<h1>Как узнать количество CD в системе?</h1>
<div class="date">01.01.2007</div>


<pre>
function GetNumberOfCDDrives: Byte;
 var
   drivemap, mask: DWORD;
   i: integer;
   root: string;
 begin
   Result := 0;
   root := 'A:\';
   drivemap := GetLogicalDrives;
   mask := 1;
   for i := 1 to 32 do
   begin
     if (mask and drivemap) &lt;&gt; 0 then
       if GetDriveType(PChar(root)) = DRIVE_CDROM then
       begin
         Inc(Result);
       end;
     mask := mask shl 1;
     Inc(root[1]);
   end;
 end;
 
 procedure TForm1.Button1Click(Sender: TObject);
 begin
   Label1.Caption := IntToStr(GetNumCDDrives);
 end;
</pre>
<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>
