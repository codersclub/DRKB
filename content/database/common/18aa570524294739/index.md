---
Title: Проблема с AddIndex
Date: 01.01.2007
---


Проблема с AddIndex
===================

::: {.date}
01.01.2007
:::

При попытке использования AddIndex я получаю ошибку \'Invalid Index/Tag
name. (Неверное имя Индекса/Тэга) Index: cusname\'. Но у меня нет
никаких проблем с этим именем при использовании DeleteIndex.

Есть глючокс с именемани индексов:

    if IndexName = Fieldname then
      ixCaseSensitive is reqd // по умолчанию
    if IndexName <> Fieldname then
      ixCaseInsensitive is reqd

Таким образом, вам нужно:

    InvTbl.AddIndex('cusname', 'name', [ixCaseInsensitive]);

или

    InvTbl.AddIndex('name', 'name', []);

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
