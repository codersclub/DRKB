---
Title: Как работать с WordBasic?
Date: 01.01.2007
Source: Delphi Knowledge Base: <https://www.baltsoft.com/>
---


Как работать с WordBasic?
=========================


    uses OleAuto;
     
    var
      MSWord: Variant;
     
    begin
      MsWord := CreateOleObject('Word.Basic');
      MsWord.FileNewDefault;
      MsWord.TogglePortrait;
    end;

