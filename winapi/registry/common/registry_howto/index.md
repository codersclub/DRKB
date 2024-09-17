---
Title: Как работать с реестром Windows?
Date: 01.01.2007
Source: <https://forum.sources.ru>
---

Как работать с реестром Windows?
================================

Вот небольшой пример работы с системным реестром;

    uses 
      Registry, Windows; 
     
    procedure TForm1.Button1Click(Sender: TObject); 
    var 
      Registry: TRegistry; 
    begin 
      { создаём объект TRegistry }
      Registry := TRegistry.Create; 
      { устанавливаем корневой ключ; напрмер hkey_local_machine или hkey_current_user } 
      Registry.RootKey := hkey_local_machine; 
      { открываем и создаём ключ }
      Registry.OpenKey('software\MyRegistryExample',true); 
      { записываем значение }
      Registry.WriteString('MyRegistryName','MyRegistry Value'); 
      { закрываем и освобождаем ключ }
      Registry.CloseKey; 
      Registry.Free; 
    end;
     
     
    // для удаления ключа используется функция Registry.DeleteKey 
