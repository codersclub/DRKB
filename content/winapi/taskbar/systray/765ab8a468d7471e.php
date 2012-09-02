<h1>Как закрыть всплывающее меню в System Tray, когда оно теряет фокус?</h1>
<div class="date">01.01.2007</div>


<p>Иногда, при потере фокуса, всплывающее меню в System Tray при потере фокуса не закрывается. Поэтому, при обработке сообщений для всплывающего меню необходимо поместить окно на передний план и послать ему сообщение WM_NULL.</p>
<pre>
procedure TForm1.WndProc(var Msg : TMessage);
var
  p : TPoint;
begin
  case Msg.Msg of
    WM_USER + 1:
    case Msg.lParam of
      WM_RBUTTONDOWN: begin
         SetForegroundWindow(Handle);
         GetCursorPos(p);
         PopupMenu1.Popup(p.x, p.y);
         PostMessage(Handle, WM_NULL, 0, 0);
      end;
    end;
  end;
  inherited;
end;
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
