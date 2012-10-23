<h1>Работа с массивом компонентов</h1>
<div class="date">01.01.2007</div>


<div class="author">Автор: RoboSol.</div>
<p>часто возникают вопросы о работе с массивом компонентов. вот пример того как вывести список имен всех компонентов в приложении.</p>
<pre>
procedure TForm1.Button1Click(Sender : TObject);

var i : integer;
begin
 ListBox1.Items.Clear;
 for i:=0 to ComponentCount-1 do ListBox1.Items.Add(Components[i].Name);
end;
</pre>
<p>для поиска конкретного компонента по его имени используйте метод формы - FindComponent.</p>
<p>для поиска вишестоящего компонента воспользуйтесь функцией - FindGlobalComponent.</p>
<p class="note">Примечание</p>
<p>в Delphi некоторые компоненты сами по себе являются контейнерами компонентов (GroupBox, Panel, PageControl, Form). В этом случаэ контейнер является родителем этих компонентов (Parent), а форма их владельцем (Owner). Для перехода по дочерних компонентах можно воспользоваться свойством Controls родителя компонентов. А для перехода независимо от родителя - используйте свойство Controls формы.</p>
<p>Смена владельца:</p>
<p>свойство Owner - только для чтения, поэтому изменить его нельзя. Владелец устанавливается в ходе создания. Нестоит попросту изменять владельца или имя компонента. Но если есть такая необходимость можно воспользоватся методами: InsertComponent и RemoveComponent самого владельца. Эти методы нельзя применять в обработчике события формы.</p>
<p>Решение задачи:</p>
<pre>
procedure ChangeOwner( Component, NewOwner : TComponent);
begin
 Component.Owner.RemoveComponent(Component);
 NewOwner.InsertComponent(Component);
end;
</pre>
<p>пример использования:</p>
<pre>
procedure TForm1.ButtonChangeClick(Sender : TObject);
begin
 if Assigned(Button1) then 
   begin
     Button1.Parent:=Form2;
     ChangeOwner(Button1. Form2);
   end;
end;
</pre>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
