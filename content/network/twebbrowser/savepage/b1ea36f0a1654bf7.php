<h1>Как сохранить веб-страничку в Bitmap?</h1>
<div class="date">01.01.2007</div>


<p>Взято из FAQ:<a href="https://blackman.km.ru/myfaq/cont4.phtml" target="_blank">https://blackman.km.ru/myfaq/cont4.phtml</a></p>
<p>Перевод материала с сайта members.home.com/hfournier/webbrowser.htm</p>
<pre>
procedure TForm1.Button1Click(Sender: TObject);
var
  ViewObject: IViewObject;
  sourceDrawRect: TRect;
begin
if EmbeddedWB1.Document &lt; &gt; nil then
try
EmbeddedWB1.Document.QueryInterface(IViewObject, ViewObject);
if ViewObject &lt; &gt; nil then
try
  sourceDrawRect := Rect(0, 0, Image1.Width, Image1.Height);
  ViewObject.Draw(DVASPECT_CONTENT, 1, nil, nil, Self.Handle,
  image1.Canvas.Handle, @sourceDrawRect, nil, nil, 0);
finally
  ViewObject._Release;
end;
except
end;
end;
</pre>



<div class="author">Автор: John </div>
