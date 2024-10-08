---
Title: Библиотека WinLight
Date: 01.01.2000
Author: Николай Мазуркин
Source: <https://forum.sources.ru>
---


Библиотека WinLight
===================

    ////////////////////////////////////////////////////////////////////////////////
    //         WinLite, библиотека классов и функций для работы с Win32 API
    //                       (c) Николай Мазуркин, 1999-2000
    // _____________________________________________________________________________
    //                                Оконные классы
    ////////////////////////////////////////////////////////////////////////////////
     
    unit WinLite;
     
    interface
     
    uses Windows, Messages;

**Инициализационные структуры**

Объявление структур, которые используются для формирования параметров
вновь создаваемых окон и диалогов соответственно. 
     
    ////////////////////////////////////////////////////////////////////////////////
    // Параметры для создания окна
    ////////////////////////////////////////////////////////////////////////////////
    type
      TWindowParams = record
        Caption     : PChar;
        Style       : DWord;
        ExStyle     : DWord;
        X           : Integer;
        Y           : Integer;
        Width       : Integer;
        Height      : Integer;
        WndParent   : THandle;
        WndMenu     : THandle;
        Param       : Pointer;
        WindowClass : TWndClass;
      end;
     
    ////////////////////////////////////////////////////////////////////////////////
    // Параметры для создания диалога
    ////////////////////////////////////////////////////////////////////////////////
    type
      TDialogParams = record
        Template    : PChar;
        WndParent   : THandle;
      end;
     
**Декларация базового класса TLiteFrame**

Базовый класс для окон и диалогов.
Инкапсулирует в себе дескриптор окна и объявляет общую оконную процедуру.
Реализует механизм message-процедур. 
     
    ////////////////////////////////////////////////////////////////////////////////
    // TLiteFrame
    // _____________________________________________________________________________
    // Базовый класс для объектов TLiteWindow, TLiteDialog, TLiteDialogBox
    ////////////////////////////////////////////////////////////////////////////////
    type
      TLiteFrame = class(TObject)
      private
        FWndCallback: Pointer;
        FWndHandle  : THandle;
        FWndParent  : THandle;
        function    WindowCallback(hWnd: HWnd; Msg, WParam, LParam:Longint):Longint; stdcall;
      protected
        procedure   WindowProcedure(var Msg: TMessage); virtual;
      public
        property    WndHandle: THandle read FWndHandle;
        property    WndCallback: Pointer read FWndCallback;
      public
        constructor Create(AWndParent: THandle); virtual;
        destructor  Destroy; override;
      end;
     
**Декларация оконного класса TLiteWindow**

Создание уникального класса окна и создание окна. Возможность субклассинга стороннего окна. 
     
    ////////////////////////////////////////////////////////////////////////////////
    // TLiteWindow
    // _____________________________________________________________________________
    // Оконный класс
    ////////////////////////////////////////////////////////////////////////////////
    type
      TLiteWindow = class(TLiteFrame)
      private
        FWndParams  : TWindowParams;
        FWndSubclass: Pointer;
      protected
        procedure   CreateWindowParams(var WindowParams: TWindowParams); virtual;
      public
        procedure   DefaultHandler(var Msg); override;
        constructor Create(AWndParent: THandle); override;
        constructor CreateSubclassed(AWnd: THandle); virtual;
        destructor  Destroy; override;
      end;
     
**Декларация диалогового класса TLiteDialog**

Загрузка шаблона диалога и создание диалога. 
     
    ////////////////////////////////////////////////////////////////////////////////
    // TLiteDialog
    // _____________________________________________________________________________
    // Диалоговый класс
    ////////////////////////////////////////////////////////////////////////////////
    type
      TLiteDialog = class(TLiteFrame)
      private
        FDlgParams  : TDialogParams;
      protected
        procedure   CreateDialogParams(var DialogParams: TDialogParams); virtual;
      public
        procedure   DefaultHandler(var Msg); override;
        constructor Create(AWndParent: THandle); override;
        destructor  Destroy; override;
      end;
     
**Декларация модального диалогового класса TLiteDialogBox**

Загрузка шаблона диалога и создание диалога. Модальный показ диалога. 
     
    ////////////////////////////////////////////////////////////////////////////////
    // TLiteDialogBox
    // _____________________________________________________________________________
    // Модальный диалоговый класс
    ////////////////////////////////////////////////////////////////////////////////
    type
      TLiteDialogBox = class(TLiteFrame)
      private
        FDlgParams  : TDialogParams;
      protected
        procedure   CreateDialogParams(var DialogParams: TDialogParams); virtual;
      public
        procedure   DefaultHandler(var Msg); override;
      public
        function    ShowModal: Integer; 
      end;
     
**Реализация базового класса TLiteFrame**

    implementation
     
    ////////////////////////////////////////////////////////////////////////////////
    // TLiteFrame
    // _____________________________________________________________________________
    // Инициализация / финализация
    ////////////////////////////////////////////////////////////////////////////////
     
    ////////////////////////////////////////////////////////////////////////////////
    // Конструктор
    ////////////////////////////////////////////////////////////////////////////////
    constructor TLiteFrame.Create(AWndParent: THandle);
    begin
      inherited Create;
      // Запоминаем дескриптор родительского окна
      FWndParent := AWndParent;
      // Создаем место под блок обратного вызова
      FWndCallback := VirtualAlloc(nil,12,MEM_RESERVE or MEM_COMMIT,PAGE_EXECUTE_READWRITE);
      // Формируем блок обратного вызова
      asm
        mov  EAX, Self
        mov  ECX, [EAX].TLiteFrame.FWndCallback     
        mov  word  ptr [ECX+0], $6858               // pop  EAX
        mov  dword ptr [ECX+2], EAX                 // push _Self_
        mov  word  ptr [ECX+6], $E950               // push EAX
        mov  EAX, OFFSET(TLiteFrame.WindowCallback)
        sub  EAX, ECX
        sub  EAX, 12
        mov  dword ptr [ECX+8], EAX                 // jmp  TLiteFrame.WindowCallback
      end;
    end;
     
    ////////////////////////////////////////////////////////////////////////////////
    // Деструктор
    ////////////////////////////////////////////////////////////////////////////////
    destructor TLiteFrame.Destroy;
    begin
      // Уничтожаем структуру блока обратного вызова
      VirtualFree(FWndCallback, 0, MEM_RELEASE);
      // Уничтожение по умолчанию
      inherited;
    end;
     
    ////////////////////////////////////////////////////////////////////////////////
    // TLiteFrame
    // _____________________________________________________________________________
    // Функции обработки сообщений
    ////////////////////////////////////////////////////////////////////////////////
     
    ////////////////////////////////////////////////////////////////////////////////
    // Функция обратного вызова для получения оконных сообщений
    ////////////////////////////////////////////////////////////////////////////////
    function TLiteFrame.WindowCallback(hWnd: HWnd; Msg, WParam, LParam: Integer): Longint;
    var
      WindowMsg : TMessage;
    begin
      // Запоминаем дескриптор окна, если это первый вызов оконной процедуры
      if FWndHandle = 0 then FWndHandle := hWnd;
      // Формируем сообщение
      WindowMsg.Msg    := Msg;
      WindowMsg.WParam := WParam;
      WindowMsg.LParam := LParam;
      // Обрабатываем его
      WindowProcedure(WindowMsg);
      // Возвращаем результат обратно системе
      Result := WindowMsg.Result;
    end;
     
    ////////////////////////////////////////////////////////////////////////////////
    // Виртуальная функция для обработки оконных сообщений
    ////////////////////////////////////////////////////////////////////////////////
    procedure TLiteFrame.WindowProcedure(var Msg: TMessage);
    begin
      // Распределяем сообщения по обработчикам
      Dispatch(Msg);
    end;
     
**Реализация оконного класса TLiteWindow**

    ////////////////////////////////////////////////////////////////////////////////
    // TLiteWindow
    // _____________________________________________________________________________
    // Инициализация / финализация
    ////////////////////////////////////////////////////////////////////////////////
     
    ////////////////////////////////////////////////////////////////////////////////
    // Конструктор
    ////////////////////////////////////////////////////////////////////////////////
    constructor TLiteWindow.Create(AWndParent: THandle);
    begin
      inherited;
      // Формируем параметры окна
      CreateWindowParams(FWndParams);
      // Регистрируем класс окна
      RegisterClass(FWndParams.WindowClass);
      // Создаем окно
      with FWndParams do
        CreateWindowEx(ExStyle, WindowClass.lpszClassName, Caption,
          Style, X, Y, Width, Height,
          WndParent, WndMenu, hInstance, Param
        );
    end;
     
    ////////////////////////////////////////////////////////////////////////////////
    // Конструктор элемента с субклассингом
    ////////////////////////////////////////////////////////////////////////////////
    constructor TLiteWindow.CreateSubclassed(AWnd: THandle);
    begin
      inherited Create(GetParent(AWnd));
      // Сохраняем оконную функцию
      FWndSubclass := Pointer(GetWindowLong(AWnd, GWL_WNDPROC));
      // Сохраняем дескриптор окна
      FWndHandle   := AWnd;
      // Устанавливаем свою оконную функцию
      SetWindowLong(FWndHandle, GWL_WNDPROC, DWord(WndCallback));
    end;
     
    ////////////////////////////////////////////////////////////////////////////////
    // Деструктор
    ////////////////////////////////////////////////////////////////////////////////
    destructor TLiteWindow.Destroy;
    begin
      // Наш объект - объект субклассиннга ?
      if FWndSubclass = nil then
      begin
        // Уничтожаем класс окна
        UnregisterClass(FWndParams.WindowClass.lpszClassName, hInstance);
        // Уничтожаем окно
        if IsWindow(FWndHandle) then DestroyWindow(FWndHandle);
      end
      else
        // Восстанавливаем старую оконную функцию
        SetWindowLong(FWndHandle, GWL_WNDPROC, DWord(FWndSubclass));
      // Уничтожение по умолчанию
      inherited;
    end;
     
    ////////////////////////////////////////////////////////////////////////////////
    // Формирование параметров окна по умолчанию
    ////////////////////////////////////////////////////////////////////////////////
    procedure TLiteWindow.CreateWindowParams(var WindowParams: TWindowParams);
    var
      WndClassName : string;
    begin
      // Формируем имя класса
      Str(DWord(Self), WndClassName);
      WndClassName := ClassName+':'+WndClassName;
      // Заполняем информацию о классе окна
      with FWndParams.WindowClass do
      begin
        style         := CS_DBLCLKS;
        lpfnWndProc   := WndCallback;
        cbClsExtra    := 0;
        cbWndExtra    := 0;
        lpszClassName := PChar(WndClassName);
        hInstance     := hInstance;
        hIcon         := LoadIcon(0, IDI_APPLICATION);
        hCursor       := LoadCursor(0, IDC_ARROW);
        hbrBackground := COLOR_BTNFACE + 1;
        lpszMenuName  := '';
      end;
      // Заполняем информацию об окне
      with FWndParams do
      begin
        WndParent := FWndParent;
        Caption := 'Lite Window';
        Style   := WS_OVERLAPPEDWINDOW or WS_VISIBLE;
        ExStyle := 0;
        X       := Integer(CW_USEDEFAULT);
        Y       := Integer(CW_USEDEFAULT);
        Width   := Integer(CW_USEDEFAULT);
        Height  := Integer(CW_USEDEFAULT);
        WndMenu := 0;
        Param   := nil;
      end;
    end;
     
    ////////////////////////////////////////////////////////////////////////////////
    // TLiteWindow
    // _____________________________________________________________________________
    // Функции обработки сообщений
    ////////////////////////////////////////////////////////////////////////////////
     
    ////////////////////////////////////////////////////////////////////////////////
    // Обработчик сообщений по умолчанию
    ////////////////////////////////////////////////////////////////////////////////
    procedure TLiteWindow.DefaultHandler(var Msg);
    begin
      // Наш объект - объект субклассиннга ?
      if FWndSubclass = nil then
        // Вызываем системную функцию обработки сообщений
        with TMessage(Msg) do 
          Result := DefWindowProc(FWndHandle, Msg, WParam, LParam)
      else
        // Вызываем старую оконную функцию обработки сообщений
        with TMessage(Msg) do 
          Result := CallWindowProc(FWndSubclass, FWndHandle, Msg, WParam, LParam);
    end;
     
**Реализация диалогового класса TLiteDialog**

    ////////////////////////////////////////////////////////////////////////////////
    // TLiteDialog
    // _____________________________________________________________________________
    // Инициализация / финализация
    ////////////////////////////////////////////////////////////////////////////////
     
    ////////////////////////////////////////////////////////////////////////////////
    // Конструктор
    ////////////////////////////////////////////////////////////////////////////////
    constructor TLiteDialog.Create(AWndParent: THandle);
    begin
      inherited;
      // Формируем параметры диалога
      CreateDialogParams(FDlgParams);
      // Создаем диалог
      with FDlgParams do
        CreateDialogParam(hInstance, Template, WndParent, WndCallback, 0);
    end;
     
    ////////////////////////////////////////////////////////////////////////////////
    // Деструктор
    ////////////////////////////////////////////////////////////////////////////////
    destructor TLiteDialog.Destroy;
    begin
      // Уничтожаем диалог
      if IsWindow(FWndHandle) then DestroyWindow(FWndHandle);
      // Уничтожение по умолчанию
      inherited;
    end;
     
    ////////////////////////////////////////////////////////////////////////////////
    // Формирование параметров диалога по умолчанию
    ////////////////////////////////////////////////////////////////////////////////
    procedure TLiteDialog.CreateDialogParams(var DialogParams: TDialogParams);
    begin
      DialogParams.WndParent := FWndParent;
      DialogParams.Template  := '';
    end;
     
    ////////////////////////////////////////////////////////////////////////////////
    // Обработка сообщений по умолчанию
    ////////////////////////////////////////////////////////////////////////////////
    procedure TLiteDialog.DefaultHandler(var Msg);
    begin
      // Возвращаемые значения по умолчанию
      with TMessage(Msg) do
        if Msg = WM_INITDIALOG then Result := 1
                               else Result := 0;
    end;
     
**Реализация модального диалогового класса TLiteDialogBox**

    ////////////////////////////////////////////////////////////////////////////////
    // TLiteDialogBox
    // _____________________________________________________________________________
    // Инициализация / финализация
    ////////////////////////////////////////////////////////////////////////////////
     
    ////////////////////////////////////////////////////////////////////////////////
    // Формирование параметров диалога по умолчанию
    ////////////////////////////////////////////////////////////////////////////////
    procedure TLiteDialogBox.CreateDialogParams(var DialogParams: TDialogParams);
    begin
      DialogParams.WndParent := FWndParent;
      DialogParams.Template  := '';
    end;
     
    ////////////////////////////////////////////////////////////////////////////////
    // Активизация модального диалога
    ////////////////////////////////////////////////////////////////////////////////
    function TLiteDialogBox.ShowModal: Integer;
    begin
      // Формируем параметры диалога
      CreateDialogParams(FDlgParams);
      // Показываем диалог
      with FDlgParams do
        Result := DialogBoxParam(hInstance, Template, WndParent, WndCallback, 0);
    end;
     
    ////////////////////////////////////////////////////////////////////////////////
    // Обработка сообщений по умолчанию
    ////////////////////////////////////////////////////////////////////////////////
    procedure TLiteDialogBox.DefaultHandler(var Msg);
    begin
      // Возвращаемые значения по умолчанию
      with TMessage(Msg) do
        if Msg = WM_INITDIALOG then Result := 1
                               else Result := 0;
    end;
     
    end.
