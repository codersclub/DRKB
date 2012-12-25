---
Title: Как расшарить диск?
Author: Repairman
Date: 01.01.2007
---


Как расшарить диск?
===================

::: {.date}
01.01.2007
:::

Автор: Repairman

Это модуль для Share любого диска или папки как на локальном, так и на
удаленном компьютере (если, конечно у Вас права администратора и на
компе разрешено удаленное администрирование, для локальной машины это не
обязательно\... ;-))

Следует отметить, что под NT некоторые процедуры находятся в других
DLL\...

Функция SetShareOnDisk - ставит шару, RemoveShareFromDisk - снимает ее.

    unit Share;
    //(c)2002 <Repairman> repairman@uzel.ru
    interface
    type
      TPassw = string[8];
      TNetName = string[12];
     
    function SetShareOnDisk(HostName: string; //имя компьютера
      LocalPath: string; //папка которую надо открыть для доступа
      NetName: TNetName; //имя расшаренной папки в сети
      Remark: string; //комментарий, видимый в сети
      Access: word; //доступ
      RO_Passw: TPassw; //пароль на чтение
      RW_Passw: TPassw //пароль на полный доступ
      ): boolean;
     
    function RemoveShareFromDisk(HostName: string; //имя компьютера
      NetName: string; //сетевое имя папки которую надо закрыть
      LocalPath: string //локальный путь папки
      ): boolean;
    var
      ShareResult: word;
    //-------------------------------------------------------------------------------------------
    implementation
    uses SysUtils, Windows, ShlObj;
     
    function NetShareAdd(ServerName: PChar; //указатель на имя компьютера, например '\\Server'#0, если свой, то можно nil
      Level: Word; //уровень структуры Share_info, здесь 50
      PShareInfo: PChar; //указатель на структуру Share_Info
      ParmErr: DWord) //указатель на ???
      : dword; stdcall; external 'svrapi.dll'; //svrapi для Win9X, NetApi32 для NT
     
    function NetShareDel(ServerName: PChar;
      NetName: PChar;
      Reserved: DWord): dword; stdcall; external 'svrapi.dll';
     
    type
      _share_info_50 = record //структура Share уровня 50
        NetName: array[1..13] of char; //Как будет называться диск в сети
        SType: byte; //тип =0 (STYPE_DISKTREE) - шарить диски
        Flags: word; //флаги $0191,$0192,$0193....(доступ из сети)
        Remark: PChar; //указатель на комментарий, видимый из сети
        Path: PChar; //указатель на имя ресурса, например 'c:\'#0
        RW_Password: array[1..9] of char; //пароль для полного доступа, если не нужен =#0
        RO_Password: array[1..9] of char; //пароль для доступа на чтение, если не нужен =#0
      end;
    //----------------------------
     
    function SetShareOnDisk(HostName, LocalPath: string; NetName: TNetName; Remark: string;
      Access: word; RO_Passw, RW_Passw: TPassw): boolean;
    var ShareInfo: _Share_Info_50;
    begin
      Result := false;
      StrPCopy(@ShareInfo.NetName, NetName);
      ShareInfo.SType := 0;
      ShareInfo.Flags := Access;
      ShareInfo.Remark := PChar(Remark);
      ShareInfo.Path := PChar(LocalPath);
      StrPCopy(@ShareInfo.RO_Password, RO_Passw);
      StrPCopy(@ShareInfo.RW_Password, RW_Passw);
      ShareResult := NetShareAdd(PChar(HostName), 50, @ShareInfo, $0000002A); //вызываем Share
      if ShareResult <> 0 then Exit; //расшарить неудалось
      SHChangeNotify(SHCNE_NETSHARE, SHCNF_PATH, PChar(LocalPath), nil); //сказать шеллу об изменениях
      Result := true;
    end;
    //----------------------------
     
    function RemoveShareFromDisk(HostName, NetName, LocalPath: string): boolean;
    begin
      Result := false;
      ShareResult := NetShareDel(PChar(HostName), PChar(NetName), 0); //удалить шару
      if ShareResult <> 0 then Exit;
      SHChangeNotify(SHCNE_NETUNSHARE, SHCNF_PATH, PChar(LocalPath), nil); //сказать шеллу об изменениях
      Result := true;
    end;
    //----------------------------
    end.

Взято из <https://forum.sources.ru>
