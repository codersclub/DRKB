<h1>Пример запуска макроса в MS WinWord</h1>
<div class="date">01.01.2007</div>


<pre>
vvWord:= CreateOleObject('Word.Application.8');  
vvWord.Application.Visible:=true;  
vvWord.Documents.Open( TempFileName );  
vvWord.ActiveDocument.SaveAs( FileName, 1 ); // as .DOC  
vvWord.Application.Run( 'Macros Name' );  
</pre>

