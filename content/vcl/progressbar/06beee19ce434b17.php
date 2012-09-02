<h1>TProgressBar в колонке TListView</h1>
<div class="date">01.01.2007</div>


<pre>
procedure TForm1.Button1Click(Sender: TObject); 
var 
  r: TRect; 
  pb: TProgressBar; 
begin 
  Listview1.Columns.Add.Width := 100; 
  Listview1.Columns.Add.Width := 200; 
  Listview1.ViewStyle         := vsReport; 
  Listview1.Items.Add.Caption := 'Text'; 
 
  r := Listview1.Items[0].DisplayRect(drBounds); 
  r.Left  := r.Left + Listview1.columns[0].Width; 
  r.Right := r.Left + Listview1.columns[1].Width; 
 
  pb := TProgressBar.Create(Self); 
  pb.Parent := Listview1; 
  pb.BoundsRect := r; 
  pb.Position := 30; 
  Listview1.Items[0].Data := pb; 
end; 
 
 
// Change the ProgressBar Position 
// ProgressBar Position andern 
 
procedure TForm1.Button2Click(Sender: TObject); 
var 
  pb: TProgressBar; 
begin 
  pb := TProgressBar(Listview1.Items[0].Data); 
  pb.StepIt; 
end;
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>

