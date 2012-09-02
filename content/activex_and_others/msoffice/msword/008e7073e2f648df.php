<h1>Как добавить текст в footer документа?</h1>
<div class="date">01.01.2007</div>



<p>Footer:</p>
<pre>
{ ... }
aDoc := WordApp.Documents.Add(EmptyParam, EmptyParam);
aDoc.Sections.Item(1).Footers.Item(wdHeaderFooterPrimary).Range.Text :=
  'This is a footer';
{ ... }
</pre>

<p>Взято с Delphi Knowledge Base: <a href="https://www.baltsoft.com/" target="_blank">https://www.baltsoft.com/</a></p>
