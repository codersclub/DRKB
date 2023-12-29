---
Title: Как пересоздать индексы?
Date: 01.01.2007
---


Как пересоздать индексы?
========================

::: {.date}
01.01.2007
:::

    procedure TForm1.Button4Click(Sender: TObject);
    var
      aExclusive, aActive: Boolean;
    begin
      with Table1 do
      begin
        aActive := Active;
        Close;
        aExclusive := Exclusive;
        Exclusive := True;
        Open;
        Check(DbiRegenIndexes(Table1.Handle));
        Close;
        Exclusive := aExclusive;
        Active := aActive;
        Check(DbiSaveChanges(Table1.Handle));
      end;
    end;

As when calling any BDE API function, the BDE API wrapper unit BDE (for
Delphi 1, the units DbiTypes, DbiErrs, and DbiProcs) must be referenced
in the Uses section of the unit from which the call is to be made. The
BDE API function DbiSaveChanges, used here, forces any data changes in
memory buffer to be written to disk at that point.

Another way to handle this situation -- if you know at design-time all
the indexes that will exist for the table -- would be to iterate
through the items in the TIndexDefs object of the TTable component,
delete each index (DeleteIndex method), and then add all needed indexes
back (AddIndex method).

    procedure TForm1.Button3Click(Sender: TObject);
    var
      aName: string;
      i: Byte;
      aExclusive, aActive: Boolean;
    begin
      with Table1 do
      begin
        aActive := Active;
        Close;
        aExclusive := Exclusive;
        Exclusive := True;
        IndexDefs.Update;
        i := IndexDefs.Count;
        while i > 0 do
        begin
          aName := IndexDefs.Items[i - 1].Name;
          DeleteIndex(aName);
          Dec(i);
        end;
        AddIndex('', 'MainField', [ixPrimary]);
        AddIndex('Field1', 'Field1', []);
        AddIndex('Field2', 'Field2', []);
        IndexDefs.Update;
        Exclusive := aExclusive;
        Active := aActive;
        Check(DbiSaveChanges(Table1.Handle));
      end;
    end;

Взято с Delphi Knowledge Base: <https://www.baltsoft.com/>
