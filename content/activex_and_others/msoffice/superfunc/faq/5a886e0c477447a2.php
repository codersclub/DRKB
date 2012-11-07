<h1>Как напечатать документ без предварительной настройки принтера (что печатать, какое качество печати и т.д.)?</h1>
<div class="date">01.01.2007</div>

<p>Для печати без отображения диалога я использую метод PrintOut. В качестве аргумента этого метода можно указать количество копий, но можно использовать и другие параметры, которые устанавливаются в диалоге печати (см. Help по VB). Приведу только простой пример функции для печати нескольких копий.</p>
<pre class="delphi">
Function PrintOutDoc(NumCopies:integer):boolean;
begin
 PrintOutDoc:=true;
 try
  W.ActiveDocument.PrintOut(NumCopies);
 except
  PrintOutDoc:=false;
end;
</pre>
</p>

