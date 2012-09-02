<h1>Как скопировать файл в Windows clipboard?</h1>
<div class="date">01.01.2007</div>


<pre>
uses 
  ShlObj, ClipBrd; 
 
procedure CopyFilesToClipboard(FileList: string); 
var 
  DropFiles: PDropFiles; 
  hGlobal: THandle; 
  iLen: Integer; 
begin 
  iLen := Length(FileList) + 2; 
  FileList := FileList + #0#0; 
  hGlobal := GlobalAlloc(GMEM_SHARE or GMEM_MOVEABLE or GMEM_ZEROINIT, 
    SizeOf(TDropFiles) + iLen); 
  if (hGlobal = 0) then raise Exception.Create('Could not allocate memory.'); 
  begin 
    DropFiles := GlobalLock(hGlobal); 
    DropFiles^.pFiles := SizeOf(TDropFiles); 
    Move(FileList[1], (PChar(DropFiles) + SizeOf(TDropFiles))^, iLen); 
    GlobalUnlock(hGlobal); 
    Clipboard.SetAsHandle(CF_HDROP, hGlobal); 
  end; 
end; 
 
// Example, Beispiel: 
 
procedure TForm1.Button1Click(Sender: TObject); 
begin 
  CopyFilesToClipboard('C:\Bootlog.Txt'#0'C:\AutoExec.Bat'); 
end; 
</pre>


<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
