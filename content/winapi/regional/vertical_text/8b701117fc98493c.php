<h1>Как вывести текст с красивым обрезанием если не помещается?</h1>
<div class="date">01.01.2007</div>


<p>Используй вызов DrawTextEx, установив в параметре dwDTFormat значение DT_PATH_ELLIPSIS.</p>
<pre>
procedure TForm1.FormPaint(Sender: TObject);
var
  r: TRect;
begin
  r := Rect(20, 20, 110, 70);
  // DT_PATH_ELLIPSIS or DT_WORD_ELLIPSIS or DT_END_ELLIPSIS
  DrawTextEx(Form1.Canvas.Handle, 'Delphi World - это круто!!!',
   25, r, DT_WORD_ELLIPSIS, nil);
end;
</pre>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
