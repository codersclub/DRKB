<h1>Панель с изменяющимися размерами</h1>
<div class="date">01.01.2007</div>

<p>Привожу исходный код для создания панелей с изменяющимися размерами. Воровняйте панель по области клиента свойством alClient, расположите на ней несколько элементов управления и посмотрите как меняются размеры во время изменения размера формы при выполнении программы. Можно расширить код и запретить изменения размеров во время проектирования, но это я оставляю для вас. Данная технология может и не идеальна, поскольку я накропал код за считанные минуты, но для выполнения моих задач этого достаточно.</p>
<pre>
unit Elastic;
 
interface
 
uses
  SysUtils, WinTypes, WinProcs, Messages, Classes, Graphics, Controls,
  Forms, Dialogs, ExtCtrls;
 
type
 
  TElasticPanel = class(TPanel)
  private
    FHorz, FVert: boolean;
    nOldWidth, nOldHeight: integer;
    bResized: boolean;
  protected
    procedure WMSize(var message: TWMSize); message WM_SIZE;
  public
    nCount: integer;
    constructor Create(AOwner: TComponent); override;
  published
    property ElasticHorizontal: boolean read FHorz write FHorz default
      TRUE;
 
    property ElasticVertical: boolean read FVert write FVert default
      TRUE;
 
  end;
 
procedure Register;
 
implementation
 
constructor TElasticPanel.Create(AOwner: TComponent);
begin
 
  inherited Create(AOwner);
  FHorz := TRUE;
  FVert := TRUE;
  nOldWidth := Width;
  nOldHeight := Height;
  bResized := FALSE;
end;
 
procedure TElasticPanel.WMSize(var message: TWMSize);
var
 
  bResize: boolean;
  xRatio: real;
  i: integer;
  ctl: TWinControl;
begin
 
  Inc(nCount);
  if Align = alNone then
    bResize := TRUE
  else
    bResize := bResized;
  if not (csDesigning in ComponentState) and bResize then
  begin
    if FHorz then
    begin
      xRatio := Width / nOldWidth;
      for i := 0 to ControlCount - 1 do
      begin
        ctl := TWinControl(Controls[i]);
        ctl.Left := Round(ctl.Left * xRatio);
        ctl.Width := Round(ctl.Width * xRatio);
      end;
    end;
    if FVert then
    begin
      xRatio := Height / nOldHeight;
      for i := 0 to ControlCount - 1 do
      begin
        ctl := TWinControl(Controls[i]);
        ctl.Top := Round(ctl.Top * xRatio);
        ctl.Height := Round(ctl.Height * xRatio);
      end;
    end;
  end
  else
  begin
    nOldWidth := Width;
    nOldHeight := Height;
  end;
  bResized := TRUE;
  nOldWidth := Width;
  nOldHeight := Height;
end;
 
procedure Register;
begin
 
  RegisterComponents('Additional', [TElasticPanel]);
end;
 
end.
 
 
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>

