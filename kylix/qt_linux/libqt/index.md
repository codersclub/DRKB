---
Title: Libqt для Kylix с поддержкой сглаживания
Author: haword
Date: 01.01.2007
---


Libqt для Kylix с поддержкой сглаживания
========================================

::: {.date}
01.01.2007
:::

Люди, просьба, проверте работает ли на ваших дистрибутивах сие чудо
перед запуском программы на Kylix напишите в командной строке

export CLX\_USE\_LIBQT="True"

export QT\_XFT="1"

скопируйте эти библиотеки в /usr/lib и попробуйте запустить потом свою
прогу из этой же консоли, чтоб переменные окружения не пропали! Надеюсь
заработает

https://cracker-shym.narod.ru/program/Kylix/libqt.zip

У меня на 10 SlackWare заработало

Добавил еще откомпилированную версию libqt версии 2.3.2, последнюю из
QT2, вроде также работает на СлакВаре 10, попутно велез баг, известный у
QT2 давно, не видит шрифты некоторые при включенном сглаживании шрифтов,
так что некоторые надписи могут не показыватся пока не сменишь шрифт, а
так вроде работает!

Автор: haword

Взято с Vingrad.ru <https://forum.vingrad.ru>
