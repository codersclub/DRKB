---
Title: Проблема передачи записи
Date: 01.01.2007
---


Проблема передачи записи
========================

::: {.date}
01.01.2007
:::

Может это не то, что вы ищете, но идея такая:

Определите базовый класс с именем, скажем, allrecs:

    tAllrecs = class
    function getVal (field: integer): string; virtual;
    end;

Затем создаем классы для каждой записи:

    recA = class (tAllrecs)
    this      : Integer;
    that      : String;
    the_other : Integer;
    function getVal (field: integer): string; virtual;
    end;

Затем для каждой функции класса определите возвращаемый результат:

    function recA.getVal (field: integer); string;
    begin
    case field of
    1: getVal := intToStr (this);
    2: getVal := that;
    3: getVal := intToStr (the_other);
    end;
    end;

Затем вы можете определить

    function myFunc (rec: tAllrecs; field: integer);
    begin
    label2.caption := allrecs.getVal(field);
    end;

затем вы можете вызвать myFunc с любым классом, производным от tAllrecs,
например:

    myFunc (recA, 2);
    myFunc (recB, 29);

(getVal предпочтительно должна быть процедурой (а не функцией) с тремя
var-параметрами, возвращающими имя, тип и значение.)

Все это работает, т.к. данный пример я взял из моего рабочего проекта.

[Sid Gudes, cougar@roadrunner.com]

Если вы хотите за один раз передавать целую запись, установите на входе
ваших функций/процедур тип \'array of const\' (убедитесь в правильном
приведенни типов). Это идентично \'array of TVarRec\'. Для получения
дополнительной информации о системных константах, определяемых для
TVarRec, смотри электронную справку по Delphi.

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
