<h1>Как програмно переключить состояние клавиш Num Lock, Caps Lock, Scroll Lock?</h1>
<div class="date">01.01.2007</div>


<pre>
VAR 
  KS: TKeyboardState; 
begin
GetKeyboardState(KS); 
KS[020] := KS[020] XOR 1; //Caps Lock
KS[144] := KS[144] XOR 1; //Num Lock
KS[145] := KS[145] XOR 1; //Scroll Lock
SetKeyboardState(KS); 
end;
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>


<hr />Во-первых, предложенный способ работает только под 9x (лично проверил)...</p>
<p>Во-вторых, для понятности лучше вместо цифр подставить нормальные константы...</p>
<p>В-третьих, тут еще способ и для NT...</p>

<p>Способ для 9x (на NT не работает):</p>
<pre>
var

 
 KeyState : TKeyboardState;
begin
 GetKeyboardState(KeyState);
 KeyState[VK_SCROLL] := KeyState[VK_SCROLL] xor 1;
 KeyState[VK_CAPITAL] := KeyState[VK_CAPITAL] xor 1;
 KeyState[VK_NUMLOCK] := KeyState[VK_NUMLOCK] xor 1;
 SetKeyboardState (KeyState);
end; 
 
Способ для NT (на 9x не работает):
begin
  keybd_event (VK_SCROLL, 0, KEYEVENTF_EXTENDEDKEY, 0);
  keybd_event (VK_SCROLL, 0, KEYEVENTF_EXTENDEDKEY or KEYEVENTF_KEYUP, 0);
 
  keybd_event (VK_CAPITAL, 0, KEYEVENTF_EXTENDEDKEY, 0);
  keybd_event (VK_CAPITAL, 0, KEYEVENTF_EXTENDEDKEY or KEYEVENTF_KEYUP, 0);
 
  keybd_event (VK_NUMLOCK, 0, KEYEVENTF_EXTENDEDKEY, 0);
  keybd_event (VK_NUMLOCK, 0, KEYEVENTF_EXTENDEDKEY or KEYEVENTF_KEYUP, 0);
end;
</pre>

<p>т.е. в программе надо будет сделать проверку на версию Windows,</p>
<p>и потом уже вызывать одну из этих функций,</p>
<p>либо же можно их обе вызывать - одна да сработает...</p>

<div class="author">Автор: p0s0l</div>

<hr /><p>Как программно включить или выключить NumLock</p>
<pre>
var
  abKeyState: array [0..255] of byte;
begin
  GetKeyboardState( Addr( abKeyState[ 0 ] ) );
  abKeyState[ VK_NUMLOCK ] := abKeyState[ VK_NUMLOCK ] or $01;
  SetKeyboardState( Addr( abKeyState[ 0 ] ) );
end;
</pre>
<a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>

<hr />
<pre>
procedure TMyForm.Button1Click(Sender: TObject);
Var
  KeyState:  TKeyboardState;
begin
  GetKeyboardState(KeyState);
  if (KeyState[VK_NUMLOCK] = 0) then
    KeyState[VK_NUMLOCK] := 1
  else
    KeyState[VK_NUMLOCK] := 0;
  SetKeyboardState(KeyState);
end;
</pre>

<p>Для Caps Lock замените VK_NUMLOCK на VK_CAPITAL.</p>
<a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>

<hr />
<pre>
type
   TKeyType = (ktCapsLock, ktNumLock, ktScrollLock);
 
 procedure SetLedState(KeyCode: TKeyType; bOn: Boolean);
 var
   KBState: TKeyboardState;
   Code: Byte;
 begin
   case KeyCode of
     ktScrollLock: Code := VK_SCROLL;
     ktCapsLock: Code := VK_CAPITAL;
     ktNumLock: Code := VK_NUMLOCK;
   end;
   GetKeyboardState(KBState);
   if (Win32Platform = VER_PLATFORM_WIN32_NT) then
   begin
     if Boolean(KBState[Code]) &lt;&gt; bOn then
     begin
       keybd_event(Code,
                   MapVirtualKey(Code, 0),
                   KEYEVENTF_EXTENDEDKEY,
                   0);
 
       keybd_event(Code,
                   MapVirtualKey(Code, 0),
                   KEYEVENTF_EXTENDEDKEY or KEYEVENTF_KEYUP,
                   0);
     end;
   end
   else
   begin
     KBState[Code] := Ord(bOn);
     SetKeyboardState(KBState);
   end;
 end;
 
 // Example Call: 
// Beispielaufruf: 
 
procedure TForm1.Button1Click(Sender: TObject);
 begin
   SetLedState(ktCapsLock, True);  // CapsLock on 
  SetLedState(ktNumLock, True);  // NumLock on 
  SetLedState(ktScrollLock, True);  // ScrollLock on 
end;
</pre>
<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>

