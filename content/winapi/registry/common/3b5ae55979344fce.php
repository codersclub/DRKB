<h1>Считать значение REG_DWORD из реестра</h1>
<div class="date">01.01.2007</div>


<pre>
uses
   Registry;
 
 // Read REG_DWORD 
procedure TForm1.Button1Click(Sender: TObject);
 var
   Reg: TRegistry;
   RegKey: DWORD;
   Key: string;
 begin
   Reg := TRegistry.Create;
   try
     Reg.RootKey := HKEY_USERS;
     Key := '.DEFAULT\Software\Microsoft\Windows\CurrentVersion\Internet Settings\URL History';
     if Reg.OpenKeyReadOnly(Key) then
     begin
       if Reg.ValueExists('DaysToKeep') then
       begin
         RegKey := Reg.ReadInteger('DaysToKeep');
         Reg.CloseKey;
         ShowMessage(IntToStr(RegKey));
       end;
     end;
   finally
     Reg.Free
   end;
 end;
 
 
 // Write REG_DWORD 
procedure TForm1.Button2Click(Sender: TObject);
 var
   Reg: TRegistry;
   Key: string;
 begin
   Reg := TRegistry.Create;
   try
     Reg.RootKey := HKEY_USERS;
     Key := '.DEFAULT\Software\Microsoft\Windows\CurrentVersion\Internet Settings\URL History';
     if Reg.OpenKey(Key, True) then
     begin
       Reg.WriteInteger('DaysToKeep', 20);
       Reg.CloseKey;
     end;
   finally
     Reg.Free
   end;
 end;
 
</pre>
<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>
