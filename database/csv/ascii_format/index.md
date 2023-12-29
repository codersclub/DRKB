---
Title: Формат файла ASCII-схемы
Date: 01.01.2007
---


Формат файла ASCII-схемы
========================

::: {.date}
01.01.2007
:::

В файле asciidrv.txt насчет последнего числа в строке схемы поля
говорится:

\"* Offset - Number of characters from the beginning of the line that
the field begins. Used for FIXED format only.\" (Offset - количество
символов он начала линии до начала поля. Используется только для
фиксированного формата.).

С тех пор, как мой файл имеет переменный (Variable) формат, я задал в
каждой строке смещение, равное нулю. После некоторых попыток, чтобы
заставить это работать, я следал следующие изменения:

\[discs\]

filetype = varying

charset = ascii

delimiter = \"

separator =,

field1 = id,char,10,0,1

field2 = title,char,30,0,2

field3 = artist,char,30,0,3

...

field36 = song30,char,50,0,36

После более произвольных изменений это стало таким:

\[discs\]

filetype = varying

charset = ascii

delimiter = \"

separator =,

field1 = id,char,10,0,10

field2 = title,char,30,0,20

field3 = artist,char,30,0,30

...

field36 = song30,char,50,0,360

и внезапно все заработало! Для поля, которое игнорируется форматом
файла, \"Offset\" несомненно дало огромный эффект.

Взято из Советов по Delphi от [Валентина Озерова](mailto:webmaster@webinspector.com)

Сборник Kuliba
