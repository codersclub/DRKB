---
Title: Как изменить цвет отмеченных записей в TDBGrid?
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Как изменить цвет отмеченных записей в TDBGrid?
===============================================

    DefaultDrawing := False;
    ...
     
    procedure TfrmCard.GridDrawColumnCell(Sender: TObject; const Rect: TRect;
    DataCol: Integer; Column: TColumn; State: TGridDrawState);
    var
      index: Integer;
      Marked, Selected: Boolean;
    begin
      Marked := False;
      if (dgMultiSelect in Grid.Options) and (THackDBGrid(Grid).Datalink.Active) then
        Marked := Grid.SelectedRows.Find(THackDBGrid(Grid).Datalink.Datasource.Dataset.Bookmark, index);
      Selected := (THackDBGrid(Grid).Datalink.Active) and (Grid.Row-1 = THackDBGrid(Grid).Datalink.ActiveRecord);
     
      if Marked then
      begin
        Grid.Canvas.Brush.Color:=$DFEFDF;;
        Grid.Canvas.Font.Color :=clBlack;
      end;
     
      if Selected then
      begin
        Grid.Canvas.Brush.Color:=$FFFBF0;
        Grid.Canvas.Font.Color :=clBlack;
        if Marked then
          Grid.Canvas.Brush.Color:=$EFE3DF; { $8F8A30 }
      end;
      Grid.DefaultDrawColumnCell(Rect, DataCol, Column, State);
    end;
     
    где: 
     
    THackDBGrid = class(TDBGrid)
      property DataLink;
      property UpdateLock;
    end;

