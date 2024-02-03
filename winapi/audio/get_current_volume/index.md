---
Title: Как определить уровень звука в данный момент?
Author: Vit
Date: 01.01.2007
---


Как определить уровень звука в данный момент?
=============================================

::: {.date}
01.01.2007
:::

Единственное, что удалось найти это компонент на Дельфи (с исходным
кодом) на
[https://www.torry.net/mixer.htm](https://www.torry.net/mixer.htm%20)
компонент называется Vumeter v.1.0. Я его не разбирал, но похоже что он
опрашивает Audio Mixer Driver (или что-то подобное).

Автор: Vit

Взято с Vingrad.ru <https://forum.vingrad.ru>

------------------------------------------------------------------------

Я построил диограмму так: Назначил

    F:= TFileStream.Create(OpenDialog1.FileName, fmOpenRead );

Затем считал заголовок

    Wav - SampleCount, SamplesPerSec, BitsPerSample, Channeles.

Затем считал данные:

    GetMem(buf, SampleCount * Channeles * BitsPerSample);

Описал массив Volume:

    SetLength(Volume, SampleCount);

Затем:

    F.Read(buf\^, SampleCount*2); F.Free;

Затем заполнил массив:

    buf16 := buf;
    for h := 0 to SampleCount - 1 do
      begin
        Volume[h] := abs(buf16^);
        inc(buf16);
      end;
    FreeMem(buf);

Затем строил график(в экранных координатах) - по горизонтальной оси
откладывал значения SampleCount, по вертикальной значения Volume[h].

График получается точно такой же как в SoundForge.

Единственно, я писал программу для конкретного случая - у меня файлы по
10 минут, моно, 11025 Гц., 16 бит. Так что программа у меня не
универсальная. Но работает нормально. По времени: обработка файла и
построение графика около 4 -5 секунд.

Автор: TPavel

Взято с Vingrad.ru <https://forum.vingrad.ru>
