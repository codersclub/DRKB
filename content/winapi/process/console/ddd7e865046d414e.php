<h1>Имитация ввода с клавиатуры для консоли</h1>
<div class="date">01.01.2007</div>

Автор: Nomadic</p>
<pre>
const
 
  ExtendedKeys: set of Byte = [ // incomplete list
  VK_INSERT, VK_DELETE, VK_HOME, VK_END, VK_PRIOR, VK_NEXT,
    VK_LEFT, VK_UP, VK_RIGHT, VK_DOWN, VK_NUMLOCK
    ];
 
procedure SimulateKeyDown(Key: byte);
var
 
  flags: DWORD;
begin
 
  if Key in ExtendedKeys then
    flags := KEYEVENTF_EXTENDEDKEY
  else
    flags := 0;
  keybd_event(Key, MapVirtualKey(Key, 0), flags, 0);
end;
 
procedure SimulateKeyUp(Key: byte);
var
 
  flags: DWORD;
begin
 
  if Key in ExtendedKeys then
    flags := KEYEVENTF_EXTENDEDKEY
  else
    flags := 0;
  keybd_event(Key, MapVirtualKey(Key, 0), KEYEVENTF_KEYUP or flags, 0);
end;
 
procedure SimulateKeystroke(Key: byte);
var
 
  flags: DWORD;
  scancode: BYTE;
begin
 
  if Key in ExtendedKeys then
    flags := KEYEVENTF_EXTENDEDKEY
  else
    flags := 0;
  scancode := MapVirtualKey(Key, 0);
  keybd_event(Key,
    scancode,
    flags,
    0);
  keybd_event(Key,
    scancode,
    KEYEVENTF_KEYUP or flags,
    0);
end;
 
 
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>

