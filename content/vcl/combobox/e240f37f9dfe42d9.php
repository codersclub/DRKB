<h1>Как получить размер развернутого TComboBox?</h1>
<div class="date">01.01.2007</div>


<p>В течение события FormShow, выпадающему списке дважды посылается сообщение CB_SHOWDROPDOWN , один раз, чтобы он открылся, а второй - чтобы свернулся. Затем посылается сообщение CB_GETDROPPEDCONTROLRECT, передающее адрес TRect. </p>

<p>Когда вызов SendMessage возвращается, то TRect будет содержать прямоугольник, который соответствует раскрытому ComboBox-у относительно окна. Затем можно вызвать ScreenToClient для преобразования координат TRect-а в координаты относительно клиентской области формы.</p>
<pre>
var 
  R : TRect; 
 
procedure TForm1.FormShow(Sender: TObject); 
var 
  T : TPoint; 
begin 
  SendMessage(ComboBox1.Handle, 
              CB_SHOWDROPDOWN, 
              1, 
              0); 
  SendMessage(ComboBox1.Handle, 
              CB_SHOWDROPDOWN, 
              0, 
              0); 
  SendMessage(ComboBox1.Handle, 
              CB_GETDROPPEDCONTROLRECT, 
              0, 
              LongInt(@r)); 
  t := ScreenToClient(Point(r.Left, r.Top)); 
  r.Left := t.x; 
  r.Top := t.y; 
  t := ScreenToClient(Point(r.Right, r.Bottom)); 
  r.Right := t.x; 
  r.Bottom := t.y; 
end; 
 
procedure TForm1.Button1Click(Sender: TObject); 
begin 
  Form1.Canvas.Rectangle(r.Left, 
                         r.Top, 
                         r.Right, 
                         r.Bottom ); 
end;
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

