---
Title: Как писать консольные приложения в Delphi?
Author: Alex G. Fedorov (alexfedorov@geocities.com)
Date: 12.07.1997
Source: <https://delphiworld.narod.ru>
---

Как писать консольные приложения в Delphi?
==========================================

_Все настоящие программисты делятся на три категории: на тех, кто пишет
программы, завершающиеся по нажатию F10, Alt-F4, Alt-X. Все остальные
принципы деления надуманны._

Статья представляет собой изучение создания консольного приложения в
Delphi. Прежде чем начать вникать в подробности, необходимо уточнить,
что консольные приложения это особый вид Windows приложений - с одной
стороны он имеет полный доступ к функциям Win API, с другой - не имеет
графического интерфейса и выполняется в текстовом режиме.

**Простая консольная программа**

На момент написания статьи (1997г.), в Delphi не было возможности
автоматически создавать консольные приложения (возможно на сегодняшний
день этот недостаток устранён), поэтому мы создадим пустой файл и
поместим в него следующий код:

    program ConPrg;
    {$APPTYPE CONSOLE}
    begin
    end.

Затем сохраним этот файл с расширением .dpr - в данном случае
conprg.dpr. Далее, его можно загрузить в Delphi (File\|Open) и
приступить к добавлению кода.

Обратите внимание:

Если Вы запустите вышеприведённую программу, то она немедленно
завершится, так как в ней нет никакого рабочего кода.

Для начала, в неё можно добавить строчку readln:

    program ConPrg;
    {$APPTYPE CONSOLE}
    begin
      readln
    end.

Вы увидите пустое текстовое окошко, которое закроется, если нажать
клавишу Enter.

Идём дальше

Как упоминалось раньше, Вы можете использовать почти любую функцию Win32
API из консольного приложения. Такое приложение очень удобно ещё и тем,
что о пользовательском интерфейсе можно вообще не думать, а для вывода
информации использовать только пару функций Write/Writeln. Примеров
применения консольных приложений великое множество: это и различного
вида утилиты, и тестовые программы для проверки работы функций API и
т.д. Мы не будет погружаться в примеры того как использовать
определённые API, а поговорим только о Консольных API (Console API).

**Консольные API (Console API)**

Microsoft предоставляет определённый набор функций, которые очень даже
полезны при создании консольных приложений. Для начала скажу, что
существует по крайней мере два дескриптора (handles), которые связаны с
консольным окном. Один для ввода, второй для вывода. Ниже приводятся две
небольшие функции, которые показывают, как получить эти дескрипторы.

    //-----------------------------------------
    // Получение дескриптора для консольного ввода
    //-----------------------------------------
    function GetConInputHandle : THandle;
    begin
      Result := GetStdHandle(STD_INPUT_HANDLE)
    end;
     
    //-----------------------------------------
    // Получение дескриптора для консольного вывода
    //-----------------------------------------
    function GetConOutputHandle : THandle;
    begin
      Result := GetStdHandle(STD_OUTPUT_HANDLE)
    end;

Так же, лучше сразу создать свои функции для таких простых операций как
позиционирование курсора, очистки экрана и отображение/скрытие курсора
(так как в консольных API они немножко громозки и запутаны). Вот как они
выглядят:

    //-----------------------------------------
    // Установка курсора в координаты X, Y
    //-----------------------------------------
    procedure GotoXY(X, Y: Word);
    begin
      Coord.X := X;
      Coord.Y := Y;
      SetConsoleCursorPosition(ConHandle, Coord);
    end;
     
    //-----------------------------------------
    // Очистка экрана - заполнение его пробелами
    //-----------------------------------------
    procedure Cls;
    begin
      Coord.X := 0;
      Coord.Y := 0;
      FillConsoleOutputCharacter(ConHandle, ' ', MaxX * MaxY, Coord, NOAW);
      GotoXY(0, 0);
    end;
     
    //--------------------------------------
    // Показываем/Скрываем курсор
    //--------------------------------------
    procedure ShowCursor(Show: Bool);
    begin
      CCI.bVisible := Show;
      SetConsoleCursorInfo(ConHandle, CCI);
    end;

Как Вы успели заметить, мы воспользовались четырьмя функциями
консольного API: GetStdHandle, SetConsoleCursorPosition,
FillConsoleOutputCharacter, SetConsoleCursorInfo. Иногда может
возникнуть задача определения размера консольного окна по вертикали и по
горизонтали. Для этого мы создадим две переменные: MaxX и MaxY, типа
WORD:

    //--------------------------------------
    // Инициализация глобальных переменных
    //--------------------------------------
    procedure Init;
    begin
      // Получаем дескриптор вывода (output)
      ConHandle := GetConOutputHandle;
      // Получаем максимальные размеры окна
      Coord := GetLargestConsoleWindowSize(ConHandle);
      MaxX := Coord.X;
      MaxY := Coord.Y;
    end;

Мы даже можем сделать "цикл обработки сообщений" (message loop) - для
тех, кто только начинает программировать в Delphi - цикл обработки
сообщений необходимо делать, если приложение создаётся в чистом API -
при этом необходимы как минимум три составляющие: WinMain, message loop
и window proc.

Ниже приведён код "цикла обработки сообщений":

     
    SetConsoleCtrlHandler(@ConProc, False);
    Cls;
    //
    // "Цикл обработки сообщений"
    //
    Continue := True;
    while Continue do
    begin
      ReadConsoleInput(GetConInputHandle, IBuff, 1, IEvent);
      case IBuff.EventType of
        KEY_EVENT :
          begin
            // Проверяем клавишу ESC и завершаем программу
            if ((IBuff.KeyEvent.bKeyDown = True) and
            (IBuff.KeyEvent.wVirtualKeyCode = VK_ESCAPE)) then
              Continue := False;
          end;
        MOUSE_EVENT :
          begin
            with IBuff.MouseEvent.dwMousePosition do
              StatusLine(Format('%d, %d', [X, Y]));
          end;
      end;
    end {While}

Так же можно добавить "обработчик событий" и перехватывать такие
комбинации клавиш как Ctrl+C и Ctrl+Break:

    //-----------------------------------------------------
    // Обработчик консольных событий
    //-----------------------------------------------------
    function ConProc(CtrlType: DWord): Bool; stdcall; far;
    var
      S: string;
    begin
      case CtrlType of
        CTRL_C_EVENT: S := 'CTRL_C_EVENT';
        CTRL_BREAK_EVENT: S := 'CTRL_BREAK_EVENT';
        CTRL_CLOSE_EVENT: S := 'CTRL_CLOSE_EVENT';
        CTRL_LOGOFF_EVENT: S := 'CTRL_LOGOFF_EVENT';
        CTRL_SHUTDOWN_EVENT: S := 'CTRL_SHUTDOWN_EVENT';
        else
          S := 'UNKNOWN_EVENT';
      end;
      MessageBox(0, PChar(S + ' detected'), 'Win32 Console', MB_OK);
      Result := True;
    end;

Чтобы посмотреть всё это в действии, я сделал небольшую демонстрационную
программу, которая содержит подпрограммы, приведённые выше, а так же
некоторые другие возможности. Далее приведён полный исходный код этого
приложения. Наслаждайтесь!

    {
    []-----------------------------------------------------------[]
    CON001 - Show various Console API functions. Checked with Win95
     
    version 1.01
     
    by Alex G. Fedorov, May-July, 1997
    alexfedorov@geocities.com
     
    09-Jul-97 some minor corrections (shown in comments)
    []-----------------------------------------------------------[]
    }
    program Con001;
     
    {$APPTYPE CONSOLE}
     
    uses
      Windows, SysUtils;
     
    const
      // Некоторые стандартные цвета
      YellowOnBlue = FOREGROUND_GREEN or FOREGROUND_RED or
      FOREGROUND_INTENSITY or BACKGROUND_BLUE;
      WhiteOnBlue = FOREGROUND_BLUE or FOREGROUND_GREEN or
      FOREGROUND_RED or FOREGROUND_INTENSITY or
      BACKGROUND_BLUE;
     
      RedOnWhite = FOREGROUND_RED or FOREGROUND_INTENSITY or
      BACKGROUND_RED or BACKGROUND_GREEN or BACKGROUND_BLUE
      or BACKGROUND_INTENSITY;
     
      WhiteOnRed = BACKGROUND_RED or BACKGROUND_INTENSITY or
      FOREGROUND_RED or FOREGROUND_GREEN or FOREGROUND_BLUE
      or FOREGROUND_INTENSITY;
     
    var
      ConHandle: THandle; // Дескриптор консольного окна
      Coord: TCoord; // Для хранения/установки позиции экрана
      MaxX, MaxY: Word; // Для хранения максимальных размеров окна
      CCI: TConsoleCursorInfo;
      NOAW: LongInt; // Для хранения результатов некоторых функций
     
    //-----------------------------------------
    // Получение дескриптора для консольного ввода
    //-----------------------------------------
    function GetConInputHandle : THandle;
    begin
      Result := GetStdHandle(STD_INPUT_HANDLE)
    end;
     
    //-----------------------------------------
    // Получение дескриптора для консольного вывода
    //-----------------------------------------
    function GetConOutputHandle : THandle;
    begin
      Result := GetStdHandle(STD_OUTPUT_HANDLE)
    end;
     
    //-----------------------------------------
    // Установка курсора в координаты X, Y
    //-----------------------------------------
    procedure GotoXY(X, Y : Word);
    begin
      Coord.X := X;
      Coord.Y := Y;
      SetConsoleCursorPosition(ConHandle, Coord);
    end;
     
    //-----------------------------------------
    // Очистка экрана - заполнение его пробелами
    //-----------------------------------------
    procedure Cls;
    begin
      Coord.X := 0;
      Coord.Y := 0;
      FillConsoleOutputCharacter(ConHandle, ' ', MaxX * MaxY, Coord, NOAW);
      GotoXY(0, 0);
    end;
     
    //--------------------------------------
    // Показываем/Скрываем курсор
    //--------------------------------------
    procedure ShowCursor(Show : Bool);
    begin
      CCI.bVisible := Show;
      SetConsoleCursorInfo(ConHandle, CCI);
    end;
     
    //--------------------------------------
    // Инициализация глобальных переменных
    //--------------------------------------
    procedure Init;
    begin
      // Получаем дескриптор вывода (output)
      ConHandle := GetConOutputHandle;
      // Получаем максимальные размеры окна
      Coord := GetLargestConsoleWindowSize(ConHandle);
      MaxX := Coord.X;
      MaxY := Coord.Y;
    end;
     
    //---------------------------------------
    // рисуем строку статуса ("status line")
    //---------------------------------------
    procedure StatusLine(S : string);
    begin
      Coord.X := 0; Coord.Y := 0;
      WriteConsoleOutputCharacter(ConHandle, PChar(S), Length(S)+1, Coord, NOAW);
      FillConsoleOutputAttribute (ConHandle, WhiteOnRed, Length(S), Coord, NOAW);
    end;
     
    //-----------------------------------------------------
    // Консольный обработчик событий
    //-----------------------------------------------------
    function ConProc(CtrlType : DWord) : Bool; stdcall; far;
    var
      S: string;
    begin
      case CtrlType of
        CTRL_C_EVENT: S := 'CTRL_C_EVENT';
        CTRL_BREAK_EVENT: S := 'CTRL_BREAK_EVENT';
        CTRL_CLOSE_EVENT: S := 'CTRL_CLOSE_EVENT';
        CTRL_LOGOFF_EVENT: S := 'CTRL_LOGOFF_EVENT';
        CTRL_SHUTDOWN_EVENT: S := 'CTRL_SHUTDOWN_EVENT';
        else
          S := 'UNKNOWN_EVENT';
      end;
      MessageBox(0, PChar(S + ' detected'), 'Win32 Console', MB_OK);
      Result := True;
    end;
     
    {
    []-----------------------------------------------------------[]
    Основная программа - показывает использование некоторых подпрограмм
    а так же некоторых функций консольного API
    []-----------------------------------------------------------[]
    }
    var
      R: TSmallRect;
      Color: Word;
      OSVer: TOSVersionInfo;
      IBuff: TInputRecord;
      IEvent: DWord;
      Continue: Bool;
     
    begin
      // Инициализация глобальных переменных
      Init;
      // Расположение окна на экране
      {!! 1.01 !!}
      with R do
      begin
        Left := 10;
        Top := 10;
        Right := 40;
        Bottom := 40;
      end
     
      {!! 1.01 !!}
      SetConsoleWindowInfo(ConHandle, False, R);
      // Устанавливаем обработчик событий
      SetConsoleCtrlHandler(@ConProc, True);
      // Проверяем обработчик событий
      GenerateConsoleCtrlEvent(CTRL_C_EVENT, 0);
      // Изменяем заголовок окна
      SetConsoleTitle('Console Demo');
      // Прячем курсор
      ShowCursor(False);
      Coord.X := 0; Coord.Y := 0;
      // Устанавливаем белый текст на синем фоне
      Color := WhiteOnBlue;
      FillConsoleOutputAttribute(ConHandle, Color, MaxX * MaxY, Coord, NOAW);
      // Console Code Page API is not supported under Win95 - only GetConsoleCP
      Writeln('Console Code Page = ', GetConsoleCP);
      Writeln('Max X=', MaxX,' Max Y=', MaxY);
      Readln; // ожидаем ввода пользователя
      Cls; // очищаем экран
      ShowCursor(True); // показываем курсор
     
      // Use some Win32API stuff
      OSVer.dwOSVersionInfoSize := SizeOf(TOSVersionInfo);
      GetVersionEx(OSVer);
      with OSVer do
      begin
        Writeln('dwMajorVersion = ', dwMajorVersion);
        Writeln('dwMinorVersion = ', dwMinorVersion);
        Writeln('dwBuildNumber = ', dwBuildNumber);
        Writeln('dwPlatformID = ', dwPlatformID);
      end;
     
      // ожидаем ввода пользователя
      Readln;
      // Удаляем обработчик событий
      SetConsoleCtrlHandler(@ConProc, False);
      Cls;
     
      // "Цикл обработки сообщений"
      Continue := True;
      while Continue do
      begin
        ReadConsoleInput(GetConInputHandle, IBuff, 1, IEvent);
        case IBuff.EventType of
          KEY_EVENT :
            begin
              // Проверяем клавишу ESC и завершаем программу
              if ((IBuff.KeyEvent.bKeyDown = True) and
              (IBuff.KeyEvent.wVirtualKeyCode = VK_ESCAPE)) then
                Continue := False;
            end;
          MOUSE_EVENT :
            begin
              with IBuff.MouseEvent.dwMousePosition do
                StatusLine(Format('%d, %d', [X, Y]));
            end;
        end;
      end {While}
    end.

