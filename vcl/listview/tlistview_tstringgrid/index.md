---
Title: Экспорт TListView в TStringGrid
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch>
---


Экспорт TListView в TStringGrid
===============================

    procedure ListView2StringGrid(Listview: TListView; StringGrid: TStringGrid);
    const
      MAX_SUBITEMS = 5;
    var
      i, j: Integer;
    begin
      with ListView do
        for i := 0 to Items.Count - 1 do
        begin
          {Get Item of First Column}
          StringGrid.Cells[1, i + 1] := Items[i].Caption;
          {loop through SubItems}
          for j := 0 to MAX_SUBITEMS do
          begin
            if Items[i].SubItems.Count > j then
              StringGrid.Cells[j + 2, i + 1] := Items[i].SubItems.Strings[j]
            else
               break;
          end;
        end;
    end;
    
    procedure TForm1.Button1Click(Sender: TObject);
    var
      i: Integer;
    begin
      // Clear the StringGrid if necessary 
      // Falls notig, zuerst das StringGrid loschen 
      i := 0;
      while i < StringGrid1.RowCount do
      begin
        StringGrid1.Rows[i].Clear;
        Inc(i);
      end;
      // Copy ListView1 to StringGrid1 
      ListView2StringGrid(ListView1, StringGrid1);
    end;

