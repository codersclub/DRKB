---
Title: Масштабирование для Canvas
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch>
---


Масштабирование для Canvas
==========================

    procedure SetCanvasZoomFactor(Canvas: TCanvas; AZoomFactor: Integer);
    var
      i: Integer;
    begin
      if AZoomFactor = 100 then
        SetMapMode(Canvas.Handle, MM_TEXT)
      else
      begin
        SetMapMode(Canvas.Handle, MM_ISOTROPIC);
        SetWindowExtEx(Canvas.Handle, AZoomFactor, AZoomFactor, nil);
        SetViewportExtEx(Canvas.Handle, 100, 100, nil);
      end;
    end;
    
    
    procedure TForm1.Button1Click(Sender: TObject);
    var
      bitmap: TBitmap;
    begin
      bitmap := TBitmap.Create;
      try
        bitmap.Assign(Form1.image1.Picture.Bitmap);
        SetCanvasZoomFactor(bitmap.Canvas, 70);
        Canvas.Draw(30, 30, bitmap);
      finally
        bitmap.Free
      end;
    end;

