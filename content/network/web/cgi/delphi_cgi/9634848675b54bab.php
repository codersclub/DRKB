<h1>Работа с Базами Данных</h1>
<div class="date">01.01.2007</div>


<p>Как это делается ?</p>
Доступ базам данных, разумеется, имеет отнощение не только к CGI... Но в этом контексте надо учитывать ряд особенностей. </p>
&nbsp;</p>
Поскольку CGI-программа запускается и выполняется на сервере, то она ДОЛЖНА обязательно завершать свою работу (и чем быстрее - тем лучше) для того, чтобы сервер и браузер пользователя считали, что запрос завершен... При каждом новом обращении к CGI происходит новый произвольный запрос к базе данных. </p>
&nbsp;</p>
В связи с этим, для получения удовлетворительного результата нам нужно максимально оптимизировать все операции с базой данных - открытие, обработку и корректное закрытие базы. </p>
&nbsp;</p>
В качестве рабочего примера обработки базы данных из CGI я предлагаю программу ABook. Эта программа использует ODBC-драйвер для работы с базой данных MS Access. При каждом обращении программа открывает базу, обрабатывает запрос, и закрывает базу... </p>
&nbsp;</p>
Хотя я и не тестировал эту программу на больших базах данных, но хочу заметить, что в любом случае открытие базы данных MS Access с помощью ODBC производится несравненно быстрее, чем при использовании BDE! </p>
&nbsp;</p>
Для более серьезных применений несомненно лучше будет использовать "сервер баз данных", который постоянно крутится на сервере. В этом случае CGI-программа будет тратить время только на отправку запроса серверу, не заботясь об открытии и закрытии базы данных... </p>
&nbsp;</p>
В качестве дальнейшего усовершенствования можно попытаться определять сессии (например, с помощью Cookies) для того, чтобы сохранять параметры между двумя запросами... </p>

