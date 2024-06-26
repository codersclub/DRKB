---
Title: Конвертирование BMP -> DIB
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Конвертирование BMP -> DIB
==========

> Если файл хранится в формате BMP, как мне преобразовать его в DIB и как
> затем отобразить?
	
Это не тривиально, но помочь нам смогут функции GetDIBSizes и GetDIB из
модуля GRAPHICS.PAS. Приведу две процедуры: одну для создания DIB из
TBitmap и вторую для его освобождения:

    { Преобразование TBitmap в DIB }
     
    procedure BitmapToDIB(Bitmap: TBitmap;
      var BitmapInfo: PBitmapInfo;
      var InfoSize: integer;
      var Bits: pointer;
      var BitsSize: longint);
    begin
      BitmapInfo := nil;
      InfoSize := 0;
      Bits := nil;
      BitsSize := 0;
      if not Bitmap.Empty then
      try
        GetDIBSizes(Bitmap.Handle, InfoSize, BitsSize);
        GetMem(BitmapInfo, InfoSize);
        Bits := GlobalAllocPtr(GMEM_MOVEABLE, BitsSize);
        if Bits = nil then
          raise
            EOutOfMemory.Create('Не хватает памяти для пикселей изображения');
        if not GetDIB(Bitmap.Handle, Bitmap.Palette, BitmapInfo^, Bits^) then
          raise Exception.Create('Не могу создать DIB');
      except
        if BitmapInfo <> nil then
          FreeMem(BitmapInfo, InfoSize);
        if Bits <> nil then
          GlobalFreePtr(Bits);
        BitmapInfo := nil;
        Bits := nil;
        raise;
      end;
    end;
     
    { используйте FreeDIB для освобождения информации об изображении и битовых указателей }
     
    procedure FreeDIB(BitmapInfo: PBitmapInfo;
      InfoSize: integer;
      Bits: pointer;
      BitsSize: longint);
    begin
      if BitmapInfo <> nil then
        FreeMem(BitmapInfo, InfoSize);
      if Bits <> nil then
        GlobalFreePtr(Bits);
    end;
     

Создаем форму с TImage Image1 и загружаем в него 256-цветное
изображение, затем рядом размещаем TPaintBox. Добавляем следующие
строчки к private-объявлениям вашей формы:

     
    { Private declarations }
    BitmapInfo : PBitmapInfo ;
    InfoSize   : integer ;
    Bits       : pointer ;
    BitsSize   : longint ;

Создаем нижеприведенные обработчики событий, которые демонстрируют
процесс отрисовки DIB:

    procedure TForm1.FormCreate(Sender: TObject);
    begin
      BitmapToDIB(Image1.Picture.Bitmap, BitmapInfo, InfoSize,
        Bits, BitsSize);
    end;
     
    procedure TForm1.FormDestroy(Sender: TObject);
    begin
      FreeDIB(BitmapInfo, InfoSize, Bits, BitsSize);
    end;
     
    procedure TForm1.PaintBox1Paint(Sender: TObject);
    var
      OldPalette: HPalette;
    begin
      if Assigned(BitmapInfo) and Assigned(Bits) then
        with BitmapInfo^.bmiHeader, PaintBox1.Canvas do
        begin
          OldPalette := SelectPalette(Handle,
            Image1.Picture.Bitmap.Palette,
            false);
          try
            RealizePalette(Handle);
            StretchDIBits(Handle, 0, 0, PaintBox1.Width, PaintBox1.Height,
              0, 0, biWidth, biHeight, Bits,
              BitmapInfo^, DIB_RGB_COLORS,
              SRCCOPY);
          finally
            SelectPalette(Handle, OldPalette, true);
          end;
        end;
    end;

Это поможет вам сделать первый шаг. Единственное, что вы можете
захотеть, это создание собственного HPalette на основе DIB, вместо
использования TBitmap и своей палитры. Функция с именем PaletteFromW3DIB
из GRAPHICS.PAS как раз этим и занимается, но она не объявлена в
качестве экспортируемой, поэтому для ее использования необходимо
скопировать ее исходный код и вставить его в ваш модуль.

