<h1>Проверка битовых значений</h1>
<div class="date">01.01.2007</div>


<p>1. Проверить чтобы одно или более значений битовых полей было 1</p>
<pre>
Select * From MyTable Where (MyBitField1 | MyBitField2 | MyBitField3)=1
</pre>
<p>2. Проверить чтобы все значения битовых полей были равны 1</p>
<pre>
Select * From MyTable Where (MyBitField1 &amp; MyBitField2 &amp; MyBitField3)=1
</pre>

<p class="author">Автор: Vit</p>

