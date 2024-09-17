---
Title: Считать значение REG\_DWORD из реестра
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch>
---

Считать значение REG\_DWORD из реестра
======================================

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

