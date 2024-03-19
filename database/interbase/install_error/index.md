---
Title: Ошибка при установке Internal error near IBcheck
Author: [Дмитрий Кузьменко](mailto:delphi@demo.ru)
Date: 01.01.2001
---


Ошибка при установке Internal error near IBcheck
================================================

Эта ошибка вызвана порчей ключа registry инсталлятором Delphi 4.
Исправить ее можно, запустив RegEdit и проверив ключ
HK\_CURRENT\_USER/Environment.

Значение PATH должно быть строкового
типа. Если это не так, то PATH надо поменять (или пересоздать) на
строковое значение.

Материал подготовлен в Демо-центре клиент-серверных технологий. (Epsylon
Technologies)

Материал не является официальной информацией компании Borland.

Составитель: Дмитрий Кузьменко  
E-mail mailto:delphi@demo.ru  
www: http://www.ibase.ru/  
Телефоны: 953-13-34

Источники информации:

- Borland Interbase / Firebird FAQ
- Borland Interbase / Firebird Q&A, версия 2.02 от 31 мая 1999
последняя редакция от 17 ноября 1999 года.
- Часто задаваемые вопросы и ответы по Borland Interbase / Firebird
- а также различные источники на WWW-серверах, текущая
переписка, московский семинар по Delphi и конференции, листсервер
ESUNIX1, листсервер mers.com,
материалы Borland International, Борланд АО, релиз Interbase 4.0, 4.1,
4.2, 5.0, 5.1, 5.5, 5.6,

