---
Title: Русификация Kylix
Date: 01.01.2007
Source: <https://delphi.h5.ru>
---


Русификация Kylix
=================

В этой статье я решил рассказать тебе, как можно заставить Kylix уважать
русский язык. Для этого нужно полностью русифицировать Linux.
Это не так уж и сложно, и мы сейчас полностью опишем этот процесс.

Для Kylix желательно использовать кодовую страницу KOI-8r, которая
является практически стандартом русского языка в Linux. Для того, чтобы
Kylix мог понимать русские шрифты, нужно сделать следующее:

1. Открыть файл /etc/sysconfig/i18n и добавить в него следующие
недостающие строки:

        LANG=ru
        LANGUAGE=ru_RU.KOI8-R:ru #опционально
        LC_CTYPE=ru_RU.KOI8-R
        LC_NUMERIC=ru_RU.KOI8-R
        LC_TIME=ru_RU.KOI8-R
        LC_COLLATE=ru_RU.KOI8-R
        LC_MONETARY=ru_RU.KOI8-R
        LC_MESSAGES=ru_RU.KOI8-R
        LC_ALL=ru_RU.KOI8-R
        SYSFONT=UniCyr_8x16
        SYSFONTACM=koi8-r

Если какие-то из этих строк уже есть в файле, то нужно отредактировать
существующие.

В системе уже должны быть установлены русские шрифты. В последних
дистрибутивах почти всегда идут шрифты Cronyx Cyrillic, которых
достаточно для нормальной работы Kylix.

И последнее, что надо сделать - настроить переключение клавиатуры в
файле /etc/X11/XF86Config. Там нужно отредактировать следующие строки:

    Option "XkbLayout" "ru(winkeys)"
    Option "XkbOptions" "grp:ctrl_shift_toggle"

Последняя строка показывает, как будет переключатся раскладка.
В данном случае будет использоваться сочетание клавишь Ctrl+Shift.

Вот и всё!!!  
Желательно ещё и перегрузить Linux, чтобы он заговорил по русски.

