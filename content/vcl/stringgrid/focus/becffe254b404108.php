<h1>Позиционирование каретки в TStringGrid</h1>
<div class="date">01.01.2007</div>


<pre>
{ 
  The following code allows you to position the caret 
  in a cell (InplaceEditor) of a StringGrid. 
  We need a Cracker class to access the InplaceEditor. 
 
}
 
 type
   TGridCracker = class(TStringGrid);
 
    {...}
 
 implementation
 
 {...}
 
 procedure SetCaretPosition(Grid: TStringGrid; col, row, x_pos: Integer);
 begin
   Grid.Col := Col;
   Grid.Row := Row;
   with TGridCracker(Grid) do
     InplaceEditor.SelStart := x_pos;
 end;
 
 // Get the Caret position from the focussed cell 
// Ermittelt die Caret-Position der aktuellen Zelle 
function GetCaretPosition(Grid: TStringGrid): Integer;
 begin
   with TGridCracker(Grid) do
     Result := InplaceEditor.SelStart;
 end;
 
 // Example / Beispiel: 
 
// Set the focus on col 1, row 3 and position the caret at position 5 
// Fokusiert die Zelle(1,3) und setzt den Cursor auf Position 5 
 
procedure TForm1.Button1Click(Sender: TObject);
 begin
   StringGrid1.SetFocus;
   SetCaretPosition(StringGrid1, 1, 3, 5);
 end;
</pre>
<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>
