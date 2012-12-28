---
Title: Сетевеая библиотека Winsock
Date: 01.01.2007
---


Сетевеая библиотека Winsock
===========================

::: {.date}
01.01.2007
:::

Сетевеая библиотека Winsock

Работа с сетью через компоненты delphi очень удобна и достаточно проста,
но слишком уж медленна. Это можно исправить, если напрямую обращаться к
сетевой библиотеке окошек - winsock. Сегодня мы познакомимся с ее
основами.

Что такое winsock

Библиотека winsock состоит из одного лишь файла winsock.dll. Она очень
хорошо подходит для создания простых приложений, потому что в ней
реализованы все необходимые функции для создания соединения и
приема/передачи файлов. Зато сниффер создавать даже не пытайся. В
winsock нет ничего для доступа к заголовкам пакетов. ms обещала встроить
эти необходимые продвинутому челу вещи в winsock2, но, как всегда,
прокатила нас задницей по наждачной бумаге и сказала, мол, обойдемся.
Чем хороша эта библиотека, так это тем, что все ее функции одинаковы для
многих платформ и языков программирования. Так, например, если мы
напишем сканер портов, его легко можно будет перенести на язык С/С++ и
даже написать что-то подобное в \*nix, потому что там сетевые функции
называются так же и имеют практически те же параметры. Разница между
сетевой библиотекой windows и linux минимальна, хотя и есть. Но так и
должно быть, ведь Билл не может по-человечески, и ему обязательно надо
выпендриться. Сразу же предупрежу, что мы будем изучать winsock2, а
delphi поддерживает только первую версию. Чтобы он смог увидеть вторую,
нужно скачать заголовочные файлы для 2-й версии их можно найти в
интернете. Вся работа сетевой библиотеки построена вокруг понятия socket
- это как бы виртуальный сетевой канал. Для соединения с сервером ты
должен подготовить такой канал к работе и потом можешь соединяться на
любой порт серванта. Все это лучше всего увидеть на практике, но я
попробую дать тебе сейчас общий алгоритм работы с сокетами:\
1. Инициализируем библиотеку winsock.\
2. Инициализируем socket (канал для связи). После инициализации у нас
должна быть переменная, указывающая на новый канал. Созданный socket -
это, можно сказать, что открытый порт на твоем компе. Порты есть не
только на серванте, но и у тебя, и когда происходит передача данных
между компами, то она происходит между сетевыми портами.\

3\. Можно присоединяться к серверу. В каждой функции для работы с сетью
первым параметром обязательно указывается переменная, указывающая на
созданный канал, через который будет происходить соединение.

Стартуем winsock

Самое первое, что надо сделать - стартануть библиотеку (для юниксоидов
это не нужно делать). Для этого нужно вызвать функцию wsastartup. У нее
есть два параметра:\
- Версия winsock, которую мы хотим стартануть. Для версии 1.0 нужно
указать makeword(1,0), но нам нужна вторая, значит, будем указывать
makeword(2,0).\
- Структура типа twsadata, в которой будет возвращена информация о
найденном winsock.\

Теперь узнаем, как нужно закрывать библиотеку. Для этого нужно вызвать
функцию wsacleanup, у которой нет параметров. В принципе, если ты не
закроешь winsock, то ничего критического не произойдет. После выхода из
программы все само закроется, просто освобождение ненужного сразу после
использования является хорошим тоном в кодинге.

Первый пример

Давай сразу напишем пример, который будет инициализировать winsock и
выводить на экран информацию о нем. Создай в delphi новый проект. Теперь
к нему надо подключить заголовочные файлы winsock 2-й версии. Для этого
надо перейти в раздел uses и добавить туда модуль winsock2. Если ты
попробуешь сейчас скомпилировать этот пустой проект, то delphi
проругается на добавленный модуль. Это потому, что он не может найти
сами файлы. Если ты скачал заголовочные файлы winsock2, то можно
поступить двумя способами:\
1. Сохранить новый проект в какую-нибудь диру и туда же забросить файлы
winsock2.pas, ws2tcpip.inc, wsipx.inc, wsnwlink.inc и wsnetbs.inс.
Неудобство этого способа - в каждый проект, использующий winsock2, надо
забрасывать заголовочные файлы.\

2\. Можно забросить эти файлы в диру delphilib, и тогда уж точно любой
проект найдет их.

Шкодим

Теперь создай форму с кнопкой и полем вывода. После этого создай
обработчик события onclick для кнопки и напиши там следующий текст:

    procedure tform1.button1click(sender: tobject); 
    var 
    info:twsadata; 
    begin 
    wsastartup(makeword(2,0), info); 
    versionedit.text:=inttostr(info.wversion); 
    descriptionedit.text:=info.szdescription; 
    systemstatusedit.text:=info.szsystemstatus; 
    wsacleanup; 
    end;

 

В самом начале я стартую winsock с помощью wsastartup. В нем я
запрашиваю 2-ю версию, а информация о текущем состоянии мне будет
возвращена в структуру info. После этого я вывожу полученную инфу для
всеобщего просмотра. При выводе информации о версии у меня есть
небольшая проблема, потому что свойство wversion структуры info имеет
числовой тип, а для вывода мне надо преобразовать его в строку. Для
этого я выполняю преобразование с помощью inttostr.

Подготовка разъема

Прежде чем производить коннект к серверу, надо еще подготовить socket к
работе. Этим и займемся. Для подготовки нужно выполнить функцию socket,
у которой есть три параметра:\
1. Тип используемой адресации. Нас интересует Инет, поэтому мы будем
указывать pf\_inet или af\_inet. Как видишь, оба значения очень похожи и
показывают одну и ту же адресацию, только в первом случае работа будет
синхронной, а во втором асинхронной.\
2. Базовый протокол. Здесь мы должны указать, на основе какого протокола
будет происходить работа. Ты должен знать, что существует два базовых
протокола - tcp (с надежным соединением) и udp (не производящий
соединений, а просто выплевывающий данные в порт). Для tcp в этом
параметре надо указать sock\_stream, а если нужен udp, то указывай
sock\_dgram.\

3\. Вот здесь мы можем указывать, какой конкретно протокол нас
интересует. Возможных значений тут немерено (например, ipproto\_ip,
ipport\_echo, ipport\_ftp и т.д.). Если хочешь увидеть все, то открывай
файл winsock2.pas и запускай поиск по ipport\_, и все что ты найдешь -
это и будут возможные протоколы.

Синхронность/асинхронность

Теперь я хочу тебя познакомить с синхронностью и асинхронностью работы
порта. Разница в этих двух режимах следующая. Синхронная работа: когда
ты вызываешь функцию, то программа останавливается и ждет полного ее
выполнения. Допустим, что ты запросил коннект с сервером. Прога тут же
тормозит и ждет, пока не произойдет коннект или ошибка. Асинхронная
работа: при этом режиме программа не спотыкается о каждую сетевую
функцию. Допустим, что ты запросил все тот же коннект с сервером. Твоя
прога посылает запрос на соединение и тут же продолжает выполнять
следующие действия, не дожидаясь физического контакта с сервантом. Это
очень удобно (но тяжело в кодинге), потому что можно использовать время,
пока произойдет контакт, в своих целях. Единственное, что ты не можешь
делать - вызывать сетевые функции, пока не произойдет реального
физического контакта. Недостаток в том, что самому приходится следить за
тем, когда закончится выполнение функции и можно будет дальше работать с
сетью.

Полный коннект

Сокет готов, а значит, можно произвести соединение с сервером. Для этого
в библиотеки winsock есть функция connect. У этой функции есть три
параметра:\
1. Переменная-сокет, которую мы получили после вызова функции socket.\
2. Структура типа tsockaddr.\
3. Размер структуры, указанной во втором параметре. Для того чтобы
узнать размер, можно воспользоваться функцией sizeof и указать в
качестве параметра структуру.\
Структура tsockaddr очень сложная, и описывать ее полностью нет смысла.
Лучше мы познакомимся с нею на практике, а пока я покажу только основные
поля, которые должны быть заполнены.\
sin\_family - семейство используемой адресации. Здесь нужно указывать то
же, что указывали в первом параметре при создании сокета (для нас это
Рf\_inet или af\_inet).\
sin\_addr - адрес сервера, куда мы хотим присоединиться.\
sin\_port - порт, на который мы хотим приконнектиться.\

На деле это будет выглядеть так:

    var 
    addr: tsockaddr; 
    begin 
    addr.sin_family := af_inet; 
    addr.sin_addr := servername; 
    addr.sin_port := htons(21); 
    connect(fsocket, @addr, sizeof(addr)); 
    end; 

 

shutdown

Ну и напоследок - функция для закрытия соединения - closesocket. В
качестве параметра нужно указать переменную-сокет.

Источник: <https://www.xakep.ru/>