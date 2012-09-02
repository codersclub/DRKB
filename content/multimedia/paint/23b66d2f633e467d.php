<h1>Как рисовать в чужом окне или по всему экрану?</h1>
<div class="date">01.01.2007</div>


<pre>
procedure DrawOnScreen;
var
  ScreenDC: hDC;
begin
  ScreenDC := GetDC(0); {получить контекст экрана}
  Ellipse(ScreenDC, 0, 0, 200, 200); {нарисовать}
  ReleaseDC(0, ScreenDC); {освободить контекст}
end;
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

