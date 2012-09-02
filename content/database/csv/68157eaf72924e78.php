<h1>Быстрая обработка CSV файла</h1>
<div class="date">01.01.2007</div>



<p>Классы Tstrings/TStringlist имеют свойство commatext, которое автоматически разделяет строки, содержащие разделители, на отдельные части. Пример показывает как считать CSV файл. В Конечном итоге, автоматически разделённые строки содержатся в TStringlist. </p>
<pre>
var
  ts: tstringlist;
  S: string;
  Tf: Textfile;
begin
  Ts := Tstringlist.create;
  Assignfile(tf, 'filename');
  Reset(tf);
  while not eof(tf) do
  begin
    Readln(tf,S);
    Ts.CommaText := S;
    //ProcessLine;
  end;
  closefile(tf);
  ts.free;
end;
</pre>


<p>Так же операцию можно производить в обратном порядке. </p>

<p>Свойство Commatext поддерживает разделители как в виде запятых, так и двойных кавычек: 1,2,3,4 и "1","2","3","4" </p>

<p>Например, строка вида "1","2,3","4" будет разделена на три элемента, которые заключены в кавычки (средняя запятая будет проигнорирована). Чтобы включить кавычку в конечный результ, нужно поставить две кавычки подряд: "1",""2" (результат будет 1 и "2 ). </p>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>

