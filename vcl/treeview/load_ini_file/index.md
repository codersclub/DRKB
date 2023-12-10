---
Title: Загрузка INI-файла в TTreeView
Author: Dynamic
Date: 01.01.2007
---


Загрузка INI-файла в TTreeView
==============================

::: {.date}
01.01.2007
:::

    procedure LoadIniToTree(const FName: string; Tree: TTreeView);
    var LS, LV: TStrings;
        i, j: integer;
        root: TTreeNode;
        n: string;
        p: PString;
    begin
         Tree.Items.Clear;  // очищаем дерево
         with TIniFile.Create(FName) do  // пытаемся открыть файл FName
         try
           LS := TStringList.Create;  // список названий секций
           try
             ReadSections(LS);          // читаем все секции в список
             LV := TStringList.Create;   // список пар "имя=значение"
             try
               for i := 0 to LS.Count-1 do   // для всех секций...
               begin
                 LV.Clear;                   // подготовим список
                 ReadSectionValues(LS[i], LV);  // читаем список пар "имя=значение" для текущей секции
                 root := Tree.Items.Add(nil, LS[i]); // добавляем корневой узел (имя текущей секции)
                 for j := 0 to LV.Count-1 do    // для всех пар "имя=значение"...
                 begin
                  n := LV.Names[j];  // выделяем "имя"
     
                  // добавляем дочерний по отношению к root узел,
                  // в качестве текста исп. "имя"
                  // в качестве значения поля Data = "значение"
                  New(p);
                  p^ := LV.Values[n];
                  Tree.Items.AddChildObject(root, n, p);
                 end;
               end;
             finally
               LV.Free;
             end;
           finally
             LS.Free;
           end;
         finally
           Free;  // корректно уничтожаем объект TIniFile
         end;
    end;
     
    // Применение:
     
    procedure TForm1.TreeView1Change(Sender: TObject; Node: TTreeNode);
    begin
         if (TreeView1.Selected <> nil) and (TreeView1.Selected.Parent <> nil) then
         begin
            Edit1.Text := TreeView1.Selected.Text;
            Edit2.Text := String(TreeView1.Selected.Data^);
         end else
         begin
           Edit1.Text := '';
           Edit2.Text := '';
         end;
    end;
     
    // После использования не забыть освободить память, напр. так:
     
    procedure TForm1.TreeView1Deletion(Sender: TObject; Node: TTreeNode);
    begin
      if Node.Data <> nil then
        Dispose(PString(Node.Data));
    end;



Автор: Dynamic


