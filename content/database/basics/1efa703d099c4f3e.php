<h1>Поиск нужных данных</h1>
<div class="date">01.01.2007</div>


<p>Теперь разберём более эффективные способы нахождения нужной записи</p>
<p>в таблице. </p>
<p>А если нам надо перейти к вполне конкретной строке (записи)? Можно конечно</p>
<p>организовать такой цикл и найти нужную запись, но это громоздко, неудобно,</p>
<p>и главное очень медлено! Для этого можно использовать метод таблицы Locate.</p>
<p>Например в нашей задаче нам надо найти запись где в поле Category значение</p>
<p>"Cod". Этого можно добится примерно следующим кодом:</p>
<p>Table1.Locate('Category','Cod',[loCaseInsensitive]);</p>
<p>Можно "повесить" этот код на кнопку и убедится, что после выполнения этого</p>
<p>кода активная запись стала именно та которая нам и нужна. Итак что же за параметры</p>
<p>мы передаём этому методу? Первый параметер - это имя поля, второй параметер -</p>
<p>это значение поля, третий опции поиска (см. справку Дельфи). А что будет если</p>
<p>такого значения нет? Например:</p>
<p>Table1.Locate('Category','Cod123',[loCaseInsensitive]);</p>
<p>Ничего не будет, правда метод Locate - это функция и она возвращает значение Boolean</p>
<p>в зависимости от того, найдена запись или нет.</p>
<p>Преобразовав код как</p>
<p>if Table1.Locate('Category','Cod123',[loCaseInsensitive]) then</p>
<p>  showmessage('Record is located seccessful!')</p>
<p>else</p>
<p>  showmessage('Record is not found!');</p>
<p>можно убедится, что теперь мы знаем найдена запись или нет. Можно искать и по части</p>
<p>значения, например</p>
<p>Table1.Locate('Category','Co',[])</p>
<p>не сможет найти запись, а</p>
<p>Table1.Locate('Category','Co',[loPartialKey])</p>
<p>вполне правильно найдёт запись с значением 'Cod'.</p>
<p>А если нам надо найти значение по двум полям? В этой таблице искать так бесполезно,</p>
<p>так как все поля разные. Переключим таблицу на другую. Для этого удалим с формы</p>
<p>все визуальные компоненты кроме DBGrid и DBNavigator (так как у новой таблицы</p>
<p>будет совсем другой список полей). В коде напишем что-то</p>
<p>типа:</p>
<pre>
Table1.active:=false; //закрыли таблицу
Table1.tablename:='items.db';//ассоциируем с новой таблицей на диске
Table1.active:=true; //открыли таблицу
</pre>
<p>Откомпилируем код, убедимся, что теперь мы видим совсем другую таблицу.</p>
<p>Теперь давайте найдём такую запись, где ItemNo=1 и Discount=50, для этого нам надо</p>
<p>применить Locate следующим образом:</p>
<p>Table1.Locate('ItemNo;Discount',VarArrayOf([1,50]),[]);</p>
<p>Теперь несколько примечаний:</p>
<p>1) Для Дельфи 6/7 - добавьте "Uses Variants;"</p>
<p>2) Первый параметер - это список имён полей через ; без пробелов</p>
<p>3) Второй параметер - это массив вариант - значений полей. Почему вариант? Потому что</p>
<p>поля могут быть разных типов и в этом массиве вполне можно задать значения</p>
<p>разных типов: VarArrayOf([1,'Вася', True, 3.14]) </p>
