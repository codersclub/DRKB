---
Title: Почему не всегда верно обновляются IndexDefs по Update?
Author: [Nomadic](mailto:Nomadic@newmail.ru)
Date: 01.01.2007
---


Почему не всегда верно обновляются IndexDefs по Update?
=======================================================

::: {.date}
01.01.2007
:::

Ошибка в VCL.

А помогает добавление fUpdated:=false; в теле процедуры
TIndexDefs.Update.

Или убиением владельца через Free, и пересозданием.

Автор: [Nomadic](mailto:Nomadic@newmail.ru)

Взято с <https://delphiworld.narod.ru>
