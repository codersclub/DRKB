<h1>Написание программ на чистом WinAPI</h1>
<div class="date">01.01.2007</div>


<p>Написание программ на чистом WinAPI.</p>
<p>Попробуем написать с Вами программу, которая не будет пользоваться VCL, а будет использовать вызовы функций Windows API.</p>
<p>Приложения такого типа нужны, когда размер исполняемого файла является критичным. Например, в инсталяторах, деинсталяторах, самораспаковывающихся архивах и т.п. В крайнем случае, для того чтобы посмотреть какую работу выполняет за нас VCL, и что из себя представляет Windows-программа.</p>
<p>  На самом деле все очень просто...</p>
<p>Для этого нам необходимо:</p>
<p> 1. Зарегистрировать класс окна для окна главной формы.</p>
<pre>
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
    Result := RegisterClass(wcx) &lt;&gt; 0;
end;
</pre>

<p> 2. Написать подпрограмму обработки оконных сообщений.</p>
<pre>
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
</pre>
<p> 3. Создать главное окно приложения.</p>
<pre>
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
</pre>
<p> 4. Написать тело программы.</p>
<pre>
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
</pre>
<p> 5. Запустить программу на исполнение.;)</p>
<p>Наша программа пока только может немногое - отображать форму, и закрываться после нажатия на кнопку закрытия формы... Но посмотрите на размер исполняемого файла - он больше чем на порядок меньше созданного с использованием VCL. </p>
<p>Полный текст програмы:</p>
<pre>
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
    Result := RegisterClass(wcx) &lt;&gt; 0;
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
</pre>

<p>Последний раз мы рассмотрели пару ф-й и их особенности(FindWindow,</p>
<p>GetNextWindow и GetWindowText), однако несмотря на это были вопросы</p>
<p>именно на эту тему - вывод : торопитесь ребята. Старайтесь по</p>
<p>максимуму использовать, то что у Вас уже есть.</p>
<p>Итак вдогонку к 12-у выпуску хочется отметить, что при поиске окон,</p>
<p>как отмечалось, нужен класс и имя, так вот - если Вы ищите DOS-окно,</p>
<p>то его класс всегда = 'tty'.</p>
<p>Сегодня рассмотрим некоторые вспомогательные функции, которые немного</p>
<p>облегчают и нашу жизнь, и программу в целом.</p>
<p>Получить каталог Windows( вдруг при установке Вы назвали его Unix :) ).</p>
<p>var</p>
<p>s1 : array[0..254] of Char;</p>
<p>...</p>
<p>GetWindowsDirectory(s1,255);</p>
<p>В s1 получим искомый путь.</p>
<p>Один момент - не надо описывать s1 просто как PChar, иначе</p>
<p>при выполнении получите неприятное сообщение.</p>
<p>Анологично можно найти и системный каталог. Это тоже важно, поскольку,</p>
<p>например для Win9x это 'Windows\System', а для NT 'System32'.</p>
<p>GetSystemDirectory(s1,255);</p>
<p>255 - это длинна строки. Отдельно подчеркну, что очень рекомендую вместо</p>
<p>этого числа ставить переменную Max_Path, содержащую в себе максимальную</p>
<p>длинну пути в Вашей операционной системе.</p>
<p>Еще очень интересная функция. Она позволяет запретить или разрешить все</p>
<p>действия с окном пользователю.</p>
<p>EnableWindow(H:Hwnd,t:Boolean);</p>
<p>Где h-дескриптор окна, если сказать Application.Handle, то свое окно.</p>
<p>t=False - запретить действия, True - разрешить.</p>
<p>Ну и все с Api - функциями на этом.</p>

