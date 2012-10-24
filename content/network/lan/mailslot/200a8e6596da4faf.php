<h1>Обмен информацией между Вашими программами в сети по почтовым каналам</h1>
<div class="date">01.01.2007</div>


<p>Обмен информацией между Вашими программами в сети по почтовым каналам.</p>
<p>Как реализовать обмен информацией между Вашими приложениями в сети? ОС Windows предлагает несколько технологий. Эта статья опишет один очень простой и надежный способ для Win9x/NT - MailSlots. <br>
The CreateMailslot function creates a mailslot with the specified name and returns a handle that a mailslot server can use to perform operations on the mailslot. The mailslot is local to the computer that creates it. An error occurs if a mailslot with the specified name already exists. <br>
&nbsp;<br>
<p>Обмен текстовыми данными в локальной сети очень прост. Для этого необходимы три функции:</p>
<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>CreateMailslot - создание почтового канала;</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>GetMailslotInfo - определение наличия сообщения в канале;</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>ReadFile - чтение сообщения из канала, как из файла;</td></tr></table></div><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>WriteFile - запись сообщения в канал, как в файл;</td></tr></table></div><p>Функции работы с почтовыми каналами присутствуют как в Windows 9x, так и в Windows NT.<br>
&nbsp;<br>
<p>Рассмотрим создание почтового канала (сервер).</p>
<pre>
  //... создание канала с именем MailSlotName - по этому имени к нему
  //    будут обращаться клиенты
  h := CreateMailSlot(PChar('\\.\mailslot\' + MailSlotName), 0, MAILSLOT_WAIT_FOREVER,nil);
 
  if h = INVALID_HANDLE_VALUE then begin
    raise Exception.Create('MailSlotServer: Ошибка создания канала !');
</pre>
<p>&nbsp;<br>
<p>Отправка сообщений по почтовомуо каналу (клиенты).</p>
<pre>
  if not GetMailSlotInfo(h,nil,DWORD(MsgNext),@MsgNumber,nil) then 
  begin 
    raise Exception.Create('TglMailSlotServer: Ошибка сбора информации!'); 
  end; 
  if MsgNext &lt;&gt; MAILSLOT_NO_MESSAGE then begin 
    beep; 
    // чтение сообщения из канала и добавление в текст протокола 
    if ReadFile(h,str,200,DWORD(Read),nil) then 
      MessageText := str 
    else 
      raise Exception.Create('TglMailSlotServer: Ошибка чтения сообщения !'); 
  end;
</pre>

<p>Все очень просто. Теперь для удобства использования создадим два компонента - клиент и сервер</p>
<pre>
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
  if h &lt;&gt; 0 then CloseHandle(h); 
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
  if MsgNext &lt;&gt; MAILSLOT_NO_MESSAGE then  
  begin 
    beep; 
    // чтение сообщения из канала и добавление в текст протокола 
    if ReadFile(h,str,200,DWORD(Read),nil) then 
      MessageText := str 
    else 
      raise Exception.Create('TglMailSlotServer: Ошибка чтения сообщения !'); 
  end; 
 
  if (MessageText&lt;&gt;'')and Assigned(OnNewMessage) then OnNewMessage(self, MessageText); 
 
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
  if h &lt;&gt; INVALID_HANDLE_VALUE then 
  begin 
    strMess := str; 
    // передача текста ошибки (запись в канал и закрытие канала) 
    WriteFile(h,strMess,Length(strMess)+1,DWORD(i),nil); 
    CloseHandle(h); 
  end; 
  Result := h &lt;&gt; INVALID_HANDLE_VALUE; 
end; 
 
end. 
</pre>
<p>&nbsp;<br>
Компонент TglMailSlotServer создает почтовый канал с именем MailSlotName и принимает входящие ссобщения. Компонент TglMailSlotClient отправляет сообщения в канал с именем MailSlotName на машине ServerName. <br>
&nbsp;<br>
<p>Эти компонеты входят в состав библиотеки GlobusLib, распространяемой с исходными текстами. Вы можете скачать ее на тут.</p>
составление статьи: Андрей Чудин, ЦПР ТД Библио-Глобус.</p>
<p>Взято из<a href="https://delphi.chertenok.ru" target="_blank"> http://delphi.chertenok.ru</a></p>
