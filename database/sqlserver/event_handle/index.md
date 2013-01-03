---
Title: Как получить обновление данных по событию, а не таймером
author: Delirium, VideoDVD@hotmail.com
Date: 01.01.2007
---


Как получить обновление данных по событию, а не таймером
========================================================

::: {.date}
01.01.2007
:::

    { **** UBPFD *********** by kladovka.net.ru ****
    >> Обратная связь от MSSQL-сервера к клиенту
     
    На форуме постоянно возникает вопрос - "Как получить обновление данных, по событию, а не таймером", чтобы снять его раз и навсегда привожу код dll-ки, которая является Extended Stored Procedure с единственной функцией - отправкой UDP-broadcast сообщения.
     
    Зависимости: Windows, SysUtils, IdUDPClient
    Автор:       Delirium, VideoDVD@hotmail.com, ICQ:118395746, Москва
    Copyright:   Delirium (Master BRAIN) 2003
    Дата:        24 октября 2003 г.
    ********************************************** }
     
    library Messager;
     
    uses
      Windows,
      SysUtils,
      IdUDPClient;
     
    function srv_rpcparams(srvproc:Pointer):integer; cdecl; external 'opends60.dll' name 'srv_rpcparams';
    function srv_paramdata(srvproc:Pointer; n:integer):integer; cdecl; external 'opends60.dll' name 'srv_paramdata';
    function srv_paramlen(srvproc:Pointer; n:integer):integer; cdecl; external 'opends60.dll' name 'srv_paramlen';
     
    procedure SendUDPMessage(Params:Pointer); stdcall; cdecl; export;
    var id:TIdUDPClient;
        Msg:String;
        Host,Port:String;
    begin
    try
    if srv_rpcparams(Params)<2 then exit;
    Host:=Copy(PChar(srv_paramdata(Params,1)), 1, srv_paramlen(Params,1));
    Port:=Copy(Host,Pos(':',Host)+1,Length(Host));
    Delete(Host,Pos(':',Host),Length(Host));
    Msg:=Copy(PChar(srv_paramdata(Params,2)), 1, srv_paramlen(Params,2));
    id:=TIdUDPClient.Create(nil);
    id.BroadcastEnabled:=True;
    id.Host:=Host;
    id.Port:=StrToInt(Port);
    id.ReceiveTimeout:=-1;
    id.Send(Msg);
    id.Free;
    except end;
    end;
     
    exports SendUDPMessage;
     
    begin
    end. 

Для регистрации на MSSQL скопировать dll в

c:\\Program Files\\Microsoft SQL Server\\80\\Tools\\Binn

и исполнить скрипт

sp\_addextendedproc \'SendUDPMessage\', \'Messager.dll\'

На клиенте рекомендую использовать компонент TIdUDPServer.

Передача сообщений осуществляется так

    exec SendUDPMessage '255.255.255.255:8080', 'Привет!'

где 255.255.255.255 - broadcast маска, но можно написать и конкретный
адрес (192.168.1.10), 8080 - выбранный для использования порт.
