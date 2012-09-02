<h1>Использование PHP-like операций с массивами</h1>
<div class="date">01.01.2007</div>



<pre>
//Some Array-functions like in PHP.
 
type
 
  ArrOfStr = array of string;
 
implementation
 
function explode(sPart, sInput: string): ArrOfStr;
begin
  while Pos(sPart, sInput) &lt;&gt; 0 do 
  begin
    SetLength(Result, Length(Result) + 1);
    Result[Length(Result) - 1] := Copy(sInput, 0,Pos(sPart, sInput) - 1);
    Delete(sInput, 1,Pos(sPart, sInput));
  end;
  SetLength(Result, Length(Result) + 1);
  Result[Length(Result) - 1] := sInput;
end;
 
function implode(sPart: string; arrInp: ArrOfStr): string;
var 
  i: Integer;
begin
  if Length(arrInp) &lt;= 1 then Result := arrInp[0]
  else 
  begin
    for i := 0 to Length(arrInp) - 2 do Result := Result + arrInp[i] + sPart;
    Result := Result + arrInp[Length(arrInp) - 1];
  end;
end;
 
procedure sort(arrInp: ArrOfStr);
var 
  slTmp: TStringList; 
  i: Integer;
begin
  slTmp := TStringList.Create;
  for i := 0 to Length(arrInp) - 1 do slTmp.Add(arrInp[i]);
  slTmp.Sort;
  for i := 0 to slTmp.Count - 1 do arrInp[i] := slTmp[i];
  slTmp.Free;
end;
 
procedure rsort(arrInp: ArrOfStr);
var 
  slTmp: TStringList; 
  i: Integer;
begin
  slTmp := TStringList.Create;
  for i := 0 to Length(arrInp) - 1 do slTmp.Add(arrInp[i]);
  slTmp.Sort;
  for i := 0 to slTmp.Count - 1 do arrInp[slTmp.Count - 1 - i] := slTmp[i];
  slTmp.Free;
end;
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
