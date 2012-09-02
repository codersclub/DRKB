<h1>Как вызвать метод предка?</h1>
<div class="date">01.01.2007</div>


<p>1) Есть Class1, с методом Mtd.</p>
<p>2) Есть Class2 унаследованный от Class1, метод Mtd перезаписан</p>
<p>3) В программе используется переменная типа Class2</p>
<p>Можно ли из программы вызвать Mtd от Class1, Другими словами, можно ли вызвать перезаписанный метод класса-предка?</p>
<p>Способ 1(только для не виртуальных методов)</p>
<pre>
var
  a:class2;
begin
a:=class2.Create;
class1(a).mtd;
....
end;
</pre>

<p class="author">Автор: Fantasist</p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
<hr />
<p>Способ со статическим приведением годится только для</p>
<p>не виртуальных методов, имеющих одно имя.</p>
<p>Вызов же виртуальных методов от статического типа не зависит.</p>
<p>В твоём простейшем случае достаточно написать inherited Mtd;</p>
<p>(ты его можешь вызвать из любого метода TClass2, не только из Mtd).</p>
<p>Трудности возникнут, когда нужно вызвать метод "дедушки" или "прадедушки" и т.д.</p>
<p>Один из способов, описанных в литературе, - временная замена</p>
<p>VMT объекта на "дедушку" и обратно. Но если у дедушки такого метода не было - будет облом.</p>
<p>Я предпочитаю такой способ:</p>
<pre>
type

 
 TProc = procedure of object;
procedure TClassN.SomeMethod;
var
 Proc: TProc;
begin
 TMethod(Proc).Code := @TClass1.Mtd; // Статический адрес
 TMethod(Proc).Data := Self;
 Proc();
end;
</pre>

<p class="author">Автор ответа: Le Taon</p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>

