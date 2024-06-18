---
Title: Как начертить круг?
Date: 01.01.2007
Source: Delphi Knowledge Base: <https://www.baltsoft.com/>
---


Как начертить круг?
===================

    { ... }
     
    implementation
     
    {$R *.DFM}
     
    uses
      Math;
     
    procedure DrawCircle(CenterX, CenterY, Radius: Integer; Canvas: TCanvas; Color:
      TColor);
     
      procedure PlotCircle(x, y, x1, y1: Integer);
      begin
        Canvas.Pixels[x + x1, y + y1] := Color;
        Canvas.Pixels[x - x1, y + y1] := Color;
        Canvas.Pixels[x + x1, y - y1] := Color;
        Canvas.Pixels[x - x1, y - y1] := Color;
        Canvas.Pixels[x + y1, y + x1] := Color;
        Canvas.Pixels[x - y1, y + x1] := Color;
        Canvas.Pixels[x + y1, y - x1] := Color;
        Canvas.Pixels[x - y1, y - x1] := Color;
      end;
     
    var
      x, y, r: Integer;
      x1, y1, p: Integer;
    begin
      x := CenterX;
      y := CenterY;
      r := Radius;
      x1 := 0;
      y1 := r;
      p := 3 - 2 * r;
      while (x1 < y1) do
      begin
        plotcircle(x, y, x1, y1);
        if (p < 0) then
          p := p + 4 * x1 + 6
        else
        begin
          p := p + 4 * (x1 - y1) + 10;
          y1 := y1 - 1;
        end;
        x1 := x1 + 1;
      end;
      if (x1 = y1) then
        plotcircle(x, y, x1, y1);
    end;

Использовать следующим образом:

    procedure TForm1.Button1Click(Sender: TObject);
    begin
      DrawCircle(ClientWidth div 2, ClientHeight div 2, Min(ClientWidth div 2,
        ClientHeight div 2), Canvas, clBlack);
      {Add Math to the uses clause for the Min function}
    end;

