---
Title: Получить содержимое TStringGrid или TDrawGrid в виде строки
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch>
---


Получить содержимое TStringGrid или TDrawGrid в виде строки
===========================================================

    { 
     This copies the contents of a TstringGrid/TDrawGrid (only Text!!) into a string. 
     Tabs are inserted between the columns, CR+LF between rows. 
    }
     
    use
      Grids;
    
    {...}
    
    { we need this Cracker Class because the Col/RowCount property 
      is not public in TCustomGrid }
    type
      TGridHack = class(TCustomGrid);
    
    function GetstringGridText(_Grid: TCustomGrid): string;
    var
      Grid: TGridHack;
      Row, Col: Integer;
      s: string;
    begin
      // Cast the paramter to a TGridHack, so we can access protected properties 
      Grid   := TGridHack(_Grid);
      Result := '';
      // for all rows, then for all columns 
      for Row := 0 to Grid.RowCount - 1 do
      begin
        for Col := 0 to Grid.ColCount - 1 do
        begin
          // the first column does not need the tab 
          if Col > 0 then
            Result := Result + #9;
          Result := Result + Grid.GetEditText(Col, Row);
        end;
        Result := Result + #13#10;
      end;
    end;

