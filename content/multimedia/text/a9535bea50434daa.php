<h1>Вывод текста на канве картинки</h1>
<div class="date">01.01.2007</div>


<p>При использовании BitBtn Caption(текст) и картинка(bitmap) из файла не видны одновременно. Почему? </p>

<p>Это может происходить если картинка слишком велика. Класс TBitBtn сначала рисует картинку, а затем выводит текст над, под, слева или справа от картинки (в завивимости от свойства Layout). Если размер картинки такой же как у всей кнопки для вывода текста просто не остается места. Если Вам нужно получить кнопку такого же размера как Ваша картинка и видеть при этом надпись на кнопке Вам придется выводить текст надписи непосредственно на канву картинки. </p>

<pre>
var
  bm : TBitmap;
  OldBkMode : integer;
begin
  bm := TBitmap.Create;
  bm.Width := BitBtn1.Glyph.Width;
  bm.Height := BitBtn1.Glyph.Height;
  bm.Canvas.Draw(0, 0, BitBtn1.Glyph);
  OldBkMode := SetBkMode(bm.Canvas.Handle, Transparent);
  bm.Canvas.TextOut(0, 0, 'The Caption');
  SetBkMode(bm.Canvas.Handle, OldBkMode);
  BitBtn1.Glyph.Assign(bm);
end; 
</pre>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
