---
Title: Создание курсора с процентом выполнения
Date: 01.01.2007
---

Создание курсора с процентом выполнения
=======================================

::: {.date}
01.01.2007
:::

    { **** UBPFD *********** by kladovka.net.ru ****
    >> Создание курсора с процентом выполнения
     
    Функция возвращает хэндл на созданный курсор Windows (hcursor, hicon)
    с процентным соотношением, указанным в min,max и pos.
    Своего рода ProgressBar, но только зашитый в курсор.
     
    Зависимости: Windows, SysUtils, Graphics, Classes
    Автор:       Роман Василенко, romix@nm.ru, Пятигорск
    Copyright:   Василенко Роман
    Дата:        07 мая 2002 г.
    ********************************************** }
     
    //Используемые модули
    uses Windows, SysUtils, Graphics, Classes;
     
     
    //Сама функция
    function create_prc_cursor(min,max,pos:integer):hicon;
    var
        cwidth, cheight:integer;
        ii:iconinfo;
        bmc,bmm:tbitmap;
        icon:hicon;
        tw:integer;
        tx:string;
     
    function int_percent(umin,umax,upos,uabs:integer):integer;
    begin
        result:=0;
        if umax<umin then exit;
        if upos<umin then exit;
        if upos>umax then begin
            result:=100;
            exit;
        end;
        if (umin=upos) and (umax=upos) then begin
            result:=100;
            exit;
        end;
        result:=round((upos-umin)/((umax-umin)/uabs));
    end;
     
    function create_curspace:tbitmap;
    begin
        result:=tbitmap.create;
        result.pixelformat:=pf4bit;
        result.width:=cwidth;
        result.height:=cheight;
    end;
     
    begin
        cwidth:=getsystemmetrics(sm_cxcursor);
        cheight:=getsystemmetrics(sm_cycursor);
        bmc:=create_curspace;
        bmm:=create_curspace;
        with bmm.Canvas do begin
            brush.color:=clwhite;
            FillRect(rect(0,0,bmm.width,bmm.height));
            brush.color:=clblack;
            fillrect(rect(0,bmm.height-8,bmm.width,bmm.height));
            brush.color:=clwhite;
            framerect(rect(0,bmm.height-8,bmm.width,bmm.height));
        end;
        with bmc.canvas do begin
            brush.color:=clblack;
            FillRect(rect(0,0,bmc.width,bmc.height));
            brush.color:=clwhite;
            fillrect(rect(1+int_percent(min,max,pos,bmc.width-2),bmm.height-7,bmc.width-1,bmc.height-1));
            brush.color:=clwhite;
            framerect(rect(0,bmc.height-8,bmc.width,bmc.height));
        end;
        tx:=inttostr(int_percent(min,max,pos,100))+'%';
        with bmm.canvas do begin
            font.Size:=8;
            font.style:=[fsbold];
            font.color:=clwhite;
            brush.color:=clwhite;
            tw:=textwidth(tx);
            textout((cwidth-tw) div 2,8,tx);
        end;
        with bmc.canvas do begin
            font.Size:=8;
            font.style:=[fsbold];
            font.color:=clwhite;
            brush.color:=clblack;
            textout((cwidth-tw) div 2,8,tx);
        end;
     
        ii.fIcon:=false;
        ii.hbmColor:=bmc.Handle;
        ii.hbmMask:=bmm.handle;
        ii.xHotspot:=0;
        ii.yHotspot:=0;
        icon:=createiconindirect(ii);
        result:=copyicon(icon);
        destroyicon(icon);
        bmc.free;
        bmm.Free;
    end; 

Пример использования:

    ...
    screen.cursors[1]:=create_prc_cursor(0,100,25);
    screen.cursor:=crnone;
    screen.cursor:=1;
    ... 
