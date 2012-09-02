<h1>Как показать Open With диалог?</h1>
<div class="date">01.01.2007</div>


<pre>
{ 
  This code displays the application/file "Open With" dialog 
  Passing the full file path and name as a parameter will cause the 
  dialog to display the line "Click the program you want to use to open 
  the file 'filename'". 
} 
 
uses 
  ShellApi; 
 
procedure OpenWith(FileName: string); 
begin 
  ShellExecute(Application.Handle, 'open', PChar('rundll32.exe'), 
    PChar('shell32.dll,OpenAs_RunDLL ' + FileName), nil, SW_SHOWNORMAL); 
end; 
 
 
procedure TForm1.Button1Click(Sender: TObject); 
begin 
  if Opendialog1.Execute then 
    OpenWith(Opendialog1.FileName); 
end; 
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>

