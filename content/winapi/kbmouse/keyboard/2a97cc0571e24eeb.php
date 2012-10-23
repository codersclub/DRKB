<h1>Как послать нажатие клавиши в какое-нибудь окно?</h1>
<div class="date">01.01.2007</div>


<p>Эта процедура посылает сообщение о нажатии клавиши.</p>
<pre>
procedure PostKeyEx32(key: Word; const shift: TShiftState; specialkey: Boolean);

 
type TShiftKeyInfo = record
    shift: Byte;
    vkey: Byte;
  end;
  byteset = set of 0..7;
const shiftkeys: array[1..3] of TShiftKeyInfo = ((shift: Ord(ssCtrl);
    vkey: VK_CONTROL), (shift: Ord(ssShift); vkey: VK_SHIFT), (shift: Ord(ssAlt); vkey: VK_MENU));
 
var flag: DWORD;
  bShift: ByteSet absolute shift;
  i: Integer;
begin
  for i := 1 to 3 do
    if shiftkeys[i].shift in bShift then 
      keybd_event(shiftkeys[i].vkey, MapVirtualKey(shiftkeys[i].vkey, 0), 0, 0);
  if specialkey then
    flag := KEYEVENTF_EXTENDEDKEY
  else
    flag := 0;
  keybd_event(key, MapvirtualKey(key, 0), flag, 0);
  flag := flag or KEYEVENTF_KEYUP;
  keybd_event(key, MapvirtualKey(key, 0), flag, 0);
  for i := 3 downto 1 do
    if shiftkeys[i].shift in bShift then 
      keybd_event(shiftkeys[i].vkey, MapVirtualKey(shiftkeys[i].vkey, 0), KEYEVENTF_KEYUP, 0);
end;
</pre>
<p>Чтобы воспользоваться этой процедурой надо предварительно найти и активизировать нужное окно:</p>
<pre>
SetForegroundWindow(FindWindow(PChar(WindowClassName), PChar(WindowCaption)));
</pre>
<p>PS. не забудьте поставить задержки типа Sleep(100) после активизации окна и между посылаемыми клавишами, не то окно может не успевать реагировать на клавиши...</p>
<div class="author">Автор: Vit</div>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
