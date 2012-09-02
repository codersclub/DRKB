<h1>Как заставить появиться окошко подсказки, когда курсор мышки находится над определенным контролом?</h1>
<div class="date">01.01.2007</div>


<pre>
var  hintWnd: THintWindow; 
 
procedure TForm1.ActivateHintNOW( x,y: Integer); 
var rect: TRect; 
begin 
  HintTxt := 'qq'; 
  if hintTxt &lt;&gt; '' then 
  begin 
    rect := hintWnd.CalcHintRect( Screen.Width, hinttxt, nil); 
    rect.Left := rect.Left + x; 
    rect.Right := rect.Right + x; 
    rect.Top := rect.Top + y; 
    rect.Bottom := rect.Bottom + y; 
    hintWnd.ActivateHint( rect, hinttxt); 
  end; 
end; 
</pre>

<p>Замечание: Не забудьте каждый раз создавать hintWnd:</p>

<p>  &nbsp;&nbsp; hintwnd:= THintWindow.create(self); </p>

<p>а затем освобождать его</p>

<p> &nbsp;&nbsp;&nbsp;&nbsp; hintwnd.releasehandle; </p>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

