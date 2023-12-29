---
Title: TIF -> PDF
Author: Morten Ravn-Jonsen
Date: 01.01.2007
---


TIF -> PDF
==========

::: {.date}
01.01.2007
:::

Автор: Morten Ravn-Jonsen

Совместимость: Delphi 5.x (или выше)

Как-то раз получился TIF файл на несколько страниц и возникла
необходимость конвертации его в PDF формат. Для использования такой
возможности необходимо иметь полную версию Adobe Acrobat. Функция
тестировалась на Adobe Acrobat 4.0.

Сперва Вам необходимо импортировать элементы управления Acrobat AxtiveX.

1) Выберите Component -\> Import ActiveX Control

2) Выберите Acrobat Control for ActiveX и нажмите install

3) Выберите пакет ActiveX control для инсталяции

4) Добавьте PDFlib\_tlb в Ваш проект. Этот файл находится в директории
Borland\\Delphi5\\Imports.

Как использовать функцию

Вот пример её вызова:

if not TifToPDF(\'c:\\test.tif\', \'c:\\test.pdf\') then
Showmessage(\'Could not convert\');

Функция TifToPdf

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

Взято из <https://forum.sources.ru>
