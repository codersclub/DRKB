---
Title: Как поменять ссылку в тексте?
Date: 01.01.2007
Source: Delphi Knowledge Base: <https://www.baltsoft.com/>
---


Как поменять ссылку в тексте?
=============================

    { ... }
    Doc := Word.ActiveDocument;
    for x := 1 to Doc.Hyperlinks.Count do
    begin
      Doc.Hyperlinks.Item(x).Address;
    end;
    { ... }

