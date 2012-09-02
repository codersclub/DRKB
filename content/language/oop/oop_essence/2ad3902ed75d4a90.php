<h1>Переназначения объектов</h1>
<div class="date">01.01.2007</div>


<p>Существует ли возможность переключения набора данных, используемого DBNavigator на набор данных активного элемента управления без из прямого указания?</p>

<p>Все, что вы хотите, поместится в пару строк кода. Добавьте "TypInfo" в список используемых модулей и сделайте примерно следующее:</p>

<pre>
var
  PropInfo: PPropInfo;
begin
  PropInfo := GetPropInfo(PTypeInfo(ActiveControl.ClassInfo), 'DataSource');
  if (PropInfo &lt;&gt; nil)
    and (PropInfo^.PropType^.Kind = tkClass)
    and (GetTypeData(PropInfo^.PropType)^.ClassType = TDataSource) then
    DBNavigator1.DataSource := TDataSource(GetOrdProp(ActiveControl, PropInfo));
end;
</pre>


<p>Некоторая избыточность в проверках гарантирует вам, что вам не попадется некий странный объект (от сторонних производителей компонентов, например), имеющий свойство DataSource, но не типа TDataSource.</p>

<p>Взято из Советов по Delphi от <a href="mailto:mailto:webmaster@webinspector.com" target="_blank">Валентина Озерова</a></p>
<p>Сборник Kuliba</p>

