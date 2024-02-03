---
Title: Как создать цветовую паллитру?
Date: 01.01.2007
---


Как создать цветовую паллитру?
==============================

::: {.date}
01.01.2007
:::

Below are functions that help to create a palette (an identity palette,
BTW) from an array of RGBQuads (such as you would find in the palette
section of a .BMP file). I stole this from the WinG documentation, and
converted it to Delphi. First call ClearSystemPalette, then you can get
an identity palette by calling CreateIdentityPalette. If you plan to try
palette animation, work in a 256-color mode, and change all the
PC\_NOCOLLAPSE entries below to PC\_RESERVED. Besides creating the
palette, the other pieces to the puzzle are:

1. Override the form\'s GetPalette method, so that it returns the new
palette.

2. Select and realize the new palette just before you paint.

OldPal := SelectPalette(Canvas.Handle, NewPalette, False);

RealizePalette(Canvas.Handle);

{ Do your painting here }

SelectPalette(Canvas.Handle, OldPal, False);

3. Remember to release the palette when you are done using DeleteObject

4. If you are used using the RGB function to get color values, use the
PaletteRGB function in its place.

    function CreateIdentityPalette(const aRGB; nColors: Integer): HPALETTE;
    type
      QA = array[0..255] of TRGBQUAD;
    var
      Palette: PLOGPALETTE;
      PalSize: Word;
      ScreenDC: HDC;
      I: Integer;
      nStaticColors: Integer;
      nUsableColors: Integer;
    begin
      PalSize := SizeOf(TLOGPALETTE) + SizeOf(TPALETTEENTRY) * 256;
      GetMem(Palette, PalSize);
      try
        with Palette^ do
        begin
          palVersion := $0300;
          palNumEntries := 256;
          ScreenDC := GetDC(0);
          try
            { For SYSPAL_NOSTATIC, just copy the color table into a PALETTEENTRY
              array and replace the first and last entries with black and white }
            if (GetSystemPaletteUse(ScreenDC) = SYSPAL_NOSTATIC) then
            begin
              { Fill in the palette with the given values, marking each with PalFlag }
     
    {$R-}
              for i := 0 to (nColors - 1) do
                with palPalEntry[i], QA(aRGB)[I] do
                begin
                  peRed := rgbRed;
                  peGreen := rgbGreen;
                  peBlue := rgbBlue;
                  peFlags := PC_NOCOLLAPSE;
                end;
              { Mark any unused entries with PalFlag }
              for i := nColors to 255 do
                palPalEntry[i].peFlags := PC_NOCOLLAPSE;
              { Make sure the last entry is white - This may replace an entry in the array!}
              I := 255;
              with palPalEntry[i] do
              begin
                peRed := 255;
                peGreen := 255;
                peBlue := 255;
                peFlags := 0;
              end;
              { And the first is black - This may replace an entry in the array!}
              with palPalEntry[0] do
              begin
                peRed := 0;
                peGreen := 0;
                peBlue := 0;
                peFlags := 0;
              end;
    {$R+}
            end
            else
            begin
              { For SYSPAL_STATIC, get the twenty static colors into the
                array, then fill in the empty spaces with the given color table }
     
              { Get the static colors from the system palette }
              nStaticColors := GetDeviceCaps(ScreenDC, NUMRESERVED);
              GetSystemPaletteEntries(ScreenDC, 0, 256, palPalEntry);
    {$R-}
              { Set the peFlags of the lower static colors to zero }
              nStaticColors := nStaticColors shr 1;
              for i := 0 to (nStaticColors - 1) do
                palPalEntry[i].peFlags := 0;
              { Fill in the entries from the given color table}
              nUsableColors := nColors - nStaticColors;
              for I := nStaticColors to (nUsableColors - 1) do
                with palPalEntry[i], QA(aRGB)[i] do
                begin
                  peRed := rgbRed;
                  peGreen := rgbGreen;
                  peBlue := rgbBlue;
                  peFlags := PC_NOCOLLAPSE;
                end;
              { Mark any empty entries as PC_NOCOLLAPSE }
              for i := nUsableColors to (255 - nStaticColors) do
                palPalEntry[i].peFlags := PC_NOCOLLAPSE;
              { Set the peFlags of the upper static colors to zero }
              for i := (256 - nStaticColors) to 255 do
                palPalEntry[i].peFlags := 0;
            end;
          finally
            ReleaseDC(0, ScreenDC);
          end;
        end;
        { Return the palette }
        Result := CreatePalette(Palette^);
      finally
        FreeMem(Palette, PalSize);
      end;
    end;
     
    procedure ClearSystemPalette;
    var
      Palette: PLOGPALETTE;
      PalSize: Word;
      ScreenDC: HDC;
      I: Word;
    const
      ScreenPal: HPALETTE = 0;
    begin
      PalSize := SizeOf(TLOGPALETTE) + SizeOf(TPALETTEENTRY) * 255; {256th = [0] }
      GetMem(Palette, PalSize);
      try
        FillChar(Palette^, PalSize, 0);
        Palette^.palVersion := $0300;
        Palette^.palNumEntries := 256;
    {$R-}
        for I := 0 to 255 do
          with Palette^.palPalEntry[I] do
            peFlags := PC_NOCOLLAPSE;
    {$R+}
        { Create, select, realize, deselect, and delete the palette }
        ScreenDC := GetDC(0);
        try
          ScreenPal := CreatePalette(Palette^);
          if ScreenPal <> 0 then
          begin
            ScreenPal := SelectPalette(ScreenDC, ScreenPal, FALSE);
            RealizePalette(ScreenDC);
            ScreenPal := SelectPalette(ScreenDC, ScreenPal, FALSE);
            DeleteObject(ScreenPal);
          end;
        finally
          ReleaseDC(0, ScreenDC);
        end;
      finally
        FreeMem(Palette, PalSize);
      end;
    end;

------------------------------------------------------------------------

    unit VideoFcns;
     
    interface
    uses Windows;
     
    procedure GrayColorTable(const clrtable: PRGBQUAD; const threshold: integer = -1);
    procedure BinaryColorTable(const clrtable: PRGBQUAD; const threshold: integer);
     
    implementation
     
    procedure GrayColorTable(const clrtable: PRGBQUAD; const threshold: integer);
    var
      j: integer;
      cp: PRGBQUAD;
    begin
      if threshold <> -1 then
      begin
        BinaryColorTable(clrtable, threshold);
        exit;
      end;
      cp := clrtable;
      for j := 0 to 255 do
      begin
        {here you can set rgb components the way you like}
        cp^.rgbBlue := j;
        cp^.rgbGreen := j;
        cp^.rgbRed := j;
        cp^.rgbReserved := 0;
        inc(cp);
      end;
    end;
     
    procedure BinaryColorTable(const clrtable: PRGBQUAD; const threshold: integer);
    var
      j: integer;
      g: integer;
      cp: PRGBQUAD;
    begin
      cp := clrtable;
      for j := 0 to 255 do
      begin
        if j < threshold then
          g := 0
        else
          g := 255;
        cp^.rgbBlue := g;
        cp^.rgbGreen := g;
        cp^.rgbRed := g;
        cp^.rgbReserved := 0;
        inc(cp);
      end;
    end;

Here is an example how palette is used:

    procedure TBmpByteImage.FillBMPInfo(BMPInfo: pointer; const Wi, He: integer);
    var
      p: ^TBitmapInfo;
    begin
      p := BMPInfo;
      p^.bmiHeader.biSize := sizeof(p.bmiHeader);
      if Wi <> 0 then
        p^.bmiHeader.biWidth := Wi
      else
        p^.bmiHeader.biWidth := w;
      if He <> 0 then
        p^.bmiHeader.biHeight := He
      else
        p^.bmiHeader.biHeight := h;
      p^.bmiHeader.biPlanes := 1;
      p^.bmiHeader.biBitCount := 8;
      p^.bmiHeader.biCompression := BI_RGB;
      p^.bmiHeader.biClrUsed := 0;
      p^.bmiHeader.biClrImportant := 0;
    end;
     
    function TBmpByteImage.CreateDIB(const threshold: integer): HBITMAP;
    var
      dc: HDC;
      bmpInfo: ^TBitmapInfo;
      BMPData: pointer;
      hBmp: HBITMAP;
      x, y: integer;
      cp1, cp2: pbyte;
    begin
      GetMem(bmpInfo, sizeof(bmpInfo.bmiHeader) + sizeof(RGBQUAD) * 256);
      FillBMPInfo(BMPInfo);
      {I am using a grey palette}
      GrayColorTable(@bmpInfo^.bmiColors[0], threshold);
      dc := CreateDC('DISPLAY', nil, nil, nil);
      hBmp := CreateDIBSection(dc, bmpInfo^, DIB_RGB_COLORS, BMPData, 0, 0);
      DeleteDC(dc);
      FreeMem(bmpInfo, sizeof(bmpInfo.bmiHeader) + sizeof(RGBQUAD) * 256);
      cp2 := BMPData;
      for y := h - 1 downto 0 do
      begin
        cp1 := @g^[y]^[0];
        for x := 0 to w - 1 do
        begin
          cp2^ := cp1^;
          inc(cp1);
          inc(cp2);
        end;
      end;
      CreateDIB := hBmp;
    end;
     
    {and  finally draw bitmap }
     
    procedure TBmpByteImage.Draw(const where: TImage; const threshold: integer);
    var
      hBmp: HBITMAP;
      Bitmap1: TBitmap;
    begin
      hBmp := CreateDIB(threshold);
      if hBmp = 0 then
        exit;
      Bitmap1 := TBitmap.Create;
      with Bitmap1 do
      begin
        Handle := hBmp;
        Width := w;
        Height := h;
      end;
      where.picture.Bitmap := Bitmap1;
      Bitmap1.Free;
      GlobalFree(hBmp);
    end;

Взято с Delphi Knowledge Base: <https://www.baltsoft.com/>

------------------------------------------------------------------------

    var
      Form1: TForm1;
      blueVal: Byte;
      BluePalette: HPalette;
    implementation
     
    {$R *.DFM}
     
    procedure TForm1.FormCreate(Sender: TObject);
    var
     
      LogicalPalette: PLogPalette;
      ColorIndex: LongInt;
    begin
      GetMem(LogicalPalette, (SizeOf(TLogPalette) + SizeOf(TPaletteEntry) * 256));
      GetSystemPaletteEntries(Canvas.Handle, 0, 256,
        LogicalPalette^.palPalEntry[0]);
      with LogicalPalette^ do
     
      begin
        palVersion := $300;
        palNumEntries := 256;
    {$R-}
        for ColorIndex := 10 to 245 do
          with palPalEntry[ColorIndex] do
          begin
            peRed := 0;
            peGreen := 0;
            peBlue := 255 - (ColorIndex - 10);
            peFlags := PC_NOCOLLAPSE;
          end;
      end;
    {$R+}
      BluePalette := CreatePalette(LogicalPalette^);
      FreeMem(LogicalPalette, (SizeOf(TLogPalette) + SizeOf(TPaletteEntry) * 256));
    end;
     
    procedure TForm1.FormDestroy(Sender: TObject);
    begin
     
      DeleteObject(BluePalette);
    end;
     
    procedure TForm1.FormMouseDown(Sender: TObject; Button: TMouseButton;
     
      Shift: TShiftState; X, Y: Integer);
    var
     
      OldPal: HPALETTE;
    begin
     
      OldPal := SelectPalette(Canvas.Handle, BluePalette, False);
      RealizePalette(Canvas.Handle);
      canvas.pen.color := $02000000 or (BlueVal * $00010000);
      canvas.pen.width := 10;
      canvas.moveto(0, 0);
      canvas.lineto(X, Y);
      SelectPalette(Canvas.Handle, OldPal, False);
      Inc(BlueVal);
     
      if BlueVal > 255 then
        BlueVal := 0;
    end;

Взято с <https://delphiworld.narod.ru>
