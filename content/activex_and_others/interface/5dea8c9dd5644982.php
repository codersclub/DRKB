<h1>Дайте теоретическое объяснение типу IDispatch</h1>
<div class="date">01.01.2007</div>


<p>Идентификатор интерфейса тип IDispatch, используемый для связи с объектом. Для создания объектов COM, не использующих интерфейс IDispatch, надо использовать функцию CreateComObject.</p>
<p>Руксскими словами: varDispatch &nbsp; &nbsp; &nbsp; &nbsp;$0009 &nbsp; &nbsp; &nbsp; &nbsp;ссылка на автоматический объект (указатель на интерфейс IDispatch)</p>
<p class="author">Автор: Snick_Y2K&nbsp; </p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
<hr />
<p>"Тип IDispatch" - не звучит. Ты бы сказал, в каком контексте.</p>
<p>Вообще, IDispatch - это интерфейс. Если ты заглянешь в System.pas, ты найдешь его делфийское описание:</p>
<pre>
 IDispatch=interface
  .....
 end;
</pre>

<p>Это интерфейс используется для обеспечения "позднего связывания" в COM, то есть вызовов методов(и использования property) когда на момент компиляции их имена не известны. Например:</p>
<pre>
var
  v:variant;
begin
  v:=CreateOleObject("Excel.Appication");
  v.Quit;
end;
</pre>

<p>  Как тут вызывается метод Quit? Ведь компилятор совершенно ничего не знает об этом методе, ровно как и о том, что содержится в переменно v. На самом деле, одна эта строчка транслируется компилятором в набор примерно таких вызовов:</p>
<pre>
var
  v:variant;
begin
  v:=CreateOleObject("Excel.Appication");
  if TVarData(v).vtType=vtIDispatch then
  begin
     pseudo_compiler_generated_IDispatch:IDispatch=TVarData(v).varIDispatch //указатель на интерфейс IDispatch
     cpl_gen_DispID:integer;
     pseudo_compiler_generated_IDispatch.GetIDsOfNames('Quit',1,cpl_gen_DispID);  //получаем числовой индефикатор имени "Quit"
     pseudo_compiler_generated_IDispatch.Invoke(cpl_gen_DispID,....); //вызывает метод по индификатору.
  end;
end;
</pre>

<p>Если использоват IDispatch вместо variant, то все это можно написать самому:</p>
<pre>
var
  Disp:IDispatch;
  DispID:integer;
begin
  Disp:=CreateOleObject("Excel.Appication");
  Disp.GetIDsOfNames('Quit',1,DispID);  //получаем числовой индефикатор имени "Quit"
  Disp.Invoke(DispID,....); //вызывает метод по индификатору.
end;
</pre>

<p class="author">Автор: Fantasist</p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
