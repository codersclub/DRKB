<h1>Взять все расширения из реестра и их описание</h1>
<div class="date">01.01.2007</div>


<pre>
{ 
 This Code will return the programs associated with each extension. 
 You can obviously modify it to search for a specific extension. 
}
 
 uses Registry;
 
 procedure TForm1.Button1Click(Sender: TObject);
 var
   reg: TRegistry;
   keys: TStringList;
   i: Integer;
   typename, displayname, server: string;
 begin
   memo1.Clear;
   reg := TRegistry.Create;
   try
     reg.rootkey := HKEY_CLASSES_ROOT;
     if reg.OpenKey('', False) then
     begin
       keys := TStringList.Create;
       try
         reg.GetKeyNames(keys);
         reg.CloseKey;
         {memo1.lines.addstrings(keys);}
         for i := 0 to keys.Count - 1 do
         begin
           if keys[i][1] = '.' then
           begin
             {this is an extension, get its typename}
             if reg.OpenKey(keys[i], False) then
             begin
               typename := reg.ReadString('');
               reg.CloseKey;
               if typename &lt;&gt; '' then
               begin
                 if reg.OpenKey(typename, False) then
                 begin
                   displayname := reg.ReadString('');
                   reg.CloseKey;
                 end;
                 if reg.OpenKey(typename + '\shell\open\command', False) then
                 begin
                   server := reg.ReadString('');
                   memo1.Lines.Add(Format('Extension: "%s", Typename: "%s", Displayname:"%s"' +
                                          #13#10'  Server: %s',
                                          [keys[i], typename, displayname, server]));
                   reg.CloseKey;
                 end;
               end;
             end;
           end;
         end;
       finally
         keys.Free;
       end;
     end;
   finally
     reg.Free
   end;
 end;
</pre>
<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>

