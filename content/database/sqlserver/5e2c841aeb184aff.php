<h1>Как построить строку подключения</h1>
<div class="date">01.01.2007</div>


<pre>
function BuildConnectionString(Database, Server, Login, Password:string):Widestring;

 
begin
  if Password&lt;&gt;'' then Password:=';Password='+Password+';Persist Security Info=True' else Password:=';Persist Security Info=False';
  result:=Format('Provider=SQLOLEDB.1%s;User ID=%s;Initial Catalog=%s;Data Source=%s', [Password, Login, Database, Server]);
end;
</pre>

<div class="author">Автор: Vit</div>

