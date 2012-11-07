<h1>Как поменять ссылку в тексте?</h1>
<div class="date">01.01.2007</div>


<pre class="delphi">
{ ... }
Doc := Word.ActiveDocument;
for x := 1 to Doc.Hyperlinks.Count do
begin
  Doc.Hyperlinks.Item(x).Address;
end;
{ ... }
</pre>

<p>Взято с Delphi Knowledge Base: <a href="https://www.baltsoft.com/" target="_blank">https://www.baltsoft.com/</a></p>
