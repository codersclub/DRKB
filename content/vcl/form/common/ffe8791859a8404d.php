<h1>Как поместить курсор мышки в нужное место на форме?</h1>
<div class="date">01.01.2007</div>


<pre>
uses 
  Windows; 
 
procedure PlaceMyMouse(Sender: TForm; X, Y: word); 
var 
  MyPoint: TPoint; 
begin 
  MyPoint := Sender.ClientToScreen(Point(X, Y)); 
  SetCursorPos(MyPoint.X, MyPoint.Y); 
end;
</pre>


<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
