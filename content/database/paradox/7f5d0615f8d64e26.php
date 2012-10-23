<h1>Byte-поля Paradox</h1>
<div class="date">01.01.2007</div>


<p>Что за магия при записи в поле Paradox Byte? По этому поводу в документации ничего не сказано.</p>

<p>Есть 2 пути получить доступ к данным в TBytesField.</p>

<p>Просто вызовите метод GetData, передавая ему указатель на буфер, где сам буфер должен иметь размер, достаточный для хранения данных:</p>
<pre>
procedure SetCheckBoxStates;
var
  CBStates: array[1..13] of Byte;
begin
  CBStateField.GetData(CBStates);
  { Здесь обрабатываем данные... }
end;
</pre>

<p>Для записи значений вы должны использовать SetData.</p>

<p>Используйте свойство Value, возвращающее вариантный массив байт (variant array of bytes):</p>
<pre>
procedure SetCheckBoxStates;
var
  CBStates: Variant;
begin
  CBStates := CBStateField.Value;
  { Здесь обрабатываем данные... }
end;
</pre>


<p>Первый метод, вероятно, для вас будет легче, поскольку вы сразу докапываетесь до уровня байт. Запись данных также получится сложнее, поскольку вам нужно будет работать с variant-методами типа VarArrayCreate и др.</p>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
