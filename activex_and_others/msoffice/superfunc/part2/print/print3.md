---
Title: Вид листа, область и параметры страницы для печати
Date: 16.06.2003
Author: Василий КОРНЯКОВ (_kvn@mail.ru)
---


Вид листа, область и параметры страницы для печати
==================================================

Вид рабочего листа может быть представлен в режиме "Разметка
страницы", если установлен и выбран принтер, или в режиме "Обычный".
В режиме разметки страницы есть возможность изменять область печати. Вид
рабочего листа определяется константой, которая содержится в поле View
объекта ActiveWindow. Она может иметь значения xlNormalView=1 или
xlPageBreakPreview=2. Функция WindowView для приложений Delphi реализует
изменение вида рабочего листа.

    Function WindowView (view:integer):boolean;
    begin
     WindowView:=true;
     try
      E.ActiveWindow.View:=view;
     except
      WindowView:=false;
     end;
    End;

 

Когда принтер выбран, можно приступать к настройке параметров страницы
печати, которые зависят от параметров выбранного принтера. Параметры
настройки печати листа содержатся в полях объекта PageSetup, который
является свойством листа. Поля объекта PageSetup содержат и определяют
ориентацию и пропорции для печати страницы, размеры полей, колонтитулы,
порядок и диапазон печати, качество печати. Из всего этого набора
остановимся на тех, которые используются наиболее часто. Это задание
ориентации страницы, размер бумаги и область печати. Ориентация бумаги
определяется константой, которая записывается в поле Orientation объекта
PageSetup. Она может иметь два значения: xlLandscape - альбомная и
xlPortrait - книжная. Функция PageOrientation реализует это в
приложениях Delphi.

    Function PageOrientation (sheet:variant;
      orientation:integer):boolean;
    begin
     PageOrientation:=true;
     try
      E.ActiveWorkbook.Sheets.Item
       [sheet].PageSetup.Orientation:=orientation;
     except
      PageOrientation:=false;
     end;
    End;

Размер бумаги определяется константой, записанной в поле PaperSize,
которая может иметь более 40 значений, каждое из которых соответствует
различным типовым размерам бумаги (см. приложение
[st2_4.zip](st2_4.zip)).

Наиболее часто используются размеры бумаги
формата A3 (xlPaperA3=8) и A4 (xlPaperA4=9).

    Function PagePaperSize (sheet:variant;
      papersize:integer):boolean;
    begin
     PagePaperSize:=true;
     try
      E.ActiveWorkbook.Sheets.Item
       [sheet].PageSetup.PaperSize:=papersize;
     except
      PagePaperSize:=false;
     end;
    End;

 

Область границ страницы - прямоугольная область ячеек, которая будет
выведена на печать. Для задания области границ необходимо в поле
PrintArea объекта PageSetup записать строку, которая определит верхнюю
левую, правую нижнюю ячейку области, например:
PrintArea="$A$1:$I$26". Ячейки, которые не входят в эту область,
не будут выведены на печать.

    Function PagePrintArea (sheet:variant;
      printarea:string):boolean;
    begin
     PagePrintArea:=true;
     try
      E.ActiveWorkbook.Sheets.Item
       [sheet].PageSetup.PrintArea:=printarea;
     except
      PagePrintArea:=false;
     end;
    End;

 

Для того, чтобы линии сетки отображались на печатной форме или были
спрятаны, используется свойство PrintGridlines объекта PageSetup.

    Function PrintGridlines (sheet:variant;
      gridline:boolean):boolean;
    begin
     PrintGridlines:=true;
     try
      E.ActiveWorkbook.Sheets.Item
       [sheet].PageSetup.PrintGridlines:=gridline;
     except
      PrintGridlines:=false;
     end;
    End;

 

Важным свойством объекта PageSetup являются размеры полей слева, справа,
сверху и снизу (LeftMargin, RightMargin, TopMargin, BottomMargin). В эти
поля записывается количество точек. Если исходные величины полей заданы
в дюймах, то преобразование осуществляем, используя функцию

    Point=Application.InchesToPoints(Inche)

где Point - количество точек, Inche - величина в дюймах.
