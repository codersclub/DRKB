<h1>Поддержка библиотеки сжатия ZLib</h1>
<div class="date">01.01.2007</div>


<p>В Delphi 7 официально включена поддержка библиотеки сжатия ZLib. Если у вас более старшая версия посмотрите модули ZLib в дестрибутиве среды (они должны быть на диске но подключать прийдеться самому). </p>
<p>Библиотеки под разные платформы, среды разработок и документация на сайте www.gzip.org/zlib. </p>
<p>Степень сжатия превосходит алгоритм zip. Максимальная степень сжатия по алгоритму ZLib приближается к степени сжатия упаковщиком RAR.</p>
<p>Модули Zlib, ZlibConst.</p>
<p>При использовании необходимо подключить в описании Uses модуль ZLib.</p>
<p>пример использования:</p>
<p>Компресия одного потока в другой:</p>
<pre>
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
</pre>
<p>Декомпресия одного потока в другой:</p>
<pre>DecompressStream(aSource, aTarget: TStream);
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
</pre>

<p class="author">Автор RoboSol</p>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
