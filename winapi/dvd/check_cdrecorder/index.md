---
Title: How to check, if a CD-Recorder is available? (WinXP)
Date: 01.01.2007
---


How to check, if a CD-Recorder is available? (WinXP)
====================================================

::: {.date}
01.01.2007
:::

    {....}
     
    uses Registry;
     
    {....}
     
    function HasCDRecorder: Boolean;
    var
      reg: TRegistry;
    begin
      reg := TRegistry.Create;
      try
        // set the the Mainkey, 
        reg.RootKey := HKEY_CURRENT_USER;
        // Open a key
        reg.OpenKey('Software\Microsoft\Windows\CurrentVersion\Explorer\CD Burning', False);
        // Check if the Key exists
        Result := reg.ValueExists('CD Recorder Drive');
        // Close the key
        reg.CloseKey;
      finally
        // and free the TRegistry Object
        reg.Free;
      end;
    end;
     
    // Example:
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      if HasCDRecorder then
        ShowMessage('CD-Recorder available.')
      else
        ShowMessage('CD-Recorder NOT available.');
    end;

Взято с сайта <https://www.swissdelphicenter.ch/en/tipsindex.php>
