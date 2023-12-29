---
Title: Выбор шрифта
Date: 01.01.2007
---


Выбор шрифта
============

::: {.date}
01.01.2007
:::

Выбор шрифта

Для задания шрифта ячеек электронной таблицы используем свойства и поля
объекта Font области ячеек Range. В отличие от Delphi, в Excel объект
Font имеет дополнительные параметры, но большинство полей совпадают по
смыслу и по типу данных. В Excel дополнительно символы могут
использоваться как верхний или нижний индексы, могут иметь несколько
способов подчеркивания, а цвет символов может задаваться выбором из
палитры.

Рассмотрим в деталях объект Font и его поля. Объект Font является
свойством ячейки или области ячеек Range, а доступ к нему получаем,
используя следующий оператор:
E.ActiveWorkbook.Sheets.Item[sheet].Range[range].Font, где E =
Excel.Application. Объект Font имеет несколько полей, которые влияют на
режим отображения символов ячейки. Name - наименование шрифта в формате
string. В это поле записывается имя одного из шрифтов, установленного в
системе. Bold - параметр, который может принимать значение True или
False и который влияет на толщину символов. Italic - принимает значение
True (наклонный) или False (прямой) и отвечает за наклонное написание
символов. Strikethrough - равен True, если символы перечеркнутые, или
False, если не перечеркнутые. Underline - свойство, которое определяет
стиль подчеркивания, имеет тип Integer. Когда
Underline=xlUnderlineStyleNone, символы отображаются без подчеркивания,
если Underline=xlUnderlineStyleSingle, то используется обычное
подчеркивание. Когда необходимо использовать дополнительные виды
подчеркивания, то применяем определенные константы (смотрите приложение
на домашней странице). Color - цвет символов, тип longint.

Нетрудно провести соответствие между описанием полей объекта Font ячеек
Excel и объектом Tfont Delphi. Ниже описанная функция использует это
соответствие для задания шрифта ячеек таблиц Excel из приложений Delphi.
Последним аргументом этой функции является ссылка на объект Font:Tfont,
который является стандартным типом объекта Delphi. Этот аргумент мы
используем для передачи параметров шрифта в Excel.

    Function SetFontRange(sheet:variant;range:string;
     font:Tfont):boolean;
    begin
     SetFontRange:=true;
     try
      E.ActiveWorkbook.Sheets.Item[sheet].Range[range].Font.Name:=font.Name;
      if fsBold in font.Style then E.ActiveWorkbook.Sheets.Item
        [sheet].Range[range].Font.Bold:=True
       else E.ActiveWorkbook.Sheets.Item[sheet].Range
        [range].Font.Bold:=False;
      if fsItalic in font.Style then E.ActiveWorkbook.Sheets.Item
        [sheet].Range[range].Font.Italic:=True
       else E.ActiveWorkbook.Sheets.Item[sheet].Range[range].Font.Italic:=False;
      E.ActiveWorkbook.Sheets.Item[sheet].Range[range].Font.Size:=font.Size;
      if fsStrikeOut in font.Style
       then E.ActiveWorkbook.Sheets.Item[sheet].Range
        [range].Font.Strikethrough:=True
       else E.ActiveWorkbook.Sheets.Item[sheet].Range
        [range].Font.Strikethrough:=False;
      if fsUnderline in font.Style then
       E.ActiveWorkbook.Sheets.Item[sheet].Range
        [range].Font.Underline:=xlUnderlineStyleSingle
       else E.ActiveWorkbook.Sheets.Item[sheet].Range
        [range].Font.Underline:=xlUnderlineStyleNone;
      E.ActiveWorkbook.Sheets.Item [sheet].Range
        [range].Font.Color:=font.Color;
     except
      SetFontRange:=false;
     end;
    End;

 

Так как Excel имеет больше возможностей для отображения шрифта, то для
реализации их можно использовать дополнительную функцию SetFontRangeEx.
Аргумент Superscript=True определяет написание символов как верхний
индекс. Subscript=True отображает символы как нижний индекс. Цвет
символов может определяться не только полем Color объекта Font, но и
полем ColorIndex того же объекта. ColorIndex может принимать следующие
значения: -4105 - соответствует автоматическому выбору цвета; от 1 до 56
- одному из заданных значений палитры цветов. Underline определяет стиль
подчеркивания (integer) и может принимать одно из пяти значений
(смотрите исходный текст на домашней странице).

     
    Function SetFontRangeEx(sheet:variant;range:string;
      underlinestyle,colorindex:integer;superscript,subscript:boolean):boolean;
    begin
     SetFontRangeEx:=true;
     try
      E.ActiveWorkbook.Sheets.Item[sheet].Range[range].Font.Superscript:=superscript;
      E.ActiveWorkbook.Sheets.Item[sheet].Range[range].Font.Subscript:=subscript;
      E.ActiveWorkbook.Sheets.Item[sheet].Range[range].Font.ColorIndex:=colorindex;
      E.ActiveWorkbook.Sheets.Item[sheet].Range[range].Font.Underline:=underlinestyle;
     except
      SetFontRangeEx:=false;
     end;
    End;
