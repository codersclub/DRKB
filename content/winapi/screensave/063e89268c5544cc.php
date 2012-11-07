<h1>Создание хранителя экрана средствами Delphi</h1>
<div class="date">01.01.2007</div>


<p>В примере описывается создание простейшего скринсейвера, а так же его установка и запуск.</p>
<p>Совместимость: Delphi (все версии)</p>
<p>Для написания скринсейвера нам необходимо включить следующие процедуры:</p>
<p>FormShow - скрыть курсор, установка обработки сообщений, начало отображения скринсейвера</p>
<p>FormHide - окончание отображения скринсейвера, отображение курсора</p>
<p>DeactivateScrSaver - обработка сообщений, деактивирование, если нажата мышка или клавиатура</p>
<p>Типичный код для этих процедур показан ниже.</p>
<p>Вы должны быть уверены, что Ваша форма создана со стилем fsStayOnTop. Вы так же должны быть уверены, что только один экземпляр Вашей программы будет запущен в системе. И в заключении Вам необходимо включить директиву компилятора {$D "Programname Screensaver"} в Ваш проект (*.dpr).</p>
<p>После того, как Вы скомпилируете программу, измените расширение файла на SCR и скопируйте его в Вашу системную папку \WINDOWS\SYSTEM .</p>
<pre>
var 
  crs : TPoint;  {первоначально расположение курсора мышки} 
 
procedure TScrForm.FormShow(Sender: TObject); 
{starts the screensaver} 
begin 
  WindowState := wsMaximized; {окошко будет на полный экран} 
  GetCursorPos(crs); {получаем позицию курсора} 
  Application.OnMessage := DeactivateScrSaver; {проверяем мышку/клавиатуру} 
  ShowCursor(false); {скрываем курсор} 
  {начинаем отображение скринсейвера...} 
  // 
end; {процедура TScrForm.FormShow} 
 
procedure TScrForm.FormHide(Sender: TObject); 
{возвращаем управление пользователю} 
begin 
  Application.OnMessage := nil; {запрещаем сообщения} 
  {останавливаем скринсейвер...} 
  // 
  ShowCursor(true); {возвращаем курсор назад} 
end; {procedure TScrForm.FormHide} 
 
procedure TScrForm.DeactivateScrSaver(var Msg : TMsg; var Handled : boolean); 
{определение движения мышки или нажатия на клавиатуре} 
var 
  done : boolean; 
begin 
  if Msg.message = WM_MOUSEMOVE then {сдвинулась мышка} 
    done := (Abs(LOWORD(Msg.lParam) - crs.x) &gt; 5) or 
            (Abs(HIWORD(Msg.lParam) - crs.y) &gt; 5) 
  else {key / mouse нажаты?} 
    done := (Msg.message = WM_KEYDOWN)     or (Msg.message = WM_KEYUP)       or 
            (Msg.message = WM_SYSKEYDOWN)  or (Msg.message = WM_SYSKEYUP)    or 
            (Msg.message = WM_ACTIVATE)    or (Msg.message = WM_NCACTIVATE)  or 
            (Msg.message = WM_ACTIVATEAPP) or (Msg.message = WM_LBUTTONDOWN) or 
            (Msg.message = WM_RBUTTONDOWN) or (Msg.message = WM_MBUTTONDOWN); 
  if done then 
    Close; 
end; {procedure TScrForm.DeactivateScrSaver}
</pre>

<div class="author">Автор: Dave Murray</div>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

<hr />
<p>Хранитель экрана (ScreenSaver) в Windows - это программа, размещенная в каталоге Windows или Windows\System. Расширение эта программа должна иметь scr. При запуске ScreenSaver должен реагировать на параметры. Если первый параметр - "/p", нужно создать окно предварительного просмотра. Если первый параметр - "/s", нужно запустить сам ScreenSaver. В ином случае нужно показать окно настроек хранителя экрана.</p>
<p>Для предварительного просмотра Windows создает окно, на месте которого ScreenSaver должен что-то рисовать. Чтобы отслеживать сообщения о перерисовке окна Preview, а также о его перемещении и закрытии, нужно создать дочернее окно в том же месте и такого же размера. Для этого нужно использовать WinAPI. Цикл, в котором обрабатываются сообщения, удобно сделать через PeekMessage, поскольку в этом случае можно создать событие OnIdle. В нем нужно рисовать что-то в окне предварительного просмотра.</p>
<p>Окно самого ScreenSaver-а можно делать без WinAPI. Для реагирования на события мыши и клавиатуры лучше всего использовать событие OnMessage. Чтобы ScreenSaver работал в фоновом режиме рисовать нужно в обработчике события OnIdle. Причем каждый раз нужно выполнять быструю операцию. Поскольку в окне ScreenSaver-а и в окне предварительного просмотра должно рисоваться одно и то же, удобно сделать единую процедуру, которая бы выполняла короткое действие. В качестве параметров ей нужно сообщать Canvas, высоту и ширину.</p>
<p>Поскольку, если программе не передаются никакие параметры, запускается окно настроек, то при его создании нужно проверять, где на винчестере находится программа. Если она находится не в каталоге Windows, то нужно скопировать файл, сменив расширение на scr.</p>
<p>В первом модуле находится окно хранителя экрана:</p>
<pre>
...
  public
    procedure OnMessage(var Msg: TMsg; var Handled: Boolean);
    procedure OnIdle(Sender: TObject; var Done: Boolean);
  end;
 
var
  Form1: TForm1;
  r, g, b: integer;
  po: TPoint;
  IniFileName: string;
 
procedure Draw(Canvas: TCanvas; var r, g, b: integer;
  width, height: integer);
 
implementation
 
{$R *.DFM}
 
uses IniFiles;
 
procedure Draw(Canvas: TCanvas; var r, g, b: integer;
  width, height: integer);
begin
  with Canvas do begin
    r := r + random(3) - 1;
    if r &lt; 0 then r := 0;
    if r &gt; 255 then r := 255;
    g := g + random(3) - 1;
    if g &lt; 0 then g := 0;
    if g &gt; 255 then g := 255;
    b := b + random(3) - 1;
    if b &lt; 0 then b := 0;
    if b &gt; 255 then b := 255;
 
    Pen.Color := RGB(r, g, b);
    LineTo(random(width), random(height));
  end;
end;
 
procedure TForm1.OnMessage(var Msg: TMsg; var Handled: Boolean);
begin
  case Msg.message of
    WM_KEYDOWN, WM_KEYUP,
      WM_SYSKEYDOWN, WM_SYSKEYUP,
      WM_LBUTTONDOWN, WM_RBUTTONDOWN, WM_MBUTTONDOWN
        : Close;
    WM_MOUSEMOVE: begin
      if (msg.pt.x &lt;&gt; po.x) or (msg.pt.y &lt;&gt; po.y) then Close;
    end;
  end;
end;
 
procedure TForm1.OnIdle(Sender: TObject; var Done: Boolean);
begin
  Draw(Canvas, r, g, b, Width, Height);
  Done := false;
end;
 
procedure TForm1.FormCreate(Sender: TObject);
var
  ini: TIniFile;
begin
  Application.OnMessage := OnMessage;
  Application.OnIdle := OnIdle;
 
  {Эти два свойства можно установить при помощи Object Inspector}
  BorderStyle := bsNone;
  WindowState := wsMaximized;
 
  ShowCursor(false);
  GetCursorPos(po);
 
  ini := TIniFile.Create(IniFileName);
  if ini.ReadBool('settings', 'clear', true)
    then Brush.Color := clBlack
    else Brush.Style := bsClear;
  ini.Destroy;
end;
</pre>

<p>Окно настроек:</p>
<pre>
...
{$R *.DFM}
 
uses IniFiles, Unit1;
 
procedure TForm2.FormCreate(Sender: TObject);
var
  buf: array [0..127] of char;
  ini: TIniFile;
begin
  GetWindowsDirectory(buf, sizeof(buf));
  if pos(UpperCase(buf), UpperCase(ExtractFilePath(ParamStr(0)))) &lt;= 0 then begin
    if not CopyFile(PChar(ParamStr(0)), PChar(buf + '\MyScrSaver.scr'), false)
      then ShowMessage('Can not copy the file');
  end;
  ini := TIniFile.Create(IniFileName);
  CheckBox1.Checked := ini.ReadBool('settings', 'clear', true);
  ini.Destroy;
 
  {Эти три свойства можно установить при помощи Object Inspector}
  Button1.Caption := 'OK';
  Button2.Caption := 'Cancel';
  CheckBox1.Caption := 'Clear screen';
end;
 
procedure TForm2.Button1Click(Sender: TObject);
var
  ini: TIniFile;
begin
  ini := TIniFile.Create(IniFileName);
  ini.WriteBool('settings', 'clear', CheckBox1.Checked);
  ini.Destroy;
  Close;
end;
 
procedure TForm2.Button2Click(Sender: TObject);
begin
  Close;
end;
</pre>

<p>Файл с самой программой (dpr). Чтобы открыть его выберите Project | View Source.</p>
<p>program Project1;</p>
<pre>
uses
  Forms,
  Graphics,
  Windows,
  Messages,
  Unit1 in 'Unit1.pas' {Form1},
  Unit2 in 'Unit2.pas' {Form2};
 
var
  PrevWnd: hWnd;
  rect: TRect;
  can: TCanvas;
 
procedure Paint;
begin
  Draw(can, r, g, b, rect.Right - rect.Left, rect.Bottom - rect.Top);
end;
 
function MyWndProc(wnd: hWnd; msg: integer;
  wParam, lParam: longint): integer; stdcall;
begin
  case Msg of
    WM_DESTROY: begin
      PostQuitMessage(0);
      result := 0;
    end;
    WM_PAINT: begin
      paint;
      result := DefWindowProc(Wnd, Msg, wParam, lParam);
    end;
    else
      result := DefWindowProc(Wnd, Msg, wParam, lParam);
  end;
end;
 
procedure Preview;
const
  ClassName = 'MyScreenSaverClass'#0;
var
  parent: hWnd;
  WndClass: TWndClass;
  msg: TMsg;
  code: integer;
begin
  val(ParamStr(2), parent, code);
  if (code &lt;&gt; 0) or (parent &lt;= 0) then Exit;
 
  with WndClass do begin
    style := CS_PARENTDC;
    lpfnWndProc := addr(MyWndProc);
    cbClsExtra := 0;
    cbWndExtra := 0;
    hIcon := 0;
    hCursor := 0;
    hbrBackground := 0;
    lpszMenuName := nil;
    lpszClassName := ClassName;
  end;
  WndClass.hInstance := hInstance;
  Windows.RegisterClass(WndClass);
 
  GetWindowRect(Parent, rect);
  PrevWnd := CreateWindow(ClassName, 'MyScreenSaver',
    WS_CHILDWINDOW or WS_VISIBLE or WS_BORDER, 0, 0, rect.Right - rect.Left,
    rect.Bottom - rect.Top, Parent, 0, hInstance, nil);
  can := TCanvas.Create;
  can.Handle := GetDC(PrevWnd);
  can.Brush.Color := clBlack;
  can.FillRect(rect);
  repeat
    if PeekMessage(Msg, 0, 0, 0, PM_REMOVE) then begin
      if Msg.Message = WM_QUIT then break;
      TranslateMessage(Msg);
      DispatchMessage(Msg);
    end else Paint;
  until false;
  ReleaseDC(PrevWnd, can.Handle);
  can.Destroy;
end;
 
var
  c: char;
  buf: array [0..127] of char;
 
begin
  GetWindowsDirectory(buf, sizeof(buf));
  IniFileName := buf + '\myinifile.ini';
  if (ParamCount &gt;= 1) and (Length(ParamStr(1)) &gt; 1)
    then c := UpCase(ParamStr(1)[2])
    else c := #0;
  case c of
    'P': Preview;
    'S': begin
      Application.Initialize;
      Application.CreateForm(TForm1, Form1);
      Application.Run;
    end;
    else begin
      Application.Initialize;
      Application.CreateForm(TForm2, Form2);
      Application.Run;
    end;
  end;
end.
</pre>
</p>

<hr />

<p>1.В файл проекта {*.DPR} добавить строку {$D SCRNSAVE &lt;название хранителя&gt;} после строки подключения модулей (Uses...).</p>
<p>2.У окна формы убрать системное меню, кнопки и придать свойству WindowState значение wsMaximize.</p>
<p>3.Предусмотреть выход из хранителя при нажатии на клавиши клавиатуры, мыши и при перемещении курсора мыши.</p>
<p>4.Проверить параметры с которым был вызван хранитель и если это /c - показать окно настройки хранителя, а иначе (можно проверять на /s, а можно и не проверять) сам хранитель. /p - для отображения в окне установок хранителя экрана.</p>
<p>5.Скомпилировать хранитель экрана.</p>
<p>6.Переименовать *.EXE файл в файл *.SCR и скопировать его в каталог WINDOWS\SYSTEM.</p>
<p>7.Установить новый хранитель в настройках системы!</p>
<p>Название хранителя может состоять из нескольких слов с пробелами, на любом языке. При работе хранителя необходимо прятать курсор мыши, только не забывайте восстанавливать его после выхода.</p>
<p>Все параметры и настройки храните в файле .INI, так как хранитель и окно настройки не связаны друг с другом напрямую. Старайтесь сделать свой хранитель как можно меньше и быстрее. Иначе ваши долго работающие (в фоновом режиме) приложения будут работать еше дольше!</p>
<p>--- в файле *.DPR ---</p>
<pre>
{$D SCRNSAVE Пример хранителя экрана}
 
//проверить переданные параметры}
IF (ParamStr(1) = '/c') OR (ParamStr(1) = '/C') THEN
 // скрыть курсор мыши
 ShowCursor(False);
 // восстановить курсор мыши
 ShowCursor(True);
</pre>


<p>Более подробно о создании хранителя экрана "по всем правилам" Screen Saver in Win95</p>
<p>Главное о чем стоит упомянуть это, что ваш хранитель экрана будет работать в фоновом режиме и он не должен мешать работе других запущенных программ. Поэтому сам хранитель должен быть как можно меньшего объема. Для уменьшения объема файла в описанной ниже программе не используется визуальные компоненты Delphi, включение хотя бы одного из них приведет к увеличению размера файла свыше 200кб, а так, описанная ниже программа, имеет размер всего 20кб!!! Технически, хранитель экрана является нормальным EXE файлом (с расширением .SCR), который управляется через командные параметры строки. Например, если пользователь хочет изменить параметры вашего хранителя, Windows выполняет его с параметром "-c" в командной строке. Поэтому начать создание вашего хранителя экрана следует с создания примерно следующей функции:</p>
<pre>
Procedure RunScreenSaver;
Var S : String;
Begin
  S := ParamStr(1);
  If (Length(S) &gt; 1) Then Begin
    Delete(S,1,1); { delete first char - usally "/" or "-" }
    S[1] := UpCase(S[1]);
  End;
  LoadSettings; { load settings from registry }
  If (S = 'C') Then RunSettings
  Else If (S = 'P') Then RunPreview
  Else If (S = 'A') Then RunSetPassword
  Else RunFullScreen;
End;
</pre>


<p>Поскольку нам нужно создавать небольшое окно предварительного просмотра и полноэкранное окно, их лучше объединить используя единственный класс окна. Следуя правилам хорошего тона, нам также нужно использовать многочисленные нити. Дело в том, что, во-первых, хранитель не должен переставать работать даже если что-то "тяжелое" случилось, и во-вторых, нам не нужно использовать таймер. Процедура для запуска хранителя на полном экране - приблизительно такова:</p>
<pre>
 
Procedure RunFullScreen;
Var
  R          : TRect;
  Msg        : TMsg;
  Dummy      : Integer;
  Foreground : hWnd;
Begin
  IsPreview := False;  MoveCounter := 3;  
  Foreground := GetForegroundWindow;
  While (ShowCursor(False) &gt; 0) do ;
  GetWindowRect(GetDesktopWindow,R);
  CreateScreenSaverWindow(R.Right-R.Left,R.Bottom-R.Top,0);
  CreateThread(nil,0,@PreviewThreadProc,nil,0,Dummy);
  SystemParametersInfo(spi_ScreenSaverRunning,1,@Dummy,0);
  While GetMessage(Msg,0,0,0) do Begin
    TranslateMessage(Msg);
    DispatchMessage(Msg);
  End;
  SystemParametersInfo(spi_ScreenSaverRunning,0,@Dummy,0);
  ShowCursor(True);
  SetForegroundWindow(Foreground);
End;
</pre>

<p>Во-первых, мы проинициализировали некоторые глобальные переменные (описанные далее), затем прячем курсор мыши и создаем окно хранителя экрана. Имейте в виду, что важно уведомлять Windows, что это - хранителя экрана через SystemParametersInfo (это выводит из строя Ctrl-Alt-Del чтобы нельзя было вернуться в Windows не введя пароль). Создание окна хранителя:</p>
<pre>
Function CreateScreenSaverWindow(Width,Height : Integer;  
  ParentWindow : hWnd) : hWnd;
Var WC : TWndClass;
Begin
  With WC do Begin
    Style := cs_ParentDC;
    lpfnWndProc := @PreviewWndProc;
    cbClsExtra := 0;  cbWndExtra := 0; hIcon := 0; hCursor := 0;
    hbrBackground := 0; lpszMenuName := nil; 
    lpszClassName := 'MyDelphiScreenSaverClass';
    hInstance := System.hInstance;
  end;
  RegisterClass(WC);
  If (ParentWindow  0) Then
    Result := CreateWindow('MyDelphiScreenSaverClass','MySaver', 
      ws_Child Or ws_Visible or ws_Disabled,0,0, 
      Width,Height,ParentWindow,0,hInstance,nil)
  Else Begin
    Result := CreateWindow('MyDelphiScreenSaverClass','MySaver', 
      ws_Visible or ws_Popup,0,0,Width,Height, 0,0,hInstance,nil);
    SetWindowPos(Result,hwnd_TopMost,0,0,0,0,swp_NoMove or swp_NoSize or 
swp_NoRedraw);
  End;
  PreviewWindow := Result;
End;
</pre>


<p>Теперь окна созданы используя вызовы API. Я удалил проверку ошибки, но обычно все проходит хорошо, особенно в этом типе приложения. Теперь Вы можете погадать, как мы получим handle родительского окна предварительного просмотра ? В действительности, это совсем просто: Windows просто передает handle в командной строке, когда это нужно. Таким образом:</p>
<pre>
Procedure RunPreview;
Var
  R             : TRect;
  PreviewWindow : hWnd;
  Msg           : TMsg;
  Dummy         : Integer;
Begin
  IsPreview := True;
  PreviewWindow := StrToInt(ParamStr(2));
  GetWindowRect(PreviewWindow,R);
  CreateScreenSaverWindow(R.Right-R.Left,R.Bottom-R.Top,PreviewWindow);
  CreateThread(nil,0,@PreviewThreadProc,nil,0,Dummy);
  While GetMessage(Msg,0,0,0) do Begin
    TranslateMessage(Msg); DispatchMessage(Msg);
  End;
End;
</pre>


<p>Как Вы видите, window handle является вторым параметром (после "-p"). Чтобы "выполнять" хранителя экрана - нам нужна нить. Это создается с вышеуказанным CreateThread. Процедура нити выглядит примерно так:</p>
<pre>
Function PreviewThreadProc(Data : Integer) : Integer; StdCall;
Var R : TRect;
Begin
  Result := 0; Randomize;
  GetWindowRect(PreviewWindow,R);
  MaxX := R.Right-R.Left;  MaxY := R.Bottom-R.Top;
  ShowWindow(PreviewWindow,sw_Show); UpdateWindow(PreviewWindow);
  Repeat
    InvalidateRect(PreviewWindow,nil,False);
    Sleep(30);
  Until QuitSaver;
  PostMessage(PreviewWindow,wm_Destroy,0,0);
End;
</pre>


<p>Нить просто заставляет обновляться изображения в нашем окне, спит на некоторое время, и обновляет изображения снова. А Windows будет посылать сообщение WM_PAINT на наше окно (не в нить !). Для того, чтобы оперировать этим сообщением, нам нужна процедура:</p>
<pre>
Function PreviewWndProc(Window : hWnd; Msg,WParam,
  LParam : Integer): Integer; StdCall;
Begin
  Result := 0;
  Case Msg of
    wm_NCCreate  : Result := 1;
    wm_Destroy   : PostQuitMessage(0);
    wm_Paint     : DrawSingleBox; { paint something }
    wm_KeyDown   : QuitSaver := AskPassword;
    wm_LButtonDown, wm_MButtonDown, wm_RButtonDown, wm_MouseMove : 
                   Begin
                     If (Not IsPreview) Then Begin
                       Dec(MoveCounter);
                       If (MoveCounter &lt;= 0) Then QuitSaver := AskPassword;
                     End;
                   End;
     Else Result := DefWindowProc(Window,Msg,WParam,LParam);
  End;
End;
</pre>


<p>Если мышь перемещается, кнопка нажала, мы спрашиваем у пользователя пароль:</p>
<pre>
 
Function AskPassword : Boolean;
Var
  Key   : hKey;
  D1,D2 : Integer; { two dummies }
  Value : Integer;
  Lib   : THandle;
  F     : TVSSPFunc;
Begin
  Result := True;
  If (RegOpenKeyEx(hKey_Current_User,'Control Panel\Desktop',0, 
      Key_Read,Key) = Error_Success) Then 
  Begin
    D2 := SizeOf(Value);
    If (RegQueryValueEx(Key,'ScreenSaveUsePassword',nil,@D1, 
        @Value,@D2) = Error_Success) Then 
    Begin
      If (Value  0) Then Begin
        Lib := LoadLibrary('PASSWORD.CPL');
        If (Lib &gt; 32) Then Begin
          @F := GetProcAddress(Lib,'VerifyScreenSavePwd');
          ShowCursor(True);
          If (@F  nil) Then Result := F(PreviewWindow);
          ShowCursor(False);
          MoveCounter := 3; { reset again if password was wrong }
          FreeLibrary(Lib);
        End;
      End;
    End;
    RegCloseKey(Key);
  End;
End;
</pre>


<p>Это также демонстрирует использование registry на уровне API. Также имейте в виду как мы динамически загружаем функции пароля, используюя LoadLibrary. Запомните тип функции? TVSSFunc ОПРЕДЕЛЕН как:</p>
<pre>
Type
TVSSPFunc = Function(Parent : hWnd) : Bool; StdCall;
 
// Теперь почти все готово, кроме диалога конфигурации. Это запросто:
 
Procedure RunSettings;
Var Result : Integer;
Begin
  Result := DialogBox(hInstance,'SaverSettingsDlg',0,@SettingsDlgProc);
  If (Result = idOK) Then SaveSettings;
End;
</pre>


<p>Трудная часть -это создать диалоговый сценарий (запомните: мы не используем здесь Delphi формы!). Я сделал это, используя 16-битовую Resource Workshop (остался еще от Turbo Pascal для Windows). Я сохранил файл как сценарий (текст), и скомпилированный это с BRCC32:</p>
<pre>
SaverSettingsDlg DIALOG 70, 130, 166, 75
STYLE WS_POPUP | WS_DLGFRAME | WS_SYSMENU
CAPTION "Settings for Boxes"
FONT 8, "MS Sans Serif"
BEGIN
    DEFPUSHBUTTON "OK", 5, 115, 6, 46, 16
    PUSHBUTTON "Cancel", 6, 115, 28, 46, 16
    CTEXT "Box &amp;Color:", 3, 2, 30, 39, 9
    COMBOBOX 4, 4, 40, 104, 50, CBS_DROPDOWNLIST | CBS_HASSTRINGS
    CTEXT "Box &amp;Type:", 1, 4, 3, 36, 9
    COMBOBOX 2, 5, 12, 103, 50, CBS_DROPDOWNLIST | CBS_HASSTRINGS
    LTEXT "Boxes Screen Saver for Win32 Copyright (c) 1996 Jani
           Jдrvinen.", 7, 4, 57, 103, 16,
           WS_CHILD | WS_VISIBLE | WS_GROUP
END
</pre>


<p>Почти также легко сделать диалоговое меню:</p>
<pre>
 
Function SettingsDlgProc(Window : hWnd; Msg,WParam,LParam : Integer): 
Integer; StdCall;
Var S : String;
Begin
  Result := 0;
  Case Msg of
    wm_InitDialog : Begin
                      { initialize the dialog box }
                      Result := 0;
                    End;
    wm_Command    : Begin
                      If (LoWord(WParam) = 5) Then EndDialog(Window,idOK)
                      Else If (LoWord(WParam) = 6) Then EndDialog(Window,idCancel);
                    End;
    wm_Close      : DestroyWindow(Window);
    wm_Destroy    : PostQuitMessage(0);
    Else Result := 0;
  End;
End;
</pre>

<p>После того, как пользователь выбрал некоторые установочные параметры, нам нужно сохранить их.</p>
<pre>
Procedure SaveSettings;
Var
  Key   : hKey;
  Dummy : Integer;
Begin
  If (RegCreateKeyEx(hKey_Current_User,
                     'Software\SilverStream',
                     0,nil,Reg_Option_Non_Volatile,
                     Key_All_Access,nil,Key,
                     @Dummy) = Error_Success) Then Begin
    RegSetValueEx(Key,'RoundedRectangles',0,Reg_Binary, 
     @RoundedRectangles,SizeOf(Boolean));
    RegSetValueEx(Key,'SolidColors',0,Reg_Binary, @SolidColors,SizeOf(Boolean));
    RegCloseKey(Key);
  End;
End;
</pre>


<p>Загружаем параметры так:</p>
<pre>
Procedure LoadSettings;
Var
  Key   : hKey;
  D1,D2 : Integer; { two dummies }
  Value : Boolean;
Begin
  If (RegOpenKeyEx(hKey_Current_User,
                   'Software\SilverStream',0,
                   Key_Read,
                   Key) = Error_Success) Then Begin
    D2 := SizeOf(Value);
    If (RegQueryValueEx(Key,'RoundedRectangles',nil,@D1,
        @Value, @D2) = Error_Success) Then 
    Begin   
      RoundedRectangles := Value;
    End;
    If (RegQueryValueEx(Key,'SolidColors',nil,@D1,
        @Value,@D2) = Error_Success) Then 
    Begin
      SolidColors := Value;
    End;
    RegCloseKey(Key);
  End;
End;
</pre>


<p>Легко? Нам также нужно позволить пользователю, установить пароль. Я честно не знаю почему это оставлено разработчику приложений ? Тем не менее:</p>
<pre>
Procedure RunSetPassword;
Var
  Lib : THandle;
  F   : TPCPAFunc;
Begin
  Lib := LoadLibrary('MPR.DLL');
  If (Lib &gt; 32) Then Begin
    @F := GetProcAddress(Lib,'PwdChangePasswordA');
    If (@F  nil) Then F('SCRSAVE',StrToInt(ParamStr(2)),0,0);
    FreeLibrary(Lib);
  End;
End;
</pre>


<p>Мы динамически загружаем (недокументированную) библиотеку MPR.DLL, которая имеет функцию, чтобы установить пароль хранителя экрана, так что нам не нужно беспокоиться об этом. TPCPAFund ОПРЕДЕЛЕН как:</p>
<pre>
Type
  TPCPAFunc = Function(A : PChar; Parent : hWnd;
    B,C : Integer) : Integer; StdCall;
</pre>


<p>(Не спрашивайте меня что за параметры B и C) Теперь единственная вещь, которую нам нужно рассмотреть, - самая странная часть: создание графики. Я не великий ГУРУ графики, так что Вы не увидите затеняющие многоугольники, вращающиеся в реальном времени. Я только сделал некоторые ящики.</p>
<pre>
Procedure DrawSingleBox;
Var
  PaintDC  : hDC;
  Info     : TPaintStruct;
  OldBrush : hBrush;
  X,Y      : Integer;
  Color    : LongInt;
Begin
  PaintDC := BeginPaint(PreviewWindow,Info);
  X := Random(MaxX); Y := Random(MaxY);
  If SolidColors Then
    Color := 
GetNearestColor(PaintDC,RGB(Random(255),Random(255),Random(255)))
  Else Color := RGB(Random(255),Random(255),Random(255));
  OldBrush := SelectObject(PaintDC,CreateSolidBrush(Color));
  If RoundedRectangles Then
    RoundRect(PaintDC,X,Y,X+Random(MaxX-X),Y+Random(MaxY-Y),20,20)
  Else Rectangle(PaintDC,X,Y,X+Random(MaxX-X),Y+Random(MaxY-Y));
  DeleteObject(SelectObject(PaintDC,OldBrush));
  EndPaint(PreviewWindow,Info);
End;
</pre>


<p>Чтобы закончить создание хранителя, я даю Вам некоторые детали. Первые, глобальные переменные:</p>
<pre>
Var
  IsPreview         : Boolean;
  MoveCounter       : Integer;
  QuitSaver         : Boolean;
  PreviewWindow     : hWnd;
  MaxX,MaxY         : Integer;
  RoundedRectangles : Boolean;
  SolidColors       : Boolean;
</pre>


<p>Затем исходная программа проекта (.dpr). Красива, а!?</p>
<pre>
program MySaverIsGreat;
uses
   windows, messages, Utility; { defines all routines }
{$R SETTINGS.RES}
begin
  RunScreenSaver; 
end.
</pre>


<p>Ох, чуть не забыл: Если, Вы используете SysUtils в вашем проекте (StrToInt определен там) Вы получаете большой EXE чем обещанный 20k. Если Вы хотите все же иметь20k, Вы не можете использовать SysUtils так, или Вам нужно написать вашу собственную StrToInt программу.</p>
<p>Конец.</p>
<p>Use Val... ;-)</p>
<p>перевод: Владимиров А.М.</p>
<p>От переводчика. Если все же очень трудно обойтись без использования Delphi-форм, то можно поступить как в случае с вводом пароля: форму изменения параметров хранителя сохранить в виде DLL и инамически ее загружать при необходимости. Т.о. будет маленький и шустрый файл самого хранителя экрана и довеска DLL для конфигурирования и прочего (там объем и скорость уже не критичны).</p>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>

<hr />

<p>Время от времени я наблюдаю вопросы с просьбой рассказать о процессе создания с помощью Delphi хранителя экрана, которого можно было бы выбрать с помощью панели управления (Control Panel / Desktop). После того, как я увидел несколько общих ответов, частично отвечавших на заданный вопрос, я решил создать данный совет и полностью посвятить вас в технологию создания хранителя экрана Windows от начала до конца. Приведенный ниже код позволяет создать предмет нашего разговора, а именно - простой хранитель экрана Windows.</p>
<p>Полный исходный код данного хранителя приведен в конце совета. Ну а теперь обсудим подробности создания этого типа программ, являющихся ровесниками первого компьютера.</p>
<p>Вступление</p>
<p>Хранитель экрана Windows является обыкновенным исполнимым приложением Windows, имеющим в отличие от стандартных программ расширение .SCR. Тем не менее, для корректного связывания с панелью управления, хранитель должен соблюдать определенные требования. В общих чертах программа должна:</p>
<p>поддерживать опции настройки</p>
<p>содержать свое описание</p>
<p>различать состояния активного режима и режима конфигурации</p>
<p>недопускать запуск своей второй копии</p>
<p>осуществлять выход, если пользователь нажал клавишу или переместил мышь</p>
<p>Ниже я попытаюсь показать, как каждое из этих требований может быть удовлетворено с помощью Delphi.</p>
<p>С самого начала</p>
<p>Хранитель экрана, который мы собираемся создать, во время очередного простоя компьютера очищает экран и рисует затененные сферы в произвольных местах экрана, периодически их стирая и начиная заново. Пользователь может определить максимальное количество выводимых на экран сфер и скорость их рисования.</p>
<p>Прежде всего создайте новый, пустой проект, выбрав пункт New Project из меню File. (Если вы находитесь в репозитарии, выберите "Blank project".)</p>
<p>Конфигурационная форма</p>
<p>Первое, что видит большинство людей при запуске хранителя экрана - диалог настройки. В нем пользователь может определить значения для специфических опций хранителя экрана. Для того, чтобы создать такую форму, измените свойства Form1 (создается автоматически при создании нового проекта) как показано ниже:</p>
<p>BorderIcons     [biSystemMenu]</p>
<p>  biSystemMenu  True</p>
<p>  biMinimize    False</p>
<p>  biMaximize    False</p>
<p>BorderStyle     bsDialog</p>
<p>Caption         Configuration</p>
<p>Height          162</p>
<p>Name            CfgFrm</p>
<p>Position        poScreenCenter</p>
<p>Visible         False</p>
<p>Width           266</p>
<p>Нам необходимо предоставить возможность изменять максимальное количество сфер, выводимых на экране, их размер и скорость рисования. Для того, чтобы это сделать, добавьте следующие три компонента Label (из палитры Standard) и компонент SpinEdit (из палитры Samples): (Примечание: Для быстрого размещения этих компонентов на форме скопируйте этот текст в буфер обмена и замените текст описания формы, выводимый при нажатии на пункт меню "View as Text" контекстного меню формы.)</p>
<pre>
object Label1: TLabel
 
Left = 16
Top = 19
Width = 58
Height = 16
Alignment = taRightJustify
Caption = 'Сфер:'
end
object Label2: TLabel
 
Left = 41
Top = 59
Width = 33
Height = 16
Alignment = taRightJustify
Caption = 'Размер:'
end
object Label3: TLabel
 
Left = 29
Top = 99
Width = 45
Height = 16
Alignment = taRightJustify
Caption = 'Скорость:'
end
object spnSpheres: TSpinEdit
 
Left = 84
Top = 15
Width = 53
Height = 26
MaxValue = 500
MinValue = 1
TabOrder = 0
Value = 50
end
object spnSize: TSpinEdit
 
Left = 84
Top = 55
Width = 53
Height = 26
MaxValue = 250
MinValue = 50
TabOrder = 1
Value = 100
end
object spnSpeed: TSpinEdit
 
Left = 84
Top = 95
Width = 53
Height = 26
MaxValue = 10
MinValue = 1
TabOrder = 2
Value = 10
end
</pre>


<p>Наконец, нам необходимы три кнопки -- OK, Отмена и Тест. Кнопка Тест не является стандартной для диалогов настройки хранителей экрана, но она позволяет удобно и легко проверить сделанные изменения. Добавьте следующие три кнопки, используя компоненты BitBtn из палитры "Additional":</p>
<pre>
object btnOK: TBitBtn
 
Left = 153
Top = 11
Width = 89
Height = 34
TabOrder = 3
Kind = bkOK
end
object btnCancel: TBitBtn
 
Left = 153
Top = 51
Width = 89
Height = 34
TabOrder = 4
Kind = bkCancel
end
object btnTest: TBitBtn
 
Left = 153
Top = 91
Width = 89
Height = 34
Caption = 'Тест...'
TabOrder = 5
Kind = bkIgnore
end
</pre>


<p>Для того, чтобы мы могли управлять формой и текущими значениями, нам необходимо создать некоторый код. Для начала мы должны обеспечить возможность загрузки и сохранения текущей конфигурации. Чтобы сделать это, мы должны сохранить значения размера и скорости рисования сфер в файле инициализации (*.INI) в директории Windows. Объект Delphi TIniFile - именно то, что нам нужно.</p>
<p>Перейдите к редактору кода модуля Setup и добавьте следующее объявление в секции используемых модулей:</p>
<pre>
uses
  IniFiles;
</pre>


<p>Затем добавьте следующие объявления процедур в секцию private модуля TCfgFrm:</p>
<pre>
procedure LoadConfig;
procedure SaveConfig;
</pre>


<p>Теперь создайте код самих процедур после секции uses в разреле реализации:</p>
<pre>
const
 
CfgFile = 'SPHERES.INI';
 
procedure TCfgFrm.LoadConfig;
var
 
inifile : TIniFile;
begin
 
inifile := TIniFile.Create(CfgFile);
try
with inifile do begin
spnSpheres.Value := ReadInteger('Config', 'Spheres', 50);
spnSize.Value    := ReadInteger('Config', 'Size', 100);
spnSpeed.Value   := ReadInteger('Config', 'Speed', 10);
end;
finally
inifile.Free;
end;
end; {TCfgFrm.LoadConfig}
 
procedure TCfgFrm.SaveConfig;
var
 
inifile : TIniFile;
begin
 
inifile := TIniFile.Create(CfgFile);
try
with inifile do begin
WriteInteger('Config', 'Spheres', spnSpheres.Value);
WriteInteger('Config', 'Size', spnSize.Value);
WriteInteger('Config', 'Speed', spnSpeed.Value);
end;
finally
inifile.Free;
end;
end; {TCfgFrm.SaveConfig}
</pre>

<p>Для обеспечения необходимой функциональности нашей формы нам необходимо создать обработчики некоторых событий, чтобы правильно и в нужный момент загрузить или сохранить конфигурацию. Сначала, в момент запуска программы, нам необходимо автоматически загрузить сохраненную конфигурацию. Для этого нам нужно обработать событие событие OnCreate нашей конфигурационной формы. Дважды щелкните на событии OnCreate в Инспекторе Объектов и введите следующий код:</p>
<pre>
procedure TCfgFrm.FormCreate(Sender: TObject);
begin
  LoadConfig;
end; {TCfgFrm.FormCreate}
</pre>


<p>Далее дважды щелкните на кнопке OK. Нам необходимо сохранять текущую конфигурацию и закрывать окно при каждом нажатии данной кнопки, поэтому введите следующий код:</p>
<pre>
procedure TCfgFrm.btnOKClick(Sender: TObject);
begin
  SaveConfig;
  Close;
end; {TCfgFrm.btnOKClick}
</pre>


<p>Для того чтобы закрыть форму, не сохраняя результаты, напишите следующий обработчик для кнопки Отмена (дважды щелкните по ней):</p>
<pre>
procedure TCfgFrm.btnCancelClick(Sender: TObject);
begin
  Close;
end; {TCfgFrm.btnCancelClick}
</pre>


<p>Наконец, чтобы протестировать хранителя экрана, мы должны вывести на экран его форму (которую мы еще не создали). Дважды щелкните на кнопке Тест и введите следующий код:</p>
<pre>
procedure TCfgFrm.btnTestClick(Sender: TObject);
begin
  ScrnFrm.Show;
end; {TCfgFrm.btnTestClick}
</pre>


<p>Затем добавьте "Scrn" в список используемых модулей в секции реализации. Scrn - это модуль формы хранителя экрана, который мы создадим в следующем шаге. Ну а пока сохраните созданный нами модуль с именем "Cfg", выбрав пункт "Save File As" в меню "File".</p>
<p>Форма хранителя экрана</p>
<p>Сам хранитель экрана будет просто большой, черной формой без заголовка, занимающей весь экран, на котором и будет разворачиваться наше представление. Для того, чтобы создать вторую форму, выберите пункт New Form в меню File или "Blank form" в репозитарии.</p>
<p>BorderIcons     []</p>
<p>  biSystemMenu  False</p>
<p>  biMinimize    False</p>
<p>  biMaximize    False</p>
<p>BorderStyle     bsNone</p>
<p>Color           clBlack</p>
<p>FormStyle       fsStayOnTop</p>
<p>Name            ScrnFrm</p>
<p>Visible         False</p>
<p>Расположите на форме единственный Delphi компонент - таймер из палитры System. Установите его свойства как указано ниже:</p>
<pre>
object tmrTick: TTimer
  Enabled = False
  OnTimer = tmrTickTimer
  Left = 199
  Top = 122
end
</pre>


<p>Больше никаких компонентов для этой формы не потребуется. Тем не менее мы должны добавить некоторый код, осуществляющий рисование затененных сфер. Переключитесь в редактор кода на модуль формы ScrnFrm. В секции private TScrnFrm добавьте следующее объявление процедуры:</p>
<pre>
procedure DrawSphere(x, y, size : integer; color : TColor);
</pre>


<p>Теперь, в секции реализации модуля, добавьте код для данной процедуры:</p>
<pre>
procedure TScrnFrm.DrawSphere(x, y, size : integer; color : TColor);
var
i, dw    : integer;
cx, cy   : integer;
xy1, xy2 : integer;
r, g, b  : byte;
begin
with Canvas do begin
{Заполняем установки карандаша и кисти.}
Pen.Style := psClear;
Brush.Style := bsSolid;
Brush.Color := color;
{Подготовим цвета для сфер.}
r := GetRValue(color);
g := GetGValue(color);
b := GetBValue(color);
{Рисуем сферу.}
dw := size div 16;
for i := 0 to 15 do begin
xy1 := (i * dw) div 2;
xy2 := size - xy1;
Brush.Color := RGB(Min(r + (i * 8), 255), Min(g + (i * 8), 255),
Min(b + (i * 8), 255));
Ellipse(x + xy1, y + xy1, x + xy2, y + xy2);
end;
end;
end; {TScrnFrm.DrawSphere}
</pre>


<p>Как вы можете увидеть из кода, мы задаем координаты (x,y) верхней части, левый угол сферы, а также диаметр и базовый цвет. Затем, для того, чтобы нарисовать сферу, мы создаем градиент от базового до самого яркого цвета. Изменяя шаг за шагом цвет кисти, мы рисуем и заполняем каждый раз концентрический круг меньшего диаметра.</p>
<p>Наверняка вы также обратили внимание на то, что функция периодически обращается другой функции, именуемой Min(). Так как это функция не является стандартной функцией Delphi, мы должны добавить ее объявление к данному модулю, выше объявления DrawSphere().</p>
<pre>
function Min(a, b : integer) : integer;
begin
if b &lt; a then
Result := b
else
Result := a;
end; {Min}
</pre>


<p>Для периодического вызова функции DrawSphere() мы должны реагировать на событие OnTimer компонента Timer, который мы добавили к форме ScrnFrm. Дважды щелкните на этом компоненте и заполните автоматически созданный скелет процедуры следующим кодом:</p>
<pre>
procedure TScrnFrm.tmrTickTimer(Sender: TObject);
const
sphcount : integer = 0;
var
x, y    : integer;
size    : integer;
r, g, b : byte;
color   : TColor;
begin
if sphcount &gt; CfgFrm.spnSpheres.Value then begin
Refresh;
sphcount := 0;
end;
Inc(sphcount);
x := Random(ClientWidth);
y := Random(ClientHeight);
size := CfgFrm.spnSize.Value + Random(50) - 25;
x := x - size div 2;
y := y - size div 2;
r := Random($80);
g := Random($80);
b := Random($80);
DrawSphere(x, y, size, RGB(r, g, b));
end; {TScrnFrm.tmrTickTimer}
</pre>


<p>Данная процедура осуществляет подсчет рисуемых сфер и осуществляет восстановление (стирание) экрана при достижении максимального числа сфер. Кроме этого, она вычисляет случайную позицию, размер и цвет следующей выводимой сферы. (Примечание: диапазон цветов ограничен только первой половиной спектра яркости для обеспечения большей глубины тени.)</p>
<p>Возможно вы уже обратили внимание, что процедура tmrTickTimer() обращается к форме CfgFrm для получения текущих значений конфигурации. Для того, чтобы эта ссылка работала, добавьте в секцию используемых модулей следующие строчки:</p>
<p>uses</p>
<p>  Cfg;</p>

<p>Затем нам необходим способ деактивирования хранителя экрана при нажатии любой клавиши, передвижении мыши или потери фокуса. Реализация этого возможна только с помощью обработчика события Application.OnMessage, которое может реагировать на необходимые для выхода их хранителя экрана сообщения.</p>
<p>Для начала добавьте следующее объявление переменной в секции реализации модуля:</p>
<p>var</p>
<p>  crs : TPoint;</p>

<p>Эта переменная необходима для хранения оригинальной позиции курсора мыши для ее последующего сравнения. Теперь добавьте следующее объявление в секции private модуля TScrnFrm:</p>
<p>procedure DeactivateScrnSaver(var Msg : TMsg; var Handled : boolean);</p>

<p>Добавьте соответствующий код в секцию реализации модуля:</p>
<pre>
procedure TScrnFrm.DeactivateScrnSaver(var Msg : TMsg; var Handled : boolean);
var
done : boolean;
begin
if Msg.message = WM_MOUSEMOVE then
done := (Abs(LOWORD(Msg.lParam) - crs.x) &gt; 5) or
(Abs(HIWORD(Msg.lParam) - crs.y) &gt; 5)
else
done := (Msg.message = WM_KEYDOWN) or (Msg.message = WM_ACTIVATE) or
(Msg.message = WM_ACTIVATEAPP) or (Msg.message = WM_NCACTIVATE);
if done then
Close;
end; {TScrnFrm.DeactivateScrnSaver}
</pre>


<p>При получении системного сообщения WM_MOUSEMOVE мы сравниваем новые координаты мыши с оригинальными. Если перемещение мыши превысило допустимое значение (в нашем случае порог составляет 5 пикселей), закрываем хранитель экрана. Далее проверяем нажатие клавиши или передачу фокуса другому окну или диалогу, и в этом случае также закрываем хранитель.</p>
<p>Чтобы процедура работала, нам нужно передать обработчику события Application.OnMessage оригинальную позицию курсора мыши. Лучшее место для получения координат курсора находится в обработчике события формы OnShow:</p>
<pre>
procedure TScrnFrm.FormShow(Sender: TObject);
begin
GetCursorPos(crs);
tmrTick.Interval      := 1000 - CfgFrm.spnSpeed.Value * 90;
tmrTick.Enabled       := true;
Application.OnMessage := DeactivateScrnSaver;
ShowCursor(false);
end; {TScrnFrm.FormShow}
</pre>


<p>В данном участке кода мы также задаем периодичность срабатывания таймера и активизируем его, а также прячем курсор мыши. Следующий код не является обязательным, но тем не менее мы включим его в обработчик события OnHide:</p>
<pre>
procedure TScrnFrm.FormHide(Sender: TObject);
begin
Application.OnMessage := nil;
tmrTick.Enabled       := false;
ShowCursor(true);
end; {TScrnFrm.FormHide}
</pre>


<p>И, наконец, нам необходимо убедиться, что при запуске форма хранителя экрана занимает целый экран. Для этого добавьте следующий код в обработчик события формы OnActivate:</p>
<pre>
procedure TScrnFrm.FormActivate(Sender: TObject);
begin
WindowState := wsMaximized;
end; {TScrnFrm.FormActivate}
</pre>


<p>Сохраните созданный нами модуль ScrnFrm под именем "SCRN.PAS", выбрав пункт Save File в меню File.</p>
<p>Описание хранителя экрана</p>
<p>Вы можете определить текст, который появится в списке хранителей экранов в Control Panel / Desktop, добавив директиву {$D текст} к исходному файлу проекта. Директива $D вставляет текст в описание модуля выполняемого файла. Чтобы Панель Управления "поняла" этот текст и принадлежность файла к хранителям экрана, описание должно начинаться с зарезервированного слова "SCRNSAVE".</p>
<p>Выберите пункт Project Source из меню View для редактирования исходного кода проекта. Под директивой "{$R *.RES}" добавьте следующую строчку:</p>
<p>{$D SCRNSAVE Spheres Screen Saver}</p>

<p>Теперь при выводе списка доступных хранителей экранов в Контрольной Панели вы увидите текст "Spheres Screen Saver", позволяющий выбрать ваш маленький шедевр.</p>
<p>Активный режим и режим конфигурации</p>
<p>Windows запускает программу хранителя экрана при двух возможных условиях: 1) при активизации хранителя экрана, и 2) когда необходимо изменить его настройки. В обоих случаях Windows запускает одну и ту же программу. Для запуска программы в одном из двух режимов предусмотрен параметр командной строки - "/s" для активного режима и "/c" для режима конфигурации. Для корректной работы с Панелью управления наш хранитель экрана должен проверять командную строку на предмет наличия одного из ключа.</p>
<p>Активный режим</p>
<p>Когда хранитель экрана стартует в активном режиме (/s), нам необходимо создать и показать именно форму хранителя экрана. Но при этом нам также необходимо создать и форму конфигурации, поскольку она содержит все конфигурационные настройки. При закрытии формы хранителя экрана программа завершает свою работу. В этом режиме форма хранителя экрана является главной формой приложения - она запускается при старте приложения и при ее закрытии приложение завершается.</p>
<p>Режим конфигурации</p>
<p>Когда хранитель экрана стартует в режиме конфигурации (/c), нам необходимо создать и вывести на экран конфигурационную форму. Но при этом нам также необходимо создать и форму хранителя экрана, поскольку пользователь может захотеть протестировать выбранные настройки. Тем не менее, при закрытии конфигурационной формы приложение также должно завершить свою работу. В этом случае мы определяем конфигурационную форму как главную форму приложения.</p>
<p>Определение главной формы</p>
<p>В нашем случае нам необходимо идентифицировать ScrnFrm как главную форму приложения, если в командной строке присутствовал параметр /s, в противном случае главной формой приложения должна быть форма CfgFrm. Чтобы это сделать, необходимо знать одну недокументированную характеристику VCL объекта TApplication: главной формой приложения становится первая форма, создаваемая вызовом Application.CreateForm(). Таким образом, для определения главной формы приложения согласно параметрам, передаваемым во время выполнения программы, следует отредактировать исходный код проекта следующим образом:</p>
<pre>
begin
if (ParamCount &gt; 0) and (UpperCase(ParamStr(1)) = '/S') then begin
{ScrnFrm должна быть главной формой.}
Application.CreateForm(TScrnFrm, ScrnFrm);
Application.CreateForm(TCfgFrm, CfgFrm);
end else begin
{CfgFrm должна быть главной формой.}
Application.CreateForm(TCfgFrm, CfgFrm);
Application.CreateForm(TScrnFrm, ScrnFrm);
end;
Application.Run;
end.
</pre>


<p>Просто изменяя порядок создания форм, мы автоматически устанавливаем главную форму приложения. Кроме того, основная форма будет показана автоматически, несмотря на то, что для обоих форм мы установили значение свойства Visible равным False. В результате мы получаем желаемый эффект с использованием минимального кода.</p>
<p>(Примечание: для обеспечения показанной выше функциональности необходимо выключить опцию "Complete boolean eval" в пункте меню Options | Project | Compiler settings. В противном случае при отсутствии параметров командной строки будет возникать ошибка.)</p>
<p>Для использования Delphi функции UpperCase(), необходимо включить модуль SysUtils в список используемых модулей исходного кода проекта как показано ниже:</p>
<pre>
uses
  Forms, SysUtils,
  Scrn in 'SCRN.PAS' {ScrnFrm},
  Cfg in 'CFG.PAS' {CfgFrm};
</pre>


<p>Блокировка запуска второй копии</p>
<p>При разработке хранителя экрана необходимо учитывать один ньюанс - недопущение запуска второй копии хранителя. В противном случае Windows будет запускать хранитель экрана каждый раз при наступлении времени его активизации, даже в случае, когда он запущен.</p>
<p>Для того, чтобы недопустить запуск второй копии нашего хранителя, отредактируйте исходный код проекта следующим образом:</p>
<pre>
begin
{Возможен запуск только одной копии.}
if hPrevInst = 0 then begin
if (ParamCount &gt; 0) and (UpperCase(ParamStr(1)) = '/S') then begin
...
end;
Application.Run;
end;
end;
</pre>


<p>Переменная hPrevInst является глобальной переменной, определенной в Delphi для ссылки на запущенные копиии текущей программы. Ее значение будет равно нулю, если хранитель экрана еще не был запущен.</p>
<p>Теперь сохраните файл проекта с именем "SPHERES.DPR" и скомпилируйте программу. Вот мы и получили хранитель экрана, полностью удовлетворяющий всем нашим требованиям. В случае отсутствия параметров в командной строке программа переходит в режим конфигурации, заданный по умолчанию. Вы можете протестировать активный режим, передавая в командной строке первым параметр "/s". (Смотри Run | Parameters...)</p>
<p>Установка хранителя экрана</p>
<p>После отладки и проверки хранителя экрана вы уже можете его установить и использовать в системе. Для этого скопируйте исполняемый файл (SPHERES.EXE) в директорию Windows и измените его расширение на .SCR, в результате чего вы получите файл с именем SPHERES.SCR. Затем, войдя в Панель Управления, дважды щелкните на иконке Desktop, и выберите Screen Saver | Name. Вы должны увидеть "Spheres Screen Saver" в списке доступных хранителей экрана. Выбрав его и нажав на кнопку ОК, вы тем самым сделаете его активным системным хранителем.</p>
<p>Полный исходный код проекта хранителя экрана</p>
<p>Cfg.dfm</p>
<pre>
// Cfg.dfm
 
object CfgFrm: TCfgFrm
  Left = 196
    Top = 124
    BorderIcons = [biSystemMenu]
    BorderStyle = bsDialog
    Caption = 'Конфигурация'
    ClientHeight = 135
    ClientWidth = 258
    Font.Color = clWindowText
    Font.Height = -13
    Font.Name = 'System'
    Font.Style = []
    PixelsPerInch = 96
    Position = poScreenCenter
    OnCreate = FormCreate
    TextHeight = 16
    object Label1: TLabel
    Left = 16
      Top = 19
      Width = 58
      Height = 16
      Alignment = taRightJustify
      Caption = 'Сфер:'
  end
  object Label2: TLabel
    Left = 41
      Top = 59
      Width = 33
      Height = 16
      Alignment = taRightJustify
      Caption = 'Размер:'
  end
  object Label3: TLabel
    Left = 29
      Top = 99
      Width = 45
      Height = 16
      Alignment = taRightJustify
      Caption = 'Скорость:'
  end
  object spnSpheres: TSpinEdit
    Left = 84
      Top = 15
      Width = 53
      Height = 26
      MaxValue = 500
      MinValue = 1
      TabOrder = 0
      Value = 50
  end
  object spnSize: TSpinEdit
    Left = 84
      Top = 55
      Width = 53
      Height = 26
      MaxValue = 250
      MinValue = 50
      TabOrder = 1
      Value = 100
  end
  object spnSpeed: TSpinEdit
    Left = 84
      Top = 95
      Width = 53
      Height = 26
      MaxValue = 10
      MinValue = 1
      TabOrder = 2
      Value = 10
  end
  object btnOK: TBitBtn
    Left = 153
      Top = 11
      Width = 89
      Height = 34
      TabOrder = 3
      OnClick = btnOKClick
      Kind = bkOK
  end
  object btnCancel: TBitBtn
    Left = 153
      Top = 51
      Width = 89
      Height = 34
      TabOrder = 4
      OnClick = btnCancelClick
      Kind = bkCancel
  end
  object btnTest: TBitBtn
    Left = 153
      Top = 91
      Width = 89
      Height = 34
      Caption = 'Тест...'
      TabOrder = 5
      OnClick = btnTestClick
      Kind = bkIgnore
  end
end
</pre>

<pre>
// Cfg.pas
 
unit Cfg;
 
interface
 
uses
 
  SysUtils, WinTypes, WinProcs, Messages, Classes, Graphics, Controls,
  Forms, Dialogs, StdCtrls, Buttons, Spin;
 
type
 
  TCfgFrm = class(TForm)
    Label1: TLabel;
    Label2: TLabel;
    Label3: TLabel;
    spnSpheres: TSpinEdit;
    spnSize: TSpinEdit;
    spnSpeed: TSpinEdit;
    btnOK: TBitBtn;
    btnCancel: TBitBtn;
    btnTest: TBitBtn;
    procedure FormCreate(Sender: TObject);
    procedure btnOKClick(Sender: TObject);
    procedure btnCancelClick(Sender: TObject);
    procedure btnTestClick(Sender: TObject);
  private
    { Private declarations }
    procedure LoadConfig;
    procedure SaveConfig;
  public
    { Public declarations }
  end;
 
var
 
  CfgFrm: TCfgFrm;
 
implementation
 
{$R *.DFM}
 
uses
 
  Scrn,
  IniFiles;
 
const
 
  CfgFile = 'SPHERES.INI';
 
procedure TCfgFrm.LoadConfig;
var
 
  inifile: TIniFile;
begin
 
  inifile := TIniFile.Create(CfgFile);
  try
    with inifile do
    begin
      spnSpheres.Value := ReadInteger('Config', 'Spheres', 50);
      spnSize.Value := ReadInteger('Config', 'Size', 100);
      spnSpeed.Value := ReadInteger('Config', 'Speed', 10);
    end;
  finally
    inifile.Free;
  end;
end; {TCfgFrm.LoadConfig}
 
procedure TCfgFrm.SaveConfig;
var
 
  inifile: TIniFile;
begin
 
  inifile := TIniFile.Create(CfgFile);
  try
    with inifile do
    begin
      WriteInteger('Config', 'Spheres', spnSpheres.Value);
      WriteInteger('Config', 'Size', spnSize.Value);
      WriteInteger('Config', 'Speed', spnSpeed.Value);
    end;
  finally
    inifile.Free;
  end;
end; {TCfgFrm.SaveConfig}
 
procedure TCfgFrm.FormCreate(Sender: TObject);
begin
 
  LoadConfig;
end; {TCfgFrm.FormCreate}
 
procedure TCfgFrm.btnOKClick(Sender: TObject);
begin
 
  SaveConfig;
  Close;
end; {TCfgFrm.btnOKClick}
 
procedure TCfgFrm.btnCancelClick(Sender: TObject);
begin
 
  Close;
end; {TCfgFrm.btnCancelClick}
 
procedure TCfgFrm.btnTestClick(Sender: TObject);
begin
 
  ScrnFrm.Show;
end; {TCfgFrm.btnTestClick}
 
end.
 
// SCRN.dfm
 
object ScrnFrm: TScrnFrm
  Left = 196
    Top = 98
    BorderIcons = []
    BorderStyle = bsNone
    Caption = 'ScrnFrm'
    ClientHeight = 101
    ClientWidth = 259
    Color = clBlack
    Font.Charset = DEFAULT_CHARSET
    Font.Color = clWindowText
    Font.Height = -13
    Font.Name = 'System'
    Font.Style = []
    FormStyle = fsStayOnTop
    OldCreateOrder = True
    OnActivate = FormActivate
    OnHide = FormHide
    OnShow = FormShow
    PixelsPerInch = 96
    TextHeight = 16
    object tmrTick: TTimer
    Enabled = False
      OnTimer = tmrTickTimer
      Left = 65535
      Top = 2
  end
end
 
// SCRN.pas
 
unit Scrn;
 
interface
 
uses
 
  SysUtils, WinTypes, WinProcs, Messages, Classes, Graphics, Controls,
  Forms, Dialogs, ExtCtrls;
 
type
 
  TScrnFrm = class(TForm)
    tmrTick: TTimer;
    procedure tmrTickTimer(Sender: TObject);
    procedure FormShow(Sender: TObject);
    procedure FormHide(Sender: TObject);
    procedure FormActivate(Sender: TObject);
  private
    { Private declarations }
    procedure DrawSphere(x, y, size: integer; color: TColor);
    procedure DeactivateScrnSaver(var Msg: TMsg; var Handled: boolean);
  public
    { Public declarations }
  end;
 
var
 
  ScrnFrm: TScrnFrm;
 
implementation
 
{$R *.DFM}
 
uses
 
  Cfg;
 
var
 
  crs: TPoint; {Оригинальная позиция курсора мыши.}
 
function Min(a, b: integer): integer;
begin
 
  if b &lt; a then
    Result := b
  else
    Result := a;
end; {Min}
 
procedure TScrnFrm.DrawSphere(x, y, size: integer; color: TColor);
var
 
  i, dw: integer;
  cx, cy: integer;
  xy1, xy2: integer;
  r, g, b: byte;
begin
 
  with Canvas do
  begin
    {Заполняем установки карандаша и кисти.}
    Pen.Style := psClear;
    Brush.Style := bsSolid;
    Brush.Color := color;
    {Подготовим цвета для сфер.}
    r := GetRValue(color);
    g := GetGValue(color);
    b := GetBValue(color);
    {Рисуем сферу.}
    dw := size div 16;
    for i := 0 to 15 do
    begin
      xy1 := (i * dw) div 2;
      xy2 := size - xy1;
      Brush.Color := RGB(Min(r + (i * 8), 255), Min(g + (i * 8), 255),
        Min(b + (i * 8), 255));
      Ellipse(x + xy1, y + xy1, x + xy2, y + xy2);
    end;
  end;
end; {TScrnFrm.DrawSphere}
 
procedure TScrnFrm.DeactivateScrnSaver(var Msg: TMsg; var Handled: boolean);
var
 
  done: boolean;
begin
 
  if Msg.message = WM_MOUSEMOVE then
    done := (Abs(LOWORD(Msg.lParam) - crs.x) &gt; 5) or
      (Abs(HIWORD(Msg.lParam) - crs.y) &gt; 5)
  else
    done := (Msg.message = WM_KEYDOWN) or (Msg.message = WM_KEYUP) or
      (Msg.message = WM_SYSKEYDOWN) or (Msg.message = WM_SYSKEYUP) or
      (Msg.message = WM_ACTIVATE) or (Msg.message = WM_NCACTIVATE) or
      (Msg.message = WM_ACTIVATEAPP) or (Msg.message = WM_LBUTTONDOWN) or
      (Msg.message = WM_RBUTTONDOWN) or (Msg.message = WM_MBUTTONDOWN);
  if done then
    Close;
end; {TScrnFrm.DeactivateScrnSaver}
 
procedure TScrnFrm.tmrTickTimer(Sender: TObject);
const
 
  sphcount: integer = 0;
var
 
  x, y: integer;
  size: integer;
  r, g, b: byte;
  color: TColor;
begin
 
  if sphcount &gt; CfgFrm.spnSpheres.Value then
  begin
    Refresh;
    sphcount := 0;
  end;
  Inc(sphcount);
  x := Random(ClientWidth);
  y := Random(ClientHeight);
  size := CfgFrm.spnSize.Value + Random(50) - 25;
  x := x - size div 2;
  y := y - size div 2;
  r := Random($80);
  g := Random($80);
  b := Random($80);
  DrawSphere(x, y, size, RGB(r, g, b));
end; {TScrnFrm.tmrTickTimer}
 
procedure TScrnFrm.FormShow(Sender: TObject);
begin
 
  GetCursorPos(crs);
  tmrTick.Interval := 1000 - CfgFrm.spnSpeed.Value * 90;
  tmrTick.Enabled := true;
  Application.OnMessage := DeactivateScrnSaver;
  ShowCursor(false);
end; {TScrnFrm.FormShow}
 
procedure TScrnFrm.FormHide(Sender: TObject);
begin
 
  Application.OnMessage := nil;
  tmrTick.Enabled := false;
  ShowCursor(true);
end; {TScrnFrm.FormHide}
 
procedure TScrnFrm.FormActivate(Sender: TObject);
begin
 
  WindowState := wsMaximized;
end; {TScrnFrm.FormActivate}
 
end.
</pre>

<pre>
 
// Spheres.dpr
 
program Spheres;
 
uses
 
  Forms, SysUtils,
  Scrn in 'SCRN.PAS' {ScrnFrm},
  Cfg in 'CFG.PAS' {CfgFrm};
 
{$R *.RES}
{$D SCRNSAVE Spheres Screen Saver}
 
begin
 
  {Возможен запуск только одной копии.}
  if hPrevInst = 0 then
  begin
    if (ParamCount &gt; 0) and (UpperCase(ParamStr(1)) = '/S') then
    begin
      {ScrnFrm должна быть главной формой.}
      Application.CreateForm(TScrnFrm, ScrnFrm);
      Application.CreateForm(TCfgFrm, CfgFrm);
    end
    else
    begin
      {CfgFrm должна быть главной формой.}
      Application.CreateForm(TCfgFrm, CfgFrm);
      Application.CreateForm(TScrnFrm, ScrnFrm);
    end;
    Application.Run;
  end;
end.
</pre>

<pre>
 
// Spheres.opt
 
[Compiler]
A = 1
B = 0
D = 1
F = 0
I = 1
K = 1
L = 1
P = 1
Q = 0
R = 0
S = 1
T = 0
U = 1
V = 1
W = 0
X = 1
Y = 1
 
[Linker]
MapFile = 0
LinkBuffer = 0
DebugInfo = 0
OptimizeExe = 1
StackSize = 16384
HeapSize = 8192
 
[Directories]
OutputDir =
SearchPath =
Conditionals =
 
[Parameters]
RunParams = / s
</pre>

<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
