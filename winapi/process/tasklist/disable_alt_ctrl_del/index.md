---
Title: Disable Ctrl+Alt+Del under Windows XP
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---

Disable Ctrl+Alt+Del under Windows XP
=====================================

    procedure DisableTaskMgr(bTF: Boolean);
    var
      reg: TRegistry;
    begin
      reg := TRegistry.Create;
      reg.RootKey := HKEY_CURRENT_USER;
     
      reg.OpenKey('Software', True);
      reg.OpenKey('Microsoft', True);
      reg.OpenKey('Windows', True);
      reg.OpenKey('CurrentVersion', True);
      reg.OpenKey('Policies', True);
      reg.OpenKey('System', True);
     
      if bTF = True then
      begin
        reg.WriteString('DisableTaskMgr', '1');
      end
      else if bTF = False then
      begin
        reg.DeleteValue('DisableTaskMgr');
      end;
      reg.CloseKey;
    end;
     
    // Example Call:
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      DisableTaskMgr(True);
    end;

