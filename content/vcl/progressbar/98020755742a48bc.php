<h1>TProgressBar с невидимой рамкой</h1>
<div class="date">01.01.2007</div>

Автор: VS </p>
<p>Заказчик моего проекта обратился с просьбой - "Сделать прогресс индикатор как в приложениях Нортона. Чтоб был в статус строке и НИКАКИХ рамок". ProgressBar в StatusBar - нет проблем, но как быть с рамкой от ProgressBar? ProgressBar всегда вычерчивает рамку и не имеет методов ее управления. Однако появилась интересная идея, воплотившаяся в компонент с новым свойством ShowFrame. Решение оказалось на удивление простым. На рисунке сравнение стандартного ProgressBar и ProgressBar с невидимой рамкой.</p>
<pre>
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
  if FShowFrame &lt;&gt; Value then
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
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
