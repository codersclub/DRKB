---
Title: Справочник свойств CSS1
Date: 01.01.2007
---


Справочник свойств CSS1
=======================

**1. Свойства шрифта - font.**

`font-family` - определяет тип используемого шрифта.
Если данное значение не указано, то шрифт выбирается браузером клиента.
У клиента может не оказаться нужного Вам шрифта, поэтому можно указывать
несколько видов шрифтов в порядке их предпочтения, разделяя названия
запятыми. Если ни одного из выбранных шрифтов в распоряжении браузера не
окажется, то браузер проигнорирует инструкции и использует свой шрифт
для отображения текста.

Свойство поддерживает механизм наследования.

`font-size` - размер букв.  
Допустимые значения:

- (xx-small, x-small, small, medium, large, x-large, x-large, xx-large)
- (larger, smaller)
- (относительные размеры - em, en, ex, px / абсолютные размеры - in, cm, mm, pt, pc)
- (значения даны в процентах от родительского размера шрифта)

Если значение не указано, то по умолчанию используется значение medium.  
Свойство поддерживает механизм наследования.

`font-style` - стиль написания букв.  
Допустимые значения:  
normal, italic, oblique  
Если значение не указано, то по умолчанию используется значение normal.  
Свойство поддерживает механизм наследования.

`font-variant` - вид текста (обычный, либо написание заглавными буквами
размером в строчные)  
Допустимые значения: normal, small-caps  
Если значение не указано, то по умолчанию используется значение normal.  
Свойство поддерживает механизм наследования.

`font-weight` - жирность текста  
Допустимые значения: normal, bold, bolder, lighter или числа от 100 до
900.  
Значение по умолчанию - normal.  
Свойство поддерживает механизм наследования.

**2. Свойства цвета - color.**

Допустимые значения - название цвета или номер.
Номерное значение может задаваться несколькими способами. Это может быть
номер в шестнадцатеричной системе (#FFFFFF), в десятичной системе (255,
0, 0) или в процентной записи (80%, 20%, 0%)  
Если цвета не указаны, то цвет выбирается согласно настроек браузера
клиента.  
Свойство поддерживает механизм наследования.

**3. Свойство фона - background.**

`background` - фон. Данное свойство имеет несколько атрибутов:

- transparent - данный атрибут указывает на то, что фон является
прозрачным, что синонимично отсутствию фона как такового.
- color - данный атрибут указывает на цвет фона.
- URL - данный атрибут указывает адрес файла, в случае использования в
картинки качестве фона. Адрес может быть как абсолютным, так и
относительным, но должен обязательно заключаться в скобки:

        BODY { background: url(http://www.somewhere.com/image/fon.gif) }

В случае когда указываются и цвет фона и фоновая картинка, картинка
всегда помещается поверх цвета.

- repeat - данный атрибут определяет степень повторяемости фоновой
картинки и может иметь следующие значения:  
    `repeat` - картинка бесконечно
    повторяется по горизонтали и вертикали, заполняя собой все фоновое
    пространство браузера;  
    `repeat-x` - картинка повторяется по горизонтали;  
    `repeat-y` - картинка повторяется по вертикали; no-repeat картинка не
    повторяется.  
    Если значения не указаны, то по умолчанию используется
    значение - `repeat`.

`scroll` - данный атрибут определяет подвижность фоновой картинки.  
Атрибут может иметь значение `scroll`, означающее, что фон прокручивается вместе с
содержанием web-документа, или значение `fixed`, означающие, что при
прокручивании документа фон остается неподвижным.  
По умолчанию принимается значение `scroll`.

`position` - атрибут определяет положение картинки в окне браузера.
Значения могут быть: top, middle, bottom, left, center, right, или же
положение может быть задано в виде абсолютного растояния от левой и
верхней кромки окна браузера (горизонтальное, вертикальное) или же в
виде процентных отношений (горизонтальное, вертикальное). По умолчанию
фоновая картинка прикрепляется к верхнему левому углу окна браузера.

Существуют и возможности вынесения некоторых характеристик фона в
отдельные свойства:

`background-attachment` - фиксация фона.  
Допустимые значения: scroll, fixed.  
Значение по умолчанию: scroll

`background-color` - цвет фона.  
Допустимые значения: transparent или указание цвета.  
Если указывается цвет фона, то он может быть чистым в виде названия
цвета или его номера (см. выше раздел "Свойства цвета") или смешанным,
когда цвет фона не указывается явно, а является смешением разных цветов.  
Значение по умолчанию: transparent.  
Синтаксис указания смешанного цвета фона следующий:

    BODY { background-color: red/blue }


`background-image` - рисунок фона.  
Допустимые значения: none или указание адреса расположения фоновой
картинки.  
Значение по умолчанию: none

`background-position` - расположение фона.  
Допустимые значения: top, center, bottom, left, right, цифровые
значения.  
Значение по умолчанию: left, top.

`background-repeat` - повторяемость фона.  
Допустимые значения: repeat, repeat-x, repeat-y, no-repeat.  
Значение по умолчанию: repeat.

Ни одно из свойств, относящихся к фону, не поддерживает механизм
наследования.

**4. Свойства текста.**

`letter-spacing` - расстояние между буквами.  
Допустимые значения: normal или значение в единицах измерения.  
Значение по умолчанию: normal  
Свойство поддерживает механизм наследования.

`line-height` - высота текущей строки.  
Допустимые значения: normal, число, единицы измерения, процент.  
Числовые значения интерпретируются как текущий размер шрифта, умноженный
на соответствующее число.  
Значение по умолчанию определяется браузером клиента.  
Свойство поддерживает механизм наследования.

`list-style` - отображение элементов списка.  
Данное свойство имеет несколько атрибутов: набор ключевых слов, position
описывающий расположение списка, url - адрес файла при использовании
индивидуального графического маркера.  
Свойство поддерживает механизм наследования и позволяет выносить
атрибутику в самостаятельные детализированные свойства:

`list-style-image` - адрес картинки, используемой в качестве маркера.  
Допустимые значения: none или url картинки.  
Значение по умолчанию: none.  
Свойство поддерживает механизм наследования.

`list-style-type` - вид маркера.  
Допустимые значения: none, circle, disk, square, demical, lower-alpha,
upper-alpha, lower-roman, upper-roman  
Значение по умолчанию: disk.  
Свойство поддерживает механизм наследования.

`list-style-position` - свойство определяет внутри или вне тела списка
расположен маркер.  
Допустимые значения: inside, outside.  
Значение по умолчанию: outside.  
Свойство поддерживает механизм наследования.

`text-align` - выравнивание текста.  
Допустимые значения: left, right, center, justify.``
Значение по умолчанию: определяется браузером клиентом.  
Свойство поддерживает механизм наследования.

`text-decoration` - специальные эффекты текста.  
Допустимые значения: none, overline, underline, line-through.  
Значение по умолчанию: none.  
Свойство не поддерживает механизм наследования.

`text-indent` - величина отступа.  
Допустимые значения: единица измерения или процент относительно
родительского элемента.  
Значение по умолчанию: zero.  
Свойство поддерживает механизм наследования.

`text-transform` - трансформация текста.  
Допустимые значения:

- capitalize - делает заглавной первую букву каждого слова.
- uppercase - делает все буквы заглавными
- lowercase - делает все буквы в словах элемента строчными
- none - снимает все установки, приобретенные в результате наследования.

Значение по умолчанию: none.  
Свойство поддерживает механизм наследования.

`vertical-align` - расположение элемента по вертикали.  
Допустимые значения:

- baseline - выравнивание по образцу родительского элемента.
- sub - переводит элемент в нижний регистр
- super - переводит элемент в верхний регистр
- top - выравнивание элемента по верху самого высокого элемента строки
- bottom - выравнивание элемента по низу самого низкого элемента строки
- text-top - выравнивание элемента по верху текста, набранного шрифтом
родительского элемента
- text-bottom - выравнивание элемента по низу текста, набранного шрифтом
родительского элемента
- middle - выравнивание элемента по средней линии на основе родительского
элемента плюс половина строки последнего.
- процент

Значение по умолчанию: baselign.  
Свойство не поддерживает механизм наследования.

**5. Свойства, связанные с рамками и размерами.**

Их значения характеризуют
области вокруг различных элементов (картинка, символ и др.)

`border` - определение свойств рамки.  
Свойство может быть детализировано:  
border-top, border-right, border-left, border-bottom.  
Свойство имеет несколько атрибутов со своими значениями:

- border-width - ширина рамки со значениями thin, medium, thick или
    единицы измерения. Значение по умолчанию - medium.
- border-style - стиль рамки со значениями none или solid. Значение по
    умолчанию - none.
- color - определение цвета фона элемента до того как элемент загрузится,
    а также цвета фона под прозрачными частями элемента. В качестве значения
    указывается цвет или URL картинки (в этом случае картинка будет
    повторятся до заполнения всего фонового пространства элемента.  
    Значение по умолчанию - нет цвета.

    Свойство не поддерживает механизм наследования.

`border-color` - определяет цвет рамки.  
Данное свойство можно детализировать:  
border-top-color, border-right-color, border-left-color, border-bottom-color.  
Допустимые значения: указание цвета или URL картинки (в этом случае
картинка будет повторяться, образуя рамку).  
Значение по умолчанию: без цвета.  
Свойство не поддерживает механизм наследования.

`border-style` - определяет стиль отображения рамки. Свойство можно детализировать:  
border-top-style, border-right-style, border-left-style, border-bottom-style.  
Допустимые значения: none, solid, double, groove, ridge, inset, outset.  
Значение по умолчанию: none.  
Свойство не поддерживает механизм наследования.

`border-width` - определение ширины рамки.  
Свойство может быть детализировано:  
border-top-width, border-right-width, border-left-width,
border-bottom-width.  
Допустимые значения: thin, medium, thick или единицы измерения.  
Значение по умолчанию: medium.  
Свойство не поддерживает механизм наследования.

`clear` - указывает, что следующие элементы должны быть расположены ниже
элемента выравненного по левому или правому краю, а не "обтекать" его
по умолчанию.  
Допустимые значения: none, both, right, left.  
Значение по умолчанию: none.  
Свойство не поддерживает механизм наследования.

`clip` - определяет какая часть элемента видна.  
Допустимые значения: rect () или auto  
Значение по умолчанию: auto  
Свойство не поддерживает механизм наследования.

`display` - свойство, определяющее следует ли отображать элемент.  
Допустимые значения: " ", none.  
Значение по умолчанию: " ".  
Свойство не поддерживает механизм наследования.

`float` - указывает на обтекание элемента другими.  
Допустимые значения: none, left, right.  
Значение по умолчанию: none.  
Свойство не поддерживает механизм наследования и применяется к элементам
категории DIV, SPAN.

`height` - устанавливает высоту элемента и измеряет ее при необходимости.
В таком случае значение возвращается как строка, включающая тип единиц
измерения (px, % и т.д.). Для получения значения в виде числа
используется запись posHeight.  
Допустимые значения: auto или значение в единицах измерения.  
Значение по умолчанию: auto.  
Свойство не поддерживает механизм наследования и применяется к элементам
категории DIV, SPAN.

`left` - устанавливает горизонтальную координату элемента. Значение
возвращается как строка, включающая тип едининцы измерения (px, % и
т.д.) Для получения значения в виде числа используется запись posLeft.  
Допустимые значения: auto, процент относительно родительского элемента,
единицы измерения.  
Значение по умолчанию: zero.  
Свойство не поддерживает механизм наследования.

`margin, margin-top, margin-bottom, margin-left, margin-right` -
устанавливает размеры отступов вокруг элемента.  
Допустимые значения: auto, единицы измерения, процент относительно
родительского элемента.  
Значение по умолчанию: zero.  
Свойство не поддерживает механизм наследования.

`overflow` - определяет поведение элемента при выходе его за свои
границы.  
Допустимые значения: none (элемент будет отображаться и за рамками своих
границ), clip (выступающие части будут обрезаны), scroll (выступающие
части не отображаются за пределами границ, но их можно увидеть с помощью
прокрутки).  
Значение по умолчанию: none.  
Свойство не поддерживает механизм наследования.

`padding, padding-top, padding-bottom, padding-left, padding-right` -
определяет расстояние между элементом и его рамкой.  
Допустимые значения: auto, единицы измерения, процент относительно
родительского элемента.  
Значение по умолчанию: zero.  
Свойство не поддерживает механизм наследования.

`position` - определяет способ позиционирования элемента на экране.  
Допустимые значения:

- absolute ( расположение элемента относительно фона
и перемещение вместе с ним),
- static (элемент располагается относительно
фона, но неподвижен при прокручивании),
- relative (элемент позиционируется относительно других элементов согласно своему положению
в коде).

Значение по умолчанию: relative.  
Свойство не поддерживает механизм наследования.

`top` - устанавливает или возвращает вертикальную координату элемента.  
Значение возвращается как строка с указанием типа единиц измерения (px,
% и т.д.) Для получения значения в виде числа используется запись
posTop.  
Допустимые значения: auto, единицы измерения или процент относительно
родительского элемента.  
Значение по умолчанию: auto.  
Свойство не поддерживает механизм наследования.

`visibility` - определяет видимость элемента.  
Допустимые значения: visible (элементвидим), hidden (элемент невидим),
inherit (элемент виден, если виден его родительский элемент).  
Значение по умолчанию: inherit.  
Свойство не поддерживает механизм наследования.

`width` - устанавливает и измеряет ширину элемента. Значение возвращается
как строка, включающая тип единиц измерения (px, % и т.д.) Для получения
значения в виде числа следует использовать запись posWidth.  
Допустимые значения: auto, единицы измерения или процент относительно
родительского элемента.  
Значение по умолчанию: auto (за исключением элементов с внутренними
установками размера)  
Свойство не поддерживает механизм наследования.

`z-index` - определяет порядок перекрывания одних элементов другими.  
Элементы с более высоким z-index будут находиться поверх элементов с
более низким z-index.  
Допустимые значения: число.  
Значение по умолчанию: в зависимости от контекста.  
Свойство не поддерживает механизм наследования.
