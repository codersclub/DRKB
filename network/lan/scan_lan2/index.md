---
Title: Обзор сети (типа Network Neighborhood)
Date: 01.01.2007
Source: <https://articles.org.ru>
---


Обзор сети (типа Network Neighborhood)
======================================

Пример может служить отправной точкой для создания рабочего варианта.



    unit netres_main_unit;
     
    interface
     
    uses
    windows, messages, sysutils, classes, graphics, controls, forms,
    dialogs, comctrls, stdctrls, buttons, menus, extctrls;
     
    type
    tfrmmain = class(tform)
    tvresources: ttreeview;
    btnok: tbitbtn;
    btnclose: tbitbtn;
    label1: tlabel;
    barbottom: tstatusbar;
    popresources: tpopupmenu;
    mniexpandall: tmenuitem;
    mnicollapseall: tmenuitem;
    mnisavetofile: tmenuitem;
    mniloadfromfile: tmenuitem;
    grplisttype: tradiogroup;
    grpresourcetype: tradiogroup;
    dlgopen: topendialog;
    dlgsave: tsavedialog;
    procedure formcreate(sender: tobject);
    procedure btncloseclick(sender: tobject);
    procedure formshow(sender: tobject);
    procedure mniexpandallclick(sender: tobject);
    procedure mnicollapseallclick(sender: tobject);
    procedure mnisavetofileclick(sender: tobject);
    procedure mniloadfromfileclick(sender: tobject);
    procedure btnokclick(sender: tobject);
    private
    listtype, resourcetype: dword;
    procedure showhint(sender: tobject);
    procedure doenumeration;
    procedure doenumerationcontainer(netrescontainer: tnetresource);
    procedure addcontainer(netres: tnetresource);
    procedure addshare(topcontainerindex: integer; netres: tnetresource);
    procedure addsharestring(topcontainerindex: integer; itemname: string);
    procedure addconnection(netres: tnetresource);
    end;
     
    var
    frmmain: tfrmmain;
     
    implementation
     
    {$r *.dfm}
     
    procedure tfrmmain.showhint(sender: tobject);
    begin
    barbottom.panels.items[0].text := application.hint;
    end;
     
    procedure tfrmmain.formcreate(sender: tobject);
    begin
    application.onhint := showhint;
    barbottom.panels.items[0].text := '';
    end;
     
    procedure tfrmmain.btncloseclick(sender: tobject);
    begin
    close;
    end;
     
    { Перечисляем все сетевые ресурсы }
    procedure tfrmmain.doenumeration;
    var
    netres: array[0..2] of tnetresource;
    loop: integer;
    r, henum, entrycount, netreslen: dword;
    begin
    case grplisttype.itemindex of
    { Подключенные ресурсы: }
    1: listtype := resource_connected;
     
    { Возобновляемые ресурсы: }
    2: listtype := resource_remembered;
    { Глобальные: }
    else listtype := resource_globalnet;
    end;
    case grpresourcetype.itemindex of
    { Дисковые ресурсы: }
    1: resourcetype := resourcetype_disk;
    { Принтерные ресурсы: }
    2: resourcetype := resourcetype_print;
    { Все: }
    else resourcetype := resourcetype_any;
    end;
    screen.cursor := crhourglass;
    try
    { Удаляем любые старые элементы из дерева }
    for loop := tvresources.items.count - 1 downto 0 do
    tvresources.items[loop].delete;
    except
    end;
    { Начинаем перечисление: }
    r := wnetopenenum(listtype, resourcetype, 0, nil, henum);
    if r <> no_error then begin
    if r = error_extended_error then
    messagedlg('Невозможно сделать обзор сети.' + #13
    + 'Произошла сетевая ошибка.', mterror, [mbok], 0)
    else
    messagedlg('Невозможно сделать обзор сети.', mterror, [mbok], 0);
    exit;
    end;
    try
    { Мы получили правильный дескриптор перечисления; опрашиваем ресурсы }
    while (1 = 1) do begin
    entrycount := 1;
    netreslen := sizeof(netres);
    r := wnetenumresource(henum, entrycount, @netres, netreslen);
    case r of
    0: begin { Это контейнер, организуем итерацию: }
    if netres[0].dwusage = resourceusage_container then
    doenumerationcontainer(netres[0])
    else { Здесь получаем подключенные и возобновляемые ресурсы }
    if listtype in [resource_remembered, resource_connected] then
    addconnection(netres[0]);
    end;
    error_no_more_items: { Получены все ресурсы: }
    break;
    else begin { Другие ошибки: }
    messagedlg('Ошибка опроса ресурсов.', mterror, [mbok], 0);
    break;
    end;
    end;
    end;
    finally
    screen.cursor := crdefault;
    { Закрываем дескриптор перечисления: }
    wnetcloseenum(henum);
    end;
    end;
     
    { Перечисление заданного контейнера. Эта функция обычно вызывается рекурсивно }
    procedure tfrmmain.doenumerationcontainer(netrescontainer: tnetresource);
    var
    netres: array[0..10] of tnetresource;
    topcontainerindex: integer;
    r, henum, entrycount, netreslen: dword;
    begin
    { Добавляем имя контейнера к найденным сетевым ресурсам }
    addcontainer(netrescontainer);
    { Делаем этот элемент текущим корневым уровнем }
    topcontainerindex := tvresources.items.count-1;
    { Начинаем перечисление: }
    if listtype = resource_globalnet then
    { Перечисляем глобальные объекты сети: }
    r := wnetopenenum(listtype, resourcetype, resourceusage_container,
    @netrescontainer, henum)
    else
    { Перечисляем подключаемые и возобновляемые ресурсы 
    (другие получить здесь невозможно) }
    r := wnetopenenum(listtype, resourcetype, resourceusage_container, nil, henum);
    { Невозможно перечислить ресурсы данного контейнера, выводим соответствующее
    предупреждение и едем дальше }
    if r <> no_error then begin
    addsharestring(topcontainerindex, '<Не могу опросить ресурсы (Ошибка #'
    + inttostr(r) + '>');
    wnetcloseenum(henum);
    exit;
    end;
    { Мы получили правильный дескриптор перечисления; опрашиваем ресурсы }
    while (1 = 1) do begin
    entrycount := 1;
    netreslen := sizeof(netres);
    r := wnetenumresource(henum, entrycount, @netres, netreslen);
    case r of
    0: begin { Другой контейнер для перечисления,
    необходим рекурсивный вызов }
    if (netres[0].dwusage = resourceusage_container)
    or (netres[0].dwusage=10) then
    doenumerationcontainer(netres[0])
    else
    case netres[0].dwdisplaytype of
    { Верхний уровень }
    resourcedisplaytype_generic,
    resourcedisplaytype_domain,
    resourcedisplaytype_server: addcontainer(netres[0]);
    { Ресурсы общего доступа: }
    resourcedisplaytype_share:
    addshare(topcontainerindex, netres[0]);
    end;
    end;
    error_no_more_items: break;
    else begin
    messagedlg('Ошибка #' + inttostr(r) + ' при перечислении ресурсов.',
    mterror, [mbok], 0); 
    break;
    end;
    end;
    end;
    { Закрываем дескриптор перечисления }
    wnetcloseenum(henum);
    end;
     
    procedure tfrmmain.formshow(sender: tobject);
    begin
    doenumeration;
    end;
     
    { Добавляем элементы дерева; помечаем, что это контейнер }
    procedure tfrmmain.addcontainer(netres: tnetresource);
    var
    itemname: string;
    begin
    itemname := trim(string(netres.lpremotename));
    if trim(string(netres.lpcomment))<>'' then begin
    if itemname <> '' then itemname := itemname + ' ';
    itemname := itemname + '(' + string(netres.lpcomment) + ')';
    end;
    tvresources.items.add(tvresources.selected,itemname);
    end;
     
    { Добавляем дочерние элементы к контейнеру, обозначенному как текущий
    верхний уровень }
    procedure tfrmmain.addshare(topcontainerindex: integer; netres: tnetresource);
    var
    itemname: string;
    begin
    itemname := trim(string(netres.lpremotename));
    if trim(string(netres.lpcomment)) <> '' then begin
    if itemname <> '' then itemname := itemname + ' ';
    itemname := itemname + '(' + string(netres.lpcomment) + ')';
    end;
    tvresources.items.addchild(tvresources.items[topcontainerindex], itemname);
    end;
     
    { Добавляем дочерние элементы к контейнеру, обозначенному как текущий верхний
    уровень; это просто добавляет строку для таких задач, как, например, перечисление
    контейнера. То есть некоторые контейнерные ресурсы общего доступа нам не
    доступны. }
    procedure tfrmmain.addsharestring(topcontainerindex: integer; itemname: string);
    begin
    tvresources.items.addchild(tvresources.items[topcontainerindex], itemname);
    end;
     
    { Добавляем соединения к дереву. По большому счету, к этому моменту все сетевые
    ресурсы типа возобновляемых и текущих соединений уже отображены. }
    procedure tfrmmain.addconnection(netres: tnetresource);
    var
    itemname: string;
    begin
    itemname := trim(string(netres.lplocalname));
    if trim(string(netres.lpremotename)) <> '' then begin
    if itemname <> '' then itemname := itemname + ' ';
    itemname := itemname + '-> ' + trim(string(netres.lpremotename));
    end;
    tvresources.items.add(tvresources.selected, itemname);
    end;
     
    { Раскрываем все контейнеры дерева }
    procedure tfrmmain.mniexpandallclick(sender: tobject);
    begin
    tvresources.fullexpand;
    end;
     
     
    { Схлопываем все контейнеры дерева }
    procedure tfrmmain.mnicollapseallclick(sender: tobject);
    begin
    tvresources.fullcollapse;
    end;
     
    { Записываем дерево в выбранный файл }
    procedure tfrmmain.mnisavetofileclick(sender: tobject);
    begin
    if dlgsave.execute then tvresources.savetofile(dlgsave.filename);
    end;
     
    { Загружаем дерево из выбранного файла }
    procedure tfrmmain.mniloadfromfileclick(sender: tobject);
    begin
    if dlgopen.execute then tvresources.loadfromfile(dlgopen.filename);
    end;
     
    { Обновляем }
    procedure tfrmmain.btnokclick(sender: tobject);
    begin
    doenumeration;
    end;
     
    end.
