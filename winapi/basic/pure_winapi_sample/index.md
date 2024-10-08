---
Title: Пример приложений на чистом API
Date: 01.01.2007
---


Пример приложений на чистом API
===============================

Вариант 1:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

    program SmallPrg;
     
    uses
      Windows, Messages;
     
    const
      WinName = 'MainWClass';
     
    function MainWndProc(Window: HWnd; AMessage, WParam, LParam: Longint): Longint; stdcall;
    begin
      //подпрограмма обработки сообщений
      case AMessage of
        WM_DESTROY:
        begin
          PostQuitMessage(0);
          Result := 0;
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
      wcx.lpszMenuName := nil;
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
      nil); // no window-creation data
    end;
     
    var
      hwndMain: HWND;
      AMessage: msg;
    begin
      if (not InitApplication) then
        MessageBox(0, 'Ошибка регистрации окна', nil, mb_Ok)
      else
      begin
        hwndMain := InitInstance;
        if (hwndMain = 0) then
          MessageBox(0, 'Ошибка создания окна', nil, mb_Ok)
        else
        begin
          // Показываем окно и посылаем сообщение WM_PAINT оконной процедуре
          ShowWindow(hwndMain, CmdShow);
          UpdateWindow(hwndMain);
          while (GetMessage(AMessage, 0, 0, 0)) do
          begin
            TranslateMessage(AMessage);
            DispatchMessage(AMessage);
          end;
        end;
      end;
     
    end.


------------------------------------------------------------------------

Вариант 2:

Author: Spawn

Source: Vingrad.ru <https://forum.vingrad.ru>

    program WinMin;
    uses Windows, Messages;
    const AppName = 'WinMin';
    Var 
      Window : HWnd; 
      Message : TMsg; 
      WindowClass : TWndClass;
    
    function WindowProc (Window : HWnd; Message, WParam : Word; LParam : LongInt) : LongInt; stdcall;
    begin
      WindowProc := 0;
      case Message of
        wm_Destroy :begin 
          PostQuitMessage (0); 
          Exit; 
        end;
      end; // case
    
      WindowProc := DefWindowProc (Window, Message, WParam, LParam); 
    end;
    
    begin
      with WindowClass do 
      begin
        Style := cs_HRedraw or cs_VRedraw; 
        lpfnWndProc := @WindowProc; 
        cbClsExtra := 0; 
        cbWndExtra := 0; 
        hInstance := 0; 
        hIcon := LoadIcon (0, idi_Application);
        hCursor := LoadCursor (0, idc_Arrow); 
        hbrBackground := GetStockObject (White_Brush); 
        lpszMenuName := ''; 
        lpszClassName := AppName; 
      end;
      If RegisterClass (WindowClass) = 0 then Halt (255); 
      Window := CreateWindow(AppName, 
                             'Win_Min', 
                             ws_OverlappedWindow, 
                             cw_UseDefault, 
                             cw_UseDefault, 
                             cw_UseDefault, 
                             cw_UseDefault, 
                             0, 
                             0, 
                             HInstance, 
                             nil); 
      ShowWindow (Window, CmdShow); 
      UpdateWindow (Window); 
      while GetMessage (Message, 0, 0, 0) do 
      begin
        TranslateMessage (Message); 
        DispatchMessage (Message); 
      end;
      Halt 
    end.

М. Краснов. "OpenGL и графика в проектах Delphi".

------------------------------------------------------------------------

Вариант 3:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

Построение формы на чистом API

    program PlainAPI;
     
    uses
      Windows,
      Messages;
     
    {$R *.res}
     
    function PlainWinProc (hWnd: THandle; nMsg: UINT;
      wParam, lParam: Cardinal): Cardinal; export; stdcall;
    var
      hdc: THandle;
      ps: TPaintStruct;
    begin
      Result := 0;
      case nMsg of
        wm_lButtonDown:
          MessageBox (hWnd, 'Mouse Clicked',
            'Plain API', MB_OK);
        wm_Paint:
        begin
          hdc := BeginPaint (hWnd, ps);
          Ellipse (hdc, 100, 100, 300, 300);
          EndPaint (hWnd, ps);
        end;
        wm_Destroy:
          PostQuitMessage (0);
        else
          Result := DefWindowProc (hWnd, nMsg, wParam, lParam);
      end;
    end;
     
    procedure WinMain;
    var
      hWnd: THandle;
      Msg: TMsg;
      WndClassEx: TWndClassEx;
    begin
      // initialize the window class structure
      WndClassEx.cbSize := sizeOf (TWndClassEx);
      WndClassEx.lpszClassName := 'PlainWindow';
      WndClassEx.style := cs_VRedraw or cs_HRedraw;
      WndClassEx.hInstance := HInstance;
      WndClassEx.lpfnWndProc := @PlainWinProc;
      WndClassEx.cbClsExtra := 0;
      WndClassEx.cbWndExtra := 0;
      WndClassEx.hIcon := LoadIcon (hInstance,
        MakeIntResource ('MAINICON'));
      WndClassEx.hIconSm  := LoadIcon (hInstance,
        MakeIntResource ('MAINICON'));
      WndClassEx.hCursor := LoadCursor (0, idc_Arrow);;
      WndClassEx.hbrBackground := GetStockObject (white_Brush);
      WndClassEx.lpszMenuName := nil;
      // register the class
      if RegisterClassEx (WndClassEx) = 0 then
        MessageBox (0, 'Invalid class registration',
          'Plain API', MB_OK)
      else
      begin
        hWnd := CreateWindowEx (
          ws_Ex_OverlappedWindow, // extended styles
          WndClassEx.lpszClassName, // class name
          'Plain API Demo', // title
          ws_OverlappedWindow, // styles
          cw_UseDefault, 0, // position
          cw_UseDefault, 0, // size
          0, // parent window
          0, // menu
          HInstance, // instance handle
          nil); // initial parameters
        if hWnd = 0 then
          MessageBox (0, 'Window not created',
            'Plain API', MB_OK)
        else
        begin
          ShowWindow (hWnd, sw_ShowNormal);
          while GetMessage (Msg, 0, 0, 0) do
          begin
            TranslateMessage (Msg);
            DispatchMessage (Msg);
          end;
        end;
      end;
    end;
     
    begin
      WinMain;
    end. 


------------------------------------------------------------------------

Вариант 4:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

    // Put this code in your Project file (*.dpr). 
     
    program Project1;
     
     uses
       windows, messages;
     
     
     // Main Window Procedure 
     
    function MainWndProc(hWindow: HWND; Msg: UINT; wParam: wParam;
       lParam: lParam): LRESULT; stdcall; export;
     var
       ps: TPaintStruct;
     begin
       Result := 0;
       case Msg of
         WM_PAINT:
           begin
             BeginPaint(hWindow, ps);
             SetBkMode(ps.hdc, TRANSPARENT);
             TextOut(ps.hdc, 10, 10, 'Hello, World!', 13);
             EndPaint(hWindow, ps);
           end;
         WM_DESTROY: PostQuitMessage(0);
         else
           begin
             Result := DefWindowProc(hWindow, Msg, wParam, lParam);
             Exit;
           end;
       end;
     end;
     
     // Main Procedure 
     
    var
       wc: TWndClass;
       hWindow: HWND;
       Msg: TMsg;
     begin
       wc.lpszClassName := 'YourAppClass';
       wc.lpfnWndProc   := @MainWndProc;
       wc.Style         := CS_VREDRAW or CS_HREDRAW;
       wc.hInstance     := hInstance;
       wc.hIcon         := LoadIcon(0, IDI_APPLICATION);
       wc.hCursor       := LoadCursor(0, IDC_ARROW);
       wc.hbrBackground := (COLOR_WINDOW + 1);
       wc.lpszMenuName  := nil;
       wc.cbClsExtra    := 0;
       wc.cbWndExtra    := 0;
       RegisterClass(wc);
       hWindow := CreateWindowEx(WS_EX_CONTROLPARENT or WS_EX_WINDOWEDGE,
         'YourAppClass',
         'API',
         WS_VISIBLE or WS_CLIPSIBLINGS or
         WS_CLIPCHILDREN or WS_OVERLAPPEDWINDOW,
         CW_USEDEFAULT, 0,
         400, 300,
         0,
         0,
         hInstance,
         nil);
     
       ShowWindow(hWindow, CmdShow);
       UpDateWindow(hWindow);
     
       while GetMessage(Msg, 0, 0, 0) do
       begin
         TranslateMessage(Msg);
         DispatchMessage(Msg);
       end;
       Halt(Msg.wParam);
     end.
     

------------------------------------------------------------------------

Вариант 5:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

Создание формы и кнопки на чистом API

    program Plain2;
     
    uses
      Windows,
      Messages;
     
    const
      id_Button = 100;
     
    function PlainWinProc (hWnd: THandle; nMsg: UINT;
      wParam, lParam: Cardinal): Cardinal; export; stdcall;
    var
      Rect: TRect;
    begin
      Result := 0;
      case nMsg of
        wm_Create:
          // create button
          CreateWindowEx (0, // extended styles
            'BUTTON', // predefined class
            '&Click here', // caption
            ws_Child or ws_Visible or ws_Border
              or bs_PushButton, // styles
            0, 0, // position: see wm_Size
            200, 80, // size
            hwnd, // parent
            id_Button, // identifier (not a menu handle)
            hInstance, // application id
            nil); // init info pointer
        wm_Size:
        begin
          // get the size of the client window
          GetClientRect (hWnd, Rect);
          // move the button window
          SetWindowPos (
            GetDlgItem (hWnd, id_Button), // button handle
            0, // zOrder
            Rect.Right div 2 - 100,
            Rect.Bottom div 2 - 40,
            0, 0, // new size
            swp_NoZOrder or swp_NoSize);
        end;
        wm_Command:
          // if it comes from the button
          if LoWord (wParam) = id_Button then
            // if it is a click
            if HiWord (wParam) = bn_Clicked then
              MessageBox (hWnd, 'Button Clicked',
                'Plain API 2', MB_OK);
        wm_Destroy:
          PostQuitMessage (0);
        else
          Result := DefWindowProc (hWnd, nMsg, wParam, lParam);
      end;
    end;
     
    procedure WinMain;
    var
      hWnd: THandle;
      Msg: TMsg;
      WndClassEx: TWndClassEx;
    begin
      // initialize the window class structure
      WndClassEx.cbSize := sizeOf (TWndClassEx);
      WndClassEx.lpszClassName := 'PlainWindow';
      WndClassEx.style := cs_VRedraw or cs_HRedraw;
      WndClassEx.hInstance := HInstance;
      WndClassEx.lpfnWndProc := @PlainWinProc;
      WndClassEx.cbClsExtra := 0;
      WndClassEx.cbWndExtra := 0;
      WndClassEx.hIcon := LoadIcon (hInstance,
        MakeIntResource ('MAINICON'));
      WndClassEx.hIconSm  := LoadIcon (hInstance,
        MakeIntResource ('MAINICON'));
      WndClassEx.hCursor := LoadCursor (0, idc_Arrow);;
      WndClassEx.hbrBackground := GetStockObject (white_Brush);
      WndClassEx.lpszMenuName := nil;
      // register the class
      if RegisterClassEx (WndClassEx) = 0 then
        MessageBox (0, 'Invalid class registration',
          'Plain API', MB_OK)
      else
      begin
        hWnd := CreateWindowEx (
          ws_Ex_OverlappedWindow, // extended styles
          WndClassEx.lpszClassName, // class name
          'Plain API Demo', // title
          ws_OverlappedWindow, // styles
          cw_UseDefault, 0, // position
          cw_UseDefault, 0, // size
          0, // parent window
          0, // menu
          HInstance, // instance handle
          nil); // initial parameters
        if hWnd = 0 then
          MessageBox (0, 'Window not created',
            'Plain API', MB_OK)
        else
        begin
          ShowWindow (hWnd, sw_ShowNormal);
          while GetMessage (Msg, 0, 0, 0) do
          begin
            TranslateMessage (Msg);
            DispatchMessage (Msg);
          end;
        end;
      end;
    end;
     
    begin
      WinMain;
    end.

