---
Title: Поддержка библиотеки сжатия ZLib
Author: RoboSol
Date: 01.01.2007
---


Поддержка библиотеки сжатия ZLib
================================

::: {.date}
01.01.2007
:::

В Delphi 7 официально включена поддержка библиотеки сжатия ZLib. Если у
вас более старшая версия посмотрите модули ZLib в дестрибутиве среды
(они должны быть на диске но подключать прийдеться самому).

Библиотеки под разные платформы, среды разработок и документация на
сайте www.gzip.org/zlib.

Степень сжатия превосходит алгоритм zip. Максимальная степень сжатия по
алгоритму ZLib приближается к степени сжатия упаковщиком RAR.

Модули Zlib, ZlibConst.

При использовании необходимо подключить в описании Uses модуль ZLib.

пример использования:

Компресия одного потока в другой:

    ComressStream( aSource, aTarget : TStream; compressionRate : TCompressionLevel );
    var comprStream : TCompressionStream;
    begin
       // compression level : (clNone, clFastest, clDefault, clMax)
       comprStream := TCompressionStream.Create( compressionRate, aTarget );
      try
       comprStream.CopyFrom( aSource, aSource.Size );
       comprStream.CompressionRate;
      finally
       comprStream.Free;
      End;
    End;

Декомпресия одного потока в другой:

    DecompressStream(aSource, aTarget: TStream);
    var decompStream : TDecompressionStream;
               nRead : Integer;
              buffer : array[0..1023] of Char;
    begin
       decompStream := TDecompressionStream.Create( aSource );
      try
        repeat
          nRead:=decompStream.Read( buffer, 1024 );
          aTarget.Write( buffer, nRead );
        Until nRead = 0;
      finally
       decompStream.Free;
      End;
    End;

Автор: RoboSol

Взято из <https://forum.sources.ru>
