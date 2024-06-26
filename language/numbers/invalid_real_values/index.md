---
Title: Некорректные вещественные значения
Date: 01.01.2007
Source: DelphiWorld <https://delphiworld.narod.ru/>
---


Некорректные вещественные значения
==================================

> При использовании функции StrToFloat() для значения 1234.5544 я получаю
> что-то типа 1234.55440000000003, но ведь это неправильно!

Ничего здесь неправильного нет. Это просто погрешность чисел с плавающей
точкой. Фактически источником ошибки является ошибка округления. Данная
ошибка является следствием дефекта арифметики плавающей точки и того
факта, что чаще всего десятичные дроби являются повторяющимися долями в
двоичной системе счисления. Такие числа не могут представляться в
конечном количестве битов. В связи с этим текстовое округление
получается не всегда точным, т.к. большинство компьютеров подбирает
последние цифры дробной части, исходя из ближайшего (с наименьшей
разницей) эквивалента. Некоторые компьютеры не производят округления, а
просто обрезают (выключают) последние биты, получая результирующую
ошибку, правильно называемую ошибкой округления (в противоположность
ошибке усечения, когда усекается расширение ряда).

Для получения
дополнительной информации обратитесь к Introduction to Numerical Methods
(введение в числовые методы) авторов Peter A. Stark, Macmillian Company,
1970.

Из-за наличия ошибки сравнение двух чисел с плавающей точкой сводится к
учету абсолютной или относительной погрешности.

Для сравнения двух чисел с учетом абсолютной погрешности используйте
следующий код:


    IF ABS(CalculatedValue - TrueValue) < FuzzValue then ...

где `FuzzValue` определяет величину абсолютной погрешности.

Для сравнения двух чисел с учетом относительной погрешности используйте
следующий код:

    IF ABS( (CalculatedValue - TrueValue) / TrueValue ) < AcceptableRelativeError then ...

где `AcceptableRelativeError` определяет величину относительной
погрешности (ну, и конечно, TrueValue \<\> 0.0).

Математический модуль Delphi вычисляет относительную погрешность
следующим образом (но оно не вынесено в секцию interface):

    FUNCTION RelSmall(X, Y: Extended): Boolean;
    { Возвращаем Истину, если разница между X и Y незначительна }
    CONST
      C1: Double = 1E-15;
      C2: Double = 1E-12;
    BEGIN
      Result := Abs(X) < (C1 + C2 * Abs(Y))
    END;

