---
Title: Добавление колонки в TStringGrid
Date: 01.01.2007
---


Добавление колонки в TStringGrid
================================

Вариант 1:

    procedure GridAddColumn(StrGrid: TStringGrid; NewColumn: Integer); 
    Var Column: Integer; 
    begin 
      StrGrid.ColCount := StrGrid.ColCount+1; 
      For Column := StrGrid.ColCount-1 downto NewColumn do 
        StrGrid.Cols[Column].Assign(StrGrid.Cols[Column-1]); 
      StrGrid.Cols[NewColumn-1].Text := ''; 
    end; 

------------------------------------------------------------------------

Вариант 2:

Source: <https://forum.sources.ru>

    procedure AddColumn(SG : TStringGrid; AtColNumber : integer; 
                        ColWidth : integer = 0); 
    var Column : integer; 
        Wdth : integer; 
    begin 
      AtColNumber := abs(AtColNumber); 
      SG.ColCount := SG.ColCount + 1; 
      if abs(ColWidth) = 0 then 
         Wdth := SG.DefaultColWidth 
      else 
         Wdth := ColWidth; 
     
      if AtColNumber <= SG.ColCount then begin 
        for Column := SG.ColCount - 1 downto AtColNumber + 1 do begin 
          SG.Cols[Column].Assign(SG.Cols[Column - 1]); 
          SG.Colwidths[Column] := SG.Colwidths[Column - 1]; 
        end; 
     
        SG.Cols[AtColNumber].Text := ''; 
        SG.Colwidths[AtColNumber] := Wdth; 
      end;   
    end; 

