<h1>Как проверить правильность штрих-кода?</h1>
<div class="date">01.01.2007</div>


<p>Solve 1:</p>

<p>I want to publish a code for checksum calculation by modulus 10 which is used in the barcodes. I must say that this "mod10" is specifical so readf an article if you're interested.</p>

<p>This algorithm is very popular for UPC barcodes (Universal Product Code), hash code or serial number generation for applications etc...</p>

<p>The basic algorithm:</p>

<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">1.</td><td>1. &nbsp; &nbsp; &nbsp; &nbsp;add the values of the digits in the odd positions (1, 3, 5...)</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">2.</td><td>2. &nbsp; &nbsp; &nbsp; &nbsp;multiply this result by 3</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">3.</td><td>3. &nbsp; &nbsp; &nbsp; &nbsp;add the values of the digits in the even positions (2, 4, 6...)</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">4.</td><td>4. &nbsp; &nbsp; &nbsp; &nbsp;sum the results of steps 2 and 3</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">5.</td><td>5. &nbsp; &nbsp; &nbsp; &nbsp;the check digit is the smallest number which, when added to the result in step 4, produces a multiple of 10.</td></tr></table></div>
<p>Small example. Assume the source data is 08137919805</p>

<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">1.</td><td>1. &nbsp; &nbsp; &nbsp; &nbsp;0+1+7+1+8+5=22</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">2.</td><td>2. &nbsp; &nbsp; &nbsp; &nbsp;22*3=66</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">3.</td><td>3. &nbsp; &nbsp; &nbsp; &nbsp;8+3+9+9+0=29</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">4.</td><td>4. &nbsp; &nbsp; &nbsp; &nbsp;66+29=95</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">5.</td><td>5. &nbsp; &nbsp; &nbsp; &nbsp;95+??=100 where ?? is a 5 (our checksum)</td></tr></table></div>
<p>My implementation in the Pascal:</p>

<pre>
function Mod10(const Value: string): Integer;
var
  i, intOdd, intEven: Integer;
begin
  {add all odd seq numbers}
  intOdd := 0;
  i := 1;
  while (i &lt;= Length(Value)) do
  begin
    Inc(intOdd, StrToIntDef(Value[i], 0));
    Inc(i, 2);
  end;
 
  {add all even seq numbers}
  intEven := 0;
  i := 2;
  while (i &lt;= Length(Value)) do
  begin
    Inc(intEven, StrToIntDef(Value[i], 0));
    Inc(i, 2);
  end;
 
  Result := 3 * intOdd + intEven;
  {modulus by 10 to get}
  Result := Result mod 10;
  if Result &lt;&gt; 0 then
    Result := 10 - Result
end;
</pre>


<p>You can expand or optimize this algorithm for own needs.</p>

<p>For example, I modified it and now I use it for any characters (not only digits) in source value.</p>

<p>The original algorithm I used for UPC-barcode validation in the SMReport Designer and the my extended algorithm I use in the serial number generation as part of the protection schema (in the shareware projects).</p>

<hr />
<pre>
function BarCodeValid(ACode: string): boolean;
var
  I: integer;
  SumOdd, SumEven: integer;
  ADigit, AChecksumDigit: integer;
begin
  SumOdd := 0;
  SumEven := 0;
  for I := 1 to (Length(ACode) - 1) do
  begin
    ADigit := StrToIntDef(ACode[I], 0);
    if (I mod 2 = 0) then
    begin
      SumEven := SumEven + ADigit;
    end
    else
    begin
      SumOdd := SumOdd + ADigit;
    end; {if}
  end; {for}
  AChecksumDigit := StrToIntDef(ACode[Length(ACode)], 0);
  Result := ((SumOdd * 3 + SumEven + AChecksumDigit) mod 10 = 0);
end; {--BarCodeValid--}
</pre>

<p>Взято с Delphi Knowledge Base: <a href="https://www.baltsoft.com/" target="_blank">https://www.baltsoft.com/</a></p>

