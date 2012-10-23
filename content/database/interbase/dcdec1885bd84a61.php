<h1>Проблемы с автоинкрементальными полями</h1>
<div class="date">01.01.2007</div>


<p>Оказывается, что Interbase триггер "before insert" срабатывает только после того, как запись "запостится" из Delphi приложения. В связи с чем становится невозможным увеличение автоинкрементальных ключевых полей. Есть решение?</p>

<p>Большинство программистов решило эту проблему созданием хранимой процедуры (stored procedure), позволяющей от InterBase получить следующий номер и поместить его в вашу запись посредством метода onBeforePost или onNewRecord.</p>

<hr />Автор: Steve Koterski (Borland)</p>

<p>Я пытаюсь сгенерировать последовательный ключ для первичной ключевой колонки, но LIBS мне отвечает "nested select is not support in this context." (вложенный выбор не поддерживается в данном контексте.)</p>

<p>Как насчет:</p>

<pre>  CREATE TRIGGER AUTOINCREMENT FOR MYTABLE
  BEFORE INSERT AS
  DECLARE VARIABLE new_key INTEGER;
  BEGIN
    UPDATE AUTOKEYS
      SET KEY_VALUE = KEY_VALUE + 1
      WHERE (KEY_ID = "A");
    SELECT KEY_VALUE
      FROM AUTOKEYS
      WHERE KEY_ID = "A"
      INTO :new_key;
    new.my_key_column = new_key;
  END ^
</pre>


<hr />Автор: Mike Downey</p>

<p>Я пытаюсь добавить запись в таблицу InterBase, содержащую триггеры и blob-поля, тем не менее, всякий раз при выполнении метода "post" после установки ("append") значений, я получаю ошибку: 'Record/Key deleted.' (запись/ключ удален).</p>

<p>Вот реальный пример того, как я обошел эту проблему:</p>

<p>Определение хранимой процедуры:</p>
<pre>  Create Procedure NewEmployeeKey Returns ( EmployeeKey Integer ) as
  begin
    EmployeeKey = Gen_Id( gnEmployeeKey, 1 ) ;
  end
</pre>


<p>Определение триггера:</p>
<pre>  Create Trigger SetEmployeeKey for tbEmployee Active Before Insert Position 0 as
  begin
    if ( New.EmployeeKey is Null ) then begin
      Execute Procedure NewEmployeeKey Returning_Values New.EmployeeKey ;
    end
  end
</pre>


<p>Код Delphi для использования в обработчике события OnNewRecord, или AfterInsert, или BeforePost:</p>
<pre>
{ qyProviderData - это tQuery }
{ spProviderKey - это tStoredProc }
 
if qyProviderData.State in [dsInsert] then
begin
  spProviderKey.ExecProc ;
  qyProviderData.FieldByName( 'ProviderKey' ).AsInteger :=
  spProviderKey.ParamByName( 'ProviderKey' ).AsInteger ;
end ; { if }
</pre>



<p>Это все, что вам необходимо. Хранимая процедура возвращает следующее сгенерированное значение. Триггер это гарантирует, даже если бы данные не были доступны из вашей Delphi-программы, первичный ключ все еще назначает значение. В Delphi-коде, я полагаю, вы могли бы проверять наличие пустого поля первичного ключа вместо .State in [dsInsert], хотя это то же работает.</p>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
