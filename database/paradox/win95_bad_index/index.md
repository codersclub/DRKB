---
Title: Paradox и неверные индексы Win95
Author: David W. Husch
Date: 01.01.2007
---


Paradox и неверные индексы Win95
================================

::: {.date}
01.01.2007
:::

Автор: David W. Husch

Сообщение об ошибке: В файловой системе win95 существует ошибка,
"микширующая" блокировку записи Paradox и механизм обновления. В
хост-файлах Paradox в Windows 95 для работы нескольких пользователей
измените следующие значения:

Select Control Panel

System (icon)

Performance (Tab)

File System (Button)

Troubleshooting (Tab)

"Disable New File Sharing and Locking Semantics" (щелкните) (нажмите
OK)

(Выключить общий доступ к новым файлам и семантику блокировки)

Взято с <https://delphiworld.narod.ru>
