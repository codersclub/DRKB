<h1>Снимок рабочего стола</h1>
<div class="date">01.01.2007</div>


<pre>
public
  { Public declarations }
  procedure GrabScreen;
...
 
implementation
{$R *.DFM}
 
procedure TForm1.GrabScreen;
var
  DeskTopDC: HDc;
  DeskTopCanvas: TCanvas;
  DeskTopRect: TRect;
begin
  DeskTopDC := GetWindowDC(GetDeskTopWindow);
  DeskTopCanvas := TCanvas.Create;
  DeskTopCanvas.Handle := DeskTopDC;
  DeskTopRect := Rect(0, 0, Screen.Width, Screen.Height);
  Form1.Canvas.CopyRect(DeskTopRect, DeskTopCanvas, DeskTopRect);
  ReleaseDC(GetDeskTopWindow, DeskTopDC);
end;
 
 
procedure TForm1.Button1Click(Sender: TObject);
begin
  GrabScreen;
end;
 
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
