---
Title: Хитрости печати
Date: 01.01.2007
Source: Советы по Delphi от [Валентина Озерова](mailto:webmaster@webinspector.com) Сборник Kuliba
---

Хитрости печати
===============

    const INCHES_PER_MILIMETER: Real = 0.04;
     
    type
     
      TOffset = record
        X, Y: Integer;
      end;
     
    var FDeviceName: string; {Имя устройства}
     
      FPageHeightPixel, FPageWidthPixel: Integer; {Высота и ширина страницы}
      FOrientation: TPrinterOrientation; {Ориентация}
      FPrintOffsetPixels: TOffset;
      FPixelsPerMMX, FPixelsPerMMY: Real;
      MMSize, FPageHeightMM: Integer;
      TheReport, TheHead, HeadLine, RecordLine, TFname, TLname: string;
     
    procedure TMissing_Rep.GetDeviceSettings;
     
    var
     
      retval: integer;
      PixX, PixY: Integer;
     
    begin
     
      FDeviceName := Printer.Printers[Printer.PrinterIndex]; {Получаем имя}
      FPageHeightPixel := Printer.PageHeight; {Получаем высоту страницы}
      FPageWidthPixel := Printer.PageWidth; {Получаем ширину страницы}
      FOrientation := Printer.Orientation;
    {Ориентация}
     
    {Получаем отступ при печати (поля страницы)}
    {$IFDEF WIN32}
      FPrintOffsetPixels.X := GetDeviceCaps(Printer.Handle, PHYSICALOFFSETX);
      FPrintOffsetPixels.Y := GetDeviceCaps(Printer.Handle, PHYSICALOFFSETY);
    {$ELSE}
      retval := Escape(Printer.Handle, GETPRINTINGOFFSET,
        0, nil, @FPrintOffsetPixels);
    {$ENDIF}
    {Получаем количество пикселей, печатаемое на миллиметре бумаги}
      PixX := GetDeviceCaps(Printer.Handle, LOGPIXELSX);
      PixY := GetDeviceCaps(Printer.Handle, LOGPIXELSY);
      FPixelsPerMMX := INCHES_PER_MILIMETER * PixX;
      FPixelsPerMMY := INCHES_PER_MILIMETER * PixY;
      FPageHeightMM := Round(FPageHeightPixel / FPixelsPerMMY);
    end;
     
    function TMissing_Rep.PutText(mmX, mmY: Integer; S: string; LeftAlign:
      Boolean): boolean;
    var
     
      X, Y: Integer;
      align: WORD;
    begin
     
      if LeftAlign then
        align := SetTextAlign(Printer.Handle, TA_BOTTOM or TA_LEFT)
      else
        align := SetTextAlign(Printer.Handle, TA_BOTTOM or TA_RIGHT);
      result := FALSE; {Вначале присваиваем флаг неудачи при выполнении функции}
      X := Trunc(mmX * FPixelsPerMMX) - FPrintOffsetPixels.X;
      Y := Trunc(mmY * FPixelsPerMMY) - FPrintOffsetPixels.Y;
      if X < 0 then exit;
      if Y < 0 then exit;
      Printer.Canvas.TextOut(X, Y, S);
      result := TRUE;
    end;
     
    procedure TMissing_Rep.Print_ButClick(Sender: TObject);
     
    var PixelSize: Integer;
     
    begin
      Print_But.Enabled := False;
      if PrintDialog1.Execute then
     
        begin
          Printer.Canvas.Font := Missing_Rep.Font;
          PixelSize := Printer.Canvas.TextHeight('Yy');
          MMSize := Round(PixelSize / FPixelsPerMMY);
          Printer.Title := 'Отчет';
          Printer.BeginDoc; { начинаем пересылать задание на печать }
          PrintGenerator;
          Printer.EndDoc; { EndDoc заканчивает задание печати }
        end;
      Print_But.Enabled := True;
    end;
     
    procedure TMissing_Rep.PrintGenerator;
     
    var
     
      yLoc, NumRows, TheRow: Integer;
     
      procedure Heading;
      begin
        yLoc := 20;
        PutText(20, 20, TheHead, TRUE);
        yLoc := yLoc + MMSize;
        PutText(20, yLoc, StringGrid1.Cells[0, 0], TRUE);
        PutText(60, yLoc, StringGrid1.Cells[1, 0], TRUE);
        PutText(100, yLoc, StringGrid1.Cells[2, 0], TRUE);
        PutText(120, yLoc, StringGrid1.Cells[3, 0], TRUE);
        PutText(150, yLoc, StringGrid1.Cells[4, 0], TRUE);
        yLoc := yLoc + MMSize;
      end;
     
      procedure Footer;
      begin
        PutText(100, FPageHeightMM, InttoStr(Printer.PageNumber), TRUE);
      end;
     
    begin
     
      Heading;
      TheRow := 1;
      while (TheRow < StringGrid1.RowCount) do
        begin
          if (yLoc > (FPageHeightMM - MMSize)) then
            begin
              Footer;
              Printer.NewPage;
              Heading;
            end;
          TheGauge.Progress := Round(100 * TheRow / (StringGrid1.RowCount - 1));
          PutText(20, yLoc, StringGrid1.Cells[0, TheRow], TRUE);
          PutText(60, yLoc, StringGrid1.Cells[1, TheRow], TRUE);
          PutText(100, yLoc, StringGrid1.Cells[2, TheRow], TRUE);
          PutText(120, yLoc, StringGrid1.Cells[3, TheRow], TRUE);
          PutText(150, yLoc, StringGrid1.Cells[4, TheRow], TRUE);
          yLoc := yLoc + MMSize;
          TheRow := TheRow + 1;
        end;
      Footer;
    end;

