---
Title: Копирование экрана
Date: 01.01.2007
Author: Зайцев О.В., Владимиров А.М.
Source: <https://forum.sources.ru>
---


Копирование экрана
==================

    unit ScrnCap;
    interface
    uses WinTypes, WinProcs, Forms, Classes, Graphics, Controls;
     
    { Копирует прямоугольную область экрана }
    function CaptureScreenRect(ARect : TRect) : TBitmap;
    { Копирование всего экрана }
    function CaptureScreen : TBitmap;
    { Копирование клиентской области формы или элемента }
    function CaptureClientImage(Control : TControl) : TBitmap;
    { Копирование всей формы элемента }
    function CaptureControlImage(Control : TControl) : TBitmap;
     
    {===============================================================}
    implementation
    function GetSystemPalette : HPalette;
    var
     PaletteSize  : integer;
     LogSize      : integer;
     LogPalette   : PLogPalette;
     DC           : HDC;
     Focus        : HWND;
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
     with result, ARect do begin
      Width:=Right-Left;
      Height:=Bottom-Top;
      ScreenDC:=GetDC(0);
      try
        BitBlt(Canvas.Handle, 0,0,Width,Height,ScreenDC, Left, Top, SRCCOPY        );
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
      if Parent=Nil then
        result:=CaptureScreenRect(Bounds(Left,Top,Width,Height))
      else
       with Parent.ClientToScreen(Point(Left, Top)) do
        result:=CaptureScreenRect(Bounds(X,Y,Width,Height));
    end;
    end.

