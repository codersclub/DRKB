---
Title: Как открыть диалог создания ярлыка?
Date: 01.01.2007
---


Как открыть диалог создания ярлыка?
===================================

::: {.date}
01.01.2007
:::

    uses 
      registry, shellapi; 
     
    function Launch_CreateShortCut_Dialog(Directory: string): Boolean; 
    var 
      reg: TRegistry; 
      cmd: string; 
    begin 
      Result := False; 
      reg    := TRegistry.Create; 
      try 
        reg.Rootkey := HKEY_CLASSES_ROOT; 
        if reg.OpenKeyReadOnly('.LNK\ShellNew') then 
        begin 
          cmd    := reg.ReadString('Command'); 
          cmd    := StringReplace(cmd, '%1', Directory, []); 
          Result := True; 
          WinExec(PChar(cmd), SW_SHOWNORMAL); 
        end 
      finally 
        reg.Free; 
      end; 
    end; 
     
    {Example} 
     
    procedure TForm1.Button1Click(Sender: TObject); 
    begin 
      Launch_CreateShortCut_Dialog('c:\temp'); 
    end; 

Взято с сайта <https://www.swissdelphicenter.ch/en/tipsindex.php>
