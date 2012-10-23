<h1>Как сделать откат внутри триггера</h1>
<div class="date">01.01.2007</div>


<p>Внутри триггера нельзя управлять транзакциями, поэтому генерируешь там исключение а откат транзакции делаешь в приложении, пославшем запрос. Естественно exception должен предварительно создан</p>

<pre>SET TERM !!;

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
 
</pre>

<pre>
DBase.StartTransaction;
try
  Query.ExecSQL;
  DBase.Commit;
except
  DBase.Rollback;
  raise;    // Для последующей обработки
end;
</pre>

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
