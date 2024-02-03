---
Title: Как распечатать веб-страничку при помощи HTML-контрола?
Date: 01.01.2007
---


Как распечатать веб-страничку при помощи HTML-контрола?
=======================================================

::: {.date}
01.01.2007
:::

Можно использовать два метода HTML контрола: AutoPrint или PrintPage.

Пример использования AutoPrint:

--------------------------------------------------------------------------------

Как распечатать WEB страничку при помощи HTML контрола

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

Взято из <https://forum.sources.ru>
