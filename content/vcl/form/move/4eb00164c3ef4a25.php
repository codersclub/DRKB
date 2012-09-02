<h1>Ограничить подвижность формы</h1>
<div class="date">01.01.2007</div>


<p>For some reason messages.pas declares no message record for this message</p>
<pre>
type
  TWmMoving = record
    Msg: Cardinal;
    fwSide: Cardinal;
    lpRect: PRect;
    Result: Integer;
  end;
 
// Add a handler to your forms private section:
 
procedure WMMoving(var msg: TWMMoving); message WM_MOVING;
 
// Implement it as
 
  procedure TFormX.WMMoving(var msg: TWMMoving);
  var
    r: TRect;
  begin
    r := Screen.WorkareaRect;
   // compare the new form bounds in msg.lpRect^ with r and modify it if
   // necessary
    if msg.lprect^.left &lt; r.left then
      OffsetRect(msg.lprect^, r.left - msg.lprect^.left, 0);
    if msg.lprect^.top &lt; r.top then
      OffsetRect(msg.lprect^, 0, r.top - msg.lprect^.top);
    if msg.lprect^.right &gt; r.right then
      OffsetRect(msg.lprect^, r.right - msg.lprect^.right, 0);
    if msg.lprect^.bottom &gt; r.bottom then
      OffsetRect(msg.lprect^, 0, r.bottom - msg.lprect^.bottom);
    inherited;
  end;
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>

