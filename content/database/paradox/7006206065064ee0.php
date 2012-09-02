<h1>Как уменьшить дату в Paradox</h1>
<div class="date">01.01.2007</div>


<p>В Local SQL для Paradox имеется ошибка, вместо вычитания происходит сложение даты с константой. </p>
<pre>// Это добавляет единицу!
UPDATE SAMPLE.DB SET DT = DT - 1

// а данное выражение даст правильный результат:
UPDATE SAMPLE.DB SET DT = DT + (-1)
</pre>


<p>Взято с сайта <a href="https://www.delphifaq.com" target="_blank">https://www.delphifaq.com</a></p>
