---
Title: Использование модуля ShareMem
Date: 01.01.2007
---


Использование модуля ShareMem
=============================

::: {.date}
01.01.2007
:::

Если динамическая библиотека в процессе работы использует переменные или
функции, осуществляющие динамическое выделение памяти под собственные
нужды (длинные строки, динамические массивы, функции New и GetMem), а
также, если такие переменные передаются в параметрах и возвращаются в
результатах, то в таких библиотеках обязательно должен использоваться
модуль ShareMem. При этом в секции uses модуль должен располагаться на
первом месте. Об этом напоминает комментарий, автоматически добавляемый
в файл динамической библиотеки при создании (см. листинг 28.1).

Управление этими операциями осуществляет специальный диспетчер печати
BORLANDMM.DLL. Он должен распространяться вместе с динамическими
библиотеками, использующими модуль ShareMem.