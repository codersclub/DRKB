---
Title: Экспорт документов Excel
Author: JB
Date: 01.01.2007
---


Экспорт документов Excel
========================

::: {.date}
01.01.2007
:::

Экспорт документов в Excel

Автор: JB

https://asportal.h16.ru

Эта статья первая из цикла статей посвященных экспорту документов в MS
Excel. В ней мы рассмотрим подключение к Excel, заполнению ячеек и
простейшее оформление документа.

Я не буду углубляться в теорию, рассказывать о том как работает OLE
механизм, начнем с самого главного.

Подключение.

Для подключения к Excel и работы с ним нам понадобится переменная типа
Variant:

Excel:Variant;

Далее создаем OLE объект:

Excel:=CreateOleObject(\'Excel.Application\');

Добавляем новую книгу:

Excel.Workbooks.Add;

Показываем Excel:

Excel.Visible:=true;

Так же нам понадобятся константы:

const

xlContinuous=1;

xlThin=2;

xlTop = -4160;

xlCenter = -4108;

Текст ячеек.

Теперь до любой ячейки мы можем добраться следующим образом:

Excel.ActiveWorkBook.WorkSheets[1].Cells[1, 2]:=\'Текст ячейки
(1,2)\';

Объект Range, выделение диапазона, объединение ячеек, выравнивание.

Представьте такую ситуацию: необходимо объединить несколько ячеек и
выровнять текст в них по центру.

Выделяем:

Excel.ActiveWorkBook.WorkSheets[1].Range[\'A1:G1\'].Select;

Объединяем:

Excel.ActiveWorkBook.WorkSheets[1].Range[\'A1:G1\'].Merge;

И выравниваем:

Excel.Selection.HorizontalAlignment:=xlCenter;

Границы и перенос по словам.

Для начала выделяем нужный диапазон а затем...

Показываем границы:

Excel.Selection.Borders.LineStyle:=xlContinuous;

Excel.Selection.Borders.Weight:=xlThin;

И включаем перенос по словам:

Excel.Selection.WrapText:=true;

Пример.

Пример можно скачать здесь

Параметры страницы.

Начнем с полей страницы. Во первых для того чтобы добраться до
параметров страницы у листа Excel имеется свойство объект PageSetup его
мы и будем использовать. Для установки размеров полей необходимо
изменить соответствующие свойства PageSetup, вот эти свойства:

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"}
  --- -------------------------
  ·   LeftMargin - Левое поле
  --- -------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"}
  --- ---------------------------
  ·   RightMargin - Правое поле
  --- ---------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"}
  --- --------------------------
  ·   TopMargin - Верхнее поле
  --- --------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"}
  --- ----------------------------
  ·   BottomMargin - Нижнее поле
  --- ----------------------------
:::

Значение размеров полей необходимо указывать в пикселях, к чему мы не
очень привыкли, поэтому воспользуемся функцией InchesToPoints объекта
Application, которая переводит значение в дюймах в значение в пикселях.
Теперь напишем процедуру которая подключит Excel и установит поля равные
0.44 дюйма (приблизительно 1 см):

    procedure Connect;
    var
      Excel:Variant;
    begin
      Excel:=CreateOleObject('Excel.Application');
      Excel.Workbooks.Add;
     
      Excel.ActiveSheet.PageSetup.LeftMargin:= Excel.Application.InchesToPoints(0.44);
      Excel.ActiveSheet.PageSetup.RightMargin:= Excel.Application.InchesToPoints(0.44);
      Excel.ActiveSheet.PageSetup.TopMargin:= Excel.Application.InchesToPoints(0.44);
      Excel.ActiveSheet.PageSetup.BottomMargin:= Excel.Application.InchesToPoints(0.44);
    end;

Иногда полезно уметь установить и ориентацию страницы:

Excel.ActiveSheet.PageSetup.Orientation:= 2;

Здесь значение ориентации = 2, означает альбомную, при книжной
ориентации присвойте Orientation значение 1.

Вы наверное не раз встречали такой отчет в котором таблица с большим
количеством строк размещается на нескольких страницах в таких случаях
очень удобны сквозные строки, они печатаются на каждой странице отчета:

Excel.ActiveSheet.PageSetup.PrintTitleRows:=\'$2:$3\';

Здесь мы указываем вторую и третью строки для печати на каждой странице.

Шрифты и цвета.

Для установки шрифта и размера текста выделите нужный диапазон и
установите свойство Name объекта-свойства Font объекта Selection или
свойство Size для изменения размера:

     
      Excel.ActiveWorkBook.WorkSheets[1].Range['F1'].Select;
      Excel.Selection.Font.Name:='Courier New';
      Excel.Selection.Font.Size:=18;

Если Вы хотите установить жирный или, например, наклонный стиль
написания текста установите соответствующие свойства:

      Excel.ActiveWorkBook.WorkSheets[1].Range['G1'].Select;
      Excel.Selection.Font.Bold:=true; // Для жирного текста
      Excel.Selection.Font.Italic:=true; // Для наклонного текста

Для указания цвета текста измените свойство ColorIndex все того же
объекта Font:

      Excel.ActiveWorkBook.WorkSheets[1].Range['A1'].Select;
      Excel.Selection.Font.ColorIndex:=3;

Вот несколько индексов цветов:

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"}
  --- ---------------
  ·   Индекс - Цвет
  --- ---------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"}
  --- ----------
  ·   0 - Авто
  --- ----------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"}
  --- -----------
  ·   2 - Белый
  --- -----------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"}
  --- -------------
  ·   3 - Красный
  --- -------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"}
  --- -----------
  ·   5 - Синий
  --- -----------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"}
  --- ------------
  ·   6 - Желтый
  --- ------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"}
  --- --------------
  ·   10 - Зеленый
  --- --------------
:::

Для изменения цвета фона ячейки используйте объект Interior свойства
Selection:

      Excel.ActiveWorkBook.WorkSheets[1].Range['H1'].Select;
      Excel.Selection.Interior.ColorIndex:=3; // Цвет

Колонтитулы.

Для добавления колонтитула к документу достаточно указать его
содержание:

      Excel.ActiveSheet.PageSetup.LeftFooter:='Левый нижний колонтитул';
      Excel.ActiveSheet.PageSetup.CenterFooter:='Центральный нижний колонтитул';
      Excel.ActiveSheet.PageSetup.RightFooter:='Правый нижний колонтитул';
      Excel.ActiveSheet.PageSetup.LeftHeader:='Левый верхний колонтитул';
      Excel.ActiveSheet.PageSetup.CenterHeader:='Центральный верхний колонтитул';
      Excel.ActiveSheet.PageSetup.RightHeader:='Правый верхний колонтитул';

Для изменения размера шрифта добавьте к колонтитулу управляющий символ
"&" и размер шрифта:

      Excel.ActiveSheet.PageSetup.LeftFooter:='&7Левый нижний колонтитул';
