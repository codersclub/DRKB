---
Title: Как узнать путь к браузеру по умолчанию?
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Как узнать путь к браузеру по умолчанию?
========================================

    uses 
      Registry; 
     
    {....} 
     
    procedure TForm1.Button1Click(Sender: TObject); 
    var 
      Reg: TRegistry; 
      KeyName: string; 
      ValueStr: string; 
    begin 
      Reg := TRegistry.Create; 
      try 
        Reg.RootKey := HKEY_CLASSES_ROOT; 
        KeyName  := 'htmlfile\shell\open\command'; 
        if Reg.OpenKey(KeyName, False) then 
        begin 
          ValueStr := Reg.ReadString(''); 
          Reg.CloseKey; 
          Label1.Caption := ValueStr; 
        end 
        else 
          ShowMessage('No Default Webbrowser !'); 
      finally 
        Reg.Free; 
      end; 
    end; 

