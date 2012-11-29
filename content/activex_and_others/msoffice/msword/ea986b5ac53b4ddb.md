Как поменять ссылку в тексте?
=============================

::: {.date}
01.01.2007
:::

    { ... }
    Doc := Word.ActiveDocument;
    for x := 1 to Doc.Hyperlinks.Count do
    begin
      Doc.Hyperlinks.Item(x).Address;
    end;
    { ... }

Взято с Delphi Knowledge Base: <https://www.baltsoft.com/>
