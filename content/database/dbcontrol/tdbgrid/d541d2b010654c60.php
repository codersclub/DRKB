<h1>Как заставить корректно работать колесо мыши в TDBGrid?</h1>
<div class="date">01.01.2007</div>


<pre>
{....}
 
public
  procedure AppMessage(var Msg: TMsg; var Handled: Boolean);
 
{....}
 
 
 
procedure TForm1.AppMessage(var Msg: TMsg; var Handled: Boolean);
var
  i: SmallInt;
begin
  {Mouse wheel behaves strangely with dgbgrids - this proc sorts this out}
  if Msg.message = WM_MOUSEWHEEL then
  begin
    Msg.message := WM_KEYDOWN;
    Msg.lParam := 0;
    i := HiWord(Msg.wParam);
    if i &gt; 0 then
      Msg.wParam := VK_UP
    else
      Msg.wParam := VK_DOWN;
 
    Handled := False;
  end;
end;
 
  // And in the project source:
 
{....}
 
Application.OnMessage := Form1.AppMessage;
 
{....}
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
