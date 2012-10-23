<h1>О руссификации Informix</h1>
<div class="date">01.01.2007</div>


<p>О Руссификации INFORMIX.</p>
<p>Данные типа char в INFORMIX имеют длину 8 бит на символ и поэтому могут хранить как английские, так и русские буквы. <br>
Встроенной сортировки по русскому алфавиту INFORMIX не реализовал. Для русской сортировки пользуйтесь предварительной перекодировкой. (См. например подпрограммку koder в демонстрационной базе ZAWOD). <br>
Во время ввода пользователь должен переключаться с русского на английский клавишей CONTROL-O, а с английского на русский клавишей CONTROL-N. <br>
<p>Должна быть установлена переменная окружения</p>
<p>KEYBMAP="маршрутное имя файла с перекодировочной таблицей"</p>
<p>&nbsp;<br>
<p>По умолчанию применяется KEYBMAP=/usr/informix/keybmap/dasher, которая устанавливает клавиатуру "ЯВЕРТЫ" под стандарт терминалов БЕСТЫ, и начальный алфавит - русский.</p>
<p>KEYBMAP=/usr/informix/keybmap/dasherE export KEYBMAP</p>
<p>&nbsp;<br>
<p>Такой командой устанавливают клавиатуру "ЯВЕРТЫ", и начальный алфавит - английский</p>
<p>KEYBMAP=/usr/informix/keybmap/dasherD export KEYBMAP</p>
<p>&nbsp;<br>
<p>Клавиатура "ЙЦУКЕН" под стандарт персонального компьютера.</p>
<p>KEYBMAP=/usr/informix/keybmap/dasherP export KEYBMAP</p>
<p>&nbsp;<br>
Клавиатура "ЙЦУКЕН" под стандарт русской пишущей машинки. <br>
В файле /usr/informix/keybmap/dasher лежит таблица перевода введенных с клавиатуры латинских символов в соответствующие им русские. Перекодировочная таблица соответствует "QWERTY"-английской клавиатуре. (Т.е. 'a' переводится в 'а', 'c' переводится в 'ц' и т.д.). Создается файл /usr/informix/keybmap/dasher программой, лежащей в /usr/informix/keybmap/crmap_dasher.c <br>
Чтобы установить другое расположение русских букв на клавиатуре переделайте эту программу. Для этого переставьте в нужном вам порядке содержимое массива russmap. <br>
В программе /usr/informix/keybmap/crmap_dasher.c статическая переменная init определяет, в каком алфавите начинается работа INFORMIX. Если init=1, то сначала устанавливается русский алфавит, если init=0, то сначала устанавливается латинский алфавит. <br>
Переделанную программу, естественно, нужно не забыть откомпилировать и запустить на выполнение. <br>
<p>Интересным способом борьбы с русификацией INFORMIX, выполненной при портировании оной является полный от нее отказ и использование русского драйвера клавиатуры для UNIX.</p>
<p>Переменные Окружения</p>
<p>Для настройки INFORMIX использует переменные окружения. Вы можете изменить любое из допущений, принимаемых INFORMIX по умолчанию, установкой одной или нескольких переменных окружения, распознаваемых INFORMIX. <br>
<p>Например сделать так, чтобы переменные типа MONEY изображались не в формате $149.50, а в формате руб 149.50 коп можно командой</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; DBMONEY='руб . коп' export DBMONEY</p>
<p>&nbsp;<br>
<p>DBPATH указывает список директорий где (помимо текущей) INFORMIX ищет базы данных и связанные с ними файлы.</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; DBPATH=/udd/iwanow:/udd/petrow export DBPATH</p>
<p>&nbsp;<br>
<p>Заставит искать базы данных не только в текущей директории, но и в директориях Петрова и Иванова</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; DBPATH=//hostname&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; *OnL*</p>
<p>&nbsp;<br>
Заставит искать базы данных OnLine на удаленном компьютере. <br>
Обычно же устанавливают переменные конкретно для вашей рабочей станции в файле /etc/profile который автоматически выполняет файл /config/profiles/informix.sh <br>
<p>Примерное содержание файла /config/profiles/informix.sh</p>
<p>INFORMIXDIR=/usr/informix export INFORMIXDIR</p>
<p>DBPRINT=pp export DBPRINT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; # программа печати - pp</p>
<p>DBEDIT='rk -E' export DBEDIT&nbsp;&nbsp;&nbsp; # пользовательский редактор</p>
<p># DBDATE=DMY4. export DBDATE&nbsp;&nbsp;&nbsp; # формат даты 24.09.1991</p>
<p># DBMONEY='. руб' export DBMONEY# совковый стандарт денег</p>
<p>PATH=$PATH:$INFORMIXDIR/bin export PATH # выполняемые модули</p>
<p>SQLEXEC=$INFORMIXDIR/lib/sqlexec export SQLEXEC # сервер - SE</p>
<p>TERMCAP=$INFORMIXDIR/etc/termcap export TERMCAP</p>
<p>case $TERM in&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; # таблица русификации клавиатуры</p>
<p>d460* | d211* | cham | vt* )</p>
<p> &nbsp; KEYBMAP=$INFORMIXDIR/keybmap/dasher&nbsp; # яверты/qwerty</p>
<p> # KEYBMAP=$INFORMIXDIR/keybmap/dasherE # qwerty/яверты</p>
<p> # KEYBMAP=$INFORMIXDIR/keybmap/dasherD # йцукен/qwerty IBM PC</p>
<p> # KEYBMAP=$INFORMIXDIR/keybmap/dasherP # йцукен/qwerty пишмаш</p>
<p> export KEYBMAP</p>
<p> ;;</p>
<p>esac</p>
<p>О Настройке INFORMIX на Терминал.</p>
<p>Для настройки на терминалы UNIX использует файл termcap или базу данных terminfo, в которых собраны описания всех (или почти всех) терминалов, существующих в природе. Выяснив, какой тип терминала подключен к машине (а задается это в переменной окружения TERM (например TERM=d460 или TERM=d211)), UNIX находит описание этого терминала базе описания терминалов и настроившись по хранящейся там информации, может адекватно воспроизводить на нем информацию, подлежащую выводу. <br>
INFORMIX имеет свой собственный termcap файл с описаниями терминалов, в нем поддерживается больше возможностей по сравнению со стандартным termcap UNIX'а. Чтобы INFORMIX пользовался им нужно присвоить его маршрутное имя в переменную окружения TERMCAP=/usr/informix/etc/termcap <br>
Терминалы TATUNG и DASHER-460 можно настраивать в два разных режима: СТАНДАРТНЫЙ, и ANSI. <br>
Стандартный режим задается стандартным значением переменной TERM. Для TATUNG TERM=d211, для DASHER-460 TERM=d460. В этом режиме я и рекомендую вам работать. Включается он по умолчанию. <br>
<p>Стандартный режим имеет следующие недостатки:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">1.</td><td>Некоторые CONTROL-ключи в нем не работают, поскольку их ASCII коды совпадают с кодами "стрелок" вправо/влево/вверх/вниз Это было бы легко пережить, если бы этими ключами не были CONTROL-W - ключ, вызывающий HELP-подсказку в среде INFORMIX и CONTROL-X - ключ "уничтожить символ". <br>
Следует заметить, что терминалы, работающие в ANSI режиме (посылающие функциональными клавишами длинные ESC-последовательности) плохо переносят русификацию клавиатуры.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">1.</td><td>Недостаток режима ANSI один: функциональные клавиши и стрелки на нем периодически сбоят. <br>
Выглядит это так: десять раз вы нажимаете на "стрелку влево" и она срабатывает как "стрелка влево" а в одиннадцатый (или в восьмой) раз она срабатывает как целая пачка нажатых клавиш: ESC, '[', '1', 'D'. Иногда это может оказаться весьма неприятно, особенно если за терминалом сидит неопытный пользователь. <br>
Представьте: вы находитесь в экранной форме, нажимаете стрелку чтобы сдвинуться, а вместо движения у вас срабатывает ESCAPE ("завершить ввод") а потом клавиша 'D', на которой в меню часто бывает навешано что-нибудь типа Drop или Delete.</td></tr></table></div><p>&nbsp;<br>
<p>Устанавливается ANSI режим так: установите значение переменной TERM=d211-tansi или TERM=d460-tansi соответственно. Сделать это можно и в общем профайле /config/profiles/informix.sh, и в личном профайле .profile, или непосредственно вручную с помощью команды</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; TERM=d460-tansi export TERM</p>
<p>&nbsp;<br>
<p>или только на время работы INFORMIX, стартовав его так:</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; TERM=$TERM-tansi&nbsp;&nbsp;&nbsp;&nbsp; r4gl</p>
<p>&nbsp;<br>
Решать, какой режим - Стандартный с неработающими ^W и ^X, или ANSI со сбоящими клавишами - ему менее противен, имеет смысл каждому пользователю индивидуально, исходя из личных вкусов. <br>
<p>Список допустимых следующие значения переменной TERM для TATUNG ET10:</p>
<table cellspacing="0" cellpadding="0" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>TERM=d211</p>
</td>
<td><p>Стандартное значение ("Простой")</p>
</td>
</tr>
<tr>
<td><p>TERM=d211-tansi</p>
</td>
<td><p>Временный ANSI режим (ANSI)</p>
</td>
</tr>
<tr>
<td><p>TERM=d211-132</p>
</td>
<td><p>"Широкоэкранный" режим (132 символа в строке)</p>
</td>
</tr>
<tr>
<td><p>TERM=vt220</p>
</td>
<td><p>Эмуляция vt220 (vt200 в 7-ми битном режиме) 
</td>
</tr>
</table>
<p>&nbsp;<br>
<p>Допустимы следующие значения TERM для для DASHER D460:</p>
<table cellspacing="0" cellpadding="0" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>TERM=d460</p>
</td>
<td><p>Стандартное значение</p>
</td>
</tr>
<tr>
<td><p>TERM=d460-tansi</p>
</td>
<td><p>Временный ANSI режим для DASHER D460</p>
</td>
</tr>
<tr>
<td><p>TERM=d460-127</p>
</td>
<td><p>Не реализован
</td>
</tr>
</table>
<p>&nbsp;<br>
<p>Обеспечивается также работа с другими типами терминалов. См. начало файла /usr/informix/etc/termcap</p>
<p>Настройка UNIX для работы с INFORMIX</p>
<p>Если при запуске нескольких процессов INFORMIX программы начинают слетать с сообщением 1250 "Unable create a pipe", значит в вашей системе слишком мало socketов. А требуется их по 4 штуки на каждую запускаемую программу INFORMIX'а. <br>
Корректирующие действия: создайте недостающие socketы в каталоге /dev/so , задайте им нормальные права доступа, и перегенерите систему, указав в dfile их новое количество. <br>
<p>Внимание! Не уничтожайте старый UNIX, пока не убедитесь, что новый грузится нормально!!!</p>
