---
Title: Написание триггеров
Date: 01.01.2007
---


Написание триггеров
===================

::: {.date}
01.01.2007
:::

Триггеры в MS SQL Server срабатывают после обновления и один раз на
оператор (а не на каждую обновленную запись). Количество триггеров на
таблицу неограниченно. В триггере доступна обновленная таблица и две
виртуальных таблицы Inserted и Deleted.

В них находятся:

Command          | Inserted             | Deleted
-----------------|----------------------|-----------------
**INSERT**       | Вставленные записи   |  Нет записей
**UPDATE**       | Новые версии записей | Старые версии записей
**DELETE**       | Нет записей          | Удаленные записи

Триггер может, основываясь на содержании этих таблиц осуществить
дополнительную модификацию данных, либо отменить транзакцию, вызвавшую
этот оператор. Например:

    CREATE TRIGGER T1 ON MyTable FOR INSERT, UPDATE 
    AS BEGIN
      -- Заносим в поля:
      --   LastUserName – имя пользователя, последним обновившего запись
      --   LastDateTime – дату и время последнего обновления
      UPDATE MyTable
        SET LastUserName = SUSER_NAME(),
            LastDateTime = GETDATE()
        FROM Inserted I INNER JOIN MyTable T ON I.Id = T.Id
    END

    CREATE TRIGGER T2 ON MyTable FOR DELETE
    AS BEGIN
      -- Этот триггер откатывает и снимает всю транзакцию
      -- вызвавшую ошибку
      IF EXISTS (SELECT * FROM Deleted 
                  WHERE Position = 'Boss') BEGIN
        RAISERROR('Нельзя удалять начальника', 16, 1)
        ROLLBACK
      END
    END

    CREATE TRIGGER T3 ON MyTable FOR DELETE
    AS BEGIN
      -- А этот просто не дает удалить запись
      -- позволяя продолжить транзакцию
      IF EXISTS (SELECT * FROM Deleted 
                  WHERE Position = 'Programmer') BEGIN
        INSERT INTO MyTable 
          SELECT * FROM Deleted 
           WHERE Position = 'Programmer'
        RAISERROR('Программиста удалить тоже не получится', 16, 1)
      END
    END

Поскольку триггер срабатывает после обновления таблицы в нем нельзя
реализовывать каскадные обновления данных при наличии FOREIGN KEY.
Например, если есть две таблицы:

    CREATE TABLE Main (
      Id INTEGER PRIMARY KEY
    )

    CREATE TABLE Child (
      Id INTEGER PRIMARY KEY,
      MainId INTEGER NOT NULL REFERENCES Main(Id)
    )

То при удалении записи из Main, на которую имеются ссылки в Child,
триггер на Main не сработает. Чтобы обойти эту проблему рекомендуется
создать хранимую процедуру

    CREATE PROCEDURE DeleteFromMain
     @Id INTEGER
    AS BEGIN
      DECLARE @Result INTEGER
      BEGIN TRANSACTION
        SAVE TRANSACTION DeleteFromMain
          DELETE Child WHERE MainId = @Id
          DELETE Main WHERE Id = @Id
        SET @Result = @@ERROR
        IF @Result <> 0
          ROLLBACK TRANSACTION DeleteFromMain
      COMMIT
    END

Другим способом является реализация ограничений ссылочной целостности
только при помощи триггеров.

Кроме этого в версии MSSQL 2000 возможно создание INSTEAD OF триггеров.
Такие триггеры выполняются вместо вызвавшей их операции. При этом
ответственность за запись данных в таблице полностью лежит на
программисте. Такие триггеры могут быть созданы на представлениях
(VIEW), что позволяет сделать обновляемым любое представление,
независимо от его сложности.
