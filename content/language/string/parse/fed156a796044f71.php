<h1>Расщепление строки с разделителями на массив строк</h1>
<div class="date">01.01.2007</div>


<pre>
{ **** UBPFD *********** by delphibase.endimus.com ****
&gt;&gt; Расщепление строки с разделителями на массив строк
 
Зависимости: System
Автор:       ALL.exe, Alexe@054.pfr.ru, ICQ:161857370, Kostroma
Copyright:   ALL.exe
Дата:        13 марта 2003 г.
***************************************************** }
 
type
  TSepArr = array of string; // массив "записей"
 
  TSepRec = record
    Rec: TSepArr; // сами "записи"
    Max: integer; // количество полученных "записей"
  end;
 
function GetSeparatorRec(const sRows: string;
  cSeparator: char = ','): TSepRec;
var
  cCol: array of integer;
  i, j: integer;
  bSTRING: boolean;
begin
  Result.Max := -1;
 
  j := 1;
  bSTRING := False;
  SetLength(cCol, j);
  cCol[0] := 0;
  for i := 1 to Length(sRows) do
  begin
    if sRows[i] = '"' then
      bSTRING := not bSTRING;
    if (sRows[i] = cSeparator) and (not bSTRING) then
    begin
      j := j + 1;
      SetLength(cCol, j);
      cCol[j - 1] := i;
    end;
  end;
  j := j + 1;
  SetLength(cCol, j);
  cCol[j - 1] := Length(sRows) + 1;
 
  Result.Max := High(cCol);
  if Result.Max &gt; 0 then
  begin
    SetLength(Result.Rec, Result.Max + 1);
    Result.Rec[0] := IntToStr(Result.Max);
    for i := 1 to Result.Max do
      Result.Rec[i] := Copy(sRows, cCol[i - 1] + 1, cCol[i] - cCol[i - 1] - 1);
  end;
 
end;
//Пример использования: 
 
var
  R: TSepRec;
begin
  R := GetSeparatorRec('123.45-ABCDEF-"A-B-C"-"0"-', '-');
 
// результат:
  R.Max = 5;
  R.Rec = ('5', '123.45', 'ABCDEF', '"A;B;C"', '"0"', '');
</pre>

