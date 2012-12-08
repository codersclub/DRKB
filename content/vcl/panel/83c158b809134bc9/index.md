---
Title: Плавающая панель
Date: 01.01.2007
---


Плавающая панель
================

::: {.date}
01.01.2007
:::

Кто-нибудь пробовал создать форму, подобную \"отстегивающимся\"
панелькам (FreeDoc)? Я попробовал и вот что получилось\...

Код требует использования некоторых функций WinAPI. Описание всех WinAPI
функций доступны при нажатии F1 (электронная справка)\...

Ну а теперь попробуем это создать (весь код занимает около 100
строчек)\...

Ход работы:

Стартуйте новый проект, задайте свойству borderstyle формы значение
bsNone, добавьте панель, установите у нее свойство borderstyle равным
значению bsSingle, добавьте другую панель с любым заголовком, добавьте
кнопку с подсказкой \'переключатель панели заголовка\', вырежьте из
данного совера код и вставьте его в модуль, создайте обработчики трех
событий панелей (MouseDown, MouseMove, MouseUp) и один обработчик кнопки
(Click). Надеюсь, что ничего не забыл\... ;-) Быстрее сделать это в
Delphi, чем написать здесь\... ;-)

    unit Unit1;
     
    interface
     
    uses
      SysUtils, WinTypes, WinProcs, Messages, Classes, Graphics, Controls,
      Forms, Dialogs, ExtCtrls, StdCtrls;
     
    type
      TForm1 = class(TForm)
        Panel1: TPanel;
        Panel2: TPanel;
        Button1: TButton;
        procedure Panel1MouseDown(Sender: TObject; Button: TMouseButton;
          Shift: TShiftState; X, Y: Integer);
        procedure Panel1MouseMove(Sender: TObject; Shift: TShiftState; X,
          Y: Integer);
        procedure Panel1MouseUp(Sender: TObject; Button: TMouseButton;
          Shift: TShiftState; X, Y: Integer);
        procedure Button1Click(Sender: TObject);
      private
        { Private declarations }
        OldX,
          OldY,
          OldLeft,
          OldTop: Integer;
        ScreenDC: HDC;
        MoveRect: TRect;
        Moving: Boolean;
      public
        { Public declarations }
      end;
     
    var
     
      Form1: TForm1;
     
    implementation
     
    {$R *.DFM}
     
    procedure TForm1.Panel1MouseDown(Sender: TObject; Button: TMouseButton;
     
      Shift: TShiftState; X, Y: Integer);
    begin
     
      if Button = mbLeft then
      begin
        SetCapture(Panel1.Handle);
        ScreenDC := GetDC(0);
        OldX := X;
        OldY := Y;
        OldLeft := X;
        OldTop := Y;
        MoveRect := BoundsRect;
        DrawFocusRect(ScreenDC, MoveRect);
        Moving := True;
      end;
    end;
     
    procedure TForm1.Panel1MouseMove(Sender: TObject; Shift: TShiftState; X,
     
      Y: Integer);
    begin
     
      if Moving then
      begin
        DrawFocusRect(ScreenDC, MoveRect);
        OldX := X;
        OldY := Y;
        MoveRect := Rect(Left + OldX - OldLeft, Top + OldY - OldTop,
          Left + Width + OldX - OldLeft, Top + Height + OldY - OldTop);
        DrawFocusRect(ScreenDC, MoveRect);
      end;
    end;
     
    procedure TForm1.Panel1MouseUp(Sender: TObject; Button: TMouseButton;
     
      Shift: TShiftState; X, Y: Integer);
    begin
     
      if Button = mbLeft then
      begin
        ReleaseCapture;
        DrawFocusRect(ScreenDC, MoveRect);
        Left := Left + X - OldLeft;
        Top := Top + Y - OldTop;
        ReleaseDC(0, ScreenDC);
        Moving := False;
      end;
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    var
     
      TitleHeight,
        BorderWidth,
        BorderHeight: Integer;
    begin
     
      TitleHeight := GetSystemMetrics(SM_CYCAPTION);
      BorderWidth := GetSystemMetrics(SM_CXBORDER) + GetSystemMetrics(SM_CXFRAME) -
        1;
      BorderHeight := GetSystemMetrics(SM_CYBORDER) + GetSystemMetrics(SM_CYFRAME) -
        2;
      if BorderStyle = bsNone then
      begin
        BorderStyle := bsSizeable;
        Top := Top - TitleHeight - BorderHeight;
        Height := Height + TitleHeight + 2 * BorderHeight;
        Left := Left - BorderWidth;
        Width := Width + 2 * BorderWidth;
      end
      else
      begin
        BorderStyle := bsNone;
        Top := Top + TitleHeight + BorderHeight;
        Height := Height - TitleHeight - 2 * BorderHeight;
        Left := Left + BorderWidth;
        Width := Width - 2 * BorderWidth;
      end;
    end;
     
    end.

Коментарии

У меня есть один коментарий отностительно вышеприведенного кода: данная
реализация сложней, чем она должна была быть. Все, что вы должны сделать
- это обработать системное сообщение wm\_NCHitTest. Я приведу здесь код,
который я создал для Borland Tech Info, и который выполняет ту же
функцию:

    unit Dragmain;
     
    interface
     
    uses
      SysUtils, WinTypes, WinProcs, Messages, Classes, Graphics, Controls,
      Forms, Dialogs, StdCtrls;
     
    type
      TForm1 = class(TForm)
        Button1: TButton;
        procedure Button1Click(Sender: TObject);
      private
        procedure WMNCHitTest(var M: TWMNCHitTest); message wm_NCHitTest;
      end;
     
    var
     
      Form1: TForm1;
     
    implementation
     
    {$R *.DFM}
     
    procedure TForm1.WMNCHitTest(var M: TWMNCHitTest);
    begin
     
      inherited; { вызвали наследованный дескриптор сообщения, }
      if M.Result = htClient then { кликнув в области окна?                     }
        M.Result := htCaption; { если так, то мы заставили Windows думать,   }
      { что это область заголовка.                  }
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      Close;
    end;
     
    end.
     
     

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

 

------------------------------------------------------------------------

Так называемая \"плавающая панель\" используется обычно для панелей
инструментов.

Текст в модуле с основной формой:

    procedure TForm1.FormShow(Sender: TObject);
    begin
      Form2.Show;
    end;

Текст в модуле с \"плавающей\" панелью:

    private
      procedure CreateParams(var Params: TCreateParams); override;
      ...
      procedure TForm2.CreateParams(var Params: TCreateParams);
     
    begin
      inherited;
      with Params do
      begin
        Style := Style or WS_OVERLAPPED;
        WndParent := Form1.Handle;
      end;
    end;

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
