---
Title: Как добавить группу в Program Manager?
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Как добавить группу в Program Manager?
======================================

    interface
     
    procedure CreateGroup;
     
    implementation
     
    procedure TSetupForm.CreateGroup;
    { Для установки группы в Program Manager используем компонент TProgMan }
    var
      ItemList: TStringList;
      GroupName: string;
      ItemName: string;
      i: word;
    begin
      { Получаем из INI-файла строку GroupName }
      GroupName := IniFile.ReadString('General', 'PMGroup', '');
      { Если один есть, устанавливаем группу }
      if GroupName <> '' then
      begin
        ItemList := TStringList.Create;
        try
          { читаем элементы для установки }
          IniFile.ReadSectionValues('PMGroup', ItemList);
          with TProgMan.Create(Self) do
          try
            CreateGroup(GroupName);
            for i := 0 to ItemList.Count - 1 do
            begin
              { получаем имя файла } ItemName := Copy(ItemList.Strings[i], 1,
                Pos('=',
                ItemList.Strings[i]) - 1);
              { прибавляем путь к имени файла и добавляем элемент }
              AddItem(GetTarget(ItemList.Values[ItemName][1]) + ItemName, ItemName);
            end;
          finally
            Free;
          end;
        finally
          ItemList.Free;
        end;
      end;
    end;
     


