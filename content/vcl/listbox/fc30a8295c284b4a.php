<h1>Как выводить элементы списка разными шрифтами?</h1>
<div class="date">01.01.2007</div>


<p>Очень удобно выбирать шрифты, когда в списке каждый шрифт написан собой. Например, "Arial" будет написано шрифтом Arial, а "Times" - Times. Список шрифтов лежит в свойстве Fonts объекта Screen. </p>
<pre>
procedure TForm1.FormCreate(Sender: TObject);
begin
  ListBox1.Items := Screen.Fonts;
  ListBox1.Style := lbOwnerDrawVariable;
end;
 
// Определение высоты элемента списка
procedure TForm1.ListBox1MeasureItem(Control: TWinControl; Index: Integer;
  var Height: Integer);
begin
  with ListBox1.Canvas do begin
    Font.Name := ListBox1.Items.Strings[index];
    Font.Size := 0; // Размер шрифта – по умолчанию
 
    Height := TextHeight(ListBox1.Items.Strings[index]) + 2;
  end;
end;
 
// Вывод названия шрифта
procedure TForm1.ListBox1DrawItem(Control: TWinControl; Index: Integer;
  Rect: TRect; State: TOwnerDrawState);
begin
  with ListBox1.Canvas do begin
    Font.Name := ListBox1.Items.Strings[index];
    Font.Size := 0; // Размер шрифта – по умолчанию
    TextOut(Rect.Left + 1, Rect.Top + 1,
 
      ListBox1.Items.Strings[index]);
  end;
end;
</pre>


<p class="author">Автор: Даниил Карапетян (delphi4all@narod.ru)</p>
<p class="author">Автор справки: Алексей Денисов (aleksey@sch103.krasnoyarsk.su)</p>

