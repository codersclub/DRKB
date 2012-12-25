---
Title: Можно ли изменить число колонок и их ширину в компоненте TFileListBox?
Date: 01.01.2007
---


Можно ли изменить число колонок и их ширину в компоненте TFileListBox?
======================================================================

::: {.date}
01.01.2007
:::

В приведенном примере FileListBox приводится к типу TDirectoryListBox -
таким образом можно добавиь дополнительные колонки.

    with TDirectoryListBox(FileListBox1) do 
    begin
      Columns := 2;
      SendMessage(Handle, LB_SETCOLUMNWIDTH, Canvas.TextWidth('WWWWWWWW.WWW'),0);
    end;
