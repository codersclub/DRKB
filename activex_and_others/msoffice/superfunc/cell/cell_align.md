---
Title: Выравнивание текста в ячейке Excel
Date: 01.01.2007
---


Выравнивание текста в ячейке Excel
==================================

::: {.date}
01.01.2007
:::

Выравнивание текста в ячейке

Следующим шагом изменения режима отображения данных в ячейках книги
Excel рассмотрим выравнивание текста по горизонтали и вертикали. Для
выравнивания по горизонтали используется свойство HorizontalAlignment
объекта Range, которое применяем в функции SetHorizontalAlignment. Если
записывать в аргумент alignment:integer этой функции определенные
числовые константы, то получим различные варианты выравнивания текста по
горизонтали. Смотрите список констант и функцию, реализующую
выравнивание текста по горизонтали.

::: {style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 0px;"}
    const
     xlHAlignCenter=-4108;
     xlHAlignDistributed=-4117;
     xlHAlignJustify=-4130;
     xlHAlignLeft=-4131;
     xlHAlignRight=-4152;
     xlHAlignCenterAcrossSelection=7;
     xlHAlignFill=5;
     xlHAlignGeneral=1;
    Function SetHorizontalAlignment (sheet:variant;range:string;
      alignment:integer):boolean;
    begin
     SetHorizontalAlignment:=true;
     try
      E.ActiveWorkbook.Sheets.Item[sheet].Range
       [range].HorizontalAlignment:=alignment;
     except
      SetHorizontalAlignment:=false;
     end;
    End;

 

Для выравнивания по вертикали используем свойство VerticalAlignment
объекта Range. Смотрите набор констант и функцию SetVerticalAlignment.

::: {style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 0px;"}
    const
     xlVAlignBottom=-4107;
     xlVAlignCenter=-4108;
     xlVAlignDistributed=-4117;
     xlVAlignJustify=-4130;
     xlVAlignTop=-4160;
    Function SetVerticalAlignment (sheet:variant;range:string;
      alignment:integer):boolean;
    begin
     SetVerticalAlignment:=true;
     try
      E.ActiveWorkbook.Sheets.Item[sheet].Range
       [range].VerticalAlignment:=alignment;
     except
      SetVerticalAlignment:=false;
     end;
    End;

 
:::
:::