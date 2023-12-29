---
Title: Как свернуть прогу в tray?
Author: Vit
Date: 01.01.2007
---

Как свернуть прогу в tray?
==========================

::: {.date}
01.01.2007
:::

Проще всего использовать RxTrayIcon компонент из библиотеки RxLib

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

Автор: Vit

Взято с Vingrad.ru <https://forum.vingrad.ru>

------------------------------------------------------------------------

Нет такого понятия "свернуть в трей". Есть возможность только
добавлять, удалять и менять значок в области трея. Сама же программа
просто прячется.

Для изменения значка в трее используется класс TShellNotifyIcon модуля
ShellApi

Объявим следующую процедруру:

Параметры к ней такие: n - номер операции ( 1 - добавить, 2 - удалить, 3
- заменить) и Icon - сама иконка с которой будет делаться эта операция

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

Теперь, нам нужно отловить минимизацию приложения, для того, чтобы
заменить стандартное действие Windows на "свёртывание в трей".
Объявляем в секции protected процедуру

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

Теперь нам нужно, чтобы значок в трее мог реагировать на манипуляции с
ним. Если Вы внимательно посмотрите процедру Ic(), то Вы увидите там
ссылку на сообщение WM\_USER+1. Это не что иное, как сообщение, которое
приходит нам от этого значка. Обычно для значка в трее делают
всплывающее меню и выводят там те или иные действия. Но TPopUpMenu
делается обычно для правой кнопки, по левой же просто активируют
приложение. На форму кидаем комопонент TPopUpMenu (пусть это будет
PopUpMenu1) и заносим в него все пункты меню, которые мы хотим, чтобы
онм появилис в меню, которое будет всплывать по нажатию правой кнопки на
значке.

После этого описываем обработчик: В вышеназванную секцию protected
добавляем ещё одну процедуру IconMouse, которая будет реагировать на
сообщение WM\_USER+1

    protected
      procedure ControlWindow(var Msg: TMessage); message WM_SYSCOMMAND;
      procedure IconMouse(var Msg: TMessage); message WM_USER + 1;

   Теперь описываем собственно процедуру.

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

Для выполнения пунктов всплывающего меню, пишите стандартные обработчики
onClick() для его пунктов.

Данный опус писался только в форме, в IDE не тестировался . Всё работает
конечно, но не обессудьте, если будут ошибочки мелкие.

Автор: Song

Взято с Vingrad.ru <https://forum.vingrad.ru>

------------------------------------------------------------------------

Для  работы  с  SystemTray  существует всего одна функция. Вот ее

Си-прототип:

           WINSHELLAPI BOOL WINAPI Shell_NotifyIcon(
                                   DWORD dwMessage,      // message identifier
                                   PNOTIFYICONDATA pnid  // pointer to structure);

Эта  функция описана в заголовочном файле Win32-SDK " shellapi.h",

включаемом   в  программу  при  включении  " windows.h" .  Параметр

dwMessage   может  принимать  одно  из  трех  значений:  NIM\_ADD,

NIM\_DELETE,  NIM\_MODIFY.  Для  добавления  иконки  он должен быть

установлен в NIM\_ADD.

Параметр pnid имеет тип PNOTIFYDATA, который описан как:

           typedef struct _NOTIFYICONDATA { // nid
                                           DWORD cbSize;
                                           HWND hWnd;
                                           UINT uID;
                                           UINT uFlags;
                                           UINT uCallbackMessage;
                                           HICON hIcon;
                                           char szTip[64];
                                          } NOTIFYICONDATA, *PNOTIFYICONDATA;

    Поля структуры NOTIFYICONDATA имеют следующий смысл:

        cbSize          - размер структуры, должен быть

                          sizeof(NOTIFYICONDATA).

        hWnd            - дескриптор окна, которое будет получать
события

                          мыши над иконкой.

        uID             - уникальный идентификатор иконки. Идентификатор

                          должен быть уникален в пределах окна - обрабо-

                          тчика, передаваемого в hWnd.

        uFlags          - битовое поле, определяющее какое из следующих

                          полей несет действительную информацию.

                          Может быть одним из следующих значений:
NIF\_ICON,

                          NIF\_MESSAGE, NIF\_TIP или их OR-комбинацией.

       uCallbackMessage - сообщение, передаваемое окну - обработчику при

                          событиях мыши. Желательно получать номер

                          сообщения вызовом RegisterWindowMessage(),

                          но допускаются и значения WM\_USER+N, где N
\>  0.

       hIcon            - дескриптор иконки, помещаемой на Tray.

       szTip            - текст для ToolTip\'а, если szTip\[0\] = 0x00,
то

                          ToolTip\'а не будет.

    Таким   образом,   для   добавления  иконки  на  Tray  необходимо

    заполнить  экземпляр  структуры  NOTIFYICONDATA и вызвать функцию

    Shell\_NotifyIcon()   с   параметром   NIM\_ADD   и  указателем  на

    заполненный экземпляр структуры.

      При  добавлении  иконки необходимо заполнить поля cbSize, hWnd,

    uID,  uFlags,  uCallbackMessage, hIcon. Поле szTip можно оставить

    пустым,  если  вам не нужен ToolTip. Поле uFlags должно содержать

    как минимум NIF\_MESSAGE \| NIF\_ICON.

Взято из FAQ:

<https://blackman.km.ru/myfaq/cont4.phtml%5Dhttp://blackman.km.ru/myfaq/cont4.phtml>
