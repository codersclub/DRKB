---
Title: Как сделать откат внутри триггера
Date: 01.01.2007
---


Как сделать откат внутри триггера
=================================

::: {.date}
01.01.2007
:::

Внутри триггера нельзя управлять транзакциями, поэтому генерируешь там
исключение а откат транзакции делаешь в приложении, пославшем запрос.
Естественно exception должен предварительно создан

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
     

    DBase.StartTransaction;
    try
      Query.ExecSQL;
      DBase.Commit;
    except
      DBase.Rollback;
      raise;    // Для последующей обработки
    end;

Взято с <https://delphiworld.narod.ru>
