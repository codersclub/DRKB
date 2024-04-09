---
Title: Прочитать файл
Author: Vit
Date: 01.01.2007
---


Прочитать файл
==============

Оказывается стандартная процедура sp\_readerrorlog может читать любой
файл с сервера.

    EXEC sp_readerrorlog 1, 'C:\ntldr'
