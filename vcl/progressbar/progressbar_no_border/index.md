---
Title: TProgressBar с невидимой рамкой
Author: VS
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


TProgressBar с невидимой рамкой
===============================

Заказчик моего проекта обратился с просьбой - "Сделать прогресс
индикатор как в приложениях Нортона. Чтоб был в статус строке и НИКАКИХ
рамок". ProgressBar в StatusBar - нет проблем, но как быть с рамкой от
ProgressBar? ProgressBar всегда вычерчивает рамку и не имеет методов ее
управления. Однако появилась интересная идея, воплотившаяся в компонент
с новым свойством ShowFrame. Решение оказалось на удивление простым. На
рисунке сравнение стандартного ProgressBar и ProgressBar с невидимой
рамкой.

    unit vsprgs;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
        ComCtrls;
     
    type
      TNProgressBar = class(TProgressBar)
        procedure WMNCPAINT(var Msg: TMessage); message WM_NCPAINT;
      private
        FShowFrame: boolean;
        procedure SetShowFrame(Value: boolean);
      protected
      public
        constructor Create(AOwner: TComponent); override;
      published
        property ShowFrame: boolean read FShowFrame write SetShowFrame;
      end;
     
    procedure Register;
     
    implementation
    { TNProgressBar }
     
    constructor TNProgressBar.Create(AOwner: TComponent);
    begin
      inherited;
      FShowFrame := True;
    end;
     
    procedure TNProgressBar.SetShowFrame(Value: boolean);
    begin
      if FShowFrame <> Value then
      begin
        FShowFrame := Value;
        RecreateWnd;
      end;
    end;
     
    procedure TNProgressBar.WMNCPAINT(var Msg: TMessage);
    var
      DC: HDC;
      RC: TRect;
    begin
      if ShowFrame then
      begin
        inherited;
        Invalidate;
      end
      else
      begin
        DC := GetWindowDC(Handle);
        try
          Windows.GetClientRect(Handle, RC);
          with RC do
          begin
            Inc(Right, 2);
            Inc(Bottom, 2);
          end;
          Windows.FillRect(DC, RC, Brush.Handle);
        finally
          ReleaseDC(Handle, DC);
        end;
      end;
    end;
     
    procedure Register;
    begin
      RegisterComponents('Controls', [TNProgressBar]);
    end;
     
    end.

