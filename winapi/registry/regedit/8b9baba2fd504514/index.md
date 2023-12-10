---
Title: Запретить использовать RegEdit
Date: 01.01.2007
---

Запретить использовать RegEdit
==============================

::: {.date}
01.01.2007
:::

Например мы вынесли компонент класса TCheckBox, назвали его
\"Использовать редактор системного реестра\". Задача такова: когда
флажок установлен пользователь может воспользоваться редактором реестра,
когда не установлен - соответственно, не может!!!

Что нужно для осуществления этой задачи? Нужно воспользоваться ключом

HKEY\_CURRENT\_USER\\Software\\Microsoft\
Windows\\CurrentVersion\\Policies\\System

создать в нём параметр:

DisableRegistryTools

и задать ему в качестве значение 1, т.е. задействовать его.

Код пишем по нажатию на самом Checkbox\'e:

    procedure TForm1.CheckBox1Click(Sender: TObject);
    var
      H: TRegistry;
    begin
      H := TRegistry.Create;
      with H do
      begin
        RootKey := HKEY_CURRENT_USER;
        OpenKey('\Software\Microsoft\Windows\CurrentVersion\Policies\System', true);
        if CheckBox1.Checked then
          WriteInteger('DisableRegistryTools', 0)
        else
          WriteInteger('DisableRegistryTools', 1);
        CloseKey;
        Free;
      end;
    end;

Не забудьте в области uses объявить модуль Registry:

    uses
      Registry; 

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
