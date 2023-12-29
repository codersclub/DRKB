---
Title: Формат wave файла
Date: 01.01.2007
---


Формат wave файла
=================

::: {.date}
01.01.2007
:::

    TWaveHeader = record
      Marker1: array[0..3] of Char;
      BytesFollowing: LongInt;
      Marker2: array[0..3] of Char;
      Marker3: array[0..3] of Char;
      Fixed1: LongInt;
      FormatTag: Word;
      Channels: Word;
      SampleRate: LongInt;
      BytesPerSecond: LongInt;
      BytesPerSample: Word;
      BitsPerSample: Word;
      Marker4: array[0..3] of Char;
      DataBytes: LongInt;
    end;

Для создания собственного WAV-файла сделайте следующее:

    DataBytes := Channels;
    DataBytes := DataBytes * SampleRate;
    DataBytes := DataBytes * Resolution;
    DataBytes := DataBytes div 8;
    DataBytes := DataBytes * Duration;
    DataBytes := DataBytes div 1000;
     
    WaveHeader.Marker1 := 'RIFF';
    WaveHeader.BytesFollowing := DataBytes + 36;
    WaveHeader.Marker2 := 'WAVE';
    WaveHeader.Marker3 := 'fmt ';
    WaveHeader.Fixed1 := 16;
    WaveHeader.FormatTag := 1;
    WaveHeader.SampleRate := SampleRate;
    WaveHeader.Channels := Channels;
    WaveHeader.BytesPerSecond := Channels;
    WaveHeader.BytesPerSecond := WaveHeader.BytesPerSecond * SampleRate;
    WaveHeader.BytesPerSecond := WaveHeader.BytesPerSecond * Resolution;
    WaveHeader.BytesPerSecond := WaveHeader.BytesPerSecond div 8;
    WaveHeader.BytesPerSample := Channels * Resolution div 8;
    WaveHeader.BitsPerSample := Resolution;
    WaveHeader.Marker4 := 'data';
    WaveHeader.DataBytes := DataBytes;

Остальная часть файлы является звуковыми данными. Порядок следования:
верхний уровень для левого канала, верхний уровень для правого канала и
так далее. Для моно или 8-битных файлов сделайте соответствующие
изменения.

Взято из Советов по Delphi от [Валентина Озерова](mailto:webmaster@webinspector.com)

Сборник Kuliba
