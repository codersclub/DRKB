---
Title: Качественно уменьшить изображение
Author: December
Date: 01.01.2007
---


Качественно уменьшить изображение
=================================

Вариант 1:

В Delphi изменять размеры изображения очень просто, используя CopyRect:

    procedure TForm1.Button1Click(Sender: TObject);
    begin
      Form1.Canvas.Font.Size := 24;
      Form1.Canvas.TextOut(0, 0, 'Text');
      Form1.Canvas.CopyRect(Bounds(0, 50, 25, 10), Form1.Canvas,
      Bounds(0, 0, 100, 40));
    end;

Но этот способ не очень хорош для уменьшения не маленьких картинок -
мелкие детали сливаются. Для частичного устранения этого недостатка при
уменьшении изображения в четыре раза я беру средний цвет в каждом
квадратике 4X4. К чему это приводит, посмотрите сами.

    procedure TForm1.Button1Click(Sender: TObject);
    var
      x, y: integer;
      i, j: integer;
      r, g, b: integer;
    begin
      Form1.Canvas.Font.Size := 24;
      Form1.Canvas.TextOut(0, 0, 'Text');
      for y := 0 to 10 do
      begin
        for x := 0 to 25 do
        begin
          r := 0;
          for i := 0 to 3 do
            for j := 0 to 3 do
              r := r + GetRValue(Form1.Canvas.Pixels[4*x+i, 4*y+j]);
          r := round(r / 16);
          g := 0;
          for i := 0 to 3 do
            for j := 0 to 3 do
              g := g + GetGValue(Form1.Canvas.Pixels[4*x+i, 4*y+j]);
          g := round(g / 16);
          b := 0;
          for i := 0 to 3 do
            for j := 0 to 3 do
              b := b + GetBValue(Form1.Canvas.Pixels[4*x+i, 4*y+j]);
          b := round(b / 16);
          Form1.Canvas.Pixels[x,y+50] := RGB(r, g, b)
        end;
        Application.ProcessMessages;
      end;
    end;

------------------------------------------------------------------------

Вариант 2:

Source: <https://delphiworld.narod.ru>

    unit ProjetoX_Screen;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
      ExtCtrls, StdCtrls, DBCtrls;
     
    type
      TFormScreen = class(TForm)
        ImgFundo: TImage;
        procedure FormCreate(Sender: TObject);
      public
        MyRegion : HRGN;
        function BitmapToRegion(hBmp: TBitmap; TransColor: TColor): HRGN;
      end;
     
    var
      FormScreen: TFormScreen;
     
    implementation
     
    {$R *.DFM}
    function TFormScreen.BitmapToRegion(hBmp: TBitmap; TransColor: TColor): HRGN;
     
    const
      ALLOC_UNIT = 100;
     
    var
      MemDC, DC: HDC;
      BitmapInfo: TBitmapInfo;
      hbm32, holdBmp, holdMemBmp: HBitmap;
      pbits32 : Pointer;
      bm32 : BITMAP;
      maxRects: DWORD;
      hData: HGLOBAL;
      pData: PRgnData;
      b, CR, CG, CB : Byte;
      p32: pByte;
      x, x0, y: integer;
      p: pLongInt;
      pr: PRect;
      h: HRGN;
     
    begin
      Result := 0;
      if hBmp <> nil then
      begin
        MemDC := CreateCompatibleDC(0);
        if MemDC <> 0 then
        begin
          with BitmapInfo.bmiHeader do
          begin
            biSize          := sizeof(TBitmapInfoHeader);
            biWidth         := hBmp.Width;
            biHeight        := hBmp.Height;
            biPlanes        := 1;
            biBitCount      := 32;
            biCompression   := BI_RGB;
            biSizeImage     := 0;
            biXPelsPerMeter := 0;
            biYPelsPerMeter := 0;
            biClrUsed       := 0;
            biClrImportant  := 0;
          end;
          hbm32 := CreateDIBSection(MemDC, BitmapInfo, DIB_RGB_COLORS, pbits32,0, 0);
          if hbm32 <> 0 then
          begin
            holdMemBmp := SelectObject(MemDC, hbm32);
            GetObject(hbm32, SizeOf(bm32), @bm32);
            while (bm32.bmWidthBytes mod 4) > 0 do
              inc(bm32.bmWidthBytes);
            DC := CreateCompatibleDC(MemDC);
            holdBmp := SelectObject(DC, hBmp.Handle);
            BitBlt(MemDC, 0, 0, hBmp.Width, hBmp.Height, DC, 0, 0, SRCCOPY);
            maxRects := ALLOC_UNIT;
            hData := GlobalAlloc(GMEM_MOVEABLE, sizeof(TRgnDataHeader) +
               SizeOf(TRect) * maxRects);
            pData := GlobalLock(hData);
            pData^.rdh.dwSize := SizeOf(TRgnDataHeader);
            pData^.rdh.iType := RDH_RECTANGLES;
            pData^.rdh.nCount := 0;
            pData^.rdh.nRgnSize := 0;
            SetRect(pData^.rdh.rcBound, MaxInt, MaxInt, 0, 0);
            CR := GetRValue(ColorToRGB(TransColor));
            CG := GetGValue(ColorToRGB(TransColor));
            CB := GetBValue(ColorToRGB(TransColor));
            p32 := bm32.bmBits;
            inc(PChar(p32), (bm32.bmHeight - 1) * bm32.bmWidthBytes);
            for y := 0 to hBmp.Height-1 do
            begin
              x := -1;
              while x+1 < hBmp.Width do
              begin
                inc(x);
                x0 := x;
                p := PLongInt(p32);
                inc(PChar(p), x * SizeOf(LongInt));
                while x < hBmp.Width do
                begin
                  b := GetBValue(p^);
                  if (b = CR) then
                  begin
                    b := GetGValue(p^);
                    if (b = CG) then
                    begin
                      b := GetRValue(p^);
                      if (b = CB) then
                        break;
                    end;
                  end;
                  inc(PChar(p), SizeOf(LongInt));
                  inc(x);
                end;
                if x > x0 then
                begin
                  if pData^.rdh.nCount >= maxRects then
                  begin
                    GlobalUnlock(hData);
                    inc(maxRects, ALLOC_UNIT);
                    hData := GlobalReAlloc(hData, SizeOf(TRgnDataHeader) +
                       SizeOf(TRect) * maxRects, GMEM_MOVEABLE);
                    pData := GlobalLock(hData);
                    Assert(pData <> NIL);
                  end;
                  pr := @pData^.Buffer[pData^.rdh.nCount * SizeOf(TRect)];
                  SetRect(pr^, x0, y, x, y+1);
                  if x0 < pData^.rdh.rcBound.Left then
                    pData^.rdh.rcBound.Left := x0;
                  if y < pData^.rdh.rcBound.Top then
                    pData^.rdh.rcBound.Top := y;
                  if x > pData^.rdh.rcBound.Right then
                    pData^.rdh.rcBound.Left := x;
                  if y+1 > pData^.rdh.rcBound.Bottom then
                    pData^.rdh.rcBound.Bottom := y+1;
                  inc(pData^.rdh.nCount);
                  if pData^.rdh.nCount = 2000 then
                  begin
                    h := ExtCreateRegion(NIL, SizeOf(TRgnDataHeader) +
                       (SizeOf(TRect) * maxRects), pData^);
                    Assert(h <> 0);
                    if Result <> 0 then
                    begin
                      CombineRgn(Result, Result, h, RGN_OR);
                      DeleteObject(h);
                    end else
                      Result := h;
                    pData^.rdh.nCount := 0;
                    SetRect(pData^.rdh.rcBound, MaxInt, MaxInt, 0, 0);
                  end;
                end;
              end;
              Dec(PChar(p32), bm32.bmWidthBytes);
            end;
            h := ExtCreateRegion(NIL, SizeOf(TRgnDataHeader) +
               (SizeOf(TRect) * maxRects), pData^);
            Assert(h <> 0);
            if Result <> 0 then
            begin
              CombineRgn(Result, Result, h, RGN_OR);
              DeleteObject(h);
            end else
              Result := h;
            GlobalFree(hData);
            SelectObject(DC, holdBmp);
            DeleteDC(DC);
            DeleteObject(SelectObject(MemDC, holdMemBmp));
          end;
        end;
        DeleteDC(MemDC);
      end;
    end;
     
    procedure TFormScreen.FormCreate(Sender: TObject);
    begin
            MyRegion := BitmapToRegion(imgFundo.Picture.Bitmap,imgFundo.Canvas.Pixels[0,0]);
            SetWindowRgn(Handle,MyRegion,True);
    end;

     
    procedure TFormXXXXXX.FormCreate(Sender: TObject);
    begin
            FormScreen.MyRegion := FormScreen.BitmapToRegion(imgFundo.Picture.Bitmap,
              imgFundo.Canvas.Pixels[0,0]);
            SetWindowRgn(Handle,FormScreen.MyRegion,True);
    end;


------------------------------------------------

Вариант 3:

Author: December

Source: Vingrad.ru <https://forum.vingrad.ru>

    procedure ShrinkPic(Big:TBitmap;Small:TBitmap;xscale:integer=0;yscale:integer=0);
    //Из уже созданной картинки Big заполняет уже созданную картинку Small
    var
      x, y: integer;
      i, j: integer;
      r, g, b: integer;
    begin
      //Если указан фактор сжатия по ширине, то устанавливаем правильный размер, иначе вычисляем фактор
      if xscale=0
        then xscale:=Big.Width div Small.Width
        else Small.Width:=Big.Width div xscale;
      //Если указан фактор сжатия по высоте, то устанавливаем правильный размер, иначе вычисляем фактор
      if yscale=0
        then yscale:=Big.Height div Small.Height
        else Small.Height:=Big.Height div yscale;
      for y := 0 to Small.Height-1 do
        for x := 0 to Small.Width-1 do
        begin
          r := 0;
          g := 0;
          b := 0;
          for i := 0 to xscale-1 do 
            for j := 0 to yscale-1 do 
            begin
            r := r + GetRValue(Big.Canvas.Pixels[xscale*x+i, yscale*y+j]);
            g := g + GetGValue(Big.Canvas.Pixels[xscale*x+i, yscale*y+j]);
            b := b + GetBValue(Big.Canvas.Pixels[xscale*x+i, yscale*y+j]);
            end;//for, for
          r := round(r/xscale/yscale);
          g := round(g/xscale/yscale);
          b := round(b/xscale/yscale);
          Small.Canvas.Pixels[x,y]:=RGB(r,g,b)
        end;//for y, x
    end;//ShrinkPic

**Замечания.**

1. В двух вложенных форах можно xscale-1 или yscale-1 заменить
константой, в зависимости от области использования. Мой пример
соптимизирован для соотношения 4:1.
2. Процедура медленная. Даже использование scanline\'ов не спасает
ситуацию кардинально, поэтому я не стал приводить более
быстродействующий вариант, так как он более запутан. Для продвинутого
преобразования я использую отдельную библиотеку.

