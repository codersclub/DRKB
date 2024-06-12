---
Title: Забавное программирование в Delphi
Date: 01.01.2007
Source: <https://delphid.dax.ru>
---


Забавное программирование в Delphi
==================================

Приведённый здесь материал можно озаглавить не иначе как "Чем заняться
программисту, если нечего делать". На самом деле,
Delphi настолько интересная среда, что в ней наряду
с разработкой серьёзных приложений
можно легко увлечься созданием абсолютно бесполезных вещей.

Итак, поехали...

**Автоматически нажимающаяся кнопка**

Этот компонент представляет из себя кнопку, на которую не надо нажимать,
чтобы получить событие OnClick. Достаточно переместить курсор мышки на
кнопку. При создании такого компонента традиционным способом, требуется
довольно много времени, так как необходимо обрабатывать мышку,
перехватывать её и т.д. Однако результат стоит того!

Предлагаю взглянуть на две версии данного компонента.
В более простой версии обработчик перемещения мышки просто перехватывает
сообщения Windows с нужным кодом и вызывает обработчик события OnClick:

    type
    TAutoButton1 = class(TButton)
    private
    procedure WmMouseMove (var Msg: TMessage);
    message wm_MouseMove;
    end;
     
    procedure TAutoButton1.WmMouseMove (var Msg: TMessage);
    begin
    inherited;
    if Assigned (OnClick) then
    OnClick (self);
    end;


Вторая версии имеет больше исходного кода,
так как в ней я просто пытаюсь повторить событие
мышки OnClick когда пользователь перемещает мышку над кнопкой либо по
истечении определённого времени. Далее следует объявление класса:

    type
    TAutoKind = (akTime, akMovement, akBoth);
     
    TAutoButton2 = class(TButton)
    private
    FAutoKind: TAutoKind;
    FMovements: Integer;
    FSeconds: Integer;
    // really private
    CurrMov: Integer;
    Capture: Boolean;
    MyTimer: TTimer;
    procedure EndCapture;
    // обработчики сообщений
    procedure WmMouseMove (var Msg: TWMMouse);
    message wm_MouseMove;
    procedure TimerProc (Sender: TObject);
    procedure WmLBUttonDown (var Msg: TMessage);
    message wm_LBUttonDown;
    procedure WmLButtonUp (var Msg: TMessage);
    message wm_LButtonUp;
    public
    constructor Create (AOwner: TComponent); override;
    published
    property AutoKind: TAutoKind
    read FAutoKind write FAutoKind default akTime;
    property Movements: Integer
    read FMovements write FMovements default 5;
    property Seconds: Integer
    read FSeconds write FSeconds default 10;
    end;


Итак, когда курсор мышки попадает в область кнопки (WmMouseMove), то
компонент запускает таймер либо счётчик количества сообщений о перемещении.
По истечении определённого времени либо при получении нужного количества
сообщений о перемещении,
компонент эмулирует событие нажатия кнопкой.


    procedure TAutoButton2.WmMouseMove (var Msg: TWMMouse);
    begin
    inherited;
    if not Capture then
    begin
    SetCapture (Handle);
    Capture := True;
    CurrMov := 0;
    if FAutoKind <> akMovement then
    begin
    MyTimer := TTimer.Create (Parent);
    if FSeconds <> 0 then
    MyTimer.Interval := 3000
    else
    MyTimer.Interval := FSeconds * 1000;
    MyTimer.OnTimer := TimerProc;
    MyTimer.Enabled := True;
    end;
    end
    else // захватываем
    begin
    if (Msg.XPos > 0) and (Msg.XPos < Width)
    and (Msg.YPos > 0) and (Msg.YPos < Height) then
    begin
    // если мы подсчитываем кол-во движений...
    if FAutoKind <> akTime then
    begin
    Inc (CurrMov);
    if CurrMov >= FMovements then
    begin
    if Assigned (OnClick) then
    OnClick (self);
    EndCapture;
    end;
    end;
    end
    else // за пределами... стоп!
    EndCapture;
    end;
    end;
     
    procedure TAutoButton2.EndCapture;
    begin
    Capture := False;
    ReleaseCapture;
    if Assigned (MyTimer) then
    begin
    MyTimer.Enabled := False;
    MyTimer.Free;
    MyTimer := nil;
    end;
    end;
     
    procedure TAutoButton2.TimerProc (Sender: TObject);
    begin
    if Assigned (OnClick) then
    OnClick (self);
    EndCapture;
    end;
     
    procedure TAutoButton2.WmLBUttonDown (var Msg: TMessage);
    begin
    if not Capture then
    inherited;
    end;
     
    procedure TAutoButton2.WmLButtonUp (var Msg: TMessage);
    begin
    if not Capture then
    inherited;
    end;


Как осуществить ввод текста в компоненте Label ?
Многие программисты задавая такой вопрос получают на него стандартный
ответ "используй edit box."
На самом же деле этот вопрос вполне решаем, хотя лейблы и не основаны на
окне и,
соответственно не могут получать фокус ввода и, соответственно не могут
получать символы,
вводимые с клавиатуры. Давайте рассмотрим шаги, которые были предприняты
мной для разработки данного компонента.

Первый шаг, это кнопка, которая может отображать вводимый текст:

    type
    TInputButton = class(TButton)
    private
    procedure WmChar (var Msg: TWMChar);
    message wm_Char;
    end;
     
    procedure TInputButton.WmChar (var Msg: TWMChar);
    var
    Temp: String;
    begin
    if Char (Msg.CharCode) = #8 then
    begin
    Temp := Caption;
    Delete (Temp, Length (Temp), 1);
    Caption := Temp;
    end
    else
    Caption := Caption + Char (Msg.CharCode);
    end;

С меткой (label) дела обстоят немного сложнее, так как прийдётся создать
некоторые ухищрения,
чтобы обойти её внутреннюю структуру. В принципе, проблему можно решить
созданием других
скрытых компонент (кстати, тот же edit box). Итак, посмотрим на
объявление класса:

    type
    TInputLabel = class (TLabel)
    private
    MyEdit: TEdit;
    procedure WMLButtonDown (var Msg: TMessage);
    message wm_LButtonDown;
    protected
    procedure EditChange (Sender: TObject);
    procedure EditExit (Sender: TObject);
    public
    constructor Create (AOwner: TComponent); override;
    end;


Когда метка (label) создана, то она в свою очередь создаёт edit box и
устанавливает несколько обработчиков событий для него. Фактически, если
пользователь кликает по метке, то фокус перемещается на (невидимый) edit
box, и мы используем его события для обновления метки. Обратите внимание
на ту часть кода, которая подражает фокусу для метки (рисует
прямоугольничек), основанная на API функции DrawFocusRect:

    constructor TInputLabel.Create (AOwner: TComponent);
    begin
    inherited Create (AOwner);
     
    MyEdit := TEdit.Create (AOwner);
    MyEdit.Parent := AOwner as TForm;
    MyEdit.Width := 0;
    MyEdit.Height := 0;
    MyEdit.TabStop := False;
    MyEdit.OnChange := EditChange;
    MyEdit.OnExit := EditExit;
    end;
     
    procedure TInputLabel.WMLButtonDown (var Msg: TMessage);
    begin
    MyEdit.SetFocus;
    MyEdit.Text := Caption;
    (Owner as TForm).Canvas.DrawFocusRect (BoundsRect);
    end;
     
    procedure TInputLabel.EditChange (Sender: TObject);
    begin
    Caption := MyEdit.Text;
    Invalidate;
    Update;
    (Owner as TForm).Canvas.DrawFocusRect (BoundsRect);
    end;
     
    procedure TInputLabel.EditExit (Sender: TObject);
    begin
    (Owner as TForm).Invalidate;
    end;


**Кнопка со звуком**

Когда Вы нажимаете на кнопку, то видите трёхмерный эффект нажатия.
А как же насчёт четвёртого измерения, например звука ?
Ну тогда нам понадобится звук для нажатия и звук для отпускания кнопки.
Если есть желание, то можно добавить даже речевую подсказку, однако не
будем сильно углубляться.

Компонент звуковой кнопки имеет два новых свойства:


    type
    TDdhSoundButton = class(TButton)
    private
    FSoundUp, FSoundDown: string;
    protected
    procedure MouseDown(Button: TMouseButton;
    Shift: TShiftState; X, Y: Integer); override;
    procedure MouseUp(Button: TMouseButton;
    Shift: TShiftState; X, Y: Integer); override;
    published
    property SoundUp: string
    read FSoundUp write FSoundUp;
    property SoundDown: string
    read FSoundDown write FSoundDown;
    end;


Звуки будут проигрываться при нажатии и отпускании кнопки:

    procedure TDdhSoundButton.MouseDown(
    Button: TMouseButton;
    Shift: TShiftState; X, Y: Integer);
    begin
    inherited;
    PlaySound (PChar (FSoundDown), 0, snd_Async);
    end;
     
    procedure TDdhSoundButton.MouseUp(Button: TMouseButton;
    Shift: TShiftState; X, Y: Integer);
    begin
    inherited;
    PlaySound (PChar (FSoundUp), 0, snd_Async);
    end;


**Экранный вирус**

Никогда не видели экранного вируса?
Представьте, что Ваш экран заболел и покрылся красными пятнами :)
А если эта болезнь нападёт на какое-нибудь окно ?
Всё, что нам надо, это получить контекст устройства при помощи API
функции GetWindowDC и
рисовать, что душе угодно.

К исходному коду особых комментариев не требуется, скажу лишь только то,
что основная часть кода находится в обработчике события OnTimer:

    type
    TScreenVirus = class(TComponent)
    private
    FTimer: TTimer;
    FInterval: Cardinal;
    FColor: TColor;
    FRadius: Integer;
    protected
    procedure OnTimer (Sender: TObject);
    procedure SetInterval (Value: Cardinal);
    public
    constructor Create (AOwner: TComponent); override;
    procedure StartInfection;
    published
    property Interval: Cardinal
    read FInterval write SetInterval;
    property Color: TColor
    read FColor write FColor default clRed;
    property Radius: Integer
    read FRadius write FRadius default 10;
    end;
     
    constructor TScreenVirus.Create (AOwner: TComponent);
    begin
    inherited Create (AOwner);
    FTimer := TTimer.Create (Owner);
    FInterval := FTimer.Interval;
    FTimer.Enabled := False;
    FTimer.OnTimer := OnTimer;
    FColor := clRed;
    FRadius := 10;
    end;
     
    procedure TScreenVirus.StartInfection;
    begin
    if Assigned (FTimer) then
    FTimer.Enabled := True;
    end;
     
    procedure TScreenVirus.SetInterval (Value: Cardinal);
    begin
    if Value <> FInterval then
    begin
    FInterval := Value;
    FTimer.Interval := Interval;
    end;
    end;
     
    procedure TScreenVirus.OnTimer (Sender: TObject);
    var
    hdcDesk: THandle;
    Brush: TBrush;
    X, Y: Integer;
    begin
    hdcDesk := GetWindowDC (GetDesktopWindow);
    Brush := TBrush.Create;
    Brush.Color := FColor;
    SelectObject (hdcDesk, Brush.Handle);
    X := Random (Screen.Width);
    Y := Random (Screen.Height);
    Ellipse (hdcDesk, X - FRadius, Y - FRadius,
    X + FRadius, Y + FRadius);
    ReleaseDC (hdcDesk, GetDesktopWindow);
    Brush.Free;
    end;



**Шутки над пользователем**

Некоторых пользователей врят ли можно будет испугать экранным вирусом,
однако можно воспользоваться другими способами запугивания, например:
прозрачные окошки,
недоступные пункты меню с большим количеством подуровней, а так же
сообщения об ошибках,
которые нельзя убрать.

В приведённом ниже примере при помощи обычного диалогового окна
пользователю показывается сообщение об ошибке, причём кнопка "close"
накак не хочет нажиматься.
У этого диалога есть зависимое окно, которое показывается, при нажатии
кнопки "details".

Поддельная форма с сообщением об ошибке имеет кнопку "details",
которая открывает вторую
часть формы. Это достигается путём добавления компонента за пределы
самой формы:


    object Form2: TForm2
    AutoScroll = False
    Caption = 'Error'
    ClientHeight = 93
    ClientWidth = 320
    OnShow = FormShow
    object Label1: TLabel
    Left = 56
    Top = 16
    Width = 172
    Height = 65
    AutoSize = False
    Caption = 
    'Программа выполнила недопустимую ' +
    'операцию. Если проблема повторится, ' +
    'то обратитесь к разработчику программного обеспечения.'
    WordWrap = True
    end
    object Image1: TImage
    Left = 8
    Top = 16
    Width = 41
    Height = 41
    Picture.Data = {...}
    end
    object Button1: TButton
    Left = 240
    Top = 16
    Width = 75
    Height = 25
    Caption = 'Close'
    TabOrder = 0
    OnClick = Button1Click
    end
    object Button2: TButton
    Left = 240
    Top = 56
    Width = 75
    Height = 25
    Caption = 'Details >>'
    TabOrder = 1
    OnClick = Button2Click
    end
    object Memo1: TMemo // за пределами формы!
    Left = 24
    Top = 104
    Width = 265
    Height = 89
    Color = clBtnFace
    Lines.Strings = (
    'AX:BX 73A5:495B'
    'SX:PK 676F:FFFF'
    'OH:OH 7645:2347'
    'Crash 3485:9874'
    ''
    'What'#39's going on here?')
    TabOrder = 2
    end
    end


Когда пользователь нажимает кнопку "details", то программа просто
изменяет размер формы:

    procedure TForm2.Button2Click(Sender: TObject);
    begin
    Height := 231;
    end;


Вторая форма, которая наследуется от первой имеет перемещающуюся кнопку
"close":

    procedure TForm3.Button1Click(Sender: TObject);
    begin
    Button1.Left := Random (ClientWidth - Button1.Width);
    Button1.Top := Random (ClientHeight - Button1.Height);
    end;


В заключение, можно сделать дырку в окне, используя API функцию
SetWindowRgn:

    procedure TForm1.Button4Click(Sender: TObject);
    var
    HRegion1, Hreg2, Hreg3: THandle;
    Col: TColor;
    begin
    ShowMessage ('Ready for a real crash?');
    Col := Color;
    Color := clRed;
    PlaySound ('boom.wav', 0, snd_sync);
    HRegion1 := CreatePolygonRgn (Pts,
    sizeof (Pts) div 8,
    alternate);
    SetWindowRgn (
    Handle, HRegion1, True);
    ShowMessage ('Now, what have you done?');
    Color := Col;
    ShowMessage ('Вам лучше купить новый монитор');
    end;

