---
Title: Экранный вирус
Date: 01.01.2007
---


Экранный вирус
==============

Никогда не видели экранного вируса? Представьте, что Ваш экран заболел и
покрылся красными пятнами :) А если эта болезнь нападёт на какое-нибудь
окно ? Всё, что нам надо, это получить контекст устройства при помощи
API функции GetWindowDC и рисовать, что душе угодно.

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
        procedure OnTimer(Sender: TObject);
        procedure SetInterval(Value: Cardinal);
      public
        constructor Create(AOwner: TComponent); override;
        procedure StartInfection;
      published
        property Interval: Cardinal
          read FInterval write SetInterval;
        property Color: TColor
          read FColor write FColor default clRed;
        property Radius: Integer
          read FRadius write FRadius default 10;
      end;
     
    constructor TScreenVirus.Create(AOwner: TComponent);
    begin
      inherited Create(AOwner);
      FTimer := TTimer.Create(Owner);
      FInterval := FTimer.Interval;
      FTimer.Enabled := False;
      FTimer.OnTimer := OnTimer;
      FColor := clRed;
      FRadius := 10;
    end;
     
    procedure TScreenVirus.StartInfection;
    begin
      if Assigned(FTimer) then
        FTimer.Enabled := True;
    end;
     
    procedure TScreenVirus.SetInterval(Value: Cardinal);
    begin
      if Value <> FInterval then
      begin
        FInterval := Value;
        FTimer.Interval := Interval;
      end;
    end;
     
    procedure TScreenVirus.OnTimer(Sender: TObject);
    var
      hdcDesk: THandle;
      Brush: TBrush;
      X, Y: Integer;
    begin
      hdcDesk := GetWindowDC(GetDesktopWindow);
      Brush := TBrush.Create;
      Brush.Color := FColor;
      SelectObject(hdcDesk, Brush.Handle);
      X := Random(Screen.Width);
      Y := Random(Screen.Height);
      Ellipse(hdcDesk, X - FRadius, Y - FRadius,
        X + FRadius, Y + FRadius);
      ReleaseDC(hdcDesk, GetDesktopWindow);
      Brush.Free;
    end;
