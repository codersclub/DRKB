---
Title: Как сделать Wipe эффект?
Date: 01.01.2007
Source: Delphi Knowledge Base: <https://www.baltsoft.com/>
---


Как сделать Wipe эффект?
========================

    unit ClockWipe;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs, ExtCtrls, StdCtrls;
     
    type
      TPkt = array[0..361] of TPoint;
     
    type
      TForm1 = class(TForm)
        Image1: TImage;
        Image2: TImage;
        Button1: TButton;
        procedure FormPaint(Sender: TObject);
        procedure Button1Click(Sender: TObject);
      private
        procedure ClockWipe(re: TRect; Bmp: TBitmap);
        procedure SetPolygonRegion(Pkt: TPkt; PktCount: Integer; Bmp: TBitmap);
        function GetArcPoint(cPoint: TPoint; radius, winkel: Integer): TPoint;
      public
        { Public Declarations }
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.DFM}
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      Canvas.Draw(0, 0, Image1.Picture.Bitmap);
      ClockWipe(Image2.Picture.Bitmap.Canvas.ClipRect, Image2.Picture.Bitmap);
    end;
     
    procedure TForm1.FormPaint(Sender: TObject);
    begin
      Canvas.Draw(0, 0, Image1.Picture.Bitmap);
    end;
     
    procedure TForm1.ClockWipe(re: TRect; Bmp: TBitmap);
    var
      radius, winkel, cv: Integer;
      cP: TPoint;
      Pkt: TPkt;
    begin
      radius := Round(Sqrt(Sqr((re.right - re.left) div 2) + Sqr((re.bottom - re.top) div 2)));
      cP := Point((re.right - re.left) div 2, (re.bottom - re.top) div 2);
      Pkt[0] := cP;
      for winkel := 0 to 360 do
        Pkt[winkel + 1] := GetArcPoint(cP, radius, winkel + 90);
      for cv := 0 to 361 do
        if (cv - 1) / 20 = (cv - 1) div 20 then
        begin
          Sleep(50);
          SetPolygonRegion(Pkt, cv + 1, Image2.Picture.Bitmap);
        end;
    end;
     
    procedure TForm1.SetPolygonRegion(Pkt: TPkt; PktCount: Integer; Bmp: TBitmap);
    var
      Region: HRGN;
    begin
      Region := CreatePolygonRGN(Pkt, PktCount, WINDING);
      if Region <> 0 then
      begin
        SelectClipRgn(Canvas.handle, Region);
        Canvas.Draw(0, 0, Bmp);
        SelectClipRgn(Canvas.handle, 0);
        DeleteObject(Region);
      end;
    end;
     
    function TForm1.GetArcPoint(cPoint: TPoint; radius, winkel: Integer): TPoint;
    begin
      result.x := Round(cPoint.x + radius * Cos(winkel * 2 * pi / 360));
      result.y := Round(cPoint.y - radius * Sin(winkel * 2 * pi / 360));
    end;
     
    end.

