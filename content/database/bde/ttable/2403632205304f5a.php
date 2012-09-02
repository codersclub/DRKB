<h1>Поиск значения при вводе</h1>
<div class="date">01.01.2007</div>


<p>Каким способом можно производить поиск подходящих величин в момент ввода? Табличный курсор (визуально) должен перемещаться к наиболее подходящему значению при добавлении пользователем новых символов водимой величины. </p>

<p>Первоначально код писался под Delphi 1. Это может и не лучшее решение, но это работает. </p>

<p>Для поиска величины таблица держится открытой. Индекс должен, естественно, принадлежать полю, используемому элементом управления EditBox. В случае изменения содержимого EditBox, новое значение используется для вызова стандартной функции FindNearest таблицы TTable. Возвращаемая величина снова присваивается свойcтву Text элемента EditBox. </p>

<p>Я привел лишь общее решение задачи. Фактически во время изменения значения я включал таймер на период 1/3 секунды и в обработчике события OnTimer проводил операцию поиска (с выключением таймера). Это позволяло пользователю набирать без задержки нужный текст без необходимости производить поиск в расчете на вновь введенный символ (поиск проводился только при возникновении задержки в 1/3 секунды). </p>

<p>Вам также может понадобиться специальный обработчик нажатия клавиши backspace или добавления символа в любое место строки. </p>

<p>Вместо возвращения результатов элементу EditBox (который перезаписывает введенное пользователем значение), вы можете передавать результаты другому элементу управления, например компоненту ListBox. Вы также можете отобразить несколько наиболее подходящих значений, к примеру так:</p>

<pre>
procedure Edit1OnChange(...);
var
  i: integer;
begin
  if not updating then
    exit;
  {сделайте обновление где-нибудь еще -
  например при срабатывании таймера}
  updating := false;
  Table1.FindNearest([Edit1.text]);
  ListBox1.clear;
  i := 0;
  while (i &lt; 5) and (not (table1.eof)) do
  begin
    listbox.items.add(Table1.fields[0].asString);
    inc(i);
    table1.next;
  end;
  listbox1.itemindex := 0;
end;
</pre>


<p class="author">Автор: Bob</p><p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>

<hr />Каким способом можно производить поиск подходящих величин в момент ввода? Табличный курсор (визуально) должен перемещаться к наиболее подходящему значению при добавлении пользователем новых символов водимой величины. </p>

<p>Это просто. Вот что я написал в обработчике события OnChange редактора.</p>
<pre>
with MainForm.PatientTable do
begin
  { начинаем поиск имени }
  IndexName := 'Name';
  FindNearest([SearchFor.Text]);
end;
</pre>


<p>Код подразумевает, что имя индекса, по которому производится поиск - Name. Свяжите этот код с табличной сеткой и курсор будет перескакивать на ближайшую запись, удовлетворяющую введенной пользователем информации. </p>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
