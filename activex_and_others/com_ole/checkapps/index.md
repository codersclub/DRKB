---
Title: Как можно определить доступные сервера приложений на этой машине через Registry
Author: Nomadic
Date: 01.01.2007
---


Как можно определить доступные сервера приложений на этой машине через Registry
===============================================================================

::: {.date}
01.01.2007
:::

Автор: Nomadic

Прочитайте ключ под HKEY_CLASSES_ROOT\\CLSID\\*, просматривая его
насчёт ключей, которые имеют подключ "Borland DataBroker". Эти
вхождения и являются серверами приложений.

Ниже пример, который загружает имена доступных серверов приложений в
Listbox:

    uses Registry;
     
    procedure TForm1.FormCreate(Sender: TObject);
    var
      I: integer;
      TempList: TStringList;
    begin
      TempList := TStringList.Create;
      try
        with TRegistry.Create do
        try
          RootKey := HKEY_CLASSES_ROOT;
          if OpenKey('CLSID', False) then
            GetKeyNames(TempList);
          CloseKey;
          for I := 1 to TempList.Count - 1 do
            if KeyExists('CLSID\' + TempList[I] + '\Borland DataBroker') then
            begin
              if OpenKey('CLSID\' + TempList[I] + '\ProgID', False) then
              begin
                Listbox1.Items.Add(ReadString(''));
                CloseKey;
              end;
            end;
        finally
          Free;
        end;
      finally
        TempList.Free;
      end;
    end;

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
