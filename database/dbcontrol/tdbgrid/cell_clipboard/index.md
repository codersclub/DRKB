---
Title: Буфер обмена и ячейки TDBGrid
Date: 01.01.2007
---


Буфер обмена и ячейки TDBGrid
=============================

::: {.date}
01.01.2007
:::

Внутренний (in-place) редактор является защищенным свойством
TCustomGrid, поэтому тут придется немного поколдовать. Вы можете сделать
приблизительно так:

    type
      TMyCustomGrid = class(TCustomGrid)
      public
        property InplaceEditor;
      end;
     
    ...
     
    if ActiveControl is TCustomGrid then
      TMyCustomGrid(ActiveControl).InplaceEditor.CopyToClipboard;

Взято с <https://delphiworld.narod.ru>
