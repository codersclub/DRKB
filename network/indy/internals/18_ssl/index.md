---
Title: Indy in depth. Глубины Indy
Date: 12.12.2006
Author: Анатолий Подгорецкий
---


Indy in depth. Глубины Indy
============

::: {.date}
12.12.2006
:::


©Анатолий Подгорецкий, 2006, перевод на русский язык

Copyright Atozed Software

**Indy  
Taming Internet development one protocol at a time.**

Indy is Copyright (c) 1993 - 2002, Chad Z. Hower (Kudzu)  
and the Indy Pit Crew - <https://www.nevrona.com/Indy/>

 

## 18. SSL -- безопасные сокеты

SSL -- это сокращение от Secure Socket Layer и является проверенным
методом шифрования данных передаваемых через Интернет. SSL обычно
используется для HTTP (Web) трафика и называется защищенный (secured)
HTTPS. Конечно, SSL не ограничен HTTP и может быть использован с любым
TCP/IP протоколом.

Для использования SSL в Indy, вы во-первых должны установить поддержку
SSL. Indy реализует поддержку SSL в открытом для расширения стиле, но
единственная поддерживаемая сейчас реализация библиотеки SSL - это
OpenSSL. Библиотека OpenSSL доступна, как набор DLL и доступна для
загрузки отдельно от дистрибутива Indy.

Экспорт некоторых методов шифрования, таких как SSL, запрещен благодаря
неописуемой мудрости и понимания технологий правительством США и других
стран. По этому SSL технология не может быть размещена на web сайте, без
принятия определенных мер по точному определению местонахождения каждого
клиента, желающего загрузить технологии. Это не только трудно для
практической реализации, но и накладывает на влядельцев сайтов
дополнительную ответственность.

Ограничение касается только на распространение в электронном виде, но не
на предоставление исходного кода в печатном виде. Даное ограничение
касается только экспорта и не является важным.

Поэтому программисты просто распечатали исходный код на футболках,
пересекли границу, а затем ввели и скомпилировали его. После того как
это произошло, страны, которые не подписали соглашение с США смогли
свободно распространять технологию шифрования в любой форме и снять
импорные ограничения для любого, кто пожелает загрузить технологию
шифрования в форме пригодной для использования.

Многие проблемы были разрешены с тех пор, и некоторые правительства даже
поумнели. Тем не менее, многие экспортные ограничения продолжают иметь
место и различаются от страны к стране. Поэтому, все работы по Indy SSL
были сделаны в Словении и технологии шифрования, относящие к Indy были
также распространены через Словению. Словения не имеет ограничений на
экспорт технологий шифрования.

В дополнение к экспорту технологий шифрования, некоторые страны имеют
ограничения на использование и даже на владение технологиями шифрования.
Вы должны проверить законодательство в вашей стране прежде чем делать
реализацию с использованием SSL. Такие страны как Китай, Ирак и другие
имеют суровые наказания и даже за владение такими технологиями.

18.1. Безопасные протоколы HTTP и HTTPS

Реализация протокола HTTPS в Indy очень проста. Просто укажите
безопасный URL вместо стандартного URL и Indy клиент HTTP (TIdHTTP) все
остальное сделает автоматически. Чтобы сделать URL безопасным, просто
измените http:// на https://.

Примечание: чтобы HTTPS сессия была установлена, web сервер, который
отвечает должен поддерживать SSL и иметь установленный сертификат
шифрования. Также HTTP клиенты Indy  не проверяют сертификат сервера --
это ваша обязанность.

18.2. Другие клиенты

SSL может легко реализована в любом TCP клиенте Indy с помощью
использования SSL IOHandler. Обычно шифрование должно быть реализовано с
помощью Intercept вместо IOHandler. SSL реализация в Indy использует
IOHandler вместо Intercept, поскольку SSL библиотека выполняют весь
обмен самостоятельно. Данные возвращаются в расшифрованной форме
напрямую из SSL библиотеки.

Чтобы сделать Indy TCP клиента с использованием SSL просто добавьте
TIdSSLIOHandlerSocket на вашу форму с закладки Indy Misc. затем
установите свойство IOHandler вашего TCP клиента в
TIdSSLIOHandlerSocket. Это все, что требуется для базовой поддержки SSL.
Класс TIdSSLIOHandlerSocket имеет дополнительные свойства для указания
сертификатов клиентской стороны и другие расширенные SSL параметры.

18.3. Сервер SSL

Реализация SSL сервера немного более сложная, чем реализация SSL
клиента. С клиентами, все что требуется это сделать хук TIdTCPClient или
его наследникам к экземпляру TIdSSLIOHandlerSocket. Это происходит
потому что, поскольку сервер выполняет больше работы для поддержки SSL.

Для реализации SSL сервера используется TIdServerIOHandlerSSL.
TIdTCPServer\'s имеет свойства для установки хука на
TIdServerIOHandlerSSL. Но в отличие от TIdSSLIOHandlerSocket (Client),
класс TIdServerIOHandlerSSL требует несколько дополнительных шагов.
Более конкретно - должен быть установлены сертификаты. Данные
сертификаты должны быть представлены как файлы на диске и указаны в
CertFile, KeyFile и RootCertFile, в соответствующих свойствах
SSLOptions.

Сертификаты обычно получают из уполномоченных источников. Вы можете
иметь свой собственный сертификат и своего собственно источника, но ни
один из браузеров не будет доверять вашим сертификатам и браузер будет
выдавать диалог с предупреждением при соединении с вашим сервером. Если
вы желаете распространять через Интернет, то вы должны получить
сертификат из корневого хранилища, которому стандартный браузер будет
доверять. Единственный сертификат, которому доверяют все браузеры -- это
сертификат от Verisign. Можно также использовать сертификат от Thawte,
но не все браузеры доверяют ему по умолчанию. Примечание от переводчика:
самое смешное, что Thawte принадлежит Verisign

Если ваши клиенты под вашим контролем, такие как Интранет или Экстранет,
то вы можете пользоваться своим собственным сертификатом. Для подавления
выдачи диалога с предупреждением, вы должны установить ваш сертификат на
каждый браузер, который подключается к вашему серверу. Это позволит
браузеру считать ваш сертификат доверенным.

Примечание: это относится только к HTTP серверам, но SSL не ограничен
использованием только в HTTP. Вы можете реализовать SSL и получить
полный контроль над правилами получения и принятия сертификатов.

18.4. Преобразование сертификатов в формат PEM

Существует шанс, что вы получите ваши сертификаты формате отличном от
.pem. Если это так, то вы должны преобразовать их с помощью Indy.

Данная процедура предполагает, что вы уже получили ключ и сертификатную
пару от поставщика (Certificate Authority), например от Verisign или
Thawte и уже установили их в  персональное хранилище сертификатов
(Personal Certificates Store) Microsoft Internet Explorer.

18.4.1. Экспортирование сертификата

Выберите сертификат и экспортируйте его в .pfx файл (Personal Exchange
Format). Дополнительно вы можете его защитить с помощью пароля.

18.4.2. Преобразование файла .pfx в .pem

Как часть загрузки дистрибутива SSL, в него включена программа
openssl.exe. данная программ преобразует ваш .pfx файл.

Для использование openssl.exe, используйте следующий синтаксис:

openssl.exe pkcs12 --in \<your file\>.pfx --out \<your file\>.pem

Openssl.exe запросит пароль. Введите его если он был задан или оставьте
его пустым в противном случае. Также будет запрошен новый пароль для
.pem файла. Это не обязательное условие, но если вы его защитите
паролем, то вы должны будете создать обработчик события OnGetPassword  в
SSL перехватчике.

18.4.3. Разделение файла .pem

Если вы посмотрите созданный .pem файл с помощью блокнота, то вы
увидите, что он разделен на две части. Эти две части содержат приватный
и публичный ключи. Также приведено некоторое количество информации. Indy
требует, что бы данная информация была помещена в отдельные файлы.

18.4.4. Файл Key.pem

С помощью блокнота создайте файл key.pem и скопируйте все между двумя,
ниже указанными строками:

\-\-\-\--BEGIN RSA PRIVATE KEY\-\-\-\--

\-\-\-\--END RSA PRIVATE KEY\-\-\-\--

18.4.5. Файл Cert.pem

С помощью блокнота создайте файл cert.pem и скопируйте все между двумя,
ниже указанными строками:

\-\-\-\--BEGIN CERTIFICATE\-\-\-\--

\-\-\-\--END CERTIFICATE\-\-\-\--

18.4.6. Файл Root.pem

Последний файл, который требуется для Indy -- это Certificate Authority
certificate файл. Вы можете получить его из Internet Explorer в диалоге
Trusted Root Certificate Authority. Выберите поставщика (Authority), чей
сертификат вы желаете экспортировать и экспортируйте его в Base64 (cer)
формате. Данный формат, аналогичен PEM и после экспорта просто
переименуйте его в root.pem

 