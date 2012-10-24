<h1>Антиотладочные приемы</h1>
<div class="date">01.01.2007</div>


<div class="author">Автор: Дмитрий Логинов</div>

<p>Я против слишком большого внимания к проблеме защиты программ. Тем более, что это проблема не разработчиков ПО. В обсуждении будущих тем АКМ я встречал то, что мы уже обсуждали. Например, как ограничить кол-во инсталляций, или как ограничить кол-во запусков инсталлятора? Как программные, так и аппаратные способы сделать это имеют один недостаток: ИХ ЛЕГКО ПЕРЕХВАТИТЬ. Т.е. используя лишь программу мониторинга (RegMON, FileMON, PortMON, VXDmon etc), можно свести, без особого изврата, все старания программистов на нет. Наиболее удачным с моей точки зрения является организационное решение. Я его встречал несколько раз. Делается с.о. Инсталлятор не продается, с фирмой заключается договор, приходит человек, устанавливает ПО и уходит. Тоже самое с обновлениями. В крайнем случае они закачиваются по почте, но после предварительного звонка в фирму-поставщик. Понимаю, это не всех устраивает, т.к. требует БОльших действий от БОльшего кол-ва людей. Но это окупается. Вам выбирать.</p>
<p>Относительно шаровар. Не стоит в качестве шароварных свойств использовать ограничение запусков, времени использования, disable некоторых пунктов меню. Поверьте, лучше полностью написать прогу, которая действительно не полностью функциональна. Например, как я писал в прошлом АКМ. Да есть еще масса способов.</p>
<p>Относительно верности паскалю. Я постараюсь написать все на паскале. Я вас понимаю. Мне тоже нравится паскаль. Красивый процедурный язык высокого уровня. Но как насчет того, чтобы разместить класс в стеке (тоже интересный антиотладочны прием)? Как насчет того, чтобы участок памяти, где лежит класс, декодировался "на лету", при обращении к классу? Как насчет того, чтобы написать процедурку со своими параметрами вызова, а не стандартный паскалевский или сишный? Как разделить выделение памяти под класс и вызов его конструктора? Как сделать автоматическое освобождение памяти класса после выхода из болка BEGIN...END? Вот такой он великий и могучий паскаль. Если вам этого не надо, то, конечно, не стоит думать о таких вещах как С++. Только не стоит воспринимать это как ОБЕСЦЕНИВАНИЕ паскаля. Ничего кроме флейма не получится. Не надо спорить, хорошо? Не буду я вам надоедать этим СИ. И ВООБЩЕ НИЧТО ТАК НЕ УМЕНЬШАЕТ ПОНИМАНИЕ, КАК СТРЕМЛЕНИЕ БЫТЬ ПРАВЫМ. Пусть каждый останется у своего разбитого корыта. Я буду мучиться со своим "супернепонятным" С++. Вы со своим. Вы хорошие парни и я не хочу быть плохим. Просто я люблю С++. И вы молодцы, раз остаетесь такими принципиальными. Самое главное, чтобы это не было вам во вред. <br>
<p>И еще опять всплыла тема аппаратной защиты. Ну что же...</p>
<p>ТЕМА "Аппаратные ключи"</p>
<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">1.</td><td>Существуют несколько видов ключей, основанных на различной электронной базе. EEPROM, ASIC и на базе микропроцессоров. Я цитирую терминологию самих производителей. EEPROM - самые дешевые, сильно конфликтующие с ПУ и легко эмулируемые, как аппаратно, так и программно. Единственной защитой для них служит нетривиальный программный интерфейс. ASIC - содержат в себе сложно табулируемую функцию. Иногда это большое кол-во алгоритмов шифрования. Средняя цена, почти невозможно проэмулировать аппаратно. Программная эмуляция справедлива только для одной партии ключей. Микропроцессорные ключи - самые дорогие и просто содержат в себе либо часть алгоритма программы, либо зашифрованные разными алгоритмами данные. Протокол обмена с такими ключами всегда шифрованный. Чаще используется на серверах.</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">1.</td><td>Ничего не имею против аппаратной защиты. Более того, отдаю ей предпочтение. НО! Любую идею можно загадить. Т.е. все сильно зависит от SDK, которое разрабатывает поставщик ключа. Иногда, это служит примером КАК НЕ НАДО РАБОТАТЬ С КЛЮЧОМ. Второе НО. Рассмотрим, например, ASIC ключ производства ALLADIN, HASP версия R3. Защищаемые программы 1С Бухгалтерия 7.0+ и иже, также Компас, RS Банк, БЕСТ и т.д. Кажется все вроде хорошо. Но вот беда, стоит хакеру достаточно подкованному в анализе такого рода защит получить инсталлятор той или иной проги. Он вскроет ее, в смысле напишет эмулятор ключа для этой и только этой партии ключей и положит это на болванку. Маленькая оговорка. Если вы когда-нибудь читали чужие проги, если вам приходилось работать в групповом проекте, то вам должно быть знакомо, как может быть узнаваем стиль программирования. Иногда для этого нужно много времени, иногда меньше. Но это знание приходит. Так вот, также с текстами ломаемых программ. Точно также привыкаешь к манере написания и "антиотладочных фокусов" ALLADIN(ключ HASP) или Rainbow(ключ Santinel). Поэтому если хакер уже ломал что-то от одной фирмы, то он привык к стилю. Ему уже составит меньших усилий проанализировать "новый" код этой фирмы. Итак, он пишет эмулятор и кладет на болванку. И, в общем-то, неважно привязан инсталлятор к этому ключу или нет. Он поставляет инсталлятор вместе с эмулятором. Иногда можно поступить проще. Например, если программа поддерживает младшие версии ключа, то и старые эмуляторы могут подойти. Благо SDK для таких вещей найти можно. Вот так гадко и не хорошо. <br>
<p>Поймите, неважно, где хранится ключ. Во внешней микросхеме или в голове покупателя. Помните, покупателем может оказаться и хакер. ВСЕГДА ДОСТАТОЧНО ОДНОГО ЭКЗЕМПЛЯРА ИНСТАЛЯТОРА, чтобы начать штамповку болванок и гнать их за 65 рублей. Я, наверно, плохо объясняю? Ну, тогда сами придумайте себе причину, почему АКМ больше не будет писать про АППАРАТНУЮ ЗАЩИТУ.</td></tr></table></div><p class="p_Heading1">ТЕМА "Антиотладочные приемы или слышать об этом больше не хочу"</p>
<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">1.</td><td>Флаг трассировки. Суть: сброс флага TF в регистре состояний процессора посредством команд ассемблера POPF или IRET. Изжил себя увеличением возможностей процессора к отладке, а также понятием "Виртуальная машина".</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">1.</td><td>Прерывания. Суть: не дать использовать отладчикам прерывания INT 1 и INT 3. Относительно INT 1 смотри предыдущий прием. INT 3 генерится процессором, если в теле программы встречается опкод 0xCC. Распространенные способы:</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 72px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>Вешание декодера кода или данных на INT 3.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 72px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>Постоянный подсчет CRC суммы процедуры, чтобы не вставлялся 0xCC.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 72px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>Разброс по программе большого количества 0xCC.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 72px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>Чтение адресов обработчиков прерываний и хранение там каких-нить важных переменных.</td></tr></table></div>
<pre>
mov&nbsp;&nbsp;&nbsp;&nbsp; ah, 25h
mov&nbsp;&nbsp;&nbsp;&nbsp; al, Int_Number 
mov&nbsp;&nbsp;&nbsp;&nbsp; dx, offset New_Int_Routine
int&nbsp;&nbsp;&nbsp;&nbsp; 21h
</pre>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 72px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>Чтение IDT и выполнение вышеперечисленных фокусов Типа 'Stone's Win32 Winice Detector':</td></tr></table></div>
<pre>
sidt&nbsp;&nbsp; fword ptr pIDT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ; Вытащить IDT
mov&nbsp;&nbsp;&nbsp; eax, dword ptr [pIDT+2] ; eax -&gt; IDT
add&nbsp;&nbsp;&nbsp; eax,8 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ; eax -&gt; int 1 "vector"
mov&nbsp;&nbsp;&nbsp; ebx, [eax]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ; ebx == int 1 "vector"
add&nbsp;&nbsp;&nbsp; eax, 16 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ; eax -&gt; int 3 "vector"
mov&nbsp;&nbsp;&nbsp; eax, [eax]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ; eax == int 3 "vector"
and &nbsp;&nbsp; eax, 0ffffh&nbsp;&nbsp;&nbsp;&nbsp; ; не использовать селектор
and &nbsp;&nbsp; ebx, 0ffffh&nbsp;&nbsp;&nbsp;&nbsp; ; а учитвать только младшее слово
sub&nbsp;&nbsp;&nbsp; eax, ebx&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ; при подсчете разницы
cmp&nbsp;&nbsp;&nbsp; eax, 01eh&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ; и для Siw95 3.0 она равна 1eh
</pre>
&nbsp;</p>
Кстати, этот прием был очень распространен, т.к. применим к Ring3. Способы не используются, т.к. <br>
а) нельзя сделать динамическую расшифровку сегмента кода.<br>
б) кракеры почти не используют такой метод установки брейка.<br>
<p>в) АЙС устанавливает ловушку(HOOK) на такие штуки. (bpint или bpm)</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 72px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>Блокировка всех аппартных прерываний. Данный метод реализуется несколькими способами: <br>
а) сброс флага FI.<br>
б) программирование контроллера прерываний.<br>
<p>в) программирование порта клавы и др. устройств на запрет аппаратного прерывания.</td></tr></table></div>Полностью пропали после того, как:</p>
а) Этот код требует переноса себя в VXD (см. пред.АКМ).<br>
<p>б) SoftICE начал эмулировать работу с портами (см. пред.АКМ).</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 72px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>Сброс отладочных регистров защищенного режима. dr7=0x700 если ICE присутствует. SoftICE перехватывает запись и чтение в/из регистров DR0-DR7. И просто не дает изменить содержимое этих регистров или возвращает 0 или 0х400. Поэтому этот прием не используется, потому что такой код должен быть перенесен в VXD, имеет постоянную сигнатуру и был уже 1.5 года назад предусмотрен в АЙСовых патчах(ловушках).</td></tr></table></div><p>Итак - все современные приемы борьбы с отладкой сводятся к обнаружению и уничтожению SoftICE в системе. Сами оценивайте недостатки и преимущества. Да, маленький комент. Когда я буду писать метод устранения, то буду иметь прежде всего обнаружение, т.е. брейк.</p>
<p>Прием N1: ФАЙЛОВЫЙ.</p>
<p>а) FindFirst и FindNext-ом ищется loader32 или sivwid.386; Устраняется перехватом этих функций.<br>
б) Через VWIN32.vxd читаем напрямую сектора с диска или кластеры и исчем там строку "tIce" или "SIWVID" или "WINICE" или "NTICE". Разновидность этого извращенного способа - использование библиотек, реализующих прямой доступ к файлам через FAT. Пример доступа ищи на Torry. Если не найдете - выложу на КОРОЛЕВСТВЕ. Устраняется все той же ловушкой на DeviceIOControl. <br>
<p>в) Поиск "подозрительных" записей в регистри. В частности:</p>
<p>HKEY_LOCAL_MACHINE\Software\Microsoft\Windows\CurrentVersion\Uninstall\SoftICE</p>
<p>HKEY_LOCAL_MACHINE\Software\NuMega\SoftICE</p>
<p>HKEY_LOCAL_MACHINE\Software\Microsoft\Windows\CurrentVersion\App Paths\Loader32.Exe</p>
<p>Устраняется ловушкой на операции с Registry. <br>
<p>г) Вариации на предыдущий способ. Работа с регистри через файловые операции или через сектора. Устраняется теми же способами.</p>
<p>Прием N2: Девайсный.</p>
<p> &nbsp; &nbsp; &nbsp; &nbsp;а) Этот способ приведен в FrogICE - патче к SoftIce.</p>
<pre>
        xor     di,di
        mov     es,di
        mov     ax, 1684h       
        mov     bx, 0202h       ; VxD ID для драйвера "winice"
        int     2Fh
        mov     ax, es          ; ES:DI -&gt; VxD API entry point
        add     ax, di
        test    ax,ax
        jnz     SoftICE_Detected
        //-----------------------------------------
        xor     di,di
        mov     es,di
        mov     ax, 1684h       
        mov     bx, 7a5fh       ; VxD ID для драйвера "SIWVID"
        int     2Fh
        mov     ax, es          ; ES:DI -&gt; VxD API entry point
        add     ax, di
        test    ax,ax
        jnz     SoftICE_Detected
</pre>
<p> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</p>
<p>Я этот способ встречал, но это было под win95(не OSR) и для 3ей версии SoftICE. У меня же установлен 4.0.5(Build 334). Попробовал этот способ на win9x OSR2, но это приводит к синим экранам. Но ID остались прежними, вообще запомните эти цифры. Для любопытных ниже привожу стек "выхода" на обвал синих экранов через вышеуказанные фрагменты кода. Хотя, конечно, никакой это не стек это history: <br>
<p>- После проверки функций (5300,53001,53002,4001,4002,4021,4022,4023,4026,4027) попадаем на INT 30H;V86MMGR(01)+0658</p>
<p>-Allocate_PM_Call_Back</p>
<p>V86MMGR_Get_Version</p>
<p>///////////////////</p>
<p>Simulate_Far_Call</p>
<p>Allocate_PM_Call_Back</p>
<p>VDD_DO_Phisical_IO</p>
<p>///////////////////</p>
<p>Simulate_Far_Call</p>
<p>Allocate_PM_Call_Back</p>
<p>End_Reentrant_Execution</p>
<p>Simulate_IRet</p>
<p>Build_Int_Stack_Frame</p>
<p>///////////////////</p>
<p>Синий экран</p>
<p>б) Способ аналогичный предыдущему, но не для Ring3, а для Ring0. Т.е. для тех кто знает, что такое DDK.</p>
<pre>//---Ring0 only----------
VMMCall Test_Debug_Installed 
je&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; not_installed
//------ИЛИ----------------
//-----Ring0 only----------
mov&nbsp;&nbsp;&nbsp;&nbsp; eax, Device_ID&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ; VxD ID -&gt; 202h для SICE или 7a5Fh для SIWVID 
mov&nbsp;&nbsp;&nbsp;&nbsp; edi, Device_Name &nbsp;&nbsp;&nbsp;&nbsp; ; можно указать символьное имя устройства, 
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;; если же задан ID, то можно пустую строку.
VMMCall Get_DDB
mov&nbsp;&nbsp;&nbsp;&nbsp; [DDB], ecx&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ; ecx=DDB или 0 если VxD нету
</pre>
<p>Небольшой комментарий для чистых паскалистов. Эти способы вам не светят. Т.к. для того, чтобы его реализовать нужно установить DDK. Соответственно, хидера для сей и инклудники для асма. Плюс еще некоторые тулзы и библиотеки. А VMMCall это макрос, а не "вызов" библиотечной функции. Он транслируется в INT 20H + маска адреса вызова. (См. DDK).</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; оба способа устранаются bpx Get_DDB if ax==0202 || ax==7a5fh</p>
<p>в) MeltICE - это официальное название сл. метода:</p>
<p>CreateFile('\\.\SICE',...) //для win32</p>
<p>или</p>
<p>_lopen('\\.\SICE',0) //для win16</p>
<p>Естественно, имя может быть либо SICE, либо SIVW, либо NTICE. Если открыть VXD удалось, то значит гад сидит в памяти. Что происходит (см.FrogICE): Фактически, после вызова CreateFileA мы попадаем в Kernel32!ORD_0001, эта затычка эмулирует VxDCall, она нас приводит к функции vxd-шки VWIN32 под названием _VWIN32_ReleaseWin32Mutex и затем мы получаем список DDB и ищем что задано. Она не грузит vxd, а просто посылает им DIOC_OPEN и DIOC_CLOSEHANDLE сообщения и находит как динамически так и не динамически загруженные VXD.<br>
<p>Отсюда способ устранения:</p>
<p> BPX CreateFileA if *(esp-&gt;4+4)=='SICE' || *(esp-&gt;4+4)=='SIWV' || *(esp-&gt;4+4)=='NTIC'</p>
<p>или &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
<p> &nbsp; BPINT 30 if eax==002A001F &amp;&amp; (*edi=='SICE' || *edi=='SIWV')&nbsp;</p>
<p>; очень медленно т.к. обращение к INT 30 и INT 20 происходит очень часто</p>
<p>или</p>
<p> &nbsp; BPINT 30 if (*edi=='SICE' || *edi=='SIWV')</p>
<p>или</p>
<p> &nbsp; BPX KERNEL32!ORD_0001 if *edi=='SICE' || *edi=='SIWV'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
<p>или</p>
<p> &nbsp; BPX VMM_GetDDBList if eax-&gt;3=='SICE' || eax-&gt;3=='SIWV' ;самый быстрый</p>
<p>Прием N3: Интерфейсные прерывания.</p>
<p>Так или иначе ICE использует для организации внутреннего API сл. прерывания:</p>
<p>int 3</p>
<p>int 41h</p>
<p>int 68h.</p>
<p>Вообще-то АЙС использует еще и int 1Ah. Но я не буду ничего говорить об этом. Т.к. данное об этом я вытащил, просмотрев SIWVID.386. Это может оказаться не справедливым для других версий АЙСА или для НТ. <br>
<p>Давайте посмотрим, что написано в FrogICE по поводу 3ех предыдущих прерываний. Кстати, если хотите узнать о прерываниях вообще воспользуйтесь командой SIDT. Итак:</p>
<p>"ИСПОЛЬЗОВАНИЕ INT 3 ДЛЯ ИНТЕРФЕЙСА С BoundsChecker" (редко используется)</p>
<pre>function IceCheck : boolean;
asm
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; push&nbsp;&nbsp;&nbsp; ebp
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; mov&nbsp;&nbsp;&nbsp;&nbsp; ebp, 04243484Bh&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ; 'BCHK'
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; mov&nbsp;&nbsp;&nbsp;&nbsp; ax, 4
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; int&nbsp;&nbsp;&nbsp;&nbsp; 3 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; xor &nbsp;&nbsp;&nbsp; ax, 4
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; pop&nbsp;&nbsp;&nbsp;&nbsp; ebp
end;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
//....
if IceCheck then ShowMessage('SoftICE detected');
</pre>
<p>"ИСПОЛЬЗОВАНИЕ INT 3 ДЛЯ РАБОТЫ С КОМАНДНОЙ СТРОКОЙ SoftICE" (очень часто)</p>
<p>Впервые было замечено в защите HASPа еще под ДОСкой. Посмотрим описаловку:</p>
<p>//функции</p>
<p>-AX = 0910h&nbsp;&nbsp; (Display string in SIce windows)</p>
<p>-AX = 0911h&nbsp;&nbsp; (Execute SIce commands -command is displayed is ds:dx)</p>
<p>-AX = 0912h&nbsp;&nbsp; (Get breakpoint infos)</p>
<p>-AX = 0913h&nbsp;&nbsp; (Set Sice breakpoints)</p>
<p>-AX = 0914h&nbsp;&nbsp; (Remove SIce breakoints)</p>
<p>//обязаловка</p>
<p>-SI = 4647h</p>
<p>-DI = 4A4Dh</p>
<p> INT&nbsp; 3</p>
<p>Например, в FrogICE приводится дамп из HASPINST.EXE старой версии, где выполняются следующий набор команд SoftICE "LDT, IDT, GDT, TSS, RS, HBOOT". Как видите в конце стоит банальная перезагрузка. Так что, достаточно написать волшебные SI,DI,AX=0911,DX=СТРОКА и INT 3. То случится страшное, если конечно за SoftICE-ом сидит лопух.</p>
<p>"МАГИЧЕСКОЕ ПРЕРЫВАНИЕ"</p>
<p>Если вызвать INT 41H с функцией AX=4Fh, то в АХ запишется число равное 0F386Н в случае присутсвтия какого-нить системного дебугера. Только не спешите писать следующую функцию:</p>
<pre>function IceCheck : boolean;
asm
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; mov&nbsp;&nbsp;&nbsp;&nbsp; ax,4fh
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; int&nbsp;&nbsp;&nbsp;&nbsp; 41h
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; cmp&nbsp;&nbsp;&nbsp;&nbsp; ax,0F386h
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; jz&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; @@End
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; xor &nbsp;&nbsp;&nbsp; ax,ax
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; @@End:
end;
</pre>
<p>Такие простушки АЙСОМ давно мониторятся. Поэтому очень присоветую следующий подход, позволяющий СИЛЬНО ОСЛОЖНИТЬ ЖИЗНЬ хакера при детектировании IceChecker-а. ПРАВИЛЬНЫЙ ПОДХОД: 1) сохранить старый обработчик INT 41H (умоляю не действуйте напрямую в памяти - только через int 21H или IDT) 2) установить новый обработчик 3) сей обработчик должен делать что-то жизненно-важное для проги и как следствие менять регистры. И в проге появляется масса INT 41H 4) Если ICE загружен, то он постарается не дать поставить новый обработчик. Метод устранения. Поставить bpint или bpx exec_int if ax==41, узнать что делает защита, выйти, запустить какой-нить HexEditor и поставить везде не int 41H, а int 42H, и танцуем джигу на костях защиты.</p>
<p>"ВТОРОЕ МАГИЧЕСКОЕ ПРЕРЫВАНИЕ"</p>
<p>Брат близнец предыдущего INT 41H, это INT 68H и тоже число в АХ=0F386H. Все что можно сказать про INT 68H - сказано уже в разделе про INT 41H.</p>
<p>"ОТСЕБЯТИНА"</p>
<p>Ну вот вроде все методы "защит" известные ICE. Он их легко обнаруживает и нейтрализует. Работа происходит в "полуавтоматическом" режиме. Можно было бы на этом закончить. Но я приведу один запрещенный прием. НИКОГДА НЕ ИСПОЛЬЗУЙТЕ ЭТОТ МЕТОД.</p>
<p>Этот метод был придуман мной, вернее пришел мне в голову самостоятельно. Я не встречал ссылок и данных на подобную методу. Но я очень даже допускаю, что такой метод уже где-то существует и какой-нить параноик использует его. Почему я его НЕ РЕКОМЕНДУЮ ИСПОЛЬЗОВАТЬ? Придется вам, зажав зубы, послушать вступление, кому не в терпеж может сам копаться в сырцах.</p>
<p>Для терпеливых. Этот метод не универсален, т.е. он только для win95 и его также можно обнаружить, но обнаружить его будет сложней, чем все другие методы. Значит, если вы не боитесь, что ваша программа станет привязана к win95 и не будет работать на др. системах, то слушайте.</p>
<p>Выше адресного пространства процесса (80000000Н) находится код системы, кеш и VXD. Если быть конкретным, то для win95 это адреса с 0С0000000H по 0С0E00000H - тут живут "статичные" VXD. К их числу принадлежит и ICE. Дальше не так интересно, но с 0С0E00000H по 0СF000000H живут динамически подгружаемые VXD. Теперь самое главное надеюсь вы узнаете:</p>
<p> &nbsp;&nbsp; struct VxD_Desc_Block {</p>
<p> &nbsp;&nbsp; ULONG DDB_Next;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; /* VMM RESERVED FIELD */</p>
<p> &nbsp;&nbsp; USHORT DDB_SDK_Version;&nbsp;&nbsp;&nbsp;&nbsp; /* INIT&nbsp; RESERVED FIELD */</p>
<p> &nbsp;&nbsp; USHORT DDB_Req_Device_Number;&nbsp;&nbsp; /* INIT&nbsp; */</p>
<p> &nbsp;&nbsp; UCHAR DDB_Dev_Major_Version;&nbsp;&nbsp;&nbsp; /* INIT &lt;0&gt; Major device number */</p>
<p> &nbsp;&nbsp; UCHAR DDB_Dev_Minor_Version;&nbsp;&nbsp;&nbsp; /* INIT &lt;0&gt; Minor device number */</p>
<p> &nbsp;&nbsp; USHORT DDB_Flags;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; /* INIT &lt;0&gt; for init calls complete */</p>
<p> &nbsp;&nbsp; UCHAR DDB_Name[8];&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; /* AINIT &lt;"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; "&gt; Device name */</p>
<p> &nbsp;&nbsp; ULONG DDB_Init_Order;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; /* INIT&nbsp; */</p>
<p> &nbsp;&nbsp; ULONG DDB_Control_Proc;&nbsp;&nbsp;&nbsp;&nbsp; /* Offset of control procedure */</p>
<p> &nbsp;&nbsp; ULONG DDB_V86_API_Proc;&nbsp;&nbsp;&nbsp;&nbsp; /* INIT &lt;0&gt; Offset of API procedure */</p>
<p> &nbsp;&nbsp; ULONG DDB_PM_API_Proc;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; /* INIT &lt;0&gt; Offset of API procedure */</p>
<p> &nbsp;&nbsp; ULONG DDB_V86_API_CSIP;&nbsp;&nbsp;&nbsp;&nbsp; /* INIT &lt;0&gt; CS:IP of API entry point */</p>
<p> &nbsp;&nbsp; ULONG DDB_PM_API_CSIP;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; /* INIT &lt;0&gt; CS:IP of API entry point */</p>
<p> &nbsp;&nbsp; ULONG DDB_Reference_Data;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; /* Reference data from real mode */</p>
<p> &nbsp;&nbsp; ULONG DDB_Service_Table_Ptr;&nbsp;&nbsp;&nbsp; /* INIT &lt;0&gt; Pointer to service table */</p>
<p> &nbsp;&nbsp; ULONG DDB_Service_Table_Size;&nbsp;&nbsp; /* INIT &lt;0&gt; Number of services */</p>
<p> &nbsp;&nbsp; ULONG DDB_Win32_Service_Table;&nbsp; /* INIT &lt;0&gt; Pointer to Win32 services */</p>
<p> &nbsp;&nbsp; ULONG DDB_Prev;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; /* INIT &lt;'Prev'&gt; Ptr to prev 4.0 DDB */</p>
<p> &nbsp;&nbsp; ULONG DDB_Size;&nbsp;&nbsp;&nbsp;&nbsp; /* INIT&nbsp; Reserved */</p>
<p> &nbsp;&nbsp; ULONG DDB_Reserved1;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; /* INIT &lt;'Rsv1'&gt; Reserved */</p>
<p> &nbsp;&nbsp; ULONG DDB_Reserved2;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; /* INIT &lt;'Rsv2'&gt; Reserved */</p>
<p> &nbsp;&nbsp; ULONG DDB_Reserved3;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; /* INIT &lt;'Rsv3'&gt; Reserved */</p>
<p> &nbsp; };</p>
<p>Правильно. Это заголовок VXD. Все что нам нужно знать - это три последних поля и имя. Да, теперь остается только просканировать область VXD и найти "подозрительный". На winNT этот способ доступен только на уровне Ring0, т.е. вам придется освоить Си. Да и еще, вы должны знать на что накалывайте хакера. КОМАНДА BPR - брейк на операцию с участком памяти нельзя поставить на область системного стека и выше, т.е. область VXD. Т.о. BPR нельзя использовать для отлова к обращению к VXD. КОМАНДА BPM - аппаратный брейк на конкретный адрес. Также не может быть установлен на область выше границ процесса, "большой восьмерки". Многие безобидные и обдиные команды АЙСА не работают в этой области памяти. Что может навести на мысль - использовать незанятые места в этих областях. Да и, Единственная, VXD терпимая операция это BPX, но вентили девайсов мы не используем. Поэтому хакеру придется запускать IDAPro и сканить константу 0С0000000H. Но не факт, что мы с нее начнем и не факт, что мы ее будем хранить, а не генерить. Можно не искать резервные байты, можно искать ключевые строчки для АЙСА по области VXD. Да вот, проблема. Не советую пользоваться VirtualQuery. Это раз. Кратность 64К адреса страницы - на это винда сама для себя положила. Поэтому в этом случае придется стряпать SEH на Access Violation, тьфу в смысле try except. Можете импровизировать. Это сильно осложняет жизнь хакеру. Но приходится платить несовместимостью. И одним из способов устранения будет...</p>

<p><a href="https://www.delphikingdom.com" target="_blank">https://www.delphikingdom.com</a></p>

