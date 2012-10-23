<h1>Дополненный TRegistry, умеет работать с значениями типа REG_MULTI_SZ</h1>
<div class="date">01.01.2007</div>


<pre>
unit Reg;
{$R-,T-,H+,X+}
 
interface
 
uses Registry, Classes, Windows, Consts, SysUtils;
 
type
 
  TReg = class(TRegistry)
  public
    procedure ReadStringList(const name: string; list: TStringList);
    procedure WriteStringList(const name: string; list: TStringList);
  end;
 
implementation
 
//*** TReg *********************************************************************
//------------------------------------------------------------------------------
// Запись TStringList ввиде значения типа REG_MULTI_SZ в реестр
//------------------------------------------------------------------------------
 
procedure TReg.WriteStringList(const name: string; list: TStringList);
var
 
  Buffer: Pointer;
  BufSize: DWORD;
  i, j, k: Integer;
  s: string;
  p: PChar;
begin
 
  {подготовим буфер к записи}
  BufSize := 0;
  for i := 0 to list.Count - 1 do
    inc(BufSize, Length(list[i]) + 1);
  inc(BufSize);
  GetMem(Buffer, BufSize);
  k := 0;
  p := Buffer;
  for i := 0 to list.Count - 1 do
  begin
    s := list[i];
    for j := 0 to Length(s) - 1 do
    begin
      p[k] := s[j + 1];
      inc(k);
    end;
    p[k] := chr(0);
    inc(k);
  end;
  p[k] := chr(0);
 
  {запись в реестр}
  if RegSetValueEx(CurrentKey, PChar(name), 0, REG_MULTI_SZ, Buffer,
    BufSize) &lt;&gt; ERROR_SUCCESS then
    raise ERegistryException.CreateResFmt(@SRegSetDataFailed, [name]);
end;
//------------------------------------------------------------------------------
// Чтение TStringList ввиде значения типа REG_MULTI_SZ из реестра
//------------------------------------------------------------------------------
 
procedure TReg.ReadStringList(const name: string; list: TStringList);
var
 
  BufSize,
    DataType: DWORD;
  Len, i: Integer;
  Buffer: PChar;
  s: string;
begin
 
  if list = nil then
    Exit;
  {чтение из реестра}
  Len := GetDataSize(Name);
  if Len &lt; 1 then
    Exit;
  Buffer := AllocMem(Len);
  if Buffer = nil then
    Exit;
  try
    DataType := REG_NONE;
    BufSize := Len;
    if RegQueryValueEx(CurrentKey, PChar(name), nil, @DataType, PByte(Buffer),
      @BufSize) &lt;&gt; ERROR_SUCCESS then
      raise ERegistryException.CreateResFmt(@SRegGetDataFailed, [name]);
    if DataType &lt;&gt; REG_MULTI_SZ then
      raise ERegistryException.CreateResFmt(@SInvalidRegType, [name]);
    {запись в TStringList}
    list.Clear;
    s := '';
    for i := 0 to BufSize - 2 do
    begin // BufSize-2 т.к. последние два нулевых символа
      if Buffer[i] = chr(0) then
      begin
        list.Add(s);
        s := '';
      end
      else
        s := s + Buffer[i];
    end;
  finally
    FreeMem(Buffer);
  end;
end;
 
end.
 
</pre>
<div class="author">Автор: Кондратюк Виталий </div>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
