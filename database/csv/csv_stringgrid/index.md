---
Title: Читаем CSV текстовый файл в StringGrid
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Читаем CSV текстовый файл в StringGrid
======================================

    procedure ReadTabFile(FN: TFileName; FieldSeparator:
    Char; SG: TStringGrid);
    var 
      i: Integer; 
      S: string; 
      T: string; 
      Colonne, ligne: Integer; 
      Les_Strings: TStringList; 
      CountCols: Integer; 
      CountLines: Integer; 
      TabPos: Integer; 
      StartPos: Integer; 
      InitialCol: Integer; 
    begin 
      Les_Strings := TStringList.Create; 
      try 
        Les_Strings.LoadFromFile(FN); 
        CountLines := Les_Strings.Count + SG.FixedRows; 
        T := Les_Strings[0]; 
        for i := 0 to Length(T) - 1 do Inc(CountCols,
        Ord(IsDelimiter(FieldSeparator, T, i)));
        Inc(CountCols, 1 + SG.FixedCols); 
        if CountLines > SG.RowCount then SG.RowCount := CountLines; 
        if CountCols > SG.ColCount then SG.ColCount := CountCols; 
        InitialCol := SG.FixedCols - 1;
        Ligne := SG.FixedRows - 1; 
        for i := 0 to Les_Strings.Count - 1 do 
        begin 
          Colonne := InitialCol; 
          Inc(Ligne); 
          StartPos := 1; 
          S := Les_Strings[i]; 
          TabPos := Pos(FieldSeparator, S); 
          repeat 
            Inc(Colonne); 
            SG.Cells[Colonne, Ligne] := Copy(S, StartPos, TabPos - 1); 
            S := Copy(S, TabPos + 1, 999); 
            TabPos := Pos(FieldSeparator, S); 
          until TabPos = 0; 
        end; 
      finally 
        Les_Strings.Free; 
      end; 
    end; 
     
    procedure TForm1.Button1Click(Sender: TObject); 
    begin 
      Screen.Cursor := crHourGlass; 
      ReadTabFile('C:\TEST.TXT', #9, StringGrid1); 
      Screen.Cursor := crDefault; 
    end;

