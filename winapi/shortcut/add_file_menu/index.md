---
Title: Как зарегистрировать свой пункт в меню для моего типа файлов?
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---

Как зарегистрировать свой пункт в меню для моего типа файлов?
=============================================================

    uses 
      Registry; 
     
    procedure AddFileMenue(FilePrefix, Menue, Command: string); 
    var 
      reg: TRegistry; 
      typ: string; 
    begin 
      reg := TRegistry.Create; 
      with reg do 
      begin 
        RootKey := HKEY_CLASSES_ROOT; 
        OpenKey('.' + FilePrefix, True); 
        typ := ReadString(''); 
        if typ = '' then 
        begin 
          typ := Fileprefix + 'file'; 
          WriteString('', typ); 
        end; 
        CloseKey; 
        OpenKey(typ + '\shell\' + Menue + '\command', True); 
        WriteString('', command + ' "%1"'); 
        CloseKey; 
        Free; 
      end; 
    end; 
     
    procedure DeleteFileMenue(Fileprefix, Menue: string); 
    var 
      reg: TRegistry; 
      typ: string; 
    begin 
      reg := TRegistry.Create; 
      with reg do 
      begin 
        RootKey := HKEY_CLASSES_ROOT; 
        OpenKey('.' + Fileprefix, True); 
        typ := ReadString(''); 
        CloseKey; 
        OpenKey(typ + '\shell', True); 
        DeleteKey(Menue); 
        CloseKey; 
        Free; 
      end; 
    end; 
     
    { Example} 
     
    procedure TForm1.Button1Click(Sender: TObject); 
    begin 
      AddFileMenue('rtf', 'Edit with Notepad', 'C:\Windows\system\notepad.exe'); 
      { 
        If you now click with the right mousebutton on a *.rtf-file then 
        you can see a Menuepoint: "Edit with Notepad". 
        When Click on that point Notepad opens the file. 
      } 
    end; 
     
    procedure TForm1.Button2Click(Sender: TObject); 
    begin 
      { 
       Undo your changes in the Registry: 
      } 
      DeleteFileMenue('rtf', 'Edit with Notepad'); 
    end; 

