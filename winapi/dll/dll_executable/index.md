---
Title: Как написать DLL, которую можно было бы выполнить с помощью RunDll, RunDll32?
Date: 01.01.2007
---


Как написать DLL, которую можно было бы выполнить с помощью RunDll, RunDll32?
=============================================================================

Вариант 1:

Author: Oleg Moroz (2:5020/701.22)

Вы должны определить в программе вызываемую снаружи функцию.

Функция должна быть `__stdcall` (или `WINAPI`, что то же самое ;)) и иметь
четыре аргумента.

Первый - HWND окна, порождаемого rundll32 (можно
использовать в качестве owner\'а своих dialog box\'ов),

второй - HINSTANCE задачи,

третий - остаток командной строки (LPCSTR, даже под NT),

четвертый - не знаю ;).

Hапример,

    int __stdcall __declspec(dllexport) Test ( 
      HWND hWnd, 
      HINSTANCE hInstance, 
      LPCSTR lpCmdLine, 
      DWORD dummy 
      ) 
    { 
      MessageBox(hWnd, lpCmdLine, "Command Line", MB_OK); 
      return 0; 
    } 

Командная строка

    rundll32 test.dll,_Test@16 this is a command line

выдаст message box со строкой "this is a command line".


---------------------------------------------------

Вариант 2:

Author: Akzhan Abdulin (2:5040/55)

    function Test(
      hWnd: Integer;
      hInstance: Integer;
      lpCmdLine: PChar;
      dummy: Longint
      ): Integer; stdcall; export;
    begin
      Windows.MessageBox(hWnd, lpCmdLine, 'Command Line', MB_OK);
      Result := 0;
    end;


------------------------------------------------------

Вариант 3:

Author: Alexey A Popoff (pvax@glas.apc.org, posp@ccas.ru)

Давненько я ждал эту инфоpмацию! Сел пpовеpять и наткнулся на очень
забавную вещь. А именно - пусть у нас есть исходник на Си пpимеpно
такого вида:

    int WINAPI RunDll( HWND hWnd, HINSTANCE hInstance, LPCSTR lpszCmdLine,
        DWORD dummy )
    ......
    
    int WINAPI RunDllW( HWND hWnd, HINSTANCE hInstance, LPCWSTR lpszCmdLine,
        DWORD dummy )
    ......

и .def-файл пpимеpно такого вида:

    EXPORTS
       RunDll
       RunDllA=RunDll
       RunDllW

то rundll32 становится pазбоpчивой - под HТ вызывает
UNICODE-веpсию. Под 95, pазумеется, ANSI.

Rulez.

Alexey A Popoff

pvax@glas.apc.org, posp@ccas.ru

https://www.ccas.ru/~posp/popov/pvax.html

(2:5020/487.26) Администрирование
