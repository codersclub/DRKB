<h1>Копировать и вставлять ячейки TStringGrid в буфер обмена</h1>
<div class="date">01.01.2007</div>


<pre>
uses
   Clipbrd;
 
 //Copy 
procedure TForm1.Button1Click(Sender: TObject);
 var
   S: string;
   GRect: TGridRect;
   C, R: Integer;
 begin
   GRect := StringGrid1.Selection;
   S  := '';
   for R := GRect.Top to GRect.Bottom do
   begin
     for C := GRect.Left to GRect.Right do
     begin
       if C = GRect.Right then  S := S + (StringGrid1.Cells[C, R])
       else
         S := S + StringGrid1.Cells[C, R] + #9;
     end;
     S := S + #13#10;
 end;
   ClipBoard.AsText := S;
 end;
 
 // Paste 
procedure TForm1.Button2Click(Sender: TObject);
 var
   Grect: TGridRect;
   S, CS, F: string;
   L, R, C: Byte;
 begin
   GRect := StringGrid1.Selection;
   L := GRect.Left;
   R := GRect.Top;
   S := ClipBoard.AsText;
   R := R - 1;
   while Pos(#13, S) &gt; 0 do
   begin
     R  := R + 1;
     C  := L - 1;
     CS := Copy(S, 1,Pos(#13, S));
     while Pos(#9, CS) &gt; 0 do
     begin
       C := C + 1;
       if (C &lt;= StringGrid1.ColCount - 1) and (R &lt;= StringGrid1.RowCount - 1) then
         StringGrid1.Cells[C, R] := Copy(CS, 1,Pos(#9, CS) - 1);
       F := Copy(CS, 1,Pos(#9, CS) - 1);
       Delete(CS, 1,Pos(#9, CS));
     end;
     if (C &lt;= StringGrid1.ColCount - 1) and (R &lt;= StringGrid1.RowCount - 1) then
       StringGrid1.Cells[C + 1,R] := Copy(CS, 1,Pos(#13, CS) - 1);
     Delete(S, 1,Pos(#13, S));
     if Copy(S, 1,1) = #10 then
       Delete(S, 1,1);
   end;
 end;
</pre>
<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>
<hr />
<p class="p_Heading1">Как скопировать выбранные в DBGrid записи в клипборд </p>
<p class="author">Автор: Тенцер А.Л. </p>
<pre>
const
 FIELD_DELIMITER = #9;
 RECORD_DELIMITER = #10;
 
 
procedure CopyDBGridToClipboard( Grid : TDBGrid );
var
 BM : String;
 S : String;
 S1: String;
 I : Integer;
begin
 with Grid  do begin
  if Assigned( DataSource ) and
     Assigned( DataSource.DataSet ) and
     DataSource.DataSet.Active then
  with DataSource.DataSet do begin
   S := '';
   DisableControls;
   BM := BookMark;
   for I := 0 to Pred( Columns.Count ) do begin
    if Assigned(Columns.Items[I].Field) then
      S := S + Columns.Items[I].Title.Caption + FIELD_DELIMITER;
   end;
   S[ Length( S ) ] := RECORD_DELIMITER;
   First;
   while not Eof do begin
    S1 := '';
    for I := 0 to Pred( Columns.Count ) do begin
      if Assigned(Columns.Items[I].Field) then
        S1 := S1 + FieldByName( Columns[I].FieldName ).AsString +
FIELD_DELIMITER;
    end;
    S1[ Length( S1 ) ] := RECORD_DELIMITER;
    S := S + S1;
    Next;
   end;
   BookMark := BM;
   EnableControls;
//   Clipboard.SetTextBuf( PChar( S ) );
   SendToClipboard( S );
  end;
 end;
end;
 
 
 
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>

