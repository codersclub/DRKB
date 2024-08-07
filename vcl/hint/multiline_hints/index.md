---
Title: Многострочные подсказки
Date: 01.01.2007
---


Многострочные подсказки
=======================

Вариант 1:

Author: Даниил Карапетян (delphi4all@narod.ru)

Если подсказка длинная, то удобно ее разместить в две или более строк.

    procedure TForm1.FormCreate(Sender: TObject);
    begin
      Button1.Hint := 'Only one string';
      Button2.Hint := 'There will be' + #13#10 + 'two strings';
      Form1.ShowHint := true;
    end;

Автор справки: Алексей Денисов (aleksey@sch103.krasnoyarsk.su)

------------------------------------------------------------------------

Вариант 2:

Source: Vingrad.ru <https://forum.vingrad.ru>

Необходимо создать соответствующую компоненту которая показывает
"быструю подсказку" (Hints) с более чем одной
строкой. Компонента наследуется от TComponent и называется TMHint.
Hint-текст можно задавать следующим образом:

    "Строка 1@Строка 2@Строка 3".

Символ "@" используется как
разделитель строк. Если Вам нравится другой символ -
измените свойство Separator.

Свойство Active указывает на активность
(TRUE) или неактивность (FALSE) "многострочности"

    unit MHint;
     
    interface
     
    uses
      SysUtils, WinTypes, WinProcs, Messages,
      Classes, Graphics, Controls, Forms, Dialogs;
     
    type
      TMHint = class(TComponent)
      private
        ScreenSize: Integer;
        FActive: Boolean;
        FSeparator: Char;
        FOnShowHint: TShowHintEvent;
      protected
        procedure SetActive(Value: Boolean);
        procedure SetSeparator(Value: char);
        procedure NewHintInfo(var HintStr: string;
          var CanShow: Boolean;
          var HintInfo: THintInfo);
      public
        constructor Create(AOwner: TComponent); override;
      published
        property Active: Boolean
          read FActive write SetActive;
        property Separator: Char
          read FSeparator write SetSeparator;
      end;
     
    procedure Register;
     
    implementation
     
    constructor TMHint.Create(AOwner: TComponent);
     
    begin
      inherited Create(AOwner);
      FActive := True;
      FSeparator := '@';
      Application.OnShowHint := NewHintInfo;
      ScreenSize := GetSystemMetrics(SM_CYSCREEN);
    end;
     
    procedure TMHint.SetActive(Value: Boolean);
     
    begin
      FActive := Value;
    end;
     
    procedure TMHint.SetSeparator(Value: Char);
     
    begin
      FSeparator := Value;
    end;
     
    procedure TMHint.NewHintInfo(var HintStr: string;
      var CanShow: Boolean;
      var HintInfo: THintInfo);
     
    var
      I: Byte;
     
    begin
      if FActive then
        begin
          I := Pos(FSeparator, HintStr);
          while I > 0 do
            begin
              HintStr[I] := #13;
              I := Pos(FSeparator, HintStr);
            end;
          if HintInfo.HintPos.Y+10 > ScreenSize then
            HintInfo.HintPos.Y := ScreenSize-11;
        end;
    end;
     
    procedure Register;
     
    begin
      RegisterComponents('MyComponents', [TMHint]);
    end;
     
    end.

