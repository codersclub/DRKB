---
Title: Reading the autoincrement value of Paradox table
Date: 01.01.2007
---


Reading the autoincrement value of Paradox table
================================================

::: {.date}
01.01.2007
:::

The current highest value is stored beginning at byte 73 decimal.

The next value is determined by adding 1 to it.

Here is a simple Delphi function that returns the current

autoincrement value.

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
