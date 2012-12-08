---
Title: Как обновить рабочий стол?
Author: neutrino
Date: 01.01.2007
---


Как обновить рабочий стол?
==========================

::: {.date}
01.01.2007
:::

    procedure RefreshDesktop;

     
    var
      c1 : cardinal;
    begin
    c1:=FindWindowEx(FindWindowEx(FindWindow('Progman','Program Manager'),,'SHELLDLL_DefView',''),0,'SysListView32','');
    PostMessage(c1,WM_KEYDOWN,VK_F5,0);
    PostMessage(c1,WM_KEYUP,VK_F5,1 shl 31);
    end;

Автор: neutrino

Взято с Vingrad.ru <https://forum.vingrad.ru>

------------------------------------------------------------------------

    winexec(Pchar( 'rundll32 user,repaintscreen' ),sw_Show);

Автор: Radmin

Взято с Vingrad.ru <https://forum.vingrad.ru>

------------------------------------------------------------------------

    procedure TForm1.Button1Click(Sender: TObject); 
    begin 
      SendMessage(FindWindow('Progman', 'Program Manager'), 
                  WM_COMMAND, 
                  $A065, 
                  0); 
    end;

Взято из <https://forum.sources.ru>

------------------------------------------------------------------------

    uses
       ShlObj;
     
     procedure RefreshDesktop1;
     begin
       SHChangeNotify(SHCNE_ASSOCCHANGED, SHCNF_IDLIST, nil, nil);
     end;
     

Взято с сайта: <https://www.swissdelphicenter.ch>

------------------------------------------------------------------------

Обновить иконки на экране

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
           if strDataRet <> '' then
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

Взято с сайта: <https://www.swissdelphicenter.ch>

 
