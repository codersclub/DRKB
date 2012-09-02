<h1>Как я могу работать с IB с клиентского компьютера?</h1>
<div class="date">01.01.2007</div>



<p>Можно использовать IB API (либо наборы компонт FreeIBComponents, IBObjects, IBX или FIBPlus, работающие напрямую с IB API), BDE+SQL Links, либо ODBC-драйвер. </p>
<p>Схема обмена данными между этими компонентами следующая </p>

<p>GDS32.DLL-&gt;IB прямое обращение к IB API </p>
<p>ODBC-&gt;GDS32.DLL-&gt; IB работа через ODBC </p>
<p>BDE-&gt;SQL Link-&gt;GDS32.DLL-&gt;IB работа через BDE </p>
<p>BDE-&gt;ODBC-&gt;GDS32.DLL-&gt;IB работа через BDE, ODBC вместо SQL Link. </p>

<p>Практически во всех случаях вам не требуется производить какие-либо специфические настройки. </p>
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

