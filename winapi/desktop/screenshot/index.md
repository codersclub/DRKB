---
Title: Снимок рабочего стола
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Снимок рабочего стола
=====================

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



