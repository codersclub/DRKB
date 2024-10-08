---
Title: Использование Hook в Delphi
Author: StayAtHome
Date: 01.01.2007
Source: Vingrad.ru <https://forum.vingrad.ru>
---


Использование Hook в Delphi
===========================

**Что такое НООК?**

НООК - это механизм перехвата сообщений, предоставляемый системой
Microsoft Windows. Программист пишет специального вида функцию
(НООК-функция), которая затем при помощи функции SetWindowsHookEx
вставляется на верх стека НООК-функций системы. Ваша НООК-функция сама
решает, передать ли ей сообщение в следующую НООК-функцию при помощи
CallNextHookEx или нет.

**Какие бывает НООК\'и?**

НООК бывают глобальные, контролирующие всю систему, так и локальные,
ориентированные на какой-либо поток (Thread). Кроме того НООК
различаются по типу перехватываемых сообщений (подробнее об этом -
ниже). НООК несколько подтормаживают систему, поэтому ставить их
рекомендуется только при необходимости, и кактолько необходимость в них
отпадает - удалять.

**Как создавать НООК?**

НООК устанавливается в систему при помощи функции SetWindowsHookEx, вот
её заголовок:

    function SetWindowsHookEx(idHook: Integer; lpfn: TFNHookProc;
             hmod: HINST; dwThreadId: DWORD): HHOOK;

idHook - константа, определяющая тип вставляемого НООК\'а, должна быть одна из
нижеследующих констант:

WH\_CALLWNDPROC - вставляемая НООК-функция следит за всеми сообщения перед их отпралением
в соответствующую оконную функцию

WH\_CALLWNDPROCRET - вставляемая НООК-функция следит за всеми сообщениями после их
отправления в оконную функцию

WH\_CBT -
вставляемая НООК-функция следит за окнами, а именно: за созданием,
активацией, уничтожением, сменой размера; перед завершением системной
команды меню, перед извлечением события мыши или клавиатуры из очереди
сообщений, перед установкой фокуса и т.д.

WH\_DEBUG -
вставляемая НООК-функция следит за другими НООК-функциями.

WH\_GETMESSAGE -
вставляемая НООК-функция следит за сообщениями, посылаемыми в очередь
сообщений.

WH\_JOURNALPLAYBACK -
вставляемая НООК-функция посылает сообщения, записанные до этого
WH\_JOURNALRECORD НООК\'ом.

WH\_JOURNALRECORD -
эта НООК-функция записывает все сообщения куда-либо в специальном
формате, причем позже они могут быть "воспроизведены" при помощи
НООК\'а WH\_JOURNALPLAYBACK. Это в некотором роде аналог магнитофонной
записи сообщений.

WH\_KEYBOARD -
вставляемая НООК-функция следит за сообщениями клавиатуры

WH\_MOUSE -
вставляемая НООК-функция следит за сообщениями мыши

WH\_MSGFILTER

WH\_SHELL

WH\_SYSMSGFILTER

lpfn -
указатель на непосредственно функцию. Обратите внимание, что если Вы
ставите глобальный НООК, то НООК-функция обязательно должна находиться в
некоторой DLL!!!

hmod -
описатель DLL, в которой находится код функции.

dwThreadId -
идентификатор потока, в который вставляется НООК

Подробнее о НООК-функциях смотри справку по Win32API.

**Как удалять НООК?**

НООК удаляется при помощи функции UnHookWindowsEx.

**Пример использования НООК.**

Ставим НООК, следящий за мышью (WH\_MOUSE). Программа следит за нажатием
средней кнопки мыши, и когда она нажимается, делает окно, находящееся
непосредственно под указателем, поверх всех остальных (TopMost). Код
самой НООК-функции помещен в библиотеку lib2.dll, туда же помещены и
функции Start - для установки НООК, и Remove - для удаления НООК.

Файл sticker.dpr

    program sticker;
     uses windows, messages;
    var
     wc : TWndClassEx;
     MainWnd : THandle;
     Mesg : TMsg;
    //экспортируем две функции из библиотеки с НООК'ами
    procedure Start; external 'lib2.dll' name 'Start';
    procedure Remove; external 'lib2.dll' name 'Remove';
     
    function WindowProc(wnd:HWND; Msg : Integer; Wparam:Wparam; Lparam:Lparam):Lresult; stdcall;
    var
     nCode, ctrlID : word;
    Begin
     case msg of
     wm_destroy :
       Begin
       Remove;//удаляем НООК
       postquitmessage(0); exit;
       Result:=0;
       End;
     else
       Result:=DefWindowProc(wnd,msg,wparam,lparam);
     end;
    End;
     
    begin
     wc.cbSize:=sizeof(wc);
     wc.style:=cs_hredraw or cs_vredraw;
     wc.lpfnWndProc:=@WindowProc;
     wc.cbClsExtra:=0;
     wc.cbWndExtra:=0;
     wc.hInstance:=HInstance;
     wc.hIcon:=LoadIcon(0,idi_application);
     wc.hCursor:=LoadCursor(0,idc_arrow);
     wc.hbrBackground:=COLOR_BTNFACE+1;
     wc.lpszMenuName:=nil;
     wc.lpszClassName:='WndClass1';
     
     RegisterClassEx(wc);
     
     MainWnd:=CreateWindowEx(0,'WndClass1','Caption',ws_overlappedwindow,
               cw_usedefault,cw_usedefault,cw_usedefault,cw_usedefault,0,0,
               Hinstance,nil);
     ShowWindow(MainWnd,CmdShow);
     Start;//вставляем НООК
     
     While GetMessage(Mesg,0,0,0) do
      begin
      TranslateMessage(Mesg);
      DispatchMessage(Mesg);
      end;
    end.
     

Файл lib2.dpr

    library lib2;
    uses
     windows, messages;
    var
     pt : TPoint;
     theHook : THandle;
    function MouseHook(nCode, wParam, lParam : integer) : Lresult; stdcall;
    var
     msg : PMouseHookStruct;
     w : THandle;
     style : integer;
    Begin
     if nCode<0 then
       begin
       result := CallNextHookEx(theHook, nCode, wParam, lParam);
       Exit;
       end;
     msg := PMouseHookStruct(lParam);
     case wParam of
     WM_MBUTTONDOWN :
       pt := msg^.pt;
     WM_MBUTTONUP :
       begin
       w := WindowFromPoint(pt);
       style := GetWindowLong(w, GWL_EXSTYLE);
       if (style and WS_EX_TOPMOST) <> 0 then
         begin //уже поверх всех - сделать обычным
         ShowWindow(w, sw_hide);
         SetWindowPos(w, HWND_NOTOPMOST, 0,0,0,0, SWP_NOMOVE or SWP_NOSIZE OR SWP_SHOWWINDOW);
         end
       else
         begin //сделать поверх остальных
         ShowWindow(w, sw_hide);
         SetWindowPos(w, HWND_TOPMOST, 0,0,0,0, SWP_NOMOVE OR SWP_NOSIZE OR SWP_SHOWWINDOW);
         end;
       end;
     end;
     Result := CallNextHookEx(theHook, nCode, wParam, lParam);
    End;
     
    procedure Start;
    begin
     theHook := SetWindowsHookEx(wh_mouse, @mouseHook, hInstance, 0);
     if theHook = 0 then
       messageBox(0,'Error!','Error!',mb_ok);
    end;
     
    procedure Remove;
    begin
     UnhookWindowsHookEx(theHook);
    end;
     
    exports
     Start index 1 name 'Start',
     Remove index 2 name 'Remove';
    end.

Всё.

(С) Автор статьи: Sergey Stolyarov

Development и Дельфи (http://MDelphi.far.ru).
