---
Title: Доступ к Oracle через ADO
Author: Pegas
Date: 01.01.2007
Source: Vingrad.ru <https://forum.vingrad.ru>
---


Доступ к Oracle через ADO
=========================

Для доступа к данных хранящимся в Oracle лучше всего использовать не
компоненты ADO а компоненты билиотека DAO (Data Access Oracle) с ними
так же просто разобраться как и со стандартными компонентами, к тому же
они работают на прямую с Oracle, без каких-либо посредников (например
BDE, или тот же ODBC), и заточены соответственно под него. Линк точный
дать не могу, но найти их будет не трудно (воспользуйся поисковой
системой)...

Но если все же решил использовать ADO вот тебе строка:

1. способ если использовать "MS OLE DB Provider for Oracle" - это
провайдер мелкомягких

        Provider=MSDAORA.1;Password=USER123;User ID=USER;Data Source=MyDataSourse;
        Persist Security Info=False

2. способ если использовать "Oracle Provider for Ole DB" - это
провайдер от Oracle

        Provider=OraOLEDB.Oracle.1;Persist Security Info=False;User ID=USER;Data Source=MyDataSourse

