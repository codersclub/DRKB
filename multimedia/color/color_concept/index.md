---
Title: Что такое Цвет?
Author: Vit
Date: 01.01.2007
---


Что такое Цвет?
===============

::: {.date}
01.01.2007
:::

**Вариант 1:**

Если Edit1.text это String то что такое Edit1.font.color?

TColor - это Integer, чтоб задать нужный цвет можно пользовать
константы, а можно в числовом виде:

    Edit1.font.color:=$223344

где 22 - яркость красного цвета, может быть в пределах от 00 до FF

где 33 - яркость зеленого цвета, может быть в пределах от 00 до FF

где 44 - яркость синего цвета, может быть в пределах от 00 до FF

Например:

    Edit1.font.color:=$000000 - черный

    Edit1.font.color:=$FFFFFF - белый

    Edit1.font.color:=$00FF00 - зеленый

Всего определено 256\*256\*256 цветов

В примерах я использовал шестнадцатиричные значения так как так проще,
но можно и десятичные, если разберетесь какой это цвет

Edit1.font.color:=123456

Автор: Vit

Взято с Vingrad.ru <https://forum.vingrad.ru>

------------------------------------------------------------------------
**Вариант 2:**

Можно использовать константы типа clred, clblack, cllime, clgreen\...

Для работы с цветом можно использовать следующие функции

    RGB(r,g,b:byte):tcolor //получаешь цвет по 3 составляющим

    GetRValue(color:tcolor)

    GetGValue(color:tcolor)//получаешь значение интенсивности цвета.

    GetBValue(color:tcolor)

Автор: Mikel

Взято с Vingrad.ru <https://forum.vingrad.ru>

------------------------------------------------------------------------
**Вариант 3:**


Для хранения цвета существует свой собственный тип, который называется
TColor. Этот тип содержит информацию, как о самом цвете, так и том,
каким образом его заменить, если, например, цветовая палитра системы не
поддерживает этот цвет (скажем, установлено всего 256 цветов, а цвет,
заданный в переменной, вылезает далеко за пределы этих 256 цветов).

Тип TColor состоит из четырех байт.
- Первый байт - указатель на замену
цвета (о нем поговорим позже).
- Второй байт - яркость красного цвета от 0
до 255 (от 00 до FF).
- Третий байт - яркость зеленого цвета от 0 до 255
(от 00 до FF).
- И, наконец, четвертый байт - яркость синего цвета, также,
от 0 до 255 (от 00 до FF).

А как Вы уже знаете, из этих трех цветов: красного, зеленого и синего,
регулируя их яркость, можно составить практически любой цвет.

Поговорим теперь о первом байте - указателе на замену цвета. Итак, этот
байт может принимать три различных значения - ноль (\$00), единицу
(\$01) или двойку (\$02). Что это значит:

- Ноль (\$00) - цвет, который не может быть воспроизведен точно,
заменяется ближайшим цветом из системной палитры.

- Единица (\$01) - цвет, который не может быть воспроизведен точно,
заменяется ближайшим цветом из палитры, которая установлена сейчас.

- Двойка (\$02) - цвет, который не может быть воспроизведен точно,
заменяется ближайшим цветом из палитры, которую поддерживает текущее
устройство вывода (в нашем случае - монитор).

Видимо, всегда лучше устанавливать значение первого байта равным нулю
(\$00), по крайней мере, так происходит при получении типа TColor при
помощи функции RGB.

И, напоследок, несколько примеров:

    $00FFFFFF - белый цвет;

    $00000000 - черный цвет;

    $00800000 - темно-красный цвет.

Взято с <https://delphiworld.narod.ru>