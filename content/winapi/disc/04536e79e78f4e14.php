<h1>Cуществует ли диск в системе?</h1>
<div class="date">01.01.2007</div>


<pre>
function DriveExists (Drive: Byte) : boolean;
begin
  Result := Boolean (GetLogicalDrives and (1 shl Drive));
end;
 
procedure TForm1.Button1Click(Sender : TObject);
  var Drive : byte;
begin
for Drive := 0 to 25 do
  If DriveExists (Drive) then
begin
ListBox1.Items.Add (Chr(Drive+$41));
end;
end;
</pre>
<p class="author">Автор Serious </p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
