<h1>Получить путь к выделенному файлу в TShellListView</h1>
<div class="date">01.01.2007</div>


<pre>Label1.Caption := ShellListView1.Folders[ShellListView1.ItemIndex].PathName
 
 {**************************************************************}
 
 { 
  To retrieve full paths to each file selected files: 
}
 
 var
   path: string;
 begin
   for i:=0 to ShellListView1.SelCount-1 do
   begin
     path := ShellListView1.Folders[ShellListView1.GetNextItem(ShellListView1.Selected,
               sdAll,[isSelected]).Index+i-1].PathName;
     // ... 
  end;
 end
</pre>

<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>
