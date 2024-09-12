---
Title: Убиваем активное приложение
Author: Dale Berry
Date: 10.10.2000
Source: <https://forum.sources.ru>
---

Убиваем активное приложение
===========================

Вариант 1:

Данная функция позволяет завершить выполнение любой активной программы
по её classname или заголовку окна.

    procedure KillProgram(Classname : string; WindowTitle : string); 
    const 
      PROCESS_TERMINATE = $0001; 
    var 
      ProcessHandle : THandle; 
      ProcessID: Integer; 
      TheWindow : HWND; 
    begin 
      TheWindow := FindWindow(Classname, WindowTitle); 
      GetWindowThreadProcessID(TheWindow, @ProcessID); 
      ProcessHandle := OpenProcess(PROCESS_TERMINATE, FALSE, ProcessId); 
      TerminateProcess(ProcessHandle,4); 
    end;

----------------------------------------------------

Вариант 2:

Author: Xianguang Li (22 Октября 2000):

Комментарий:

В Delphi 5, при компиляции получается следующая ошибка :

    Incompatible types: 'String' and 'PChar'.

После изменения выражения

    TheWindow := FindWindow(ClassName, WindowTitle)

на

    TheWindow := FindWindow(PChar(ClassName), PChar(WindowTitle)),

Нормально откомпилировалось.

И ещё: если мы не знаем ClassName или WindowTitle программы, которую мы
хотим убить, то мы не сможем её завершить.
Причина в том, что нельзя вызвать функцию в виде:

    KillProgram(nil, WindowTitle)

или

    KillProgram(ClassName, nil).

Компилятор не позволяет передать nil в переменную типа String.

Итак, я изменил объявление

    KillProgram(ClassName: string; WindowTitle: string)

на

    KillProgram(ClassName: PChar; WindowTitle: PChar),

вот теперь функция действительно может завершить любое приложение, если
вы не знаете ClassName или WindowTitle этого приложения.

