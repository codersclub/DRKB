<h1>Кросс-таблица через pivot-таблицу</h1>
<div class="date">01.01.2007</div>


<p>Мне нужна помощь по реализации запроса кросс-таблицы в Delphi. У кого-нибудь имеется соответствующий опыт? </p>

<p>Использовать pivot-таблицу должен все тот-же общий механизм (относительно к любой базе данных SQL). </p>

<p>Предположим, что у нас есть данные продаж в таблице с полями Store, Product, Month, Sales, и вам необходимо отображать данные по продуктам за каждый месяц. (Примем, что поле 'month' для простоты имеет значения 1..12.) </p>

<p>Оригинальные данные примера:</p>

<p>  Store&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Product&nbsp;&nbsp;&nbsp; Month&nbsp;&nbsp; Sales</p>
<p> &nbsp;&nbsp; #1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Toys&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 100</p>
<p> &nbsp;&nbsp; #2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Toys&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 68</p>
<p> &nbsp;&nbsp; #1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Toys&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 150</p>
<p> &nbsp;&nbsp; #1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Books&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 75</p>
<p> &nbsp;&nbsp; ...</p>
<p>Желаемый отчет должен выглядеть похожим на этот:</p>

<p> &nbsp;&nbsp;&nbsp;&nbsp; Product&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; January&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; February&nbsp;&nbsp;&nbsp; March&nbsp; .....</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Toys&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 168&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 150</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Books&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 75&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; .....</p>

<p>Установите pivot-таблицу с именем tblPivot и 12 строками:</p>

<p> &nbsp; pvtMonth&nbsp;&nbsp; pvtJan&nbsp; pvtFeb&nbsp;&nbsp; pvtMar&nbsp; pvtApr&nbsp;&nbsp; ....</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 0&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 0&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 0&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ....</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 0&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 0&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 0</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 3&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 0&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 0&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 0</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 4&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 0&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 0&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 0&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 1</p>
<p> &nbsp;&nbsp;&nbsp; .....</p>
<p>Теперь запрос, выполненный в виде:</p>
<pre>  select Product, January=sum(Sales*pvtJan), 
                           February=sum(Sales*pvtFeb),
                          March=sum(Sales*pvtMar), 
                          April=sum(Sales*pvtApr),...
  where Month = pvtMonth
  group by Product
</pre>


<p>даст вам информацию, опубликованную выше. </p>
<p>Поскольку pivot-таблица имеет только 12 строк, большинство SQL-движков сохранят результат в кэшовой памяти, так что скорость выполнения запроса весьма велика.</p>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
