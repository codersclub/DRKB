<h1>DBFSeek и DBFLocate</h1>
<div class="date">01.01.2007</div>


<p>Надежней и намного быстрее (если вы ищите отдельные записи) выполнить поиск строки с помощью Seek (если найдена первая запись), или выполнить Locate (индекс не требуется)</p>

<p>например</p>
<pre>
Table1.UpdateCursorPos;
if DBFSeek( Table1, xVal1 ) then {_не_ delphi-функция - смотри ниже}
begin
  if DBFLocate( Table1, 'CUSTNAME', xVal2  ) then {_не_ delphi-функция - модификация из faq}
  begin
    //... делаем все, что необходимо
  end;
end;
</pre>

<p>P.S.</p>

<p>DBFLocate - модифицированная из faq фунция fieldname</p>
<p>DBFSeek - функция, найденная методом проб и ошибок! - значительно лучшая (IMHO) чем setkey...fieldbyname1...fieldbyname2...gotokey, используемые для выражений индексов dBase за первым полем. Вы можете использовать FindKey для dBase индексов, состоящих из одного поля, вопреки мнению других участников форума.</p>

<pre>
{============================================================
{ DBFSeek
{ поиск величины с использованием индекса - простой путь
{============================================================}
 
function DBFSeek(const Table1: TTable; const sValue: string): boolean;
var
 
  sExpValue: DBIKEYEXP;
  bmPos: TBookMark;
  nOrder: integer;
 
begin
 
  Result := False;
 
  with Table1 do
  begin
    if (Active) and (Length(IndexName) &gt; 0) then
    begin
      bmPos := GetBookMark;
      DisableControls;
 
      StrPCopy(sExpValue, sValue);
      if (DbiGetRecordForKey(Handle, True, 0, strlen(sExpValue), @sExpValue, nil)
        = DBIERR_NONE) then
        Result := True
      else
        GotoBookMark(bmPos);
 
      FreeBookMark(bmPos);
      EnableControls;
    end;
  end;
end;
 
{==================================================================================
{ DBFLocate
{ поиск величины, не связанный с ключевым полем
{ замена из faq, теперь акцептует fieldname, величина может быть частичной
{================================================================================}
 
function DBFLocate(const Table1: TTable; const sFld, sValue: string): boolean;
var
 
  bmPos: TBookMark;
  bFound: boolean;
  len: integer;
begin
 
  Result := False;
  if (not StrEmpty(sValue)) and (not StrEmpty(sFld)) then
  begin
    with Table1 do
    begin
      DisableControls;
      bFound := False;
      bmPos := GetBookMark;
      len := Length(sValue);
      First;
 
      while not EOF do
      begin
        if FieldByName(sFld).AsString &lt;&gt; sValue then
          Next
        else
        begin
          Result := True;
          bFound := True;
          Break;
        end;
      end;
 
      if (not bFound) then
        GotoBookMark(bmPos);
 
      FreeBookMark(bmPos);
      EnableControls;
    end;
  end;
end;
</pre>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>

