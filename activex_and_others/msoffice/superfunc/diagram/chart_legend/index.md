---
Title: Легенда диаграммы
Date: 01.01.2007
---


Легенда диаграммы
=================

::: {.date}
01.01.2007
:::


Легенда диаграммы представляет собой подписи к той части, которая
передает информацию в графическом виде. Как и любая область, она
обладает типичными свойствами, присущими им. Есть одно отличие - шрифт
элемента легенды. Чтобы легенда была видима на диаграмме, установите
поле HasLegend объекта Chart в
True.E.Charts.Item\[name\].HasLegend:=True. Затем можно установить
координаты и размеры легенды, параметры границы (рамки) и области. Для
этого используем следующие функции:

### Установка размеров и координат.

    Function PositionSizeLegend (Name:variant;
      Left,Top,Width,Height:real):boolean;
    begin
     PositionSizeLegend:=true;
     try
      E.Charts.Item[name].Legend.Left:=Left;
      E.Charts.Item[name].Legend.Top:=Top;
      E.Charts.Item[name].Legend.Width:=Width;
      E.Charts.Item[name].Legend.Height:=Height;
     except
      PositionSizeLegend:=false;
     end;
    End;

 
### Установка типа и цвета рамки.

    Function BorderLegend (Name:variant;
      Color,LineStyle,Weight:integer):boolean;
    begin
     BorderLegend:=true;
     try
      E.Charts.Item[name].Legend.Border.Color:=Color;
      E.Charts.Item[name].Legend.Border.Weight:=Weight;
      E.Charts.Item[name].Legend.Border.LineStyle:=LineStyle;
     except
      BorderLegend:=false;
     end;
    End;

 
### Установка цвета и типа узора области.

    Function BrushLegend (Name:variant;
      Color,Pattern,PatternColor:integer):boolean;
    begin
     BrushLegend:=true;
     try
      E.Charts.Item[name].Legend.Interior.Color:=Color;
      E.Charts.Item[name].Legend.Interior.Pattern:=Pattern;
      E.Charts.Item[name].Legend.Interior.PatternColor:=PatternColor;
     except
      BrushLegend:=false;
     end;
    End;

 
### Заливка области из файла.

    Function BrushLegendFromFile (Name:variant;File_: string):boolean;
    begin
     BrushLegendFromFile:=true;
     try
      E.Charts.Item[name].Legend.Fill.UserPicture(PictureFile:=File_);
      E.Charts.Item[name].Legend.Fill.Visible:=True;
     except
      BrushLegendFromFile:=false;
     end;
    End;

 
### Шрифт элемента легенды.

Объект Legend имеет доступ к коллекции LegendEntries, посредством
которой можно получить доступ к шрифту элемента легенды. Например:
E.Charts.Item\[name\].Legend.LegendEntries.Item\[LegendEntries\].Font,
где LegendEntries - индекс элемента. Чтобы согласовать поля объектов
"Шрифт" в Excel и Delphi, напишем функцию FontToEFont, которая
преобразует шрифт объекта Delphi в шрифт объекта Excel. Эту функцию
можно будет использовать везде, где необходимо установить шрифт.

    Function FontToEFont (font:Tfont;EFont:variant):boolean;
    Begin
     FontToEFont:=true;
     try
      EFont.Name:=font.Name;
      if fsBold in font.Style
       then EFont.Bold:=True // Жирный
       else EFont.Bold:=False; // Тонкий
      if fsItalic in font.Style
       then EFont.Italic:=True // Наклонный
       else EFont.Italic:=False; // Наклонный
      EFont.Size:=font.Size; // Размер
      if fsStrikeOut in font.Style
       then EFont.Strikethrough:=True // Перечеркнутый
       else EFont.Strikethrough:=False; // Перечеркнутый
      if fsUnderline in font.Style
       then EFont.Underline:=xlUnderlineStyleSingle // Подчеркивание
       else EFont.Underline:=xlUnderlineStyleNone; // Подчеркивание
      EFont.Color:=font.Color; // Цвет
     except
      FontToEFont:=false;
     end;
    End;

 
Функция FontLegendEntries устанавливает шрифт элемента (LegendEntries) легенды (Name).

    Function FontLegendEntries(Name,LegendEntries:variant;
      Font:TFont):boolean;
    begin
     FontLegendEntries:=true;
     try
      FontLegendEntries:=
       FontToEFont(Font,E.Charts.Item[name].Legend.LegendEntries.Item[LegendEntries].Font);
     except
      FontLegendEntries:=false;
     end;
    End;


