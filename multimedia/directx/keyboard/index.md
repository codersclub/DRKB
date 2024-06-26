---
Title: Пример использования DirectInput для опроса клавиатуры
Author: Виктор Кода
Date: 24.03.2002
Source: https://podgoretsky.com
---


Пример использования DirectInput для опроса клавиатуры
======================================================

    {******************************************************************************
     *                                                                            *
     *  Придумал и написал Кода Виктор, Март 2002                                 *
     *                                                                            *
     *  Файл:       main.pas                                                      *
     *  Содержание: Пример использования DirectInput для опроса клавиатуры        *
     *                                                                            *
     ******************************************************************************}
    unit main;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, ComCtrls,
      StdCtrls, ExtCtrls;
     
    type
      TForm1 = class(TForm)
        gb1: TGroupBox;
        gb2: TGroupBox;
        gb3: TGroupBox;
        lbRemark: TLabel;
        imView: TImage;
        rbWM: TRadioButton;
        rgDI8: TRadioButton;
        lbKeys: TLabel;
        lbIndex: TLabel;
        btnClose: TButton;
        procedure FormCreate(Sender: TObject);
        procedure btnCloseClick(Sender: TObject);
        procedure FormDestroy(Sender: TObject);
      private
        { Private declarations }
      public
        { Public declarations }
        procedure Hook( var Msg: TMsg; var Handled: Boolean );
        procedure Idle( Sender: TObject; var Done: Boolean );
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.DFM}
     
    uses
      DirectInput8;
     
    //------------------------------------------------------------------------------
    // Константы и глобальные переменные
    //------------------------------------------------------------------------------
    var
      lpDI8:        IDirectInput8       = nil;
      lpDIKeyboard: IDirectInputDevice8 = nil;
     
      nXPos,
      nYPos:         Integer;
     
    //------------------------------------------------------------------------------
    // Имя:      InitDirectInput()
    // Описание: Производит инициализацию объектов DirectInput в программе
    //------------------------------------------------------------------------------
    function InitDirectInput( hWnd: HWND ): Boolean;
    begin
      Result := FALSE;
     
      // Создаём главный объект DirectInput
      if FAILED( DirectInput8Create( GetModuleHandle( 0 ), DIRECTINPUT_VERSION,
                                     IID_IDirectInput8, lpDI8, nil ) ) then
         Exit;
      lpDI8._AddRef();
     
      // Создаём объект для работы с клавиатурой
      if FAILED( lpDI8.CreateDevice( GUID_SysKeyboard, lpDIKeyboard, nil ) ) then
         Exit;
      lpDIKeyboard._AddRef();
     
      // Устанавливаем предопределённый формат для "простогй клавиатуры". В боль-
      // шинстве случаев можно удовлетвориться и установками, заданными в структуре
      // c_dfDIKeyboard по умолчанию, но в особых случаях нужно заполнить её самому
      if FAILED( lpDIKeyboard.SetDataFormat( @c_dfDIKeyboard ) ) then
         Exit;
     
      // Устанавливаем уровень кооперации. Подробности о флагах смотри в DirectX SDK
      if FAILED( lpDIKeyboard.SetCooperativeLevel( hWnd, DISCL_BACKGROUND or
                                                         DISCL_NONEXCLUSIVE ) ) then
         Exit;
     
      // Захвытываем клавиатуру
      lpDIKeyboard.Acquire();
     
      Result := TRUE;
    end;
     
    //------------------------------------------------------------------------------
    // Имя:      ReleaseDirectInput()
    // Описание: Производит удаление объектов DirectInput
    //------------------------------------------------------------------------------
    procedure ReleaseDirectInput();
    begin
      // Удаляем объект для работы с клавиатурой
      if lpDIKeyboard <> nil then // Можно проверить if Assigned( DIKeyboard )
      begin
        lpDIKeyboard.Unacquire(); // Освобождаем устройство
        lpDIKeyboard._Release();
        lpDIKeyboard := nil;
      end;
     
      // Последним удаляем главный объект DirectInput
      if lpDI8 <> nil then
      begin
        lpDI8._Release();
        lpDI8 := nil;
      end;
    end;
     
    //------------------------------------------------------------------------------
    // Имя:      UpdateKeyboardState()
    // Описание: Обрабатывает клавиатурный ввод методом DirectInput
    //------------------------------------------------------------------------------
    function UpdateKeyboardState(): Boolean;
    var
      bKeyBuffer: array [0..255] of Byte;
      i:          Integer;
     
      hr:         HRESULT;
    begin
      Result := FALSE;
     
      // Производим опрос состояния клавиш, данные записываются в буфер-массив
      if lpDIKeyboard.GetDeviceState( SizeOf( bKeyBuffer ), @bKeyBuffer ) = DIERR_INPUTLOST then
      begin
        // Захватываем снова
        lpDIKeyboard.Acquire();
        // Производим повторный опрос
        if FAILED( lpDIKeyboard.GetDeviceState( SizeOf( bKeyBuffer ), @bKeyBuffer ) ) then
           Exit;
      end;
     
      // Изменяем координаты курсора
      if bKeyBuffer[ DIK_NUMPAD4 ] = $080 then Dec( nXPos );
      if bKeyBuffer[ DIK_NUMPAD6 ] = $080 then Inc( nXPos );
      if bKeyBuffer[ DIK_NUMPAD8 ] = $080 then Dec( nYPos );
      if bKeyBuffer[ DIK_NUMPAD2 ] = $080 then Inc( nYPos );
     
      // Выводим список кодов нажатых клавиш
      with Form1.lbKeys do
      begin
        Caption := '';
     
        for i := 0 to 255 do
        if bKeyBuffer[ i ] = $080 then
        if i <= 9 then Caption := Caption + Format( '0%d ', [ i ] )
                  else Caption := Caption + Format( '%d ', [ i ] );
      end;
     
      Result := TRUE;
    end;
     
    //------------------------------------------------------------------------------
    // Имя:      TForm1.Hook()
    // Описание: Обрабатывает клавиатурный ввод подобно главной функции окна
    //------------------------------------------------------------------------------
    procedure TForm1.Hook( var Msg: TMsg; var Handled: Boolean );
    var
      i: Integer;
    begin
      if Msg.message <> WM_KEYDOWN then
         Exit;
     
      // Изменяем координаты курсора
      case Msg.wParam of
         VK_NUMPAD4: Dec( nXPos );
         VK_NUMPAD6: Inc( nXPos );
         VK_NUMPAD8: Dec( nYPos );
         VK_NUMPAD2: Inc( nYPos );
      end;
     
      // Выводим код нажатой клавиши
      with Form1.lbKeys do
      begin
        Caption := '';
     
        // Бессмысленно писать for i := 0 to 255 do ... При обработке сообщения
        // WM_KEYDOWN мы можем узнать состояние только одной клавиши - ведь массив
        // не используется. Справедливоси ради надо сказать, что в Windows есть
        // функция GetKeyboardState(), работающая с массивом и очень быстро
        if Msg.wParam <= 9 then Caption := Caption + Format( '0%d ', [ Msg.wParam ] )
                           else Caption := Caption + Format( '%d ', [ Msg.wParam ] );
      end;
     
      // Блокируем дальнейшую обработку события
      Handled := TRUE;
    end;
     
    //------------------------------------------------------------------------------
    // Имя:      TForm1.Idle()
    // Описание: Вызывает функцию опроса состояния клавиатуры
    //------------------------------------------------------------------------------
    procedure TForm1.Idle( Sender: TObject; var Done: Boolean );
    var
      i: Integer;
    begin
      if rbWM.Checked then Application.OnMessage := Hook
      else
      begin
        Application.OnMessage := nil;
     
        // Если данные от клавиатуры не получены
        if not UpdateKeyboardState() then
        begin
           MessageBox( Form1.Handle, 'Потеряно устройство управления!',
                      'Ошибка!', MB_ICONHAND );
           Form1.Close();
        end;
      end;
     
      // Проверяем выход курсора за пределы диапазона
      if nXPos < 0        then nXPos := 0;
      if nXPos + 10 > 140 then nXPos := 130;
      if nYPos < 0        then nYPos := 0;
      if nYPos + 10 > 140 then nYPos := 130;
     
      // Рисуем курсор
      with imView.Canvas do
      begin
        FillRect( Canvas.ClipRect );
     
        Brush.Color := clRed;
        Rectangle( nXPos, nYPos, nXPos + 10, nYPos + 10 );
        Brush.Color := clWhite;
      end;
     
      Done := FALSE;
    end;
     
    //------------------------------------------------------------------------------
    // Имя:      TForm1.FormCreate()
    // Описание: Производит инициализацию DirectInput при старте программы
    //------------------------------------------------------------------------------
    procedure TForm1.FormCreate(Sender: TObject);
    begin
      if not InitDirectInput( Form1.Handle ) then
      begin
        MessageBox( Form1.Handle, 'Ошибка при инициализации DirectInput!',
                    'Ошибка!', MB_ICONHAND );
        ReleaseDirectInput();
        Halt;
      end;
     
      // Приводим UI в соответствующий вид
      lbKeys.Caption := '';
     
      // Назначаем обработчик Idle-события. Компонент TTimer не позволит раскрыть
      // всех преимуществ использования DirectInput
      Application.OnIdle := Idle;
    end;
     
    //------------------------------------------------------------------------------
    // Имя:      TForm1.btnCloseClick()
    // Описание: Закрывает программу
    //------------------------------------------------------------------------------
    procedure TForm1.btnCloseClick(Sender: TObject);
    begin
      Form1.Close();
    end;
     
    //------------------------------------------------------------------------------
    // Имя:      TForm1.FormDestroy()
    // Описание: Вызывается при удалении программы из памяти
    //------------------------------------------------------------------------------
    procedure TForm1.FormDestroy(Sender: TObject);
    begin
      ReleaseDirectInput();
    end;
     
    end.

Форма:

    object Form1: TForm1
      Left = 192
      Top = 106
      BorderIcons = [biSystemMenu, biMinimize]
      BorderStyle = bsSingle
      Caption = 'DirectInput 8: Клавиатура'
      ClientHeight = 318
      ClientWidth = 377
      Color = clBtnFace
      Font.Charset = DEFAULT_CHARSET
      Font.Color = clWindowText
      Font.Height = -11
      Font.Name = 'MS Sans Serif'
      Font.Style = []
      OldCreateOrder = False
      Position = poScreenCenter
      OnCreate = FormCreate
      OnDestroy = FormDestroy
      PixelsPerInch = 96
      TextHeight = 13
      object lbRemark: TLabel
        Left = 8
        Top = 8
        Width = 338
        Height = 13
        Caption = 'Используйте num-клавиши клавиатуры для перемещения курсора'
      end
      object btnClose: TButton
        Left = 294
        Top = 288
        Width = 75
        Height = 23
        Cancel = True
        Caption = 'Закрыть'
        TabOrder = 0
        OnClick = btnCloseClick
      end
      object gb1: TGroupBox
        Left = 8
        Top = 32
        Width = 177
        Height = 177
        Caption = 'Визуальная проверка'
        TabOrder = 1
        object imView: TImage
          Left = 19
          Top = 24
          Width = 140
          Height = 140
        end
      end
      object gb3: TGroupBox
        Left = 8
        Top = 216
        Width = 361
        Height = 65
        Caption = 'Клавиши'
        TabOrder = 2
        object lbKeys: TLabel
          Left = 64
          Top = 24
          Width = 289
          Height = 17
          AutoSize = False
          Caption = 'lbKeys'
        end
        object lbIndex: TLabel
          Left = 8
          Top = 24
          Width = 49
          Height = 13
          Caption = 'Индексы:'
        end
      end
      object gb2: TGroupBox
        Left = 200
        Top = 32
        Width = 169
        Height = 177
        Caption = 'Способ опроса'
        TabOrder = 3
        object rbWM: TRadioButton
          Left = 24
          Top = 56
          Width = 129
          Height = 17
          Caption = 'Windows Messaging'
          Checked = True
          TabOrder = 0
          TabStop = True
        end
        object rgDI8: TRadioButton
          Left = 24
          Top = 104
          Width = 129
          Height = 17
          Caption = 'DirectInput 8'
          TabOrder = 1
        end
      end
    end

Взято с сайта Анатолия Подгорецкого  <https://podgoretsky.com>

по материалам fido7.ru.delphi.*
