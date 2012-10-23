<h1>Пропажа прав пользователей в Local IB после переноса</h1>
<div class="date">01.01.2007</div>


<p>Я создал БД с правами пользователей в Local IB. После переноса этой БД на IB for NT все пользователи куда-то "пропали". В чем дело ? </p>

<p>Причина в том, что информация о пользователях IB хранится в специальном файле ISC4.GDB, и является общей для всех БД на конкретном компьютере. Очевидно что в вашем случае на сервере IB for NT отсутствовали пользователи, заведенные вами для Local IB. Вам придется создать всех ваших пользователей и для IB for NT (при помощи Server Manager). То же самое будет и при переносе базы данных между серверами IB. Т.е. на обоих серверах пользователи должны быть созданы отдельно. </p>

<p>Если версии IB и платформы на обоих серверах совпадают, то ISC4.GDB можно просто скопировать. Разумеется, при отсутствии подсоединений. (еще лучше вообще выключить сервер БД на время копирования isc4.gdb). </p>

<p>Перенести isc4.gdb между платформами можно следующим способом: сделать backup isc4.gdb, восстановить на нужном сервере эту БД в другое имя (например isc4_new.gdb), остановить сервер IB, удалить старую isc4.gdb и переименовать isc4_new.gdb. </p>
<div class="author">Автор: <a href="mailto:delphi@demo.ru" target="_blank">Дмитрий Кузьменко</a> (<a href="https://www.ibase.ru" target="_blank">https://www.ibase.ru</a>)</div>
