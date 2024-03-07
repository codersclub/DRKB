---
Title: Как сделать откат внутри триггера
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Как сделать откат внутри триггера
=================================

Внутри триггера нельзя управлять транзакциями, поэтому генерируешь там
исключение а откат транзакции делаешь в приложении, пославшем запрос.
Естественно exception должен предварительно создан

```sql
SET TERM !!;

CREATE TRIGGER " DELETE_INV"  FOR " TINV"
    ACTIVE BEFORE DELETE
    POSITION 10
    AS
    BEGIN
        IF (EXISTS (SELECT tOst.Id FROM tOst
                    WHERE tOst.Id = tInv.Id))
        THEN
            EXCEPTION EST_OSTATOK;
    END !!

SET TERM ;!!
```

```delphi
DBase.StartTransaction;
try
  Query.ExecSQL;
  DBase.Commit;
except
  DBase.Rollback;
  raise;    // Для последующей обработки
end;
```
