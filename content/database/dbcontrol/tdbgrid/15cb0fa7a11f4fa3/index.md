---
Title: Как программно перевести TDBGrid в режим редактирования?
Date: 01.01.2007
---


Как программно перевести TDBGrid в режим редактирования?
========================================================

::: {.date}
01.01.2007
:::

Переведите таблицу в режим редактирования, затем получите дескриптор
(handle) окна редактирования и перешлите ей сообщение EM\_SETSEL. В
качестве параметров вы должны переслать начальную позицию курсора, и
конечную позицию, определяющую конец выделения текста цветом. В
приведенном примере курсор помещается во вторую позицию, текст внутри
ячейки не выделяется.

    procedure TForm1.Button1Click(Sender: TObject);
    var
           h : THandle;
    begin
           Application.ProcessMessages;
           DbGrid1.SetFocus;
           DbGrid1.EditorMode := true;
           Application.ProcessMessages;
           h:= Windows.GetFocus;
           SendMessage(h, EM_SETSEL, 2, 2);
    end;

Взято с <https://delphiworld.narod.ru>
