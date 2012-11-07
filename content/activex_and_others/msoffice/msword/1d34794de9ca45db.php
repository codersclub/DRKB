<h1>Как работать с WordBasic?</h1>
<div class="date">01.01.2007</div>


<pre class="delphi">
uses OleAuto;
 
var
  MSWord: Variant;
 
begin
  MsWord := CreateOleObject('Word.Basic');
  MsWord.FileNewDefault;
  MsWord.TogglePortrait;
end;
</pre>

<p>Взято с Delphi Knowledge Base: <a href="https://www.baltsoft.com/" target="_blank">https://www.baltsoft.com/</a></p>
