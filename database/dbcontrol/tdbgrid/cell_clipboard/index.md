---
Title: Буфер обмена и ячейки TDBGrid
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Буфер обмена и ячейки TDBGrid
=============================

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

