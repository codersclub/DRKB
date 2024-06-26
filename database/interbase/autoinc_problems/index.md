---
Title: Проблемы с автоинкрементальными полями
Author: Steve Koterski (Borland)
Date: 01.01.2007
---


Проблемы с автоинкрементальными полями
======================================

Вариант 1.

Оказывается, что Interbase триггер "before insert" срабатывает только
после того, как запись "запостится" из Delphi приложения. В связи с
чем становится невозможным увеличение автоинкрементальных ключевых
полей. Есть решение?

Большинство программистов решило эту проблему созданием хранимой
процедуры (stored procedure), позволяющей от InterBase получить
следующий номер и поместить его в вашу запись посредством метода
onBeforePost или onNewRecord.

------------------------------------------------------------------------

Вариант 2.

Author: Steve Koterski (Borland)

Я пытаюсь сгенерировать последовательный ключ для первичной ключевой
колонки, но LIBS мне отвечает "nested select is not support in this
context." (вложенный выбор не поддерживается в данном контексте.)

Как насчет:

      CREATE TRIGGER AUTOINCREMENT FOR MYTABLE
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

------------------------------------------------------------------------

Вариант 3.

Author: Mike Downey

Я пытаюсь добавить запись в таблицу InterBase, содержащую триггеры и
blob-поля, тем не менее, всякий раз при выполнении метода "post" после
установки ("append") значений, я получаю ошибку: \'Record/Key
deleted.\' (запись/ключ удален).

Вот реальный пример того, как я обошел эту проблему:

Определение хранимой процедуры:

      Create Procedure NewEmployeeKey Returns ( EmployeeKey Integer ) as
      begin
        EmployeeKey = Gen_Id( gnEmployeeKey, 1 ) ;
      end

Определение триггера:

      Create Trigger SetEmployeeKey for tbEmployee Active Before Insert Position 0 as
      begin
        if ( New.EmployeeKey is Null ) then begin
          Execute Procedure NewEmployeeKey Returning_Values New.EmployeeKey ;
        end
      end

Код Delphi для использования в обработчике события OnNewRecord, или
AfterInsert, или BeforePost:

    { qyProviderData - это tQuery }
    { spProviderKey - это tStoredProc }
     
    if qyProviderData.State in [dsInsert] then
    begin
      spProviderKey.ExecProc ;
      qyProviderData.FieldByName( 'ProviderKey' ).AsInteger :=
      spProviderKey.ParamByName( 'ProviderKey' ).AsInteger ;
    end ; { if }

Это все, что вам необходимо. Хранимая процедура возвращает следующее
сгенерированное значение. Триггер это гарантирует, даже если бы данные
не были доступны из вашей Delphi-программы, первичный ключ все еще
назначает значение. В Delphi-коде, я полагаю, вы могли бы проверять
наличие пустого поля первичного ключа вместо .State in [dsInsert],
хотя это то же работает.

Source: <https://delphiworld.narod.ru>
