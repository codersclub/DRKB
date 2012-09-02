<h1>Небольшой модуль для работы со строками</h1>
<div class="date">01.01.2007</div>


<pre>
{ **** UBPFD *********** by delphibase.endimus.com ****
&gt;&gt; Небольшой модуль для работы со строками
 
function CompMask(S, Mask: string):string; //выбор строки по маске
// удаление из строки count символов начиная с posit
function deleteStr(s:string;posit,count:integer):string;
//Удаление из строки s сначала first и с конца last символов
function deleteFaskaStr(s:string; first,last:integer):string;
Запись в стринлист strg всех вхождений по маске mask из строки source
procedure getStrings(var strg: TStringList; mask,source: string);
 
Зависимости: classes,sysutils
Автор:       SuMaga, sumaga@mail.ru, ICQ:721602488, Махачкала
Copyright:   Сам состряпал :)
Дата:        24 января 2003 г.
***************************************************** }
 
unit StrMask;
interface
uses classes, sysutils;
function CompMask(S, Mask: string): string;
function deleteStr(s: string; posit, count: integer): string;
function deleteFaskaStr(s: string; first, last: integer): string;
procedure getStrings(var strg: TStringList; mask, source: string);
 
implementation
 
type
  TmaskObj = class
    constructor open;
  public
    Maschr: tstringlist;
    Masposish: TStringList;
    destructor close;
  end;
 
procedure getStrings(var strg: TStringList; mask, source: string);
var
  s, s2: string;
begin
  s2 := source;
  s := CompMask(s2, mask);
  while s &lt;&gt; '' do
  begin
    strg.Add(s);
    s2 := StringReplace(s2, s, '', []);
    s := CompMask(s2, mask);
    if pos(s, s2) = 0 then
      break;
  end;
 
end;
 
function eraseMask(inpstr: TStrings): TStrings;
var
  i: integer;
  e: boolean;
begin
  e := false;
  for i := 0 to inpstr.Count - 1 do
    if (i &lt;&gt; inpstr.Count - 1) and (i &lt; inpstr.Count - 1) then
      if ((inpstr[i] = '`') and (inpstr[i + 1] = '|')) or
        ((inpstr[i] = '|') and (inpstr[i + 1] = '`')) or
        ((inpstr[i] = '`') and (inpstr[i + 1] = '`')) then
      begin
        e := true;
      end;
 
  if (e = false) or (i &lt;= inpstr.Count - 1) then
  begin
    Result := inpstr;
    exit;
  end;
 
  for i := 0 to inpstr.Count - 1 do
    if (i &lt;&gt; inpstr.Count - 1) and (i &lt; inpstr.Count - 1) then
      if ((inpstr[i] = '`') and (inpstr[i + 1] = '|')) or
        ((inpstr[i] = '`') and (inpstr[i + 1] = '`')) or
        ((inpstr[i] = '|') and (inpstr[i + 1] = '`')) then
      begin
        inpstr.Delete(i + 1);
        inpstr[i] := '`';
      end;
  Result := eraseMask(inpstr);
end;
 
{
`&lt;---- Эквивалентна-----&gt;*
|&lt;---- Эквивалентна-----&gt;?
}
 
function SplitMask(mask: string; MaskList: TStringList): TStringList;
var
  i, j, k: integer;
  s1: string;
  mch: TmaskObj;
begin
  mch := TmaskObj.open;
  for i := 1 to length(Mask) do
  begin
    if Mask[i] = '`' then
    begin
      mch.Maschr.Add('`');
      mch.Masposish.Add(inttostr(i))
    end;
 
    if Mask[i] = '|' then
    begin
      mch.Maschr.Add('|');
      mch.Masposish.Add(inttostr(i))
    end;
  end;
  k := 0;
  for i := 0 to mch.Maschr.Count - 1 do
  begin
    j := strtoint(mch.Masposish.Strings[i]) - k;
    if j - 1 &lt;&gt; 0 then
      s1 := copy(Mask, 1, j - 1)
    else
      s1 := '';
    delete(Mask, 1, j);
    k := length(s1) + 1 + k;
    if (s1 &lt;&gt; mch.Maschr.Strings[i]) and (length(s1) &lt;&gt; 0) then
      MaskList.Add(s1);
    MaskList.Add(mch.Maschr.Strings[i]);
  end;
  if Mask &lt;&gt; '' then
    MaskList.Add(Mask);
  mch.close;
  Result := TStringList(eraseMask(MaskList));
end;
 
function deleteStr(s: string; posit, count: integer): string;
begin
  Delete(s, posit, count);
  Result := s;
end;
 
function deleteFaskaStr(s: string; first, last: integer): string;
begin
  result := deleteStr(s, 1, first);
  result := deleteStr(Result, length(Result) - last + 1, length(Result) -
    (length(Result) - last));
end;
 
function CompMask(S, Mask: string): string;
var
  i, j, k, y: integer;
  s1, s2, s3, s4, s5: string;
  MaskList: TStringList;
  PrPos: integer;
var
  fm: boolean;
label
  1, 2, 3;
 
begin
  2:
  if length(s) = 0 then
    exit;
  if length(Mask) = 0 then
    exit;
  if length(s) &lt; length(Mask) then
    exit;
  //if Assigned(MaskList) then
  begin
    MaskList := TStringList.Create;
    MaskList := SplitMask(Mask, MaskList);
  end;
  PrPos := 0;
  s4 := s;
  fm := false;
  s3 := '';
  i := 0;
  result := '';
  if MaskList.Count - 1 = 0 then
  begin
    if (MaskList[0] = '`') then
    begin
 
      s3 := s;
      fm := true;
    end;
    if (MaskList[0] = '|') then
    begin
      s3 := s[1];
      fm := true;
      result := s3;
      exit;
    end;
    if (MaskList[0] &lt;&gt; '`') and (MaskList[0] &lt;&gt; '|') then
    begin
      if pos(MaskList[0], s) = 0 then
        exit;
      s3 := copy(s, pos(MaskList[0], s), length(MaskList[0]));
      fm := true;
    end;
    i := MaskList.Count + 1;
  end;
 
  //Начало цикла
  while i &lt;= MaskList.Count - 1 do
  begin
    if (MaskList[i] = '`') and (PrPos = 0) and (i + 1 &lt;= MaskList.Count - 1)
      then
    begin
      if pos(MaskList[i + 1], s) = 0 then
        goto 2;
      j := pos(MaskList[i + 1], s) + length(MaskList[i + 1]) - 1;
      s3 := copy(s, 1, j);
      delete(s, 1, j);
      fm := true;
      PrPos := j;
      i := i + 1;
      goto 1;
    end;
 
    if (MaskList[i] = '|') and (PrPos = 0) and (i + 1 &lt;= MaskList.Count - 1)
      then
    begin
      k := i;
      y := 0;
      if i + 1 &lt;= MaskList.Count - 1 then
        while (MaskList[k] = '|') do
        begin
          k := k + 1;
          y := y + 1;
          if k &gt;= MaskList.Count - 1 then
            break;
        end;
      if pos(MaskList[k], s) = 0 then
        goto 2;
      j := pos(MaskList[k], s);
      s3 := copy(s, j - y, length(MaskList[k]) + y);
      delete(s, 1, j + length(MaskList[k]) - 1);
      fm := true;
      PrPos := j - 1;
      i := k;
      goto 1;
    end;
    if (PrPos = 0) and (MaskList[i] &lt;&gt; '|') and (MaskList[i] &lt;&gt; '`') then
    begin
      if pos(MaskList[i], s) = 0 then
        break;
      j := pos(MaskList[i], s);
      s3 := copy(s, j, length(MaskList[i]));
      delete(s, 1, j + length(MaskList[i]) - 1);
      fm := true;
      PrPos := length(MaskList[i]);
      goto 1;
    end;
 
    fm := false;
    if (PrPos &lt;&gt; 0) and (i &lt; MaskList.Count - 1) then
    begin
      if (MaskList[i] = '`') then
      begin
        if pos(MaskList[i + 1], s) = 0 then
          goto 2;
        j := pos(MaskList[i + 1], s);
        s3 := s3 + copy(s, 1, j + length(MaskList[i + 1]) - 1);
        fm := true;
 
        delete(s, 1, j + length(MaskList[i + 1]) - 1);
 
        PrPos := j + length(MaskList[i + 1]);
        i := i + 1;
        goto 1;
 
      end;
      if (MaskList[i] = '|') then
      begin
        if i + 1 &lt;= MaskList.Count - 1 then
          if MaskList[i + 1] &lt;&gt; '|' then
          begin
            if pos(MaskList[i + 1], s) &gt; 2 then
            begin
              //break;
              goto 2;
            end;
            s3 := s3 + copy(s, 1, length(MaskList[i + 1]) + 1);
            delete(s, 1, length(MaskList[i + 1]) + 1);
            fm := true;
            i := i + 1;
            goto 1;
          end;
        s3 := s3 + copy(s, 1, 1);
        delete(s, 1, 1);
        fm := true;
        PrPos := 1;
      end;
 
      if (MaskList[i] &lt;&gt; '`') and (MaskList[i] &lt;&gt; '|') then
      begin
        if pos(MaskList[i], s) = 0 then
          goto 2;
        j := pos(MaskList[i], s);
        s3 := s3 + copy(s, j, length(MaskList[i]));
        delete(s, 1, j + length(MaskList[i]) - 1);
        fm := true;
        PrPos := length(MaskList[i]);
        fm := true
      end;
    end;
 
    if (PrPos &lt;&gt; 0) and (i = MaskList.Count - 1) then
    begin
      if (MaskList[i] = '`') then
      begin
        s3 := s3 + s;
        s := '';
        fm := true;
        PrPos := j;
      end;
      if (MaskList[i] = '|') then
      begin
        s3 := s3 + copy(s, 1, 1);
        delete(s, 1, 1);
        fm := true;
        PrPos := 1;
      end;
      if (MaskList[i] &lt;&gt; '`') and (MaskList[i] &lt;&gt; '|') then
      begin
        if pos(MaskList[i], s) &lt;&gt; 0 then
          j := pos(MaskList[i], s) + length(MaskList[i]) - 1
        else
          goto 2;
        s3 := s3 + copy(s, 1, j);
        delete(s, 1, j);
        fm := true;
        PrPos := j + length(s3);
      end;
    end;
    1: inc(i);
  end;
  s5 := s3;
  if s3 &lt;&gt; '' then
    for i := 0 to MaskList.Count - 1 do
      if (MaskList[i] &lt;&gt; '`') and (MaskList[i] &lt;&gt; '|') then
      begin
        if pos(MaskList[i], s3) = 0 then
          goto 2;
        s3 := StringReplace(s3, MaskList[i], '', []);
      end;
 
  s3 := s5;
  MaskList.Free;
 
  if fm then
  begin
    result := s3;
  end
    {
    {result:='';
    else
    if length(s)&gt;=length(Mask) then
    result:=CompMask(s,Mask)
    else Result:='';}
end;
 
destructor TmaskObj.close;
begin
  Maschr.free;
  Masposish.free;
end;
 
constructor TmaskObj.open;
begin
  Maschr := TStringList.Create;
  Masposish := TStringList.Create;
end;
end.
Пример использования: 
 
s := 'asd r';
s := CompMask(s, 'd |');
//в результате s='d r';
</pre>

