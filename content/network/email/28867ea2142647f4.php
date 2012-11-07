<h1>Описание протокола SMTP</h1>
<div class="date">01.01.2007</div>

<p>Введение</p>

<p>Основная задача протокола SMTP (Simple Mail Transfer Protocol) заключается в том, чтобы обеспечивать передачу электронных сообщений (почту). Для работы через протокол SMTP клиент создаёт TCP соединение с сервером через порт 25. Затем клиент и SMTP сервер обмениваются информацией пока соединение не будет закрыто или прервано. Основной процедурой в SMTP является передача почты (Mail Procedure). Далее идут процедуры форвардинга почты (Mail Forwarding), проверка имён почтового ящика и вывод списков почтовых групп. Самой первой процедурой является открытие канала передачи, а последней - его закрытие.</p>
<p>Команды SMTP указывают серверу, какую операцию хочет произвести клиент. Команды состоят из ключевых слов, за которыми следует один или более параметров. Ключевое слово состот из 4-х символов и разделено от аргумента одним или несколькими пробелами. Каждая командная строка заканчивается символами CRLF. Вот синтаксис всех команд протокола SMTP (SP - пробел):</p>
<p>HELO &lt;SP&gt; &lt;domain&gt; &lt;CRLF&gt;</p>
<p>MAIL &lt;SP&gt; FROM:&lt;reverse-path&gt; &lt;CRLF&gt;</p>
<p>RCPT &lt;SP&gt; TO:&lt;forward-path&gt; &lt;CRLF&gt;</p>
<p>DATA &lt;CRLF&gt;</p>
<p>RSET &lt;CRLF&gt;</p>
<p>SEND &lt;SP&gt; FROM:&lt;reverse-path&gt; &lt;CRLF&gt;</p>
<p>SOML &lt;SP&gt; FROM:&lt;reverse-path&gt; &lt;CRLF&gt;</p>
<p>SAML &lt;SP&gt; FROM:&lt;reverse-path&gt; &lt;CRLF&gt;</p>
<p>VRFY &lt;SP&gt; &lt;string&gt; &lt;CRLF&gt;</p>
<p>EXPN &lt;SP&gt; &lt;string&gt; &lt;CRLF&gt;</p>
<p>HELP &lt;SP&gt; &lt;string&gt; &lt;CRLF&gt;</p>
<p>NOOP &lt;CRLF&gt;</p>
<p>QUIT &lt;CRLF&gt;</p>
<p>Обычный ответ SMTP сервера состоит из номера ответа, за которым через пробел следует дополнительный текст. Номер ответа служит индикатором состояния сервера.</p>
<p>Отправка почты</p>
<p>Первым делом подключаемся к SMTP серверу через порт 25. Теперь надо передать серверу команду HELLO и наш IP адрес:</p>
<p>C: HELLO 195.161.101.33</p>
<p>S: 250 smtp.mail.ru is ready</p>
<p>При отправке почты передаём некоторые нужные данные (отправитель, получатель и само письмо):</p>
<p>C: MAIL FROM:&lt;drozd&gt; 'указываем отправителя</p>
<p>S: 250 OK</p>
<p>C: RCPT TO:&lt;drol@mail.ru&gt; 'указываем получателя</p>
<p>S: 250 OK</p>
<p>указываем серверу, что будем передавать содержание письма (заголовок и тело письма)</p>
<p>C: DATA</p>
<p>S: 354 Start mail input; end with &lt;CRLF&gt;.&lt;CRLF&gt;</p>
<p>передачу письма необходимо завершить символами CRLF.CRLF</p>
<p>S: 250 OK</p>
<p>C: From: Drozd &lt;drozd@mail.ru&gt;</p>
<p>C: To: Drol &lt;drol@mail.ru&gt;</p>
<p>C: Subject: Hello</p>
<p>между заголовком письма и его текстом не одна пара CRLF, а две.</p>
<p>C: Hello Drol!</p>
<p>C: You will be die on next week!</p>
<p>заканчиваем передачу символами CRLF.CRLF</p>
<p>S: 250 OK</p>
<p>Теперь завершаем работу, отправляем команду QUIT:</p>
<p>S: QUIT</p>
<p>C: 221 smtp.mail.ru is closing transmission channel</p>
<p>&gt; Другие команды</p>
<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>SEND - используется вместо команды MAIL и указыает, что почта должна быть доставлена на терминал пользователя.</td></tr></table></div>
<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>SOML, SAML - комбинации команд SEND или MAIL, SEND и MAIL соответственно.</td></tr></table></div>
<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>RSET - указвает серверу прервать выполнение текущего процесса. Все сохранённые данные (отправитель, получатель и др) удаляются. Сервер должен отправить положительный ответ.</td></tr></table></div>
<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>VRFY - просит сервер проверить, является ли переданный аргумент именем пользователя. В случае успеха сервер возвращает полное имя пользователя.</td></tr></table></div>
<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>EXPN - просит сервер подтвердить, что переданный аргумент - это список почтовой группы, и если так, то сервер выводит членов этой группы.</td></tr></table></div>
<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>HELP - запрашивает у сервера полезную помощь о переданной в качестве аргумента команде.</td></tr></table></div>
<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>NOOP - на вызов этой команды сервер должен положительно ответить. NOOP ничего не делает и никак не влияет на указанные до этого данные.</td></tr></table></div></p>

<div class="author">Автор: Бельбаков Александр, https://msa.km.ru/</div>
