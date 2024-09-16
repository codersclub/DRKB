---
Title: Как добавить нужный язык в систему
Author: Mekan Gara
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---

Как добавить нужный язык в систему
==================================

Для этого необходимо изменить некоторые ключи в реестре. Например,
необходимо добавить Туркменский язык. Конечно, Вам необходимо иметь файл
KBD с раскладкой клавиатуры (Turkmen.kbd).

    procedure TTMKBD.OkClick(Sender: TObject);
    var
      reg: TRegistry;
      srs, dst: string;
    begin
      Reg := TRegistry.Create;
      with Reg do
      try
        RootKey := HKEY_LOCAL_MACHINE;
        OpenKey('\System\CurrentControlSet\Control\keyboard layouts\00000405', True);
        WriteString('layout file', 'Turkmen.kbd');
        WriteString('layout text', 'Turkmen');
        OpenKey('\System\CurrentControlSet\Control\Nls\Locale', True);
        WriteString('00000405', 'Turkmen');
        CloseKey;
      finally
        Free;
      end;
      srs := 'Turkmen.kbd';
      dst := 'c:\windows\system\Turkmen.kbd';
      Filecopy(srs, dst);
      showmessage('Well Done it all');
      close;
    end;

