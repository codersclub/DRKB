<h1>Доступ к объекту Oracle</h1>
<div class="date">01.01.2007</div>


<p>Для этого можно воспользоваться компонентами от AllRoundAutomations Direct Oracle Access. Если кому надо могу поделиться. При помощи этих компонент можно не только производить простые запросы/вставки, но и выполнять DDL-скрипты, и иметь доступ к объектам Oracle 8, примет смотри ниже...</p>

<pre>
var
  Address: TOracleObject;
begin
  Query.SQL.Text := 'select Name, Address from Persons';
  Query.Execute;
  while not Query.Eof do
  begin
    Address := Query.ObjField('Address');
    if not Address.IsNull then
      ShowMessage(Query.Field('Name') + ' lives in ' + Address.GetAttr('City'));
    Query.Next;
  end;
end;
</pre>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
