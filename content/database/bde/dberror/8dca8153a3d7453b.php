<h1>ENoResultSet Error creating cursor handle</h1>
<div class="date">01.01.2007</div>


<p>Почему не работает Query.Open(Query.ExecSQL)?</p>
<p>Что значит "ENoResultSet Error creating cursor handle"?</p>
<p>1.Query.Open возвращает результат запроса в виде курсора(Cursor).</p>
<p>Когда мы выполняем запрос «select * from table1» мы получаем </p>
<p>Набор данных (Cursor). Можете представит курсор как виртуальную таблицу, со строками и столбцами, определенными в запросе. В этом случае надо использовать Query.Open или Query.Active:=true;</p>
<p>2.Query.ExecSQL выполняет инструкции запроса и курсор не создается.</p>
<p>Если в запросах используются инструкции не создающие набор данных (курсор) &#8211; СREATE TABLE, INSERT, DELETE, UPDATE , SELECT INTO и т.д. то нужно вызывать метод ExecSQL.</p>
<div class="author">Автор: BAS </div>
