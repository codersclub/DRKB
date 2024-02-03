---
Title: Как распечатать TStringGrid?
Date: 01.01.2007
---

Как распечатать TStringGrid?
============================

::: {.date}
01.01.2007
:::

    uses 
      Printers; 
     
    procedure PrintGrid(sGrid: TStringGrid; sTitle: string); 
    var 
      X1, X2: Integer; 
      Y1, Y2: Integer; 
      TmpI: Integer; 
      F: Integer; 
      TR: TRect; 
    begin 
      Printer.Title := sTitle; 
      Printer.BeginDoc; 
      Printer.Canvas.Pen.Color  := 0; 
      Printer.Canvas.Font.Name  := 'Times New Roman'; 
      Printer.Canvas.Font.Size  := 12; 
      Printer.Canvas.Font.Style := [fsBold, fsUnderline]; 
      Printer.Canvas.TextOut(0, 100, Printer.Title); 
      for F := 1 to sGrid.ColCount - 1 do  
      begin 
        X1 := 0; 
        for TmpI := 1 to (F - 1) do 
          X1 := X1 + 5 * (sGrid.ColWidths[TmpI]); 
        Y1 := 300; 
        X2 := 0; 
        for TmpI := 1 to F do 
          X2 := X2 + 5 * (sGrid.ColWidths[TmpI]); 
        Y2 := 450; 
        TR := Rect(X1, Y1, X2 - 30, Y2); 
        Printer.Canvas.Font.Style := [fsBold]; 
        Printer.Canvas.Font.Size := 7; 
        Printer.Canvas.TextRect(TR, X1 + 50, 350, sGrid.Cells[F, 0]); 
        Printer.Canvas.Font.Style := []; 
        for TmpI := 1 to sGrid.RowCount - 1 do  
        begin 
          Y1 := 150 * TmpI + 300; 
          Y2 := 150 * (TmpI + 1) + 300; 
          TR := Rect(X1, Y1, X2 - 30, Y2); 
          Printer.Canvas.TextRect(TR, X1 + 50, Y1 + 50, sGrid.Cells[F, TmpI]); 
        end; 
      end; 
      Printer.EndDoc; 
    end; 
     
     
    //Examplem, Beispiel: 
     
    procedure TForm1.Button1Click(Sender: TObject); 
    begin 
      PrintGrid(StringGrid1, 'Print Stringgrid'); 
    end; 

Взято с сайта <https://www.swissdelphicenter.ch/en/tipsindex.php>
