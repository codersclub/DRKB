---
Title: Вставка новой записи через буфер
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Вставка новой записи через буфер
================================

    Table2.Insert;
    Move(Table1.ActiveBuffer^,Table2.ActiveBuffer^,Table1.RecordSize);
    {При необходимости назначаем новый первичный ключ}
    Table2.FieldByName('Primary Key').AsWhatever := whatever;
    Table2.Post;

...если вы уверены в том, что нарушение ключа произойти не может, то
можно вырезать это для дальнейшего использования:

    DbiInsertRecord(Table2.Handle,dbiNOLOCK,Table1.ActiveBuffer);

...конечно, это "обходит" VCL, т.к., чтобы увидеть потом новую
запись, необходимо сделать TTable.Refresh.

