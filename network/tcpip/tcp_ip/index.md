---
Title: Семейство протоколов TCP/IP
Date: 01.01.2007
Source: https://kunegin.com/ref1/tcp/
ID: 03364
---


Семейство протоколов TCP/IP
===========================

**Основы TCP/IP**

Термин **"TCP/IP"** обычно обозначает все, что связано с протоколами TCP и
IP. Он охватывает целое семейство протоколов, прикладные программы и
даже саму сеть. В состав семейства входят протоколы UDP, ARP, ICMP,
TELNET, FTP и многие другие. TCP/IP - это технология межсетевого
взаимодействия, технология internet. Сеть, которая использует технологию
internet, называется "internet". Если речь идет о глобальной сети,
объединяющей множество сетей с технологией internet, то ее называют
Internet.

**Модуль IP создает единую логическую сеть**

Архитектура протоколов TCP/IP предназначена для объединенной сети,
состоящей из соединенных друг с другом шлюзами отдельных разнородных
пакетных подсетей, к которым подключаются разнородные машины. Каждая из
подсетей работает в соответствии со своими специфическими требованиями и
имеет свою природу средств связи. Однако предполагается, что каждая
подсеть может принять пакет информации (данные с соответствующим сетевым
заголовком) и доставить его по указанному адресу в этой конкретной
подсети. Не требуется, чтобы подсеть гарантировала обязательную доставку
пакетов и имела надежный сквозной протокол. Таким образом, две машины,
подключенные к одной подсети могут обмениваться пакетами.

Когда необходимо передать пакет между машинами, подключенными к разным
подсетям, то машина-отправитель посылает пакет в соответствующий шлюз
(шлюз подключен к подсети также как обычный узел). Оттуда пакет
направляется по определенному маршруту через систему шлюзов и подсетей,
пока не достигнет шлюза, подключенного к той же подсети, что и
машина-получатель; там пакет направляется к получателю. Объединенная
сеть обеспечивает датаграммный сервис.

Проблема доставки пакетов в такой системе решается путем реализации во
всех узлах и шлюзах межсетевого протокола IP. Межсетевой уровень
является по существу базовым элементом во всей архитектуре протоколов,
обеспечивая возможность стандартизации протоколов верхних уровней.

**Структура связей протокольных модулей**

Логическая структура сетевого программного обеспечения, реализующего
протоколы семейства TCP/IP в каждом узле сети internet, изображена на
рис.1. Прямоугольники обозначают обработку данных, а линии, соединяющие
прямоугольники, - пути передачи данных. Горизонтальная линия внизу рисунка
обозначает кабель сети Ethernet, которая используется в качестве примера
физической среды; "o" - это трансивер. Знак "\*" - обозначает IP-адрес, а
"@" - адрес узла в сети Ethernet (Ethernet-адрес). Понимание этой
логической структуры является основой для понимания всей технологии
internet. В дальнейшем мы будем часто ссылаться на эту схему.

        +----------------------------+
        |    прикладные процессы     |
        |  ... \ | / ... \ | / ...   |
        |     -------   -------      |
        |     | TCP |   | UDP |      |
        |     -------   -------      |
        |           \    /           |
        |           ------           |
        |  -------  | IP |           |
        |  | ARP |  -*----           |
        |  -------   |               |
        |         \  |               |
        |        --------            |
        |        | ENET |            |
        |        ---@----            |
        |           |                |
        +-----------|----------------+
                    |
        ------------o----------------
        кабель Ethernet

        Рис.1. Структура протокольных модулей в узле сети TCP/IP


**Терминология**

Введем ряд базовых терминов, которые мы будем использовать в дальнейшем.

Драйвер - это программа, непосредственно взаимодействующая с сетевым
адаптером. Модуль - это программа, взаимодействующая с драйвером,
сетевыми прикладными программами или другими модулями. Драйвер сетевого
адаптера и, возможно, другие модули, специфичные для физической сети
передачи данных, предоставляют сетевой интерфейс для протокольных
модулей семейства TCP/IP.

Название блока данных, передаваемого по сети, зависит от того, на каком
уровне стека протоколов он находится. Блок данных, с которым имеет дело
сетевой интерфейс, называется кадром; если блок данных находится между
сетевым интерфейсом и модулем IP, то он называется IP-пакетом; если он -
между модулем IP и модулем UDP, то - UDP-датаграммой; если между модулем
IP и модулем TCP, то - TCP-сегментом (или транспортным сообщением);
наконец, если блок данных находится на уровне сетевых прикладных
процессов, то он называется прикладным сообщением.

Эти определения, конечно, несовершенны и неполны. К тому же они меняются
от публикации к публикации. Более подробные определения можно найти в
RFC-1122, раздел 1.3.3.

**Потоки данных**

Рассмотрим потоки данных, проходящие через стек протоколов, изображенный
на рис.1. В случае использования протокола TCP (Transmission Control
Protocol - протокол управления передачей), данные передаются между
прикладным процессом и модулем TCP. Типичным прикладным процессом,
использующим протокол TCP, является модуль FTP (File Transfer Protocol
протокол передачи файлов). Стек протоколов в этом случае будет
FTP/TCP/IP/ENET.

При использовании протокола UDP (User Datagram Protocol - протокол
пользовательских датаграмм), данные передаются между
прикладным процессом и модулем UDP. Например, SNMP (Simple Network
Management Protocol - простой протокол управления сетью) пользуется
транспортными услугами UDP. Его стек протоколов выглядит так:
SNMP/UDP/IP/ENET.

Модули TCP, UDP и драйвер Ethernet являются мультиплексорами n x 1.
Действуя как мультиплексоры, они переключают несколько входов на один
выход. Они также являются демультиплексорами 1 x n. Как
демультиплексоры, они переключают один вход на один из многих выходов в
соответствии с полем типа в заголовке протокольного блока данных
(рис.2).

Когда Ethernet-кадр попадает в драйвер сетевого интерфейса Ethernet, он
может быть направлен либо в модуль ARP (Address Resolution Protocol
адресный протокол), либо в модуль IP (Internet Protocol - межсетевой
протокол). На то, куда должен быть направлен Ethernet-кадр, указывает
значение поля типа в заголовке кадра.

Если IP-пакет попадает в модуль IP, то содержащиеся в нем данные могут
быть переданы либо модулю TCP, либо UDP, что определяется полем
"протокол" в заголовке IP-пакета.

Если UDP-датаграмма попадает в модуль UDP, то на основании значения поля
"порт" в заголовке датаграммы определяется прикладная программа,
которой должно быть передано прикладное сообщение. Если TCP-сообщение
попадает в модуль TCP, то выбор прикладной программы, которой должно
быть передано сообщение, осуществляется на основе значения поля "порт"
в заголовке TCP-сообщения.

Мультиплексирование данных в обратную сторону осуществляется довольно
просто, так как из каждого модуля существует только один путь вниз.
Каждый протокольный модуль добавляет к пакету свой заголовок, на
основании которого машина, принявшая пакет, выполняет
демультиплексирование.

     1  2  3 .... n      |           1   2  3 .... n       ^
      \ |  |      /      |             \ |  |      /       |
    -----------------  поток       -------------------  поток
    | мультиплексор |   данных     | демультиплексор |  данных
    -----------------   |          -------------------   |
           |            |                  ^             |
           v            V                  |             |
           1                               1

    Рис.2. Мультиплексор n x 1 и демультиплексор 1 x n


Хотя технология internet поддерживает много различных сред передачи
данных, здесь мы будем предполагать использование Ethernet, так как
именно эта среда чаще всего служит физической основой для IP-сети.
Машина на рис.1 имеет одну точку соединения с Ethernet. Шестибайтный
Ethernet-адрес является уникальным для каждого сетевого адаптера и
распознается драйвером.

Машина имеет также четырехбайтный IP-адрес. Этот адрес обозначает точку
доступа к сети на интерфейсе модуля IP с драйвером. IP-адрес должен быть
уникальным в пределах всей сети Internet.

Работающая машина всегда знает свой IP-адрес и Ethernet-адрес.

**Работа с несколькими сетевыми интерфейсами**

Машина может быть подключена одновременно к нескольким средам передачи
данных. На рис.3 показана машина с двумя сетевыми интерфейсами Ethernet.
Заметим, что она имеет 2 Ethernet-адреса и 2 IP-адреса.

Из представленной схемы видно, что для машин с несколькими сетевыми
интерфейсами модуль IP выполняет функции мультиплексора n x m и
демультиплексора m x n (рис.4).

```
    ---------------------------------
   |       прикладные процессы       |
   |    ... \ | / .... \ | / ...     |
   |       -------    -------        |
   |       | TCP |    | UDP |        |
   |       -------    -------        |
   |             \    /              |
   |             ------              |
   |    -------  | IP |  -------     |
   |    | ARP |  -*--*-  | ARP |     |
   |    -------   |  |   -------     |
   |         \    |  |     /         |
   |       --------  --------        |
   |       | ENET |  | ENET |        |
   |       ---@----  ---@----        |
   |          |         |            |
    ----------|---------|------------
              |         |
              |      ---o---------------
--------------o----          Ethernet 2
 Ethernet 1

Рис.3. Узел сети TCP/IP с двумя сетевыми интерфейсами
```
```
 1  2  3 .... n        |         1  2  3 ...... n      ^
  \ |  |     /         |          \ |  |        /      |
-----------------   поток     -------------------   поток
| мультиплексор |   данных    | демультиплексор |   данных
-----------------    |        -------------------    |
  / |  | ... \       V            / |  | ..... \     |
 1  2  3      m                  1  2  3        m

Рис.4. Мультиплексор n x m и демультиплексор m x n
```

Таким образом, он осуществляет мультиплексирование входных и выходных
данных в обоих направлениях. Модуль IP в данном случае сложнее, чем в
первом примере, так как может передавать данные между сетями. Данные
могут поступать через любой сетевой интерфейс и быть ретранслированы
через любой другой сетевой интерфейс. Процесс передачи пакета в другую
сеть называется ретрансляцией IP-пакета. Машина, выполняющая
ретрансляцию, называется шлюзом.

> В документации по TCP/IP термины шлюз (gateway) и IP маршрутизатор
> (IP-router) часто используются как синонимы. Мы сочли возможным
> использовать более распространенный термин "шлюз".

Как показано на рис.5, ретранслируемый пакет не передается модулям TCP или
UDP. Некоторые шлюзы вообще могут не иметь модулей TCP и UDP.

**Ethernet**

В этом разделе мы кратко рассмотрим технологию Ethernet.

Кадр Ethernet содержит адрес назначения, адрес источника, поле типа и
данные. Размер адреса в Ethernet - 6 байт. Каждый сетевой адаптер имеет
свой Ethernet-адрес. Адаптер контролирует обмен информацией,
происходящий в сети, и принимает адресованные ему Ethernet-кадры, а
также Ethernet-кадры с адресом "FF:FF:FF:FF:FF:FF" (в 16-ричной
системе), который обозначает "всем", и используется при
широковещательной передаче.

     -------      -------
     | TCP |      | UDP |
     -------      -------
          \       /
          ----------
          |        |
          |   IP   |
          |  ____  |
          | /    \ |
          ----------
          /       \
     данные      данные
     поступают   отправляются
     отсюда      сюда
    
    Рис.5. Пример межсетевой ретрансляции пакета модулем IP

Ethernet реализует метод МДКН/ОС (множественный доступ с контролем
несущей и обнаружением столкновений). Метод МДКН/ОС предполагает, что
все устройства взаимодействуют в одной среде, в каждый момент времени
может передавать только одно устройство, а принимать могут все
одновременно. Если два устройства пытаются передавать одновременно, то
происходит столкновение передач, и оба устройства после случайного
(краткого) периода ожидания пытаются вновь выполнить передачу.

**Аналогия с разговором**

Хорошей аналогией взаимодействиям в среде Ethernet может служить
разговор группы вежливых людей в небольшой темной комнате. При этом
аналогией электрическим сигналам в коаксиальном кабеле служат звуковые
волны в комнате.

Каждый человек слышит речь других людей (контроль несущей). Все люди в
комнате имеют одинаковые возможности вести разговор (множественный
доступ), но никто не говорит слишком долго, так как все вежливы. Если
человек будет невежлив, то его попросят выйти (т.е. удалят из сети). Все
молчат, пока кто-то говорит. Если два человека начинают говорить
одновременно, то они сразу обнаруживают это, поскольку слышат друг друга
(обнаружение столкновений). В этом случае они замолкают и ждут некоторое
время, после чего один из них вновь начинает разговор. Другие люди
слышат, что ведется разговор, и ждут, пока он кончится, а затем могут
начать говорить сами. Каждый человек имеет собственное имя (аналог
уникального Ethernet-адреса). Каждый раз, когда кто-нибудь начинает
говорить, он называет по имени того, к кому обращается, и свое имя,
например, "Слушай Петя, это Андрей, ... ля-ля-ля ..." Если кто-то
хочет обратиться ко всем, то он говорит: "Слушайте все, это Андрей,
... ля-ля-ля ..." (широковещательная передача).

**Протокол ARP**

В этом разделе мы рассмотрим то, как при посылке IP-пакета определяется
Ethernet-адрес назначения. Для отображения IP-адресов в Ethernet адреса
используется протокол ARP (Address Resolution Protocol - адресный
протокол). Отображение выполняется только для отправляемых IP-пакетов,
так как только в момент отправки создаются заголовки IP и Ethernet.

**ARP-таблица для преобразования адресов**

Преобразование адресов выполняется путем поиска в таблице. Эта таблица,
называемая ARP-таблицей, хранится в памяти и содержит строки для каждого
узла сети. В двух столбцах содержатся IP- и Ethernet-адреса. Если
требуется преобразовать IP-адрес в Ethernet-адрес, то ищется запись с
соответствующим IP-адресом. Ниже приведен пример упрощенной ARP-таблицы.

| IP-адрес  | Ethernet-адрес    |
|-----------|-------------------|
| 223.1.2.1 | 08:00:39:00:2F:C3 |
| 223.1.2.3 | 08:00:5A:21:A7:22 |
| 223.1.2.4 | 08:00:10:99:AC:54 |

Табл.1. Пример ARP-таблицы

Принято все байты 4-байтного IP-адреса записывать десятичными числами,
разделенными точками. При записи 6-байтного Ethernet-адреса каждый байт
указывается в 16-ричной системе и отделяется двоеточием.

ARP-таблица необходима потому, что IP-адреса и Ethernet-адреса
выбираются независимо, и нет какого-либо алгоритма для преобразования
одного в другой. IP-адрес выбирает менеджер сети с учетом положения
машины в сети internet. Если машину перемещают в другую часть сети
internet, то ее IP-адрес должен быть изменен. Ethernet-адрес выбирает
производитель сетевого интерфейсного оборудования из выделенного для
него по лицензии адресного пространства. Когда у машины заменяется плата
сетевого адаптера, то меняется и ее Ethernet-адрес.

**Порядок преобразования адресов**

В ходе обычной работы сетевая программа, такая как TELNET, отправляет
прикладное сообщение, пользуясь транспортными услугами TCP. Модуль TCP
посылает соответствующее транспортное сообщение через модуль IP. В
результате составляется IP-пакет, который должен быть передан драйверу
Ethernet. IP-адрес места назначения известен прикладной программе,
модулю TCP и модулю IP. Необходимо на его основе найти Ethernet-адрес
места назначения. Для определения искомого Ethernet-адреса используется
ARP-таблица.

**Запросы и ответы протокола ARP**

Как же заполняется ARP-таблица? Она заполняется автоматически модулем
ARP, по мере необходимости. Когда с помощью существующей ARP-таблицы не
удается преобразовать IP-адрес, то происходит следующее:

1. По сети передается широковещательный ARP-запрос.
2. Исходящий IP-пакет ставится в очередь.

Каждый сетевой адаптер принимает широковещательные передачи. Все
драйверы Ethernet проверяют поле типа в принятом Ethernet-кадре и
передают ARP-пакеты модулю ARP. ARP-запрос можно интерпретировать так:
"Если ваш IP-адрес совпадает с указанным, то сообщите мне ваш
Ethernet-адрес". Пакет ARP-запроса выглядит примерно так:

    +----------------------------+-------------------+
    | IP-адрес отправителя       | 223.1.2.1         |
    | Ethernet-адрес отправителя | 08:00:39:00:2F:C3 |
    +----------------------------+-------------------+
    | Искомый IP-адрес           | 223.1.2.2         |
    | Искомый Ethernet-адрес     | <пусто>           |
    +----------------------------+-------------------+
             Табл.2. Пример ARP-запроса

Каждый модуль ARP проверяет поле искомого IP-адреса в полученном
ARP-пакете и, если адрес совпадает с его собственным IP-адресом, то
посылает ответ прямо по Ethernet-адресу отправителя запроса. ARP-ответ
можно интерпретировать так: "Да, это мой IP-адрес, ему соответствует
такой-то Ethernet-адрес". Пакет с ARP-ответом выглядит примерно так:

    +----------------------------+-------------------+
    | IP-адрес отправителя       | 223.1.2.2         |
    | Ethernet-адрес отправителя | 08:00:28:00:38:A9 |
    +----------------------------+-------------------+
    | Искомый IP-адрес           | 223.1.2.1         |
    | Искомый Ethernet-адрес     | 08:00:39:00:2F:C3 |
    +----------------------------+-------------------+
            Табл.3. Пример ARP-ответа.

Этот ответ получает машина, сделавшая
ARP-запрос. Драйвер этой машины проверяет поле типа в Ethernet-кадре и
передает ARP-пакет модулю ARP. Модуль ARP анализирует ARP-пакет и
добавляет запись в свою ARP-таблицу.

Обновленная таблица выглядит следующим образом:

    +-----------+-------------------+
    | IP-адрес  | Ethernet-адрес    |
    +-----------+-------------------+
    | 223.1.2.1 | 08:00:39:00:2F:C3 |
    | 223.1.2.2 | 08:00:28:00:38:A9 |
    | 223.1.2.3 | 08:00:5A:21:A7:22 |
    | 223.1.2.3 | 08:00:10:99:AC:54 |
    +-----------+-------------------+
    Табл.4. ARP-таблица после обработки ответа

**Продолжение преобразования адресов**

Новая запись в ARP-таблице появляется автоматически, спустя несколько
миллисекунд после того, как она потребовалась. Как вы помните, ранее на
шаге 2 исходящий IP-пакет был поставлен в очередь. Теперь с
использованием обновленной ARP-таблицы выполняется преобразование
IPадреса в Ethernet-адрес, после чего Ethernet-кадр передается по сети.
Полностью порядок преобразования адресов выглядит так:

1.   По сети передается широковещательный ARP-запрос.
2.   Исходящий IP-пакет ставится в очередь.
3.   Возвращается ARP-ответ, содержащий информацию о соответствии IP- и Ethernet-адресов. Эта информация заносится в ARP-таблицу.
4.   Для преобразования IP-адреса в Ethernet-адрес у IP-пакета, постав ленного в очередь, используется ARP-таблица.
5.   Ethernet-кадр передается по сети Ethernet.

Короче говоря, если с помощью ARP-таблицы не удается сразу осуществить
преобразование адресов, то IP-пакет ставится в очередь, а необходимая
для преобразования информация получается с помощью запросов и ответов
протокола ARP, после чего IP-пакет передается по назначению.

Если в сети нет машины с искомым IP-адресом, то ARP-ответа не будет и не
будет записи в ARP-таблице. Протокол IP будет уничтожать IP-пакеты,
направляемые по этому адресу. Протоколы верхнего уровня не могут
отличить случай повреждения сети Ethernet от случая отсутствия машины с
искомым IP-адресом.

Некоторые реализации IP и ARP не ставят в очередь IP-пакеты на то время,
пока они ждут ARP-ответов. Вместо этого IP-пакет просто уничтожается, а
его восстановление возлагается на модуль TCP или прикладной процесс,
работающий через UDP. Такое восстановление выполняется с помощью
таймаутов и повторных передач. Повторная передача сообщения проходит
успешно, так как первая попытка уже вызвала заполнение ARP-таблицы.

Следует отметить, что каждая машина имеет отдельную ARP-таблицу для
каждого своего сетевого интерфейса.

**Межсетевой протокол IP**

Модуль IP является базовым элементом технологии internet, а центральной
частью IP является его таблица маршрутов. Протокол IP использует эту
таблицу при принятии всех решений о маршрутизации IP-пакетов. Содержание
таблицы маршрутов определяется администратором сети. Ошибки при
установке маршрутов могут заблокировать передачи.

Чтобы понять технику межсетевого взаимодействия, нужно понять то, как
используется таблица маршрутов. Это понимание необходимо для успешного
администрирования и сопровождения IP-сетей.

**Прямая маршрутизация**

На рис.6 показана небольшая IP-сеть, состоящая из 3 машин: A, B и C. Каждая
машина имеет такой же стек протоколов TCP/IP как на рис.1. Каждый сетевой
адаптер этих машин имеет свой Ethernet-адрес. Менеджер сети должен
присвоить машинам уникальные IP-адреса.

                  A      B      C
                  |      |      |
    --------------o------o------o------
     Ethernet 1
     IP-сеть "development"
     
        Рис.6. Простая IP-сеть

Когда A посылает IP-пакет B, то заголовок IP-пакета содержит в поле
отправителя IP-адрес узла A, а заголовок Ethernet-кадра содержит в поле
отправителя Ethernet-адрес A. Кроме этого, IP-заголовок содержит в поле
получателя IP-адрес узла B, а Ethernet-заголовок содержит в поле получателя
Ethernet-адрес B.

 адрес               | отправитель | получатель
---------------------|-------------|------------
 IP-заголовок        | A           | B
 Ethernet-заголовок  | A           | B

Табл.5. Адреса в Ethernet-кадре, передающем IP-пакет от A к B

В этом простом примере протокол IP является излишеством, которое мало что
добавляет к услугам, предоставляемым сетью Ethernet. Однако протокол IP
требует дополнительных расходов на создание, передачу и обработку
IP-заголовка. Когда в машине B модуль IP получает IP-пакет от машины A, он
сопоставляет IP-адрес места назначения со своим и, если адреса совпадают,
то передает датаграмму протоколу верхнего уровня.

В данном случае при взаимодействии A с B используется прямая маршрутизация.

**Косвенная маршрутизация**

На рис.7 представлена более реалистичная картина сети internet. В данном
случае сеть internet состоит из трех сетей Ethernet, на базе которых
работают три IP-сети, объединенные шлюзом D. Каждая IP-сеть включает четыре
машины; каждая машина имеет свои собственные IP- и Ethernet-адреса.

                          ----- D -------
        A     B     C     |     |        |     E     F      G
        |     |     |     |     |        |     |     |      |
    ----o-----o-----o-----o--   |      --o-----o-----o-----o---
     Ethernet 1                 |                    Ethernet 2
     IP-сеть "development"      |          IP-сеть "accounting"
                                |
                                |    H     I     J
                                |    |     |     |
                              --o----o-----o-----o----------
                                                  Ethernet 3
                                           IP-сеть "fuctory"
     
     Рис.7. Сеть internet, состоящая из трех IP-сетей

За исключением D все машины имеют стек протоколов, аналогичный показанному
на рис.1. Шлюз D соединяет все три сети и, следовательно, имеет три
IP-адреса и три Ethernet-адреса. Машина D имеет стек протоколов TCP/IP,
похожий на тот, что показан на рис.3, но вместо двух модулей ARP и двух
драйверов, он содержит три модуля ARP и три драйвера Ethernet. Обратим
внимание на то, что машина D имеет только один модуль IP.

Менеджер сети присваивает каждой сети Ethernet уникальный номер, называемый
IP-номером сети. На рис.7 IP-номера не показаны, вместо них используются
имена сетей.

Когда машина A посылает IP-пакет машине B, то процесс передачи идет в
пределах одной сети. При всех взаимодействиях между машинами, подключенными
к одной IP-сети, используется прямая маршрутизация, обсуждавшаяся в
предыдущем примере.

Когда машина D взаимодействует с машиной A, то это прямое взаимодействие.  
Когда машина D взаимодействует с машиной E, то это прямое взаимодействие.  
Когда машина D взаимодействует с машиной H, то это прямое взаимодействие.  
Это так, поскольку каждая пара этих машин принадлежит одной IP-сети.

Однако, когда машина A взаимодействует с машинами, включенными в другую
IP-сеть, то взаимодействие уже не будет прямым. Машина A должена
использовать шлюз D для ретрансляции IP-пакетов в другую IP-сеть. Такое
взаимодействие называется "косвенным".

Маршрутизация IP-пакетов выполняется модулями IP и является прозрачной для
модулей TCP, UDP и прикладных процессов.

Если машина A посылает машине E IP-пакет, то IP-адрес и Ethernet-адрес
отправителя соответствуют адресам A. IP-адрес места назначения является
адресом E, но поскольку модуль IP в A посылает IP-пакет через D,
Ethernet-адрес места назначения является адресом D.

 адрес              | отправитель  | получатель
--------------------|--------------|------------
 IP-заголовок       | A            | E
 Ethernet-заголовок | A            | D

Табл.6. Адреса в Ethernet-кадре, содержащем IP-пакет от A к E (до шлюза D)

Модуль IP в машине D получает IP-пакет и проверяет IP-адрес места
назначения. Определив, что это не его IP-адрес, шлюз D посылает этот
IP-пакет прямо к E.

 адрес              | отправитель  | получатель
--------------------|--------------|------------
 IP-заголовок       | A            | E
 Ethernet-заголовок | D            | E

Табл.7. Адреса в Ethernet-кадре, содержащем IP-пакет от A к E (после шлюз D)

Итак, при прямой маршрутизации IP- и Ethernet-адреса отправителя
соответствуют адресам того узла, который послал IP-пакет, а IP- и
Ethernet-адреса места назначения соответствуют адресам получателя. При
косвенной маршрутизации IP- и Ethernet-адреса не образуют таких пар.

В данном примере сеть internet является очень простой. Реальные сети могут
быть гораздо сложнее, так как могут содержать несколько шлюзов и несколько
типов физических сред передачи. В приведенном примере несколько сетей
Ethernet объединяются шлюзом для того, чтобы локализовать широковещательный
трафик в каждой сети.


