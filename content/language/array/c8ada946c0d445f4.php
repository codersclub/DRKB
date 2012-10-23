<h1>Работа с большими массивами</h1>
<div class="date">01.01.2007</div>


<p>Распределите память кучи с помощью GetMem. Если вы имеете:</p>

<pre>
var a, b: array[0..30000]: Integer;
</pre>

<p>то попробуйте:</p>

<pre>
type  TBigArray = array[0..30000] of Integer;
var  a, b: ^TBigArray;
</pre>

<p>и во внешнем блоке сделайте:</p>
<pre>
GetMem(a, SizeOf(TBigArray));
GetMem(b, SizeOf(TBigArray));
</pre>

<p>Также необходимо применять указатели на память вместо ссылок, например взамен:</p>

<pre>
a[0] := xxx; 
</pre>

<p>необходимо использовать</p>

<pre>
a^[0] := xxx; 
</pre>

<p>Взято из Советов по Delphi от <a href="mailto:mailto:webmaster@webinspector.com" target="_blank">Валентина Озерова</a></p>
<p>Сборник Kuliba</p>



<hr />
<p class="p_Heading1">Заставить Delphi работать с достаточно большим массивом данных</p>
<p class="p_Heading1">
<pre>
procedure TForm1.Button1Click(Sender: TObject);
  type
    TMyRec = record
    i1, i2, i3: Integer;
  end;
  TMyArr = array[1..20000000] of TMyRec;
  PMyArr=^TMyArr;
var
  A: PMyArr;
begin
  GetMem(A, SizeOf(TMyArr));
  A^[1].i1 := 100;
  ShowMessage('Ok' + IntToStr(A^[1].i1));
  FreeMem(A);
end;
 
</pre>
<a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
<p class="p_Heading1">
<hr />В 16-битной версии Delphi нельзя сделать это непосредственно. В новой, 32-битной версии, это как-то можно сделать, но за два месяца колупания я так и не понял как. (Некоторые бета-тестеры знают как. Не могли бы они сообщить нам всю подноготную этого дела?)</p>

<p>В 16-битной версии Delphi вам необходимо работать с блоками по 32K или 64K и картой. Вы могли бы сделать приблизительно следующее:</p>

<pre>
type
chunk:     array[0..32767] of byte;
pchunk:    ^chunk;
 
var
BigArray:  array[0..31] of pChunk;
</pre>

<p>Для создания массива:</p>

<pre>
for i := 0 to high(bigArray) do
  new(bigArray[i]);
</pre>

<p>Для получения доступа к n-ному байту в пределах массива (n должен иметь тип longint):</p>
<pre>
bigArray[n shr 15]^[n and $7FFF] := y;
x := bigArray[n shr 15]^[n and $7fff];
</pre>

<p>Это даже осуществляет проверку выхода за границы диапазона, если вы установили в ваших настройках опцию "range checking"!</p>

<p>n должен находиться в диапазоне [0..32*32*1024] = [0..1024*1024] = [0..1048576].</p>

<p>Для освобождения массива после его использования необходимо сделать следующее:</p>

<pre>
for i := 0 to high(bigArray) do
  dispose (bigArray[i]);
</pre>
<a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>



<p class="p_Heading1">Примечание от Vit: проблемы с большими массивами были актуальны в 16 битных средах (DOS, Windows 3x), когда использовалась сегментированная модель памяти и было затруднительно напрямую адресовать блоки больее 64K, в 32 разрядных системах подобные проблемы возникают значительно реже, при размерах массивов превосходящих 2Gb, что согласитесь даже в современном программировании дело далеко не частое. Для адресации более 2Gb см. статьи по AWE для 32 разрядных систем.</p>
