---
Title: Алгоритм переноса русского текста по слогам
Date: 01.01.2007
Author: Alex Gorbunov, acdc@media-press.donetsk.ua
Source: Delphi and Windows API Tips'n'Tricks <http://www.chat.ru/~olmal>
---


Алгоритм переноса русского текста по слогам
===========================================

```delphi
interface

uses
  Windows, Classes, SysUtils;

function SetHyph(pc: PChar; MaxSize: Integer): PChar;
function SetHyphString(s: string): string;
function MayBeHyph(p: PChar; pos: Integer): Boolean;

implementation

type
  TSymbol = (st_Empty, st_NoDefined, st_Glas, st_Sogl, st_Spec);
  TSymbAR = array [0..1000] of TSymbol;
  PSymbAr = ^TSymbAr;

const
  HypSymb = #$1F;

  Spaces = [' ', ',', ';', ':', '.', '?', '!', '/', #10, #13];

  GlasCHAR = ['Й', 'й', 'У', 'у', 'Е', 'е', 'Ю', 'ю', 'А', 'а', 'О', 'о', 'Э', 'э', 'Я', 'я', 'И', 'и',
             { english }
              'e', 'E', 'u', 'U', 'i', 'I', 'o', 'O', 'a', 'A', 'j', 'J'];

  SoglChar = ['Г', 'г', 'Ц', 'ц', 'К', 'к', 'Н', 'н', 'Ш', 'ш', 'щ', 'Щ',
              'З', 'з', 'Х', 'х', 'Ф', 'ф', 'В', 'в', 'П', 'п', 'Р', 'р',
              'Л', 'л', 'Д', 'д', 'Ж', 'ж', 'Ч', 'ч', 'С', 'с', 'М', 'м',
              'т', 'T', 'б', 'Б',
              { english }
              'q', 'Q', 'w', 'W', 'r', 'R', 't', 'T', 'y', 'Y', 'p', 'P', 's', 'S',
              'd', 'D', 'f', 'F', 'g', 'G', 'h', 'H', 'k', 'K', 'l', 'L', 'z', 'Z',
              'x', 'X', 'c', 'C', 'v', 'V', 'b', 'B', 'n', 'N', 'm', 'M'];

  SpecSign = ['Ы', 'ы', 'Ь', 'ь', 'Ъ', 'ъ'];

function isSogl(c: Char): Boolean;
begin
  Result := c in SoglChar;
end;

function isGlas(c: Char): Boolean;
begin
  Result := c in GlasChar;
end;

function isSpecSign(c: Char): Boolean;
begin
  Result := c in SpecSign;
end;

function GetSymbType(c: Char): TSymbol;
begin
  if isSogl(c) then
    Result := st_Sogl
  else if isGlas(c) then
    Result := st_Glas
  else if isSpecSign(c) then
    Result := st_Spec
  else
    Result := st_NoDefined;
end;

function isSlogMore(c: pSymbAr; start, len: Integer): Boolean;
var
  i: Integer;
  glFlag: Boolean;
begin
  glFlag := False;
  Result := False;
  for i := Start to Len-1 do
  begin
    if c^[i] = st_NoDefined then
      Exit;
    if (c^[i] = st_Glas) and ((c^[i+1] <> st_Nodefined) or (i <> Start)) then
    begin
      Result := True;
      Exit;
    end;
  end;
end;

{ расставлялка переносов }
function SetHyph(pc: PChar; MaxSize: Integer): PChar;
var
  HypBuff: Pointer;
  h: PSymbAr;
  i: Integer;
  len: Integer;
  Cur: Integer;  { Текущая позиция в результирующем массиве}
  cw : Integer;  { Номер буквы в слове}
  Lock: Integer; { счетчик блокировок}
begin
  Cur := 0;
  len := StrLen(pc);
  if (MaxSize = 0) or (Len = 0) then
  begin
    Result := nil;
    Exit;
  end;

  GetMem(HypBuff, MaxSize);
  GetMem(h, Len+1);
  { заполнение массива типов символов}
  for i := 0 to len-1 do
    h^[i] := GetSymbType(pc[i]);
  { собственно расстановка переносов}
  cw := 0;
  Lock := 0;
  for i := 0 to Len-1 do
  begin
    PChar(HypBuff)[cur] := PChar(pc)[i];
    Inc(Cur);

    if i >= Len-2 then Continue;
    if h^[i] = st_NoDefined then
    begin
      cw := 0;
      Continue;
    end
    else
      Inc(cw);
    if Lock <> 0 then
    begin
      Dec(Lock);
      Continue;
    end;
    if cw <= 1 then Continue;
    if not (isSlogMore(h, i+1, len)) then Continue;

    if (h^[i] = st_Sogl) and (h^[i-1] = st_Glas) and (h^[i+1] = st_Sogl) and (h^[i+2] <> st_Spec) then
    begin
      PChar(HypBuff)[cur] := HypSymb;
      Inc(Cur);
      Lock := 1;
    end;

    if (h^[i] = st_Glas) and (h^[i-1] = st_Sogl) and (h^[i+1] = st_Sogl) and (h^[i+2] = st_Glas) then
    begin
      PChar(HypBuff)[cur] := HypSymb;
      Inc(Cur);
      Lock := 1;
    end;

    if (h^[i] = st_Glas) and (h^[i-1] = st_Sogl) and (h^[i+1] = st_Glas) and (h^[i+2] = st_Sogl) then
    begin
      PChar(HypBuff)[cur] := HypSymb;
      Inc(Cur);
      Lock := 1;
    end;

    if (h^[i] = st_Spec) then
    begin
      PChar(HypBuff)[cur] := HypSymb;
      Inc(Cur);
      Lock := 1;
    end;
  end;
  {}
  FreeMem(h, Len+1);
  PChar(HypBuff)[cur] := #0;
  Result := HypBuff;
end;

function Red_GlasMore(p: PChar; pos: Integer): Boolean;
begin
  Result := False;
  while p[pos] <> #0 do
  begin
    if p[pos] in Spaces then
      Exit;
    if isGlas(p[pos]) then
    begin
      Result := True;
      Exit;
    end;
    Inc(pos);
  end;
end;

function Red_SlogMore(p: PChar; pos: Integer): Boolean;
var
  BeSogl, BeGlas: Boolean;
begin
  BeSogl := False;
  BeGlas := False;
  while p[pos] <> #0 do
  begin
    if p[pos] in Spaces then Break;
    if not BeGlas then
      BeGlas := isGlas(p[pos]);
    if not BeSogl then
      BeSogl := isSogl(p[pos]);
    Inc(pos);
  end;
  Result := BeGlas and BeSogl;
end;

function MayBeHyph(p: PChar; pos: Integer): Boolean;
var
  i: Integer;
  len: Integer;
begin
  i := pos;
  Len := StrLen(p);
  Result := (Len > 3) and (i > 2) and (i < Len-2)
    and (not (p[i] in Spaces)) and (not (p[i+1] in Spaces)) and (not (p[i-1] in Spaces))
    and (
       (isSogl(p[i]) and isGlas(p[i-1]) and isSogl(p[i+1]) and Red_SlogMore(p, i+1))
    or ((isGlas(p[i])) and (isSogl(p[i-1])) and (isSogl(p[i+1])) and (isGlas(p[i+2])))
    or ((isGlas(p[i])) and (isSogl(p[i-1])) and (isGlas(p[i+1])) and Red_SlogMore(p, i+1))
    or isSpecSign(p[i])
    );
end;

function SetHyphString(s: string): string;
var
  Res: PChar;
begin
  Res := SetHyph(PChar(S), Length(S) * 2);
  Result := Res;
  FreeMem(Res, Length(S) * 2);
end;

end.
```

Alex Gorbunov  
acdc@media-press.donetsk.ua  
www.media-press.donetsk.ua  
(2:465/85.4)

Взято из FAQ:  
Delphi and Windows API Tips\'n\'Tricks  
<http://www.chat.ru/~olmal>  
olmal@mail.ru
