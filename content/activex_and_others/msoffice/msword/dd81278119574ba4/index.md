---
Title: Как заменить значение переменных для текста MS Word?
Date: 01.01.2007
---


Как заменить значение переменных для текста MS Word?
====================================================

::: {.date}
01.01.2007
:::

    uses
      Office97; {or Office2000, OfficeXP, Office_TLB}
     
    var
      VDoc, PropName, DocName: OleVariant;
      VDoc := Word.ActiveDocument;
      { ... }
     
    { Set a document property }
    PropName := 'MyOpinionOfThisDocument';
    VDoc.CustomDocumentProperties.Add(PropName, False, msoPropertyTypeString,
      'Utter drivel', EmptyParam);
    { Read a document property }
    Caption := VDoc.CustomDocumentProperties[PropName].Value;
    { ... }

Взято с Delphi Knowledge Base: <https://www.baltsoft.com/>
