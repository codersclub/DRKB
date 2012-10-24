<h1>Перевести коды ошибок Winsock'a в текстовый вид</h1>
<div class="date">01.01.2007</div>

Вот функция, аналогичная SysErrorMessage, принемает на вход код ошибки socket'a , возвращает строковое сообщение об ошибке..<br>
<p>&nbsp;</p>
<pre>
function WSAErrorMessage(ErrorCode: Integer): string;
var
  Buffer: array[0..255] of Char;
var
  Len: Integer;
begin
  Len := FormatMessage(FORMAT_MESSAGE_FROM_HMODULE or FORMAT_MESSAGE_IGNORE_INSERTS or
    FORMAT_MESSAGE_ARGUMENT_ARRAY, Pointer(GetModuleHandle('wsock32.dll')),
    ErrorCode, 0, Buffer,
    SizeOf(Buffer), nil);
  while (Len &gt; 0) and (Buffer[Len - 1] in [#0..#32, '.']) do Dec(Len);
  SetString(Result, Buffer, Len);
end;
</pre>
&nbsp;</p>
<div class="author">Автор: jack128</div>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

<hr /><p>&nbsp;<br>
<p>Некоторые коды сразу на русском:</p>
<p>&nbsp;<br>
10004 Выполнение операции с сокетом, блокирующей выполнение программы, прервано вызовом специальной функции. <br>
10013 Нет разрешения на доступ к сокету. <br>
10014 Неверный адрес указателя при вызове функции. <br>
10022 Неправильный аргумент при вызове функции для работы с сокетами. <br>
10024 Слишком много открытых сокетов на нить, процесс или глобальных. <br>
10035 Ресурс временно недоступен, при выполнении функции работы с сокетом, которая не может выполнить операцию немедленно. <br>
10036 Одна блокирующая операция сейчас уже выполняется. <br>
10037 Одна операция с неблокирующим сокетом уже выполняется. <br>
10038 Попытка вызвать функцию, работающую с сокетами, при передаче ей в аргументе значения, которое не является правильным значением сокета. Обычно возникает, при попытке работы с уже закрытым сокетом. <br>
10039 Требуется адрес назначения <br>
10040 Сообщение слишком длинное при передаче дейтаграммы. <br>
10041 Тип протокол не поддерживается для данного сокета. <br>
10042 Неправильная опция или уровень заданы в функциях опций сокетов <br>
10043 Запрошенный протокол не сконфигурирован для работы с системе <br>
10044 Тип сокета не поддерживается <br>
10045 Операция с сокетом не поддерживается <br>
10046 Семейство протоколов не поддерживается <br>
10047 Адрес не поддерживается на выбранном протоколе сокета <br>
10048 Адрес+порт уже используется на этом хосте. Очень распространённая ошибка, когда две программы-серверы пытаются использовать один и тот же порт для приема запросов клиентов. <br>
10049 Невозможно использовать запрошенный адрес для привязки в порту <br>
10050 Сеть неработоспособна <br>
10051 Сеть недоступна, аппаратура не знает как туда переслать пакет, возможно из-за ненастроенной маршрутизации. <br>
10052 Соединение разорвано из-за сбоя при выполнении операции <br>
10053 Программное обеспечение компьютера, на котором выполняется данная программа, разорвало соединение. <br>
10054 Соединение разорвано с удаленного компьютера, возможно, что так оно и задумано было, и клиент завершил всю передачу информации по сокету. <br>
10055 Не места в буфере или очереди. <br>
10056 Сокет уже подсоединен. <br>
10057 Сокет не подсоединенный <br>
10058 Невозможно послать или получить данные по сокету, из-за того, что эта операция уже запрещена функцией shutdown <br>
10060 Timeout <br>
10061 Удаленный компьютер отказал в соединении, возможно не нём не запущен соответствующая программа сервер. <br>
10064 Компьютер, с которым производится попытка соединения выключен. <br>
10065 К удаленному компьютеру не найдет маршрут пересылки пакетов. <br>
10067 Запущено слишком много процессов, использующих Windows Socket <br>
10091 Сетевая подсистема недоступна. <br>
10092 Неверная версия winsock.dll <br>
10093 Не выполнена функция WSAStartup перед использованием любой другой фукнции работы с сокетами. <br>
10109 Запрошенный тип класса не найден. <br>
10101 Удаленный компьютер инициировал завершение соединения <br>
11001 Запрошенное имя компьютера не найдено <br>
11002 Временная ошибка при разрешении имени компьютера в адрес, возможно её не будет при повторе операции через некоторое время. <br>
11003 Невосстанавливаемая ошибка при разрешении имени в адрес. <br>
<p>11004 С запрошенным именем компьютера не связано никакой правильной информации об адресе, хотя само имя присутствует в соответствующих базах данных имён.</p>
<p>&nbsp;<br>
<div class="author">Автор: Misc&#1106;ka</div>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
