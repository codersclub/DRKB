---
Title: Набор dialup соединения по умолчанию
Author: Song
Date: 01.01.2007
---


Набор dialup соединения по умолчанию
====================================

Вариант 1:

Для w9x, me:

    procedure TForm1.Button1Click(Sender: TObject);
    var cmd, par, fil, dir: PChar;
    begin
      Cmd := 'open';
      Fil := 'rasdial.exe';
      Par := PChar(edtEntry.Text + ' ' + EdtUser.Text + ' ' + EdtPass.Text);
      Dir := 'C:';
      ShellExecute(Handle, Cmd, Fil, Par, Dir, SW_SHOWMINNOACTIVE);
    end;
     
    procedure TForm1.Button2Click(Sender: TObject);
    var Cmd, Par, Fil, Dir: PChar;
    begin
      Cmd := 'open';
      Fil := 'rasdial.exe';
      Par := PChar(EdtEntry.Text + ' /DISCONNECT');
      Dir := 'C:';
      ShellExecute(Handle, Cmd, Fil, Par, Dir, SW_SHOWMINNOACTIVE);
    end;

------------------------------------------------------------------------
Вариант 2:

    uses Registry, Windows;
     
    function DUNDialDefault(Hide: Boolean): Boolean;
    var Reg: TRegistry;
      TempResult: Boolean;
      Name, Con: string;
      ASW: Integer;
    begin
      with TRegistry.Create do
      try
        RootKey := HKEY_CURRENT_USER;
        if OpenKey('\RemoteAccess', False) then
          begin
            TempResult := True;
            Name := ReadString('Default');
          end
        else
          TempResult := False;
      finally
        Free;
      end;
      if TempResult then
        begin
          if Hide then
            ASW := SW_HIDE
          else
            ASW := SW_SHOWDEFAULT;
          Con := 'rnaui.dll,RnaDial ' + Name;
          ShellExecute(0, nil, 'rundll32.exe', PChar(Con), 'C:\windows\', ASW);
        end; {IF}
      Result := TempResult;
    end;

------------------------------------------------------------------------
Вариант 3:

Автор: Song

Source: <https://forum.sources.ru>

Для Nt, w2k, XP:

    Uses ..., WinInet;
     
    InternetAutoDial (INTERNET_AUTODIAL_FORCE_ONLINE, Handle);

Handle - окно, из которого вызывается функция.

