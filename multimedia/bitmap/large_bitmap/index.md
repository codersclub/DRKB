---
Title: Загружать большие битовые изображения с небольшим использованием памяти
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch>
---


Загружать большие битовые изображения с небольшим использованием памяти
=======================================================================

    function MyGetMem(Size: DWORD): Pointer;
    begin
      Result := Pointer(GlobalAlloc(GPTR, Size));
    end;
    
    procedure MyFreeMem(p: Pointer);
    begin
      if p = nil then Exit;
      GlobalFree(THandle(p));
    end;
    
    { This code will fill a bitmap by stretching an image coming from a big bitmap on disk. 
    
     FileName - Name of the uncompressed bitmap to read 
     DestBitmap - Target bitmap  where the bitmap on disk will be resampled. 
     BufferSize - The size of a memory buffer used for reading scanlines from the physical bitmap on disk. 
       This value will decide how many scanlines can be read from disk at the same time, with always a 
       minimum value of 2 scanlines. 
    
     Will return false on error. 
    }
    function GetDIBInBands(const FileName: string;
      DestBitmap: TBitmap; BufferSize: Integer;
      out TotalBitmapWidth, TotalBitmapHeight: Integer): Boolean;
    var
      FileSize: integer;    // calculated file size 
      ImageSize: integer;    // calculated image size 
      dest_MaxScans: integer;  // number of scanline from source bitmap 
      dsty_top: Integer;    // used to calculate number of passes 
      NumPasses: integer;    // number of passed needed 
      dest_Residual: integer;  // number of scanlines on last band 
      Stream: TStream;    // stream used for opening the bitmap 
      bmf: TBITMAPFILEHEADER;  // the bitmap header 
      lpBitmapInfo: PBITMAPINFO;  // bitmap info record 
      BitmapHeaderSize: integer;  // size of header of bitmap 
      SourceIsTopDown: Boolean;  // is reversed bitmap ? 
      SourceBytesPerScanLine: integer;  // number of bytes per scanline 
      SourceLastScanLine: Extended;     // last scanline processes 
      SourceBandHeight: Extended;       // 
      BitmapInfo: PBITMAPINFO;
      img_start: integer;
      img_end: integer;
      img_numscans: integer;
      OffsetInFile: integer;
      OldHeight: Integer;
      bits: Pointer;
      CurrentTop: Integer;
      CurrentBottom: Integer;
    begin
      Result := False;
     
      // open the big bitmap 
      Stream := TFileStream.Create(FileName, fmOpenRead or fmShareDenyWrite);
     
      // total size of bitmap 
      FileSize := Stream.Size;
      // read the header 
      Stream.ReadBuffer(bmf, SizeOf(TBITMAPFILEHEADER));
      // calculate header size 
      BitmapHeaderSize := bmf.bfOffBits - SizeOf(TBITMAPFILEHEADER);
      // calculate size of bitmap bits 
      ImageSize := FileSize - Integer(bmf.bfOffBits);
      // check for valid bitmap and exit if not 
      if ((bmf.bfType <> $4D42) or
         (Integer(bmf.bfOffBits) < 1) or
         (FileSize < 1) or (BitmapHeaderSize < 1) or (ImageSize < 1) or
         (FileSize < (SizeOf(TBITMAPFILEHEADER) + BitmapHeaderSize + ImageSize))) then
      begin
        Stream.Free;
        Exit;
      end;
      lpBitmapInfo := MyGetMem(BitmapHeaderSize);
      try
        Stream.ReadBuffer(lpBitmapInfo^, BitmapHeaderSize);
        // check for uncompressed bitmap 
        if ((lpBitmapInfo^.bmiHeader.biCompression = BI_RLE4) or
           (lpBitmapInfo^.bmiHeader.biCompression = BI_RLE8)) then
        begin
          Exit;
        end;
     
        // bitmap dimensions 
        TotalBitmapWidth  := lpBitmapInfo^.bmiHeader.biWidth;
        TotalBitmapHeight := abs(lpBitmapInfo^.bmiHeader.biHeight);
     
        // is reversed order ? 
        SourceIsTopDown := (lpBitmapInfo^.bmiHeader.biHeight < 0);
     
        // calculate number of bytes used per scanline 
        SourceBytesPerScanLine := ((((lpBitmapInfo^.bmiHeader.biWidth *
           lpBitmapInfo^.bmiHeader.biBitCount) + 31) and not 31) div 8);
     
        // adjust buffer size 
        if BufferSize < Abs(SourceBytesPerScanLine) then
           BufferSize := Abs(SourceBytesPerScanLine);
     
        // calculate number of scanlines for every pass on the destination bitmap 
        dest_MaxScans := round(BufferSize / abs(SourceBytesPerScanLine));
        dest_MaxScans := round(dest_MaxScans * (DestBitmap.Height / TotalBitmapHeight));
     
        if dest_MaxScans < 2 then
          dest_MaxScans := 2;         // at least two scan lines 
     
        // is not big enough ? 
        if dest_MaxScans > TotalBitmapHeight then
           dest_MaxScans := TotalBitmapHeight;
     
        { count the number of passes needed to fill the destination bitmap }
        dsty_top  := 0;
        NumPasses := 0;
        while (dsty_Top + dest_MaxScans) <= DestBitmap.Height do
        begin
          Inc(NumPasses);
          Inc(dsty_top, dest_MaxScans);
        end;
        if NumPasses = 0 then Exit;
     
        // calculate scanlines on last pass 
        dest_Residual := DestBitmap.Height mod dest_MaxScans;
     
        // now calculate how many scanlines in source bitmap needed for every band on the destination bitmap 
        SourceBandHeight := (TotalBitmapHeight * (1 - (dest_Residual / DestBitmap.Height))) /
           NumPasses;
     
        // initialize first band 
        CurrentTop    := 0;
        CurrentBottom := dest_MaxScans;
     
        // a floating point used in order to not loose last scanline precision on source bitmap 
        // because every band on target could be a fraction (not integral) on the source bitmap 
        SourceLastScanLine := 0.0;
     
        while CurrentTop < DestBitmap.Height do
        begin
          // scanline start of band in source bitmap 
          img_start          := Round(SourceLastScanLine);
          SourceLastScanLine := SourceLastScanLine + SourceBandHeight;
          // scanline finish of band in source bitmap 
          img_end := Round(SourceLastScanLine);
          if img_end > TotalBitmapHeight - 1 then
             img_end := TotalBitmapHeight - 1;
          img_numscans := img_end - img_start;
          if img_numscans < 1 then Break;
          OldHeight := lpBitmapInfo^.bmiHeader.biHeight;
          if SourceIsTopDown then
            lpBitmapInfo^.bmiHeader.biHeight := -img_numscans
          else
            lpBitmapInfo^.bmiHeader.biHeight := img_numscans;
     
          // memory used to read only the current band 
          bits := MyGetMem(Abs(SourceBytesPerScanLine) * img_numscans);
     
          try
            // calculate offset of band on disk 
            OffsetInFile := TotalBitmapHeight - (img_start + img_numscans);
            Stream.Seek(Integer(bmf.bfOffBits) + (OffsetInFile * abs(SourceBytesPerScanLine)),
              soFromBeginning);
            Stream.ReadBuffer(bits^, abs(SourceBytesPerScanLine) * img_numscans);
     
            SetStretchBltMode(DestBitmap.Canvas.Handle, COLORONCOLOR);
            // now stretch the band readed to the destination bitmap 
            StretchDIBits(DestBitmap.Canvas.Handle,
               0,
               CurrentTop,
               DestBitmap.Width,
               Abs(CurrentBottom - CurrentTop),
               0,
               0,
               TotalBitmapWidth,
               img_numscans,
               Bits,
               lpBitmapInfo^,
               DIB_RGB_COLORS, SRCCOPY);
          finally
            MyFreeMem(bits);
            lpBitmapInfo^.bmiHeader.biHeight := OldHeight;
          end;
     
          CurrentTop    := CurrentBottom;
          CurrentBottom := CurrentTop + dest_MaxScans;
          if CurrentBottom > DestBitmap.Height then
            CurrentBottom := DestBitmap.Height;
        end;
      finally
        Stream.Free;
        MyFreeMem(lpBitmapInfo);
      end;
      Result := True;
    end;
     
    // example of usage 
    procedure TForm1.Button1Click(Sender: TObject);
    var
      bmw, bmh: Integer;
      Bitmap: TBitmap;
    begin
      Bitmap := TBitmap.Create;
      with TOpenDialog.Create(nil) do
        try
          DefaultExt := 'BMP';
          Filter := 'Bitmaps (*.bmp)|*.bmp';
          Title := 'Define bitmap to display';
          if not Execute then Exit;
          { define the size of the required bitmap }
          Bitmap.Width       := Self.ClientWidth;
          Bitmap.Height      := Self.ClientHeight;
          Bitmap.PixelFormat := pf24Bit;
          Screen.Cursor      := crHourglass;
          // use 100 KB of buffer 
          if not GetDIBInBands(FileName, Bitmap, 100 * 1024, bmw, bmh) then Exit;
          // original bitmap width = bmw 
          // original bitmap height = bmh 
          Self.Canvas.Draw(0,0,Bitmap);
        finally
          Free;
          Bitmap.Free;
          Screen.Cursor := crDefault;
        end;
     end;

