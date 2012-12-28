---
Title: Как работать с объектом Excel, вставленным в Word документ?
Date: 01.01.2007
---


Как работать с объектом Excel вставленном в Word документ?
==========================================================

::: {.date}
01.01.2007
:::

    { ... }
    var
      AWordApplication: WordApplication;
      AWordDocument: WordDocument;
      AWorkBook: ExcelWorkBook;
      AWorkSheet: ExcelWorkSheet;
      AInlineShape: InlineShape;
      AFileName: OleVariant;
      TrueParam: OleVariant;
    begin
      AWordApplication := CoWordApplication.Create;
      try
        FalseParam := False;
        AFileName := 'c:\wordexcel.doc';
        AWordDocument := AWordApplication.Documents.Open(AFileName, EmptyParam,
          EmptyParam,
          EmptyParam, EmptyParam, EmptyParam, EmptyParam, EmptyParam,
          EmptyParam, EmptyParam, EmptyParam, EmptyParam);
        AInlineShape := AWordDocument.InlineShapes.Item(1);
        AInlineShape.Activate;
        AWorkBook := AWordDocument.InlineShapes.Item(1).OLEFormat.Object_ as
          ExcelWorkBook;
        AWorkSheet := AWorkBook.ActiveSheet as ExcelWorkSheet;
        ShowMessage(AWorkSheet.Cells.Item[2, 1].Text);
      finally
        AWordApplication.Quit(FalseParam, EmptyParam, EmptyParam);
        AWordApplication := nil;
        AWordDocument := nil;
      end;
    end;

Взято с Delphi Knowledge Base: <https://www.baltsoft.com/>
