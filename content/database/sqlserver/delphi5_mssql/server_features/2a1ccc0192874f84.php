<h1>Написание триггеров</h1>
<div class="date">01.01.2007</div>


<p>Триггеры в MS SQL Server срабатывают после обновления и один раз на оператор (а не на каждую обновленную запись). Количество триггеров на таблицу неограниченно. В триггере доступна обновленная таблица и две виртуальных таблицы Inserted и Deleted.</p>
<p>В них находятся:</p>

<p> &nbsp; &nbsp; &nbsp; &nbsp;Inserted &nbsp; &nbsp; &nbsp; &nbsp;Deleted &nbsp; &nbsp; &nbsp;</p>
<p><b>INSERT</b> &nbsp; &nbsp; &nbsp; &nbsp;Вставленные записи &nbsp; &nbsp; &nbsp; &nbsp;Нет записей &nbsp; &nbsp; &nbsp;</p>
<p><b>UPDATE</b> &nbsp; &nbsp; &nbsp; &nbsp;Новые версии записей &nbsp; &nbsp; &nbsp; &nbsp;Старые версии записей &nbsp; &nbsp; &nbsp;</p>
<p><b>DELETE</b> &nbsp; &nbsp; &nbsp; &nbsp;Нет записей &nbsp; &nbsp; &nbsp; &nbsp;Удаленные записи &nbsp; &nbsp; &nbsp;</p>
<p>Триггер может, основываясь на содержании этих таблиц осуществить дополнительную модификацию данных, либо отменить транзакцию, вызвавшую этот оператор. Например:</p>

<pre>
CREATE TRIGGER T1 ON MyTable FOR INSERT, UPDATE 
AS BEGIN
  -- Заносим в поля:
  --&nbsp;&nbsp; LastUserName &#8211; имя пользователя, последним обновившего запись
  --&nbsp;&nbsp; LastDateTime &#8211; дату и время последнего обновления
  UPDATE MyTable
 &nbsp;&nbsp; SET LastUserName = SUSER_NAME(),
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; LastDateTime = GETDATE()
 &nbsp;&nbsp; FROM Inserted I INNER JOIN MyTable T ON I.Id = T.Id
END

CREATE TRIGGER T2 ON MyTable FOR DELETE
AS BEGIN
  -- Этот триггер откатывает и снимает всю транзакцию
  -- вызвавшую ошибку
  IF EXISTS (SELECT * FROM Deleted 
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; WHERE Position = 'Boss') BEGIN
 &nbsp;&nbsp; RAISERROR('Нельзя удалять начальника', 16, 1)
 &nbsp;&nbsp; ROLLBACK
  END
END

CREATE TRIGGER T3 ON MyTable FOR DELETE
AS BEGIN
  -- А этот просто не дает удалить запись
  -- позволяя продолжить транзакцию
  IF EXISTS (SELECT * FROM Deleted 
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; WHERE Position = 'Programmer') BEGIN
 &nbsp;&nbsp; INSERT INTO MyTable 
 &nbsp;&nbsp;&nbsp;&nbsp; SELECT * FROM Deleted 
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; WHERE Position = 'Programmer'
 &nbsp;&nbsp; RAISERROR('Программиста удалить тоже не получится', 16, 1)
  END
END
</pre>


<p>Поскольку триггер срабатывает после обновления таблицы в нем нельзя реализовывать каскадные обновления данных при наличии FOREIGN KEY. Например, если есть две таблицы:</p>
<pre>
CREATE TABLE Main (
  Id INTEGER PRIMARY KEY
)

CREATE TABLE Child (
  Id INTEGER PRIMARY KEY,
  MainId INTEGER NOT NULL REFERENCES Main(Id)
)
</pre>


<p>То при удалении записи из Main, на которую имеются ссылки в Child, триггер на Main не сработает. Чтобы обойти эту проблему рекомендуется создать хранимую процедуру</p>
<pre>
CREATE PROCEDURE DeleteFromMain
 @Id INTEGER
AS BEGIN
  DECLARE @Result INTEGER
  BEGIN TRANSACTION
    SAVE TRANSACTION DeleteFromMain
      DELETE Child WHERE MainId = @Id
      DELETE Main WHERE Id = @Id
    SET @Result = @@ERROR
    IF @Result &lt;&gt; 0
      ROLLBACK TRANSACTION DeleteFromMain
  COMMIT
END
</pre>


<p>Другим способом является реализация ограничений ссылочной целостности только при помощи триггеров.</p>
<p>Кроме этого в версии MSSQL 2000 возможно создание INSTEAD OF триггеров. Такие триггеры выполняются вместо вызвавшей их операции. При этом ответственность за запись данных в таблице полностью лежит на программисте. Такие триггеры могут быть созданы на представлениях (VIEW), что позволяет сделать обновляемым любое представление, независимо от его сложности.</p>

