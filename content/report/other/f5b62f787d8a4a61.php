<h1>Передача переменной в отчет Report Smith</h1>
<div class="date">01.01.2007</div>


<p>Следующий код показывает, как передать переменную в отчет.</p>

<p>В примере строковой переменной отчета 'City' присваивается значение ('Bombey').</p>
<p>Подразумевается, что есть готовый отчет с данной переменной.</p>

<p>Поместите компонент TReport на форму и установите требуемые свойства для вызова</p>
<p>печати отчета.</p>

<p>Напишите обработчик OnClick для кнопки Button1 на форме</p>
<p>(кнопка - для простоты) :</p>

<pre>
procedure TForm1.Button1Click(Sender: TObject);
var s: string;
begin
  s:='CA';
  Report1.InitialValues.Add('@state=&lt;'+s+'&gt;');
  Report1.run;
end;
</pre>

<p>Источник: <a href="https://dmitry9.nm.ru/info/" target="_blank">https://dmitry9.nm.ru/info/</a></p>
