---
Title: Использование нумерации в TFields
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Использование нумерации в TFields
=================================

Я хочу хранить журнал транзакций в таблице Paradox и хотел бы писать и
читать коды транзаций вместо простых целых чисел, которые они
представляют в данный момент...

Можете попробовать сделать так:

    type Tcodes = (c1,c2,c3,c4);
     
    var code: Tcodes;
     
    code := Tcodes(Table1Field1.AsInteger);
    if code in [c2,c4] then .....
      Table1Field1.AsInteger := Integer(code);

