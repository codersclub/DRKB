---
Title: Как создать bitmap из массива пикселей?
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Как создать bitmap из массива пикселей?
=======================================

Один из способов создания битмапа из массива пикселей заключается в
использовании Windows API функции CreateDiBitmap(). Это позволит
использовать один из многих форматов битмапа, которые Windows использует
для хранения пикселей. Следующий пример создаёт 256-цветный битмап из
массива пикселей. Битмап состит из 256 оттенков серого цвета плавно
переходящих от белого к чёрному. Обратите внимание, что Windows
резервирует первые и последние 10 цветов для системных нужд, поэтому Вы
можете получить максимум 236 оттенков серого.

    {$IFNDEF WIN32} 
    type 
    {Used for pointer math under Win16} 
      PPtrRec = ^TPtrRec; 
      TPtrRec = record 
        Lo : Word; 
        Hi : Word; 
      end; 
    {$ENDIF} 
     
    {Used for huge pointer math} 
    function GetBigPointer(lp : pointer; 
                           Offset : Longint) : Pointer; 
    begin 
    {$IFDEF WIN32} 
      GetBigPointer := @PByteArray(lp)^[Offset]; 
    {$ELSE} 
      Offset := Offset + TPtrRec(lp).Lo; 
      GetBigPointer := Ptr(TPtrRec(lp).Hi + TPtrRec(Offset).Hi * 
                           SelectorInc, 
                           TPtrRec(Offset).Lo); 
    {$ENDIF} 
    end; 
     
    procedure TForm1.Button1Click(Sender: TObject); 
    var 
      hPixelBuffer : THandle; {Handle to the pixel buffer} 
      lpPixelBuffer : pointer; {pointer to the pixel buffer} 
      lpPalBuffer : PLogPalette; {The palette buffer} 
      lpBitmapInfo : PBitmapInfo; {The bitmap info header} 
      BitmapInfoSize : longint; {Size of the bitmap info header} 
      BitmapSize : longint; {Size of the pixel array} 
      PaletteSize : integer; {Size of the palette buffer} 
      i : longint; {loop variable} 
      j : longint; {loop variable} 
      OldPal : hPalette; {temp palette} 
      hPal : hPalette; {handle to our palette} 
      hBm : hBitmap; {handle to our bitmap} 
      Bm : TBitmap; {temporary TBitmap} 
      Dc : hdc; {used to convert the DOB to a DDB} 
      IsPaletteDevice : bool; 
    begin 
    Application.ProcessMessages; 
    {If range checking is on - turn it off for now} 
    {we will remember if range checking was on by defining} 
    {a define called CKRANGE if range checking is on.} 
    {We do this to access array members past the arrays} 
    {defined index range without causing a range check} 
    {error at runtime. To satisfy the compiler, we must} 
    {also access the indexes with a variable. ie: if we} 
    {have an array defined as a: array[0..0] of byte,} 
    {and an integer i, we can now access a[3] by setting} 
    {i := 3; and then accessing a[i] without error} 
    {$IFOPT R+} 
      {$DEFINE CKRANGE} 
      {$R-} 
    {$ENDIF} 
     
    {Lets check to see if this is a palette device - if so, then} 
    {we must do palette handling for a successful operation.} 
    {Get the screen's dc to use since memory dc's are not reliable} 
      dc := GetDc(0); 
      IsPaletteDevice := 
        GetDeviceCaps(dc, RASTERCAPS) and RC_PALETTE = RC_PALETTE; 
    {Give back the screen dc} 
      dc := ReleaseDc(0, dc); 
     
    {Размер информации о рисунке должен равняться размеру BitmapInfo} 
    {плюс размер таблицы цветов, минус одна таблица} 
    {так как она уже объявлена в TBitmapInfo} 
      BitmapInfoSize := sizeof(TBitmapInfo) + (sizeof(TRGBQUAD) * 255); 
     
    {The bitmap size must be the width of the bitmap rounded} 
    {up to the nearest 32 bit boundary} 
      BitmapSize := (sizeof(byte) * 256) * 256; 
     
    {Размер палитры должен равняться размеру TLogPalette} 
    {плюс количество ячеек цветовой палитры - 1, так как}
    {одна палитра уже объявлена в TLogPalette} 
      if IsPaletteDevice then 
       PaletteSize := sizeof(TLogPalette) + (sizeof(TPaletteEntry) * 255); 
     
    {Выделяем память под BitmapInfo, PixelBuffer, и Palette} 
      GetMem(lpBitmapInfo, BitmapInfoSize); 
      hPixelBuffer := GlobalAlloc(GHND, BitmapSize); 
      lpPixelBuffer := GlobalLock(hPixelBuffer); 
     
      if IsPaletteDevice then 
        GetMem(lpPalBuffer, PaletteSize); 
     
    {Заполняем нулями BitmapInfo, PixelBuffer, и Palette} 
      FillChar(lpBitmapInfo^, BitmapInfoSize, #0); 
      FillChar(lpPixelBuffer^, BitmapSize, #0); 
      if IsPaletteDevice then 
        FillChar(lpPalBuffer^,PaletteSize, #0); 
     
    {Заполняем структуру BitmapInfo} 
      lpBitmapInfo^.bmiHeader.biSize := sizeof(TBitmapInfoHeader); 
      lpBitmapInfo^.bmiHeader.biWidth := 256; 
      lpBitmapInfo^.bmiHeader.biHeight := 256; 
      lpBitmapInfo^.bmiHeader.biPlanes := 1; 
      lpBitmapInfo^.bmiHeader.biBitCount := 8; 
      lpBitmapInfo^.bmiHeader.biCompression := BI_RGB; 
      lpBitmapInfo^.bmiHeader.biSizeImage := BitmapSize; 
      lpBitmapInfo^.bmiHeader.biXPelsPerMeter := 0; 
      lpBitmapInfo^.bmiHeader.biYPelsPerMeter := 0; 
      lpBitmapInfo^.bmiHeader.biClrUsed := 256; 
      lpBitmapInfo^.bmiHeader.biClrImportant := 256; 
     
    {Заполняем таблицу цветов BitmapInfo оттенками серого: от чёрного до белого} 
      for i := 0 to 255 do begin 
        lpBitmapInfo^.bmiColors[i].rgbRed := i; 
        lpBitmapInfo^.bmiColors[i].rgbGreen := i; 
        lpBitmapInfo^.bmiColors[i].rgbBlue := i; 
      end;

