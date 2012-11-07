<h1>Кросс-таблица через pivot-таблицу</h1>
<div class="date">01.01.2007</div>


<p>Мне нужна помощь по реализации запроса кросс-таблицы в Delphi. У кого-нибудь имеется соответствующий опыт?</p>

<p>Использовать pivot-таблицу должен все тот-же общий механизм (относительно к любой базе данных SQL).</p>

<p>Предположим, что у нас есть данные продаж в таблице с полями Store, Product, Month, Sales, и вам необходимо отображать данные по продуктам за каждый месяц. (Примем, что поле 'month' для простоты имеет значения 1..12.)</p>

<p>Оригинальные данные примера:</p>

<p>  Store         Product    Month   Sales</p>
<p>    #1            Toys       1      100</p>
<p>    #2            Toys       1       68</p>
<p>    #1            Toys       2      150</p>
<p>    #1            Books      1       75</p>
<p>    ...</p>
<p>Желаемый отчет должен выглядеть похожим на этот:</p>

<p>      Product         January      February    March  .....</p>
<p>       Toys             168          150</p>
<p>       Books             75         .....</p>

<p>Установите pivot-таблицу с именем tblPivot и 12 строками:</p>

<p>   pvtMonth   pvtJan  pvtFeb   pvtMar  pvtApr   ....</p>
<p>       1        1       0        0       0      ....</p>
<p>       2        0       1        0       0</p>
<p>       3        0       0        1       0</p>
<p>       4        0       0        0       1</p>
<p>     .....</p>
<p>Теперь запрос, выполненный в виде:</p>
<pre>  select Product, January=sum(Sales*pvtJan), 
                           February=sum(Sales*pvtFeb),
                          March=sum(Sales*pvtMar), 
                          April=sum(Sales*pvtApr),...
  where Month = pvtMonth
  group by Product
</pre>


<p>даст вам информацию, опубликованную выше.</p>
<p>Поскольку pivot-таблица имеет только 12 строк, большинство SQL-движков сохранят результат в кэшовой памяти, так что скорость выполнения запроса весьма велика.</p>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
