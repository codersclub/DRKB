<h1>Управление настройками шрифта</h1>
<div class="date">01.01.2007</div>



<pre>
{
Данный код изменяет стиль шрифта поля редактирования,
если оно выбрано. Может быть адаприрован для управления
шрифтами в других объектах.
 
Расположите на форме Edit(Edit1) и ListBox(ListBox1).
Добавьте следующие элементы (Items) к ListBox:
fsBold
fsItalic
fsUnderLine
fsStrikeOut
}
 
procedure TForm1.ListBox1Click(Sender: TObject);
var
  X: Integer;
type
  TLookUpRec = record
    Name: string;
    Data: TFontStyle;
  end;
const
  LookUpTable: array[1..4] of TLookUpRec =
  ((Name: 'fsBold'; Data: fsBold),
    (Name: 'fsItalic'; Data: fsItalic),
    (Name: 'fsUnderline'; Data: fsUnderline),
    (Name: 'fsStrikeOut'; Data: fsStrikeOut));
begin
  X := ListBox1.ItemIndex;
  Edit1.Text := ListBox1.Items[X];
  Edit1.Font.Style := [LookUpTable[ListBox1.ItemIndex + 1].Data];
end;
</pre>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
