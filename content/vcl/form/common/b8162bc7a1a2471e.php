<h1>Как сделать анимацию минимизации формы?</h1>
<div class="date">01.01.2007</div>


<p>In FormShow:</p>
<pre>
var
  RecS, RecL: TRect;
begin
  RecS := Rect(Screen.Width, Screen.Height, Screen.Width, Screen.Height);
  RecL := ThisForm.BoundsRect;
  DrawAnimatedRects(GetDesktopWindow, IDANI_CAPTION, RecS, RecL);
  { ... }
end;
</pre>


<p>In FormHide:</p>
<pre>
var
  RecS, RecL: TRect;
begin
  HideTimer.Enabled := False;
  RecS := Rect(Screen.Width, Screen.Height, Screen.Width, Screen.Height);
  RecL := ThisForm.BoundsRect;
  DrawAnimatedRects(GetDesktopWindow, IDANI_CAPTION, RecL, RecS);
end;
</pre>


<p>Взято с Delphi Knowledge Base: <a href="https://www.baltsoft.com/" target="_blank">https://www.baltsoft.com/</a></p>

