<h1>Кириллица в параметрах CGI-запроса</h1>
<div class="date">01.01.2007</div>


<p>Вопрос: Я хочу реализовать регистрацию своей программы через Internet. Для этого я вызываю CGI-скрипт, которому в качестве параметра передается имя пользователя. Однако, если имя набрано кириллицей, происходит ошибка. В чем дело?</p>

<p>Дело в том, что при передаче запроса по протоколу HTTP служебные символы и символы с кодами 128..255 надо кодировать. То есть, если пользователь ввел имя 'Вася Пупкин', то запрос для регистрации должен выглядеть не так:</p>

<p> &nbsp;&nbsp;&nbsp; http://site/cgi-bin/reg.pl?user=Вася Пупкин</p>

<p>а вот так:</p>

<p> &nbsp;&nbsp;&nbsp; http://site/cgi-bin/reg.pl?user=%C2%E0%F1%FF+%CF%F3%EF%EA%E8%ED</p>

<p>Решить проблему перекодировки туда и обратно может компонент TNMURL.</p>

<p>DK: Дополнительную информацию про кодирование URL'ов, можно прочитать в RFC1738</p>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
