---
Title: Пример опроса мыши методами DirectInput
author: Виктор Кода
Date: 21.03.2002
Source: https://podgoretsky.com
---


Пример опроса мыши методами DirectInput
=======================================

Вариант 1:

    {******************************************************************************
     *                                                                            *
     *  Придумал и написал Кода Виктор, Март 2002                                 *
     *                                                                            *
     *  Файл:       main.pas                                                      *
     *  Содержание: Пример буферизированного опроса мыши методами DirectInput     *
     *                                                                            *
     ******************************************************************************}
    unit main;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, StdCtrls,
      ExtCtrls;
     
    type
      TForm1 = class(TForm)
        gb1: TGroupBox;
        lbX0: TLabel;
        lbY0: TLabel;
        lbX: TLabel;
        lbY: TLabel;
        lb1: TLabel;
        lb2: TLabel;
        lb3: TLabel;
        lb4: TLabel;
        lbBtn1: TLabel;
        lbBtn2: TLabel;
        lbBtn3: TLabel;
        lbBtn4: TLabel;
        imCursor: TImage;
        procedure FormActivate(Sender: TObject);
        procedure FormKeyDown(Sender: TObject; var Key: Word;
          Shift: TShiftState);
        procedure FormDestroy(Sender: TObject);
      private
        { Private declarations }
      public
        { Public declarations }
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
      lpDI8:     IDirectInput8       = nil;
      lpDIMouse: IDirectInputDevice8 = nil;
     
      mouseX:    LongInt = 0;
      mouseY:    LongInt = 0;
     
    //------------------------------------------------------------------------------
    // Имя:      InitDirectInput()
    // Описание: Производит инициализацию объектов DirectInput в программе
    //------------------------------------------------------------------------------
    function InitDirectInput( hWnd: HWND ): Boolean;
    var
      dipropdw: TDIPROPDWORD; // Структура для задания характеристик мыши
    begin
      Result := FALSE;
     
      // Создаём главный объект DirectInput
      if FAILED( DirectInput8Create( GetModuleHandle( 0 ), DIRECTINPUT_VERSION,
                                     IID_IDirectInput8, lpDI8, nil ) ) then
         Exit;
      lpDI8._AddRef();
     
      // Создаём объект для работы с мышью
      if FAILED( lpDI8.CreateDevice( GUID_SysMouse, lpDIMouse, nil ) ) then
         Exit;
      lpDIMouse._AddRef();
     
      // Устанавлаваем предопределённый формат данных
      if FAILED( lpDIMouse.SetDataFormat( @c_dfDIMouse ) ) then
         Exit;
     
      // Устанавливаем уровень кооперации
      if FAILED( lpDIMouse.SetCooperativeLevel( hWnd, DISCL_FOREGROUND or
                                                      DISCL_EXCLUSIVE ) ) then
         Exit;
     
      // Подготавливаем структуру TDIPROPDWORD, она поможет установить нам
      // буферизированный опрос мыши
      ZeroMemory( @dipropdw, SizeOf( TDIPROPDWORD ) );
      dipropdw.diph.dwSize := SizeOf( TDIPROPDWORD );
      dipropdw.diph.dwHeaderSize := SizeOf( TDIPROPHEADER );
     
      dipropdw.diph.dwObj := 0;
      dipropdw.diph.dwHow := DIPH_DEVICE; // Изменяем х-ки всего устройства
      dipropdw.dwData := 16;              // Размер буфера для данных (по умолчанию 0)
     
      // Устанавливаем размер буфера для мыши
      if FAILED( lpDIMouse.SetProperty( DIPROP_BUFFERSIZE, dipropdw.diph ) ) then
         Exit;
     
      // Захвытываем мышь
      lpDIMouse.Acquire();
     
      Result := TRUE;
    end;
     
    //------------------------------------------------------------------------------
    // Имя:      ReleaseDirectInput()
    // Описание: Производит удаление объектов DirectInput
    //------------------------------------------------------------------------------
    procedure ReleaseDirectInput();
    begin
      // Удаляем объект для работы с мышью
      if lpDIMouse <> nil then
      begin
        lpDIMouse.Unacquire();
        lpDIMouse._Release();
        lpDIMouse := nil;
      end;
     
      // Удаляем главный объект DirectInput (всегда последним)
      if lpDI8 <> nil then
      begin
        lpDI8._Release();
        lpDI8 := nil;
      end;
    end;
     
    //------------------------------------------------------------------------------
    // Имя:      GetMouseCaps()
    // Описание: Получает характеристики мыши (определяет кол-во кнопок)
    //------------------------------------------------------------------------------
    procedure GetMouseCaps();
    var
      lpCaps: TDIDEVCAPS; // Структура для получения данных об элементах мыши
    begin
      // Подготавливаем структуру TDIDEVCAPS (для получения характеристик мыши)
      ZeroMemory( @lpCaps, SizeOf( TDIDEVCAPS ) );
      lpCaps.dwSize := SizeOf( TDIDEVCAPS );
     
      // Получаем характеристики мыши, данные записывааются в структуру lpCaps
      lpDIMouse.GetCapabilities( lpCaps );
     
      // Приводим UI в соответствующий вид
      with Form1 do
      begin
        if lpCaps.dwButtons > 0 then
        begin
          lb1.Enabled := TRUE; lbBtn1.Enabled := TRUE;
        end;
     
        if lpCaps.dwButtons > 1 then
        begin
          lb2.Enabled := TRUE; lbBtn2.Enabled := TRUE;
        end;
     
        if lpCaps.dwButtons > 2 then
        begin
          lb3.Enabled := TRUE; lbBtn3.Enabled := TRUE;
        end;
     
        if lpCaps.dwButtons > 3 then
        begin
          lb4.Enabled := TRUE; lbBtn4.Enabled := TRUE;
        end;
      end;
    end;
     
    //------------------------------------------------------------------------------
    // Имя:      UpdateMouseState()
    // Описание: Производит опрос мыши и выводит данные в окно
    //------------------------------------------------------------------------------
    function UpdateMouseState( var(*по параметру*)dwX, dwY: DWORD ): Boolean;
    var
      od:         TDIDEVICEOBJECTDATA;
      dwElements: DWORD;
    begin
      Result := FALSE;
     
      // Обазательно обнуляем!
      dwX := 0;
      dwY := 0;
     
      dwElements := 1;
     
      // Пока количество опрашиваемых элементов мыши (оси, кнопки, колёсики ) <> 0
      while dwElements <> 0 do
      begin
        // Получаем данные от мыши
        if lpDIMouse.GetDeviceData( SizeOf( TDIDEVICEOBJECTDATA ), @od,
                                    dwElements, 0 ) = DIERR_INPUTLOST then
        begin
          // Снова захватываем
          lpDIMouse.Acquire();
          // Если всё бесполезно, то выходим
          if FAILED( lpDIMouse.GetDeviceData( SizeOf( TDIDEVICEOBJECTDATA ), @od,
                                              dwElements, 0 ) ) then
             Exit;
        end;
     
        with Form1 do
        begin
          case od.dwOfs of
            DIMOFS_X:       dwX := od.dwData;
            DIMOFS_Y:       dwY := od.dwData;
            DIMOFS_BUTTON0: if od.dwData = $080 then lbBtn1.Caption := 'Нажата'
                                                else lbBtn1.Caption := '';
            DIMOFS_BUTTON1: if od.dwData = $080 then lbBtn2.Caption := 'Нажата'
                                                else lbBtn2.Caption := '';
            DIMOFS_BUTTON2: if od.dwData = $080 then lbBtn3.Caption := 'Нажата'
                                                else lbBtn3.Caption := '';
            DIMOFS_BUTTON3: if od.dwData = $080 then lbBtn4.Caption := 'Нажата'
                                                else lbBtn4.Caption := '';
          end;
        end;
      end;
     
      Result := TRUE;
    end;
     
    //------------------------------------------------------------------------------
    // Имя:      TForm1.Idle()
    // Описание: Вызывает функцию опроса состояния мыши
    //------------------------------------------------------------------------------
    procedure TForm1.Idle( Sender: TObject; var Done: Boolean );
    var
      dwOffsX,
      dwOffsY: DWORD; // Смещение мыши
    begin
      // Получаем данные и записываем их в offsX и offsY
      if not UpdateMouseState( dwOffsX, dwOffsY ) then
      begin
        MessageBox( Form1.Handle, 'Потеряно устройство ввода!',
                    'Ошибка', MB_ICONHAND );
        Form1.Close();
      end;
     
      // Вычисляем абсолютные координаты
      Inc( mouseX, dwOffsX );
      Inc( mouseY, dwOffsY );
     
      lbX.Caption := Format( '%d', [ mouseX ] );
      lbY.Caption := Format( '%d', [ mouseY ] );
     
      imCursor.Left := 234 + mouseX; // 234 - координата, если мы хотим, чтобы
      imCursor.Top  := 234 + mouseY; // курсор был с начала работы в центре окна
     
      Done := FALSE;
    end;
     
    //------------------------------------------------------------------------------
    // Имя:      TForm1.FormActivate()
    // Описание: Производит инициализацию DirectInput при активизации окна
    //------------------------------------------------------------------------------
    procedure TForm1.FormActivate(Sender: TObject);
    begin
      if not InitDirectInput( Form1.Handle ) then
      begin
        MessageBox( Form1.Handle, 'Ошибка при инициализации DirectInput!',
                    'Ошибка!', MB_ICONHAND );
        Form1.Close();
      end;
     
      // Получаем характеристики мыши (сколько кнопок?). Кстати, я не знаю - как
      // определить, есть ли у мыши колёсико?
      GetMouseCaps();
     
      // Приводим UI в соответствующий вид
      lbBtn1.Caption := '';
      lbBtn2.Caption := '';
      lbBtn3.Caption := '';
      lbBtn4.Caption := '';
     
      Application.OnIdle := Idle;
    end;
     
    //------------------------------------------------------------------------------
    // Имя:      TForm1.FormKeyDown()
    // Описание: Обрабатывает клавиатурный ввод
    //------------------------------------------------------------------------------
    procedure TForm1.FormKeyDown(Sender: TObject; var Key: Word;
      Shift: TShiftState);
    begin
      if Key = VK_ESCAPE then Form1.Close();
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
      Left = 221
      Top = 31
      BorderIcons = []
      BorderStyle = bsSingle
      Caption = 
        'DirectInput 8: буферизированный опрос мыши (нажмите Esc для выхо' +
        'да)'
      ClientHeight = 500
      ClientWidth = 500
      Color = clBtnFace
      Font.Charset = DEFAULT_CHARSET
      Font.Color = clWindowText
      Font.Height = -11
      Font.Name = 'MS Sans Serif'
      Font.Style = []
      KeyPreview = True
      OldCreateOrder = False
      Position = poScreenCenter
      OnActivate = FormActivate
      OnDestroy = FormDestroy
      OnKeyDown = FormKeyDown
      PixelsPerInch = 96
      TextHeight = 13
      object imCursor: TImage
        Left = 234
        Top = 234
        Width = 32
        Height = 32
        AutoSize = True
        Picture.Data = {
          055449636F6E0000010001002020000001000800A80800001600000028000000
          2000000040000000010008000000000080040000000000000000000000010000
          0000000000000000800080008000000080800000008000000080800000008000
          C0C0C000C0DCC000F0CAA60080808000FF00FF00FF000000FFFF000000FF0000
          00FFFF000000FF00FFFFFF00F0FBFF00A4A0A000D4F0FF00B1E2FF008ED4FF00
          6BC6FF0048B8FF0025AAFF0000AAFF000092DC00007AB90000629600004A7300
          00325000D4E3FF00B1C7FF008EABFF006B8FFF004873FF002557FF000055FF00
          0049DC00003DB900003196000025730000195000D4D4FF00B1B1FF008E8EFF00
          6B6BFF004848FF002525FF000000FF000000DC000000B9000000960000007300
          00005000E3D4FF00C7B1FF00AB8EFF008F6BFF007348FF005725FF005500FF00
          4900DC003D00B900310096002500730019005000F0D4FF00E2B1FF00D48EFF00
          C66BFF00B848FF00AA25FF00AA00FF009200DC007A00B900620096004A007300
          32005000FFD4FF00FFB1FF00FF8EFF00FF6BFF00FF48FF00FF25FF00FF00FF00
          DC00DC00B900B900960096007300730050005000FFD4F000FFB1E200FF8ED400
          FF6BC600FF48B800FF25AA00FF00AA00DC009200B9007A009600620073004A00
          50003200FFD4E300FFB1C700FF8EAB00FF6B8F00FF487300FF255700FF005500
          DC004900B9003D00960031007300250050001900FFD4D400FFB1B100FF8E8E00
          FF6B6B00FF484800FF252500FF000000DC000000B90000009600000073000000
          50000000FFE3D400FFC7B100FFAB8E00FF8F6B00FF734800FF572500FF550000
          DC490000B93D0000963100007325000050190000FFF0D400FFE2B100FFD48E00
          FFC66B00FFB84800FFAA2500FFAA0000DC920000B97A000096620000734A0000
          50320000FFFFD400FFFFB100FFFF8E00FFFF6B00FFFF4800FFFF2500FFFF0000
          DCDC0000B9B90000969600007373000050500000F0FFD400E2FFB100D4FF8E00
          C6FF6B00B8FF4800AAFF2500AAFF000092DC00007AB90000629600004A730000
          32500000E3FFD400C7FFB100ABFF8E008FFF6B0073FF480057FF250055FF0000
          49DC00003DB90000319600002573000019500000D4FFD400B1FFB1008EFF8E00
          6BFF6B0048FF480025FF250000FF000000DC000000B900000096000000730000
          00500000D4FFE300B1FFC7008EFFAB006BFF8F0048FF730025FF570000FF5500
          00DC490000B93D00009631000073250000501900D4FFF000B1FFE2008EFFD400
          6BFFC60048FFB80025FFAA0000FFAA0000DC920000B97A000096620000734A00
          00503200D4FFFF00B1FFFF008EFFFF006BFFFF0048FFFF0025FFFF0000FFFF00
          00DCDC0000B9B900009696000073730000505000F2F2F200E6E6E600DADADA00
          CECECE00C2C2C200B6B6B600AAAAAA009E9E9E0092929200868686007A7A7A00
          6E6E6E0062626200565656004A4A4A003E3E3E0032323200262626001A1A1A00
          0E0E0E0000000000000000000000000000000000000000000000000000000000
          0000000000000000000000000000000000000000000000000000000000000000
          0000000000000000000000000000000000000000000000000000000000000000
          0000000000000000000000000000000000000000000000000000000000000000
          0000000000000000000000000000000000000000000000000000000000000000
          0000000000000000000000000000000000000000000000000000000000000000
          0000000000000000000000000000000000000000000000000000000000000000
          0000000000000000000000000000000000000000000000000000000000000000
          0000000000000000000000000000000000000000000000000000000000000000
          0000000000000000000000000000000000000000000000000000000000000000
          0000000000000000000000000000000000000000000000000000000000000000
          0000000000000000000000000000000000000000000000000000000000000000
          0000000000000000000000000000000000000000000000000000000000000000
          0000000000000000000000BABA00000000000000000000000000000000000000
          00000000000000000000C5C5C5BA000000000000000000000000000000000000
          00000000000000000000C5ABC5BA000000000000000000000000000000000000
          000000000000000000C5ABC5BA00000000000000000000000000000000000000
          00000000C500000000C5ABC5BA00000000000000000000000000000000000000
          00000000C2C50000C5ABC5BA0000000000000000000000000000000000000000
          00000000C2C3C500C5ABC5BA0000000000000000000000000000000000000000
          00000000C2C3C3C5ABBABA000000000000000000000000000000000000000000
          00000000C2C3C3C4C4C4C5C5BABAD30000000000000000000000000000000000
          00000000C2C3C3C4C4D1D1D1BAD3000000000000000000000000000000000000
          00000000C2C3C3C4C4D1D1BAD300000000000000000000000000000000000000
          00000000C2C3C4C4D1D1D1D30000000000000000000000000000000000000000
          00000000C2C3C4C4D1D1D3000000000000000000000000000000000000000000
          00000000C2C3C4D1D1BA00000000000000000000000000000000000000000000
          00000000C2C4D1D1BA0000000000000000000000000000000000000000000000
          00000000C2C4D1C5000000000000000000000000000000000000000000000000
          00000000C2C5C500000000000000000000000000000000000000000000000000
          00000000C2C50000000000000000000000000000000000000000000000000000
          00000000D0000000000000000000000000000000000000000000000000000000
          00000000FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF
          FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFE7FFFFFFC3FFFFF
          FC3FFFFFF87FFFFF787FFFFF30FFFFFF10FFFFFF01FFFFFF001FFFFF003FFFFF
          007FFFFF00FFFFFF01FFFFFF03FFFFFF07FFFFFF0FFFFFFF1FFFFFFF3FFFFFFF
          7FFFFFFF}
      end
      object gb1: TGroupBox
        Left = 360
        Top = 8
        Width = 129
        Height = 145
        Caption = 'Состояние мыши'
        TabOrder = 0
        object lbX0: TLabel
          Left = 17
          Top = 24
          Width = 10
          Height = 13
          Caption = 'X:'
        end
        object lbY0: TLabel
          Left = 17
          Top = 40
          Width = 10
          Height = 13
          Caption = 'Y:'
        end
        object lb1: TLabel
          Left = 16
          Top = 64
          Width = 46
          Height = 13
          Caption = 'Кнопка1:'
          Enabled = False
        end
        object lb2: TLabel
          Left = 16
          Top = 80
          Width = 46
          Height = 13
          Caption = 'Кнопка2:'
          Enabled = False
        end
        object lb3: TLabel
          Left = 16
          Top = 96
          Width = 46
          Height = 13
          Caption = 'Кнопка3:'
          Enabled = False
        end
        object lbBtn1: TLabel
          Left = 72
          Top = 64
          Width = 30
          Height = 13
          Caption = 'lbBtn1'
          Enabled = False
        end
        object lbBtn2: TLabel
          Left = 72
          Top = 80
          Width = 30
          Height = 13
          Caption = 'lbBtn2'
          Enabled = False
        end
        object lbBtn3: TLabel
          Left = 72
          Top = 96
          Width = 30
          Height = 13
          Caption = 'lbBtn3'
          Enabled = False
        end
        object lb4: TLabel
          Left = 16
          Top = 112
          Width = 46
          Height = 13
          Caption = 'Кнопка4:'
          Enabled = False
        end
        object lbBtn4: TLabel
          Left = 72
          Top = 112
          Width = 30
          Height = 13
          Caption = 'lbBtn4'
          Enabled = False
        end
        object lbX: TLabel
          Left = 72
          Top = 24
          Width = 6
          Height = 13
          Caption = '0'
        end
        object lbY: TLabel
          Left = 72
          Top = 40
          Width = 6
          Height = 13
          Caption = '0'
        end
      end
    end

------------------------------------------------------------------------

Вариант 2:

А это другой вариант, использующий метод непосредственного опроса мыши методами DirectInput.

    {******************************************************************************
     *                                                                            *
     *  Придумал и написал Кода Виктор, Март 2002                                 *
     *                                                                            *
     *  Файл:       main.pas                                                      *
     *  Содержание: Пример непосредственного опроса мыши методами DirectInput     *
     *                                                                            *
     ******************************************************************************}
    unit main;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, StdCtrls,
      ExtCtrls;
     
    type
      TForm1 = class(TForm)
        gb1: TGroupBox;
        lbX0: TLabel;
        lbY0: TLabel;
        lbX: TLabel;
        lbY: TLabel;
        lb1: TLabel;
        lb2: TLabel;
        lb3: TLabel;
        lb4: TLabel;
        lbBtn1: TLabel;
        lbBtn2: TLabel;
        lbBtn3: TLabel;
        lbBtn4: TLabel;
        imCursor: TImage;
        lbEMail: TLabel;
        procedure FormActivate(Sender: TObject);
        procedure FormKeyDown(Sender: TObject; var Key: Word;
          Shift: TShiftState);
        procedure FormDestroy(Sender: TObject);
      private
        { Private declarations }
      public
        { Public declarations }
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
    const
      CURSOR_SPEED = 2.0;
     
    var
      lpDI8:       IDirectInput8       = nil;
      lpDIMouse:   IDirectInputDevice8 = nil;
     
      dwMouseXPos: DWORD = 0;
      dwMouseYPos: DWORD = 0;
     
     
    //------------------------------------------------------------------------------
    // Имя:      InitDirectInput()
    // Описание: Производит инициализацию объектов DirectInput в программе
    //------------------------------------------------------------------------------
    function InitDirectInput( hWnd: HWND ): Boolean;
    var
      dipropdw: TDIPROPDWORD; // Структура для задания характеристик мыши
    begin
      Result := FALSE;
     
      // Создаём главный объект DirectInput
      if FAILED( DirectInput8Create( GetModuleHandle( 0 ), DIRECTINPUT_VERSION,
                                     IID_IDirectInput8, lpDI8, nil ) ) then
         Exit;
      lpDI8._AddRef();
     
      // Создаём объект для работы с мышью
      if FAILED( lpDI8.CreateDevice( GUID_SysMouse, lpDIMouse, nil ) ) then
         Exit;
      lpDIMouse._AddRef();
     
      // Устанавлаваем предопределённый формат данных
      if FAILED( lpDIMouse.SetDataFormat( @c_dfDIMouse ) ) then
         Exit;
     
      // Устанавливаем уровень кооперации
      if FAILED( lpDIMouse.SetCooperativeLevel( hWnd, DISCL_FOREGROUND or
                                                      DISCL_EXCLUSIVE ) ) then
         Exit;
     
      // Захвытываем мышь
      lpDIMouse.Acquire();
     
      Result := TRUE;
    end;
     
     
    //------------------------------------------------------------------------------
    // Имя:      ReleaseDirectInput()
    // Описание: Производит удаление объектов DirectInput
    //------------------------------------------------------------------------------
    procedure ReleaseDirectInput();
    begin
      // Удаляем объект для работы с мышью
      if lpDIMouse <> nil then
      begin
        lpDIMouse.Unacquire();
        lpDIMouse._Release();
        lpDIMouse := nil;
      end;
     
      // Удаляем главный объект DirectInput (всегда последним)
      if lpDI8 <> nil then
      begin
        lpDI8._Release();
        lpDI8 := nil;
      end;
    end;
     
     
    //------------------------------------------------------------------------------
    // Имя:      GetMouseCaps()
    // Описание: Получает характеристики мыши (определяет кол-во кнопок)
    //------------------------------------------------------------------------------
    procedure GetMouseCaps();
    var
      lpCaps: TDIDEVCAPS; // Структура для получения данных об элементах мыши
    begin
      // Подготавливаем структуру TDIDEVCAPS (для получения характеристик мыши)
      ZeroMemory( @lpCaps, SizeOf( TDIDEVCAPS ) );
      lpCaps.dwSize := SizeOf( TDIDEVCAPS );
     
      // Получаем характеристики мыши, данные записывааются в структуру lpCaps
      lpDIMouse.GetCapabilities( lpCaps );
     
      // Приводим GUI в соответствующий вид
      with Form1 do
      begin
        if lpCaps.dwButtons > 0 then
        begin
          lb1.Enabled := TRUE; lbBtn1.Enabled := TRUE;
        end;
     
        if lpCaps.dwButtons > 1 then
        begin
          lb2.Enabled := TRUE; lbBtn2.Enabled := TRUE;
        end;
     
        if lpCaps.dwButtons > 2 then
        begin
          lb3.Enabled := TRUE; lbBtn3.Enabled := TRUE;
        end;
     
        if lpCaps.dwButtons > 3 then
        begin
          lb4.Enabled := TRUE; lbBtn4.Enabled := TRUE;
        end;
      end;
    end;
     
     
    //------------------------------------------------------------------------------
    // Имя:      UpdateMouseState()
    // Описание: Производит опрос мыши и выводит данные в окно
    //------------------------------------------------------------------------------
    function UpdateMouseState( var(*по параметру*)x, y: DWORD ): Boolean;
    var
      ms: TDIMOUSESTATE;
    begin
      Result := FALSE;
     
      // Получаем данные от мыши
      if lpDImouse.GetDeviceState( SizeOf( TDIMOUSESTATE ), @ms ) = DIERR_INPUTLOST then
      begin
        // Снова захватываем
        lpDIMouse.Acquire();
        // Если всё бесполезно, то выходим
        if FAILED( lpDImouse.GetDeviceState( SizeOf( TDIMOUSESTATE ), @ms ) ) then
           Exit;
      end;
     
      with Form1 do
      begin
        // Вот так можно сделать движение курсора с переменной скоростью
        if ms.lX < 0 then ms.lX := Round( ms.lX * CURSOR_SPEED ) else
        if ms.lX > 0 then ms.lX := Round( ms.lX * CURSOR_SPEED );
     
        if ms.lY < 0 then ms.lY := Round( ms.lY * CURSOR_SPEED ) else
        if ms.lY > 0 then ms.lY := Round( ms.lY * CURSOR_SPEED );
     
        x := ms.lX ;
        y := ms.lY;
     
        //------
     
        if ms.rgbButtons[ 0 ] = $080 then lbBtn1.Caption := 'Нажата'
                                     else lbBtn1.Caption := '';
        if ms.rgbButtons[ 1 ] = $080 then lbBtn2.Caption := 'Нажата'
                                     else lbBtn2.Caption := '';
        if ms.rgbButtons[ 2 ] = $080 then lbBtn3.Caption := 'Нажата'
                                     else lbBtn3.Caption := '';
        if ms.rgbButtons[ 3 ] = $080 then lbBtn4.Caption := 'Нажата'
                                     else lbBtn4.Caption := '';
      end;
     
      Result := TRUE;
    end;
     
     
    //------------------------------------------------------------------------------
    // Имя:      TForm1.Idle()
    // Описание: Вызывает функцию опроса состояния мыши
    //------------------------------------------------------------------------------
    procedure TForm1.Idle( Sender: TObject; var Done: Boolean );
    var
      dwOffsX,
      dwOffsY: DWORD; // Смещение мыши
    begin
      // Получаем данные и записываем их в offsX и offsY
      if not UpdateMouseState( dwOffsX, dwOffsY ) then
      begin
        MessageBox( Form1.Handle, 'Потеряно устройство управления!',
                    'Ошибка!', MB_ICONHAND );
        Form1.Close();
      end;
     
      // Смещаем позицию курсора
      Inc( dwMouseXPos, dwOffsX );
      Inc( dwMouseYPos, dwOffsY );
     
      lbX.Caption := Format( '%d', [ dwMouseXPos ] );
      lbY.Caption := Format( '%d', [ dwMouseYPos ] );
     
      imCursor.Left := 234 + dwMouseXPos; // 234 - координата, если мы хотим, чтобы
      imCursor.Top  := 234 + dwMouseYPos; // курсор был с начала работы в центре окна
     
      Done := FALSE;
    end;
     
     
    //------------------------------------------------------------------------------
    // Имя:      TForm1.FormActivate()
    // Описание: Производит инициализацию DirectInput при активизации окна
    //------------------------------------------------------------------------------
    procedure TForm1.FormActivate(Sender: TObject);
    begin
      if not InitDirectInput( Form1.Handle ) then
      begin
        MessageBox( Form1.Handle, 'Ошибка при инициализации DirectInput!',
                    'Ошибка!', MB_ICONHAND );
        Form1.Close();
      end;
     
      // Получаем характеристики мыши (сколько кнопок?). Кстати, я не знаю - как
      // определить, есть ли у мыши колёсико?
      GetMouseCaps();
     
      // Приводим UI в соответствующий вид
      lbBtn1.Caption := '';
      lbBtn2.Caption := '';
      lbBtn3.Caption := '';
      lbBtn4.Caption := '';
      imCursor.Left := 184; // Курсор центре окна
      imCursor.Top  := 184;
     
      Application.OnIdle := Idle;
    end;
     
     
    //------------------------------------------------------------------------------
    // Имя:      TForm1.FormKeyDown()
    // Описание: Обрабатывает клавиатурный ввод
    //------------------------------------------------------------------------------
    procedure TForm1.FormKeyDown(Sender: TObject; var Key: Word;
      Shift: TShiftState);
    begin
      if Key = VK_ESCAPE then Form1.Close();
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

форма:

    object Form1: TForm1
      Left = 155
      Top = 34
      BorderIcons = []
      BorderStyle = bsSingle
      Caption = 
        'DirectInput 8: непосредственный опрос мыши (нажмите Esc для выхо' +
        'да)'
      ClientHeight = 500
      ClientWidth = 500
      Color = clBtnFace
      Font.Charset = DEFAULT_CHARSET
      Font.Color = clWindowText
      Font.Height = -11
      Font.Name = 'MS Sans Serif'
      Font.Style = []
      KeyPreview = True
      OldCreateOrder = False
      Position = poScreenCenter
      OnActivate = FormActivate
      OnDestroy = FormDestroy
      OnKeyDown = FormKeyDown
      PixelsPerInch = 96
      TextHeight = 13
      object imCursor: TImage
        Left = 234
        Top = 234
        Width = 32
        Height = 32
        AutoSize = True
        Picture.Data = {
          055449636F6E0000010001002020000001000800A80800001600000028000000
          2000000040000000010008000000000080040000000000000000000000010000
          0000000000000000800080008000000080800000008000000080800000008000
          C0C0C000C0DCC000F0CAA60080808000FF00FF00FF000000FFFF000000FF0000
          00FFFF000000FF00FFFFFF00F0FBFF00A4A0A000D4F0FF00B1E2FF008ED4FF00
          6BC6FF0048B8FF0025AAFF0000AAFF000092DC00007AB90000629600004A7300
          00325000D4E3FF00B1C7FF008EABFF006B8FFF004873FF002557FF000055FF00
          0049DC00003DB900003196000025730000195000D4D4FF00B1B1FF008E8EFF00
          6B6BFF004848FF002525FF000000FF000000DC000000B9000000960000007300
          00005000E3D4FF00C7B1FF00AB8EFF008F6BFF007348FF005725FF005500FF00
          4900DC003D00B900310096002500730019005000F0D4FF00E2B1FF00D48EFF00
          C66BFF00B848FF00AA25FF00AA00FF009200DC007A00B900620096004A007300
          32005000FFD4FF00FFB1FF00FF8EFF00FF6BFF00FF48FF00FF25FF00FF00FF00
          DC00DC00B900B900960096007300730050005000FFD4F000FFB1E200FF8ED400
          FF6BC600FF48B800FF25AA00FF00AA00DC009200B9007A009600620073004A00
          50003200FFD4E300FFB1C700FF8EAB00FF6B8F00FF487300FF255700FF005500
          DC004900B9003D00960031007300250050001900FFD4D400FFB1B100FF8E8E00
          FF6B6B00FF484800FF252500FF000000DC000000B90000009600000073000000
          50000000FFE3D400FFC7B100FFAB8E00FF8F6B00FF734800FF572500FF550000
          DC490000B93D0000963100007325000050190000FFF0D400FFE2B100FFD48E00
          FFC66B00FFB84800FFAA2500FFAA0000DC920000B97A000096620000734A0000
          50320000FFFFD400FFFFB100FFFF8E00FFFF6B00FFFF4800FFFF2500FFFF0000
          DCDC0000B9B90000969600007373000050500000F0FFD400E2FFB100D4FF8E00
          C6FF6B00B8FF4800AAFF2500AAFF000092DC00007AB90000629600004A730000
          32500000E3FFD400C7FFB100ABFF8E008FFF6B0073FF480057FF250055FF0000
          49DC00003DB90000319600002573000019500000D4FFD400B1FFB1008EFF8E00
          6BFF6B0048FF480025FF250000FF000000DC000000B900000096000000730000
          00500000D4FFE300B1FFC7008EFFAB006BFF8F0048FF730025FF570000FF5500
          00DC490000B93D00009631000073250000501900D4FFF000B1FFE2008EFFD400
          6BFFC60048FFB80025FFAA0000FFAA0000DC920000B97A000096620000734A00
          00503200D4FFFF00B1FFFF008EFFFF006BFFFF0048FFFF0025FFFF0000FFFF00
          00DCDC0000B9B900009696000073730000505000F2F2F200E6E6E600DADADA00
          CECECE00C2C2C200B6B6B600AAAAAA009E9E9E0092929200868686007A7A7A00
          6E6E6E0062626200565656004A4A4A003E3E3E0032323200262626001A1A1A00
          0E0E0E0000000000000000000000000000000000000000000000000000000000
          0000000000000000000000000000000000000000000000000000000000000000
          0000000000000000000000000000000000000000000000000000000000000000
          0000000000000000000000000000000000000000000000000000000000000000
          0000000000000000000000000000000000000000000000000000000000000000
          0000000000000000000000000000000000000000000000000000000000000000
          0000000000000000000000000000000000000000000000000000000000000000
          0000000000000000000000000000000000000000000000000000000000000000
          0000000000000000000000000000000000000000000000000000000000000000
          0000000000000000000000000000000000000000000000000000000000000000
          0000000000000000000000000000000000000000000000000000000000000000
          0000000000000000000000000000000000000000000000000000000000000000
          0000000000000000000000000000000000000000000000000000000000000000
          0000000000000000000000BABA00000000000000000000000000000000000000
          00000000000000000000C5C5C5BA000000000000000000000000000000000000
          00000000000000000000C5ABC5BA000000000000000000000000000000000000
          000000000000000000C5ABC5BA00000000000000000000000000000000000000
          00000000C500000000C5ABC5BA00000000000000000000000000000000000000
          00000000C2C50000C5ABC5BA0000000000000000000000000000000000000000
          00000000C2C3C500C5ABC5BA0000000000000000000000000000000000000000
          00000000C2C3C3C5ABBABA000000000000000000000000000000000000000000
          00000000C2C3C3C4C4C4C5C5BABAD30000000000000000000000000000000000
          00000000C2C3C3C4C4D1D1D1BAD3000000000000000000000000000000000000
          00000000C2C3C3C4C4D1D1BAD300000000000000000000000000000000000000
          00000000C2C3C4C4D1D1D1D30000000000000000000000000000000000000000
          00000000C2C3C4C4D1D1D3000000000000000000000000000000000000000000
          00000000C2C3C4D1D1BA00000000000000000000000000000000000000000000
          00000000C2C4D1D1BA0000000000000000000000000000000000000000000000
          00000000C2C4D1C5000000000000000000000000000000000000000000000000
          00000000C2C5C500000000000000000000000000000000000000000000000000
          00000000C2C50000000000000000000000000000000000000000000000000000
          00000000D0000000000000000000000000000000000000000000000000000000
          00000000FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF
          FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFE7FFFFFFC3FFFFF
          FC3FFFFFF87FFFFF787FFFFF30FFFFFF10FFFFFF01FFFFFF001FFFFF003FFFFF
          007FFFFF00FFFFFF01FFFFFF03FFFFFF07FFFFFF0FFFFFFF1FFFFFFF3FFFFFFF
          7FFFFFFF}
      end
      object lbEMail: TLabel
        Left = 8
        Top = 480
        Width = 195
        Height = 13
        Caption = 'Кода Виктор, e-mail kodavic@rambler.ru'
        Font.Charset = DEFAULT_CHARSET
        Font.Color = clBlue
        Font.Height = -11
        Font.Name = 'MS Sans Serif'
        Font.Style = []
        ParentFont = False
      end
      object gb1: TGroupBox
        Left = 360
        Top = 8
        Width = 129
        Height = 145
        Caption = 'Состояние мыши'
        TabOrder = 0
        object lbX0: TLabel
          Left = 17
          Top = 24
          Width = 10
          Height = 13
          Caption = 'X:'
        end
        object lbY0: TLabel
          Left = 17
          Top = 40
          Width = 10
          Height = 13
          Caption = 'Y:'
        end
        object lb1: TLabel
          Left = 16
          Top = 64
          Width = 46
          Height = 13
          Caption = 'Кнопка1:'
          Enabled = False
        end
        object lb2: TLabel
          Left = 16
          Top = 80
          Width = 46
          Height = 13
          Caption = 'Кнопка2:'
          Enabled = False
        end
        object lb3: TLabel
          Left = 16
          Top = 96
          Width = 46
          Height = 13
          Caption = 'Кнопка3:'
          Enabled = False
        end
        object lbBtn1: TLabel
          Left = 72
          Top = 64
          Width = 30
          Height = 13
          Caption = 'lbBtn1'
          Enabled = False
        end
        object lbBtn2: TLabel
          Left = 72
          Top = 80
          Width = 30
          Height = 13
          Caption = 'lbBtn2'
          Enabled = False
        end
        object lbBtn3: TLabel
          Left = 72
          Top = 96
          Width = 30
          Height = 13
          Caption = 'lbBtn3'
          Enabled = False
        end
        object lb4: TLabel
          Left = 16
          Top = 112
          Width = 46
          Height = 13
          Caption = 'Кнопка4:'
          Enabled = False
        end
        object lbBtn4: TLabel
          Left = 72
          Top = 112
          Width = 30
          Height = 13
          Caption = 'lbBtn4'
          Enabled = False
        end
        object lbX: TLabel
          Left = 72
          Top = 24
          Width = 6
          Height = 13
          Caption = '0'
        end
        object lbY: TLabel
          Left = 72
          Top = 40
          Width = 6
          Height = 13
          Caption = '0'
        end
      end
    end

Взято с сайта Анатолия Подгорецкого  <https://podgoretsky.com>

по материалам fido7.ru.delphi.*
