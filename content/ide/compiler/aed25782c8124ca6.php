<h1>Как сделать свои собственные сообщения при компилляции?</h1>
<div class="date">01.01.2007</div>


<p>Формат команды:</p>
<p><span style="color: teal;">{$MESSAGE HINT|WARN|ERROR|FATAL 'text string' }</span></p>

<p>Например, добавление следующих строк приведёт  к появлению:</p>

<pre>
{$MESSAGE 'Появился новый hint!'}
{$MESSAGE Hint 'И это тоже hint!'}
{$MESSAGE Warn 'А это уже Warning'}
{$MESSAGE Error 'Эта строка вызовет ошибку компиляции!'}
{$MESSAGE Fatal 'А это фатальная ошибка компиляции!'}
</pre>

<p>Пример:</p>

<pre>
destructor TumbSelectionTempTable.Destroy;
begin
  // Clear the temp tables.
{$MESSAGE Warn ' - remember to free all allocated objects'}
  ClearAllOuterWorldFold;
  if FSubjectsTempTableCreated then
    DropTempTable(FTableName);
 
  FOuterWorldsFolded.Free;
  FQuery.Free;
  inherited;
end;
</pre>

<p>Работает только в Дельфи 6/7</p>
