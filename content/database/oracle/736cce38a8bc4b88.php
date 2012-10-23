<h1>Доступ к Oracle через ADO</h1>
<div class="date">01.01.2007</div>


<p>Для доступа к данных хранящимся в Oracle лучше всего использовать не компоненты ADO а компоненты билиотека DAO (Data Access Oracle) с ними так же просто разобраться как и со стандартными компонентами, к тому же они работают на прямую с Oracle, без каких-либо посредников (например BDE, или тот же ODBC), и заточены соответственно под него. Линк точный дать не могу, но найти их будет не трудно (воспользуйся поисковой системой)...</p>
<p>Но если все же решил использовать ADO вот тебе строка:</p>
<p>1) способ если использовать "MS OLE DB Provaider for Oracle" - это провайдер мелкомягких</p>
<p>Provider=MSDAORA.1;Password=USER123;User ID=USER;Data Source=MyDataSourse;</p>
<p>Persist Security Info=False</p>
<p>2) способ если использовать "Oracle Provaider for Ole DB" - это провайдер от Oracle</p>
<p>Provider=OraOLEDB.Oracle.1;Persist Security Info=False;User ID=USER;Data Source=MyDataSourse</p>
<div class="author">Автор: Pegas</div>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>

