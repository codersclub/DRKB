---
Title: Как найти системные папки Windows?
Author: Vit
Date: 01.01.2007
---


Как найти системные папки Windows?
==================================

Author: Vit

Source: Vingrad.ru <https://forum.vingrad.ru>

    Type TSystemPath=(Desktop,StartMenu,Programs,Startup,Personal, winroot, winsys);
     
    ...
    Function GetSystemPath(SystemPath:TSystemPath):string;
    var p:pchar;
    begin
      with TRegistry.Create do
      try
        RootKey := HKEY_CURRENT_USER;
        OpenKey('\Software\Microsoft\Windows\CurrentVersion\Explorer\Shell Folders', True);
        case SystemPath of
          Desktop:
            Result:=ReadString('Desktop');
          StartMenu:
            Result:=ReadString('Start Menu');
          Programs:
            Result:=ReadString('Programs');
          Startup:
            Result:=ReadString('Startup');
          Personal:
            Result:=ReadString('Personal');
          Winroot:begin
            GetMem(p,255);
            GetWindowsDirectory(p,254);
            result:=Strpas(p);
            Freemem(p);
          end;
          WinSys:begin
            GetMem(p,255);
            GetSystemDirectory(p,254);
            result:=Strpas(p);
            Freemem(p);
          end;
        end;
      finally
        CloseKey;
        free;
      end;
      if (result<>'') and (result[length(result)]<>'\') then result:=result+'\';
    end;

------------------------------------------------------------------------

Вариант 2:

Source: <https://delphiworld.narod.ru>

    uses Registry;
     
    procedure TForm1.Button1Click(Sender: TObject);
    var
      reg : TRegistry;
      ts : TStrings;
      i : integer;
    begin
      reg := TRegistry.Create;
      reg.RootKey := HKEY_CURRENT_USER;
      reg.LazyWrite := false;
      reg.OpenKey('Software\Microsoft\Windows\CurrentVersion\Explorer\ShellFolders', false);
      ts := TStringList.Create;
      reg.GetValueNames(ts);
      for i := 0 to ts.Count -1 do
        Memo1.Lines.Add(ts.Strings[i] + ' = ' + reg.ReadString(ts.Strings[i]));
      ts.Free;
      reg.CloseKey;
      reg.free;
    end;

