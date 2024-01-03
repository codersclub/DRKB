---
Title: Telnet
Date: 01.01.2007
---


Telnet
======

::: {.date}
01.01.2007
:::

TELNET

На практике ваши возможности лимитируются тем уровнем доступа, которым
задан для вас администратором удаленной системы. Во всяком случае вы
должны иметь свой идентификатор id (userid или username) и пароль для
входа в систему.

В то же время, только относительно небольшое количество компьютеров в
internet позволяют свободный доступ через telnet. Использование telnet
Чтобы подключиться к удаленной машине в internet и произвести те или
иные действия в ней, запустите программу telnet, которая является
пользовательским интерфейсом протокола telnet (в данном случае речь идет
о вводе команды на unix или unix-подобных системах, о работе
программ-клиентов для telnet на других платформах будет сказано
отдельно).
Формат команды (не полная, но достаточная для практики, версия)
telnet host [port]

где
host - официальное доменное имя машины или ее псевдоним (alias), или ее
ip-адрес в виде цифр, разделенных точками;
port - определяет номер порта (адрес приложения). Если номер порта не
задан, то принимается номер порта telnet по умолчанию - 23.
Если команда telnet используется без аргументов, тогда вводится
командный режим, о котором сигнализирует подсказка

telnet \>
В этом режиме доступа и выполняются следующие основные команды:

open host [-port], - открывает соединение с названной системой; close
- закрывает telnet соединения и возвращает вас в командный режим; quit -
заканчивает все открытые telnet соединения и выводит вас из telnet;

! [команда] - выполнение отдельной команды в shell на локальной
системе; status - показывает текущий статус telnet;

? [команда] - получение помощи. Если аргумента нет, то telnet выдает
список всех своих команд. Возможные сообщения об ошибках

unknown host 1. Имя или адрес были набраны неправильно
connection refused 1. Удаленный компьютер функционирует с ошибками
connection dropped Проблема с сетью или удаленным хостом, приведшая к
закрытию соединения


Особенности

Порой весьма сложно закрыть telnet-соединения, например, из-за резкого
замедления прохождения ip-пакетов или разрыва связи по выделенной линии.
Лучший совет - внимательно читать все инструкции, которые появляются,
когда вы делаете login в систему. Если же на экране нет ничего, что
могло бы помочь, попробуйте одну из этих команд:

exit, quit, logout, //end, end, leave, bye,
disconnect, goodbye, ciao, ctrl-d, или ctrl-z.
В последнем случае на ряде платформ ctrl-z переводит ваше telnet
соединение в фоновый режим с выводом номера процесса, после чего
желательно оборвать этот процесс командой

kill idprocess

Если перечисленные команды не приводят к нужному результату, то остается
ctrl-] или ctrl-^, которые заканчивают telnet соединение. Это вернет
Вас в режим подсказки telnet\>.

Введите quit или exit после telnet\>,
этим Вы закончите свой сеанс.


Некоторые примеры и адреса

    unit unit1;
    interface
     
    uses
    windows, messages, sysutils, classes, graphics, controls, forms, dialogs,
    stdctrls, shlobj, buttons;
    //необходимые константы
    const
    lm20_nnlen = 12;
    shpwlen = 8;
    shi50f_rdonly = 1;
    shi50f_full = 2;
    stype_disktree = 0;
     
    maxnetarrayitems = 512;
     
    //формируем тип для записи с необходимыми параметрами
    type
    //для win'9x
    tshareinfo50 = packed record
    shi50_netname: array[0..lm20_nnlen] of char; //сетевое имя
    shi50_type: byte; //тип ресурса
    shi50_flags: short; //флаг доступа
    shi50_remark: pchar; // комментарий
    shi50_path: pchar; // путь к ресурсу
    shi50_rw_password: array[0..shpwlen] of char; //пароль полного доступа
    shi50_ro_password: array[0..shpwlen] of char;
    //пароль "только чтение" доступа
    end;
     
    tshareevent = record //информация о сетевом ресурсе
    res: integer;
    readonlypassword: string;
    fullaccesspassword: string;
    comments: string;
    path: string;
    end;
    < a name = form > < / a >
    tform1 = class(tform)
    edcomputernetname: tedit;
    button1: tbutton;
    combobox1: tcombobox;
    bitbtn1: tbitbtn;
    bitbtn2: tbitbtn;
    lbreadonlypassword: tlabel;
    edreadonlypassword: tedit;
    lbfullaccesspassword: tlabel;
    edfullaccesspassword: tedit;
    lbcomments: tlabel;
    edcomments: tedit;
    lbphysicalpath: tlabel;
    edphysicalpath: tedit;
    label1: tlabel;
    label2: tlabel;
    procedure button1click(sender: tobject);
    procedure bitbtn1click(sender: tobject);
    procedure bitbtn2click(sender: tobject);
    private
    { private declarations }
    procedure fillshareenum(items: tstrings);
    function getcomputernetname: string;
    function getshareinfo(computernetname, resourcenetname: string):
    tshareevent;
    procedure connectadmin;
    public
    { public declarations }
    end;
     
    var
    form1: tform1;
    function netsharegetinfo(const pszserver: pchar; const psznetname: pchar;
    slevel: smallint; pbbuffer: pointer; cbbuffer: word;
    var pctotalavail: word): dword; stdcall; external 'svrapi.dll' name
    'netsharegetinfo';
    function netshareenum(const pszserver: pchar; slevel: smallint;
    pbbuffer: pointer; cbbuffer: word; var pcentriesread: word;
    var pctotalavail: word): dword; stdcall; external 'svrapi.dll';
     
    implementation
     
    {$r *.dfm}
     
    procedure tform1.connectadmin;
    var
    compname: string;
    res: integer;
    lpnetresource: tnetresource;
    computername: array[0..max_computername_length] of char;
    bufsize: integer;
    begin
    //получим имя локальной машины
    bufsize := max_computername_length + 1;
    getcomputername(@computername, bufsize);
    compname := string(computername);
    //если имя локальной машины совпадает с сетевым именем машины,
    //значит идет запрос о сетевом ресурсе локальной машины -
    //в этом случае admin$ не нужен
    if ansiuppercase(compname) = ansiuppercase(edcomputernetname.text)thenexit;
    //заполним нолями значение указателя
    zeromemory(@lpnetresource, sizeof(lpnetresource));
    //укажем нужные значения
    with lpnetresource do
    begin
    dwtype := resourcetype_any;
    lpremotename := '';
    lpremotename := pchar('' + edcomputernetname.text + 'admin$' + #0);
    end;
    //Сезам, откройся!
    res := wnetaddconnection3(application.handle, lpnetresource, nil, nil,
    connect_interactive);
    //Сезам, к сожалению не открылся...
    if not (res = no_error) then
    begin
    showmessage('with out connected resource "admin$" a work impossible!');
    application.terminate;
    end;
    end;
     
    function tform1.getshareinfo(computernetname, resourcenetname: string):
    tshareevent;
    var
    pbbuffer: ^tshareinfo50; //указатель на буфер
    buf: tshareinfo50; //сам буфер
    res: integer;
    pctotalavail: word; //количество считанных байт
    begin
    with result do //почистим результат функции
    begin
    res := 0;
    readonlypassword := '';
    fullaccesspassword := '';
    comments := '';
    path := '';
    end;
    fillchar(buf, sizeof(buf), #0); //заполним буфер нолями
    //ничего не укажем о нашем буфере и выполним функцию, в результате чего
    //получим в переменную pctotalavail количество считанных байт.
    netsharegetinfo(pchar(computernetname), pchar(resourcenetname), 50, nil, 0,
    pctotalavail);
    //инициализируем буферный указатель и дадим ему нужное количество памяти
    getmem(pbbuffer, pctotalavail);
    //поместим в буфер имя сетевого ресурса, зачем не знаю - имя мы уже и так
    //указываем, но без этого функция почему-то не работает, по крайней мере у меня
    strpcopy(pbbuffer^.shi50_netname, resourcenetname);
    //выполним функцию еще раз уже указав параметры буфера
    res := netsharegetinfo(pchar(computernetname), pchar(resourcenetname), 50,
    pbbuffer, pctotalavail, pctotalavail);
    if res = 0 then //все в порядке
    begin
    //передадим данные из указателя в "обычную" переменную
    buf := pbbuffer^;
    //заполним результат полученными значениями
    result.readonlypassword := string(buf.shi50_ro_password);
    result.fullaccesspassword := string(buf.shi50_rw_password);
    result.comments := string(buf.shi50_remark);
    result.path := string(buf.shi50_path);
    end;
    //освободим указатель
    freemem(pbbuffer);
    end;
     
    procedure tform1.fillshareenum(items: tstrings);
    var
    shareinfo: array[0..maxnetarrayitems - 1] of tshareinfo50;
    entriesread, totalavial: word;
    res: integer;
    n: integer;
    begin
    items.clear; //почистим items
    fillchar(shareinfo, sizeof(shareinfo), #0); //заполним буфер нолями
    res := netshareenum(pchar('' + edcomputernetname.text), 50, @shareinfo,
    sizeof(shareinfo),
    entriesread, totalavial); //имя сетевой машины возьмем из строки ввода,
    //предварительно озаглавив его двумя обратными слэшами
    if res = no_error then //функция выполнена без ошибок
    for n := 0 to entriesread - 1 do
    //пройдемся по буферу считанных имен ресурсов
    if not (string(shareinfo[n].shi50_netname) = '') then
    items.add(string(shareinfo[n].shi50_netname));
    //добавим имя машины в список
    end;
     
    function tform1.getcomputernetname: string;
    var
    rootitemidlist: pitemidlist;
    //идентификатор объекта в пространстве имен проводника
    browseinfo: tbrowseinfo; //структура, в которой содержится информация о диалоге
    buffer: pchar; //сюда получим имя компьютера
    begin
    result := '';
    //получим нужный идентификатор pitemidlist, csidl_network - в сетевом окружении
    if not (shgetspecialfolderlocation(0, csidl_network, rootitemidlist) =
    no_error) then
    exit;
    //подготовим буфер, в который получим имя компьютера
    getmem(buffer, max_path);
    fillchar(browseinfo, sizeof(browseinfo), 0);
    //подготовим структуру tbrowseinfo
    with browseinfo do
    begin {with browseinfo}
    hwndowner := application.handle; //хозяин окна - наше приложение
    pidlroot := rootitemidlist; //полученный ранее идентификатор
    // объекта в списке объектов проводника
    pszdisplayname := buffer; //имя компьютера будем принимать в buffer
    lpsztitle := 'Подключенные компьютеры'; //заголовок диалога
    ulflags := bif_browseforcomputer; //будут показаны имена только компьютеров
    end; {with browseinfo}
     
    //выполним нужную функцию
    if shbrowseforfolder(browseinfo) = nil thenexit;
    result := string(buffer); //вот оно - сетевое имя компьютера
    freemem(buffer);
    end;
     
    procedure tform1.button1click(snder: tobject);
    begin
    edcomputernetname.text := getcomputernetname;
    fillshareenum(combobox1.items);
    combobox1.itemindex := 0;
    end;
     
    procedure tform1.bitbtn1click(sender: tobject);
    var
    shareevent: tshareevent;
    begin
    if (edcomputernetname.text = '') or (combobox1.text = '') then
    begin
    edcomputernetname.setfocus;
    exit;
    end;
    connectadmin;
    shareevent := getshareinfo('' + edcomputernetname.text, combobox1.text);
    edreadonlypassword.text := shareevent.readonlypassword;
    edfullaccesspassword.text := shareevent.fullaccesspassword;
    edcomments.text := shareevent.comments;
    edphysicalpath.text := shareevent.path;
    end;
     
    procedure tform1.bitbtn2click(sender: tobject);
    begin
    close;
    end;
     
    end.


Другие ресурсы, доступные через telnet

ndlc.occ.uky.edu или 128.163.38.10(login: nolc)

База данных дистанционного образования
acsvax.open.ac.uk
или 137.108.48.24
(username: icdl, acconut code: usa password: aaa)

open university(uk)
newton.dep.anl.gov или 130.292.92.50(login: bbs)
bbs для тех, кто преподает / изучает естественные науки,
математику

martini.eecs.umich.edu 3000
или 141.212.99.9 3000 - информация о городах США,
население, географическое положение и др.

locis.loc.gov или 140.147.254.3
marvel.loc.gov или 140.147.2.69

библиотека конгресса США
e - math.ams.com или 130.44.1.100(login / password: e - math)
американское матем.общество, bbs,
програмное обеспечение, обзоры.

gemm.com
база данных о cd и музыкальных клубах
enews.com(login: enews)
электронные журналы(выберите elec.serials)
rusinfo.rus.uni - stuttgart.de или 129.69.1.12(login: info)
Предлагает: журналы, unix - материалы, книги и др.
culine.colorado.edu 859 / 128.138.129.170 859
Расписание nba
culine.colorado.edu 860 / 128.138.129.170 860
Расписание nha
archie(поиск нужных файлов
по всем анонимным ftp серверам)
elnet archie.sura.net or 128.167.254.194(login: archie)

archie.unl.edu or 129.93.1.14
archie.ans.net or 147.225.1.10

archie.rutgers.edu or 128.6.18.15
Здесь приведены только archie-серверы, расположенные в США, более
подробный список приведен в разделе о ftp.

gopher
telnet consultant.micro.umn.edu или 134.84.132.4
infoslug.ucsc.edu или 128.114.143.25[infoslug]
infopath.ucsd.edu(login: infopath)
netfind user lookup
(поиск адреса, места работы пользователя и т.п.)
telnet bruno.cs.colorado.edu
или 128.138.243.150(login: netfind)
cobber.cord.edu или 138.129.1.32
pascal.sjsu.edu или 130.65.86.15
mudhoney.micro.umn.edu или 134.84.132.7
redmont.cis.uab.edu или 138.26.64.4
ds.internic.net или 198.49.45.10
netfind.oc.com или 192.82.215.88
archie.au или 139.130.4.6
netfind.anu.edu.au или 150.203.2.14
netfind.if.usp.br или 143.107.249.132
netfind.ee.mcgill.ca или 132.206.62.30
malloco.ing.puc.cl или 146.155.1.43
netfind.vslib.cz или 147.230.16.1
nic.nm.kr или 143.248.1.100
lincoln.technet.sg или 192.169.33.6
nic.uakom.sk или 192.108.131.12
monolith.cc.ic.ac.uk или 155.198.5.3
lust.mrrl.lut.ac.uk или 158.125.220.7
dino.conicit.ve или 150.188.1.10
whois services
поиск по ключевому слову адреса в internet)
telnet rs.internic.net или 198.41.0.5(login: whois)
info.cnri.reston.va.us 185(knowbot info serv.)
garam.kreonet.re.kr или 134.75.30.11(login: nic)
paradise.ulcc.ac.uk или 128.86.8.56(login: dua)

waistation(wide area information service)
telnet quake.think.com или telnet 192.31.181.1(login: swais)
wais.com или telnet 192.216.46.98

swais.cwis.uci.edu или 128.200.15.2
sunsite.unc.edu или telnet 198.86.40.81
info.funet.fi или 128.214.6.100(login: info)
wais.nis.garr.it или 192.12.192.10(login: wais)
Программы-клиенты

Работа с telnet возможна и с помощью программ-клиентов, функционирующих
под более употребительными операционными системами dos и/или ms-windows.
Один из примеров - free-пакет ncsa telnet для dos или winqvt для
windows.

Обычно пакеты снабжены подробной информацией для инсталляции и
тщательной настройки. Если и возникают проблемы, то они связаны больше с
таблицами кодировок кириллицы или адекватной реакцией от нажатия
комбинаций клавиш или при вызове таких программ как deco или midnight
commander под unix.
Источник:
<https://www.delphirus.com.ru>
