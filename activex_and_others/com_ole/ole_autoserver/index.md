---
Title: Интерфейс OLE AutoServer
Author: Anders Hejlsberg
Date: 01.01.2007
---


Интерфейс OLE AutoServer
========================

::: {.date}
01.01.2007
:::

Это не улыбка, а дружественный интерфейс. 

Я пытаюсь создать in-process oleserver с возможностью обратного вызова
(callback). Я хочу передавать мой ole-объект MS C++ dll так, чтобы DLL
могла бы вызываться из сервера. Проблема в том, что dll "вылетает",
если мой сервер - Delphi 2.0, но работает в VB 4.0

Проблема в том, что вы передаете со стороны Delphi Variant, но на
стороне C++ "ожидают" IUnknown. Измените прототип функции Delphi
следующим образом:

    function SmtOleLink(OleCallBack: IUnknown; ...) ...;

Для получения доступа к типу IUnknown необходимо добавить "Ole2" к
списку используемых модулей. Теперь измените вызов со стороны Delphi:

Автор: Anders Hejlsberg

Взято с <https://delphiworld.narod.ru>
