---
Title: Почему не всегда верно обновляются IndexDefs по Update?
Author: [Nomadic](mailto:Nomadic@newmail.ru)
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Почему не всегда верно обновляются IndexDefs по Update?
=======================================================

Ошибка в VCL.

А помогает добавление `fUpdated:=false;` в теле процедуры TIndexDefs.Update.

Или убиением владельца через Free, и пересозданием.

