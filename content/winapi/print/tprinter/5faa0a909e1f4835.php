<h1>Exception при попытке создать обьект класса TPrinter</h1>
<div class="date">01.01.2007</div>


<p>В создании обьекта класса TPrinter с использованием TPrinter.Create нет необходимости,</p>
<p>так как обьект класса TPrinter (называемый Printer) автоматически создается при</p>
<p>использовании модуля Printers.</p>

<p>Пример:</p>
<pre>
uses Printers;
 
procedure TForm1.Button1Click(Sender: TObject);
begin
  Printer.BeginDoc;
  Printer.Canvas.TextOut(100, 100, 'Hello World!');
  Printer.EndDoc;
end;
</pre>

<p>Взято из</p>
DELPHI VCL FAQ Перевод с английского &nbsp; &nbsp; &nbsp; 
<p>Подборку, перевод и адаптацию материала подготовил Aziz(JINX)</p>
<p>специально для <a href="https://delphi.vitpc.com/" target="_blank">Королевства Дельфи</a></p>

