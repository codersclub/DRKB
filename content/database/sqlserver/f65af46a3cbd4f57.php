<h1>Узнать автоинкрементное поле после вставки</h1>
<div class="date">01.01.2007</div>


<pre>
Insert into MyTable
  (Field1, Field2, Field3)
Values
  ('Value for field1', 'Value for field2', 0)
 
Select @@identity as 'New number for inserted row'
</pre>
<p>Вообще-то правильнее использовать Identity_Scope(), но разница будет только если на таблице стоит триггер:</p>
<pre>
Insert into MyTable
  (Field1, Field2, Field3)
Values
  ('Value for field1', 'Value for field2', 0)
 
Select identity_scope() as 'New number for inserted row'
</pre>

<div class="author">Автор: Vit</div>

