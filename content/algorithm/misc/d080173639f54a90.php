<h1>Числа Фибоначчи</h1>
<div class="date">01.01.2007</div>


<pre>
{
  Fibonacci integers are defined as:
 
  fib[n+2] = fib[n+1] + fib[n];
  fib[1] = 1;
  fib[0] = 1;
 
  Example/Beispiel: fib[4] = fib[3] + fib[2] = fib[2] + fib[1] + fib[1] + fib[0] =
                    fib[1] + fib[0] + fib[1] + fib[1] + fib[0] = 5
}
 
function  fibit(n: Integer): Integer;
var
  a, b, i, temp: Integer;
begin
  temp := 1;
  a := 1;
  b := 1;
  for i := 1 to n - 1 do
  begin
    temp := a + b;
    a := b;
    b := temp;
  end;
  Result := temp;
end;
 
function fibrec(n: Integer): Integer;
var
  temp: Integer;
begin
  temp := 0;
  if (n = 0) then temp := 1;
  if (n = 1) then temp := 1;
  if (n &gt; 1) then temp := fibrec(n - 1) + fibrec(n - 2);
  Result := temp;
end;
 
 
// Example:
procedure TForm1.Button1Click(Sender: TObject);
begin
  ShowMessage(IntToStr(fibit(10)));
  ShowMessage(IntToStr(fibrec(10)));
end;
</pre>
<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
