---
Title: Как работать с WordBasic?
Date: 01.01.2007
---


Как работать с WordBasic?
=========================

::: {.date}
01.01.2007
:::

    uses OleAuto;
     
    var
      MSWord: Variant;
     
    begin
      MsWord := CreateOleObject('Word.Basic');
      MsWord.FileNewDefault;
      MsWord.TogglePortrait;
    end;

Взято с Delphi Knowledge Base: <https://www.baltsoft.com/>
