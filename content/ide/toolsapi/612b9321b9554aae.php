<h1>Создание редактора свойства</h1>
<div class="date">01.01.2007</div>


<p>Взято из FAQ: <a href="https://blackman.km.ru/myfaq/cont4.phtml" target="_blank">https://blackman.km.ru/myfaq/cont4.phtml</a></p>
<p>Если вы присвоили свойству имя TableName, то полный цикл создания редактора свойств включает следующие шаги:</p>
<p>Опишите класс редактора свойства:</p>
<pre>
type
  TTableNameProperty = class(TStringProperty)
    function GetAttributes: TPropertyAttributes; override;
    procedure GetValues(Proc: TGetStrProc); override;
  end;
 
implementation
 
{ TTableNameProperty }
function TTableNameProperty.GetAttributes: TPropertyAttributes;
begin
  Result := [paValueList];
end;
 
procedure TTableNameProperty.GetValues(Proc: TGetStrProc);
var
  TableName: String;
  I: Integer;
begin
  { здесь вы должны добавить свой код, ?тобы с помощью цикла обойти имена всех
  таблиц, включенных в список }
  for I := 0 to ???? do 
  begin
    TableName := ????[I];
    Proc(TableName);
  end;
end; 
</pre>
<p>Затем зарегистрируйте данный редактор свойства следующим образом: </p>
<pre>
 RegisterPropertyEditor(TypeInfo(string), TcsNotebook, 'TableName', TTableNameProperty);         
</pre>

<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
