---
Title: Смешивание цветов рисунка с другим цветом
Author: Федоровских Николай (Fenik), chook_nu@uraltc.ru
Date: 05.06.2002
---


Смешивание цветов рисунка с другим цветом
=========================================

    **** UBPFD *********** by delphibase.endimus.com ****
    >> Смешивание цветов рисунка с другим цветом
     
    Зависимости: Graphics
    Автор:       Fenik, chook_nu@uraltc.ru, Новоуральск
    Copyright:   Автор Федоровских Николай
    Дата:        5 июня 2002 г.
    ***************************************************** }
     
    procedure Mixer(Bitmap: TBitmap; Value: Byte; Color: TColor);
      function BLimit(B: Integer): Byte;
      begin
        if B < 0 then
          Result := 0
        else if B > 255 then
          Result := 255
        else
          Result := B;
      end;
    type
      TRGB = record
        B, G, R: Byte;
      end;
      pRGB = ^TRGB;
    var
      x, y: Word;
      Dest: pRGB;
      DR, DG, DB, D: Double;
    begin
      D := Value / 200;
      DR := Lo(Color) * (1.275 - D);
      DG := Lo(Color shr 8) * (1.275 - D);
      DB := Lo((Color shr 8) shr 8) * (1.275 - D);
      for y := 0 to Bitmap.Height - 1 do
      begin
        Dest := Bitmap.ScanLine[y];
        for x := 0 to Bitmap.Width - 1 do
        begin
          with Dest^ do
          begin
            B := BLimit(Round(B * D + DB));
            G := BLimit(Round(G * D + DG));
            R := BLimit(Round(R * D + DR));
          end;
          Inc(Dest);
        end;
      end;
     
      { Неоптимизированный вариант.
     
        Value - процент цвета рисунка от конечного цвета,
        (255-Value) - процент цвета Color от конечного цвета,
        где 255 - это 100%;
        Новый цвет получается путём нахождения
        среднеарифметического значения каждого компонента
        цвета в точке (x, y) и цвета Color
        после процентного преобразования.
     
        DR := Lo(Color);//извлечение красного
        DG := Lo(Color shr 8);//извлечение зелёного
        DB := Lo((Color shr 8) shr 8);//извлечение синего
        for y := 0 to Bitmap.Height - 1 do begin
          Dest := Bitmap.ScanLine[y];
          for x := 0 to Bitmap.Width - 1 do begin
            with Dest^ do begin
              R := BLimit(Round((R/100 * Value + DR/100 * (255-Value)) / 2));
              G := BLimit(Round((G/100 * Value + DG/100 * (255-Value)) / 2));
              B := BLimit(Round((B/100 * Value + DB/100 * (255-Value)) / 2));
            end;
            Inc(Dest);
          end;
        end; }
    end;

Пример использования: 

    Mixer(FBitmap, 120, clRed); 
