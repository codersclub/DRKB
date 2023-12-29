---
Title: Табуляция в графическом TListBox
Author: [Virtualik](mailto:virty1k@mail.ru)
Date: 01.01.2007
---


Табуляция в графическом TListBox
================================

::: {.date}
01.01.2007
:::

Использование табуляции в ListBox, когда компонент находится в
стандартном режиме, не составляет труда. Но что делать если надо
использовать графическое отображение элементов списка? Ведь при этом
надо самому писать обработчик отрисовки элементов с разбиением на
колонки. Элементарное решение - использование API функции TabbedTextOut,
однако результаты работы этой функции меня явно не удовлетворили.
Пришлось-таки "выкручиваться"... Символ-разделитель можно
использовать любой. Например, будем использовать символ "\|", тогда
обработчик OnDrawItem может выглядеть следующим образом:

    procedure TBrowser.ListBox1DrawItem(Control: TWinControl; Index: Integer;
      Rect: TRect; State: TOwnerDrawState);
    var
      S, Ss: string;
      P: Integer; // Флаг символа-разделителя
    begin
      ListBox1.Canvas.FillRect(Rect);
      //Отрисовка графики
      ...
        //
      S := ListBox1.Items.Strings[Index];
      P := Pos('|', S);
      if P = 0 then
        Ss := S
      else
        // Если нет табуляции, то пишем всю строку,
        // иначе отрезаем кусок до разделителя
        Ss := Copy(S, 1, P - 1);
      ListBox1.Canvas.TextOut(Rect.Left + 20, Rect.Top + 2, Ss);
      if P > 0 then
        ListBox1.Canvas.TextOut(ListBox1.TabWidth, Rect.Top + 2, Copy(S, P + 1,
          Length(S) - P + 2));
    end;

Не забудьте перед запуском поставить нужное значение TabWidth.

Автор: [Virtualik](mailto:virty1k@mail.ru)

Взято с <https://delphiworld.narod.ru>
