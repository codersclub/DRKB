---
Title: Не читаются русские буквы в Database Desktop
Author: Pegas
Date: 01.01.2007
---


Не читаются русские буквы в Database Desktop
============================================

::: {.date}
01.01.2007
:::

Для DBD 7.0 нужно исправить реестр: ключ

HKCU\\Software\\Borland\\DBD\\7.0\\Preferences\\Properties\

SystemFont=\"Fixedsys\"

Если такой ключ не существует, его следует создать.

или

\[HKEY\_LOCAL\_MACHINE\\SYSTEM\\CurrentControlSet\\Control\\Nls\\CodePage\]

\"1252\"=\"c\_1251.nls\"

Автор: Pegas

Взято с Vingrad.ru <https://forum.vingrad.ru>

------------------------------------------------------------------------

Подскажите пожалуйста, у меня вот какая проблема:

Загружаю Database Desktop, открываю таблицу имеющую в полях русский
текст,

а отображается не русский текст а не понятно что.

О: MANka

Для DBD 5.0 в файл c:\\windows\\pdoxwin.ini вставить в секцию

\[Properties\]

SystemFont=Arial Cyr

Для DBD 7.0 нужно исправить реестр: ключ

HKCU\\Software\\Borland\\DBD\\7.0\\Preferences\\Properties\

SystemFont=\"Fixedsys\"

Если такой ключ не существует, его следует создать. Впрочем, для
просмотра таблиц

все равно можно порекомендовать rx Database Explorer \-- у него это
получается очень хорошо.

О: Sergey V. Baldin

Это - проблема русских .dbf и Desktop\'а . Надо установить шрифт

по умолчанию не Arial Cyr, а Fixedsys или System. копать примерно так:

1.находишь производителя Desktop :

Например, если это Borland Desktop 7.0, то находишь строку в реестре

HKEY\_CURRENT\_USER\\SOFTWARE\\BORLAND\\DBD\\7.0\\Preferences\\Properties\\SystemFont
и

меняешь Arial Cyr на стандартные для Windows: Fixedsys или System

(писать название шрифта с большой буквы).

2\. И в стандартном драйвере BDE,например DBASE, ставишь русский драйвер
dBASE RUS cp866.

Открываешь BDE configurator(administrator), ярлык на 32-BDE находится в
панели управления.

И в строке Drivers-\>Native-\>DBASE-\>Langdriver-\>ставишь dBASE RUS
cp866.

После этого все заиграет

Взято с сайта <https://blackman.wp-club.net/>

------------------------------------------------------------------------

Для DBD 5.0 в файл c:\\windows\\pdoxwin.ini

вставить в секцию

\[Properties\]

SystemFont=Arial Cyr

Для DBD 7.0 нужно исправить реестр: ключ

HKCU\\Software\\Borland\\DBD\\7.0\\Preferences\\Properties\

SystemFont=\"Fixedsys\"

Если такой ключ не существует, его следует создать. Впрочем, для
просмотра таблиц все равно можно порекомендовать rx Database
Explorer \-- у него это получается очень хорошо.

Copyright (C) Alexey Mahotkin 1997-1999
