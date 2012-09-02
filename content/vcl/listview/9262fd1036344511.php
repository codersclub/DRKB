<h1>Сохранить TListView как HTML страницу</h1>
<div class="date">01.01.2007</div>


<pre>
function ListViewConfHTML(Listview:TListview; output:string; center: Boolean) : Boolean;
 var
   i,f: Integer;
   tfile: TextFile;
 begin
   try
     ForceDirectories(ExtractFilePath(output));
     AssignFile(tfile,output);
     ReWrite(tfile);
     WriteLn(tfile,'&lt;html&gt;');
     WriteLn(tfile,'&lt;head&gt;');
     WriteLn(tfile,'&lt;title&gt;HTML-Ansicht: '+listview.Name+'&lt;/title&gt;');
     WriteLn(tfile,'&lt;/head&gt;');
     WriteLn(tfile,'&lt;table border="1" bordercolor="#000000"&gt;');
     WriteLn(tfile,'&lt;tr&gt;');
     for i := 0 to listview.Columns.Count - 1 do
     begin
       if center then
         WriteLn(tfile,'&lt;td&gt;&lt;b&gt;&lt;center&gt;'+listview.columns[i].caption+'&lt;/center&gt;&lt;/b&gt;&lt;/td&gt;') else
         WriteLn(tfile,'&lt;td&gt;&lt;b&gt;'+listview.columns[i].caption+'&lt;/b&gt;&lt;/td&gt;');
     end;
     WriteLn(tfile,'&lt;/tr&gt;');
     WriteLn(tfile,'&lt;tr&gt;');
     for i := 0 to listview.Items.Count-1 do
     begin
       WriteLn(tfile,'&lt;td&gt;'+listview.items.item[i].caption+'&lt;/td&gt;');
       for f := 0 to listview.Columns.Count-2 do
       begin
         if listview.items.item[i].subitems[f]='' then Write(tfile,'&lt;td&gt;-&lt;/td&gt;') else
           Write(tfile,'&lt;td&gt;'+listview.items.item[i].subitems[f]+'&lt;/td&gt;');
       end;
       Write(tfile,'&lt;/tr&gt;');
     end;
     WriteLn(tfile,'&lt;/table&gt;');
     WriteLn(tfile,'&lt;/html&gt;');
     CloseFile(tfile);
     Result := True;
   except
   Result := False;
   end;
 end;
 
 procedure TForm1.Button1Click(Sender: TObject);
 begin
   if ListViewConfHTML(form1.ListView1,'C:\text.html', true) then
     ShowMessage('OK/ Hat geklappt') else
       ShowMessage('Error occured/ Hat nicht geklappt');
 end;
</pre>

<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>
