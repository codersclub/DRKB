<h1>Сохранение и чтение TStringGrid</h1>
<div class="date">01.01.2007</div>


<pre>
procedure SaveGrid;
var
  f: textfile;
  x, y: integer;
begin
  assignfile(f, 'Filename');
  rewrite(f);
  writeln(f, stringgrid.colcount);
  writeln(f, stringgrid.rowcount);
  for X := 0 to stringgrid.colcount - 1 do
    for y := 0 to stringgrid.rowcount - 1 do
      writeln(F, stringgrid.cells[x, y]);
  closefile(f);
end;
</pre>
<pre>
procedure LoadGrid;
var
  f: textfile;
  temp, x, y: integer;
  tempstr: string;
begin
  assignfile(f, 'Filename');
  reset(f);
  readln(f, temp);
  stringgrid.colcount := temp;
  readln(f, temp);
  stringgrid.rowcount := temp;
  for X := 0 to stringgrid.colcount - 1 do
    for y := 0 to stringgrid.rowcount - 1 do
    begin
      readln(F, tempstr);
      stringgrid.cells[x, y] := tempstr;
    end;
  closefile(f);
end;
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
</p>
<hr />
<pre>
// Save a TStringGrid to a file 
 
procedure SaveStringGrid(StringGrid: TStringGrid; const FileName: TFileName);
 var
   f:    TextFile;
   i, k: Integer;
 begin
   AssignFile(f, FileName);
   Rewrite(f);
   with StringGrid do
   begin
     // Write number of Columns/Rows 
    Writeln(f, ColCount);
     Writeln(f, RowCount);
     // loop through cells 
    for i := 0 to ColCount - 1 do
       for k := 0 to RowCount - 1 do
         Writeln(F, Cells[i, k]);
   end;
   CloseFile(F);
 end;
 
 // Load a TStringGrid from a file 
 
procedure LoadStringGrid(StringGrid: TStringGrid; const FileName: TFileName);
 var
   f:          TextFile;
   iTmp, i, k: Integer;
   strTemp:    String;
 begin
   AssignFile(f, FileName);
   Reset(f);
   with StringGrid do
   begin
     // Get number of columns 
    Readln(f, iTmp);
     ColCount := iTmp;
     // Get number of rows 
    Readln(f, iTmp);
     RowCount := iTmp;
     // loop through cells &amp; fill in values 
    for i := 0 to ColCount - 1 do
       for k := 0 to RowCount - 1 do
       begin
         Readln(f, strTemp);
         Cells[i, k] := strTemp;
       end;
   end;
   CloseFile(f);
 end;
 
 
 // Save StringGrid1 to 'c:\temp.txt': 
 
procedure TForm1.Button1Click(Sender: TObject);
 begin
   SaveStringGrid(StringGrid1, 'c:\temp.txt');
 end;
 
 // Load StringGrid1 from 'c:\temp.txt': 
 
procedure TForm1.Button2Click(Sender: TObject);
 begin
   LoadStringGrid(StringGrid1, 'c:\temp.txt');
 end;
 
 
</pre>
<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>
