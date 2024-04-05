---
Title: Byte-поля Paradox
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Byte-поля Paradox
=================

> Что за магия при записи в поле Paradox Byte?
> По этому поводу в документации ничего не сказано.

Есть 2 пути получить доступ к данным в TBytesField.

Просто вызовите метод GetData, передавая ему указатель на буфер, где сам
буфер должен иметь размер, достаточный для хранения данных:

    procedure SetCheckBoxStates;
    var
      CBStates: array[1..13] of Byte;
    begin
      CBStateField.GetData(CBStates);
      { Здесь обрабатываем данные... }
    end;

Для записи значений вы должны использовать SetData.

Используйте свойство Value, возвращающее вариантный массив байт (variant
array of bytes):

    procedure SetCheckBoxStates;
    var
      CBStates: Variant;
    begin
      CBStates := CBStateField.Value;
      { Здесь обрабатываем данные... }
    end;

Первый метод, вероятно, для вас будет легче, поскольку вы сразу
докапываетесь до уровня байт. Запись данных также получится сложнее,
поскольку вам нужно будет работать с variant-методами типа
VarArrayCreate и др.

