<h1>Array &gt; String</h1>
<div class="date">01.01.2007</div>


<pre>
function ArrayToStr(str: TStrings; r: string): string;
var
  i: integer;
begin
  Result:='';
  if str = nil then
    Exit;
  for i := 0 to Str.Count-1 do
    Result := Result + Str.Strings[i] + r;
end;
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
</p>
