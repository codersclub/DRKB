<h1>Подсчет слов в TRichEdit</h1>
<div class="date">01.01.2007</div>


<pre>
function GetWord: boolean;
var
  s: string; {предположим что слова не содержат&gt;255 символов}
  c: char;
begin
  result := false;
  s := ' ';
  while not eof(f) do
  begin
    read(f, c);
    if not (c in ['a'..'z', 'A'..'Z' {,... и т.д, и т.п.}]) then
      break;
    s := s + c;
  end;
  result := (s &lt;&gt; ' ');
end;
 
procedure GetWordCount(TextFile: string);
begin
  Count := 0;
  assignfile(f, TextFile);
  reset(f);
  while not eof(f) do
    if GetWord then
      inc(Count);
  closefile(f);
end;
 
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
