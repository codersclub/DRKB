---
Title: Сохранение изображения экрана в файле
Author: Vit
Date: 01.01.2007
---


Сохранение изображения экрана в файле
=====================================

::: {.date}
01.01.2007
:::

На форме у меня стоит TImage (его можно сделать невидимым)

    var

      Dwh : HWND; 
      DRect: TRect; 
      DescDC: HDC; 
      Canv: TCanvas;
      i: TJPEGImage;
    begin
      try
        i := TJPEGImage.create;
        try
          Canv := TCanvas.Create();
          i.CompressionQuality := 100;
          image.Width := screen.width;
          image.height := screen.height;
          DWH := GetDesktopWindow;
          GetWindowRect(DWH, DRect);
          DescDC := GetDeviceContext(DWH);
          Canv.Handle := DescDC;
          DRect.Left := 0;
          DRect.Top := 0;
          DRect.Right := screen.Width;
          DRect.Bottom := screen.Height;
          Image.Canvas.CopyRect(DRect, Canv, DRect);
          i.assign(Image.Picture.Bitmap);
          I.SaveToFile('M:\MyFile.jpg');
          Canv.free;
        finally
          i.free;
        end;
      except
      end;

Автор: Vit

    program ScrShop;
     
    uses
    Windows;
     
    procedure ApiScrCapture(FileName: String);
    type
       TScr = array [0..1] of Byte;
       PScr = ^TScr;
    var
       hBmp       : hBitmap;
       DeskDC     : hDC;
       DC         : hDC;
       BFH        : BITMAPFILEHEADER;
       BIH        : tagBITMAPINFO;
       ScrX, ScrY : Integer;
       F          : File;
       ScrSize    : Cardinal;
       Bits       : PScr;
    begin
       SCRX     := GetSystemMetrics(SM_CXSCREEN);
       SCRY     := GetSystemMetrics(SM_CYSCREEN);
       ScrSize  := ScrX * ScrY * 3;
     
       GetMem(Bits, ScrSize);
     
       DeskDC   := GetDC(0);
       hBmp     := CreateCompatibleBitmap(DeskDC, ScrX, ScrY);
       DC       := CreateCompatibleDC(DeskDC);
     
       SelectObject(DC, hbmp);
       BitBlt(DC, 0, 0, SCRX, SCRY, DeskDC, 0, 0, SrcCopy);
     
       with BFH do
       begin
         bfType      := $4D42;
         bfSize      := SCRX * SCRY * 3 + SizeOf(BFH) + SizeOf(BIH);
         bfReserved1 := 0;
         bfReserved2 := 0;
         bfOffBits   := SizeOf(BFH) + SizeOf(BIH);
       end;
     
       with BIH.bmiHeader do
       begin
        biSize         := sizeof(BIH);
        biWidth        := SCRX;
        biHeight       := SCRY;
        biPlanes       := 1;
        biBitCount     := 24;
        biCompression  := BI_RGB;
        biSizeImage    := ScrSize;
        biClrImportant := 0;
       end;
     
       GetDiBits(DC, hbmp, 0, SCRY, Bits, BIH, DIB_RGB_COLORS);
       DeleteObject(hbmp);
       AssignFile(F, FileName);
       Rewrite(F, 1);
       Blockwrite(F, BFH, SizeOf(BFH));
       Blockwrite(F, BIH, SizeOf(BIH));
       Blockwrite(F, bits^, ScrSize);
       CloseFile(F);
       FreeMem(Bits);
    end;
     
    begin
       ApiScrCapture('1.bmp');
    end.

 \

 \
Автор: Arazel\

Взято из <https://forum.sources.ru>

------------------------------------------------------------------------

    procedure TForm1.Button1Click(Sender: TObject);
    var
      DC: HDC;
      Canva: TCanvas;
      B: TBitmap;
    begin
      Canva := TCanvas.Create;
      B := TBitmap.Create;
      DC := GetDC(0);
      try
        Canva.Handle := DC;
        with Screen do
        begin
          B.Width := Width;
          B.Height := Height;
          B.Canvas.CopyRect(Rect(0, 0, Width, Height),
          Canva, Rect(0, 0, Width, Height));
          B.SaveToFile('c:\Мои документы\screentofile.bmp');
        end
      finally
        ReleaseDC(0, DC);
        B.Free;
        Canva.Free
      end
    end;
     

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
