---
Title: Получение изображения экрана
Author: Rouse\_
Date: 01.01.2007
---


Получение изображения экрана
============================

::: {.date}
01.01.2007
:::

    // В качестве параметров передаются:
    // AHandle - хэндл окна, скриншот которого мы хочем получить
    // CompressPercent - процент сжатия картинки
    // AImage - картинка, в которую будет помещено изображение
    // в случае успешного скриншота функция вернет True

     
    function GetScreenShot(const AHandle: THandle; const CompressPercent: Byte;
      var AImage: TJPEGImage): Boolean;
    var
      fBitmap: TBitmap;
      DC: HDC;
      Rect: TRect;
    begin
      Result := False;
      if AImage = nil then Exit;
      DC := GetDC(AHandle);
      if DC <> 0 then
      try
        fBitmap := TBitmap.Create;
        try
          if not GetClientRect(AHandle, Rect) then Exit;
          fBitmap.Width := Rect.Right - Rect.Left;
          fBitmap.Height := Rect.Bottom - Rect.Top;
          fBitmap.PixelFormat := pf32bit;
          Result := BitBlt(fBitmap.Canvas.Handle, 0, 0, fBitmap.Width,
            fBitmap.Height, DC, 0, 0, SRCCOPY);
          if not Result then Exit;
          AImage.Assign(fBitmap);
          AImage.CompressionQuality := CompressPercent;
        finally
          fBitmap.Free;
        end;
      finally
        ReleaseDC(AHandle, DC);
      end;
    end;
     
    // Пример использования...
    procedure TForm1.Button1Click(Sender: TObject);
    var
      Image: TJPEGImage;
    begin
      // Скриншот рабочего стола
      Image := TJPEGImage.Create;
      try
        if GetScreenShot(GetDesktopWindow, 150, Image) then
          Image1.Picture.Assign(Image);
      finally
        Image.Free;
      end;
      // Скриншот нашей формы
      Image := TJPEGImage.Create;
      try
        if GetScreenShot(Handle, 150, Image) then
          Image2.Picture.Assign(Image);
      finally
        Image.Free;
      end;
    end;

Автор: Rouse\_

Взято из <https://forum.sources.ru>

------------------------------------------------------------------------

    keybd_event(VK_SNAPSHOT,1,KEYEVENTF_KEYUP,0);
    OpenClipBoard(Form1.handle);
    try
     SetClipBoardData(CF_DIB,Form1.handle);
     vv:=GetClipBoardData(CF_BITMAP);
     Image1.Picture.LoadFromClipboardFormat(CF_BITMAP,vv,0);
    finally
     CloseClipBoard; 
     EmptyClipBoard;
    end;

 

Автор: Song

Взято из <https://forum.sources.ru>

------------------------------------------------------------------------

Еще один способ получения скриншота окна, на чистом WinApi:

    function CreateWindwowBitmap(Wnd: HWND): HBITMAP;

     
    var
      R: TRect;
      W, H: Integer;
      DC, memDC: HDC;
      bm, oldBM: HBITMAP;
    begin
      GetWindowRect(Wnd, R);
      W := R.Right - R.Left;
      H := R.Bottom - R.Top;
      DC := GetWindowDC(Wnd);
      memDC := CreateCompatibleDC(DC);
      bm := CreateCompatibleBitmap(DC, W, H);
      oldBM := SelectObject(memDC, bm);
      BitBlt(memDC, 0,0, w, h, DC, 0,0, SRCCOPY);
      SelectObject(memDC, oldBM);
      DeleteDC(memDC);
      DeleteObject(oldBM);
      ReleaseDC(Wnd, DC);
      Result := bm;
    end;

Автор: Krid

Взято из <https://forum.sources.ru>

------------------------------------------------------------------------

Универсальный способ - скриншот с прозрачностью:

    procedure CaptureScreen(AFileName: string);
    const
      CAPTUREBLT = $40000000;
    var
      hdcScreen: HDC;
      hdcCompatible: HDC;
      bmp: TBitmap;
      hbmScreen: HBITMAP;
    begin
      // Create a normal DC and a memory DC for the entire screen. The
      // normal DC provides a "snapshot" of the screen contents. The
      // memory DC keeps a copy of this "snapshot" in the associated
      // bitmap.
     
      hdcScreen := CreateDC('DISPLAY', nil, nil, nil);
      hdcCompatible := CreateCompatibleDC(hdcScreen);
      // Create a compatible bitmap for hdcScreen.
     
      hbmScreen := CreateCompatibleBitmap(hdcScreen,
        GetDeviceCaps(hdcScreen, HORZRES),
        GetDeviceCaps(hdcScreen, VERTRES));
     
      // Select the bitmaps into the compatible DC.
      SelectObject(hdcCompatible, hbmScreen);
      bmp := TBitmap.Create;
      bmp.Handle := hbmScreen;
      BitBlt(hdcCompatible,
        0, 0,
        bmp.Width, bmp.Height,
        hdcScreen,
        0, 0,
        SRCCOPY or CAPTUREBLT);
     
      bmp.SaveToFile(AFileName);
      bmp.Free;
      DeleteDC(hdcScreen);
      DeleteDC(hdcCompatible);
    end;
    // from http://www.swissdelphicenter.ch

------------------------------------------------------------------------

Используйте стандартный Windows API:

используйте hWnd := GetDesktopWindow для получения дескриптора
\'рабочего стола\';

используйте hDC := GetDC (hWnd) для получения HDC (дескриптора контекста
экрана) ;

и не забывайте освобождать (уничтожать дескриптор) hDC после выполнения
задачи.

Используя TCanvas.Handle в качестве HDC, можно при помощи WinAPI
реализовать функции рисования, или, если это возможно, можно присвоить
HDC свойству Handle непосредственно при создании TCanvas.

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

------------------------------------------------------------------------

В D1 (по идее должно работать и в D2) попробуйте это:

Разместите на форме TPaintBox и TButton.

    procedure TForm1.Button1Click(Sender: TObject);
    var
      DeskTop: TCanvas;
    begin
      DeskTop := TCanvas.Create;
      try
        with DeskTop do
          Handle := GetWindowDC(GetDesktopWindow);
        with PaintBox1.Canvas do
          CopyRect(Rect(0, 0, 200, 200),
            DeskTop,
            Rect(0, 0, 200, 200))
      finally
        DeskTop.Free;
      end
    end;

Это скопирует верхнюю левую область рабочего стола в верхнюю левую
область вашего TPaintBox.

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

------------------------------------------------------------------------

Например, с помощью WinAPI так -

    var
      bmp: TBitmap;
      DC: HDC;
    begin
      bmp:=TBitmap.Create;
      bmp.Height:=Screen.Height;
      bmp.Width:=Screen.Width;
      DC:=GetDC(0);  //Дескpиптоp экpана
      bitblt(bmp.Canvas.Handle, 0, 0, Screen.Width, Screen.Height,
        DC, 0, 0, SRCCOPY);
      bmp.SaveToFile('Screen.bmp');
      ReleaseDC(0, DC);
    end;

Или с помощью обертки TCanvas -

Объект Screen\[.width,height\] - размеры

    Var
      Desktop: TCanvas ;
      BitMap: TBitMap;
    begin
      DesktopCanvas:=TCanvas.Create;
      DesktopCanvas.Handle:=GetDC(Hwnd_Desktop);
      BitMap := TBitMap.Create;
      BitMap.Width := Screen.Width;
      BitMap.Height:=Screen.Height;
      Bitmap.Canvas.CopyRect(Bitmap.Canvas.ClipRect,
      DesktopCanvas, DesktopCanvas.ClipRect);
      ........
    end; 

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

------------------------------------------------------------------------

    unit ScrnCap;
     
    interface
     
    uses
      WinTypes, WinProcs, Forms, Classes, Graphics, Controls;
     
    { Копирует прямоугольную область экрана }
    function CaptureScreenRect(ARect : TRect) : TBitmap;
    { Копирование всего экрана }
    function CaptureScreen : TBitmap;
    { Копирование клиентской области формы или элемента }
    function CaptureClientImage(Control : TControl) : TBitmap;
    { Копирование всей формы элемента }
    function CaptureControlImage(Control : TControl) : TBitmap;
     
    implementation
     
    function GetSystemPalette : HPalette;
    var
      PaletteSize : integer;
      LogSize : integer;
      LogPalette : PLogPalette;
      DC : HDC;
      Focus : HWND;
    begin
      result:=0;
      Focus:=GetFocus;
      DC:=GetDC(Focus);
      try
        PaletteSize:=GetDeviceCaps(DC, SIZEPALETTE);
        LogSize:=SizeOf(TLogPalette)+(PaletteSize-1)*SizeOf(TPaletteEntry);
        GetMem(LogPalette, LogSize);
        try
          with LogPalette^ do
          begin
            palVersion:=$0300;
            palNumEntries:=PaletteSize;
            GetSystemPaletteEntries(DC, 0, PaletteSize, palPalEntry);
          end;
          result:=CreatePalette(LogPalette^);
        finally
          FreeMem(LogPalette, LogSize);
        end;
      finally
        ReleaseDC(Focus, DC);
      end;
    end;
     
     
    function CaptureScreenRect(ARect : TRect) : TBitmap;
    var
      ScreenDC : HDC;
    begin
      Result:=TBitmap.Create;
      with result, ARect do
      begin
        Width:=Right-Left;
        Height:=Bottom-Top;
        ScreenDC:=GetDC(0);
        try
          BitBlt(Canvas.Handle, 0,0,Width,Height,ScreenDC, Left, Top, SRCCOPY );
        finally
          ReleaseDC(0, ScreenDC);
        end;
        Palette:=GetSystemPalette;
      end;
    end;
     
    function CaptureScreen : TBitmap;
    begin
      with Screen do
        Result:=CaptureScreenRect(Rect(0,0,Width,Height));
    end;
     
    function CaptureClientImage(Control : TControl) : TBitmap;
    begin
      with Control, Control.ClientOrigin do
        result:=CaptureScreenRect(Bounds(X,Y,ClientWidth,ClientHeight));
    end;
     
    function CaptureControlImage(Control : TControl) : TBitmap;
    begin
      with Control do
        if Parent=nil then
          result:=CaptureScreenRect(Bounds(Left,Top,Width,Height))
        else
          with Parent.ClientToScreen(Point(Left, Top)) do
            result:=CaptureScreenRect(Bounds(X,Y,Width,Height));
    end;
     
    end.
     

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

------------------------------------------------------------------------

    // Для копирования изображения, находящегося в клиентской части
    // формы есть метод GetFormImage. Для копирования любого
    // прямоугольника экрана можно воспользоваться функциями GDI.
     
    // Копирование произвольной прямоугольной области экрана
    Function CaptureScreenRect( ARect: TRect ): TBitmap;
    var
      ScreenDC: HDC;
    begin
      Result := TBitmap.Create;
      with Result, ARect do
      begin
        Width := Right - Left;
        Height := Bottom - Top;
     
        // получаем для экрана контекст устройства
        ScreenDC := GetDC( 0 );
        try
          // копируем оттуда прямоугольную область на канву
          // растрового изображения
          BitBlt( Canvas.Handle, 0, 0, Width, Height, ScreenDC,
            Left, Top, SRCCOPY );
        finally
          ReleaseDC( 0, ScreenDC );
        end;
      end;
    end;
     
    // Таким образом, задавая нужный прямоугольник, можно получить
    // изображение любой части экрана, получить изображение любого
    // элемента формы(кнопок , выпадающих списков и так далее).
     
    // Пример для копирования нужного элемента формы или всей формы,
    // включая и заголовок и рамку:
    Function CaptureControlImage( Control: TControl ): TBitmap;
    begin
      with Control do
        IF Parent = nil Then
          Result := CaptureScreenRect( Bounds( Left, Top, Width,Height ))
        Else
        With Parent.ClientToScreen( Point( Left, Top )) DO
          Result := CaptureScreenRect( Bounds( X, Y, Width,Height ));
    end;

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

------------------------------------------------------------------------

    uses
       Graphics;
     
     // Capture the entire screen 
    procedure ScreenShot(Bild: TBitMap);
     var
       c: TCanvas;
       r: TRect;
     begin
       c := TCanvas.Create;
       c.Handle := GetWindowDC(GetDesktopWindow);
       try
         r := Rect(0, 0, Screen.Width, Screen.Height);
         Bild.Width := Screen.Width;
         Bild.Height := Screen.Height;
         Bild.Canvas.CopyRect(r, c, r);
       finally
         ReleaseDC(0, c.Handle);
         c.Free;
       end;
     end;
     
     procedure TForm1.Button1Click(Sender: TObject);
     begin
       Form1.Visible := False;
       Sleep(750); // some delay, ein wenig Zeit geben 
      ScreenShot(Image1.Picture.BitMap);
       Form1.Visible := True;
     end;

Взято с сайта: <https://www.swissdelphicenter.ch>

------------------------------------------------------------------------

    // Capture Only active window
    procedure ScreenShotActiveWindow(Bild: TBitMap);
     var
       c: TCanvas;
       r, t: TRect;
       h: THandle;
     begin
       c := TCanvas.Create;
       c.Handle := GetWindowDC(GetDesktopWindow);
       h := GetForeGroundWindow;
       if h <> 0 then
         GetWindowRect(h, t);
       try
         r := Rect(0, 0, t.Right - t.Left, t.Bottom - t.Top);
         Bild.Width  := t.Right - t.Left;
         Bild.Height := t.Bottom - t.Top;
         Bild.Canvas.CopyRect(r, c, t);
       finally
         ReleaseDC(0, c.Handle);
         c.Free;
       end;
     end;
     
     
     procedure TForm1.Button2Click(Sender: TObject);
     begin
       Form1.Visible := False;
       Sleep(750); //some delay,ein wenig Zeit geben 
      ScreenShotActiveWindow(Image1.Picture.BitMap);
       Form1.Visible := True;
     end;

Взято с сайта: <https://www.swissdelphicenter.ch>

------------------------------------------------------------------------

    // Capture the entire screen 
    procedure ScreenShot(x: Integer;
       y: Integer; //(x, y) = Left-top coordinate 
      Width: Integer;
       Height: Integer; //(Width-Height) = Bottom-Right coordinate 
      bm: TBitMap); //Destination 
    var
       dc: HDC;
       lpPal: PLOGPALETTE;
     begin
       {test width and height}
       if ((Width = 0) or
         (Height = 0)) then
         Exit;
       bm.Width  := Width;
       bm.Height := Height;
       {get the screen dc}
       dc := GetDc(0);
       if (dc = 0) then
         Exit;
       {do we have a palette device?}
       if (GetDeviceCaps(dc, RASTERCAPS) and
         RC_PALETTE = RC_PALETTE) then
       begin
         {allocate memory for a logical palette}
         GetMem(lpPal,
           SizeOf(TLOGPALETTE) +
         (255 * SizeOf(TPALETTEENTRY)));
         {zero it out to be neat}
         FillChar(lpPal^,
           SizeOf(TLOGPALETTE) +
         (255 * SizeOf(TPALETTEENTRY)),
           #0);
         {fill in the palette version}
         lpPal^.palVersion := $300;
         {grab the system palette entries}
         lpPal^.palNumEntries :=
           GetSystemPaletteEntries(dc,
           0,
           256,
           lpPal^.palPalEntry);
         if (lpPal^.PalNumEntries <> 0) then
           {create the palette}
           bm.Palette := CreatePalette(lpPal^);
         FreeMem(lpPal, SizeOf(TLOGPALETTE) +
         (255 * SizeOf(TPALETTEENTRY)));
       end;
       {copy from the screen to the bitmap}
       BitBlt(bm.Canvas.Handle,
         0,
         0,
         Width,
         Height,
         Dc,
         x,
         y,
         SRCCOPY);
       {release the screen dc}
       ReleaseDc(0, dc);
     end;
     
     
     // Example: 
    procedure TForm1.Button1Click(Sender: TObject);
     begin
      ScreenShot(0,0,Screen.Width, Screen.Height, Image1.Picture.Bitmap);
     end;

Взято с сайта: <https://www.swissdelphicenter.ch>

------------------------------------------------------------------------

     // Capture a window 
    procedure ScreenShot(hWindow: HWND; bm: TBitmap);
     var
       Left, Top, Width, Height: Word;
       R: TRect;
       dc: HDC;
       lpPal: PLOGPALETTE;
     begin
       {Check if valid window handle}
       if not IsWindow(hWindow) then Exit;
       {Retrieves the rectangular coordinates of the specified window}
       GetWindowRect(hWindow, R);
       Left := R.Left;
       Top := R.Top;
       Width := R.Right - R.Left;
       Height := R.Bottom - R.Top;
       bm.Width  := Width;
       bm.Height := Height;
       {get the screen dc}
       dc := GetDc(0);
       if (dc = 0) then
        begin
         Exit;
       end;
       {do we have a palette device?}
       if (GetDeviceCaps(dc, RASTERCAPS) and
         RC_PALETTE = RC_PALETTE) then
        begin
         {allocate memory for a logical palette}
         GetMem(lpPal,
           SizeOf(TLOGPALETTE) +
         (255 * SizeOf(TPALETTEENTRY)));
         {zero it out to be neat}
         FillChar(lpPal^,
           SizeOf(TLOGPALETTE) +
         (255 * SizeOf(TPALETTEENTRY)),
           #0);
         {fill in the palette version}
         lpPal^.palVersion := $300;
         {grab the system palette entries}
         lpPal^.palNumEntries :=
           GetSystemPaletteEntries(dc,
           0,
           256,
           lpPal^.palPalEntry);
         if (lpPal^.PalNumEntries <> 0) then
          begin
           {create the palette}
           bm.Palette := CreatePalette(lpPal^);
         end;
         FreeMem(lpPal, SizeOf(TLOGPALETTE) +
         (255 * SizeOf(TPALETTEENTRY)));
       end;
       {copy from the screen to the bitmap}
       BitBlt(bm.Canvas.Handle,
         0,
         0,
         Width,
         Height,
         Dc,
         Left,
         Top,
         SRCCOPY);
       {release the screen dc}
       ReleaseDc(0, dc);
     end;
     // Example: Capture the foreground window: 
    procedure TForm1.Button1Click(Sender: TObject);
     begin
       ScreenShot(GetForeGroundWindow, Image1.Picture.Bitmap);
     end;

Взято с сайта: <https://www.swissdelphicenter.ch>

------------------------------------------------------------------------

     {**********************************************}
     // by Daniel Wischnewski 
    Sometimes you want to take a screen shot,
     however often Windows has trouble with big data amounts and becomes very slow.
     The simple solution is to make many small screen shots and paste the result together.
     It''s not light speed, however often faster than taking the whole screen at once.
     const
       cTileSize = 50;
     function TForm1.GetSCREENSHOT: TBitmap;
     var
       Locked: Boolean;
       X, Y, XS, YS: Integer;
       Canvas: TCanvas;
       R: TRect;
     begin
       Result := TBitmap.Create;
       Result.Width := Screen.Width;
       Result.Height := Screen.Height;
       Canvas := TCanvas.Create;
       Canvas.Handle := GetDC(0);
       Locked := Canvas.TryLock;
       try
         XS := Pred(Screen.Width div cTileSize);
         if Screen.Width mod cTileSize > 0 then
           Inc(XS);
         YS := Pred(Screen.Height div cTileSize);
         if Screen.Height mod cTileSize > 0 then
           Inc(YS);
         for X := 0 to XS do
           for Y := 0 to YS do
           begin
             R := Rect(
               X * cTileSize, Y * cTileSize, Succ(X) * cTileSize,
               Succ(Y) * cTileSize);
             Result.Canvas.CopyRect(R, Canvas, R);
           end;
       finally
         if Locked then
           Canvas.Unlock;
         ReleaseDC(0, Canvas.Handle);
         Canvas.Free;
       end;
     end;

Взято с сайта: <https://www.swissdelphicenter.ch>
