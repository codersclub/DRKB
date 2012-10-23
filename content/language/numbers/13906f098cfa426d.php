<h1>Bin &gt; Dec</h1>
<div class="date">01.01.2007</div>


<pre>
function BinToInt(const Value: string): Integer;

var
  i, strLen: Integer;
begin
  Result := 0;
  strLen := Length(Value);
  for i := 1 to strLen do
    if Value[i] = '1' then
      Result := Result or (1 shl (strLen - i))
    else
      Result := Result and not (1 shl (strLen - i));
end;
 
</pre>
<div class="author">Автор: Yanis</div>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
