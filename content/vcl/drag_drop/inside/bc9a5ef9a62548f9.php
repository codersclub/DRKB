<h1>Drag &amp; Drop &ndash; как использовать ItemAtPos для получения элемента DirListBox</h1>
<div class="date">01.01.2007</div>

Просто сохраните результат функции ItematPos в переменной формы, и затем используйте эту переменную в обработчике ListBoxDragDrop. Пример:</p>
<pre>
FDragItem := ItematPos(X, Y, True);
if FDragItem &gt;= 0 then
  BeginDrag(false);
...
 
procedure TForm1.ListBoxDragDrop(Sender, Source: TObject; X, Y: Integer);
begin
  if Source is TDirectoryListBox then
    ListBox.Items.Add(TDirectoryListBox(Source).GetItemPath(FDragItem));
end;
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
