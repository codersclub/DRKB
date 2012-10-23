<h1>Табуляция в графическом TListBox</h1>
<div class="date">01.01.2007</div>


<p>Использование табуляции в ListBox'е когда компонент находится в стандартном режиме не составляет труда. Но что делать если надо использовать графическое отображение элементов списка? Ведь при этом надо самому писать обработчик отрисовки элементов с разбиением на колонки. Элементарное решение - использование API функции TabbedTextOut, однако результаты работы этой функции меня явно не удовлетворили. Пришлось-таки "выкручиваться"... Символ-разделитель можно использовать любой. Например, будем использовать символ "|", тогда обработчик OnDrawItem может выглядеть следующим образом:</p>
<pre>
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
  if P &gt; 0 then
    ListBox1.Canvas.TextOut(ListBox1.TabWidth, Rect.Top + 2, Copy(S, P + 1,
      Length(S) - P + 2));
end;
</pre>

<p>Не забудьте перед запуском поставить нужное значение TabWidth.</p>
<div class="author">Автор: <a href="mailto:virty1k@mail.ru">Virtualik</a></div>

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
