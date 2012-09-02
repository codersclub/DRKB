<h1>Кнопки в панели задач</h1>
<div class="date">01.01.2007</div>


<pre>
// Это необходимо объявить в секции public в верхней части вашего pas-файла
procedure TForm1.IconCallBackMessage( var Mess : TMessage ); message WM_USER + 100;
 
 
 
 
 
procedure TForm1.FormCreate(Sender: TObject);
var
 
  nid: TNotifyIconData;
begin
 
  with nid do
  begin
    cbSize := SizeOf(TNotifyIconData);
    Wnd := Form1.Handle;
    uID := 1;
    uFlags := NIF_ICON or NIF_MESSAGE or NIF_TIP;
    uCallbackMessage := WM_USER + 100;
    hIcon := Application.Icon.Handle;
    szTip := 'Текст всплывающей подсказки';
  end;
  Shell_NotifyIcon(NIM_ADD, @nid);
end;
 
procedure TForm1.FormClose(Sender: TObject; var Action: TCloseAction);
var
 
  nid: TNotifyIconData;
begin
 
  with nid do
  begin
    cbSize := SizeOf(TNotifyIconData);
    Wnd := Form1.Handle;
    uID := 1;
    uFlags := NIF_ICON or NIF_MESSAGE or NIF_TIP;
    uCallbackMessage := WM_USER + 100;
    hIcon := Application.Icon.Handle;
    szTip := 'Текст всплывающей подсказки';
    // Все, что указано выше, не является обязательным
 
  end;
  Shell_NotifyIcon(NIM_DELETE, @nid);
end;
 
procedure TForm1.IconCallBackMessage(var Mess: TMessage);
var
 
  sEventLog: string;
begin
 
  case Mess.lParam of
    // Сделайте здесь все что вы хотите. Например,
    // вызов контекстного меню при нажатии правой кнопки мыши.
 
    WM_LBUTTONDBLCLK: sEventLog := 'Двойной щелчок левой кнопкой';
    WM_LBUTTONDOWN: sEventLog := 'Нажатие левой кнопки мыши';
    WM_LBUTTONUP: sEventLog := 'Отжатие левой кнопки мыши';
    WM_MBUTTONDBLCLK: sEventLog := 'Двойной щелчок мышью';
    WM_MBUTTONDOWN: sEventLog := 'Нажатие кнопки мыши';
    WM_MBUTTONUP: sEventLog := 'Отжатие кнопки мыши';
    WM_MOUSEMOVE: sEventLog := 'перемещение мыши';
    WM_MOUSEWHEEL: sEventLog := 'Вращение колесика мыши';
    WM_RBUTTONDBLCLK: sEventLog := 'Двойной щелчок правой кнопкой';
    WM_RBUTTONDOWN: sEventLog := 'Нажатие правой кнопки мыши';
    WM_RBUTTONUP: sEventLog := 'Отжатие правой кнопки мыши';
  end;
end;
 
 
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
