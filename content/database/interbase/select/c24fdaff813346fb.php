<h1>Почему в операторе SELECT для VIEW нельзя использовать ORDER BY?</h1>
<div class="date">01.01.2007</div>



<p>Вообще независимо от наличия индексов записи в таблице располагаются в том порядке, в котором они добавлялись. Поскольку view представляет из себя "виртуальную" таблицу, то записи также должны быть представлены в произвольном порядке. </p>
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

