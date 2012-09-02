<h1>Как нарисовать disabled текст?</h1>
<div class="date">01.01.2007</div>


<pre>
{Draw Disabled Text **************
 ***** This function draws text in "disabled" style.  *****
 ***** i.e. the text is grayed .                      *****
 **********************************************************}
function DrawDisabledText (Canvas : tCanvas; Str: PChar; Count: Integer;
                           var Rect: TRect;  Format: Word): Integer;
begin
  SetBkMode(Canvas.Handle, TRANSPARENT);
 
  OffsetRect(Rect, 1, 1);
  Canvas.Font.color:= ClbtnHighlight;
  DrawText (Canvas.Handle, Str, Count, Rect,Format);
 
  Canvas.Font.Color:= ClbtnShadow;
  OffsetRect(Rect, -1, -1);
  DrawText (Canvas.Handle, Str, Count, Rect, Format);
end;
</pre>

<p>Зайцев О.В.</p>
<p>Владимиров А.М.</p>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>


