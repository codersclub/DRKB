<h1>Использование AutoInc полей в приложениях MIDAS</h1>
<div class="date">01.01.2007</div>


<pre class="delphi">
{ **** UBPFD *********** by kladovka.net.ru ****
&gt;&gt; Использование AutoInc полей в приложениях Midas
 
При использовании полей AutoInc в клиентских приложениях 
наблюдается следующая ситуация: при вставке новых записей 
в таблицу происходит исключение EkeyViolation. Данное 
исключение указывает на тот факт, что поле с типом данных 
AutoInc автоматически в ClientDataSet не инкрементируется. 
По этой причине необходимо постоянно применять и обновлять 
данные, после каждой вставки. Т.е. использовать пару 
CDS.ApplyUpdates()/CDS.Refresh. Этот прием вполне 
приемлем при локальном использовании и клиента и сервера, 
но в сети сводит на нет все преимущества использования 
DataSnap. И в таком случае клиент не сможет вставлять данные, 
если у него нет соединения с сервером или ему (клиенту) 
необходимо иметь постоянный доступ к серверу. 
 
Единственный выход из данной ситуации это самому генерировать 
значения для полей с типом AutoInc в клиентском приложении. 
А когда сервер будет обновлять данные, полеченные от клиента, 
то он не будет учитывать значения поля AutoInc при вставке. 
 
Да еще один важный момент касается уже существующих записей. 
Когда CDS обновит данные, чтобы нам не конфликтовать с уже 
существующими значениями, нужно генерировать отрицательные 
значения. Теперь при вставке нам нужно сгенерировать нужное 
значение.
 
Второй код - еще одна возможность: это использование агрегатов
 
Зависимости: DB, DBClient, MConnect, SysUtils, Classes
Автор:       Бушин Сергей, sanbotech@yandex.ru, Братск
Copyright:   1)Бушин Сергей, 2)Borland Corparation
Дата:        14 января 2003 г.
********************************************** }
 
MyAutoIncValue: longint;
…
Procedure TmyModaule.ClientDSAfterInsert(DataSet: TDataSet);
Begin
 ClientDS.MyAutoIncField.AsInteger:=MyAutoIncValue;
 //генерируем новое значение
 Dec(MyAutoIncValue);
End;
 
procedure TMyModule.ClientDSAfterRefresh(DataSet: TDataSet);
begin
 //Сбрасываем значение счетчика
 MyAutoIncValue:=-1;
end;
...
 
//вторая возможность - использование агрегатов
var
   NewID: Integer;
begin
   with ClientDataSet do 
   begin
       //вначале отключаем и очищаем агрегаты
      AggregatesActive := False;
      Aggregates.Clear;
      //Теперь добавляем 
      with Aggregates.Add do
      begin
        //здаем ему выражение
        Expression := 'Max(AField)';
         //имя 
        AggregateName := 'Runtime';
        //активизируем его
        Active := True;
      end;
       //подключаем агрегаты 
      AggregatesActive := True;
 
      Try
        //Теперь генерируем наше новое значение 
        NewID := Aggregates[0].Value; 
        // ...или еще одна альтернатива
        // NewID := Aggregates.Find('Runtime').Value;
        Inc(NewID);
      except
        on E: Exception do SomeHandle; 
      end;
      //вставляем и присваиваем
      Insert;
      FieldByName('AField').AsInteger := NewID;
   end;
</pre>

