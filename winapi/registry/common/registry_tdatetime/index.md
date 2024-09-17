---
Title: Сохранить значение TDateTime в реестре
Date: 01.01.2007
---

Сохранить значение TDateTime в реестре
======================================

    uses
       Registry;
     
    // Write TDateTime to Registry 
    procedure Reg_WriteDateTime(dwRootKey: DWord; const sKey: string; const sField: string; aDate: TDateTime);
    begin
      with TRegistry.Create do
      try
        RootKey := dwRootKey;
        if OpenKey(sKey, True) then
        begin
          try
            WriteBinaryData(sField, aDate, SizeOf(aDate));
          finally
            CloseKey;
          end;
        end;
      finally
        Free;
      end;
    end;
    
    // Read TDateTime from Registry 
    function Reg_ReadDateTime(dwRootKey: DWord; const sKey: string; const sField: string) : TDateTime;
    begin
      Result := 0; // default Return value 
     with TRegistry.Create do
      begin
        RootKey := dwRootKey;
        if OpenKey(sKey, False) then
        begin
          try
            ReadBinaryData(sField, Result, SizeOf(Result));
          finally
            CloseKey;
          end;
        end;
        Free;
      end;
    end;
    
    // Example: 
     
    // Write DateTimePicker1's DateTime to Registry 
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      Reg_WriteDateTime(HKEY_CURRENT_USER, 'Software\TestXYZ\','DateTime',DateTimePicker1.DateTime);
    end;
    
    // Set DateTimePicker1's DateTime from Registry 
    procedure TForm1.Button2Click(Sender: TObject);
    var
      ATime: TDateTime;
    begin
      ATime := Reg_ReadDateTime(HKEY_CURRENT_USER, 'Software\TestXYZ\','DateTime');
      if ATime <> 0 then
        DateTimePicker1.DateTime := TDateTime(ATime);
    end;
