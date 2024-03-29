---
Title: Как создать таблицу в MS Word?
Date: 01.01.2007
Source: Delphi Knowledge Base: <https://www.baltsoft.com/>
---


Как создать таблицу в MS Word?
==============================


If Doc is a TWordDocument, for example:

    { ... }
    var
      Tbl: Table;
      R: Range;
      Direction: OleVariant;
      { ... }
    Direction := wdCollapseEnd;
    R := Doc.Range;
    R.Collapse(Direction);
    Tbl := Doc.Tables.Add(R, 2, 4, EmptyParam, EmptyParam);
    Tbl.Cell(1, 1).Range.Text := 'Row 1, Col 1';
    Tbl.Cell(1, 2).Range.Text := 'Row 1, Col 2';

But doing things with individual table cells in Word is extremely slow.
If you can, it\'s better to enter the data as (for example)
comma-separated values and convert it into a table only as the last
step. Here\'s an example:

     
    { ... }
    const
      Line1 = 'January,February,March';
      Line2 = '31,28,31';
      Line3 = '31,59,90';
    var
      R: Range;
      Direction, Separator, Format: OleVariant;
    { ... }
    R := Word.Selection.Range;
    Direction := wdCollapseEnd;
    R.Collapse(Direction);
    R.InsertAfter(Line1);
    R.InsertParagraphAfter;
    R.InsertAfter(Line2);
    R.InsertParagraphAfter;
    R.InsertAfter(Line3);
    R.InsertParagraphAfter;
    Separator := ',';
    Format := wdTableFormatGrid1;
    R.ConvertToTable(Separator, EmptyParam, EmptyParam, EmptyParam, Format, EmptyParam,
      EmptyParam, EmptyParam, EmptyParam, EmptyParam, EmptyParam, EmptyParam,
      EmptyParam, EmptyParam);
    { ... }

