<h1>Можно-ли в запросах делать поиск по BLOB?</h1>
<div class="date">01.01.2007</div>



<p>Да. Поиск по строковым (CHAR, VARCHAR) полям или по BLOB можно производить при помощи операторов CONTAINING, STARTING WITH и LIKE. Например </p>

<pre>
SELECT * FROM MYTABLE </p>
WHERE BLOBFIELD CONTAINING 'sometext'; 
</pre>


<p>Поиск по умолчанию считается case-insensitive (регистро-нечувствительный), поэтому для латинских букв строку поиска можно задавать строчными буквами (в нижнем регистре). В этом случае при поиске 'sometext' в ответ войдут записи с 'sometext', 'SOMETEXT' и 'SomeText'. К сожалению, для BLOB невозможно указать COLLATE для правильного перевода русских букв в верхний регистр, поэтому поиск слов, содержащих русские буквы, будет производиться только по точному совпадению. </p>

<p>При поиске подтип BLOB (SUB_TYPE 0 или 1 - текст или binary) не имеет значения, т.к. подтип имеет значение только для приложения, или для фильтров BLOB. BLOB-ы разных подтипов хранятся абсолютно одинаковым способом. </p>
<p>Borland Interbase / Firebird FAQ </p>
<p>Borland Interbase / Firebird Q&amp;A, версия 2.02 от 31 мая 1999</p>
<p>последняя редакция от 17 ноября 1999 года.</p>
<p>Часто задаваемые вопросы и ответы по Borland Interbase / Firebird</p>
<p>Материал подготовлен в Демо-центре клиент-серверных технологий. (Epsylon Technologies)</p>
<p>Материал не является официальной информацией компании Borland. </p>
<p>E-mail mailto:delphi@demo.ru </p>
<p>www: http://www.ibase.ru/</p>
<p>Телефоны: 953-13-34</p>
<p>источники: Borland International, Борланд АО, релиз Interbase 4.0, 4.1, 4.2, 5.0, 5.1, 5.5, 5.6, различные источники на WWW-серверах, текущая переписка, московский семинар по Delphi и конференции, листсервер ESUNIX1, листсервер mers.com. </p>
<p>Cоставитель: Дмитрий Кузьменко </p>

