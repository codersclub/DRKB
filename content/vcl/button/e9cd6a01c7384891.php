<h1>Смена иконки BitBtn во время работы приложения</h1>
<div class="date">01.01.2007</div>

<p>Иконка компонента является инкапсулированным объектом, требующим для хранения изображения некоторый участок памяти. Следовательно, при замене иконки, память, связанная с первоначальной иконкой, должна возвратиться в кучу, а для новой иконки требуется новое распределение памяти. По правилам Delphi, этим должен заниматься метод "Assign". Ниже приведен код всей процедуры замены иконки.</p>
<pre>implementation
 
{$R *.DFM}
 
var
  n: integer; // При инициализации программы данное значение будет равным нулю
 
procedure TForm1.Button1Click(Sender: TObject);
var
  Image: TBitmap;
begin // Изменение иконки в BitBtn1
 
  Image := TBitmap.Create;
  if n &lt; ImageList1.Count then
    ImageList1.GetBitmap(n, Image);
  {end if}
 
  BitBtn1.Glyph.Assign(Image)
    // Примечание: Для изменения свойств объекта используется метод Assign
 
  inc(n, 2); // В данный момент кнопка содержит две иконки!
  if n &gt; ImageList1.Count then
    n := 0;
  {end if}
  Image.Free;
end;
 
procedure TForm1.Button2Click(Sender: TObject);
begin // добавляем новую иконку кнопки в список ImageList1
  if OpenDialog1.Execute then
    ImageList1.FileLoad(rtBitMap, OpenDialog1.FileName, clBtnFace);
  label1.Caption := 'Количество иконок = ' + IntToStr(ImageList1.Count);
end;
 
 
</pre>

<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
