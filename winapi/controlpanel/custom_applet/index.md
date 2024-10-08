---
Title: Свои апплеты в панели управления
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Свои апплеты в панели управления
================================

Компилятор: Delphi 3.x

Источник: www.borland.com.

**Примечание Vit**

> Более поздние версии Дельфи имеют встроенные средства для создания
> апплетов - см. New Project-\>Other-\>Control Panel...

Апплеты в панели управления, это обычные DLL, имеющие расширение .cpl
(Control Panel Library) и располагающиеся в системной директории
Windows. В свою очередь, в каждом файле cpl может храниться несколько
апплетов. Cpl имеет единственную функцию точки входа CPlApplet(), через
которую поступают все сообщения от панели управления.

Давайте рассмотрим сообщения, с которыми панель управления вызывает
функцию CPlApplet():

CPL\_INIT - сообщение, которым CPlApplet() вызывается первый раз
(инициализация). Возвращаем TRUE для продолжения процесса загрузки.

CPL\_GETCOUNT - этим сообщением панель управления запрашивает количество
поддерживаемых апплетов в файле cpl.

CPL\_INQUIRE - панель управления запрашивает информацию о каждом
апплете, хранящемся в файле cpl. При этом, параметр lParam1 будет
содержать номер апплета, о котором панель управления хочет получить
информацию, lParam2 будет указывать на структуру TCplInfo. Поле idIcon в
структуре TClpInfo должно содержать идентификатор (id) ресурса иконки,
которая будет отображаться в панели управления, а поля idName и idInfo
должны содержать идентификаторы строковых ресурсов для имени и описания.
lData может содержать данные, которые будут использоваться апплетом.

CPL\_SELECT - это сообщение посылается апплету, если его иконка была
выбрана пользователем. При этом lParam1 содержит номер выбранного
апплета, а lParam2 содержит значение lData, определённое для данного
апплета.

CPL\_DBLCLK - это сообщение будет послано, если по иконке апплета
сделать двойной щелчёк. lParam1 будет содержать номер апплета, а lParam2
будет содержать значение lData, определённое для данного апплета. При
поступление это сообщения апплет должен как-то показать себя, в
частности отобразить своё диалоговое окно.

CPL\_STOP - Посылается каждому апплету, когда панель управления
закрывается. lParam1 содержит номер апплета, а lParam2 содержит значение
lData, определённое для данного апплета.

CPL\_EXIT - Посылается перед тем, как панель управления вызовет
FreeLibrary.

CPL\_NEWINQUIRE - тоже, что и CPL\_INQUIRE за исключением того, что
lParam2 указывает на структуру NEWCPLINFO.

Итак, приступим. Для начала необходимо создать файл ресурсов, содержащий
таблицу строк для имени и описания Вашего апплета(ов), а также иконки
для каждого апплета (если у Вас их будет несколько).

Пример .rc файла содержит таблицу строк, состоящую из двух строк, и
указатель на файл с иконкой:

    STRINGTABLE
    {
    1, "TestApplet"
    2, "My Test Applet"
    }

    2 ICON C:\SOMEPATH\CHIP.ICO

Чтобы преобразовать файл .rc в .res, (который можно будет спокойно
прилинковать к Вашему приложению) достаточно просто указать в командной
строке полный путь до компилятора ресурсов и полный путь до файла .rc:

    c:\Delphi\Bin\brcc32.exe c:\Delphi\MyRes.rc

После того, как компиляция будет завершена, то Вы получите новый файл, с
таким же именем, что и .rc, только с расширением ".res".

Следующий пример, это апплет панели управления, который в ответ на
сообщение CPL\_DBLCLK запускает блокнот. Код можно легко изменить, чтобы
отображалась форма или диалоговое окошко. Этот код можно компилировать
как под платформу Win32, так и под Win16.

Чтобы скомпилировать проект, необходимо из вышеприведённого файла .rc
создать два: TCPL32.RES и TCPL16.RES.

     
    library TestCpl;
     
    {$IFDEF WIN32}
    uses
      SysUtils,
      Windows,
      Messages;
    {$ELSE}
    uses
      SysUtils,
      WinTypes,
      WinProcs,
      Messages;
    {$ENDIF}
     
    {$IFDEF WIN32}
     {$R TCPL32.RES}
    {$ELSE}
     {$R TCPL16.RES}
    {$ENDIF}
     
    const NUM_APPLETS = 1;
     
    {$IFDEF WIN32}
     const CPL_DYNAMIC_RES = 0;
    {$ENDIF}
    const CPL_INIT = 1;
    const CPL_GETCOUNT = 2;
    const CPL_INQUIRE = 3;
    const CPL_SELECT = 4;
    const CPL_DBLCLK = 5;
    const CPL_STOP = 6;
    const CPL_EXIT = 7;
    const CPL_NEWINQUIRE = 8;
    {$IFDEF WIN32}
     const CPL_STARTWPARMS = 9;
    {$ENDIF}
    const CPL_SETUP = 200;
     
    {$IFNDEF WIN32}
    type DWORD = LongInt;
    {$ENDIF}
     
    type TCplInfo = record
           idIcon : integer;
           idName : integer;
           idInfo : integer;
           lData : LongInt;
         end;
         PCplInfo = ^TCplInfo;
     
    type TNewCplInfoA = record
           dwSize : DWORD;
           dwFlags : DWORD;
           dwHelpContext : DWORD;
           lData : LongInt;
           IconH : HIcon;
           szName : array [0..31] of char;
           szInfo : array [0..63] of char;
           szHelpFile : array [0..127] of char;
         end;
         PNewCplInfoA = ^TNewCplInfoA;
     
    {$IFDEF WIN32}
    type TNewCplInfoW = record
           dwSize : DWORD;
           dwFlags : DWORD;
           dwHelpContext : DWORD;
           lData : LongInt;
           IconH : HIcon;
           szName : array [0..31] of WChar;
           szInfo : array [0..63] of WChar;
           szHelpFile : array [0..127] of WChar;
         end;
         PNewCplInfoW = ^TNewCplInfoW;
    {$ENDIF}
     
    type TNewCplInfo = TNewCplInfoA;
    type PNewCplInfo = ^TNewCplInfoA;
     
    function CPlApplet(hWndCPL : hWnd;
                       iMEssage : integer;
                       lParam1 : longint;
                       lParam2 : longint) : LongInt
    {$IFDEF WIN32} stdcall; {$ELSE} ; export; {$ENDIF}
    begin
      case iMessage of
        CPL_INIT : begin
          Result := 1;
          exit;
        end;
        CPL_GetCount : begin
          Result := NUM_APPLETS;
          exit;
        end;
        CPL_Inquire : begin
          PCplInfo(lParam2)^.idIcon := 2;
          PCplInfo(lParam2)^.idName := 1;
          PCplInfo(lParam2)^.idInfo := 2;
          PCplInfo(lParam2)^.lData := 0;
          Result := 1;
          exit;
        end;
        CPL_NewInquire : begin
          PNewCplInfo(lParam2)^.dwSize := sizeof(TNewCplInfo);
          PNewCplInfo(lParam2)^.dwHelpContext := 0;
          PNewCplInfo(lParam2)^.lData := 0;
          PNewCplInfo(lParam2)^.IconH := LoadIcon(hInstance,
                                                  MakeIntResource(2));
          lStrCpy(@PNewCplInfo(lParam2)^.szName, 'TestCPL');
          lStrCpy(PNewCplInfo(lParam2)^.szInfo, 'My Test CPL');
          PNewCplInfo(lParam2)^.szHelpFile[0] := #0;
          Result := 1;
          exit;
        end;
        CPL_SELECT : begin
          Result := 0;
          exit;
        end;
        CPL_DBLCLK : begin
            WinExec('Notepad.exe', SW_SHOWNORMAL);
          Result := 1;
          exit;
        end;
        CPL_STOP : begin
          Result := 0;
          exit;
        end;
        CPL_EXIT : begin
          Result := 0;
          exit;
        end else begin
          Result := 0;
          exit;
        end;
      end;
    end;
     
    exports CPlApplet name 'CPlApplet';
     
    begin
    end.

