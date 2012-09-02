<h1>Как распечатать веб-страничку при помощи HTML-контрола?</h1>
<div class="date">01.01.2007</div>


<p>Можно использовать два метода HTML контрола: AutoPrint или PrintPage.</p>
<p>Пример использования AutoPrint: </p>
<p>--------------------------------------------------------------------------------</p>
<p>Как распечатать WEB страничку при помощи HTML контрола</p>
<p>Можно использовать два метода HTML контрола: AutoPrint или PrintPage.</p>
<p>Пример использования AutoPrint: </p>
<pre>
uses Printers; 
 
procedure TForm1.Button1Click(Sender: TObject); 
var 
  OldCur: TCursor; 
begin 
  OldCur := Screen.Cursor; 
  with Printer do begin 
    BeginDoc; 
    HTML1.AutoPrint(handle); 
    Title := HTML1.URL; 
    EndDoc; 
  end; 
  Screen.Cursor := OldCur; 
end; 
</pre>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

