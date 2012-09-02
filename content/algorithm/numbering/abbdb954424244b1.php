<h1>Конвертация римских цифр в арабские</h1>
<div class="date">01.01.2007</div>


<pre>
function RomanToDec(const Value: string): integer;
var
  i, lastValue, curValue: integer;
begin
  Result := 0;
  lastValue := 0;
  for i := Length(Value) downto 1 do
  begin
    case UpCase(Value[i]) of
      'C':
        curValue := 100;
      'D':
        curValue := 500;
      'I':
        curValue := 1;
      'L':
        curValue := 50;
      'M':
        curValue := 1000;
      'V':
        curValue := 5;
      'X':
        curValue := 10;
    else
      raise Exception.CreateFmt('Invalid character: %s', [Value[i]]);
    end;
    if curValue &lt; lastValue then
      Dec(Result, curValue)
    else
      Inc(Result, curValue);
    lastValue := curValue;
  end;
end;
</pre>
<p>Взято с Delphi Knowledge Base: <a href="https://www.baltsoft.com/" target="_blank">https://www.baltsoft.com/</a></p>

