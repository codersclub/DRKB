<h1>Посчитать события по месяцам</h1>
<div class="date">01.01.2007</div>


<pre>
SELECT
    YEAR([MyDateFiled]),
    MONTH([MyDateFiled]),
    COUNT(*)
FROM [SomeTable]
GROUP BY
    YEAR([MyDateFiled]),
    MONTH([MyDateFiled])
</pre>
<div class="author">Автор: Vit</div>
