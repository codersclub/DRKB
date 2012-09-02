<h1>Замена Application.ProcessMessages</h1>
<div class="date">01.01.2007</div>


<pre>
{ **** UBPFD *********** by delphibase.endimus.com ****
&gt;&gt; Замена штатного Application.ProcessMessages
 
Хорошо использовать в DLL или бесформенных приложениях, 
если внутри цикла возникает необходимость в использовании Application.ProcessMessages.
 
Зависимости: Windows, Messages
Автор:       ssk, ucad@pisem.net, ICQ:166758074, Харьков
Copyright:   составлено из кусков кода Borland
Дата:        7 сентября 2004 г.
***************************************************** }
 
procedure ProcessMessagesEx;
  function IsKeyMsg(var Msg: TMsg): Boolean;
  const
    CN_BASE = $BC00;
  var
    Wnd: HWND;
  begin
    Result := False;
    with Msg do
      if (Message &gt;= WM_KEYFIRST) and (Message &lt;= WM_KEYLAST) then
        begin
          Wnd := GetCapture;
          if Wnd = 0 then
            begin
              Wnd := HWnd;
              if SendMessage(Wnd, CN_BASE + Message, WParam, LParam) &lt;&gt; 0 then
                Result := True;
            end
              else
                if (LongWord(GetWindowLong(Wnd, GWL_HINSTANCE)) = HInstance) then
                  if SendMessage(Wnd, CN_BASE + Message, WParam, LParam) &lt;&gt; 0 then
                    Result := True;
        end;
  end;
 
  function ProcessMessage(var Msg: TMsg): Boolean;
  begin
    Result := False;
    if PeekMessage(Msg, 0, 0, 0, PM_REMOVE) then
      begin
        Result := True;
        if Msg.Message &lt;&gt; WM_QUIT then
          if not IsKeyMsg(Msg) then
            begin
              TranslateMessage(Msg);
              DispatchMessage(Msg);
            end;
      end;
  end;
 
var
 Msg: TMsg;
begin
 while ProcessMessage(Msg) do {loop};
end;
</pre>

<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
