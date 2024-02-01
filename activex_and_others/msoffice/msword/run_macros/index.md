---
Title: Пример запуска макроса в MS WinWord
Date: 01.01.2007
---


Пример запуска макроса в MS WinWord
===================================

    vvWord:= CreateOleObject('Word.Application.8');  
    vvWord.Application.Visible:=true;  
    vvWord.Documents.Open( TempFileName );  
    vvWord.ActiveDocument.SaveAs( FileName, 1 ); // as .DOC  
    vvWord.Application.Run( 'Macros Name' );  
