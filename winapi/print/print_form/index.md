---
Title: Подробное описание способа печати содержимого формы
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---

Подробное описание способа печати содержимого формы
===================================================

Данный документ содержит подробное описание способа печати содержимого
формы: получение отдельных битов устройства при 256-цветной форме, и
использования полученных битов для печати формы на принтере.

Кроме того, в данном коде осуществляется проверка палитры устройства
(экран или принтер), и включается обработка палитры соответствующего
устройства. Если устройством палитры является устройство экрана,
принимаются дополнительные меры по заполнению палитры растрового
изображения из системной палитры, избавляющие от некорректного
заполнения палитры некоторыми видеодрайверами.

**Примечание**

Поскольку данный код делает снимок формы, форма должна располагаться на
самом верху, поверх остальных форм, быть полность на экране, и быть
видимой на момент ее "съемки".

    unit Prntit;
     
    interface
     
    uses
      SysUtils, WinTypes, WinProcs, Messages, Classes, Graphics,
      Controls, Forms, Dialogs, StdCtrls, ExtCtrls;
     
    type
      TForm1 = class(TForm)
        Button1: TButton;
        Image1: TImage;
        procedure Button1Click(Sender: TObject);
      private
        { Private declarations }
      public
        { Public declarations }
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.DFM}
     
    uses Printers;
     
    procedure TForm1.Button1Click(Sender: TObject);
    var
     
      dc: HDC;
      isDcPalDevice: BOOL;
      MemDc: hdc;
      MemBitmap: hBitmap;
      OldMemBitmap: hBitmap;
      hDibHeader: Thandle;
      pDibHeader: pointer;
      hBits: Thandle;
      pBits: pointer;
      ScaleX: Double;
      ScaleY: Double;
      ppal: PLOGPALETTE;
      pal: hPalette;
      Oldpal: hPalette;
      i: integer;
    begin
     
      {Получаем dc экрана}
      dc := GetDc(0);
      {Создаем совместимый dc}
      MemDc := CreateCompatibleDc(dc);
      {создаем изображение}
      MemBitmap := CreateCompatibleBitmap(Dc,
        form1.width,
        form1.height);
      {выбираем изображение в dc}
      OldMemBitmap := SelectObject(MemDc, MemBitmap);
     
      {Производим действия, устраняющие ошибки при работе с некоторыми типами видеодрайверов}
      isDcPalDevice := false;
      if GetDeviceCaps(dc, RASTERCAPS) and
        RC_PALETTE = RC_PALETTE then
      begin
        GetMem(pPal, sizeof(TLOGPALETTE) +
          (255 * sizeof(TPALETTEENTRY)));
        FillChar(pPal^, sizeof(TLOGPALETTE) +
          (255 * sizeof(TPALETTEENTRY)), #0);
        pPal^.palVersion := $300;
        pPal^.palNumEntries :=
          GetSystemPaletteEntries(dc,
          0,
          256,
          pPal^.palPalEntry);
        if pPal^.PalNumEntries <> 0 then
        begin
          pal := CreatePalette(pPal^);
          oldPal := SelectPalette(MemDc, Pal, false);
          isDcPalDevice := true
        end
        else
          FreeMem(pPal, sizeof(TLOGPALETTE) +
            (255 * sizeof(TPALETTEENTRY)));
      end;
     
      {копируем экран в memdc/bitmap}
      BitBlt(MemDc,
        0, 0,
        form1.width, form1.height,
        Dc,
        form1.left, form1.top,
        SrcCopy);
     
      if isDcPalDevice = true then
      begin
        SelectPalette(MemDc, OldPal, false);
        DeleteObject(Pal);
      end;
     
      {удаляем выбор изображения}
      SelectObject(MemDc, OldMemBitmap);
      {удаляем dc памяти}
      DeleteDc(MemDc);
      {Распределяем память для структуры DIB}
      hDibHeader := GlobalAlloc(GHND,
        sizeof(TBITMAPINFO) +
        (sizeof(TRGBQUAD) * 256));
      {получаем указатель на распределенную память}
      pDibHeader := GlobalLock(hDibHeader);
     
      {заполняем dib-структуру информацией, которая нам необходима в DIB}
      FillChar(pDibHeader^,
        sizeof(TBITMAPINFO) + (sizeof(TRGBQUAD) * 256),
        #0);
      PBITMAPINFOHEADER(pDibHeader)^.biSize :=
        sizeof(TBITMAPINFOHEADER);
      PBITMAPINFOHEADER(pDibHeader)^.biPlanes := 1;
      PBITMAPINFOHEADER(pDibHeader)^.biBitCount := 8;
      PBITMAPINFOHEADER(pDibHeader)^.biWidth := form1.width;
      PBITMAPINFOHEADER(pDibHeader)^.biHeight := form1.height;
      PBITMAPINFOHEADER(pDibHeader)^.biCompression := BI_RGB;
     
      {узнаем сколько памяти необходимо для битов}
      GetDIBits(dc,
        MemBitmap,
        0,
        form1.height,
        nil,
        TBitmapInfo(pDibHeader^),
        DIB_RGB_COLORS);
     
      {Распределяем память для битов}
      hBits := GlobalAlloc(GHND,
        PBitmapInfoHeader(pDibHeader)^.BiSizeImage);
      {Получаем указатель на биты}
      pBits := GlobalLock(hBits);
     
      {Вызываем функцию снова, но на этот раз нам передают биты!}
      GetDIBits(dc,
        MemBitmap,
        0,
        form1.height,
        pBits,
        PBitmapInfo(pDibHeader)^,
        DIB_RGB_COLORS);
     
      {Пробуем исправить ошибки некоторых видеодрайверов}
      if isDcPalDevice = true then
      begin
        for i := 0 to (pPal^.PalNumEntries - 1) do
        begin
          PBitmapInfo(pDibHeader)^.bmiColors[i].rgbRed :=
            pPal^.palPalEntry[i].peRed;
          PBitmapInfo(pDibHeader)^.bmiColors[i].rgbGreen :=
            pPal^.palPalEntry[i].peGreen;
          PBitmapInfo(pDibHeader)^.bmiColors[i].rgbBlue :=
            pPal^.palPalEntry[i].peBlue;
        end;
        FreeMem(pPal, sizeof(TLOGPALETTE) +
          (255 * sizeof(TPALETTEENTRY)));
      end;
     
      {Освобождаем dc экрана}
      ReleaseDc(0, dc);
      {Удаляем изображение}
      DeleteObject(MemBitmap);
     
      {Запускаем работу печати}
      Printer.BeginDoc;
     
      {Масштабируем размер печати}
      if Printer.PageWidth < Printer.PageHeight then
      begin
        ScaleX := Printer.PageWidth;
        ScaleY := Form1.Height * (Printer.PageWidth / Form1.Width);
      end
      else
      begin
        ScaleX := Form1.Width * (Printer.PageHeight / Form1.Height);
        ScaleY := Printer.PageHeight;
      end;
     
      {Просто используем драйвер принтера для устройства палитры}
      isDcPalDevice := false;
      if GetDeviceCaps(Printer.Canvas.Handle, RASTERCAPS) and
        RC_PALETTE = RC_PALETTE then
      begin
        {Создаем палитру для dib}
        GetMem(pPal, sizeof(TLOGPALETTE) +
          (255 * sizeof(TPALETTEENTRY)));
        FillChar(pPal^, sizeof(TLOGPALETTE) +
          (255 * sizeof(TPALETTEENTRY)), #0);
        pPal^.palVersion := $300;
        pPal^.palNumEntries := 256;
        for i := 0 to (pPal^.PalNumEntries - 1) do
        begin
          pPal^.palPalEntry[i].peRed :=
            PBitmapInfo(pDibHeader)^.bmiColors[i].rgbRed;
          pPal^.palPalEntry[i].peGreen :=
            PBitmapInfo(pDibHeader)^.bmiColors[i].rgbGreen;
          pPal^.palPalEntry[i].peBlue :=
            PBitmapInfo(pDibHeader)^.bmiColors[i].rgbBlue;
        end;
        pal := CreatePalette(pPal^);
        FreeMem(pPal, sizeof(TLOGPALETTE) +
          (255 * sizeof(TPALETTEENTRY)));
        oldPal := SelectPalette(Printer.Canvas.Handle, Pal, false);
        isDcPalDevice := true
      end;
     
      {посылаем биты на принтер}
      StretchDiBits(Printer.Canvas.Handle,
        0, 0,
        Round(scaleX), Round(scaleY),
        0, 0,
        Form1.Width, Form1.Height,
        pBits,
        PBitmapInfo(pDibHeader)^,
        DIB_RGB_COLORS,
        SRCCOPY);
     
      {Просто используем драйвер принтера для устройства палитры}
      if isDcPalDevice = true then
      begin
        SelectPalette(Printer.Canvas.Handle, oldPal, false);
        DeleteObject(Pal);
      end;
     
      {Очищаем распределенную память} GlobalUnlock(hBits);
      GlobalFree(hBits);
      GlobalUnlock(hDibHeader);
      GlobalFree(hDibHeader);
     
      {Заканчиваем работу печати}
      Printer.EndDoc;
     
    end;

