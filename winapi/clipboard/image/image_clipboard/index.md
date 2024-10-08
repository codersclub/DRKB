---
Title: Как копировать и вставлять картинки через буфер обмена?
Date: 01.01.2007
---


Как копировать и вставлять картинки через буфер обмена?
=======================================================

Вариант 1:

Некоторые функции для копирования и вставки Bitmap-объектов через буфер
обмена.

    function CopyClipToBuf(DC: HDC; Left, Top, Width, Height: Integer;
                           Rop: LongInt; var CopyDC: HDC;
                           var CopyBitmap: HBitmap): Boolean;
    var
      TempBitmap: HBitmap;
    begin
      Result := False;
      CopyDC := 0;
      CopyBitmap := 0;
      if DC <> 0 then
        begin
          CopyDC := CreateCompatibleDC(DC);
          if CopyDC <> 0 then
            begin
              CopyBitmap := CreateCompatibleBitmap(DC, Width, Height);
              if CopyBitmap <> 0 then
                begin
                  TempBitmap := CopyBitmap;
                  CopyBitmap := SelectObject(CopyDC, CopyBitmap);
                  Result := BitBlt(CopyDC, 0, 0, Width, Height, DC, Left, Top, Rop);
                  CopyBitmap := TempBitmap;
                end;
            end;
        end;
    end;

    function CopyBufToClip(DC: HDC; var CopyDC: HDC; var CopyBitmap: HBitmap; 
               Left, Top, Width, Height: Integer;
               Rop: LongInt; DeleteObjects: Boolean): Boolean;
    var
      TempBitmap: HBitmap;
    begin
      Result := False;
      if (DC <> 0) and (CopyDC <> 0) and (CopyBitmap <> 0) then
        begin
          TempBitmap := CopyBitmap;
          CopyBitmap := SelectObject(DC, CopyBitmap);
          Result := BitBlt(DC, Left, Top, Width, Height, CopyDC, 0, 0, Rop);
          CopyBitmap := TempBitmap;
          if DeleteObjects then
            begin
              DeleteDC(CopyDC);
              DeleteObject(CopyBitmap);
            end;
        end;
    end;

------------------------------------------------------------------------

Вариант 2:

Source: <https://delphiworld.narod.ru>

Ниже приведен код, позволяющий скопировать панель. Для вырезания части
изображения необходимо знать размеры и координаты вырезаемого
прямоугольника, и заменить значения width, height, left и top,
приведенные в коде, на реальные. Если вы действительно хотите вырезать,
а не копировать область, то вам понадобиться ее залить с помощью вызова
функции fillrect.

    Var
      BitMap: TBitmap;
    begin
      BitMap:=TBitMap.Create;
      BitMap.Height:=BaseKeyPanel.Height;
      BitMap.Width:=BaseKeyPanel.Width;
      BitBlt(BitMap.Canvas.Handle, 0 {Лево}, 0{Top},
      BaseKeyPanel.Width, BaseKeyPanel.Height,
      GetDC(BaseKeyPanel.Handle), 0, 0, SRCCOPY);
      Clipboard.Assign(BitMap);
      BitMap.Free;
    End;


------------------------------------------------------------------------

Вариант 3:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

    Clipboard.Assign(Image1.Picture);  

------------------------------------------------------------------------

Вариант 4:

Source: <https://www.swissdelphicenter.ch>

    // Copy form1 as bitmap into the clipboard 
     
    procedure TForm1.Button1Click(Sender: TObject);
    var
      imgWindow: TBitmap;
    begin
      imgWindow := GetFormImage;
      try
        Clipboard.Assign(imgWindow);
      finally
        imgWindow.Free;
      end;
    end;
    
    // Save the bitmap to a file 
    // Das Bitmap in einer Datei speichern: 
     
    procedure TForm1.Button2Click(Sender: TObject);
    var
      imgWindow: TBitmap;
    begin
      imgWindow := TBitmap.Create;
      try
        imgWindow := Form1.GetFormImage;
        imgWindow.SaveToFile('c:\FormImage.bmp');
      finally
        imgWindow.Free;
      end;
    end;
     


------------------------------------------------------------------------

Вариант 5:

Author: William Egge, egge@eggcentric.com 

Date: 17.01.2002 

Source: <https://www.swissdelphicenter.ch>

    { 
     In order to run this example you will need the GR32 Unit from the package 
     http://www.g32.org/files/graphics32/graphics32-1_5_1.zip 
     to run this example. 
    }
     
    unit EG_ClipboardBitmap32;
    { 
      Author William Egge. egge@eggcentric.com 
      January 17, 2002 
      Compiles with ver 1.2 patch #1 of Graphics32 
     
      This unit will copy and paste Bitmap32 pixels to the clipboard and retain the 
      alpha channel. 
     
      The clipboard data will still work with regular paint programs because this 
      unit adds a new format only for the alpha channel and is kept seperate from 
      the regular bitmap storage. 
    }
     
    interface
    
    uses
      ClipBrd, Windows, SysUtils, GR32;
    
    procedure CopyBitmap32ToClipboard(const Source: TBitmap32);
    procedure PasteBitmap32FromClipboard(const Dest: TBitmap32);
    function CanPasteBitmap32: Boolean;
    
    implementation
    
    const
      RegisterName = 'G32 Bitmap32 Alpha Channel';
      GlobalUnlockBugErrorCode = ERROR_INVALID_PARAMETER;
    
    var
      FAlphaFormatHandle: Word = 0;
    
    procedure RaiseSysError;
    var
      ErrCode: LongWord;
    begin
      ErrCode := GetLastError();
      if ErrCode <> NO_ERROR then
        raise Exception.Create(SysErrorMessage(ErrCode));
    end;
    
    function GetAlphaFormatHandle: Word;
    begin
      if FAlphaFormatHandle = 0 then
      begin
        FAlphaFormatHandle := RegisterClipboardFormat(RegisterName);
        if FAlphaFormatHandle = 0 then
          RaiseSysError;
      end;
      Result := FAlphaFormatHandle;
    end;
    
    function CanPasteBitmap32: Boolean;
    begin
      Result := Clipboard.HasFormat(CF_BITMAP);
    end;
    
    procedure CopyBitmap32ToClipboard(const Source: TBitmap32);
    var
      H: HGLOBAL;
      Bytes: LongWord;
      P, Alpha: PByte;
      I: Integer;
    begin
      Clipboard.Assign(Source);
      if not OpenClipboard(0) then
        RaiseSysError
      else
        try
          Bytes := 4 + (Source.Width * Source.Height);
          H := GlobalAlloc(GMEM_MOVEABLE and GMEM_DDESHARE, Bytes);
          if H = 0 then
            RaiseSysError;
          P := GlobalLock(H);
          if P = nil then
            RaiseSysError
          else
            try
              PLongWord(P)^ := Bytes - 4;
              Inc(P, 4);
              // Copy Alpha into Array 
             Alpha := Pointer(Source.Bits);
              Inc(Alpha, 3); // Align with Alpha 
             for I := 1 to (Source.Width * Source.Height) do
              begin
                P^ := Alpha^;
                Inc(Alpha, 4);
                Inc(P);
              end;
            finally
              if (not GlobalUnlock(H)) then
                if (GetLastError() <> GlobalUnlockBugErrorCode) then
                  RaiseSysError;
            end;
          SetClipboardData(GetAlphaFormatHandle, H);
        finally
          if not CloseClipboard then
            RaiseSysError;
        end;
    end;
    
    procedure PasteBitmap32FromClipboard(const Dest: TBitmap32);
    var
      H: HGLOBAL;
      ClipAlpha, Alpha: PByte;
      I, Count, PixelCount: LongWord;
    begin
      if Clipboard.HasFormat(CF_BITMAP) then
      begin
        Dest.BeginUpdate;
        try
          Dest.Assign(Clipboard);
          if not OpenClipboard(0) then
            RaiseSysError
          else
            try
              H := GetClipboardData(GetAlphaFormatHandle);
              if H <> 0 then
              begin
                ClipAlpha := GlobalLock(H);
                if ClipAlpha = nil then
                  RaiseSysError
                else
                  try
                    Alpha := Pointer(Dest.Bits);
                    Inc(Alpha, 3); // Align with Alpha 
                   Count := PLongWord(ClipAlpha)^;
                    Inc(ClipAlpha, 4);
                    PixelCount := Dest.Width * Dest.Height;
                    Assert(Count = PixelCount,
                      'Alpha Count does not match Bitmap pixel Count, PasteBitmap32FromClipboard(const Dest: TBitmap32);');
    
                    // Should not happen, but if it does then this is a safety catch. 
                   if Count > PixelCount then
                      Count := PixelCount;
    
                    for I := 1 to Count do
                    begin
                      Alpha^ := ClipAlpha^;
                      Inc(Alpha, 4);
                      Inc(ClipAlpha);
                    end;
                  finally
                    if (not GlobalUnlock(H)) then
                      if (GetLastError() <> GlobalUnlockBugErrorCode) then
                        RaiseSysError;
                  end;
              end;
            finally
              if not CloseClipboard then
                RaiseSysError;
            end;
        finally
          Dest.EndUpdate;
          Dest.Changed;
        end;
      end;
    end;
    
    end.
    
    
    // Example Call: 
     
    {uses 
      JPEG;}
     
    procedure TForm1.Button1Click(Sender: TObject);
    var
      bmp: TBitmap32;
    begin
      bmp := TBitmap32.Create;
      try
        bmp.LoadFromFile('C:\test.jpg');
        CopyBitmap32ToClipboard(bmp);
      finally
        bmp.Free;
      end;
    end;

