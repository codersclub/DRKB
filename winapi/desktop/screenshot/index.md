---
Title: Снимок рабочего стола
Date: 01.01.2007
---


Снимок рабочего стола
=====================

::: {.date}
01.01.2007
:::

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
     

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
