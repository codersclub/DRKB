<h1>Как обновить рабочий стол?</h1>
<div class="date">01.01.2007</div>


<pre>
procedure RefreshDesktop;

 
var
  c1 : cardinal;
begin
c1:=FindWindowEx(FindWindowEx(FindWindow('Progman','Program Manager'),,'SHELLDLL_DefView',''),0,'SysListView32','');
PostMessage(c1,WM_KEYDOWN,VK_F5,0);
PostMessage(c1,WM_KEYUP,VK_F5,1 shl 31);
end;
</pre>
<p class="author">Автор: neutrino </p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
<hr />
<pre>
winexec(Pchar( 'rundll32 user,repaintscreen' ),sw_Show);
</pre>

<p class="author">Автор: Radmin</p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
<hr />
<pre>
procedure TForm1.Button1Click(Sender: TObject); 
begin 
  SendMessage(FindWindow('Progman', 'Program Manager'), 
              WM_COMMAND, 
              $A065, 
              0); 
end;
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
<hr />
<pre>
uses
   ShlObj;
 
 procedure RefreshDesktop1;
 begin
   SHChangeNotify(SHCNE_ASSOCCHANGED, SHCNF_IDLIST, nil, nil);
 end;
 
</pre>
<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>
<hr />
<p class="p_Heading1">Обновить иконки на экране </p>
<pre>
{ 
  Microsoft's Tweak UI has a feature 'rebuild icon cache now'. 
  Windows then rebuilds its internal cache of icons. 
  Unfortunately, there is no single API to do this. 
}
 
 uses
   Registry;
 
 function RefreshScreenIcons : Boolean;
 const
   KEY_TYPE = HKEY_CURRENT_USER;
   KEY_NAME = 'Control Panel\Desktop\WindowMetrics';
   KEY_VALUE = 'Shell Icon Size';
 var
   Reg: TRegistry;
   strDataRet, strDataRet2: string;
 
  procedure BroadcastChanges;
  var
    success: DWORD;
  begin
    SendMessageTimeout(HWND_BROADCAST,
                       WM_SETTINGCHANGE,
                       SPI_SETNONCLIENTMETRICS,
                       0,
                       SMTO_ABORTIFHUNG,
                       10000,
                       success);
  end;
 
 
 begin
   Result := False;
   Reg := TRegistry.Create;
   try
     Reg.RootKey := KEY_TYPE;
     // 1. open HKEY_CURRENT_USER\Control Panel\Desktop\WindowMetrics 
    if Reg.OpenKey(KEY_NAME, False) then
     begin
       // 2. Get the value for that key 
      strDataRet := Reg.ReadString(KEY_VALUE);
       Reg.CloseKey;
       if strDataRet &lt;&gt; '' then
       begin
         // 3. Convert sDataRet to a number and subtract 1, 
        //    convert back to a string, and write it to the registry 
        strDataRet2 := IntToStr(StrToInt(strDataRet) - 1);
         if Reg.OpenKey(KEY_NAME, False) then
         begin
           Reg.WriteString(KEY_VALUE, strDataRet2);
           Reg.CloseKey;
           // 4. because the registry was changed, broadcast 
          //    the fact passing SPI_SETNONCLIENTMETRICS, 
          //    with a timeout of 10000 milliseconds (10 seconds) 
          BroadcastChanges;
           // 5. the desktop will have refreshed with the 
          //    new (shrunken) icon size. Now restore things 
          //    back to the correct settings by again writing 
          //    to the registry and posing another message. 
          if Reg.OpenKey(KEY_NAME, False) then
           begin
             Reg.WriteString(KEY_VALUE, strDataRet);
             Reg.CloseKey;
             // 6.  broadcast the change again 
            BroadcastChanges;
             Result := True;
           end;
         end;
       end;
     end;
   finally
     Reg.Free;
   end;
 end;
 
 procedure TForm1.Button1Click(Sender: TObject);
 begin
   RefreshScreenIcons
 end;
 
 
 { 
  The result is Window's erasing all its icons, and recalculating them 
  based on the registry settings. 
  This means if you have changed a DefaultIcon key within the registry for 
  some application or file, Windows will display the new icon when the 
  refresh is completed. 
 
  Original source: 
  www.mvps.org/vbnet/index.html?code/reg/screenrefresh.htm 
  Translated from VB by Thomas Stutz 
}
</pre>
<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>
<p class="p_Heading1">&nbsp;</p>
