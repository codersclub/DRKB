---
Title: Как сделать эффект скручивания (Twist / Swirl)?
Date: 01.01.2007
Source: Delphi Knowledge Base: <https://www.baltsoft.com/>
---


Как сделать эффект скручивания (Twist / Swirl)?
=================================

> Looking for something like this:

    { ... }
    try
      try
        begin
          b := TBitmap.Create;
          tBufr := TBitmap.Create;
          CopyMe(b, Image1.Picture.Graphic); {copy image to b}
          Twist(100);
        end;
      finally
        begin
          b.Free;
          tBufr.Free;
        end;
      end;
    except
      raise ESomeErrorWarning.Create('Kaboom!');
    end;
    { ... }
     

Hope this is what you were looking for:

    {A procedure to copy a graphic to a bitmap}
     
    procedure TForm1.CopyMe(tobmp: TBitmap; frbmp: TGraphic);
    begin
      tobmp.PixelFormat := pf24bit;
      tobmp.Width := frbmp.Width;
      tobmp.Height := frbmp.Height;
      tobmp.Canvas.Draw(0, 0, frbmp);
    end;
     
    procedure TForm1.Twist(Amount: integer);
    var
      fxmid, fymid: Single;
      txmid, tymid: Single;
      fx, fy: Single;
      tx2, ty2: Single;
      r: Single;
      theta: Single;
      ifx, ify: Integer;
      dx, dy: Single;
      K: integer;
      Offset: Single;
      ty, tx: Integer;
      weight_x, weight_y: array[0..1] of Single;
      weight: Single;
      new_red, new_green: Integer;
      new_blue: Integer;
      total_red, total_green: Single;
      total_blue: Single;
      ix, iy: Integer;
      sli, slo: pRGBArray;
     
      function ArcTan2(xt, yt: Single): Single;
      begin
        if xt = 0 then
          if yt > 0 then
            Result := Pi / 2
          else
            Result := -(Pi / 2)
        else
        begin
          Result := ArcTan(yt / xt);
          if xt < 0 then
            Result := Pi + ArcTan(yt / xt);
        end;
      end;
     
    begin
      Screen.Cursor := crHourGlass;
      CopyMe(tBufr, b);
      K := Amount; {Adjust this for 'amount' of twist}
      Offset := -(Pi / 2);
      dx := b.Width - 1;
      dy := b.Height - 1;
      r := Sqrt(dx * dx + dy * dy);
      tx2 := r;
      ty2 := r;
      txmid := (b.Width - 1) / 2; {Adjust these to move center of rotation}
      tymid := (b.Height - 1) / 2; {Adjust these to move}
      fxmid := (b.Width - 1) / 2;
      fymid := (b.Height - 1) / 2;
      if tx2 >= b.Width then
        tx2 := b.Width - 1;
      if ty2 >= b.Height then
        ty2 := b.Height - 1;
      for ty := 0 to Round(ty2) do
      begin
        for tx := 0 to Round(tx2) do
        begin
          dx := tx - txmid;
          dy := ty - tymid;
          r := Sqrt(dx * dx + dy * dy);
          if r = 0 then
          begin
            fx := 0;
            fy := 0;
          end
          else
          begin
            theta := ArcTan2(dx, dy) - r / K - Offset;
            fx := r * Cos(theta);
            fy := r * Sin(theta);
          end;
          fx := fx + fxmid;
          fy := fy + fymid;
          ify := Trunc(fy);
          ifx := Trunc(fx);
          {Calculate the weights}
          if fy >= 0 then
          begin
            weight_y[1] := fy - ify;
            weight_y[0] := 1 - weight_y[1];
          end
          else
          begin
            weight_y[0] := -(fy - ify);
            weight_y[1] := 1 - weight_y[0];
          end;
          if fx >= 0 then
          begin
            weight_x[1] := fx - ifx;
            weight_x[0] := 1 - weight_x[1];
          end
          else
          begin
            weight_x[0] := -(fx - ifx);
            Weight_x[1] := 1 - weight_x[0];
          end;
          if ifx < 0 then
            ifx := b.Width - 1 - (-ifx mod b.Width)
          else if ifx > b.Width - 1 then
            ifx := ifx mod b.Width;
          if ify < 0 then
            ify := b.Height - 1 - (-ify mod b.Height)
          else if ify > b.Height - 1 then
            ify := ify mod b.Height;
          total_red := 0.0;
          total_green := 0.0;
          total_blue := 0.0;
          for ix := 0 to 1 do
          begin
            for iy := 0 to 1 do
            begin
              if ify + iy < b.Height then
                sli := tBufr.Scanline[ify + iy]
              else
                sli := tBufr.ScanLine[b.Height - ify - iy];
              if ifx + ix < b.Width then
              begin
                new_red := sli[ifx + ix].rgbtRed;
                new_green := sli[ifx + ix].rgbtGreen;
                new_blue := sli[ifx + ix].rgbtBlue;
              end
              else
              begin
                new_red := sli[b.Width - ifx - ix].rgbtRed;
                new_green := sli[b.Width - ifx - ix].rgbtGreen;
                new_blue := sli[b.Width - ifx - ix].rgbtBlue;
              end;
              weight := weight_x[ix] * weight_y[iy];
              total_red := total_red + new_red * weight;
              total_green := total_green + new_green * weight;
              total_blue := total_blue + new_blue * weight;
            end;
          end;
          slo := b.ScanLine[ty];
          slo[tx].rgbtRed := Round(total_red);
          slo[tx].rgbtGreen := Round(total_green);
          slo[tx].rgbtBlue := Round(total_blue);
        end;
      end;
      Image1.Picture.Assign(b);
      Screen.Cursor := crDefault;
    end;

