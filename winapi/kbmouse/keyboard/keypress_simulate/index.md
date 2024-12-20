---
Title: Програмная эмуляция нажатия клавиш
Author: Robert Wittig
Date: 01.01.2007
---


Програмная эмуляция нажатия клавиш
==================================

Вариант 1:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

**Использование клавиш для управления компонентами.**

Так, если у меня есть своего рода кнопка (check, radio, speed и т.п.),
то почему я не могу с помощью клавиш курсора управлять ею?

После некоторых экспериметов я создал метод, который привожу ниже,
способный перехватывать в форме все нажатые клавиши позиционирования и
управлять ими выбранным в настоящий момент элементом управления. Имейте
в виду, что элементы управления (кроме компонентов Label) должны иметь
возможность "выбираться". Для возможности выбрать GroupBox или другой
компонент, удедитесь, что их свойство TabStop установлено в True. Вы
можете переместить управление на GroupBox, но, так как он не выделяется
целиком, узнать, что он действительно имеет управление, достаточно
непросто. Если вам не нужно передавать управление в контейнерные
элементы (нижеследующий код исходит из этого предположения), то вы
можете управлять элементами, просто перемещая управление в сам GroupBox.

В нижеследующем коде FormActivate является обработчиком события формы
OnActivate, тогда как ProcessFormMessages никакого отношения к событиям
формы не имеет. Не забудьте поместить объявление процедуры
ProcessFormMessages в секцию \'Private\' класса вашей формы.

Надеюсь, что вам помог.

    procedure TForm1.FormActivate(Sender: TObject);
    begin
      { Делаем ссылку на нового обработчика сообщений }
      Application.OnMessage := ProcessFormMessages;
    end;
     
    procedure tForm1.ProcessFormMessages(var Msg: tMsg;
      var Handled: Boolean);
    var
      Increment: Byte;
      TheControl: tWinControl;
    begin
      { проверка наличия системного сообщения KeyDown }
      case Msg.Message of
        WM_KEYDOWN: if Msg.wParam in [VK_UP, VK_DOWN, VK_LEFT, VK_RIGHT] then
          begin
            { изменяем величину приращения взависимости
            от состояния клавиши Shift }
            if GetKeyState(VK_SHIFT) and $80 = 0 then
              Increment := 8
            else
              Increment := 1;
     
            { Этот код перемещает управление на родительский
            GroupBox, если один из его контейнерных элементов
            получает фокус. Если вам необходимо управлять
            элементами внутри контейнера, удалите блок IF и
            измените в блоке CASE TheControl на ActiveControl }
     
            if (ActiveControl.Parent is tGroupBox) then
              TheControl := ActiveControl.Parent
            else
              TheControl := ActiveControl;
     
            case Msg.wParam of
              VK_UP: TheControl.Top := TheControl.Top - Increment;
              VK_DOWN: TheControl.Top := TheControl.Top + Increment;
              VK_LEFT: TheControl.Left := TheControl.Left - Increment;
              VK_RIGHT: TheControl.Left := TheControl.Left + Increment;
            end;
     
            { сообщаем о том, что сообщение обработано }
            Handled := True;
          end;
      end;
    end;


------------------------------------------------------------------------

Вариант 2:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

**Как посылать нажатие клавиш в элемент управления.**

Ниже приведена процедура, позволяющаю отправлять нажатия в любой элемент
управления (window control), способный принимать ввод с клавиатуры. Вы
можете использовать эту технику чтобы включать клавиши NumLock, CapsLock
и ScrollLock под Windows NT. Та же техника работает и под Windows 95 для
CapsLock и ScrollLock но не работает для клавиши NumLock.

Обратите внимание, что приведены четыре поцедуры: SimulateKeyDown() -
эмулировать нажатие клавиши (без отпускания) SimulateKeyUp() -
эмулировать отпускание клавиши SimulateKeystroke() - эмулировать удар по
клавише (нажатие и отпускание) и SendKeys(), позволяющие Вам гибко
контролировать посылаемые сообщения клавиатуры.

SimulateKeyDown(), SimulateKeyUp() и SimulateKeystroke() получают коды
виртуальных клавиш (virtural key) (вроде VK\_F1). Процедура
SimulateKeystroke() получает дополнительный параметр, полезный при
эмуляции нажатия PrintScreen. Когда этот параметр равен нулю весь экран
будет скопирован в буфер обмена (clipboard). Если дополнительный
параметр равен 1 будет скопированно только активное окно.

Четыре метода "button click" демонстрируют использование:
- ButtonClick1 - включает capslock
- ButtonClick2 - перехватывает весь экран в буфер
обмена (clipboard).
-  ButtonClick3 - перехватывает активное окно в буфер
обмена (clipboard).
-  ButtonClick4 - устанавливает фокус в Edit и
отправляет в него строку.

    procedure SimulateKeyDown(Key: byte);
    begin
      keybd_event(Key, 0, 0, 0);
    end;
     
    procedure SimulateKeyUp(Key: byte);
    begin
      keybd_event(Key, 0, KEYEVENTF_KEYUP, 0);
    end;
     
    procedure SimulateKeystroke(Key: byte; extra: DWORD);
    begin
      keybd_event(Key, extra, 0, 0);
      keybd_event(Key, extra, KEYEVENTF_KEYUP, 0);
    end;
     
    procedure SendKeys(s: string);
    var
      i: integer;
      flag: bool;
      w: word;
    begin
      {Get the state of the caps lock key}
      flag := not GetKeyState(VK_CAPITAL) and 1 = 0;
      {If the caps lock key is on then turn it off}
      if flag then
        SimulateKeystroke(VK_CAPITAL, 0);
      for i := 1 to Length(s) do
      begin
        w := VkKeyScan(s[i]);
        {If there is not an error in the key translation}
        if ((HiByte(w) $FF) and (LoByte(w) $FF)) then
        begin
          {If the key requires the shift key down - hold it down}
          if HiByte(w) and 1 = 1 then
            SimulateKeyDown(VK_SHIFT);
          {Send the VK_KEY}
          SimulateKeystroke(LoByte(w), 0);
          {If the key required the shift key down - release it}
          if HiByte(w) and 1 = 1 then
            SimulateKeyUp(VK_SHIFT);
        end;
      end;
      {if the caps lock key was on at start, turn it back on}
      if flag then
        SimulateKeystroke(VK_CAPITAL, 0);
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      {Toggle the cap lock}
      SimulateKeystroke(VK_CAPITAL, 0);
    end;
     
    procedure TForm1.Button2Click(Sender: TObject);
    begin
      {Capture the entire screen to the clipboard}
      {by simulating pressing the PrintScreen key}
      SimulateKeystroke(VK_SNAPSHOT, 0);
    end;
     
    procedure TForm1.Button3Click(Sender: TObject);
    begin
      {Capture the active window to the clipboard}
      {by simulating pressing the PrintScreen key}
      SimulateKeystroke(VK_SNAPSHOT, 1);
    end;
     
    procedure TForm1.Button4Click(Sender: TObject);
    begin
      {Set the focus to a window (edit control) and send it a string}
      Application.ProcessMessages;
      Edit1.SetFocus;
      SendKeys('Delphi World is REALY BEST');
    end;


------------------------------------------------------------------------

Вариант 3:

Author: Den is Com 

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

К сожалению работает хорошо, только когда фокус у вызывающего окна, в
противном случае может глючить

    procedure TForm1.SetKey(Key:Integer);
    begin
      keybd_event(Key,0,KEYEVENTF_EXTENDEDKEY or KEYEVENTF_KEYUP,0);
      keybd_event(Key,0,KEYEVENTF_EXTENDEDKEY,0);
      keybd_event(Key,0,KEYEVENTF_EXTENDEDKEY or KEYEVENTF_KEYUP,0);
    end;

Применение

    SetKey(VK_SCROLL);
    SetKey(VK_CAPITAL);



------------------------------------------------------------------------

Вариант 4:

Author: Xavier Pacheco

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

Послать нажатие клавиш:


    unit Main;
     
    interface
     
    uses
      SysUtils, Windows, Messages, Classes, Graphics, Controls,
      Forms, Dialogs, StdCtrls, Menus;
     
    type
      TForm1 = class(TForm)
        Edit1: TEdit;
        Edit2: TEdit;
        Button1: TButton;
        Button2: TButton;
        MainMenu1: TMainMenu;
        File1: TMenuItem;
        Open1: TMenuItem;
        Exit1: TMenuItem;
        Button4: TButton;
        Button3: TButton;
        procedure Button1Click(Sender: TObject);
        procedure Button2Click(Sender: TObject);
        procedure Open1Click(Sender: TObject);
        procedure Exit1Click(Sender: TObject);
        procedure Button4Click(Sender: TObject);
        procedure FormDestroy(Sender: TObject);
        procedure Button3Click(Sender: TObject);
      private
        { Private declarations }
      public
        { Public declarations }
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.DFM}
     
    uses SendKey, KeyDefs;
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      Edit1.SetFocus; // focus Edit1
      SendKeys('^{DELETE}I love...'); // send keys to Edit1
      WaitForHook; // let keys playback
      Perform(WM_NEXTDLGCTL, 0, 0); // move to Edit2
      SendKeys('~delphi ~developers ~guide!'); // send keys to Edit2
    end;
     
    procedure TForm1.Button2Click(Sender: TObject);
    var
      H: hWnd;
      PI: TProcessInformation;
      SI: TStartupInfo;
    begin
      FillChar(SI, SizeOf(SI), 0);
      SI.cb := SizeOf(SI);
      { Invoke notepad }
      if CreateProcess(nil, 'notepad', nil, nil, False, 0, nil, nil, SI,
        PI) then
      begin
        { wait until notepad is ready to receive keystrokes }
        WaitForInputIdle(PI.hProcess, INFINITE);
        { find new notepad window }
        H := FindWindow('Notepad', 'Untitled - Notepad');
        if SetForegroundWindow(H) then // bring it to front
          SendKeys('Hello from the Delphi Developers Guide SendKeys ' +
            'example!{ENTER}'); // send keys!
      end
      else
        MessageDlg(Format('Failed to invoke Notepad.  Error code %d',
          [GetLastError]), mtError, [mbOk], 0);
    end;
     
    procedure TForm1.Open1Click(Sender: TObject);
    begin
      ShowMessage('Open');
    end;
     
    procedure TForm1.Exit1Click(Sender: TObject);
    begin
      Close;
    end;
     
    procedure TForm1.Button4Click(Sender: TObject);
    begin
      WaitForInputIdle(GetCurrentProcess, INFINITE);
      SendKeys('@fx');
    end;
     
    procedure TForm1.FormDestroy(Sender: TObject);
    begin
      WaitForHook;
    end;
     
    procedure TForm1.Button3Click(Sender: TObject);
    begin
      WaitForInputIdle(GetCurrentProcess, INFINITE);
      SendKeys('@fo');
    end;
     
    end.



------------------------------------------------------------------------

Вариант 5:

Source: <https://www.swissdelphicenter.ch>

Послать нажатие клавиш в программу Блокнот:

    procedure TForm1.Button1Click(Sender: TObject);
    var
      wnd: HWND;
      i: Integer;
      s: string;
    begin
      wnd := FindWindow('notepad', nil);
      if wnd <> 0 then
      begin
        wnd := FindWindowEx(wnd, 0, 'Edit', nil);
    
        // Write Text in Notepad. 
        // Text ins Notepad schreiben. 
        s := 'Hello';
        for i := 1 to Length(s) do
          SendMessage(wnd, WM_CHAR, Word(s[i]), 0);
        // Simulate Return Key. 
        PostMessage(wnd, WM_KEYDOWN, VK_RETURN, 0);
        // Simulate Space. 
        PostMessage(wnd, WM_KEYDOWN, VK_SPACE, 0);
       end;
     end;
     
     
     // To send keys to Wordpad: 
     {...}
     wnd := FindWindow('WordPadClass', nil);
     
     if wnd <> 0 then
     begin
       wnd := FindWindowEx(wnd, 0, 'RICHEDIT', nil);
     {...}


------------------------------------------------------------------------

Вариант 6:

Author: Gert v.d. Venis

Source: <https://forum.sources.ru>

Посылаем нажатия клавиш другому приложению.

Компонент Sendkeys:

    unit SendKeys;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs;
     
    type
      TSendKeys = class(TComponent)
      private
        fhandle: HWND;
        L: Longint;
        fchild: boolean;
        fChildText: string;
        procedure SetIsChildWindow(const Value: boolean);
        procedure SetChildText(const Value: string);
        procedure SetWindowHandle(const Value: HWND);
      protected
     
      public
     
      published
        procedure GetWindowHandle(Text: string);
        procedure SendKeys(buffer: string);
        property WindowHandle: HWND read fhandle write SetWindowHandle;
        property IsChildWindow: boolean read fchild write SetIsChildWindow;
        property ChildWindowText: string read fChildText write SetChildText;
      end;
     
    procedure Register;
     
    implementation
     
    var
      temps: string; {используется для доступа к функциям,
                  которые используются в качестве обратных вызовов}
      HTemp: Hwnd;
      ChildText: string;
      ChildWindow: boolean;
     
    procedure Register;
    begin
      RegisterComponents('Standard', [TSendKeys]);
    end;
     
    { TSendKeys }
     
    function PRVGetChildHandle(H: HWND; L: Integer): LongBool;
    var
      p: pchar;
      I: integer;
      s: string;
    begin
      I := length(ChildText) + 2;
      GetMem(p, i + 1);
      SendMessage(H, WM_GetText, i, integer(p));
      s := strpcopy(p, s);
      if pos(ChildText, s) <> 0 then
      begin
        HTemp := H;
        Result := False
      end
      else
        Result := True;
      FreeMem(p);
    end;
     
    function PRVSendKeys(H: HWND; L: Integer): LongBool; stdcall;
    var
      s: string;
      i: integer;
    begin
      i := length(temps);
      if i <> 0 then
      begin
        SetLength(s, i + 2);
        GetWindowText(H, pchar(s), i + 2);
        if Pos(temps, string(s)) <> 0 then
        begin
          Result := false;
          if ChildWindow then
            EnumChildWindows(H, @PRVGetChildHandle, L)
          else
            HTemp := H;
        end
        else
          Result := True;
      end
      else
        Result := False;
    end;
     
    procedure TSendKeys.GetWindowHandle(Text: string);
    begin
      temps := Text;
      ChildText := fChildText;
      ChildWindow := fChild;
      EnumWindows(@PRVSendKeys, L);
      fHandle := HTemp;
    end;
     
    procedure TSendKeys.SendKeys(buffer: string);
    var
      i: integer;
      w: word;
      D: DWORD;
      P: ^DWORD;
    begin
      P := @D;
      SystemParametersInfo(//get flashing timeout on win98
        SPI_GETFOREGROUNDLOCKTIMEOUT,
        0,
        P,
        0);
      SetForeGroundWindow(fHandle);
      for i := 1 to length(buffer) do
      begin
        w := VkKeyScan(buffer[i]);
        keybd_event(w, 0, 0, 0);
        keybd_event(w, 0, KEYEVENTF_KEYUP, 0);
      end;
      SystemParametersInfo(//set flashing TimeOut=0
        SPI_SETFOREGROUNDLOCKTIMEOUT,
        0,
        nil,
        0);
      SetForegroundWindow(TWinControl(TComponent(Self).Owner).Handle);
      //->typecast working...
      SystemParametersInfo(//set flashing TimeOut=previous value
        SPI_SETFOREGROUNDLOCKTIMEOUT,
        D,
        nil,
        0);
    end;
     
    procedure TSendKeys.SetChildText(const Value: string);
    begin
      fChildText := Value;
    end;
     
    procedure TSendKeys.SetIsChildWindow(const Value: boolean);
    begin
      fchild := Value;
    end;
     
    procedure TSendKeys.SetWindowHandle(const Value: HWND);
    begin
      fHandle := WindowHandle;
    end;
     
    end.

**Описание:**

Данный компонент получает хэндл(handle) любого запущенного окна и даёт
возможность отправить по указанному хэндлу любые комбинации нажатия
клавиш.

Совместимость: Все версии Delphi

Собственно сам исходничек:

После того, как проинсталируете этот компонент, создайте новое
приложение и поместите на форму кнопку и сам компонент SendKeys.
Добавьте следующий код в обработчик события OnClick кнопки:

    procedure TForm1.Button1Click(Sender: TObject);
    begin
      // Запускаем Notepad, и ему мы будем посылать нажатия клавиш
      WinExec('NotePad.exe', SW_SHOW);
      // В параметре процедуры GetWindowHandle помещаем
      // текст заголовка окна Notepad'а.
      SendKeys1.GetWindowHandle('Untitled - Notepad');
      // Если хэндл окна получен успешно, то отправляем ему текст
      if SendKeys1.WindowHandle <> 0 then
        SendKeys1.SendKeys('This is a test');
      // Так же можно отправить код любой кнопки типа
      // RETURN, используя следующий код:
      // SendKeys1.SendKeys(Chr(13));
    end;

Неправда ли весело :)

------------------------------------------------------------------------

Вариант 7:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

Посылка кода клавиши или текста в окно

    unit Unit1;
     
    interface
     
    uses
      SysUtils, WinTypes, WinProcs, Messages, Classes, Graphics, Controls,
      Forms, Dialogs, StdCtrls;
     
    type
      TForm1 = class(TForm)
        Button1: TButton;
        Button2: TButton;
        procedure Button1Click(Sender: TObject);
        procedure Button2Click(Sender: TObject);
        procedure FormKeyPress(Sender: TObject; var Key: Char);
      private
        AppInst: THandle;
        AppWind: THandle;
      public
        { Public declarations }
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.DFM}
     
    uses ShellAPI;
     
    procedure SendShift(H: HWnd; Down: Boolean);
    var
      vKey, ScanCode, wParam: Word;
      lParam: longint;
    
    begin
      vKey := $10;
      ScanCode := MapVirtualKey(vKey, 0);
      wParam := vKey or ScanCode shl 8;
      lParam := longint(ScanCode) shl 16 or 1;
      if not (Down) then
        lParam := lParam or $C0000000;
      SendMessage(H, WM_KEYDOWN, vKey, lParam);
    end;
     
    procedure SendCtrl(H: HWnd; Down: Boolean);
    var
      vKey, ScanCode, wParam: Word;
      lParam: longint;
    
    begin
      vKey := $11;
      ScanCode := MapVirtualKey(vKey, 0);
      wParam := vKey or ScanCode shl 8;
      lParam := longint(ScanCode) shl 16 or 1;
      if not (Down) then
        lParam := lParam or $C0000000;
      SendMessage(H, WM_KEYDOWN, vKey, lParam);
    end;
     
    procedure SendKey(H: Hwnd; Key: char);
    var
      vKey, ScanCode, wParam: Word;
      lParam, ConvKey: longint;
      Shift, Ctrl: boolean;
     
    begin
      ConvKey := OemKeyScan(ord(Key));
      Shift := (ConvKey and $00020000) <> 0;
      Ctrl := (ConvKey and $00040000) <> 0;
      ScanCode := ConvKey and $000000FF or $FF00;
      vKey := ord(Key);
      wParam := vKey;
      lParam := longint(ScanCode) shl 16 or 1;
      if Shift then
        SendShift(H, true);
      if Ctrl then
        SendCtrl(H, true);
      SendMessage(H, WM_KEYDOWN, vKey, lParam);
      SendMessage(H, WM_CHAR, vKey, lParam);
      lParam := lParam or $C0000000;
      SendMessage(H, WM_KEYUP, vKey, lParam);
      if Shift then
        SendShift(H, false);
      if Ctrl then
        SendCtrl(H, false);
    end;
     
    function EnumFunc(Handle: HWnd; TF: TForm1): Bool; far;
    begin
      TF.AppWind := 0;
      if GetWindowWord(Handle, GWW_HINSTANCE) = TF.AppInst then
        TF.AppWind := Handle;
      result := (TF.AppWind = 0);
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    var
      Text: array[0..255] of char;
     
    begin
      AppInst := ShellExecute(Handle, 'open', 'notepad.exe', nil, '', SW_NORMAL);
      EnumWindows(@EnumFunc, longint(self));
      AppWind := GetWindow(AppWind, GW_CHILD);
    end;
     
    procedure TForm1.Button2Click(Sender: TObject);
    begin
      SendKey(AppWind, 'T');
      SendKey(AppWind, 'e');
      SendKey(AppWind, 's');
      SendKey(AppWind, 't');
    end;
     
    procedure TForm1.FormKeyPress(Sender: TObject; var Key: Char);
    begin
      if AppWind <> 0 then
        SendKey(AppWind, Key);
    end;
     
    end.



------------------------------------------------------------------------

Вариант 8:

Author: Ken Henderson, khen@compuserve.com

Date: 1995-12-03

Почти полный аналог метода SendKeys из VB

    {
    SendKeys routine for 32-bit Delphi.
     
    Written by Ken Henderson
     
    Copyright (c) 1995 Ken Henderson     email:khen@compuserve.com
     
    This unit includes two routines that simulate popular Visual Basic
    routines: Sendkeys and AppActivate.  SendKeys takes a PChar
    as its first parameter and a boolean as its second, like so:
     
      SendKeys('KeyString', Wait);
     
    where KeyString is a string of key names and modifiers that you want
    to send to the current input focus and Wait is a boolean variable or value
    that indicates whether SendKeys should wait for each key message to be
    processed before proceeding.  See the table below for more information.
     
    AppActivate also takes a PChar as its only parameter, like so:
     
      AppActivate('WindowName');
     
    where WindowName is the name of the window that you want to make the
    current input focus.
     
    SendKeys supports the Visual Basic SendKeys syntax, as documented below.
     
    Supported modifiers:
     
      + = Shift
      ^ = Control
      % = Alt
     
    Surround sequences of characters or key names with parentheses in order to
    modify them as a group.  For example, '+abc' shifts only 'a', while  '+(abc)' shifts
    all three characters.
     
    Supported special characters
     
      ~ = Enter
      ( = begin modifier group (see above)
      ) = end modifier group (see above)
      { = begin key name text (see below)
      } = end key name text (see below)
     
    Supported characters:
     
    Any character that can be typed is supported.  Surround the modifier keys
    listed above with braces in order to send as normal text.
     
    Supported key names (surround these with braces):
     
    BKSP, BS, BACKSPACE
    BREAK
    CAPSLOCK
    CLEAR
    DEL
    DELETE
    DOWN
    END
    ENTER
    ESC
    ESCAPE
    F1
    F2
    F3
    F4
    F5
    F6
    F7
    F8
    F9
    F10
    F11
    F12
    F13
    F14
    F15
    F16
    HELP
    HOME
    INS
    LEFT
    NUMLOCK
    PGDN
    PGUP
    PRTSC
    RIGHT
    SCROLLLOCK
    TAB
    UP
     
    Follow the keyname with a space and a number to send the specified key a
    given number of times (e.g., {left 6}).
    }
     
    unit sndkey32;
     
    interface
     
    Uses SysUtils, Windows, Messages;
     
    Function SendKeys(SendKeysString : PChar; Wait : Boolean) : Boolean;
    function AppActivate(WindowName : PChar) : boolean;
     
    {Buffer for working with PChar's}
     
    const
      WorkBufLen = 40;
    var
      WorkBuf : array[0..WorkBufLen] of Char;
     
    implementation
    type
      THKeys = array[0..pred(MaxLongInt)] of byte;
    var
      AllocationSize : integer;
     
    (*
    Converts a string of characters and key names to keyboard events and
    passes them to Windows.
     
    Example syntax:
     
    SendKeys('abc123{left}{left}{left}def{end}456{left 6}ghi{end}789', True);
     
    *)
     
    Function SendKeys(SendKeysString : PChar; Wait : Boolean) : Boolean;
    type
      WBytes = array[0..pred(SizeOf(Word))] of Byte;
     
      TSendKey = record
        Name : ShortString;
        VKey : Byte;
      end;
     
    const
      {Array of keys that SendKeys recognizes.
     
      If you add to this list, you must be sure to keep it sorted alphabetically
      by Name because a binary search routine is used to scan it.}
     
      MaxSendKeyRecs = 41;
      SendKeyRecs : array[1..MaxSendKeyRecs] of TSendKey =
      (
       (Name:'BKSP';            VKey:VK_BACK),
       (Name:'BS';              VKey:VK_BACK),
       (Name:'BACKSPACE';       VKey:VK_BACK),
       (Name:'BREAK';           VKey:VK_CANCEL),
       (Name:'CAPSLOCK';        VKey:VK_CAPITAL),
       (Name:'CLEAR';           VKey:VK_CLEAR),
       (Name:'DEL';             VKey:VK_DELETE),
       (Name:'DELETE';          VKey:VK_DELETE),
       (Name:'DOWN';            VKey:VK_DOWN),
       (Name:'END';             VKey:VK_END),
       (Name:'ENTER';           VKey:VK_RETURN),
       (Name:'ESC';             VKey:VK_ESCAPE),
       (Name:'ESCAPE';          VKey:VK_ESCAPE),
       (Name:'F1';              VKey:VK_F1),
       (Name:'F10';             VKey:VK_F10),
       (Name:'F11';             VKey:VK_F11),
       (Name:'F12';             VKey:VK_F12),
       (Name:'F13';             VKey:VK_F13),
       (Name:'F14';             VKey:VK_F14),
       (Name:'F15';             VKey:VK_F15),
       (Name:'F16';             VKey:VK_F16),
       (Name:'F2';              VKey:VK_F2),
       (Name:'F3';              VKey:VK_F3),
       (Name:'F4';              VKey:VK_F4),
       (Name:'F5';              VKey:VK_F5),
       (Name:'F6';              VKey:VK_F6),
       (Name:'F7';              VKey:VK_F7),
       (Name:'F8';              VKey:VK_F8),
       (Name:'F9';              VKey:VK_F9),
       (Name:'HELP';            VKey:VK_HELP),
       (Name:'HOME';            VKey:VK_HOME),
       (Name:'INS';             VKey:VK_INSERT),
       (Name:'LEFT';            VKey:VK_LEFT),
       (Name:'NUMLOCK';         VKey:VK_NUMLOCK),
       (Name:'PGDN';            VKey:VK_NEXT),
       (Name:'PGUP';            VKey:VK_PRIOR),
       (Name:'PRTSC';           VKey:VK_PRINT),
       (Name:'RIGHT';           VKey:VK_RIGHT),
       (Name:'SCROLLLOCK';      VKey:VK_SCROLL),
       (Name:'TAB';             VKey:VK_TAB),
       (Name:'UP';              VKey:VK_UP)
      );
     
      {Extra VK constants missing from Delphi's Windows API interface}
      VK_NULL=0;
      VK_SemiColon=186;
      VK_Equal=187;
      VK_Comma=188;
      VK_Minus=189;
      VK_Period=190;
      VK_Slash=191;
      VK_BackQuote=192;
      VK_LeftBracket=219;
      VK_BackSlash=220;
      VK_RightBracket=221;
      VK_Quote=222;
      VK_Last=VK_Quote;
     
      ExtendedVKeys : set of byte =
      [VK_Up,
       VK_Down,
       VK_Left,
       VK_Right,
       VK_Home,
       VK_End,
       VK_Prior,  {PgUp}
       VK_Next,   {PgDn}
       VK_Insert,
       VK_Delete];
     
    const
      INVALIDKEY = $FFFF {Unsigned -1};
      VKKEYSCANSHIFTON = $01;
      VKKEYSCANCTRLON = $02;
      VKKEYSCANALTON = $04;
      UNITNAME = 'SendKeys';
    var
      UsingParens, ShiftDown, ControlDown, AltDown, FoundClose : Boolean;
      PosSpace : Byte;
      I, L : Integer;
      NumTimes, MKey : Word;
      KeyString : String[20];
     
    procedure DisplayMessage(Message : PChar);
    begin
      MessageBox(0,Message,UNITNAME,0);
    end;
     
    function BitSet(BitTable, BitMask : Byte) : Boolean;
    begin
      Result:=ByteBool(BitTable and BitMask);
    end;
     
    procedure SetBit(var BitTable : Byte; BitMask : Byte);
    begin
      BitTable:=BitTable or Bitmask;
    end;
     
    procedure KeyboardEvent(VKey, ScanCode : Byte; Flags : Longint);
    var
      KeyboardMsg : TMsg;
    begin
      keybd_event(VKey, ScanCode, Flags,0);
      If (Wait) then While (PeekMessage(KeyboardMsg,0,WM_KEYFIRST, WM_KEYLAST, PM_REMOVE)) do begin
        TranslateMessage(KeyboardMsg);
        DispatchMessage(KeyboardMsg);
      end;
    end;
     
    procedure SendKeyDown(VKey: Byte; NumTimes : Word; GenUpMsg : Boolean);
    var
      Cnt : Word;
      ScanCode : Byte;
      NumState : Boolean;
      KeyBoardState : TKeyboardState;
    begin
      If (VKey=VK_NUMLOCK) then begin
        NumState:=ByteBool(GetKeyState(VK_NUMLOCK) and 1);
        GetKeyBoardState(KeyBoardState);
        If NumState then KeyBoardState[VK_NUMLOCK]:=(KeyBoardState[VK_NUMLOCK] and not 1)
        else KeyBoardState[VK_NUMLOCK]:=(KeyBoardState[VK_NUMLOCK] or 1);
        SetKeyBoardState(KeyBoardState);
        exit;
      end;
     
      ScanCode:=Lo(MapVirtualKey(VKey,0));
      For Cnt:=1 to NumTimes do
        If (VKey in ExtendedVKeys)then begin
          KeyboardEvent(VKey, ScanCode, KEYEVENTF_EXTENDEDKEY);
          If (GenUpMsg) then
            KeyboardEvent(VKey, ScanCode, KEYEVENTF_EXTENDEDKEY or KEYEVENTF_KEYUP)
        end  else begin
          KeyboardEvent(VKey, ScanCode, 0);
          If (GenUpMsg) then KeyboardEvent(VKey, ScanCode, KEYEVENTF_KEYUP);
        end;
    end;
     
    procedure SendKeyUp(VKey: Byte);
    var
      ScanCode : Byte;
    begin
      ScanCode:=Lo(MapVirtualKey(VKey,0));
      If (VKey in ExtendedVKeys)then
        KeyboardEvent(VKey, Sca
      else KeyboardEvent(VKey, ScanCode, KEYEVENTF_KEYUP);
    end;
     
    procedure SendKey(MKey: Word; NumTimes : Word; GenDownMsg : Boolean);
    begin
      If (BitSet(Hi(MKey),VKKEYSCANSHIFTON)) then SendKeyDown(VK_SHIFT,1,False);
      If (BitSet(Hi(MKey),VKKEYSCANCTRLON)) then SendKeyDown(VK_CONTROL,1,False);
      If (BitSet(Hi(MKey),VKKEYSCANALTON)) then SendKeyDown(VK_MENU,1,False);
      SendKeyDown(Lo(MKey), NumTimes, GenDownMsg);
      If (BitSet(Hi(MKey),VKKEYSCANSHIFTON)) then SendKeyUp(VK_SHIFT);
      If (BitSet(Hi(MKey),VKKEYSCANCTRLON)) then SendKeyUp(VK_CONTROL);
      If (BitSet(Hi(MKey),VKKEYSCANALTON)) then SendKeyUp(VK_MENU);
    end;
     
    {Implements a simple binary search to locate special key name strings}
     
    function StringToVKey(KeyString : ShortString) : Word;
    var
      Found, Collided : Boolean;
      Bottom, Top, Middle : Byte;
    begin
      Result:=INVALIDKEY;
      Bottom:=1;
      Top:=MaxSendKeyRecs;
      Found:=false;
      Middle:=(Bottom+Top) div 2;
      Repeat
        Collided:=((Bottom=Middle) or (Top=Middle));
        If (KeyString=SendKeyRecs[Middle].Name) then begin
           Found:=True;
           Result:=SendKeyRecs[Middle].VKey;
        end  else begin
           If (KeyString>SendKeyRecs[Middle].Name) then Bottom:=Middle
           else Top:=Middle;
           Middle:=(Succ(Bottom+Top)) div 2;
        end;
      Until (Found or Collided);
      If (Result=INVALIDKEY) then DisplayMessage('Invalid Key Name');
    end;
     
    procedure PopUpShiftKeys;
    begin
      If (not UsingParens) then begin
        If ShiftDown then SendKeyUp(VK_SHIFT);
        If ControlDown then SendKeyUp(VK_CONTROL);
        If AltDown then SendKeyUp(VK_MENU);
        ShiftDown:=false;
        ControlDown:=false;
        AltDown:=false;
      end;
    end;
     
    begin
      AllocationSize:=MaxInt;
      Result:=false;
      UsingParens:=false;
      ShiftDown:=false;
      ControlDown:=false;
      AltDown:=false;
      I:=0;
      L:=StrLen(SendKeysString);
      If (L>AllocationSize) then L:=AllocationSize;
      If (L=0) then Exit;
     
      while  (Ibegin
        case SendKeysString[I] of
        '(' : begin
                UsingParens:=True;
                Inc(I);
              end;
        ')' : begin
                UsingParens:=False;
                PopUpShiftKeys;
                Inc(I);
              end;
        '%' : begin
                 AltDown:=True;
                 SendKeyDown(VK_MENU,1,False);
                 Inc(I);
              end;
        '+' :  begin
                 ShiftDown:=True;
                 SendKeyDown(VK_SHIFT,1,False);
                 Inc(I);
               end;
        '^' :  begin
                 ControlDown:=True;
                 SendKeyDown(VK_CONTROL,1,False);
                 Inc(I);
               end;
        '{' : begin
                NumTimes:=1;
                If (SendKeysString[Succ(I)]='{') then begin
                  MKey:=VK_LEFTBRACKET;
                  SetBit(Wbytes(MKey)[1],VKKEYSCANSHIFTON);
                  SendKey(MKey,1,True);
                  PopUpShiftKeys;
                  Inc(I,3);
                  Continue;
                end;
                KeyString:='';
                FoundClose:=False;
                while  (I<=L) do begin
                  Inc(I);
                  If (SendKeysString[I]='}') then begin
                    FoundClose:=True;
                    Inc(I);
                    Break;
                  end;
                  KeyString:=KeyString+Upcase(SendKeysString[I]);
                end;
                If (Not FoundClose) then begin
                   DisplayMessage('No Close');
                   Exit;
                end;
                If (SendKeysString[I]='}') then begin
                  MKey:=VK_RIGHTBRACKET;
                  SetBit(Wbytes(MKey)[1],VKKEYSCANSHIFTON);
                  SendKey(MKey,1,True);
                  PopUpShiftKeys;
                  Inc(I);
                  Continue;
                end;
                PosSpace:=Pos(' ',KeyString);
                If (PosSpace<>0) then begin
                   NumTimes:=StrToInt(Copy(KeyString,Succ(PosSpace),Length(KeyString)-PosSpace));
                   KeyString:=Copy(KeyString,1,Pred(PosSpace));
                end;
                If (Length(KeyString)=1) then MKey:=vkKeyScan(KeyString[1])
                else MKey:=StringToVKey(KeyString);
                If (MKey<>INVALIDKEY) then begin
                  SendKey(MKey,NumTimes,True);
                  PopUpShiftKeys;
                  Continue;
                end;
              end;
        '~' : begin
                SendKeyDown(VK_RETURN,1,True);
                PopUpShiftKeys;
                Inc(I);
              end;
        else  begin
                 MKey:=vkKeyScan(SendKeysString[I]);
                 If (MKey<>INVALIDKEY) then begin
                   SendKey(MKey,1,True);
                   PopUpShiftKeys;
                 end else DisplayMessage('Invalid KeyName');
                 Inc(I);
              end;
        end;
      end;
      Result:=true;
      PopUpShiftKeys;
    end;
     
    {AppActivate
     
    This is used to set the current input focus to a given window using its
    name.  This is especially useful for ensuring a window is active before
    sending it input messages using the SendKeys function.  You can specify
    a window's name in its entirety, or only portion of it, beginning from
    the left.
     
    }
     
    var
      WindowHandle : HWND;
     
    function EnumWindowsProc(WHandle: HWND; lParam: LPARAM): BOOL; export; stdcall;
    const
      MAX_WINDOW_NAME_LEN = 80;
    var
      WindowName : array[0..MAX_WINDOW_NAME_LEN] of char;
    begin
      {Can't test GetWindowText's return value since some windows don't have a title}
      GetWindowText(WHandle,WindowName,MAX_WINDOW_NAME_LEN);
      Result := (StrLIComp(WindowName,PChar(lParam), StrLen(PChar(lParam))) <> 0);
      If (not Result) then WindowHandle:=WHandle;
    end;
     
    function AppActivate(WindowName : PChar) : boolean;
    begin
      try
        Result:=true;
        WindowHandle:=FindWindow(nil,WindowName);
        If (WindowHandle=0) then EnumWindows(@EnumWindowsProc,Integer(PChar(WindowName)));
        If (WindowHandle<>0) then begin
          SendMessage(WindowHandle, WM_SYSCOMMAND, SC_HOTKEY, WindowHandle);
          SendMessage(WindowHandle, WM_SYSCOMMAND, SC_RESTORE, WindowHandle);
        end else Result:=false;
      except
        on Exception do Result:=false;
      end;
    end;
     
    end.

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

--------------------------------------------------------------------

Вариант 9:

Author: P. Below

Source: <https://www.swissdelphicenter.ch>

    {PostKeyEx32 function}
     
    procedure PostKeyEx32(key: Word; const shift: TShiftState; specialkey: Boolean);
    {************************************************************ 
    * Procedure PostKeyEx32 
    * 
    * Parameters: 
    *  key    : virtual keycode of the key to send. For printable 
    *           keys this is simply the ANSI code (Ord(character)). 
    *  shift  : state of the modifier keys. This is a set, so you 
    *           can set several of these keys (shift, control, alt, 
    *           mouse buttons) in tandem. The TShiftState type is 
    *           declared in the Classes Unit. 
    *  specialkey: normally this should be False. Set it to True to 
    *           specify a key on the numeric keypad, for example. 
    * Description: 
    *  Uses keybd_event to manufacture a series of key events matching 
    *  the passed parameters. The events go to the control with focus. 
    *  Note that for characters key is always the upper-case version of 
    *  the character. Sending without any modifier keys will result in 
    *  a lower-case character, sending it with [ssShift] will result 
    *  in an upper-case character! 
    // Code by P. Below 
    ************************************************************}
    type
      TShiftKeyInfo = record
        shift: Byte;
        vkey: Byte;
      end;
      byteset = set of 0..7;
    const
      shiftkeys: array [1..3] of TShiftKeyInfo =
        ((shift: Ord(ssCtrl); vkey: VK_CONTROL),
        (shift: Ord(ssShift); vkey: VK_SHIFT),
        (shift: Ord(ssAlt); vkey: VK_MENU));
    var
      flag: DWORD;
      bShift: ByteSet absolute shift;
      i: Integer;
    begin
      for i := 1 to 3 do
      begin
        if shiftkeys[i].shift in bShift then
          keybd_event(shiftkeys[i].vkey, MapVirtualKey(shiftkeys[i].vkey, 0), 0, 0);
      end; { For }
      if specialkey then
        flag := KEYEVENTF_EXTENDEDKEY
      else
        flag := 0;
    
      keybd_event(key, MapvirtualKey(key, 0), flag, 0);
      flag := flag or KEYEVENTF_KEYUP;
      keybd_event(key, MapvirtualKey(key, 0), flag, 0);
    
      for i := 3 downto 1 do
      begin
        if shiftkeys[i].shift in bShift then
          keybd_event(shiftkeys[i].vkey, MapVirtualKey(shiftkeys[i].vkey, 0),
            KEYEVENTF_KEYUP, 0);
      end; { For }
    end; { PostKeyEx32 }
     
     
    // Example: 
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      //Pressing the Left Windows Key 
      PostKeyEx32(VK_LWIN, [], False);
    
      //Pressing the letter D 
      PostKeyEx32(Ord('D'), [], False);
    
      //Pressing Ctrl-Alt-C 
      PostKeyEx32(Ord('C'), [ssctrl, ssAlt], False);
    end;


------------------------------------------------------------------------

Вариант 10:

Source: <https://www.swissdelphicenter.ch>

    {With keybd_event API}
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      {or you can also try this simple example to send any 
      amount of keystrokes at the same time. }
    
      {Pressing the A Key and showing it in the Edit1.Text}
    
      Edit1.SetFocus;
      keybd_event(VK_SHIFT, 0, 0, 0);
      keybd_event(Ord('A'), 0, 0, 0);
      keybd_event(VK_SHIFT, 0, KEYEVENTF_KEYUP, 0);
    
      {Presses the Left Window Key and starts the Run}
      keybd_event(VK_LWIN, 0, 0, 0);
      keybd_event(Ord('R'), 0, 0, 0);
      keybd_event(VK_LWIN, 0, KEYEVENTF_KEYUP, 0);
    end;


------------------------------------------------------------------------

Вариант 11:

Date: 1996-02-21

Author: P. Below

Source: <https://www.swissdelphicenter.ch>

    {With keybd_event API}
     
    procedure PostKeyExHWND(hWindow: HWnd; key: Word; const shift: TShiftState;
      specialkey: Boolean);
    {************************************************************ 
    * Procedure PostKeyEx 
    * 
    * Parameters: 
    *  hWindow: target window to be send the keystroke 
    *  key    : virtual keycode of the key to send. For printable 
    *           keys this is simply the ANSI code (Ord(character)). 
    *  shift  : state of the modifier keys. This is a set, so you 
    *           can set several of these keys (shift, control, alt, 
    *           mouse buttons) in tandem. The TShiftState type is 
    *           declared in the Classes Unit. 
    *  specialkey: normally this should be False. Set it to True to 
    *           specify a key on the numeric keypad, for example. 
    *           If this parameter is true, bit 24 of the lparam for
    *           the posted WM_KEY* messages will be set.
    * Description:
    *  This procedure sets up Windows key state array to correctly
    *  reflect the requested pattern of modifier keys and then posts
    *  a WM_KEYDOWN/WM_KEYUP message pair to the target window. Then
    *  Application.ProcessMessages is called to process the messages
    *  before the keyboard state is restored.
    * Error Conditions:
    *  May fail due to lack of memory for the two key state buffers.
    *  Will raise an exception in this case.
    * NOTE:
    *  Setting the keyboard state will not work across applications
    *  running in different memory spaces on Win32 unless AttachThreadInput
    *  is used to connect to the target thread first.
    *Created: 02/21/96 16:39:00 by P. Below
    ************************************************************}
    
    type
      TBuffers = array [0..1] of TKeyboardState;
    var
      pKeyBuffers: ^TBuffers;
      lParam: LongInt;
    begin
      (* check if the target window exists *)
      if IsWindow(hWindow) then
      begin
        (* set local variables to default values *)
        pKeyBuffers := nil;
        lParam := MakeLong(0, MapVirtualKey(key, 0));
    
        (* modify lparam if special key requested *)
        if specialkey then
          lParam := lParam or $1000000;
    
        (* allocate space for the key state buffers *)
        New(pKeyBuffers);
        try
          (* Fill buffer 1 with current state so we can later restore it.
             Null out buffer 0 to get a "no key pressed" state. *)
          GetKeyboardState(pKeyBuffers^[1]);
          FillChar(pKeyBuffers^[0], SizeOf(TKeyboardState), 0);
    
          (* set the requested modifier keys to "down" state in the buffer*)
          if ssShift in shift then
            pKeyBuffers^[0][VK_SHIFT] := $80;
          if ssAlt in shift then
          begin
            (* Alt needs special treatment since a bit in lparam needs also be set *)
            pKeyBuffers^[0][VK_MENU] := $80;
            lParam := lParam or $20000000;
          end;
          if ssCtrl in shift then
            pKeyBuffers^[0][VK_CONTROL] := $80;
          if ssLeft in shift then
            pKeyBuffers^[0][VK_LBUTTON] := $80;
          if ssRight in shift then
            pKeyBuffers^[0][VK_RBUTTON] := $80;
          if ssMiddle in shift then
            pKeyBuffers^[0][VK_MBUTTON] := $80;
    
          (* make out new key state array the active key state map *)
          SetKeyboardState(pKeyBuffers^[0]);
          (* post the key messages *)
          if ssAlt in Shift then
          begin
            PostMessage(hWindow, WM_SYSKEYDOWN, key, lParam);
            PostMessage(hWindow, WM_SYSKEYUP, key, lParam or $C0000000);
          end
          else
          begin
            PostMessage(hWindow, WM_KEYDOWN, key, lParam);
            PostMessage(hWindow, WM_KEYUP, key, lParam or $C0000000);
          end;
          (* process the messages *)
          Application.ProcessMessages;
    
          (* restore the old key state map *)
          SetKeyboardState(pKeyBuffers^[1]);
        finally
          (* free the memory for the key state buffers *)
          if pKeyBuffers <> nil then
            Dispose(pKeyBuffers);
        end; { If }
      end;
    end; { PostKeyEx }
    
    // Example: 
     
    procedure TForm1.Button1Click(Sender: TObject);
    var
      targetWnd: HWND;
    begin
      targetWnd := FindWindow('notepad', nil)
        if targetWnd <> 0 then
        begin
          PostKeyExHWND(targetWnd, Ord('I'), [ssAlt], False);
      end;
    end;


------------------------------------------------------------------------

Вариант 12:

Source: <https://www.swissdelphicenter.ch>

    {With SendInput API}
     
    // Example: Send text 
    procedure TForm1.Button1Click(Sender: TObject);
    const
       Str: string = 'writing writing writing';
    var
      Inp: TInput;
      I: Integer;
    begin
      Edit1.SetFocus;
    
      for I := 1 to Length(Str) do
      begin
        // press 
        Inp.Itype := INPUT_KEYBOARD;
        Inp.ki.wVk := Ord(UpCase(Str[i]));
        Inp.ki.dwFlags := 0;
        SendInput(1, Inp, SizeOf(Inp));
    
        // release 
        Inp.Itype := INPUT_KEYBOARD;
        Inp.ki.wVk := Ord(UpCase(Str[i]));
        Inp.ki.dwFlags := KEYEVENTF_KEYUP;
        SendInput(1, Inp, SizeOf(Inp));
    
        Application.ProcessMessages;
        Sleep(80);
      end;
    end;
    
    // Example: Simulate Alt+Tab 
    procedure SendAltTab;
    var
      KeyInputs: array of TInput;
      KeyInputCount: Integer;
    
      procedure KeybdInput(VKey: Byte; Flags: DWORD);
      begin
        Inc(KeyInputCount);
        SetLength(KeyInputs, KeyInputCount);
        KeyInputs[KeyInputCount - 1].Itype := INPUT_KEYBOARD;
        with  KeyInputs[KeyInputCount - 1].ki do
        begin
          wVk := VKey;
          wScan := MapVirtualKey(wVk, 0);
          dwFlags := KEYEVENTF_EXTENDEDKEY;
          dwFlags := Flags or dwFlags;
          time := 0;
          dwExtraInfo := 0;
        end;
      end;
    begin
      KeybdInput(VK_MENU, 0);                // Alt 
      KeybdInput(VK_TAB, 0);                 // Tab 
      KeybdInput(VK_TAB, KEYEVENTF_KEYUP);   // Tab 
      KeybdInput(VK_MENU, KEYEVENTF_KEYUP);  // Alt 
      SendInput(KeyInputCount, KeyInputs[0], SizeOf(KeyInputs[0]));
    end;


------------------------------------------------------------------------

Вариант 13:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

    Memo1.Perform(WM_CHAR, Ord('A'), 0);

или

    SendMessage(Memo1.Handle, WM_CHAR, Ord('A'), 0);


------------------------------------------------------------------------

Вариант 14:

Author: Dimka Maslov, mainbox@endimus.ru

Date: 29.04.2002

    { **** UBPFD *********** by delphibase.endimus.com ****
    >> Эмуляция нажатия клавиши в активном окне
     
    VKey - код виртуальной клавиши (см. описание констант VK_xxxx)
     
    Зависимости: Windows
    Автор:       Dimka Maslov, mainbox@endimus.ru, ICQ:148442121, Санкт-Петербург
    Copyright:   Dimka Maslov
    Дата:        29 апреля 2002 г.
    ***************************************************** }
     
    procedure PressKey(VKey: Byte);
    begin
      keybd_event(VKey, 0, 0, 0);
      keybd_event(VKey, 0, KEYEVENTF_KEYUP, 0);
    end;

------------------------------------------------------------------------

Вариант 15:

Author: Dimka Maslov, mainbox@endimus.ru

Date: 29.04.2002

    { **** UBPFD *********** by delphibase.endimus.com ****
    >> Эмуляция нажатия клавиши в любом окне, в т.ч. неактивном
     
    Процедура эмулирует нажатие клавиши в любом окне путём посылки ему пары
    сообщений WM_KEYDOWN и WM_KEYUP. Процедура принимает два параметра -
    Handle окна и код клавиши (см. описание констант VK_xxxx).
     
    Зависимости: Windows
    Автор:       Dimka Maslov, mainbox@endimus.ru, ICQ:148442121, Санкт-Петербург
    Copyright:   Dimka Maslov
    Дата:        29 апреля 2002 г.
    ***************************************************** }
     
    procedure EmulateKey(Wnd: HWND; VKey: Integer);
    asm
       push 0
       push edx
       push 0101H //WM_KEYUP
       push eax
       push 0
       push edx
       push 0100H //WM_KEYDOWN
       push eax
       call PostMessage
       call PostMessage
    end;
     
    // Пример использования:
    EmulateKey(Edit1.Handle, VK_RETURN);

------------------------------------------------------------------------

Вариант 16

Author: VID, vidsnap@mail.ru

Date: 19.06.2002

    { **** UBPFD *********** by delphibase.endimus.com ****
    >> Эмуляция нажатия клавиши
     
    Функция SendKeys этого юнита, эмулиреут нажатие клавиши для лююого активного приложения
    Для активизации приложения ивпользуйте функцию AppActivate
     
    Зависимости: SysUtils, Windows, messages
    Автор:       VID, vidsnap@mail.ru, ICQ:132234868, Махачкала
    Copyright:   Автор неизвестен
    Дата:        19 июня 2002 г.
    ***************************************************** }
     
    unit SKUnit;
     
    interface
     
    uses SysUtils, Windows, messages;
     
    function SendKeys(SendKeysString: PChar; Wait: Boolean): Boolean;
    function AppActivate(WindowName: PChar): boolean;
    const
      WorkBufLen = 40;
    var
      WorkBuf: array[0..WorkBufLen] of Char;
     
    implementation
     
    type
      THKeys = array[0..pred(MaxLongInt)] of byte;
    var
      AllocationSize: integer;
     
      (*
      Converts a string of characters and key names to keyboard events and
      passes them to Windows.
     
      Example syntax:
     
      SendKeys('abc123{left}{left}{left}def{end}456{left 6}ghi{end}789', True);
     
      *)
     
    function SendKeys(SendKeysString: PChar; Wait: Boolean): Boolean;
    type
      WBytes = array[0..pred(SizeOf(Word))] of Byte;
     
      TSendKey = record
        Name: ShortString;
        VKey: Byte;
      end;
     
    const
      {Array of keys that SendKeys recognizes.
     
      If you add to this list, you must be sure to keep it sorted alphabetically
      by Name because a binary search routine is used to scan it.}
     
      MaxSendKeyRecs = 41;
      SendKeyRecs: array[1..MaxSendKeyRecs] of TSendKey =
      (
        (Name: 'BKSP'; VKey: VK_BACK),
        (Name: 'BS'; VKey: VK_BACK),
        (Name: 'BACKSPACE'; VKey: VK_BACK),
        (Name: 'BREAK'; VKey: VK_CANCEL),
        (Name: 'CAPSLOCK'; VKey: VK_CAPITAL),
        (Name: 'CLEAR'; VKey: VK_CLEAR),
        (Name: 'DEL'; VKey: VK_DELETE),
        (Name: 'DELETE'; VKey: VK_DELETE),
        (Name: 'DOWN'; VKey: VK_DOWN),
        (Name: 'END'; VKey: VK_END),
        (Name: 'ENTER'; VKey: VK_RETURN),
        (Name: 'ESC'; VKey: VK_ESCAPE),
        (Name: 'ESCAPE'; VKey: VK_ESCAPE),
        (Name: 'F1'; VKey: VK_F1),
        (Name: 'F10'; VKey: VK_F10),
        (Name: 'F11'; VKey: VK_F11),
        (Name: 'F12'; VKey: VK_F12),
        (Name: 'F13'; VKey: VK_F13),
        (Name: 'F14'; VKey: VK_F14),
        (Name: 'F15'; VKey: VK_F15),
        (Name: 'F16'; VKey: VK_F16),
        (Name: 'F2'; VKey: VK_F2),
        (Name: 'F3'; VKey: VK_F3),
        (Name: 'F4'; VKey: VK_F4),
        (Name: 'F5'; VKey: VK_F5),
        (Name: 'F6'; VKey: VK_F6),
        (Name: 'F7'; VKey: VK_F7),
        (Name: 'F8'; VKey: VK_F8),
        (Name: 'F9'; VKey: VK_F9),
        (Name: 'HELP'; VKey: VK_HELP),
        (Name: 'HOME'; VKey: VK_HOME),
        (Name: 'INS'; VKey: VK_INSERT),
        (Name: 'LEFT'; VKey: VK_LEFT),
        (Name: 'NUMLOCK'; VKey: VK_NUMLOCK),
        (Name: 'PGDN'; VKey: VK_NEXT),
        (Name: 'PGUP'; VKey: VK_PRIOR),
        (Name: 'PRTSC'; VKey: VK_PRINT),
        (Name: 'RIGHT'; VKey: VK_RIGHT),
        (Name: 'SCROLLLOCK'; VKey: VK_SCROLL),
        (Name: 'TAB'; VKey: VK_TAB),
        (Name: 'UP'; VKey: VK_UP)
        );
     
      {Extra VK constants missing from Delphi's Windows API interface}
      VK_NULL = 0;
      VK_SemiColon = 186;
      VK_Equal = 187;
      VK_Comma = 188;
      VK_Minus = 189;
      VK_Period = 190;
      VK_Slash = 191;
      VK_BackQuote = 192;
      VK_LeftBracket = 219;
      VK_BackSlash = 220;
      VK_RightBracket = 221;
      VK_Quote = 222;
      VK_Last = VK_Quote;
     
      ExtendedVKeys: set of byte =
      [VK_Up,
        VK_Down,
        VK_Left,
        VK_Right,
        VK_Home,
        VK_End,
        VK_Prior, {PgUp}
      VK_Next, {PgDn}
      VK_Insert,
        VK_Delete];
     
    const
      INVALIDKEY = $FFFF {Unsigned -1};
      VKKEYSCANSHIFTON = $01;
      VKKEYSCANCTRLON = $02;
      VKKEYSCANALTON = $04;
      UNITNAME = 'SendKeys';
    var
      UsingParens, ShiftDown, ControlDown, AltDown, FoundClose: Boolean;
      PosSpace: Byte;
      I, L: Integer;
      NumTimes, MKey: Word;
      KeyString: string[20];
     
      procedure DisplayMessage(Message: PChar);
      begin
        MessageBox(0, Message, UNITNAME, 0);
      end;
     
      function BitSet(BitTable, BitMask: Byte): Boolean;
      begin
        Result := ByteBool(BitTable and BitMask);
      end;
     
      procedure SetBit(var BitTable: Byte; BitMask: Byte);
      begin
        BitTable := BitTable or Bitmask;
      end;
     
      procedure KeyboardEvent(VKey, ScanCode: Byte; Flags: Longint);
      var
        KeyboardMsg: TMsg;
      begin
        keybd_event(VKey, ScanCode, Flags, 0);
        if (Wait) then
          while (PeekMessage(KeyboardMsg, 0, WM_KEYFIRST, WM_KEYLAST, PM_REMOVE)) do
          begin
            TranslateMessage(KeyboardMsg);
            DispatchMessage(KeyboardMsg);
          end;
      end;
     
      procedure SendKeyDown(VKey: Byte; NumTimes: Word; GenUpMsg: Boolean);
      var
        Cnt: Word;
        ScanCode: Byte;
        NumState: Boolean;
        KeyBoardState: TKeyboardState;
      begin
        if (VKey = VK_NUMLOCK) then
        begin
          NumState := ByteBool(GetKeyState(VK_NUMLOCK) and 1);
          GetKeyBoardState(KeyBoardState);
          if NumState then
            KeyBoardState[VK_NUMLOCK] := (KeyBoardState[VK_NUMLOCK] and not 1)
          else
            KeyBoardState[VK_NUMLOCK] := (KeyBoardState[VK_NUMLOCK] or 1);
          SetKeyBoardState(KeyBoardState);
          exit;
        end;
     
        ScanCode := Lo(MapVirtualKey(VKey, 0));
        for Cnt := 1 to NumTimes do
          if (VKey in ExtendedVKeys) then
          begin
            KeyboardEvent(VKey, ScanCode, KEYEVENTF_EXTENDEDKEY);
            if (GenUpMsg) then
              KeyboardEvent(VKey, ScanCode, KEYEVENTF_EXTENDEDKEY or KEYEVENTF_KEYUP)
          end
          else
          begin
            KeyboardEvent(VKey, ScanCode, 0);
            if (GenUpMsg) then
              KeyboardEvent(VKey, ScanCode, KEYEVENTF_KEYUP);
          end;
      end;
     
      procedure SendKeyUp(VKey: Byte);
      var
        ScanCode: Byte;
      begin
        ScanCode := Lo(MapVirtualKey(VKey, 0));
        if (VKey in ExtendedVKeys) then
          KeyboardEvent(VKey, ScanCode, KEYEVENTF_EXTENDEDKEY and KEYEVENTF_KEYUP)
        else
          KeyboardEvent(VKey, ScanCode, KEYEVENTF_KEYUP);
      end;
     
      procedure SendKey(MKey: Word; NumTimes: Word; GenDownMsg: Boolean);
      begin
        if (BitSet(Hi(MKey), VKKEYSCANSHIFTON)) then
          SendKeyDown(VK_SHIFT, 1, False);
        if (BitSet(Hi(MKey), VKKEYSCANCTRLON)) then
          SendKeyDown(VK_CONTROL, 1, False);
        if (BitSet(Hi(MKey), VKKEYSCANALTON)) then
          SendKeyDown(VK_MENU, 1, False);
        SendKeyDown(Lo(MKey), NumTimes, GenDownMsg);
        if (BitSet(Hi(MKey), VKKEYSCANSHIFTON)) then
          SendKeyUp(VK_SHIFT);
        if (BitSet(Hi(MKey), VKKEYSCANCTRLON)) then
          SendKeyUp(VK_CONTROL);
        if (BitSet(Hi(MKey), VKKEYSCANALTON)) then
          SendKeyUp(VK_MENU);
      end;
     
      {Implements a simple binary search to locate special key name strings}
     
      function StringToVKey(KeyString: ShortString): Word;
      var
        Found, Collided: Boolean;
        Bottom, Top, Middle: Byte;
      begin
        Result := INVALIDKEY;
        Bottom := 1;
        Top := MaxSendKeyRecs;
        Found := false;
        Middle := (Bottom + Top) div 2;
        repeat
          Collided := ((Bottom = Middle) or (Top = Middle));
          if (KeyString = SendKeyRecs[Middle].Name) then
          begin
            Found := True;
            Result := SendKeyRecs[Middle].VKey;
          end
          else
          begin
            if (KeyString > SendKeyRecs[Middle].Name) then
              Bottom := Middle
            else
              Top := Middle;
            Middle := (Succ(Bottom + Top)) div 2;
          end;
        until (Found or Collided);
        if (Result = INVALIDKEY) then
          DisplayMessage('Invalid Key Name');
      end;
     
      procedure PopUpShiftKeys;
      begin
        if (not UsingParens) then
        begin
          if ShiftDown then
            SendKeyUp(VK_SHIFT);
          if ControlDown then
            SendKeyUp(VK_CONTROL);
          if AltDown then
            SendKeyUp(VK_MENU);
          ShiftDown := false;
          ControlDown := false;
          AltDown := false;
        end;
      end;
     
    begin
      AllocationSize := MaxInt;
      Result := false;
      UsingParens := false;
      ShiftDown := false;
      ControlDown := false;
      AltDown := false;
      I := 0;
      L := StrLen(SendKeysString);
      if (L > AllocationSize) then
        L := AllocationSize;
      if (L = 0) then
        Exit;
     
      case SendKeysString[I] of
        '(':
          begin
            UsingParens := True;
            Inc(I);
          end;
        ')':
          begin
            UsingParens := False;
            PopUpShiftKeys;
            Inc(I);
          end;
        '%':
          begin
            AltDown := True;
            SendKeyDown(VK_MENU, 1, False);
            Inc(I);
          end;
        '+':
          begin
            ShiftDown := True;
            SendKeyDown(VK_SHIFT, 1, False);
            Inc(I);
          end;
        '^':
          begin
            ControlDown := True;
            SendKeyDown(VK_CONTROL, 1, False);
            Inc(I);
          end;
        '{':
          begin
            NumTimes := 1;
            if (SendKeysString[Succ(I)] = '{') then
            begin
              MKey := VK_LEFTBRACKET;
              SetBit(Wbytes(MKey)[1], VKKEYSCANSHIFTON);
              SendKey(MKey, 1, True);
              PopUpShiftKeys;
              Inc(I, 3);
              // Continue;
            end;
            KeyString := '';
            FoundClose := False;
            while (I <= L) do
            begin
              Inc(I);
              if (SendKeysString[I] = '}') then
              begin
                FoundClose := True;
                Inc(I);
                Break;
              end;
              KeyString := KeyString + Upcase(SendKeysString[I]);
            end;
            if (not FoundClose) then
            begin
              DisplayMessage('No Close');
              Exit;
            end;
            if (SendKeysString[I] = '}') then
            begin
              MKey := VK_RIGHTBRACKET;
              SetBit(Wbytes(MKey)[1], VKKEYSCANSHIFTON);
              SendKey(MKey, 1, True);
              PopUpShiftKeys;
              Inc(I);
              // Continue;
            end;
            PosSpace := Pos(' ', KeyString);
            if (PosSpace <> 0) then
            begin
              NumTimes := StrToInt(Copy(KeyString, Succ(PosSpace), Length(KeyString)
                - PosSpace));
              KeyString := Copy(KeyString, 1, Pred(PosSpace));
            end;
            if (Length(KeyString) = 1) then
              MKey := vkKeyScan(KeyString[1])
            else
              MKey := StringToVKey(KeyString);
            if (MKey <> INVALIDKEY) then
            begin
              SendKey(MKey, NumTimes, True);
              PopUpShiftKeys;
              // Continue;
            end;
          end;
        '~':
          begin
            SendKeyDown(VK_RETURN, 1, True);
            PopUpShiftKeys;
            Inc(I);
          end;
      else
        begin
          MKey := vkKeyScan(SendKeysString[I]);
          if (MKey <> INVALIDKEY) then
          begin
            SendKey(MKey, 1, True);
            PopUpShiftKeys;
          end
          else
            DisplayMessage('Invalid KeyName');
          Inc(I);
        end;
      end;
     
      Result := true;
      PopUpShiftKeys;
    end;
     
    {AppActivate
     
    This is used to set the current input focus to a given window using its
    name. This is especially useful for ensuring a window is active before
    sending it input messages using the SendKeys function. You can specify
    a window's name in its entirety, or only portion of it, beginning from
    the left.
     
    }
     
    var
      WindowHandle: HWND;
     
    function EnumWindowsProc(WHandle: HWND; lParam: LPARAM): BOOL; export; stdcall;
    const
      MAX_WINDOW_NAME_LEN = 80;
    var
      WindowName: array[0..MAX_WINDOW_NAME_LEN] of char;
    begin
      {Can't test GetWindowText's return value since some windows don't have a title}
      GetWindowText(WHandle, WindowName, MAX_WINDOW_NAME_LEN);
      Result := (StrLIComp(WindowName, PChar(lParam), StrLen(PChar(lParam))) <> 0);
      if (not Result) then
        WindowHandle := WHandle;
    end;
     
    function AppActivate(WindowName: PChar): boolean;
    begin
      try
        Result := true;
        WindowHandle := FindWindow(nil, WindowName);
        if (WindowHandle = 0) then
          EnumWindows(@EnumWindowsProc, Integer(PChar(WindowName)));
        if (WindowHandle <> 0) then
        begin
          SendMessage(WindowHandle, WM_SYSCOMMAND, SC_HOTKEY, WindowHandle);
          SendMessage(WindowHandle, WM_SYSCOMMAND, SC_RESTORE, WindowHandle);
        end
        else
          Result := false;
      except
        on Exception do
          Result := false;
      end;
    end;
     
    end.
     
    //Пример использования: 
     
    SendKeys('A', False); 

 

------------------------------------------------------------------------

Вариант 17:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

Как отправить нажатие клавиши с кодом 255 в элемент управления Windows.

Функция keybd\_event() принимает значения до 244 - как мне отправить
нажатие клавиши с кодом #255 в элемент управления Windows? Это может
понадобится для иностранных языков или для специальных символов.
(например, в русских шрифтах символ с кодом #255 - я прописное).
Приведенный в примере метод, не стоит использовать в случае если символ
может быть передан обычным способом (функцией keybd\_event()).

    procedure TForm1.Button1Click(Sender: TObject);
    var
          KeyData : packed record
                    RepeatCount : word;
                    ScanCode : byte;
                    Bits : byte;
          end;
    begin
            {Let the button repaint}
            Application.ProcessMessages;
            {Set the focus to the window}
            Edit1.SetFocus;
            {Send a right so the char is added to the end of the line}
            //  SimulateKeyStroke(VK_RIGHT, 0);
            keybd_event(VK_RIGHT, 0,0,0);
            {Let the app get the message}
            Application.ProcessMessages;
            FillChar(KeyData, sizeof(KeyData), #0);
            KeyData.ScanCode := 255;
            KeyData.RepeatCount := 1;
            SendMessage(Edit1.Handle, WM_KEYDOWN, 255,LongInt(KeyData));
            KeyData.Bits := KeyData.Bits or (1 shl 30);
            KeyData.Bits := KeyData.Bits or (1 shl 31);
            SendMessage(Edit1.Handle, WM_KEYUP, 255, LongInt(KeyData));
            KeyData.Bits := KeyData.Bits and not (1 shl 30);
            KeyData.Bits := KeyData.Bits and not (1 shl 31);
            SendMessage(Edit1.Handle, WM_CHAR, 255, LongInt(KeyData));
            Application.ProcessMessages;
    end;

