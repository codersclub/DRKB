<h1>TIF &gt; PDF</h1>
<div class="date">01.01.2007</div>


<div class="author">Автор: Morten Ravn-Jonsen</div>

<p>Совместимость: Delphi 5.x (или выше)</p>

<p>Как-то раз получился TIF файл на несколько страниц и возникла необходимость конвертации его в PDF формат. Для использования такой возможности необходимо иметь полную версию Adobe Acrobat. Функция тестировалась на Adobe Acrobat 4.0.</p>

<p>Сперва Вам необходимо импортировать элементы управления Acrobat AxtiveX.</p>

<p>1) Выберите Component -&gt; Import ActiveX Control</p>
<p>2) Выберите Acrobat Control for ActiveX и нажмите install</p>
<p>3) Выберите пакет ActiveX control для инсталяции</p>
<p>4) Добавьте PDFlib_tlb в Ваш проект. Этот файл находится в директории Borland\Delphi5\Imports.</p>

<p>Как использовать функцию</p>

<p>Вот пример её вызова:</p>

<p>if not TifToPDF('c:\test.tif', 'c:\test.pdf') then Showmessage('Could not convert');</p>

<p>Функция TifToPdf</p>
<pre>
function TifToPDF(TIFFilename, PDFFilename: string): boolean; 
var 
  AcroApp : variant; 
  AVDoc : variant; 
  PDDoc : variant; 
  IsSuccess : Boolean; 
begin 
  result := false; 
  if not fileexists(TIFFilename) then exit; 
 
  try 
    AcroApp := CreateOleObject('AcroExch.App'); 
    AVDoc := CreateOleObject('AcroExch.AVDoc'); 
 
    AVDoc.Open(TIFFilename, ''); 
    AVDoc := AcroApp.GetActiveDoc; 
 
    if AVDoc.IsValid then 
    begin 
      PDDoc := AVDoc.GetPDDoc; 
 
      PDDoc.SetInfo ('Title', ''); 
      PDDoc.SetInfo ('Author', ''); 
      PDDoc.SetInfo ('Subject', ''); 
      PDDoc.SetInfo ('Keywords', ''); 
 
      result := PDDoc.Save(1 or 4 or 32, PDFFilename); 
 
      PDDoc.Close; 
    end; 
 
    AVDoc.Close(True); 
    AcroApp.Exit; 
 
  finally 
    VarClear(PDDoc); 
    VarClear(AVDoc); 
    VarClear(AcroApp); 
  end; 
end; 
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

