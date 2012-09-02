<h1>Создаем свой GetRight</h1>
<div class="date">01.01.2007</div>

<p>Создаём свой GetRight</p>
Постановка задачи<br>
&nbsp;<br>
А задача наша проста как угол дома - сесть за комп и максимум за полчаса сообразить себе собственный getright. Конечно, он не будет производить докачку после дисконнекта, качать в заданное тобой время, не сможет качать несколько файлов сразу... но зато он сможет качать файлы по ftp и http, для начала совсем неплохо. Соображать прогу будем на delphi. Ну что, задача ясна? От винта! <br>
&nbsp;<br>
Делаем фейс <br>
&nbsp;<br>
Запускай delphi, желательно в версии 4 или 5. Перед тобой раскроется целехонькая и нетронутая (хе-хе, пока) форма. На ней мы и будем мутить. Что, ты не знаешь, что такое форма и где она там перед тобой раскрывается? Тогда позырь на монитор - вон она, большой серый прямоугольник в центре. И вообще, я не буду тебе щас про дельфийский интерфейс шибко подробно рассказывать. Лучше сразу за дело! Сейчас мы немного покликаем мышом и потаскаем. Итак, начнем: сначала нужно изменить название формы. Она сейчас называется form1, а на кой тебе такое название? Это ж название окна твоей проги. Изменить! Кликай по форме, она становится активной, теперь смотри налево - там object inspector, фича для конфигурирования разных свойств. Свойство, ответственное за название, называется caption, ищи его в object inspector'е и нажимай на него. В белом окошке вводи что-то типа "Крутая программа-качалка". Ну как, все понятно? Позырь вон на скриншот, там object inspector есть.<br>
&nbsp;<br>
Теперь смотри над формой - там палитра компонентов. На закладке standard кликай мышом по букве А. Эта буква А - ни что иное, как Метка (label). Нам она нужна, чтобы писать на форме. Кликай мышом по ней, а потом по форме, куда кликнешь на форме - там она и будет. Она сейчас выделена (в черных квадратиках вся), посему object inspector отображает ее свойства. Меняй caption (в нем напиши "Введи адрес файла сюда: ") и font (он находится ниже, кликни на нем, а потом на трех точках; я ставлю 10-ый ms sans serif полужирный). Добавь еще одну метку (поставь ее ниже), в ней caption поставь "Сохранить файл сюда: ", ну и шрифт поставь аналогичный. В третьей метке поменяй шрифт и сотри все в caption, здесь мы будем выдавать сообщения по ходу загрузки. Теперь добавь два edit'а (справа от метки в палитре компонентов). Первый поставь напротив первой метки справа (это будет для ввода адреса), второй - напротив второй метки справа (это для сохранения). У обоих сотри текст (там написано edit1, edit2, на фиг оно надо), для этого выдели (клик по нему мышом) и стирай текст в свойстве text. Затем кинь на форму две кнопки (через одну справа от edit'а в палитре компонентов), первую назови "Закачать", вторую - "Закрыть" (это все свойства caption кнопок). Потом открой закладку internet (для delphi 4) или fastnet (для delphi 5) палитры компонентов. Помести на форму компоненты nmftp и nmhttp, это для закачки. Они не будут видны в готовой программе, посему тыкай их куда хочешь. Уфф, можешь сохраняться. Дави file -&gt; save all. Форму обзови main, например, а проект - downloader. Посмотри, что у меня получилось.<br>
&nbsp;<br>
Готовимся кодить<br>
&nbsp;<br>
<p>Увы, программирование состоит не только из кликанья мышой и редактирования свойств. Приходится и кодить, и сейчас мы вплотную приблизились к этому. Но начнем с простого. Кликни два раза по кнопке "Закрыть". Опа! На экране появилось следующее:</p>
<pre>
procedure tform1.button2click(sender: tobject);
begin
end;
</pre>
&nbsp;<br>
&nbsp;<br>
<p>и твой курсор мигает между begin и end. Это - обработчик события onclick для кнопки "Закрыть", и все, что ты напишешь между begin и end, будет выполняться при клике по этой кнопке. А нам нужно, чтобы прога закрывалась, посему пишем</p>
<pre>
procedure tform1.button2click(sender: tobject);
begin
nmftp1.disconnect ; // разрываем связь по фтп, если она установлена
nmhttp1.disconnect ; // разрываем связь по хттп, если она установлена
close ; // Закрываем прогу
end ;
</pre>
&nbsp;<br>
&nbsp;<br>
Если не разорвать связь, прога просто откажется выходить. Поэтому и разрываем.<br>
&nbsp;<br>
<p>Кстати, после // в delphi до конца строки идет комментарий, его она не учитывает при компиляции. Комментарии для тебя, чтобы понятнее было, не нужно их переписывать. Обрати внимание, там написано button2click, а не "Закрыть" click. button2 - это рабочее имя кнопки для взаимодействия с программой (как в вышеописанном примере), а caption - это всего лишь надпись на кнопке. Все имена компонентов находятся в их свойстве name, можешь посмотреть в object inspector'е. Теперь кликни два раза по первому edit'у, появляется нечто похожее на обработчик для кнопки:</p>
<pre>
procedure tform1.edit1change(sender: tobject) ;
begin
end ;
</pre>
&nbsp;<br>
&nbsp;<br>
<p>Тут вместо onclick мы видим onchange - все, что находится между begin и end, будет выполняться, когда в edit'е что-то напишут. Мы изменим tag (свойство edit'а, некоторое число, по умолчанию 0), это нам понадобится потом, для проверки заполнения всех полей. </p>
<pre>
procedure tform1.edit1change(sender: tobject) ;
begin
edit1.tag := 1 ; // присвоить тагу первого эдита значение 1
end ;
</pre>
&nbsp;<br>
&nbsp;<br>
Аналогичную операцию необходимо проделать и со вторым эдитом, только там нужно писать: <br>
&nbsp;<br>
edit2.tag := 1 ;<br>
&nbsp;<br>
Не забывай об именах! Вот и все с подготовкой, а теперь начинается...<br>
&nbsp;<br>
Реальный кодинг<br>
&nbsp;<br>
<p>Да, именно он. Читай внимательнее и вникай. Перейдем к нашей главной кнопке - "Закачать". Кликай по ней два раза и создавай обработчик, далее вписывай код, чтобы получилось вот что:</p>
<pre>
procedure tform1.button1click(sender: tobject) ;
begin
label3.caption := '' ; // очищаем метку для сообщений 
if ( edit1.tag = 1 ) and ( edit2.tag = 1 ) and ( edit1.text &lt;&gt; '' ) 
and ( edit2.text &lt;&gt; '' ) then // проверка данных
begin
// данные введены, выполнять действия
end
else label3.caption := 'Введи все данные, чувак!' // не все данные
end ;
</pre>
&nbsp;<br>
&nbsp;<br>
Что есть что: сначала очищаем метку, просто присваиваем ее caption'у пустое место (сначала она, правда, и так пустая, но потом будет полная, поэтому очищаем), затем идет стандартный оператор if then else, используем этот оператор для проверки, все ли поля заполнены - помнишь, мы тагам единицы присваивали? Так вот, теперь и проверяем - если чувак поля не заполнил, то таги - "0", и проверка не пройдет. Но юзверь мог ввести дату, а потом все стереть - вот для этого и нужна проверка значений эдитов на '' - если там пустое место (''), то проверка не пройдет. Дальше просто: если проверка прошла - гоним далее, нет - пишем в метке "Введи все данные, чувак!". Ну как, врубаешься? Если нет, просто пиши код, но все-таки старайся понять. <br>
&nbsp;<br>
<p>Продолжаем разговор. Нам нужно узнать, по фтп загружать или по хттп. Для этого нужно знать, что впереди: ftp:// или http://. Чтобы вытянуть это из оригинального адреса, проведем ряд извращений со строками. Дописывай код:</p>
<pre>
procedure tform1.button1click(sender: tobject) ;
begin
label3.caption := '' ; // очищаем метку для сообщений 
if ( edit1.tag = 1 ) and ( edit2.tag = 1 ) and ( edit1.text &lt;&gt; '' ) 
and ( edit2.text &lt;&gt; '' ) then // проверка данных
begin // данные введены, выполнять действия
addr := edit1.text ; // сохраняем адрес в переменную
serv := copy( addr , 1 , 6 ) ; // копируем 6 символов из адреса в 
// переменную serv
if serv = 'ftp://' then // впереди ftp://
begin
// качаем по фтп 
end
else 
if serv = 'http:/' then // впереди http:/
begin
// качаем по хттп
end
else label3.caption := 'Что за корявый адрес?' ;
end
else label3.caption := 'Введи все данные, чувак!' // не все данные
end ;
</pre>
&nbsp;<br>
&nbsp;<br>
Сначала мы сохранили адрес из первого эдита в переменную addr, затем в переменную serv мы из переменной addr копируем 6 символов. Используем функцию copy. В скобках идут параметры - сначала пишем переменную, из которой копировать, потом номер символа, с которого начинать, ну и потом сколько символов копировать. Всю скопированную бурду сохраняем в переменной serv, теперь проверяем: если серв равен ftp://, то качать будем по фтп, а если http:/ - по хттп. Ну а если серв другой, то адрес корявый - это и напишем в метке. Кстати, переменные serv и addr еще не определены, и программа будет ругаться (а работать не будет). Надо их определить, иди в самый верх кода и там ищи слово var. Вот после этого слова и допиши переменные, заодно добавь еще несколько - они нам потом пригодятся. Вот так:<br>
&nbsp;<br>
var<br>
serv , addr , host , dir : string ; <br>
&nbsp;<br>
<p>string - это строка, соответственно, все эти переменные - строки. Уфф! Теперь последние штрихи на этой стадии - для скачки по фтп нужно сначала соединиться с хостом (сервером), а потом уже скачивать файло. Нужно разбить адрес на хост и собственно адрес файла, а это опять извращения со строками. Дописывай:</p>
<pre>
procedure tform1.button1click(sender: tobject) ;
begin
label3.caption := '' ; // очищаем метку для сообщений 
if ( edit1.tag = 1 ) and ( edit2.tag = 1 ) and ( edit1.text &lt;&gt; '' ) 
and ( edit2.text &lt;&gt; '' ) then // проверка данных
begin // данные введены, выполнять действия
addr := edit1.text ; // сохраняем адрес в переменную
serv := copy( addr , 1 , 6 ) ; // копируем 6 символов из адреса в 
// переменную serv
if serv = 'ftp://' then // впереди ftp://
begin
delete( addr , 1 , 6 ) ; // удаляем первые 6 символов из 
//адреса
host := copy ( addr , 1 , ( pos( '/' , addr ) - 1 ) ) ;
// находим хост
delete( addr , 1 , ( pos( '/' , addr ) - 1 ) ) ;
dir := addr ; 
// находим путь к файлу
// качаем по фтп 
end
else 
if serv = 'http:/' then // впереди http:/
begin
// качаем по хттп
end
else label3.caption := 'Что за корявый адрес?' ;
end
else label3.caption := 'Введи все данные, чувак!' // не все данные
end ;
</pre>
&nbsp;<br>
&nbsp;<br>
&nbsp;<br>
Итак, сначала функцией delete стираем первые 6 символов из адреса. Функция берет строку, из которой стирать, символ, с которого начинать стирать, количество стираемых символов - все очень похоже на copy. Затем в переменную host копируем адрес сервака, но вместо количества символов там стоит конструкция типа <br>
&nbsp;<br>
(pos( '/' , addr ) -1). Все путем! Функция pos находит положение символа / в строке addr и выдает число, которое показывает, какой этот символ по счету. Но нам его копировать не надо, поэтому и отнимаем единицу. Теперь, если адрес файла ftp://my.host.com/file.exe, то адрес сервера будет my.host.com. Дальше стираем из адреса хост, и остается адрес файла - его и присваиваем переменной dir. Все, подготовка закончена, все данные обработаны, сохраняйся.<br>
&nbsp;<br>
Кодим скачку по фтп<br>
&nbsp;<br>
Обработаем теперь докачку по фтп. Ниже идущий код пиши там, где надпись:<br>
&nbsp;<br>
// качаем по фтп. <br>
&nbsp;<br>
<p>Сначала поработаем с кнопками, дописывай код: </p>
<pre>
edit1.enabled := false ;
edit2.enabled := false ; // вырубаем эдиты
button1.enabled := false ; // выключаем кнопку "Закачать" 
</pre>
&nbsp;<br>
&nbsp;<br>
<p>Тут, я думаю, все понятно, прописываем закачку:</p>
<pre>
nmftp1.host := host ;
nmftp1.userid := 'anonymous' ;
nmftp1.password := '' ;
label3.caption := 'Подключаемся ... ' ;
nmftp1.connect ;
nmftp1.mode( mode_image ) ;
label3.caption := 'Начинаем качать ...' ;
nmftp1.download( dir , edit2.text ) ;
label3.caption := 'Ура !!!' ;
label3.caption := 'Отключаемся ...' ;
nmftp1.disconnect ;
</pre>
&nbsp;<br>
&nbsp;<br>
<p>Тут тоже все понятно - соединяемся, скачиваем, отсоединяемся. download берет себе сначала адрес файла в Инете, а потом адрес, куда его сохранить на диске. Вот и все. Обрабатываем кнопки: </p>
<pre>
 
button1.enabled := true ; // включаем кнопку "Закачать"
edit1.enabled := true ;
edit2.enabled := true ; // врубаем эдиты 
edit1.clear ;
edit2.clear ; // очищаем эдиты 
</pre>
<p>&nbsp;<br>
&nbsp;<br>
Поработай немного мышом - добавим несколько комментариев. Выдели компонент nmftf1 у себя на форме, затем кликни в object inspector'е на вкладку events (кликай на onconnect, затем на белое место справа - два раза).<br>
&nbsp;<br>
<p>Пиши:</p>
<pre>
procedure tform1.nmftp1connect(sender: tobject);
begin
label3.caption := 'Подключено успешно!!!' ;
end;
</pre>
<p>&nbsp;<br>
&nbsp;<br>
<p>Теперь, когда соединение установлено, прога выдаст в метку сообщение. Кликай по onconnectionfailed. Пиши:</p>
<pre>
procedure tform1.nmftp1connectionfailed(sender: tobject);
begin
label3.caption := 'Ошибка!!! Не могу соединиться!' ;
end;
</pre>
<p>&nbsp;<br>
&nbsp;<br>
Ну и так и далее, там все прозрачно, пофантазируй немного.<br>
&nbsp;<br>
Все, обработка фтп закончена. <br>
&nbsp;<br>
Кодим скачку по http <br>
&nbsp;<br>
После скачки по фтп это совсем легко, посему отдыхай. Код пиши вместо строки:<br>
&nbsp;<br>
// качаем по хттп . <br>
&nbsp;<br>
<p>А код следующий: </p>
<pre>
edit1.enabled := false ;
edit2.enabled := false ; // вырубаем эдиты
button1.enabled := false ; // выключаем кнопку "Закачать" 
</pre>
<p>&nbsp;<br>
<p>Обрабатываем кнопки и эдиты, как и при скачке по фтп.</p>
<pre>
label3.caption := 'Подключаемся ... ' ;
delete(addr, 1, 7) ;
</pre>
<p>&nbsp;<br>
&nbsp;<br>
<p>В переменной addr у нас адрес, помнишь? Так вот, удаляем из него кусок http:// - это ОЧЕНЬ важно. Почему? Потом объясню. Теперь, собственно, скачка: </p>
<pre>
nmhttp1.inputfilemode := true ;
nmhttp1.body := edit2.text ;
nmhttp1.get( addr ) ; // качаем
</pre>
<p>&nbsp;<br>
&nbsp;<br>
<p>Опять обрабатываем кнопки:</p>
<pre>
button1.enabled := true ; // включаем кнопку "Закачать"
edit1.enabled := true ;
edit2.enabled := true ; // врубаем эдиты 
edit1.clear ;
edit2.clear ; // очищаем эдиты
</pre>
<p>&nbsp;<br>
&nbsp;<br>
С кодом все, теперь осталось добавить несколько событий, как и при скачке по фтп. Кликай на компоненте nmhttp1 на форме, и в object inspector'е выбирай закладку events. А дальше фантазируй: напиши что-нибудь при onconnect, onconnectionfailed, ondisconnect. А вообще, корректная обработка ошибок (типа onconnectionfailed) - это гимор, поэтому особо не забивай себе голову.<br>
&nbsp;<br>
Последние штрихи<br>
&nbsp;<br>
<p>Чего-то не хватает... Правильно! Не хватает прогресс-бара - этой синей полоски с процентами! Но это не проблема, сейчас сделаем. Открывай закладку win32 палитры компонентов, хватай компонент progressbar и лепи его на форму (чтобы посмотреть, как его прилепил я, позырь на скриншот готовой проги). Теперь выделяй компонент nmftp1 и открывай в object inspector'е закладку events. Ищи onpacketrcvd. Создавай обработчик (клик по onpacketrecvd, два по пустому месту справа от него). Там пиши следующий код: </p>
<pre>
procedure tform1.nmftp1packetrecvd(sender: tobject);
begin
progressbar1.position := round(nmftp1.bytesrecvd*100/nmftp1.bytestotal) ;
label3.caption := 'Получено ' + inttostr(nmftp1.bytesrecvd) + ' байт из ' + inttostr ( 
nmftp1.bytestotal ) ;
end;
</pre>
<p>&nbsp;<br>
&nbsp;<br>
Строки разрывать не надо, просто они длинные и не помещаются.<br>
&nbsp;<br>
Теперь, когда прога будет что-то качать, синяя строчка будет ползти, а в метке будет написано, сколько байт уже получено. Все эти действия необходимо повторить и для nmhttp1, только nmftp1 в коде замени на nmhttp1. После завершения загрузки очистим progressbar - для этого в конце фтп и хттп фрагментов - там, где мы открывали эдиты и очищали их - допиши следующую строку: <br>
&nbsp;<br>
progressbar1.position := 0 ; // очищаем прогресс-бар <br>
&nbsp;<br>
Теперь сохраняй все и компилируй (дави на f9) - получишь вполне работоспособную прогу-качалку, пользуйся.<br>
&nbsp;<br>
Последнее слово<br>
&nbsp;<br>
Так вот, чтобы написать эту прогу, мне пришлось основательно помучаться: я не знал, ни как закачать файлы по фтп, ни как закачать его по хттп. Но если с фтп, перерыв борландовский хелп и примеры, я разобрался, то хттп постоянно глючил, выдавал битый файл. Я написал в десяток ньюсгрупп - как русских, так и забугорных, задавал вопросы на бордах крутых дельфовских сайтов, я писал программерам, я написал в службу поддержки разработчика компонента nmhttp ... И что ты думаешь, кто-нибудь посоветовал что-нибудь путевое? Фиг!<br>
&nbsp;<br>
Я дошел сам. А дело было в мелочи: я делал все правильно, но писал <br>
&nbsp;<br>
nmhttp1.get('http://www.host.com/file.zip') ;<br>
&nbsp;<br>
А нужно было<br>
&nbsp;<br>
nmhttp1.get('www.host.com/file.zip') ;<br>
&nbsp;<br>
Вот почему нужно выбрасывать часть http://. Но ты теперь можешь не мучаться и кодить спокойно, а если что не так - мыль мне, я постараюсь ответить на твои вопросы. Удачи! <br>
&nbsp;<br>
<p>Источник: <a href="https://www.realcoding.net/" target="_blank">https://www.realcoding.net/</a></p>
