---
Title: Как результат TQuery сделать в виде постоянной таблицы?
Date: 01.01.2007
Source: Delphi Knowledge Base: <https://www.baltsoft.com/>
---


Как результат TQuery сделать в виде постоянной таблицы?
=======================================================

Традиционно для записи результатов запроса на диск используется
TBatchMove и TTable в дополнение к вашему запросу. Но вы можете
сократить этот процесс, выполнив пару простых прямых вызовов BDE.

Убедитесь, что BDE объявлен в разделе «Uses».

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

