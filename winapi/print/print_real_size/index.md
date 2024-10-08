---
Title: Сохранение точных размеров при печати
Date: 01.01.2007
Source: Советs по Delphi от [Валентина Озерова](mailto:webmaster@webinspector.com) Сборник Kuliba
---

Сохранение точных размеров при печати
=====================================

Приведенный ниже модуль демонстрирует принцип использования
GetDeviceCaps для получения исчерпывающей информации о вашем принтере,
включая HORZRES и VERTRES (горизонтальное и вертикальное разрешение в
пикселах) на дюйм бумаги. Используя значения LOGPIXELSX и LOGPIXELSY, вы
можете откалибровать принтер для точного задания количества точек на
дюйм в горизонтальном и вертикальном направлениях.

В дополнение к информации о принтере, приведенный модуль демонстрирует
способ печати, при котором изображение выводится на принтер
"естественного" размера; также показана возможность размещения
изображения на бумаге в определенной позиции и определенного размера
(т.е. с применением масштабирования). Я думаю это должно вам помочь в
деле управления принтером.

Пример также демонстрирует вывод на печать синусной кривой в конкретной
позиции печати с заданными в дюймах размерами. Я думаю вы без труда
разберетесь как перейти на метрическую систему размеров.

    unit Tstpr2fm;
     
    {Пример использования объекта Printer из модуля TPrinter.
     
    Приведен избыточный стиль программирования для облегчения
    восприятия материала.
     
    Демонстрация величин, возвращаемых функцией Windows API GetDeviceCaps.}
     
    interface
    uses SysUtils, WinTypes, WinProcs, Messages, Classes, Graphics, Controls,
    Forms, Dialogs, StdCtrls, ExtCtrls;
     
    type
     
    TForm1 = class(TForm)
      Print: TButton;
      Image1: TImage;
      procedure PrintClick(Sender: TObject);
      private
      { Private declarations }
      public{ Public declarations }
    end;
     
    var
     
      Form1: TForm1;
     
    implementation
     
    uses
      Printers;
     
    {Константы WINAPI GetDeviceCaps получены из C++ windows.h и wingdi.h}
     
    {Отдельные константы здесь приведены только для информации о их наличии}
    const
      DRIVERVERSION = 0;
      TECHNOLOGY = 2; {Смотри windows.h для значения маски}
      HORZSIZE = 4;
      VERTSIZE = 6;
      HORZRES = 8;
      VERTRES = 10;
      BITSPIXEL = 12;
      PLANES = 14;
      NUMBRUSHES = 16;
      NUMPENS = 18;
      NUMMARKERS = 20;
      NUMFONTS = 22;
      NUMCOLORS = 24;
      PDEVICESIZE = 26;
      CURVECAPS = 28; {Смотри windows.h для значения маски}
      LINECAPS = 30; {Смотри windows.h для значения маски}
      POLYGONALCAPS = 32; {Смотри windows.h для значения маски}
      TEXTCAPS = 34; {Смотри windows.h для значения маски}
      CLIPCAPS = 36; {Смотри windows.h для значения маски}
      RASTERCAPS = 38; {Смотри windows.h для значения маски}
      ASPECTX = 40;
      ASPECTY = 42;
      ASPECTXY = 44;
     
      LOGPIXELSX = 88;
      LOGPIXELSY = 90;
     
      SIZEPALETTE = 104;
      NUMRESERVED = 106;
      COLORRES = 108;
     
      PHYSICALWIDTH = 110; {Смотри определение в windows.h}
      PHYSICALHEIGHT = 111; {Смотри определение в windows.h}
      PHYSICALOFFSETX = 112; {Смотри определение в windows.h}
      PHYSICALOFFSETY = 113; {Смотри определение в windows.h}
      SCALINGFACTORX = 114; {Смотри определение в windows.h}
      SCALINGFACTORY = 115; {Смотри определение в windows.h}
     
      DeviceCapsString: array[1..34] of string = (
        'DRIVERVERSION', 'TECHNOLOGY', 'HORZSIZE',
        'VERTSIZE', 'HORZRES', 'VERTRES',
        'BITSPIXEL', 'PLANES', 'NUMBRUSHES',
        'NUMPENS', 'NUMMARKERS', 'NUMFONTS',
        'NUMCOLORS', 'PDEVICESIZE', 'CURVECAPS',
        'LINECAPS', 'POLYGONALCAPS', 'TEXTCAPS',
        'CLIPCAPS', 'RASTERCAPS', 'ASPECTX',
        'ASPECTY', 'ASPECTXY', 'LOGPIXELSX',
        'LOGPIXELSY', 'SIZEPALETTE', 'NUMRESERVED',
        'COLORRES', 'PHYSICALWIDTH', 'PHYSICALHEIGHT',
        'PHYSICALOFFSETX', 'PHYSICALOFFSETY', 'SCALINGFACTORX',
        'SCALINGFACTORY'
      );
     
      DeviceCapsIndex: array[1..34] of INTEGER = (
        0, 2, 4, 6, 8, 10, 12, 14, 16, 18,
        20, 22, 24, 26, 28, 30, 32, 34, 36, 38,
        40, 42, 44, 88, 90, 104, 106, 108, 110, 111,
        112, 113, 114, 115);
     
    {$R *.DFM}
     
    function iPosition(const i: INTEGER): INTEGER;
    begin
      RESULT := Integer(i * LongInt(Printer.PageWidth) div 1000)
    end {iPosition};
     
    function jPosition(const j: INTEGER): INTEGER;
    begin
      RESULT := Integer(j * LongInt(Printer.PageHeight) div 1000)
    end {jPosition};
     
    procedure TForm1.PrintClick(Sender: TObject);
    var
      DestinationRectangle: TRect;
      GraphicAspectRatio: DOUBLE;
      i: INTEGER;
      j: INTEGER;
      iBase: INTEGER;
      iPixelsPerInch: WORD;
      jBase: INTEGER;
      jDelta: INTEGER;
      jPixelsPerInch: WORD;
      OffScreen: TBitMap;
      PixelAspectRatio: DOUBLE;
      SourceRectangle: TRect;
      TargetRectangle: TRect;
      value: INTEGER;
      x: DOUBLE;
      y: DOUBLE;
    begin
    
      Printer.Orientation := poLandscape;
      Printer.BeginDoc;
     
    {Делаем прямоугольник для показа полей}
      Printer.Canvas.Rectangle(0, 0, Printer.PageWidth, Printer.PageHeight);
     
    {Свойства принтера и страницы}
      Printer.Canvas.Font.Name := 'Times New Roman';
      Printer.Canvas.Font.Size := 12;
      Printer.Canvas.Font.Style := [fsBold];
      Printer.Canvas.TextOut(iPosition(50), jPosition(40), 'Свойства принтера и страницы');
     
      Printer.Canvas.Font.Style := [];
      Printer.Canvas.Font.Size := 10;
      iBase := iPosition(50);
      jBase := 60;
      jDelta := 18;
      Printer.Canvas.TextOut(iPosition(50), jPosition(jBase),
        Printer.Printers.Strings[Printer.PrinterIndex]);
      INC(jBase, jDelta);
     
      Printer.Canvas.TextOut(iBase, jPosition(jBase),
        'Пикселей:  ' + IntToStr(Printer.PageWidth) + ' X ' +
        IntToStr(Printer.PageHeight));
      INC(jBase, jDelta);
     
      Printer.Canvas.TextOut(iBase, jPosition(jBase),
        'Дюймов:  ' + FormatFloat('0.000',
        Printer.PageWidth / Printer.Canvas.Font.PixelsPerInch) + ' X ' +
        FormatFloat('0.000',
        Printer.PageHeight / Printer.Canvas.Font.PixelsPerInch));
      INC(jBase, 2 * jDelta);
     
      Printer.Canvas.TextOut(iBase, jPosition(jBase),
        'Шрифт:  ' + Printer.Canvas.Font.Name + '   Размер:  ' +
        IntToStr(Printer.Canvas.Font.Size));
      INC(jBase, jDelta);
     
      Printer.Canvas.TextOut(iBase, jPosition(jBase),
        'Пикселей в дюйме:  ' + IntToStr(Printer.Canvas.Font.PixelsPerInch));
      INC(jBase, jDelta);
     
      Printer.Canvas.TextOut(iBase, jPosition(jBase),
        '`ТЕКСТ`:  ' + IntToStr(Printer.Canvas.TextWidth('ТЕКСТ')) + ' X ' +
        IntToStr(Printer.Canvas.TextHeight('ТЕКСТ')) + ' пикселей');
     
    {Значения GetDeviceCaps}
        INC(jBase, 2 * jDelta);
        Printer.Canvas.Font.Size := 12;
        Printer.Canvas.Font.Style := [fsBold];
        Printer.Canvas.TextOut(iBase, jPosition(jBase), 'GetDeviceCaps');
        INC(jBase, jDelta);
     
        Printer.Canvas.Font.Size := 10;
        Printer.Canvas.Font.Style := [];
     
        for j := LOW(DeviceCapsIndex) to HIGH(DeviceCapsIndex) do
          begin
            value := GetDeviceCaps(Printer.Handle, DeviceCapsIndex[j]);
            Printer.Canvas.TextOut(iBase, jPosition(jBase), DeviceCapsString[j]);
     
            if (DeviceCapsIndex[j] < 28) or (DeviceCapsIndex[j] > 38) then
              Printer.Canvas.TextOut(iPosition(250), jPosition(jBase), Format('%-8d', [value]))
            else
              Printer.Canvas.TextOut(iPosition(250), jPosition(jBase), Format('%.4x', [value]));
     
            INC(jBase, jDelta);
     
          end;
     
    {Помещаем изображение в левый нижний угол}
        Printer.Canvas.Draw(iPosition(300), jPosition(100), Form1.Image1.Picture.Graphic);
     
    {Помещаем то же изображение, имеющее ширину 1" и пропорциональную
    высоту в позиции 4"-правее и 1"-ниже верхнего левого угла}
        GraphicAspectRatio := Form1.Image1.Picture.Height /
          Form1.Image1.Picture.Width;
     
        iPixelsPerInch := GetDeviceCaps(Printer.Handle, LOGPIXELSX);
        jPixelsPerInch := GetDeviceCaps(Printer.Handle, LOGPIXELSY);
        PixelAspectRatio := jPixelsPerInch / iPixelsPerInch;
     
        TargetRectangle := Rect(4 * iPixelsPerInch, {4"}
          jPixelsPerInch, {1"}
          6 * iPixelsPerInch, {6" - 2" ширина}
          jPixelsPerInch +
            TRUNC(2 * iPixelsPerInch * GraphicAspectRatio * PixelAspectRatio));
     
        Printer.Canvas.TextOut(4 * iPixelsPerInch, jPixelsPerInch -
          Printer.Canvas.TextHeight('X'),
          '2" ширина от (4", 1")');
        Printer.Canvas.StretchDraw(TargetRectangle, Form1.Image1.Picture.Graphic);
     
    {Создаем изображение в памяти и затем копируем его на холст принтера}
        SourceRectangle := Rect(0, 0, 3 * iPixelsPerInch - 1, 2 * jPixelsPerInch - 1);
     
    {Это не должно работать!  Rectangle = Left, Top, Right, Bottom
    Top и Bottom считаются зарезервированными?}
        DestinationRectangle := Rect(4 * iPixelsPerInch, 6 * jPixelsPerInch,
          7 * iPixelsPerInch - 1, 4 * jPixelsPerinch - 1);
     
        Printer.Canvas.TextOut(4 * iPixelsPerInch,
          4 * jPixelsPerInch - Printer.Canvas.TextHeight('X'),
          IntToStr(3 * iPixelsPerInch) + ' пикселей на ' +
          IntToStr(2 * jPixelsPerInch) + ' пикселей -- ' +
          '3"-на-2" в (4",4")');
     
        OffScreen := TBitMap.Create;
        try
          OffScreen.Width := SourceRectangle.Right + 1;
          OffScreen.Height := SourceRectangle.Bottom + 1;
          with OffScreen.Canvas do
            begin
              Pen.Color := clBlack;
              Brush.Color := clWhite;
              Rectangle(0, 0, 3 * iPixelsPerInch - 1, 2 * jPixelsPerInch - 1);
              Brush.Color := clRed;
              MoveTo(0, 0);
              LineTo(3 * iPixelsPerInch - 1, 2 * jPixelsPerInch - 1);
     
              Brush.Color := clBlue;
              MoveTo(0, 0);
              for i := 0 to 3 * iPixelsPerInch - 1 do
                begin
                  x := 12 * PI * (i / (3 * iPixelsPerInch - 1));
                  y := jPixelsPerInch + jPixelsPerInch * SIN(x);
                  LineTo(i, TRUNC(y));
                end
     
            end;
     
          Printer.Canvas.CopyRect(DestinationRectangle, OffScreen.Canvas,
            SourceRectangle);
        finally
          OffScreen.Free
        end;
     
    {Список шрифтов для данного принтера}
        iBase := iPosition(750);
        Printer.Canvas.Font.Name := 'Times New Roman';
        Printer.Canvas.Font.Size := 12;
        Printer.Canvas.Font.Style := [fsBold];
        Printer.Canvas.TextOut(iBase, jPosition(40), 'Шрифты');
     
        Printer.Canvas.Font.Style := [];
        Printer.Canvas.Font.Size := 10;
        jDelta := 16;
        for j := 0 to Printer.Fonts.Count - 1 do
          begin
            Printer.Canvas.TextOut(iBase, jPosition(60 + jDelta * j), Printer.Fonts.Strings[j])
          end;
     
        Printer.EndDoc;
     
    end;
     
    end.

