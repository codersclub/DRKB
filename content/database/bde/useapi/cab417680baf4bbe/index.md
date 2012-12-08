---
Title: Каким драйвером пользуется TDatabase?
Date: 01.01.2007
---


Каким драйвером пользуется TDatabase?
=====================================

::: {.date}
01.01.2007
:::

Вы можете использовать вызов IDAPI dbiGetDatabaseDesc. Вот быстрая
справка (не забудьте добавить DB в список используемых модулей):

    var
      pDatabase: DBDrsc:
    begin
      { pAlias - PChar, содержащий имя псевдонима }
      dbiGetDatabaseDesc ( pAlias, @pDatabase ) ;

Для получения дополнительной информации обратитесь к описанию свойства
pDatabase.szDbType.

Взято с <https://delphiworld.narod.ru>
