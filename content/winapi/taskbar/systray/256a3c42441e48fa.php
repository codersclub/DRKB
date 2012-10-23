<h1>Как свернуть прогу в tray?</h1>
<div class="date">01.01.2007</div>



<p>Проще всего использовать RxTrayIcon компонент из библиотеки RxLib</p>
<pre>
procedure TForm1.ApplicationMinimize(Sender : TObject);

 
begin
RxTrayIcon1.Show;
ShowWindow(Application.Handle,SW_HIDE);
end;
 
procedure TForm1.RxTrayIcon1Click(Sender: TObject; Button: TMouseButton; Shift: TShiftState; X, Y: Integer);
begin
Application.Restore;
SetForeGroundWindow(Application.MainForm.Handle);
RxTrayIcon1.Hide;
end;
</pre>


<div class="author">Автор: Vit</div>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>

<hr />Нет такого понятия "свернуть в трей". Есть возможность только добавлять, удалять и менять значок в области трея. Сама же программа просто прячется.</p>
<p>Для изменения значка в трее используется класс TShellNotifyIcon модуля ShellApi</p>
<p>Объявим следующую процедруру:</p>
<p>Параметры к ней такие: n - номер операции ( 1 - добавить, 2 - удалить, 3 - заменить) и Icon - сама иконка с которой будет делаться эта операция</p>
<pre>
Procedure TForm1.Ic(n:Integer;Icon:TIcon);
  Var Nim:TNotifyIconData;
begin
With Nim do
Begin
cbSize:=SizeOf(Nim);
Wnd:=Form1.Handle;
uID:=1;
uFlags:=NIF_ICON or NIF_MESSAGE or NIF_TIP;
hicon:=Icon.Handle;
uCallbackMessage:=wm_user+1;
szTip:='Хинт, который будет появляться у значка';
End;
Case n OF
1: Shell_NotifyIcon(Nim_Add,@Nim);
2: Shell_NotifyIcon(Nim_Delete,@Nim);
3: Shell_NotifyIcon(Nim_Modify,@Nim);
End;
end;
</pre>


<p>Теперь, нам нужно отловить минимизацию приложения, для того, чтобы заменить стандартное действие Windows на "свёртывание в трей". Объявляем в секции protected процедуру</p>
<pre>
protected
 
procedure ControlWindow(var Msg: TMessage); message WM_SYSCOMMAND;
...
    procedure TForm1.ControlWindow(var Msg: TMessage);
  begin
    if Msg.WParam = SC_MINIMIZE then
      begin
        Ic(1, Application.Icon); // Добавляем значок в трей
        ShowWindow(Handle, SW_HIDE); // Скрываем программу
      end
    else
      inherited;
  end;
</pre>


<p>Теперь нам нужно, чтобы значок в трее мог реагировать на манипуляции с ним. Если Вы внимательно посмотрите процедру Ic(), то Вы увидите там ссылку на сообщение WM_USER+1. Это не что иное, как сообщение, которое приходит нам от этого значка. Обычно для значка в трее делают всплывающее меню и выводят там те или иные действия. Но TPopUpMenu делается обычно для правой кнопки, по левой же просто активируют приложение. На форму кидаем комопонент TPopUpMenu (пусть это будет PopUpMenu1) и заносим в него все пункты меню, которые мы хотим, чтобы онм появилис в меню, которое будет всплывать по нажатию правой кнопки на значке.</p>
<p>После этого описываем обработчик: В вышеназванную секцию protected добавляем ещё одну процедуру IconMouse, которая будет реагировать на сообщение WM_USER+1</p>

<pre>
protected
  procedure ControlWindow(var Msg: TMessage); message WM_SYSCOMMAND;
  procedure IconMouse(var Msg: TMessage); message WM_USER + 1;
</pre>
<p> &nbsp;&nbsp; Теперь описываем собственно процедуру.</p>

<pre>
    procedure TForm1.IconMouse(var Msg: TMessage);
    var p: tpoint;
    begin
      GetCursorPos(p); // Запоминаем координаты курсора мыши
      case Msg.LParam of // Проверяем какая кнопка была нажата
        WM_LBUTTONUP, WM_LBUTTONDBLCLK: {Действия, выполняемый по одинарному или двойному щел?ку левой кнопки мыши на зна?ке. В нашем слу?ае это просто активация приложения}
          begin
            Ic(3, Applicattion.Icon); // Удаляем зна?ок из трея
            ShowWindow(Application.Handle, SW_SHOWNORMAL); // Восстанавливаем окно программы
          end;
        WM_RBUTTONUP: {Действия, выполняемый по одинарному щел?ку правой кнопки мыши}
          begin
            SetForegroundWindow(Handle); // Восстанавливаем программу в ка?естве переднего окна
            PopupMenu1.Popup(p.X, p.Y); // Заставляем всплыть тот самый TPopUp о котором я говорил ?уть раньше
            PostMessage(Handle, WM_NULL, 0, 0) // Обнуляем сообщение
          end;
      end;
    end;
</pre>

<p>Для выполнения пунктов всплывающего меню, пишите стандартные обработчики onClick() для его пунктов.</p>

<p>Данный опус писался только в форме, в IDE не тестировался . Всё работает конечно, но не обессудьте, если будут ошибочки мелкие.</p>
<div class="author">Автор: Song</div>

<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>

<hr />Для&nbsp; работы&nbsp; с&nbsp; SystemTray&nbsp; существует всего одна функция. Вот ее</p>
<p>Си-прототип:</p>
<pre>
       WINSHELLAPI BOOL WINAPI Shell_NotifyIcon(
                               DWORD dwMessage,      // message identifier
                               PNOTIFYICONDATA pnid  // pointer to structure);
</pre>

<p>Эта&nbsp; функция описана в заголовочном файле Win32-SDK " shellapi.h" ,</p>
<p>включаемом&nbsp;&nbsp; в&nbsp; программу&nbsp; при&nbsp; включении&nbsp; " windows.h" .&nbsp; Параметр</p>
<p>dwMessage&nbsp;&nbsp; может&nbsp; принимать&nbsp; одно&nbsp; из&nbsp; трех&nbsp; значений:&nbsp; NIM_ADD,</p>
<p>NIM_DELETE,&nbsp; NIM_MODIFY.&nbsp; Для&nbsp; добавления&nbsp; иконки&nbsp; он должен быть</p>
<p>установлен в NIM_ADD.</p>
<p>Параметр pnid имеет тип PNOTIFYDATA, который описан как:</p>
<pre>
       typedef struct _NOTIFYICONDATA { // nid
                                       DWORD cbSize;
                                       HWND hWnd;
                                       UINT uID;
                                       UINT uFlags;
                                       UINT uCallbackMessage;
                                       HICON hIcon;
                                       char szTip[64];
                                      } NOTIFYICONDATA, *PNOTIFYICONDATA;
</pre>

<p> &nbsp;&nbsp;&nbsp; Поля структуры NOTIFYICONDATA имеют следующий смысл:</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; cbSize&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - размер структуры, должен быть</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; sizeof(NOTIFYICONDATA).</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; hWnd&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - дескриптор окна, которое будет получать события</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; мыши над иконкой.</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; uID&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - уникальный идентификатор иконки. Идентификатор</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; должен быть уникален в пределах окна - обрабо-</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; тчика, передаваемого в hWnd.</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; uFlags&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - битовое поле, определяющее какое из следующих</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; полей несет действительную информацию.</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Может быть одним из следующих значений: NIF_ICON,</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NIF_MESSAGE, NIF_TIP или их OR-комбинацией.</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; uCallbackMessage - сообщение, передаваемое окну - обработчику при</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; событиях мыши. Желательно получать номер</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; сообщения вызовом RegisterWindowMessage(),</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; но допускаются и значения WM_USER+N, где N &gt;&nbsp; 0.</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; hIcon&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - дескриптор иконки, помещаемой на Tray.</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; szTip&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - текст для ToolTip'а, если szTip[0] = 0x00, то</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ToolTip'а не будет.</p>
<p> &nbsp;&nbsp;&nbsp; Таким&nbsp;&nbsp; образом,&nbsp;&nbsp; для&nbsp;&nbsp; добавления&nbsp; иконки&nbsp; на&nbsp; Tray&nbsp; необходимо</p>
<p> &nbsp;&nbsp;&nbsp; заполнить&nbsp; экземпляр&nbsp; структуры&nbsp; NOTIFYICONDATA и вызвать функцию</p>
<p> &nbsp;&nbsp;&nbsp; Shell_NotifyIcon()&nbsp;&nbsp; с&nbsp;&nbsp; параметром&nbsp;&nbsp; NIM_ADD&nbsp;&nbsp; и&nbsp; указателем&nbsp; на</p>
<p> &nbsp;&nbsp;&nbsp; заполненный экземпляр структуры.</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; При&nbsp; добавлении&nbsp; иконки необходимо заполнить поля cbSize, hWnd,</p>
<p> &nbsp;&nbsp;&nbsp; uID,&nbsp; uFlags,&nbsp; uCallbackMessage, hIcon. Поле szTip можно оставить</p>
<p> &nbsp;&nbsp;&nbsp; пустым,&nbsp; если&nbsp; вам не нужен ToolTip. Поле uFlags должно содержать</p>
<p> &nbsp;&nbsp;&nbsp; как минимум NIF_MESSAGE | NIF_ICON.</p>

<p>Взято из FAQ:</p>
<a href="https://blackman.km.ru/myfaq/cont4.phtml]http://blackman.km.ru/myfaq/cont4.phtml" target="_blank">https://blackman.km.ru/myfaq/cont4.phtml]http://blackman.km.ru/myfaq/cont4.phtml</a></p>

