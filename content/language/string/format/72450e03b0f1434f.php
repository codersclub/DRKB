<h1>Как удалить переносы из строки?</h1>
<div class="date">01.01.2007</div>


<pre>
function DeleteLineBreaks(const S: string): string;
var
  Source, SourceEnd: PChar;
begin
  Source := Pointer(S);
  SourceEnd := Source + Length(S);
  while Source &lt; SourceEnd do
  begin
    case Source^ of
      #10: Source^ := #32;
      #13: Source^ := #32;
    end;
    Inc(Source);
  end;
  Result := S;
end;
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
&nbsp;</p>
&nbsp;</p>
<hr />
<p>Можно значительно проще:</p>
<pre>
function DeleteLineBreaks(const S: string): string;

 
begin
  Result := StringReplace(S, #10#13, '',[rfReplaceAll]);
end;
</pre>
<p class="author">Автор: Vit</p>
&nbsp;</p>
&nbsp;
<p>&nbsp;</p>
