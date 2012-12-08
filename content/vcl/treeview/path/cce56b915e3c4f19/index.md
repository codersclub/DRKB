---
Title: Получение узла в TTreeView по пути заголовков
Date: 01.01.2007
---


Получение узла в TTreeView по пути заголовков
=============================================

::: {.date}
01.01.2007
:::

    { **** UBPFD *********** by delphibase.endimus.com ****
    >> Получение узла в TreeView по пути заголовков
     
    Функция выдает узел TTreeNode из дерева TreeView, находящийся по пути,
    указанному в Path, в котором разделителем уровней является символ Separator.
    Если узел не найден - выдается nil.
    Ограничение - заголовки узлов дерева не должны содержать символа Separator.
     
    Зависимости: ComCtrls, Classes, SysUtils
    Автор:       lipskiy, lipskiy@mail.ru, ICQ:51219290, Санкт-Петербург
    Copyright:   Собственное написание (lipskiy)
    Дата:        26 июня 2002 г.
    ***************************************************** }
     
    function GetNodeInPath(Path: string; Separator: char; TreeView: TTreeView):
      TTreeNode;
    var
      List: TStringList;
      Node: TTreeNode;
      i: integer;
      s: string;
    begin
      Result := nil;
      if (TreeView = nil) or (TreeView.Items.Count = 0) or (Path = '') or (Separator
        = '') then
        exit;
      List := TStringList.Create;
      // Меняем сепаратор на первод строки
      s := StringReplace(Path, Separator, #13#10,[rfReplaceAll]);
     // Получаем список уровней
      List.Text := s;
      // Начинаем с нулевой ноды дерева
      Node := TreeView.Items[0];
      // Проходим по всему списку уровней пути
      for i := 0 to List.Count - 1 do
      begin
        // Ищем имя ноды на текущем уровне
        while (Node <> nil) and (Node.Text <> List[i]) do
          Node := Node.getNextSibling;
        // Нода не найдена
        if Node = nil then
          break;
        // Переходим на уровень ниже
        if i < List.Count - 1 then
          Node := Node.getFirstChild;
      end;
      List.Free;
      Result := Node;
    end;
     
    // Пример использования:
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      TreeView1.Selected := GetNodeInPath('Каталог\Подкаталог', '\', TreeView1);
    end;
