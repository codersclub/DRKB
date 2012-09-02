<h1>Сохранить и загрузить TTreeView</h1>
<div class="date">01.01.2007</div>


<pre>
{ 
  Treeview1.SaveToFile('...') doesn't store images. 
  Instead, use the code below. 
}
 
 
 // Save 
 
procedure TForm1.Button1Click(Sender: TObject);
 var
   F: TFileStream;
 begin
   F := TFileStream.Create('c:\TreeView.txt', fmCreate or fmShareCompat);
   try
     F.WriteComponent(TreeView1);
   finally
     F.Free;
   end;
 end;
 
 
 // Load 
 
procedure TForm1.Button2Click(Sender: TObject);
 var
   F: TFileStream;
 begin
   F := TFileStream.Create('c:\TreeView.txt', fmOpenRead or fmShareDenyWrite);
   try
     F.ReadComponent(TreeView1);
   finally
     F.Free;
   end;
 end;
</pre>
<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>
