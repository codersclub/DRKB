<h1>Как зарегистрировать свое расширение?</h1>
<div class="date">01.01.2007</div>


<pre>
Uses Registry;

 
procedure RegisterFileType(FileType,FileTypeName, Description,ExecCommand:string);
begin
if (FileType='') or (FileTypeName='') or (ExecCommand='') then exit;
if FileType[1]&lt;&gt;'.' then FileType:='.'+FileType;
if Description='' then Description:=FileTypeName;
with Treginifile.create do
try
rootkey := hkey_classes_root;
writestring(FileType,'',FileTypeName);
writestring(FileTypeName,'',Description);
writestring(FileTypeName+'\shell\open\command','',ExecCommand+' "%1"');
finally
free;
end;
end;
 
procedure TForm1.Button1Click(Sender: TObject);
begin
RegisterFileType('txt','TxtFile', 'Plain text','notepad.exe');
end;
</pre>

<div class="author">Автор: Vit</div>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>

