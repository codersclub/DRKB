<h1>Как проверить правильность International Bank Account Number?</h1>
<div class="date">01.01.2007</div>


<pre>
// IBAN = International Bank Account Number 
// Example : CH10002300A1023502601 
 
function ChangeAlpha(input: string): string; 
  // A -&gt; 10, B -&gt; 11, C -&gt; 12 ... 
var  
  a: Char; 
begin 
  Result := input; 
  for a := 'A' to 'Z' do 
  begin 
    Result := StringReplace(Result, a, IntToStr(Ord(a) - 55), [rfReplaceAll]); 
  end; 
end; 
 
function CalculateDigits(iban: string): Integer; 
var  
  v, l: Integer; 
  alpha: string; 
  number: Longint; 
  rest: Integer; 
begin 
  iban := UpperCase(iban); 
  if Pos('IBAN', iban) &gt; 0 then 
    Delete(iban, Pos('IBAN', iban), 4); 
  iban := iban + Copy(iban, 1, 4); 
  Delete(iban, 1, 4); 
  iban := ChangeAlpha(iban); 
  v := 1; 
  l := 9; 
  rest := 0; 
  alpha := ''; 
  try 
    while v &lt;= Length(iban) do 
    begin 
      if l &gt; Length(iban) then 
        l := Length(iban); 
      alpha := alpha + Copy(iban, v, l); 
      number := StrToInt(alpha); 
      rest := number mod 97; 
      v := v + l; 
      alpha := IntToStr(rest); 
      l := 9 - Length(alpha); 
    end; 
  except 
    rest := 0; 
  end; 
  Result := rest; 
end; 
 
function CheckIBAN(iban: string): Boolean; 
begin 
  iban := StringReplace(iban, ' ', '', [rfReplaceAll]); 
  if CalculateDigits(iban) = 1 then 
    Result := True 
  else 
    Result := False; 
end; 
</pre>
<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
