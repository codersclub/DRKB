---
Title: Как в TDBGrid узнать, над каким полем висит мышь?
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Как в TDBGrid узнать, над каким полем висит мышь?
=================================================

    var
      ScrPt, GrdPt: TPoint;
      Cell: TGridCoord;
    begin
      ScrPt := Mouse.CursorPos;
      GrdPt := DBGrid.ScreenToClient(ScrPt);
      Cell := DBGrid.MouseCoord(GrdPt.X, GrdPt.Y);
      // Col := Cell.X;
      // Row := Cell.Y;
    end;
     
     ...
     FieldText: string;
     DLink: TDataLink;
     OldActiveRec: Integer;
     ... 
     Cell := DBGrid.MouseCoord(GrdPt.X, GrdPt.Y);
     FieldText := '';   
     DLink := THackDBGrid(DBGrid).DataLink;
     if Assigned(DLink) then
     begin
       if (Cell.X < = 0)or(Cell.Y < = 0) then Exit;
       OldActiveRec := DLink.ActiveRecord;
       try
         DLink.ActiveRecord := Cell.Y-1{TitleOffset};
         FieldText := DBGrid.Columns[Cell.X-1{IndicatorOffset}].Field.Text;
       finally
         DLink.ActiveRecord := OldActiveRec;
       end;
     end;

