---
Title: Чтение значения автоинкремента таблицы Paradox
Date: 01.01.2007
---


Чтение значения автоинкремента таблицы Paradox
==============================================

Текущее наибольшее значение сохраняется, начиная с байта 73 в десятичном измерении.

Следующее значение определяется добавлением к нему 1.

Вот простая функция Delphi, которая возвращает текущее значение автоинкремента.

    function getAutoInc(filename: string): LongInt;
    var
      mystream: tfilestream;
      buffer: longint;
    begin
      mystream := tfilestream.create(filename,
        fmOpenread + fmShareDenyNone);
      mystream.Seek(73, soFromBeginning);
      mystream.readbuffer(buffer, 4);
      mystream.Free;
      getAutoInc := buffer;
    end;
