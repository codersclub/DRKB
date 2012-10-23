<h1>Глобальный объект Screen</h1>
<div class="date">01.01.2007</div>


<p>Этот объект инкапсулирует свойства дисплея. У него очень много свойств, но мы посмотрим только некоторые из них. Вам, наверно, часто приходилось встречать такую вещь: когда программа выполняет какую-нибудь долгую операцию, курсор над формой изменяет свой вид, а потом, когда операция выполнена, становится нормальным. Чтобы реализовать эту штуку, нам придется воспользоваться свойством Cursor, объекта Screen. Это свойство отвечает за вид курсора над вашим приложением. Тогда общий вид какой-нибудь процедуры может быть таким:</p>
<pre>
try
  Screen.Cursor:=crHourGlass;
  {какие-нибудь длинные операции или вычисления}
finally
  Screen.Cursor:=crDefault;
end;
</pre>

Также с помощью объекта Screen можно узнать параметры монитора. Свойства Width и Height указывают на ширину и высоту монитора соответственно. А свойство PixelPerInch - число точек на дюйм.</p>
<p>Как получить список всех шрифтов, о потом занести их в Combobox?? Такой вопрос, наверно, не раз задавали себе начинающие программисты, делая текстовые редакторы. Все очень просто, достаточно воспользоваться свойством Fonts. Записав эту строку в обработчике OnCreate для вашей формы, вы получите Combo со списком шрифтов, установленных у вас в системе:</p>
<p>Combobox1.Items:=Screen.Fonts;</p>

<div class="author">Автор: Михаил Христосенко // Development и Дельфи (http://delphid.dax.ru/). </div>
