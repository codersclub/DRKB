---
Title: Можно ли работать и создавать, редактировать документы, используя объект Word.Basic?
Date: 01.01.2007
---


Можно ли работать и создавать, редактировать документы, используя объект Word.Basic?
====================================================================================

::: {.date}
01.01.2007
:::

Можно работать с документами Word, используя Word.Basic. Для этого
вначале создаем объект W:=CreateOleObject(\'Word.Basic\'). Чтобы открыть
файл, используем W.FileOpen(\'Путь и имя файла\'). Для сохранения файла
используем W.FileSave. Для поиска строки используем W.EditFind
(\'текст\'), после чего оцениваем результат поиска W.EditFindFound и
т.д. Объект Word.Application имеет больше возможностей, поэтому лучше
использовать его.


Уточнение по работе с \"Офисом XP\" (замечание автора)

Для работы в \"Офисе XP\" пришлось аргументы типа real заменить
аргументами типа extended. Это пришлось сделать во всех функциях,
особенно там, где необходимо установить координаты расположения
объектов. Смотрите пример изменения координат и размеров объекта
TextBox:

    Function SetPosZizeTextBox(TextBox:variant;
      Left,Top,Width,Height:real):boolean;
     const msoTextBox=17;
     var l_,t_,w_,h_:Extended;
    begin
     SetPosZizeTextBox:=true;
     try
      l_:=Left; t_:=Top; w_:=Width; h_:=Height;
      if w.ActiveDocument.Shapes.Item(TextBox).Type=msoTextBox
       then begin
        W.ActiveDocument.Shapes.Item(TextBox).Left:=l_;
        W.ActiveDocument.Shapes.Item(TextBox).Top:=t_;
        W.ActiveDocument.Shapes.Item(TextBox).Width:=w_;
        W.ActiveDocument.Shapes.Item(TextBox).Height:=h_;
       end
       else SetPosZizeTextBox:=false;
     except
      SetPosZizeTextBox:=false;
     end;
    End;
