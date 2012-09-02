<h1>Как шифровать файлы при помощи Windows NTFS API?</h1>
<div class="date">01.01.2007</div>


<pre>
{
This tip works with Windows 2000 (NTFS 5) and later
 
These 2 functions are defined in windows.pas, but they're defined wrong. In this
case our own definition.
}
 
function EncryptFile(lpFilename: PChar): BOOL; stdcall;
  external advapi32 name 'EncryptFileA';
 
function DecryptFile(lpFilename: PChar; dwReserved: DWORD): BOOL; stdcall;
  external advapi32 name 'DecryptFileA';
 
{....}
 
procedure TForm1.Button1Click(Sender: TObject);
begin
  if not EncryptFile('c:\temp') then
    ShowMessage('Cannot encrypt directory.');
end;
 
procedure TForm1.Button2Click(Sender: TObject);
begin
  if not DecryptFile('c:\temp', 0) then
    ShowMessage('Cannot decrypt directory.');
end;
</pre>
<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>
