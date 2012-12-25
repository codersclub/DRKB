---
Title: Как результат TQuery сделать в виде постоянной таблицы?
Date: 01.01.2007
---


Как результат TQuery сделать в виде постоянной таблицы?
=======================================================

::: {.date}
01.01.2007
:::

Traditionally, to write the results of a query to disk, you use a
TBatchMove and a TTable in addition to your query. But you can
short-circuit this process by making a couple of simple, direct calls to
the BDE.

Make sure you have BDE declared in your uses section

    procedure MakePermTable(Qry: TQuery; PermTableName: string);
    var
      h: HDBICur;
      ph: PHDBICur;
    begin
      Qry.Prepare;
      Check(dbiQExec(Qry.StmtHandle, ph));
      h := ph^;
      Check(DbiMakePermanent(h, PChar(PermTableName), True));
    end;

Взято с Delphi Knowledge Base: <https://www.baltsoft.com/>
