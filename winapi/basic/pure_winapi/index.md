---
Title: Написание программ на чистом WinAPI
Date: 01.01.2007
---


Написание программ на чистом WinAPI
===================================

Попробуем написать с Вами программу, которая не будет пользоваться VCL,
а будет использовать вызовы функций Windows API.

Приложения такого типа нужны, когда размер исполняемого файла является
критичным. Например, в инсталяторах, деинсталяторах,
самораспаковывающихся архивах и т.п. В крайнем случае, для того чтобы
посмотреть какую работу выполняет за нас VCL, и что из себя представляет
Windows-программа.

На самом деле все очень просто...

Для этого нам необходимо:

1. Зарегистрировать класс окна для окна главной формы.

        function InitApplication: Boolean;
        var
          wcx: TWndClass;
        begin
        //Заполняем структуру TWndClass
            // перерисовываем, если размер изменяется
            wcx.style := CS_HREDRAW or CS_VREDRAW;
            // адрес оконной процедуры
            wcx.lpfnWndProc := @MainWndProc;
            wcx.cbClsExtra := 0;
            wcx.cbWndExtra := 0;
            // handle to instance
            wcx.hInstance := hInstance;
            // загружаем стандандартную иконку
            wcx.hIcon := LoadIcon(0, IDI_APPLICATION);
            // загружаем стандартный курсор
            wcx.hCursor := LoadCursor(0, IDC_ARROW);
            // делаем светло-cерый фон
            wcx.hbrBackground := COLOR_WINDOW;
            // пока нет главного меню
            wcx.lpszMenuName :=  nil;
            // имя класса окна
            wcx.lpszClassName := PChar(WinName);
         
            // Регистрируем наш класс окна.
            Result := RegisterClass(wcx) <> 0;
        end;

2. Написать подпрограмму обработки оконных сообщений.

        function MainWndProc(Window: HWnd; AMessage, WParam,
                            LParam: Longint): Longint; stdcall; export;
        begin
          //подпрограмма обработки сообщений
          case AMessage of
            WM_DESTROY: begin
              PostQuitMessage(0);
              Exit;
            end;
            else
               Result := DefWindowProc(Window, AMessage, WParam, LParam);
          end;
        end;

3. Создать главное окно приложения.

        function InitInstance: HWND;
        begin
          // Создаем главное окно.
          Result := CreateWindow(
           // имя класса окна
           PChar(WinName),
           // заголовок
           'Small program',
           // стандартный стиль окна
           WS_OVERLAPPEDWINDOW,
           // стандартные горизонтальное, вертикальное положение, ширина и высота
           Integer(CW_USEDEFAULT),
           Integer(CW_USEDEFAULT),
           Integer(CW_USEDEFAULT),
           Integer(CW_USEDEFAULT),
           0,//нет родительского окна
           0,//нет меню
           hInstance, // handle to application instance
           nil);      // no window-creation data
        end;

4. Написать тело программы.

        var
          hwndMain: HWND;
          AMessage: msg;
        begin
          if (not InitApplication) then
          begin
            MessageBox(0, 'Ошибка регистрации окна', nil, mb_Ok);
            Exit;
          end;
          hwndMain := InitInstance;
          if (hwndMain = 0) then
          begin
            MessageBox(0, 'Ошибка создания окна', nil, mb_Ok);
            Exit;
          end
          else
          begin
            // Показываем окно и посылаем сообщение WM_PAINT оконной процедуре
            ShowWindow(hwndMain, CmdShow);
            UpdateWindow(hwndMain);
          end;
          while (GetMessage(AMessage, 0, 0, 0)) do
          begin
            //Запускаем цикл обработки сообщений
            TranslateMessage(AMessage);
            DispatchMessage(AMessage);
          end;
          Halt(AMessage.wParam);
        end.

5. Запустить программу на исполнение.;)

Наша программа пока только может немногое - отображать форму, и
закрываться после нажатия на кнопку закрытия формы... Но посмотрите на
размер исполняемого файла - он больше чем на порядок меньше созданного с
использованием VCL.

Полный текст програмы:

    program SmallPrg;
     
    uses Windows,  Messages;
     
    const
      WinName = 'MainWClass';
     
    function MainWndProc(Window: HWnd; AMessage, WParam,
                        LParam: Longint): Longint; stdcall; export;
    begin
      //подпрограмма обработки сообщений
      case AMessage of
        WM_DESTROY: begin
          PostQuitMessage(0);
          Exit;
        end;
        else
           Result := DefWindowProc(Window, AMessage, WParam, LParam);
      end;
    end;
     
    function InitApplication: Boolean;
    var
      wcx: TWndClass;
    begin
    //Заполняем структуру TWndClass
        // перерисовываем, если размер изменяется
        wcx.style := CS_HREDRAW or CS_VREDRAW;
        // адрес оконной процедуры
        wcx.lpfnWndProc := @MainWndProc;
        wcx.cbClsExtra := 0;
        wcx.cbWndExtra := 0;
        // handle to instance
        wcx.hInstance := hInstance;
        // загружаем стандандартную иконку
        wcx.hIcon := LoadIcon(0, IDI_APPLICATION);
        // загружаем стандартный курсор
        wcx.hCursor := LoadCursor(0, IDC_ARROW);
        // делаем светло-cерый фон
        wcx.hbrBackground := COLOR_WINDOW;
        // пока нет главного меню
        wcx.lpszMenuName :=  nil;
        // имя класса окна
        wcx.lpszClassName := PChar(WinName);
     
        // Регистрируем наш класс окна.
        Result := RegisterClass(wcx) <> 0;
    end;
     
    function InitInstance: HWND;
    begin
      // Создаем главное окно.
      Result := CreateWindow(
       // имя класса окна
       PChar(WinName),
       // заголовок
       'Small program',
       // стандартный стиль окна
       WS_OVERLAPPEDWINDOW,
       // стандартные горизонтальное, вертикальное положение, ширина и высота
       Integer(CW_USEDEFAULT),
       Integer(CW_USEDEFAULT),
       Integer(CW_USEDEFAULT),
       Integer(CW_USEDEFAULT),
       0,//нет родительского окна
       0,//нет меню
       hInstance, // handle to application instance
       nil);      // no window-creation data
    end;
     
    var
      hwndMain: HWND;
      AMessage: msg;
    begin
        if (not InitApplication) then
        begin
          MessageBox(0, 'Ошибка регистрации окна', nil, mb_Ok);
          Exit;
        end;
        hwndMain := InitInstance;
        if (hwndMain = 0) then
        begin
          MessageBox(0, 'Ошибка создания окна', nil, mb_Ok);
          Exit;
        end
        else
        begin
          // Показываем окно и посылаем сообщение WM_PAINT оконной процедуре
          ShowWindow(hwndMain, CmdShow);
          UpdateWindow(hwndMain);
        end;
        while (GetMessage(AMessage, 0, 0, 0)) do
        begin
          //Запускаем цикл обработки сообщений
          TranslateMessage(AMessage);
          DispatchMessage(AMessage);
        end;
        Halt(AMessage.wParam);
    end.

Последний раз мы рассмотрели пару функций и их особенности (FindWindow,
GetNextWindow и GetWindowText), однако несмотря на это были вопросы
именно на эту тему. Вывод - торопитесь, ребята.
Старайтесь по максимуму использовать, то что у Вас уже есть.

Итак, вдогонку к 12-у выпуску хочется отметить, что при поиске окон,
как отмечалось, нужен класс и имя, так вот - если Вы ищите DOS-окно,
то его класс всегда = \'tty\'.

Сегодня рассмотрим некоторые вспомогательные функции, которые немного
облегчают и нашу жизнь, и программу в целом.

Получить каталог Windows ( вдруг при установке Вы назвали его Unix :) ).

    var
      s1 : array[0..254] of Char;
    ...
    GetWindowsDirectory(s1,255);

В s1 получим искомый путь.

Один момент - не надо описывать s1 просто как PChar, иначе
при выполнении получите неприятное сообщение.

Анологично можно найти и системный каталог. Это тоже важно, поскольку,
например для Win9x это \'Windows\\System\', а для NT \'System32\'.

    GetSystemDirectory(s1,255);

255 - это длинна строки. Отдельно подчеркну, что очень рекомендую вместо
этого числа ставить переменную Max\_Path, содержащую в себе максимальную
длинну пути в Вашей операционной системе.

Еще очень интересная функция. Она позволяет запретить или разрешить все
действия с окном пользователю.

    EnableWindow(H:Hwnd,t:Boolean);

Где h-дескриптор окна, если сказать Application.Handle, то свое окно.

t=False - запретить действия, True - разрешить.

Ну и все с Api - функциями на этом.
