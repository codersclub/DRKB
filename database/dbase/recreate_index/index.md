---
Title: Создание/пересоздание индекса
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Создание/пересоздание индекса
=============================

    DbiRegenIndexes( Table1.Handle ); { Регенерация всех индексов } 
    create index (зависит от существования выражения)
     
     
    if (( Pos('(',cTagExp) + Pos('+',cTagExp) ) > 0 ) then
      Table1.AddIndex( cTagName, cTagExp, [ixExpression])  // <- ixExpression - _литерал_
    else
      Table1.AddIndex( cTagName, cTagExp, []);

