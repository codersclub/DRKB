<h1>Импорт большого CSV файла</h1>
<div class="date">01.01.2007</div>


<pre>
var s: string; f: TextFile;
  AssignFile(f, 'D:\\INPUT.TXT');
    Reset(f);
    while not EOF(f) do
      begin
        ReadLn(s, f);
        ShowMessage(GetField(s, 1)); {The first field\}
        ShowMessage(GetField(s, 6)); {The sixth field\}
        ShowMessage(GetField(s, 25)); {will return '' if no 25 column...\}
      end;
    CloseFile(f);
 
{ ==== This function will return a field from a delimited string. ==== \}
 
function GetField(InpString: string; fieldpos: Integer): string;
var
  c: Char;
  curpos, i: Integer;
begin
  curpos := 1;
  for i := 1 to fieldpos do
    begin
      result := ''; if curpos &gt; Length(InpString) then Break;
      repeat
        c := InpString[curpos]; Inc(curpos, 1);
        if (c = '"') or (c = #13) or (c = #10) then c := ' ';
        if c &lt;&gt; ',' then result := result + c;
      until (c = ',') or (curpos &gt; Length(InpString))
    end;
  if (curpos &gt; Length(InpString)) and (i &lt; fieldpos) then result := '';
  result := Trim(result);
end;
 
{ ==== This function will trim a string removing spaces etc. ==== \}
 
function Trim(inp_str: string): string;
var
  i: Integer;
begin
  for i := 1 to Length(inp_str) do
    if inp_str[i] &lt;&gt; ' ' then Break;
  if i &gt; 1 then Delete(inp_str, 1, i - 1);
  for i := Length(inp_str) downto 1 do
    if inp_str[i] &lt;&gt; ' ' then Break;
  if i &lt; Length(inp_str) then Delete(inp_str, i + 1, Length(inp_str));
  result := inp_str;
  if result = ' ' then result := '';
end;
</pre>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>


