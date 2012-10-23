<h1>Еще шаг в направлении COM</h1>
<div class="date">01.01.2007</div>


<p>Сделаем еще шаг в направлении Component Object Module (COM).Даже сейчас у экспортируется довольно много функций. Соответсвенно и в программе нам надо сделать несколько ступений - создать переменную-указатель, присвоить ей значение адреса нужной функции при помощи GetProcAddress, и только потом вызвать саму функцию. Причем все эти функции у нас сами по себе и никак не связанны с самим объектом, который мы используем. А неплохо бы сделать так, чтобы можно было работать с ними как с объектом, что нибудь типа:</p>
<p>Сalc.SetOperands(13,10);</p>
<p>i:=Calc.Sum;</p>
<p>Так давайте так и сделаем! Правда мы ограничены экспортом только функций, но мы сделаем так:</p>
<p>Добавим в dll такую запись</p>
<pre>type
ICalc=record
SetOpers:procedure (x,y:integer);
Sum:function:integer;
Diff:function:integer;
Release:procedure;
end;
 
</pre>
<p>и процедуру:</p>
<pre>procedure GetInterface(var Calc:ICalc);
begin
CreateObject;
Calc.Sum:=Sum;
Calc.Diff:=Diff;
Calc.SetOpers:=SetOperands;
Calc.Release:=ReleaseObject;
end;
</pre>

<p>и будем экспортировать только ее:</p>
<pre>exports
GetInterface; 
 
</pre>
<p>Видете что происходит? Теперь вместо того, чтобы получать адрес каждой функции, мы можем получить сразу всю таблицу адресов. Причем создание объекта происходит в этой же функции, и пользователю больше не нужно знать функцию CreateObject и не забыть ее вызвать.</p>
<p>Переделаем наш тестер.</p>
<p>В описание типов добавим:</p>
<pre>type
ICalc=record
SetOpers:procedure (x,y:integer);
Sum:function:integer;
Diff:function:integer;
Release:procedure;
end;
</pre>

<p>изменим секцию var.</p>
<pre>var
Form1: TForm1;
_Mod:Integer;
GetInterface:procedure (var x:ICalc);
Calc:ICalc;
</pre>

<p>и процедуры где мы используем наш объект.</p>
<pre>
procedure TForm1.FormCreate(Sender: TObject);
begin
_Mod:=LoadLibrary('CalcDll.dll');
GetInterface:=GetProcAddress(_Mod,'GetInterface');
GetInterface(Calc);
Calc.SetOpers(13,10);
end;
procedure TForm1.FormDestroy(Sender: TObject);
begin
Calc.Release;
FreeLibrary(_Mod);
end;
procedure TForm1.Button1Click(Sender: TObject);
begin
ShowMessage(IntToStr(Calc.diff));
end;
procedure TForm1.Button2Click(Sender: TObject);
begin
ShowMessage(IntToStr(Calc.Sum));
end;
</pre>
<p>Теперь со стороны может показаться, что мы пользуемся объектом, хотя на самом деле это всего лиш таблица с указателями на функции.</p>

