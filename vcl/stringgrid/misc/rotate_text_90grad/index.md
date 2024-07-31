---
Title: Повернуть текст в TStringGrid на 90 градусов
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch>
---


Повернуть текст в TStringGrid на 90 градусов
==============================================

    uses
      {...} Grids;
    
    type
      TForm1 = class(TForm)
        StringGrid1: TStringGrid;
        procedure StringGrid1DrawCell(Sender: TObject; ACol, ARow: Integer;
          Rect: TRect; State: TGridDrawState);
      end;
    
    {...}
    
    implementation
    
    {...}
    
    // Display text vertically in StringGrid cells 
    // Vertikale Textausgabe in den Zellen eines StringGrid 
    procedure StringGridRotateTextOut(Grid: TStringGrid; ARow, ACol: Integer; Rect: TRect;
      Schriftart: string; Size: Integer; Color: TColor; Alignment: TAlignment);
    var
      lf: TLogFont;
      tf: TFont;
    begin
      // if the font is to big, resize it 
      // wenn Schrift zu gro? dann anpassen 
      if (Size > Grid.ColWidths[ACol] div 2) then
        Size := Grid.ColWidths[ACol] div 2;
      with Grid.Canvas do
      begin
        // Replace the font 
        // Font setzen 
        Font.Name := Schriftart;
        Font.Size := Size;
        Font.Color := Color;
        tf := TFont.Create;
        try
          tf.Assign(Font);
          GetObject(tf.Handle, SizeOf(lf), @lf);
          lf.lfEscapement  := 900;
          lf.lfOrientation := 0;
          tf.Handle := CreateFontIndirect(lf);
          Font.Assign(tf);
        finally
          tf.Free;
        end;
        // fill the rectangle 
        // Rechteck fullen 
        FillRect(Rect);
        // Align text and write it 
        // Text nach Ausrichtung ausgeben 
        if Alignment = taLeftJustify then
          TextRect(Rect, Rect.Left + 2,Rect.Bottom - 2,Grid.Cells[ACol, ARow]);
        if Alignment = taCenter then
          TextRect(Rect, Rect.Left + Grid.ColWidths[ACol] div 2 - Size +
            Size div 3,Rect.Bottom - 2,Grid.Cells[ACol, ARow]);
        if Alignment = taRightJustify then
          TextRect(Rect, Rect.Right - Size - Size div 2 - 2,Rect.Bottom -
            2,Grid.Cells[ACol, ARow]);
      end;
    end;
    
    // 2. Alternative: Display text vertically in StringGrid cells 
    // 2. Variante: Vertikale Textausgabe in den Zellen eines StringGrid 
    procedure StringGridRotateTextOut2(Grid:TStringGrid;ARow,ACol:Integer;Rect:TRect;
              Schriftart:String;Size:Integer;Color:TColor;Alignment:TAlignment);
    var
        NewFont, OldFont : Integer;
        FontStyle, FontItalic, FontUnderline, FontStrikeout: Integer;
    begin
      // if the font is to big, resize it 
      // wenn Schrift zu gro? dann anpassen 
      If (Size > Grid.ColWidths[ACol] DIV 2) Then
           Size := Grid.ColWidths[ACol] DIV 2;
      with Grid.Canvas do
      begin
          // Set font 
          // Font setzen 
          If (fsBold IN Font.Style) Then
              FontStyle := FW_BOLD
          Else
              FontStyle := FW_NORMAL;
    
          If (fsItalic IN Font.Style) Then
              FontItalic := 1
          Else
              FontItalic := 0;
    
          If (fsUnderline IN Font.Style) Then
              FontUnderline := 1
          Else
              FontUnderline := 0;
    
          If (fsStrikeOut IN Font.Style) Then
              FontStrikeout:=1
          Else
              FontStrikeout:=0;
    
          Font.Color := Color;
    
          NewFont := CreateFont(Size, 0, 900, 0, FontStyle, FontItalic,
                                FontUnderline, FontStrikeout, DEFAULT_CHARSET,
                                OUT_DEFAULT_PRECIS, CLIP_DEFAULT_PRECIS, DEFAULT_QUALITY,
                                DEFAULT_PITCH, PChar(Schriftart));
    
          OldFont := SelectObject(Handle, NewFont);
          // fill the rectangle 
          // Rechteck fullen 
          FillRect(Rect);
          // Write text depending on the alignment 
          // Text nach Ausrichtung ausgeben 
          If Alignment = taLeftJustify Then
              TextRect(Rect,Rect.Left+2,Rect.Bottom-2,Grid.Cells[ACol,ARow]);
          If Alignment = taCenter Then
              TextRect(Rect,Rect.Left+Grid.ColWidths[ACol] DIV 2 - Size + Size DIV 3,
                Rect.Bottom-2,Grid.Cells[ACol,ARow]);
          If Alignment = taRightJustify Then
              TextRect(Rect,Rect.Right-Size - Size DIV 2 - 2,Rect.Bottom-2,Grid.Cells[ACol,ARow]);
    
          // Recreate reference to the old font 
          // Referenz auf alten Font wiederherstellen 
          SelectObject(Handle, OldFont);
          // Recreate reference to the new font 
          // Referenz auf neuen Font loschen 
          DeleteObject(NewFont);
       end;
    end;
    
    // Call the method in OnDrawCell 
    // Methode im OnDrawCell aufrufen 
    procedure TForm1.StringGrid1DrawCell(Sender: TObject; ACol,
      ARow: Integer; Rect: TRect; State: TGridDrawState);
    begin
      // In the second column: Rotate Text by 90° and left align the text 
      // Text um 90°gedreht ausgeben, linksbundig in der zweiten Spalte 
      if ACol = 1 then
        StringGridRotateTextOut(StringGrid1, ARow, ACol, Rect, 'ARIAL',
          12,clRed, taLeftJustify);
    
      // In the third column: Center the text 
      // Ausgabe zentriert in der dritten Spalte 
      if ACol = 2 then
        StringGridRotateTextOut(StringGrid1, ARow, ACol, Rect, 'ARIAL', 12, clBlue, taCenter);
    
      // In all other columns third row: right align the text 
      // Ausgabe rechtsbundig in den restlichen Spalten 
      if ACol > 2 then
        StringGridRotateTextOut(StringGrid1, ARow, ACol, Rect, 'ARIAL', 12,clGreen,
          taRightJustify);
    end;
    
    end.

