---
Title: Как зыкрыть Excel
Author: Akella
Date: 01.01.2007
---


Как зыкрыть Excel
=================

::: {.date}
01.01.2007
:::

    try
      Ex1.Workbooks.Close(LOCALE_USER_DEFAULT);
      Ex1.Disconnect;
      Ex1.Quit;
      Ex1:=nil;
     except
     end;

Автор: Akella

Взято с Vingrad.ru <https://forum.vingrad.ru>
