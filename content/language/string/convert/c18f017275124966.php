<h1>Hex &gt; String</h1>
<div class="date">01.01.2007</div>


<pre>
procedure TForm1.Button1Click(Sender: TObject);
const Source: string = '4D 5A';
var S: string;
  t: Integer;
begin
  with TStringList.Create do
  try
    Text := StringReplace(Source, #32, #13#10, [rfReplaceAll]);
    S := '';
    for t := 0 to Count - 1 do
      S := S + Chr(StrToInt('$' + Strings[t]));
    ShowMessage(S);
  finally
    Free;
  end;
end;
</pre>


<p class="author">Автор: Song</p>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

<p>
