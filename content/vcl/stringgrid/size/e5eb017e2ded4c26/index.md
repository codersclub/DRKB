---
Title: Правое выравнивание ячеек TStringGrid
Date: 01.01.2007
---


Правое выравнивание ячеек TStringGrid
=====================================

::: {.date}
01.01.2007
:::

    procedure TForm1.GridSumaDrawCell(Sender: TObject; ACol, ARow: Longint;
      ARect: TRect; State: TGridDrawState);
    var
      dx: integer;
    begin
      with (Sender as TStringGrid).Canvas do
      begin
        Font := GridSuma.Font;
        Pen.Color := clBlack;
        if (ACol = 0) or (ARow = 0) then
        begin
          { Рисуем заголовок }
          Brush.Color := clBtnFace;
          FillRect(ARect);
          TextOut(ARect.Left, ARect.Top, GridSuma.Cells[ACol, ARow])
        end
        else
        begin
          { Рисуем ячейку с правым выравниванием }
          Brush.Color := clWhite;
          FillRect(ARect);
          dx := TextWidth(GridSuma.Cells[ACol, ARow]) + 2;
          TextOut(ARect.Right - dx, ARect.Top, GridSuma.Cells[ACol, ARow])
        end
      end
    end;
     

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

------------------------------------------------------------------------

    procedure TForm1.StringGrid1DrawCell(Sender: TObject; ACol, ARow: Integer;
       Rect: TRect; State: TGridDrawState);
     
       procedure WriteText(StringGrid: TStringGrid; ACanvas: TCanvas; const ARect: TRect;
         const Text: string; Format: Word);
       const
         DX = 2;
         DY = 2;
       var
         S: array[0..255] of Char;
         B, R: TRect;
       begin
         with Stringgrid, ACanvas, ARect do
         begin
           case Format of
             DT_LEFT: ExtTextOut(Handle, Left + DX, Top + DY,
                 ETO_OPAQUE or ETO_CLIPPED, @ARect, StrPCopy(S, Text), Length(Text), nil);
     
             DT_RIGHT: ExtTextOut(Handle, Right - TextWidth(Text) - 3, Top + DY,
                 ETO_OPAQUE or ETO_CLIPPED, @ARect, StrPCopy(S, Text),
                 Length(Text), nil);
     
             DT_CENTER: ExtTextOut(Handle, Left + (Right - Left - TextWidth(Text)) div 2,
                 Top + DY, ETO_OPAQUE or ETO_CLIPPED, @ARect,
                 StrPCopy(S, Text), Length(Text), nil);
           end;
         end;
       end;
     
       procedure Display(StringGrid: TStringGrid; const S: string; Alignment: TAlignment);
       const
         Formats: array[TAlignment] of Word = (DT_LEFT, DT_RIGHT, DT_CENTER);
       begin
         WriteText(StringGrid, StringGrid.Canvas, Rect, S, Formats[Alignment]);
       end;
     begin
       // Right-justify columns 0-2 
      // Spalten 0-2 rechts ausrichten. 
      if ACol in [0..2] then
         Display(StringGrid1, StringGrid1.Cells[ACol, ARow], taRightJustify)
     
         // Center the first row 
        // Erste zeile zentrieren 
        if ARow = 0 then
           Display(StringGrid1, StringGrid1.Cells[ACol, ARow], taCenter)
       end;

Взято с сайта: <https://www.swissdelphicenter.ch>
