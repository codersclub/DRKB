---
Title: Обмен информацией между Вашими программами в сети по почтовым каналам
Date: 01.01.2007
---


Обмен информацией между Вашими программами в сети по почтовым каналам
=====================================================================

::: {.date}
01.01.2007
:::

Обмен информацией между Вашими программами в сети по почтовым каналам.

Как реализовать обмен информацией между Вашими приложениями в сети? ОС
Windows предлагает несколько технологий. Эта статья опишет один очень
простой и надежный способ для Win9x/NT - MailSlots.\
The CreateMailslot function creates a mailslot with the specified name
and returns a handle that a mailslot server can use to perform
operations on the mailslot. The mailslot is local to the computer that
creates it. An error occurs if a mailslot with the specified name
already exists.\
 \

Обмен текстовыми данными в локальной сети очень прост. Для этого
необходимы три функции:

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"}
  --- ---------------------------------------------
  ·   CreateMailslot - создание почтового канала;
  --- ---------------------------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"}
  --- -----------------------------------------------------------
  ·   GetMailslotInfo - определение наличия сообщения в канале;
  --- -----------------------------------------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"}
  --- ------------------------------------------------------
  ·   ReadFile - чтение сообщения из канала, как из файла;
  --- ------------------------------------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"}
  --- ---------------------------------------------------
  ·   WriteFile - запись сообщения в канал, как в файл;
  --- ---------------------------------------------------
:::

Функции работы с почтовыми каналами присутствуют как в Windows 9x, так и
в Windows NT.\
 \

Рассмотрим создание почтового канала (сервер).

      //... создание канала с именем MailSlotName - по этому имени к нему
      //    будут обращаться клиенты
      h := CreateMailSlot(PChar('\\.\mailslot\' + MailSlotName), 0, MAILSLOT_WAIT_FOREVER,nil);
     
      if h = INVALID_HANDLE_VALUE then begin
        raise Exception.Create('MailSlotServer: Ошибка создания канала !');

 \

Отправка сообщений по почтовомуо каналу (клиенты).

      if not GetMailSlotInfo(h,nil,DWORD(MsgNext),@MsgNumber,nil) then 
      begin 
        raise Exception.Create('TglMailSlotServer: Ошибка сбора информации!'); 
      end; 
      if MsgNext <> MAILSLOT_NO_MESSAGE then begin 
        beep; 
        // чтение сообщения из канала и добавление в текст протокола 
        if ReadFile(h,str,200,DWORD(Read),nil) then 
          MessageText := str 
        else 
          raise Exception.Create('TglMailSlotServer: Ошибка чтения сообщения !'); 
      end;

Все очень просто. Теперь для удобства использования создадим два
компонента - клиент и сервер

    { 
     Globus Delphi VCL Extensions Library         
     ' GLOBUS LIB '                         
     Freeware                                 
     Copyright (c) 2000 Chudin A.V, FidoNet: 1246.1 
     =================================================================== 
     gl3DCol Unit 05.2000 components TglMailSlotServer, TglMailSlotClient 
     =================================================================== 
    } 
    unit glMSlots; 
     
    interface 
     
    uses 
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs, extctrls; 
     
    type 
      TOnNewMessage = procedure (Sender: TObject; MessageText: string) of object; 
     
      TglMailSlotServer = class(TComponent) 
      private 
        FMailSlotName, FLastMessage: string; 
        FOnNewMessage: TOnNewMessage; 
     
        Timer: TTimer; //...таймер для прослушивания канала 
        h : THandle; 
        str : string[250]; 
        MsgNumber,MsgNext,Read : DWORD; 
      public 
        constructor Create(AOwner: TComponent); override; 
        destructor Destroy; override; 
        procedure Open;  //...создание канала 
        procedure Close; //...закрытие канала 
      protected 
        procedure Loaded; override; 
        procedure OnTimer(Sender: TObject); 
      published 
        property MailSlotName: string read FMailSlotName write FMailSlotName; 
        //...событие получения сообщения 
        property OnNewMessage: TOnNewMessage read FOnNewMessage write FOnNewMessage;  
      end; 
     
     
      TglMailSlotClient = class(TComponent) 
      private 
        FMailSlotName, FServerName, FLastMessage: string; 
      public 
        constructor Create(AOwner: TComponent); override; 
        destructor Destroy; override; 
        function Send(str: string):boolean; //...отправка сообщения 
      protected 
        procedure Loaded; override; 
        procedure ErrorCatch(Sender : TObject; Exc : Exception); 
      published 
        property ServerName: string read FServerName write FServerName; 
        property MailSlotName: string read FMailSlotName write FMailSlotName; 
      end; 
     
    procedure Register; 
     
    implementation 
     
    procedure Register; 
    begin 
      RegisterComponents('Gl Components', [TglMailSlotServer, TglMailSlotClient]); 
    end; 
     
    constructor TglMailSlotServer.Create(AOwner: TComponent); 
    begin 
      inherited; 
      FEnabled := true;   
      FMailSlotName := 'MailSlot'; 
      Timer := TTimer.Create(nil); 
      Timer.Enabled := false; 
      Timer.OnTimer := OnTimer; 
    end; 
     
    destructor TglMailSlotServer.Destroy; 
    begin 
      Timer.Free; 
      // закрытие канала 
      Close; 
      inherited; 
    end; 
     
    procedure TglMailSlotServer.Loaded; 
    begin 
      inherited; 
      Open; 
    end; 
     
    procedure TglMailSlotServer.Open; 
    begin 
      // создание канала с именем MailSlotName - по этому имени к нему 
      // будут обращаться клиенты 
      h := CreateMailSlot(PChar('\\.\mailslot\' + MailSlotName), 0, MAILSLOT_WAIT_FOREVER,nil); 
      //h:=CreateMailSlot('\\.\mailslot\MailSlot',0,MAILSLOT_WAIT_FOREVER,nil); 
     
      if h = INVALID_HANDLE_VALUE then begin 
        raise Exception.Create('TglMailSlotServer: Ошибка создания канала !'); 
      end; 
      Timer.Enabled := true; 
    end; 
     
    procedure TglMailSlotServer.Close; 
    begin 
      if h <> 0 then CloseHandle(h); 
      h := 0; 
    end; 
     
    procedure TglMailSlotServer.OnTimer(Sender: TObject); 
    var 
      MessageText: string; 
    begin 
     
      MessageText := ''; 
      // определение наличия сообщения в канале 
      if not GetMailSlotInfo(h,nil,DWORD(MsgNext),@MsgNumber,nil) then 
      begin 
        raise Exception.Create('TglMailSlotServer: Ошибка сбора информации!'); 
      end; 
      if MsgNext <> MAILSLOT_NO_MESSAGE then  
      begin 
        beep; 
        // чтение сообщения из канала и добавление в текст протокола 
        if ReadFile(h,str,200,DWORD(Read),nil) then 
          MessageText := str 
        else 
          raise Exception.Create('TglMailSlotServer: Ошибка чтения сообщения !'); 
      end; 
     
      if (MessageText<>'')and Assigned(OnNewMessage) then OnNewMessage(self, MessageText); 
     
      FLastMessage := MessageText; 
    end; 
    //------------------------------------------------------------------------------ 
     
    constructor TglMailSlotClient.Create(AOwner: TComponent); 
    begin 
      inherited; 
      FMailSlotName := 'MailSlot'; 
      FServerName := ''; 
    end; 
     
    destructor TglMailSlotClient.Destroy; 
    begin 
      inherited; 
    end; 
     
    procedure TglMailSlotClient.Loaded; 
    begin 
      inherited; 
      Application.OnException := ErrorCatch; 
    end; 
     
    procedure TglMailSlotClient.ErrorCatch(Sender : TObject; Exc : Exception); 
    var 
      UserName: array[0..99] of char; 
      i: integer; 
    begin 
      // получение имени пользователя 
      i:=SizeOf(UserName); 
      GetUserName(UserName,DWORD(i)); 
     
      Send('/'+UserName+'/'+FormatDateTime('hh:mm',Time)+'/'+Exc.Message); 
      // вывод сообщения об ошибке пользователю 
      Application.ShowException(Exc); 
    end; 
     
    function TglMailSlotClient.Send(str: string):boolean; 
    var 
      strMess: string[250]; 
      UserName: array[0..99] of char; 
      h: THandle; 
      i: integer; 
    begin 
      // открытие канала : MyServer - имя сервера 
      // (\\.\\mailslot\xxx - монитор работает на этом же ПК) 
      // xxx - имя канала 
      if FServerName = '' then FServerName := '.\'; 
      h:=CreateFile( PChar('\\' + FServerName + '\mailslot\' + FMailSlotName), GENERIC_WRITE, 
                     FILE_SHARE_READ,nil,OPEN_EXISTING, 0, 0); 
      if h <> INVALID_HANDLE_VALUE then 
      begin 
        strMess := str; 
        // передача текста ошибки (запись в канал и закрытие канала) 
        WriteFile(h,strMess,Length(strMess)+1,DWORD(i),nil); 
        CloseHandle(h); 
      end; 
      Result := h <> INVALID_HANDLE_VALUE; 
    end; 
     
    end. 

 \
Компонент TglMailSlotServer создает почтовый канал с именем MailSlotName
и принимает входящие ссобщения. Компонент TglMailSlotClient отправляет
сообщения в канал с именем MailSlotName на машине ServerName.\
 \

Эти компонеты входят в состав библиотеки GlobusLib, распространяемой с
исходными текстами. Вы можете скачать ее на тут.

составление статьи: Андрей Чудин, ЦПР ТД Библио-Глобус.

Взято из [http://delphi.chertenok.ru](https://delphi.chertenok.ru)
