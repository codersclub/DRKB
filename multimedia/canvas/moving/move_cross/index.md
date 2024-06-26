---
Title: Двигаем крестик для показа значений X/Y
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Двигаем крестик для показа значений X/Y
=======================================

    // TPanel, TImage e TLabel components
    // Insert Image into Panel...
     
    private
       BmpH, BmpV : TBitmap;
       OldX, OldY: Integer;
    end;
     
    var
      RectSaved : boolean = false;
     
    procedure TFormMain.FormCreate(Sender: TObject);
    begin
      PanelImage.DoubleBuffered := true; // This prevents that the image is blinking
      LabelHint.Transparent := true;
      LabelHint.Font.Color := clNave;
    end;
     
    procedure TFormMain.FormMouseMove(Sender: TObject; Shift: TShiftState; X,
      Y: Integer);
    begin
      Cross(X, Y);
    end;
     
    procedure TFormMain.Cross(X, Y: Integer);
    begin
      Image.Canvas.Pen.Color := clBlack;
      // Restore last image to erase line
      if RectSaved then
      begin
        Image.Canvas.CopyRect(Rect(OldX - 5, 0, OldX + 5, BmpV.Height),
        BmpV.Canvas, Rect(0,0,BmpV.Width,BmpV.Height));
        Image.Canvas.CopyRect(Rect(0, OldY - 5, BmpH.Width, OldY + 5),
        BmpH.Canvas, Rect(0,0,BmpH.Width,BmpH.Height));
        BmpH.Free;
        BmpV.Free;
      end;
      // Now save the image at new position for each line
      // horizontal line
      BmpH := TBitmap.Create;
      BmpH.Width := Image.Width;
      BmpH.Height := 10;
      BmpH.Canvas.CopyRect(Rect(0,0,BmpH.Width,BmpH.Height),
      Image.Canvas,Rect(0, Y - 5, BmpH.Width, Y + 5));
      // Vertical line
      BmpV := TBitmap.Create;
      BmpV.Width := 10;
      BmpV.Height := Image.Height;
      BmpV.Canvas.CopyRect(Rect(0,0,BmpV.Width,BmpV.Height),
           Image.Canvas,Rect(X - 5, 0, X + 5, BmpV.Height));
     
      // Now draw the current position
      Image.Canvas.MoveTo(0, Y);
      Image.Canvas.LineTo(Image.Width, Y);
      Image.Canvas.MoveTo(X, 0);
      Image.Canvas.LineTo(X, Image.Height);
     
      RectSaved := true;
      OldX := X;
      OldY := Y;
     
      LabelHint.Left := X + 36;
      LabelHint.Top := Y - 15;
      LabelHint.Caption := '(X:' + IntToStr(X) + ' x Y:' + IntToStr(Y) +')';
    end;

