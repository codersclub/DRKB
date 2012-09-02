<h1>Из строки в массив и наоборот</h1>
<div class="date">01.01.2007</div>



<pre>
function StrToArrays(str, r: string; out Temp: TStrings): Boolean;
var
  j: integer;
begin
  if temp &lt;&gt; nil then
  begin
    temp.Clear;
    while str &lt;&gt; '' do
    begin
      j := Pos(r,str);
      if j=0 then
        j := Length(str) + 1;
      temp.Add(Copy(Str,1,j-1));
      Delete(Str,1,j+length(r)-1);
    end;
    Result:=True;
  end
  else
    Result:=False;
end;
 
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

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
