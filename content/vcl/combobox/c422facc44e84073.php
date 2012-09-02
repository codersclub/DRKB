<h1>Несколько колонок в TComboBox</h1>
<div class="date">01.01.2007</div>

</p>
<pre>
procedure TForm1.ComboBox1DrawItem(Control: TWinControl; 
  Index: Integer; Rect: TRect; State: TOwnerDrawState); 
var 
  strVal, strAll: string; 
  pos1, pos2: Integer; 
  rc: TRect; 
  arrWidth: array [0..3] of Integer; 
begin 
  Combobox1.Canvas.Brush.Style := bsSolid; 
  Combobox1.Canvas.FillRect(Rect); 
  // the columns must be separated by ';' 
  strAll := Combobox1.Items[Index]; 
 
  arrWidth[0] := 0; 
  arrWidth[1] := 100;  // Width of column 1 
  arrWidth[2] := 200;  // Width of column 2 
  arrWidth[3] := 300;  // Width of colimn 3 
 
  // Drawingrange for first column 
  rc.Left   := Rect.Left + arrWidth[0] + 2; 
  rc.Right  := Rect.Left + arrWidth[1] - 2; 
  rc.Top    := Rect.Top; 
  rc.Bottom := Rect.Bottom; 
 
  // Get text for first column 
  pos1   := Pos(';', strAll); 
  strVal := Copy(strAll, 1, pos1 - 1); 
  // Draw Text 
  Combobox1.Canvas.TextRect(rc, rc.Left, rc.Top, strVal); 
  // Draw separating line betwenn columns 
  Combobox1.Canvas.MoveTo(rc.Right, rc.Top); 
  Combobox1.Canvas.LineTo(rc.Right, rc.Bottom); 
 
  // Drawingrange for second column 
  rc.Left  := Rect.Left + arrWidth[1] + 2; 
  rc.Right := Rect.Left + arrWidth[2] - 2; 
 
  // Text fur zweite Spalte ausfiltern 
  // Get text for second column 
  strAll := Copy(strAll, pos1 + 1, Length(strAll) - pos1); 
  pos1   := Pos(';', strAll); 
  strVal := Copy(strAll, 1, pos1 - 1); 
 
  // Text ausgeben 
  // Draw Text 
  Combobox1.Canvas.TextRect(rc, rc.Left, rc.Top, strVal); 
  // Trennlinie zwischen Spalten zeichnen 
  // Draw separating line betwenn columns 
  Combobox1.Canvas.MoveTo(rc.Right, rc.Top); 
  Combobox1.Canvas.LineTo(rc.Right, rc.Bottom); 
 
  // Drawingrange for third column 
  rc.Left  := Rect.Left + arrWidth[2] + 2; 
  rc.Right := Rect.Left + arrWidth[3] - 2; 
 
  // Get text for third column 
  strAll := Copy(strAll, pos1 + 1, Length(strAll) - pos1); 
  pos1   := Pos(';', strAll); 
  strVal := Copy(strAll, 1, pos1 - 1); 
 
  // Draw Text 
  Combobox1.Canvas.TextRect(rc, rc.Left, rc.Top, strVal); 
  // Draw separating line betwenn columns 
  Combobox1.Canvas.MoveTo(rc.Right, rc.Top); 
  Combobox1.Canvas.LineTo(rc.Right, rc.Bottom); 
  strAll := Copy(strAll, pos1 + 1, Length(strAll) - pos1); 
end; 
 
 
// Example/ Beispiel: 
 
procedure TForm1.Button1Click(Sender: TObject); 
begin 
  with Combobox1.Items do 
  begin 
    Add('first;second;third;'); 
    Add('column1;column2;column3;'); 
  end; 
end; 
 
 
procedure TForm1.FormCreate(Sender: TObject); 
begin 
  //Oder im Objekt Inspektor einstellen 
  //Or set this Property in the Object Inspector 
  Combobox1.Style := csOwnerDrawFixed; 
end;
</pre>

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>

