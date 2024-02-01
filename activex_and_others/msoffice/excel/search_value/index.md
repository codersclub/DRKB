---
Title: Как осуществить поиск ячейки по её значению?
Date: 01.01.2007
Source: Delphi Knowledge Base: <https://www.baltsoft.com/>
---


Как осуществить поиск ячейки по её значению?
============================================

    { ... }
    var
      Rnge: OleVariant;
      { ... }
     
    Rnge := WS.Cells;
    Rnge := Rnge.Find('Is this text on the sheet?');
    if Pointer(IDispatch(Rnge)) <> nil then
      {The text was found somewhere, so colour it pink}
      Rnge.Interior.Color := clFuchsia;

