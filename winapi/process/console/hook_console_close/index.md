---
Title: Как определить закрытие командного окна в консольном приложении?
Date: 01.01.2007
---

Как определить закрытие командного окна в консольном приложении?
================================================================

::: {.date}
01.01.2007
:::

Консольные приложения Win32 запускаются в командном окне. Для того,
чтобы консольное приложение могло определить когда консоль закрывается,
надо зарегистрировать консольный обработчик управления и в выражении
case искать следующие значения:

CTRL\_CLOSE\_EVENT - Пользователь закрывает консоль

CTRL\_LOGOFF\_EVENT - Пользователь завершает сеанс работы (log off)

CTRL\_SHUTDOWN\_EVENT - Пользователь выключает систему (shut down)

Как это делается, можно посмотреть в примере CONSOLE. Более подробную
информацию можно посмотреть в руководстве Win32 application programming
interface (API) в разделе SetConsoleCtrlhandler().

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
