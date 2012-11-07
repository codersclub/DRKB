<h1>Настройки принтера</h1>
<div class="date">01.01.2007</div>


<p>Ниже приведены некоторые участки кода, позволяющие изменять настройки принтера.Тот код, который позволяет менять установки, позволяет также вам узнать принцип управления настройками.Смотри документацию по структурам ExtDeviceMode, TDEVMODE и escape функциям принтера GETSETPAPERBINS и GetDeviceCaps().</p>

<p>Один из путей изменения установок принтера перед печатью документа - изменение devicemode(режим устройства)принтера.</p>

<pre>
var
  Device: array[0..255] of char;
  Driver: array[0..255] of char;
  Port: array[0..255] of char;
  hDMode: THandle;
  PDMode: PDEVMODE;
begin
 
  Printer.PrinterIndex := Printer.PrinterIndex;
  Printer.GetPrinter(Device, Driver, Port, hDMode);
  if hDMode &lt;&gt; 0 then
    begin
      pDMode := GlobalLock(hDMode);
      if pDMode &lt;&gt; nil then
        begin
          pDMode^.dmFields := pDMode^.dmFields or DM_COPIES;
          pDMode^.dmCopies := 5;
          GlobalUnlock(hDMode);
        end;
      GlobalFree(hDMode);
    end;
  Printer.PrinterIndex := Printer.PrinterIndex;
  Printer.BeginDoc;
  Printer.Canvas.TextOut(100, 100, 'Тест 1');
  Printer.EndDoc;
</pre>

<p>  Другой путь - изменение TPrinter.Это позволит изменять установки во время работы.Вы можете изменять настройки МЕЖДУ страницами.</p>

<p>  Чтобы сделать это:</p>

<p>  Прежде чем поступит команда startpage()(см.модуль printers.pas в каталоге Source\VCL), вы можете передать принтеру следующий код:</p>

<p>    DevMode.dmPaperSize := DMPAPER_LEGAL</p>
<p>{сброс настроек}</p>

<p>  Windows.ResetDc(dc, Devmode^);</p>

<p>  Это также сбросит настройки, связанные с размером бумаги.Вы можете обратиться к описанию DEVMODE, чтобы узнать все доступные размеры бумаги.</p>

<p>  Но это решение потребует перекомпиляции исходного кода vcl с добавлением пути к новому модулю(tools..options..library...libaray).Если вы все - таки на это решились, не забудьте после этого перезагрузить Delphi и помните, что после этого ваш исходный код становится несовместимым со стандартной версией Delphi.</p>

<p>  Маленькое замечание...</p>

<p>  При замене исходного принтера на другой помните, что размеры шрифтов не всегда могут правильно масштабироваться.Чтобы гарантировать соответствующий масштаб, устанавите свойство шрифта PixelsPerInch.</p>
<pre>
  uses Printers;
 
var
 
  MyFile: TextFile;
begin
 
  AssignPrn(MyFile);
  Rewrite(MyFile);
 
  Printer.Canvas.Font.Name := 'Courier New';
  Printer.Canvas.Font.Style := [fsBold];
  Printer.Canvas.Font.PixelsPerInch :=
    GetDeviceCaps(Printer.Canvas.Handle, LOGPIXELSY);
 
  Writeln(MyFile, 'Печатаем этот текст');
 
  System.CloseFile(MyFile);
end;
</pre>


<pre>
uses Printers;
 
begin
 
  Printer.BeginDoc;
  Printer.Canvas.Font.Name := 'Courier New';
  Printer.Canvas.Font.Style := [fsBold];
 
  Printer.Canvas.Font.PixelsPerInch :=
    GetDeviceCaps(Printer.Canvas.Handle, LOGPIXELSY);
 
  Printer.Canvas.Textout(10, 10, 'Печатаем этот текст');
 
  Printer.EndDoc;
end;
</pre>

<p>Взято из Советов по Delphi от <a href="mailto:mailto:webmaster@webinspector.com" target="_blank">Валентина Озерова</a></p>
<p>Сборник Kuliba</p>

