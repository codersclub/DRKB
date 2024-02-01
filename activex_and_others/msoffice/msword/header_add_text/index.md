---
Title: Как добавить текст в header документа?
Date: 01.01.2007
Source: Delphi Knowledge Base: <https://www.baltsoft.com/>
---


Как добавить текст в header документа?
======================================


    { ... }
    aDoc := WordApp.Documents.Add(EmptyParam, EmptyParam);
    aDoc.Sections.Item(1).Headers.Item(wdHeaderFooterPrimary).Range.Text :=
      'This is a header';
    { ... }

