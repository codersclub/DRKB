---
Title: Кнопка программы в IE
Author: Rouse\_
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Кнопка программы в IE
=====================

    procedure CreateExplorerButton(Path: string); 
     
     
    const 
      Tagit = '{10954C80-4F0F-11d3-B17C-00C0DFE39736}';
    var 
      Reg: TRegistry; 
      Path1: string; 
      Merge: string; 
    begin 
      Path := 'c:\your_program_path'; 
      Reg := TRegistry.Create; 
      try 
        with Reg do 
        begin 
          RootKey := HKEY_LOCAL_MACHINE; 
          Path1 := 'Software\Microsoft\Internet Explorer\Extensions'; 
          Merge := Path1 + Tagit; 
          OpenKey(Merge, True); 
          WriteString('ButtonText', 'ButtonText'); 
          WriteString('MenuText', 'Tools Menu Item'); 
          WriteString('MenuStatusBar', 'Run Script'); 
          WriteString('ClSid', '{1FBA04EE-3024-11d2-8F1F-0000F87ABD16}'); 
          WriteString('Default Visible', 'Yes'); 
          WriteString('Exec', Path + '\ProgramName.exe'); 
          WriteString('HotIcon', ',4'); 
          WriteString('Icon', ',4'); 
        end 
      finally 
        Reg.CloseKey; 
        Reg.Free; 
      end; 
    end;

