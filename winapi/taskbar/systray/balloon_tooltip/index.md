---
Title: Как показать округленное окошко подсказки в трее в Windows 2000?
Date: 01.01.2007
Source: <https://forum.sources.ru>
---

Как показать округленное окошко подсказки в трее в Windows 2000?
================================================================

В Windows 2000, формат структуры NotifyIconData, которая используется
для работы с иконками в Трее (которая, кстати, называется "The Taskbar
Notification Area" :) значительно отличается от предыдущий версий
Windows.
Однако, эти изменения НЕ отражены в юните ShellAPI.pas в Delphi 5.

Итак, нам понадобится преобразованный SHELLAPI.H, в котором присутствуют
все необходимые объявления:

    uses Windows;
     
    type
      NotifyIconData_50 = record // определённая в shellapi.h
        cbSize: DWORD;
        Wnd: HWND;
        uID: UINT;
        uFlags: UINT;
        uCallbackMessage: UINT;
        hIcon: HICON;
        szTip: array[0..MAXCHAR] of AnsiChar;
        dwState: DWORD;
        dwStateMask: DWORD;
        szInfo: array[0..MAXBYTE] of AnsiChar;
        uTimeout: UINT; // union with uVersion: UINT;
        szInfoTitle: array[0..63] of AnsiChar;
        dwInfoFlags: DWORD;
      end{record};
     
    const
      NIF_INFO      = $00000010;
      NIIF_NONE     = $00000000;
      NIIF_INFO     = $00000001;
      NIIF_WARNING  = $00000002;
      NIIF_ERROR    = $00000003;
     
    А это набор вспомогательных типов:
     
    type
      TBalloonTimeout = 10..30{seconds};
      TBalloonIconType = (bitNone,    // нет иконки
                          bitInfo,    // информационная иконка (синяя)
                          bitWarning, // иконка восклицания (жёлтая)
                          bitError);  // иконка ошибки (краснаа)

Теперь мы готовы приступить к созданию округлённых подсказок!

Для этого воспользуемся следующей функцией:

    uses SysUtils, Windows, ShellAPI;
     
    function DZBalloonTrayIcon(const Window: HWND; const IconID: Byte;
                               const Timeout: TBalloonTimeout;
                               const BalloonText, BalloonTitle: String;
                               const BalloonIconType: TBalloonIconType): Boolean; 
    const
      aBalloonIconTypes : array[TBalloonIconType] of Byte =
                          (NIIF_NONE, NIIF_INFO, NIIF_WARNING, NIIF_ERROR);
    var
      NID_50 : NotifyIconData_50;
    begin
      FillChar(NID_50, SizeOf(NotifyIconData_50), 0);
      with NID_50 do begin
        cbSize := SizeOf(NotifyIconData_50);
        Wnd := Window;
        uID := IconID;
        uFlags := NIF_INFO;
        StrPCopy(szInfo, BalloonText);
        uTimeout := Timeout * 1000;
        StrPCopy(szInfoTitle, BalloonTitle);
        dwInfoFlags := aBalloonIconTypes[BalloonIconType];
      end{with};
      Result := Shell_NotifyIcon(NIM_MODIFY, @NID_50);
    end;

Вызывается она следующим образом:

    DZBalloonTrayIcon(Form1.Handle, 1, 10, 'this is the balloon text',
                      'title', bitWarning);

Иконка, должна быть предварительно добавлена с темже дескриптором окна и
IconID (в данном примере Form1.Handle и 1).

Можете попробовать все три типа иконок внутри всплывающей подсказки.

P.S. На всякий случай, ниже представлены функции для добавление/удаления
иконок в трее:

    uses SysUtils, Windows, ShellAPI;
     
    {добавление иконки}
    function DZAddTrayIcon(const Window: HWND;
                           const IconID: Byte;
                           const Icon: HICON;
                           const Hint: String = ''): Boolean;
    var 
      NID : NotifyIconData;
    begin
      FillChar(NID, SizeOf(NotifyIconData), 0);
      with NID do begin
        cbSize := SizeOf(NotifyIconData);
        Wnd := Window;
        uID := IconID;
        if Hint = '' then begin
          uFlags := NIF_ICON;
        end{if} else begin
          uFlags := NIF_ICON or NIF_TIP;
          StrPCopy(szTip, Hint);
        end{else};
        hIcon := Icon;
      end{with};
      Result := Shell_NotifyIcon(NIM_ADD, @NID);
    end;
     
    {добавляет иконку с call-back сообщением}
    function DZAddTrayIconMsg(const Window: HWND;
                              const IconID: Byte;
                              const Icon: HICON;
                              const Msg: Cardinal;
                              const Hint: String = ''): Boolean;
    var
      NID : NotifyIconData;
    begin
      FillChar(NID, SizeOf(NotifyIconData), 0);
      with NID do begin
        cbSize := SizeOf(NotifyIconData);
        Wnd := Window;
        uID := IconID;
        if Hint = '' then begin
          uFlags := NIF_ICON or NIF_MESSAGE;
        end{if} else begin
          uFlags := NIF_ICON or NIF_MESSAGE or NIF_TIP;
          StrPCopy(szTip, Hint);
        end{else};
        uCallbackMessage := Msg;
        hIcon := Icon;
      end{with};
      Result := Shell_NotifyIcon(NIM_ADD, @NID);
    end;
     
    {удаляет иконку}
    function DZRemoveTrayIcon(const Window: HWND;
                              const IconID: Byte): Boolean;
    var
      NID : NotifyIconData;
    begin
      FillChar(NID, SizeOf(NotifyIconData), 0);
      with NID do begin
        cbSize := SizeOf(NotifyIconData);
        Wnd := Window;
        uID := IconID;
      end{with};
      Result := Shell_NotifyIcon(NIM_DELETE, @NID);
    end;

Несколько заключительных замечаний:

1. Нет необходимости использовать большую структуру NotifyIconData\_50
для добавления или удаления иконок, старая добрая структура
NotifyIconData прекрасно подойдёт для этого.

2. Для callback сообщения можно использовать WM\_APP + что-нибудь.

3. Используя различные IconID, легко можно добавить несколько различных
иконок из одного родительского окна и работать с ними по их IconID.

