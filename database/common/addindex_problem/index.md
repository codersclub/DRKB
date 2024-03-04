---
Title: Проблема с AddIndex
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Проблема с AddIndex
===================

При попытке использования AddIndex я получаю ошибку \'Invalid Index/Tag
name. (Неверное имя Индекса/Тэга) Index: cusname\'. Но у меня нет
никаких проблем с этим именем при использовании DeleteIndex.

Есть глючокс с именами индексов:

    if IndexName = Fieldname then
      ixCaseSensitive is reqd // по умолчанию
    if IndexName <> Fieldname then
      ixCaseInsensitive is reqd

Таким образом, вам нужно:

    InvTbl.AddIndex('cusname', 'name', [ixCaseInsensitive]);

или

    InvTbl.AddIndex('name', 'name', []);


