---
Title: Как определить, установлен ли IE?
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Как определить, установлен ли IE?
=================================

    uses 
      registry; 
     
    function IE_installed(var Version: string): Boolean; 
    var 
      Reg: TRegistry; 
    begin 
      Reg := TRegistry.Create; 
      with Reg do 
      begin 
        RootKey := HKEY_LOCAL_MACHINE; 
        OpenKey('Software\Microsoft\Internet Explorer', False); 
        if ValueExists('Version') then 
          Version := ReadString('Version') 
        else 
          Version := ''; 
        CloseKey; 
        Free; 
      end; 
      Result := Version <> ''; 
    end; 
     
    procedure TForm1.Button1Click(Sender: TObject); 
    var 
      IE_Version: string; 
    begin 
      if IE_Installed(IE_Version) then 
        ShowMessage(Format('Internet Explorer %s installed.', [IE_Version])); 
    end; 

