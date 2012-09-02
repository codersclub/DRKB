<h1>Как записать содержимое окна OpenGL в bmp файл?</h1>
<div class="date">01.01.2007</div>

gr - объект, в канве которого я рисую с помощью OpenGL </p>
<pre>
bt := TBitmap.Create;
with bt do
begin
  Width := gr.Width;
  Height := gr.Height;
  Canvas.CopyRect(ClientRect, gr.Canvas, gr.ClientRect);
  SaveToFile('e:\bt.bmp');
  Free;
end;
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
