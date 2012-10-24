<h1>Удаление и добавление значений динамического массива</h1>
<div class="date">01.01.2007</div>


<pre>
type 
  TArrayString = array of string; 
 
procedure DeleteArrayIndex(var X: TArrayString; Index: Integer); 
begin 
  if Index &gt; High(X) then Exit; 
  if Index &lt; Low(X) then Exit; 
  if Index = High(X) then 
  begin 
    SetLength(X, Length(X) - 1); 
    Exit; 
  end; 
  Finalize(X[Index]); 
  System.Move(X[Index +1], X[Index], 
  (Length(X) - Index -1) * SizeOf(string) + 1); 
  SetLength(X, Length(X) - 1); 
end; 
 
// Example : Delete the second item from array a 
// Beispiel : Losche das 2. Element vom array a 
 
procedure TForm1.Button2Click(Sender: TObject); 
var 
  a: TArrayString; 
begin 
  DeleteArrayIndex(a, 2); 
end; 
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
&nbsp;</p>

<hr />

<div class="author">Автор: http://sunsb.dax.ru</div>

<p>Крутая штука динамический массив. Очень быстрая и здоровая реализация. Единственное, чего на мой взгляд не хватает, это механизма удаления элемента из середины массива и соответственно вставки в середину. Насколько я понял ( и проверил ), в памяти массив хранится по-разному в зависимости от типа его элементов. Скажм если в массиве строки(!! не shortString ) - хранятся указатели на них, а если прямоугольники (TRect) - то непосредственно сами прямоугольники.</p>
<p>Ниже привожу подпрограммы удаления и добавления элемента.</p>
<pre>
procedure delElem( var A:TRectArray; Index:integer );
var Last : integer;
begin
   Last:= high( A );
   if Index &lt;  Last then move( A[Index+1], A[ Index ],
       (Last-Index) * sizeof( A[Index] )  );
   setLength( A, Last );
end;
 
procedure addElem( var A: TRectArray; Index: integer;
                                       ANew: TRect );
var Len : integer;
begin
   Len:= Length( A );
   if Index &gt; = Len then Index := Len+1;
   setLength( A, Len+1);
   move( A[Index], A[ Index+1 ],
         (Len-Index) * sizeof( A[Index] ));
   A[Index] := ANew;
end;
 
 
</pre>
<p>Подпрограмма delElem полностью универсальна, а в addElem Вам нужно поменять тип добовляемого елемента (ANew) на требуемый.</p>

<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
