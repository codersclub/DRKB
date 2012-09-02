<h1>Как в TDBGrid узнать, над каким полем висит мышь?</h1>
<div class="date">01.01.2007</div>


<pre>
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
   if (Cell.X &lt; = 0)or(Cell.Y &lt; = 0) then Exit;
   OldActiveRec := DLink.ActiveRecord;
   try
     DLink.ActiveRecord := Cell.Y-1{TitleOffset};
     FieldText := DBGrid.Columns[Cell.X-1{IndicatorOffset}].Field.Text;
   finally
     DLink.ActiveRecord := OldActiveRec;
   end;
 end;
</pre>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>

