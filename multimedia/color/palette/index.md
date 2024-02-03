---
Title: Как работать с палитрой в Delphi?
Date: 01.01.2007
---


Как работать с палитрой в Delphi?
=================================

::: {.date}
01.01.2007
:::

Как работать с палитрой в Delphi? На форме установлен TImage и видна
картинка (*.BMP файл), как изменить у него палитру цветов ?

Палитра в TBitmap и TMetaFile доступна через property Palette. Если
палитра имеется (что совсем необязательно), то Palette\<\>0:

    procedure TMain.BitBtnClick(Sender: TObject);
    var
      Palette : HPalette;
      PaletteSize : Integer;
      LogSize: Integer;
      LogPalette: PLogPalette;
      Red : Byte;
    begin
      Palette := Image.Picture.Bitmap.ReleasePalette;
      // здесь можно использовать просто Image.Picture.Bitmap.Palette, но  я не
      // знаю, удаляются ли ненужные палитры автоматически
     
      if Palette=0 then exit; //Палитра отсутствует
      PaletteSize := 0;
      if GetObject(Palette, SizeOf(PaletteSize), @PaletteSize) = 0 then Exit;
      // Количество элементов в палитре = paletteSize
      if PaletteSize = 0 then Exit; // палитра пустая
      // определение размера палитры
      LogSize := SizeOf(TLogPalette) + (PaletteSize - 1) * SizeOf(TPaletteEntry);
      GetMem(LogPalette, LogSize);
      try
        // заполнение полей логической палитры
        with LogPalette^ do begin
          palVersion := $0300;    palNumEntries := PaletteSize;
          GetPaletteEntries(Palette, 0, PaletteSize, palPalEntry);
          // делаете что нужно с палитрой, например:
          Red := palPalEntry[PaletteSize-1].peRed;
          Edit1.Text := 'Красная составляющего последнего элемента  палитры ='+IntToStr(Red);
          palPalEntry[PaletteSize-1].peRed := 0;
          //.......................................
        end;
        // завершение работы
        Image.Picture.Bitmap.Palette := CreatePalette(LogPalette^);
      finally
        FreeMem(LogPalette, LogSize);
        // я должен позаботиться сам об удалении Released Palette
        DeleteObject(Palette);
      end;
    end;
     
     
    { Этот модуль заполняет фон формы рисунком bor6.bmp (256 цветов) 
      и меняет его палитру при нажатии кнопки }
    unit bmpformu;
    interface
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs, StdCtrls;
     
    type
      TBmpForm = class(TForm)
        Button1: TButton;
        procedure FormDestroy(Sender: TObject);
        procedure FormPaint(Sender: TObject);
        procedure Button1Click(Sender: TObject);
        procedure FormCreate(Sender: TObject);
      private
        Bitmap: TBitmap;
        procedure ScrambleBitmap;
        procedure WMEraseBkgnd(var m: TWMEraseBkgnd); message WM_ERASEBKGND;
    end;
     
    var
      BmpForm: TBmpForm;
     
    implementation
    {$R *.DFM}
    procedure TBmpForm.FormCreate(Sender: TObject);
    begin
      Bitmap := TBitmap.Create;
      Bitmap.LoadFromFile('bor6.bmp');
    end;
     
    procedure TBmpForm.FormDestroy(Sender: TObject);
    begin
      Bitmap.Free;
    end;
     
    // since we're going to be painting the whole form, handling this
    // message will suppress the uneccessary repainting of the background
    // which can result in flicker.
    procedure TBmpform.WMEraseBkgnd(var m : TWMEraseBkgnd);
    begin
      m.Result := LRESULT(False);
    end;
     
    procedure TBmpForm.FormPaint(Sender: TObject);
    var x, y: Integer;
    begin
      y := 0;
      while y < Height do begin
        x := 0;
        while x < Width do begin
          Canvas.Draw(x, y, Bitmap);
          x := x + Bitmap.Width;
        end;
        y := y + Bitmap.Height;
      end;
    end;
     
    procedure TBmpForm.Button1Click(Sender: TObject);
    begin
      ScrambleBitmap; Invalidate;
    end;
     
    // scrambling the bitmap is easy when it's has 256 colors:
    // we just need to change each of the color in the palette
    // to some other value.
    procedure TBmpForm.ScrambleBitmap;
    var
      pal: PLogPalette;
      hpal: HPALETTE;
      i: Integer;
    begin
      pal := nil;
      try
        GetMem(pal, sizeof(TLogPalette) + sizeof(TPaletteEntry) * 255);
        pal.palVersion := $300;
        pal.palNumEntries := 256;
        for i := 0 to 255 do
        begin
          pal.palPalEntry[i].peRed := Random(255);
          pal.palPalEntry[i].peGreen := Random(255);
          pal.palPalEntry[i].peBlue := Random(255);
        end;
        hpal := CreatePalette(pal^);
        if hpal <> 0 then
          Bitmap.Palette := hpal;
      finally
        FreeMem(pal);
      end;
    end;
     
    end.

Зайцев О.В.

Владимиров А.М.

Взято из <https://forum.sources.ru>
