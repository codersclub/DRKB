<h1>ANSI &gt; ASCII</h1>
<div class="date">01.01.2007</div>


<pre>
{преобразование Ansi to Ascii}
 function AnToAs(s: String) : String;
 Var i,kod : Integer;
 begin
  Result:=s;
  for i:=1 to length(s) do
  begin
   kod:=Ord(s[i]);
   if  kod=13 then Result[i]:=' ';
   if ( kod&gt;=192) and ( kod=239) then 
      Result[i]:=Chr(kod-64);
   if ( kod&gt;=240) and ( kod=255) then 
      Result[i]:=Chr(kod-16);
   if kod=168 then  Result[i]:=Chr(240);
   if kod=184 then  Result[i]:=Chr(241);
  end;
 end;
</pre>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>

