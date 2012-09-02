<h1>Копирование большого файла в буфер обмена</h1>
<div class="date">01.01.2007</div>

Вот общее решение, которое будет работать, даже если у вас размер файла превышает 64Кб:</p>
<pre>
function _hread(FileHandle: word; BufPtr: pointer;
  ByteCount: longint): longint; far;
  external 'KERNEL' index 349;
 
procedure CopyFileToClipboard(const fname: string);
var
  hmem, hFile: THandle;
  size: LongInt;
  p: Pointer;
begin
  hFile := FileOpen(fname, fmOpenRead);
  try
    size := FileSeek(hFile, 0, 2);
    FileSeek(hfile, 0, 0);
    if size &gt; 0 then
    begin
      hmem := GlobalAlloc(GHND, size);
      if hMem &lt;&gt; 0 then
      begin
        p := GlobalLock(hMem);
        if p &lt;&gt; nil then
        begin
          _hread(hFile, p, size);
          GlobalUnlock(hMem);
          Clipboard.SetAsHandle(CF_TEXT, hMem);
        end
        else
          GlobalFree(hMem);
      end;
    end;
  finally
    FileClose(hFile);
  end;
end;
 
procedure TForm1.SpeedButton2Click(Sender: TObject);
var
  fname: string[128];
begin
  if OpenDialog1.Execute then
  begin
    fname := OpenDialog1.Filename;
    CopyFileToClipboard(fname);
  end;
end;
 
 
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
<p class="note">Примечание Vit</p>
<p>Похоже это актуально только для Windows 3x</p>
