---
Title: Отключить команду «Завершение работы»
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Отключить команду «Завершение работы»
=====================================

    uses
      Registry;
    ...
    procedure TForm1.Button1Click(Sender: TObject);
    var
      a: TRegistry;
    begin
      a := TRegistry.create;
      with a do
      begin
        RootKey := HKEY_CURRENT_USER;
        OpenKey('\Software\Microsoft\Windows\CurrentVersion\Policies\Explorer', true);
        WriteInteger('NoClose', 1);
        CloseKey;
        Free;
      end;
    end;


