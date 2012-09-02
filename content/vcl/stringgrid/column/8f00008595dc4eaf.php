<h1>Удаление колонки в TStringGrid</h1>
<div class="date">01.01.2007</div>


<pre>
Procedure GridRemoveColumn(StrGrid: TStringGrid; DelColumn: Integer); 
Var Column: Integer; 
begin 
  If DelColumn &lt;= StrGrid.ColCount then 
  Begin 
    For Column := DelColumn To StrGrid.ColCount-1 do 
      StrGrid.Cols[Column-1].Assign(StrGrid.Cols[Column]); 
    StrGrid.ColCount := StrGrid.ColCount-1; 
  End; 
end; 
</pre>
<hr />
<pre>
procedure RemoveColumn(SG : TStringGrid; ColNumber : integer); 
var Column : integer; 
begin 
  ColNumber := abs(ColNumber); 
 
  if ColNumber &lt;= SG.ColCount then begin 
     for Column := ColNumber to SG.ColCount - 2 do begin 
        SG.Cols[Column].Assign(SG.Cols[Column + 1]); 
        SG.Colwidths[Column] := SG.Colwidths[Column + 1]; 
     end; 
     SG.ColCount := SG.ColCount - 1; 
  end; 
end; 
</pre>

<hr />
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>


<pre>
procedure TForm1.Button3Click(Sender: TObject);
var
  i,j: Integer;
begin
  j:=SG1.Row; // строка с выделением
  SG1.Rows[j].Clear;
  for i:=j to SG1.RowCount-2 do
    SG1.Rows[i].Assign(SG1.Rows[i+1]);
  SG1.RowCount:=SG1.RowCount-1;
end;
 
</pre>
<a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>


<hr />
<pre>
type
   TStringGridHack = class(TStringGrid)
   public
     procedure DeleteCol(ACol: Longint);
   end;
 
 var
   Form1: TForm1;
 
 implementation
 
 
 procedure TStringGridHack.DeleteCol(ACol: Longint);
 begin
   if ACol = FixedCols then if ACol = (ColCount - 1) then
     begin
       Cols[ACol].Clear;
       if ColCount(FixedCols + 1) then ColCount := (ColCount - 1);
     end
     else
     begin
       Cols[ACol] := Cols[ACol + 1];
       DeleteCol(ACol + 1);
     end;
 end;
 
</pre>

<a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
