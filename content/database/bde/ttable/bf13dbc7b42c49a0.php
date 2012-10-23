<h1>Как передать Username и Password в удаленный модуль данных</h1>
<div class="date">01.01.2007</div>

В Удаленный Модуль Данных бросьте компонент TDatabase, затем добавьте процедуру автоматизации (пункт главного меню Edit | Add To Interface) для Login.</p>
<p>Убедитесь, что свойство HandleShared компонента TDatabase установлено в True.</p>
<pre>
procedure Login(UserName, Password: WideString);
begin
  { DB = TDatabase }
  { Something unique between clients }
  DB.DatabaseName := UserName + 'DB';
  DB.Params.Values['USER NAME'] := UserName;
  DB.Params.Values['PASSWORD'] := Password;
  DB.Open;
end;
</pre>
<p>После того, как Вы создали этот метод автоматизации, Вы можете вызывать его с помощью:</p>
<pre>
RemoteServer1.AppServer.Login('USERNAME','PASSWORD'); 
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
