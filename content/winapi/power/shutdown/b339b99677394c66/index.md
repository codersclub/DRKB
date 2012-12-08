---
Title: Отключить команду «Завершение работы»
Date: 01.01.2007
---


Отключить команду «Завершение работы»
=====================================

::: {.date}
01.01.2007
:::

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
     

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
