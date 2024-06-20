---
Title: Как распечатать веб-страничку при помощи HTML-контрола?
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Как распечатать веб-страничку при помощи HTML-контрола?
=======================================================

Можно использовать два метода HTML контрола: AutoPrint или PrintPage.

Пример использования AutoPrint:

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

