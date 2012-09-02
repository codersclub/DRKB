<h1>Как изменить шрифт и выравнивание в заголовке формы?</h1>
<div class="date">01.01.2007</div>


<p>Note: The formDeactivate never gets called so when the form isn't active, sometimes the FormPaint isn't called. If anything causes the form to be repainted while in inactive, it draws correctly.</p>
<pre>
unit Unit1;
 
interface
 
uses
  Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs;
 
type
  TForm1 = class(TForm)
    procedure FormPaint(Sender: TObject);
    procedure FormResize(Sender: TObject);
    procedure FormDeactivate(Sender: TObject);
    procedure FormActivate(Sender: TObject);
  private
  public
    { Public declarations }
  end;
 
var
  Form1: TForm1;
 
implementation
 
{$R *.DFM}
 
procedure TForm1.FormPaint(Sender: TObject);
var
  LabelHeight, LabelWidth, LabelTop: Integer;
  caption_height, border3d_y, button_width, border_thickness: Integer;
  MyCanvas: TCanvas;
  CaptionBarRect: TRect;
begin
  CaptionBarRect := Rect(0, 0, 0, 0);
  MyCanvas := TCanvas.Create;
  MyCanvas.Handle := GetWindowDC(Form1.Handle);
  border3d_y := GetSystemMetrics(SM_CYEDGE);
  button_width := GetSystemMetrics(SM_CXSIZE);
  border_thickness := GetSystemMetrics(SM_CYSIZEFRAME);
  caption_height := GetSystemMetrics(SM_CYCAPTION);
  LabelWidth := Form1.Canvas.TextWidth(Form1.Caption);
  LabelHeight := Form1.Canvas.TextHeight(Form1.Caption);
  LabelTop := LabelHeight - (caption_height div 2);
  CaptionBarRect.Left := border_thickness + border3d_y + button_width;
  CaptionBarRect.Right := Form1.Width - (border_thickness + border3d_y) 
                - (button_width * 4);
  CaptionBarRect.Top := border_thickness + border3d_y;
  CaptionBarRect.Bottom := caption_height;
  if Form1.Active then
    MyCanvas.Brush.Color := clActiveCaption
  else
    MyCanvas.Brush.Color := clInActiveCaption;
  MyCanvas.Brush.Style := bsSolid;
  MyCanvas.FillRect(CaptionBarRect);
  MyCanvas.Brush.Style := bsClear;
  MyCanvas.Font.Color := clCaptionText;
  MyCanvas.Font.Name := 'MS Sans Serif';
  MyCanvas.Font.Style := MyCanvas.Font.Style + [fsBold];
  DrawText(MyCanvas.Handle, PChar(' ' + Form1.Caption), Length(Form1.Caption) + 1,
    CaptionBarRect, DT_CENTER or DT_SINGLELINE or DT_VCENTER);
  MyCanvas.Free;
end;
 
procedure TForm1.FormResize(Sender: TObject);
begin
  Form1.Paint;
end;
 
procedure TForm1.FormDeactivate(Sender: TObject);
begin
  Form1.Paint;
end;
 
procedure TForm1.FormActivate(Sender: TObject);
begin
  Form1.Paint;
end;
 
end.
</pre>

<hr />
<pre>
{ ... }
type
  TForm1 = class(TForm)
  private
    procedure WMNCPaint(var Msg: TWMNCPaint); message WM_NCPAINT;
  public
  end;
 
var
  Form1: TForm1;
 
implementation
 
{$R *.dfm}
 
procedure TForm1.WMNCPaint(var Msg: TWMNCPaint);
var
  ACanvas: TCanvas;
begin
  inherited;
  ACanvas := TCanvas.Create;
  try
    ACanvas.Handle := GetWindowDC(Form1.Handle);
    with ACanvas do
    begin
      Brush.Color := clActiveCaption;
      Font.Name := 'Tahoma';
      Font.Size := 8;
      Font.Color := clred;
      Font.Style := [fsItalic, fsBold];
      TextOut(GetSystemMetrics(SM_CYMENU) + GetSystemMetrics(SM_CXBORDER),
        Round((GetSystemMetrics(SM_CYCAPTION) - Abs(Font.Height)) / 2) + 1,
          ' Some Text');
    end;
  finally
    ReleaseDC(Form1.Handle, ACanvas.Handle);
    ACanvas.Free;
  end;
end;
</pre>

<p>Взято с Delphi Knowledge Base: <a href="https://www.baltsoft.com/" target="_blank">https://www.baltsoft.com/</a></p>
