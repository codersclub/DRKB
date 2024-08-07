---
Title: Видеть подсказки все время, пока поле редактирования имеет фокус
Author: Ed Jordan
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Видеть подсказки все время, пока поле редактирования имеет фокус
================================================================

> На TabbedNotebook у меня есть множество компонентов TEdit. Я изменяю
> цвет компонентов TEdit на желтый и назначаю свойству Hint компонента
> строчку предупреждения, если поле редактирования содержит неверные
> данные.
> 
> Поведение окна со всплывающей подсказкой (hintwindow) позволяет делать
> его видимым только тогда, когда курсор мыши находится в области элемента
> управления. Но мой заказчик хочет видеть подсказки все время, пока поле
> редактирования имеет фокус.
> 
> Я не знаю как изменить поведение всплывающей подсказки, заданное по
> умолчанию. Я знаю что это возможно, но кто мне подскажет как?

Ниже приведен модуль, содержащий новый тип hintwindow, TFocusHintWindow.
Когда вы "просите" TFocusHintWindow появиться, он появляется ниже
элемента управления, имеющего фокус. Для показа и скрытия достаточно
следующих команд:

    FocusHintWindow.Showing := True;
    FocusHintWindow.Showing := False;

Пример того, как это можно использовать, содержится в комментариях к
модулю. Это просто.

    unit FHintWin;
     
    { -----------------------------------------------------------
     
    TFocusHintWindow --
     
    Вот пример того, как можно использовать TFocusHintWindow.
    Данный пример выводит всплывающую подсказку ниже любого
    TEdit, имеющего фокус. В противном случае выводится
    стандартная подсказка Windows.
     
    unit Unit1;
    interface
    uses
      SysUtils, WinTypes, WinProcs, Messages, Classes, Graphics,
      Controls, Forms, Dialogs, StdCtrls, FHintWin;
     
    type
    TForm1 = class(TForm)
      procedure FormCreate(Sender: TObject);
      private
      FocusHintWindow: TFocusHintWindow;
      procedure AppIdle( Sender: TObject; var Done: Boolean );
      procedure AppShowHint( var HintStr: string;
      var CanShow: Boolean; var HintInfo: THintInfo );
    end;
     
    implementation
     
    procedure TForm1.FormCreate( Sender: TObject );
    begin
      Application.OnIdle := AppIdle;
      Application.OnShowHint := AppShowHint;
      FocusHintWindow := TFocusHintWindow.Create( Self );
    end;
     
    procedure TForm1.AppIdle(Sender: TObject; var Done: Boolean);
    begin
      FocusHintWindow.Showing := Screen.ActiveControl is TEdit;
    end;
     
    procedure TForm1.AppShowHint( var HintStr: string;
      var CanShow: Boolean; var HintInfo: THintInfo );
    begin
      CanShow := not FocusHintWindow.Showing;
    end;
     
    end.
    ----------------------------------------------------------- }
     
    interface
     
    uses SysUtils, WinTypes, WinProcs, Classes, Controls, Forms;
     
    type
      TFocusHintWindow = class(THintWindow)
      private
        FShowing: Boolean;
        HintControl: TControl;
      protected
        procedure SetShowing(Value: Boolean);
        function CalcHintRect(Hint: string): TRect;
        procedure Appear;
        procedure Disappear;
      public
        property Showing: Boolean read FShowing write SetShowing;
      end;
     
    implementation
     
    function TFocusHintWindow.CalcHintRect(Hint: string): TRect;
    var
      Buffer: array[Byte] of Char;
    begin
      Result := Bounds(0, 0, Screen.Width, 0);
      DrawText(Canvas.Handle, StrPCopy(Buffer, Hint), -1, Result,
        DT_CALCRECT or DT_LEFT or DT_WORDBREAK or DT_NOPREFIX);
     
      with HintControl, ClientOrigin do
        OffsetRect(Result, X, Y + Height + 6);
      Inc(Result.Right, 6);
      Inc(Result.Bottom, 2);
    end;
     
    procedure TFocusHintWindow.Appear;
    var
      Hint: string;
      HintRect: TRect;
    begin
      if (Screen.ActiveControl = HintControl) then
        Exit;
     
      HintControl := Screen.ActiveControl;
      Hint := GetShortHint(HintControl.Hint);
      HintRect := CalcHintRect(Hint);
      ActivateHint(HintRect, Hint);
      FShowing := True;
    end;
     
    procedure TFocusHintWindow.Disappear;
    begin
      HintControl := nil;
      ShowWindow(Handle, SW_HIDE);
      FShowing := False;
    end;
     
    procedure TFocusHintWindow.SetShowing(Value: Boolean);
    begin
      if Value then
        Appear
      else
        Disappear;
    end;
     
    end.


