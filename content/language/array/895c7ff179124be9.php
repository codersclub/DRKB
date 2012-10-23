<h1>Запись массива на диск</h1>
<div class="date">01.01.2007</div>


<p>Скажем, ваша структура данных выглядит следующим образом:</p>

<pre>
type
  TMyRec = record
    SomeField: Integer;
    SomeOtherField: Double;
    TheRest: array[0..99] of Single;
  end;
</pre>

<p>и TBlobField имеет имя MyBlobField. TMyRec назван как MyRec. Для копирования содержимого MyRec в MyBlobField необходимо сделать следующее:</p>

<pre>
var
  Stream: TBlobStream;
begin
  Stream := TBlobStream.Create(MyBlobField, bmWrite);
  Stream.Write(MyRec, SizeOf(MyRec));
  Stream.Free;
end;
</pre>

<p>Есть другой путь:</p>

<pre>
var
  Stream: TBlobStream;
begin
  Stream := TBlobStream.Create(MyBlobField, bmRead);
  Stream.Read(MyRec, SizeOf(MyRec));
  Stream.Free;
end;
</pre>


<p>- Steve Schafer</p>
<p>Взято из Советов по Delphi от <a href="mailto:mailto:webmaster@webinspector.com" target="_blank">Валентина Озерова</a></p>
<p>Сборник Kuliba</p>


<hr />
<pre>
type
  TCharArray = array[500] of Char;
 
procedure WriteToFile(var aArray: TCharArray; sFileName: string); {Примечание:
Объявление массива как параметр Var позволяет передавать только ссылку на массив,
а не копировать его целиком в стек, если же вам нужна безопасная работа с массивом,
то вам не следует передавать его как var-параметр. }
var
  nArrayIndex: Word;
  fFileHandle: TextFile;
begin
  AssignFile(fFileHandle, sFileName);
  Rewrite(fFileHandle);
 
  for nArrayIndex := 1 to 500 do
  begin
    Write(fFileHandle, aArray[nArrayIndex]);
  end;
 
  CloseFile(fFileHandle);
end; {end Procedure, WriteToFile()}
 
</pre>
<a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>

