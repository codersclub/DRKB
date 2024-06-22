---
Title: Как узнать версию IE?
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Как узнать версию IE?
=====================

    uses 
      Registry; 
     
    function GetIEVersion(Key: string): string; 
    var 
      Reg: TRegistry; 
    begin 
      Reg := TRegistry.Create; 
      try 
        Reg.RootKey := HKEY_LOCAL_MACHINE; 
        Reg.OpenKey('Software\Microsoft\Internet Explorer', False); 
        try 
          Result := Reg.ReadString(Key); 
        except 
          Result := ''; 
        end; 
        Reg.CloseKey; 
      finally 
        Reg.Free; 
      end; 
    end; 
     
     
    procedure TForm1.Button1Click(Sender: TObject); 
    begin 
      ShowMessage('IE-Version: ' + GetIEVersion('Version')[1] + '.' + GetIEVersion('Version')[3]); 
      ShowMessage('IE-Version: ' + GetIEVersion('Version')); 
      // <major version>.<minor version>.<build number>.<sub-build number> 
    end; 

