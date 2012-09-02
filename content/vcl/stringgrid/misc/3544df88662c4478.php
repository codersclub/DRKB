<h1>OnColumnClick из TListView для TStringGrid</h1>
<div class="date">01.01.2007</div>


<pre>
{ 
 There are two routines to implement the OnColumnClick Methods for a TStringGrid. 
 Set the first row as fixed and the Defaultdrawing to True. 
}
 
 
 type
   TForm1 = class(TForm)
     StringGrid1: TStringGrid;
     procedure StringGrid1MouseDown(Sender: TObject; Button: TMouseButton;
       Shift: TShiftState; X, Y: Integer);
     procedure StringGrid1MouseUp(Sender: TObject; Button: TMouseButton;
       Shift: TShiftState; X, Y: Integer);
   private
     zelle: TRect; // cell 
    acol, arow: Integer;
   public
   end;
 
 var
   Form1: TForm1;
 
 implementation
 
 {$R *.DFM}
 
 procedure TForm1.StringGrid1MouseDown(Sender: TObject; Button: TMouseButton;
   Shift: TShiftState; X, Y: Integer);
 var
   Text: string;
 begin
   with stringgrid1 do
   begin
     MouseRoCell(x, y, acol, arow);
     if (arow = 0) and (button = mbleft) then
       case acol of
         0..2:
           begin
             // Draws a 3D Effect (Push) 
            // Zeichnet 3D-Effekt (Push) 
            zelle := CellRect(acol, arow);
             Text := Cells[acol, arow];
             Canvas.Font := Font;
             Canvas.Brush.Color := clBtnFace;
             Canvas.FillRect(zelle);
             Canvas.TextRect(zelle, zelle.Left + 2, zelle.Top + 2, Text);
             DrawEdge(Canvas.Handle, zelle, 10, 2 or 4 or 8);
             DrawEdge(Canvas.Handle, zelle, 2 or 4, 1);
           end;
       end;
   end;
 end;
 
 procedure TForm1.StringGrid1MouseUp(Sender: TObject; Button: TMouseButton;
   Shift: TShiftState; X, Y: Integer);
 var
   Text: string;
 begin
   with StringGrid1 do
   begin
     // Draws a 3D-Effect (Up) 
    // Zeichnet 3D-Effekt (Up) 
    Text := Cells[acol, arow];
     if arow = 0 then
     begin
       Canvas.Font := Font;
       Canvas.Brush.Color := clBtnFace;
       Canvas.FillRect(zelle);
       Canvas.TextRect(zelle, zelle.Left + 2, zelle.Top + 2, Text);
       DrawEdge(Canvas.Handle, zelle, 4, 4 or 8);
       DrawEdge(Canvas.Handle, zelle, 4, 1 or 2);
       MouseToCell(zelle.Left, zelle.Top, acol, arow);
     end;
   end;
   if (arow = 0) and (Button = mbleft) then
     case acol of
       0..2:
         begin
           // Code to be executed... 
          // Programmcode der ausgefuhrt werden soll 
          ShowMessage('Column ' + IntToStr(acol));
           zelle := stringgrid1.CellRect(1, 1);
         end;
     end;
 end;
 
 end.
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
