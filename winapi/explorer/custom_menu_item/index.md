---
Title: Как добавить свой пункт меню?
Date: 01.01.2007
Source: Delphi Knowledge Base: <https://www.baltsoft.com/>
---


Как добавить свой пункт меню?
=============================

    function AddMenuItem(ConnType: TconnType; MenuText, StatusBarText,
      GuidOrPath: string; HelpMenu: Boolean): string;
    var
      GUID: TGUID;
      ID: string;
      Reg: TRegistry;
    begin
      CreateGuid(GUID);
      ID := GuidToString(GUID);
      Reg := TRegistry.Create;
      with Reg do
      begin
        RootKey := HKEY_LOCAL_MACHINE;
        OpenKey('\Software\Microsoft\Internet Explorer\Extensions\'
          + ID, True);
        if HelpMenu then
          WriteString('MenuCostumize', 'help');
        WriteString('CLSID', '{1FBA04EE-3024-11d2-8F1F-0000F87ABD16}');
        WriteString('MenuText', MenuText);
        WriteString('MenuStatusBar', StatusBarText);
        case ConnType of
          EXECUTABLE: WriteString('Exec', GuidOrPath);
          COM_OBJECT: WriteString('ClsidExtension', GuidOrPath);
          SCRIPT: WriteString('Script', GuidOrPath);
        end;
        CloseKey;
        OpenKey('\Software\IE5Tools\Menu Items\', True);
        WriteString(MenuText, ID);
        CloseKey;
        Free;
      end;
      Result := ID;
    end;

