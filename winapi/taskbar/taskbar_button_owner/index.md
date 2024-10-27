---
Title: Кто владелец taskbar buttons (NT)?
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---

Кто владелец taskbar buttons (NT)?
==================================

В этой статье я хочу описать полезную недокументированную функцию GetTaskmanWindow.
Функция GetTaskmanWindow возвращает дескриптор окна,
которому принадлежат кнопки панели задач.
Вот цитата о панели задач из Microsoft MSDN:

> "Интерфейс Microsoft® Windows® включает специальную панель инструментов
> рабочего стола приложений, называемую панелью задач.
> Панель задач может использоваться для таких задач,
> как переключение между открытыми окнами и запуск новых приложений..."

и

> "Панель задач включает меню "Пуск", кнопки панели задач,
> контекстное меню и область состояния...".

К сожалению, Win32 API не содержит документированной функции,
которая может использоваться для доступа к панели задач,
поэтому нам снова придется использовать недокументированный способ.

Вот прототип для GetTaskmanWindow:

    function GetTaskmanWindow (): HWND;

Как всегда, Microsoft не предоставляет нам символы экспорта
в User32.lib для этой функции, поэтому мы должны загрузить их динамически с помощью
функций GetProcAddress и GetModuleHandle:

    {
      In this article, I wish to describe the useful undocumented function
      GetTaskmanWindow. The GetTaskmanWindow function returns a handle to
      the window that ownes the taskbar buttons.
      Here is the quoting about taskbar from Microsoft MSDN:
      "The Microsoft® Windows® interface includes a special application desktop
      toolbar called the taskbar.
      The taskbar can be used for such tasks as switching between open
      windows and starting new applications..."
      and "The taskbar includes the Start menu, taskbar buttons,
      a shortcut menu, and a status area...".
      Unfortunately, Win32 API doesn't contain documented
      function that can be used for accessing to the
      taskbar so we should again use an undocumented way.
     
      Here is the prototype for GetTaskmanWindow:
     
       function GetTaskmanWindow (): HWND;
     
      As always, Microsoft doesn't provide us with the exports symbols
      in the User32.lib for this function, so we should load them dynamically using the
      GetProcAddress and GetModuleHandle functions:
    }
     
    // getaskmanwnd.cpp (Windows NT/2000)
    //
    // This example will show you how you can obtain a handle to the
    // Windows Taskbar window.
    // Translated from C to Delphi by Thomas Stutz
    // Original Code:
    // (c)1999 Ashot Oganesyan K, SmartLine, Inc
    // mailto:ashot@aha.ru, http://www.protect-me.com, http://www.codepile.com
     
     
    function TaskmanWindow: HWND;
    type
      TGetTaskmanWindow = function(): HWND; stdcall;
    var
      hUser32: THandle;
      GetTaskmanWindow: TGetTaskmanWindow;
    begin
      Result := 0;
      hUser32 := GetModuleHandle('user32.dll');
      if (hUser32 > 0) then
      begin
        @GetTaskmanWindow := GetProcAddress(hUser32, 'GetTaskmanWindow');
        if Assigned(GetTaskmanWindow) then
        begin
          Result := GetTaskmanWindow;
        end;
      end;
    end;
     
    procedure ShowTaskmanWindow(bValue: Boolean);
    var
      hTaskmanWindow: Hwnd;
    begin
      hTaskmanWindow := TaskmanWindow;
      if hTaskmanWindow <> 0 then
      begin
        ShowWindow(GetParent(hTaskmanWindow), Ord(bValue));
      end;
    end;
     
    // Example to Hide the Taskman Window
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      ShowTaskmanWindow(False);
    end;

