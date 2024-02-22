---
Title: Использование многомерных массивов в процедурах и функциях из math.pas
Author: Александр Шарахов, alsha@mailru.com
Date: 18.04.2003
---


Использование многомерных массивов в процедурах и функциях из math.pas
======================================================================

    { **** UBPFD *********** by kladovka.net.ru ****
    >> Использование многомерных массивов в процедурах и функциях из Math.pas
     
    Многим процедурам и функциям из Math.pas в качестве одного из параметров требуется одномерный открытый массив, например:
    function Mean(const Data: array of Double): Extended;
    function Sum(const Data: array of Double): Extended;
    function MinValue(const Data: array of Double): Double;
    function MaxValue(const Data: array of Double): Double;
     
    Эти процедуры и функции можно применить также для работы с многомерными массивами или подмассивами одномерного массива, приводя их тип и заменяя описание открытого массива на пару "Data: pointer; Bound: integer", где первый параметр - указатель на первый обрабатываемый элемент массива, второй - количество обрабатываемых элементов минус 1. 
    Например, для доступа к функции MaxIntValue можно использовать тип: 
    TMaxIntValue = function(Data: pointer; Bound: integer): integer;
     
    Зависимости: Math
    Автор:       Александр Шарахов, alsha@mailru.com, Москва
    Copyright:   Александр Шарахов
    Дата:        18 января 2003 г.
    ********************************************** }
     
    type // Тип для доступа к MaxIntValue
      TMaxIntValue = function(Data: pointer; Bound: integer): integer; 

Пример использования:

    type // Тип для доступа к MaxIntValue
      TMaxIntValue = function(Data: pointer; Bound: integer): integer;
    var
      a: array[1..2,1..2,1..2] of integer;
      b: integer;
    begin
      // Эквивалент для b:=MaxIntValue(a); если бы так можно было писать
      b:=TMaxIntValue(@MaxIntValue)(@a,SizeOf(a) div SizeOf(integer)-1);
    end; 
