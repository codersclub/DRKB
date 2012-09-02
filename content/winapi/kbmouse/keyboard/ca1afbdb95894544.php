<h1>Оперировать с цифровой частью клавиатуры всегда как будто NumLock занят</h1>
<div class="date">01.01.2007</div>


<pre>
procedure TForm1.AppOnMessage(var Msg: TMsg; var Handled: Boolean);
 var
   ccode: Word;
 begin
   case Msg.Message of
     WM_KEYDOWN, WM_KEYUP:
       begin
         if (GetKeyState(VK_NUMLOCK) &gt;= 0)  {NumLock not active} and
           ((Msg.lParam and $1000000) = 0)  {not a gray key} then
         begin
           ccode := 0;
           case Msg.wParam of
             VK_HOME: ccode   := VK_NUMPAD7;
             VK_UP: ccode     := VK_NUMPAD8;
             VK_PRIOR: ccode  := VK_NUMPAD9;
             VK_LEFT: ccode   := VK_NUMPAD4;
             VK_CLEAR: ccode  := VK_NUMPAD5;
             VK_RIGHT: ccode  := VK_NUMPAD6;
             VK_END: ccode    := VK_NUMPAD1;
             VK_DOWN: ccode   := VK_NUMPAD2;
             VK_NEXT: ccode   := VK_NUMPAD3;
             VK_INSERT: ccode := VK_NUMPAD0;
             VK_DELETE: ccode := VK_DECIMAL;
           end; {Case}
           if ccode &lt;&gt; 0 then
             Msg.wParam := ccode;
         end; {If}
       end; {Case Msg.Message}
   end; {Case}
 end;
 
 procedure TForm1.FormCreate(Sender: TObject);
 begin
   Application.OnMessage := AppOnMessage;
 end;
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>

