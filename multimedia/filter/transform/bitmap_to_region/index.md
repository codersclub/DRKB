---
Title: Создание уменьшенной копии картинки
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Создание уменьшенной копии картинки
===================================

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
        { Public declarations }
        MyRegion : HRGN;
        function BitmapToRegion(hBmp: TBitmap; TransColor: TColor): HRGN;
      end;
     
    var
      FormScreen: TFormScreen;
     
    implementation
     
    {$R *.DFM}
    {===========================
     размещает форму на битмапе}
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
        { Создает контекст устройства, в котором будет храниться растровое изображение. }
        MemDC := CreateCompatibleDC(0);
        if MemDC <> 0 then
        begin
         { Создает несжатое 32-битное растровое изображение. }
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
            {
              Вычисляет, сколько байтов в строке занимает 32-битное растровое изображение.
            }
            GetObject(hbm32, SizeOf(bm32), @bm32);
            while (bm32.bmWidthBytes mod 4) > 0 do
              inc(bm32.bmWidthBytes);
            DC := CreateCompatibleDC(MemDC);
            { Copia o bitmap para o Device Context }
            holdBmp := SelectObject(DC, hBmp.Handle);
            BitBlt(MemDC, 0, 0, hBmp.Width, hBmp.Height, DC, 0, 0, SRCCOPY);
            {
             Для повышения производительности для создания HRGN
             будет использоваться функция ExtCreasteRegion.
             Эта функция получает структуру RGNDATA.
             По умолчанию каждая структура будет иметь 100 прямоугольников (ALLOC_UNIT).
            }
            maxRects := ALLOC_UNIT;
            hData := GlobalAlloc(GMEM_MOVEABLE, sizeof(TRgnDataHeader) +
               SizeOf(TRect) * maxRects);
            pData := GlobalLock(hData);
            pData^.rdh.dwSize := SizeOf(TRgnDataHeader);
            pData^.rdh.iType := RDH_RECTANGLES;
            pData^.rdh.nCount := 0;
            pData^.rdh.nRgnSize := 0;
            SetRect(pData^.rdh.rcBound, MaxInt, MaxInt, 0, 0);
            { Разделяет пиксель на его основные цвета. }
            CR := GetRValue(ColorToRGB(TransColor));
            CG := GetGValue(ColorToRGB(TransColor));
            CB := GetBValue(ColorToRGB(TransColor));
            {
             Обрабатывает растровые пиксели снизу вверх,
             поскольку растровые изображения инвертированы по вертикали.
            }
            p32 := bm32.bmBits;
            inc(PChar(p32), (bm32.bmHeight - 1) * bm32.bmWidthBytes);
            for y := 0 to hBmp.Height-1 do
            begin
              { Обрабатывать пиксели растрового изображения слева направо }
              x := -1;
              while x+1 < hBmp.Width do
              begin
                inc(x);
                { Ищет непрерывную полосу непрозрачных пикселей }
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
                  {
                    Добавляет диапазон пикселей [(x0, y),(x, y+1)]
                    в качестве нового прямоугольника в регионе.
                  }
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
                  {
                    В Windows98 функция ExtCreateRegion() может завершиться ошибкой,
                    если количество прямоугольников превышает 4000.
                    По этой причине регион должен быть создан из частей,
                    содержащих менее 4000 прямоугольников.
                    В данном случае стандартизировались регионы с 2000 прямоугольниками.
                  }
                  if pData^.rdh.nCount = 2000 then
                  begin
                    h := ExtCreateRegion(NIL, SizeOf(TRgnDataHeader) +
                       (SizeOf(TRect) * maxRects), pData^);
                    Assert(h <> 0);
                   { Объединяет вновь созданную частичную область с предыдущими }
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
            { Cria a regiТo geral }
            h := ExtCreateRegion(NIL, SizeOf(TRgnDataHeader) +
                 (SizeOf(TRect) * maxRects), pData^);
            Assert(h <> 0);
            if Result <> 0 then
            begin
              CombineRgn(Result, Result, h, RGN_OR);
              DeleteObject(h);
            end else
              Result := h;
            { После завершения окончательного региона
              32-битное растровое изображение можно удалить из памяти
              вместе со всеми другими созданными указателями. }
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
     
      {загрузить изображение в TImage ImgFundo}
     
      {перепроектирует форму в формате ImgFundo}
      MyRegion := BitmapToRegion(imgFundo.Picture.Bitmap,imgFundo.Canvas.Pixels[0,0]);
      SetWindowRgn(Handle,MyRegion,True);
    end;


Для других форм просто объявите следующие строки в процедуре FormCreate:
     
    procedure TFormXXXXXX.FormCreate(Sender: TObject);
    begin
     
      {загрузить изображение в TImage ImgFundo}
     
      {перепроектирует форму в формате ImgFundo}
      FormScreen.MyRegion := FormScreen.BitmapToRegion(imgFundo.Picture.Bitmap,
              imgFundo.Canvas.Pixels[0,0]);
      SetWindowRgn(Handle,FormScreen.MyRegion,True);
    end;


