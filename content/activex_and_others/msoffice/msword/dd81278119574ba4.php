<h1>Как заменить значение переменных для текста MS Word?</h1>
<div class="date">01.01.2007</div>


<pre>
uses
  Office97; {or Office2000, OfficeXP, Office_TLB}
 
var
  VDoc, PropName, DocName: OleVariant;
  VDoc := Word.ActiveDocument;
  { ... }
 
{ Set a document property }
PropName := 'MyOpinionOfThisDocument';
VDoc.CustomDocumentProperties.Add(PropName, False, msoPropertyTypeString,
  'Utter drivel', EmptyParam);
{ Read a document property }
Caption := VDoc.CustomDocumentProperties[PropName].Value;
{ ... }
</pre>
<p>Взято с Delphi Knowledge Base: <a href="https://www.baltsoft.com/" target="_blank">https://www.baltsoft.com/</a></p>


