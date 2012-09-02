<h1>Как добавить текст в header документа?</h1>
<div class="date">01.01.2007</div>


<pre>
{ ... }
aDoc := WordApp.Documents.Add(EmptyParam, EmptyParam);
aDoc.Sections.Item(1).Headers.Item(wdHeaderFooterPrimary).Range.Text :=
  'This is a header';
{ ... }
</pre>

<p>Взято с Delphi Knowledge Base: <a href="https://www.baltsoft.com/" target="_blank">https://www.baltsoft.com/</a></p>
