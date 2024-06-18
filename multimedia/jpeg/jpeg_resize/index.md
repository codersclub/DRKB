---
Title: Изменение размеров JPEG Image?
Author: RoboSol
Date: 01.01.2007
---


Изменение размеров JPEG Image?
==============================

Вариант 1:

Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>

    {
     
      Before importing an image (jpg) into a database,
      I would like to resize it (reduce its size) and
      generate the corresponding smaller file. How can I do this?
     
     
      Load the JPEG into a bitmap, create a new bitmap
      of the size that you want and pass them both into
      SmoothResize then save it again ...
      there's a neat routine JPEGDimensions that
      gets the JPEG dimensions without actually loading the JPEG into a bitmap,
      saves loads of time if you only need to test its size before resizing.
    }
     
     
    uses
      JPEG;
     
    type
      TRGBArray = array[Word] of TRGBTriple;
      pRGBArray = ^TRGBArray;
     
     
    procedure SmoothResize(Src, Dst: TBitmap);
    var
      x, y: Integer;
      xP, yP: Integer;
      xP2, yP2: Integer;
      SrcLine1, SrcLine2: pRGBArray;
      t3: Integer;
      z, z2, iz2: Integer;
      DstLine: pRGBArray;
      DstGap: Integer;
      w1, w2, w3, w4: Integer;
    begin
      Src.PixelFormat := pf24Bit;
      Dst.PixelFormat := pf24Bit;
     
      if (Src.Width = Dst.Width) and (Src.Height = Dst.Height) then
        Dst.Assign(Src)
      else
      begin
        DstLine := Dst.ScanLine[0];
        DstGap  := Integer(Dst.ScanLine[1]) - Integer(DstLine);
     
        xP2 := MulDiv(pred(Src.Width), $10000, Dst.Width);
        yP2 := MulDiv(pred(Src.Height), $10000, Dst.Height);
        yP  := 0;
     
        for y := 0 to pred(Dst.Height) do
        begin
          xP := 0;
     
          SrcLine1 := Src.ScanLine[yP shr 16];
     
          if (yP shr 16 < pred(Src.Height)) then
            SrcLine2 := Src.ScanLine[succ(yP shr 16)]
          else
            SrcLine2 := Src.ScanLine[yP shr 16];
     
          z2  := succ(yP and $FFFF);
          iz2 := succ((not yp) and $FFFF);
          for x := 0 to pred(Dst.Width) do
          begin
            t3 := xP shr 16;
            z  := xP and $FFFF;
            w2 := MulDiv(z, iz2, $10000);
            w1 := iz2 - w2;
            w4 := MulDiv(z, z2, $10000);
            w3 := z2 - w4;
            DstLine[x].rgbtRed := (SrcLine1[t3].rgbtRed * w1 +
              SrcLine1[t3 + 1].rgbtRed * w2 +
              SrcLine2[t3].rgbtRed * w3 + SrcLine2[t3 + 1].rgbtRed * w4) shr 16;
            DstLine[x].rgbtGreen :=
              (SrcLine1[t3].rgbtGreen * w1 + SrcLine1[t3 + 1].rgbtGreen * w2 +
     
              SrcLine2[t3].rgbtGreen * w3 + SrcLine2[t3 + 1].rgbtGreen * w4) shr 16;
            DstLine[x].rgbtBlue := (SrcLine1[t3].rgbtBlue * w1 +
              SrcLine1[t3 + 1].rgbtBlue * w2 +
              SrcLine2[t3].rgbtBlue * w3 +
              SrcLine2[t3 + 1].rgbtBlue * w4) shr 16;
            Inc(xP, xP2);
          end; {for}
          Inc(yP, yP2);
          DstLine := pRGBArray(Integer(DstLine) + DstGap);
        end; {for}
      end; {if}
    end; {SmoothResize}
     
     
    function LoadJPEGPictureFile(Bitmap: TBitmap; FilePath, FileName: string): Boolean;
    var
      JPEGImage: TJPEGImage;
    begin
      if (FileName = '') then    // No FileName so nothing
        Result := False  //to load - return False...
      else
      begin
        try  // Start of try except
          JPEGImage := TJPEGImage.Create;  // Create the JPEG image... try  // now
          try  // to load the file but
            JPEGImage.LoadFromFile(FilePath + FileName);
            // might fail...with an Exception.
            Bitmap.Assign(JPEGImage);
            // Assign the image to our bitmap.Result := True;
            // Got it so return True.
          finally
            JPEGImage.Free;  // ...must get rid of the JPEG image. finally
          end; {try}
        except
          Result := False; // Oops...never Loaded, so return False.
        end; {try}
      end; {if}
    end; {LoadJPEGPictureFile}
     
     
    function SaveJPEGPictureFile(Bitmap: TBitmap; FilePath, FileName: string;
      Quality: Integer): Boolean;
    begin
      Result := True;
      try
        if ForceDirectories(FilePath) then
        begin
          with TJPegImage.Create do
          begin
            try
              Assign(Bitmap);
              CompressionQuality := Quality;
              SaveToFile(FilePath + FileName);
            finally
              Free;
            end; {try}
          end; {with}
        end; {if}
      except
        raise;
        Result := False;
      end; {try}
    end; {SaveJPEGPictureFile}
     
     
    procedure ResizeImage(FileName: string; MaxWidth: Integer);
    var
      OldBitmap: TBitmap;
      NewBitmap: TBitmap;
      aWidth: Integer;
    begin
      OldBitmap := TBitmap.Create;
      try
        if LoadJPEGPictureFile(OldBitmap, ExtractFilePath(FileName),
          ExtractFileName(FileName)) then
        begin
          aWidth := OldBitmap.Width;
          if (OldBitmap.Width > MaxWidth) then
          begin
            aWidth    := MaxWidth;
            NewBitmap := TBitmap.Create;
            try
              NewBitmap.Width  := MaxWidth;
              NewBitmap.Height := MulDiv(MaxWidth, OldBitmap.Height, OldBitmap.Width);
              SmoothResize(OldBitmap, NewBitmap);
              RenameFile(FileName, ChangeFileExt(FileName, '.$$$'));
              if SaveJPEGPictureFile(NewBitmap, ExtractFilePath(FileName),
                ExtractFileName(FileName), 75) then
                DeleteFile(ChangeFileExt(FileName, '.$$$'))
              else
                RenameFile(ChangeFileExt(FileName, '.$$$'), FileName);
            finally
              NewBitmap.Free;
            end; {try}
          end; {if}
        end; {if}
      finally
        OldBitmap.Free;
      end; {try}
    end;
     
     
    function JPEGDimensions(Filename : string; var X, Y : Word) : boolean;
    var
      SegmentPos : Integer;
      SOIcount : Integer;
      b : byte;
    begin
      Result  := False;
      with TFileStream.Create(Filename, fmOpenRead or fmShareDenyNone) do
      begin
        try
          Position := 0;
          Read(X, 2);
          if (X <> $D8FF) then
            exit;
          SOIcount  := 0;
          Position  := 0;
          while (Position + 7 < Size) do
          begin
            Read(b, 1);
            if (b = $FF) then begin
              Read(b, 1);
              if (b = $D8) then
                inc(SOIcount);
              if (b = $DA) then
                break;
            end; {if}
          end; {while}
          if (b <> $DA) then
            exit;
          SegmentPos  := -1;
          Position    := 0;
          while (Position + 7 < Size) do
          begin
            Read(b, 1);
            if (b = $FF) then
            begin
              Read(b, 1);
              if (b in [$C0, $C1, $C2]) then
              begin
                SegmentPos  := Position;
                dec(SOIcount);
                if (SOIcount = 0) then
                  break;
              end; {if}
            end; {if}
          end; {while}
          if (SegmentPos = -1) then
            exit;
          if (Position + 7 > Size) then
            exit;
          Position := SegmentPos + 3;
          Read(Y, 2);
          Read(X, 2);
          X := Swap(X);
          Y := Swap(Y);
          Result  := true;
        finally
          Free;
        end; {try}
      end; {with}
    end; {JPEGDimensions}

------------------------------------------------------------------------

Вариант 2:

Author: RoboSol

Source: <https://forum.sources.ru>

загрузи в bitmap, измени размеры, сделай Stretch и сохрани.

    procedure TForm1.Button1Click(Sender: TObject);
    var
      bmp: TBItmap;
      jpg: TJpegImage;
      scale: Double;
    begin
      if opendialog1.execute then
      begin
        jpg := TJpegImage.Create;
        try
          jpg.Loadfromfile( opendialog1.filename );
          if jpg.Height > jpg.Width then
            scale := 50 / jpg.Height
          else
            scale := 50 / jpg.Width;
          bmp:= Tbitmap.Create;
          try
            {Create thumbnail bitmap, keep pictures aspect ratio}
            bmp.Width := Round( jpg.Width * scale );
            bmp.Height:= Round( jpg.Height * scale );
            bmp.Canvas.StretchDraw( bmp.Canvas.Cliprect, jpg );
            {Draw thumbnail as control}
            Self.Canvas.Draw( 100, 10, bmp );
            {Convert back to JPEG and save to file}
            jpg.Assign( bmp );
            jpg.SaveToFile(ChangeFileext( opendialog1.filename, '_thumb.JPG' ));
          finally
            bmp.free;
          end;
        finally
          jpg.free;
        end;
      end;
    end;

Не забудь USES Jpeg;

