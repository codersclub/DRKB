<h1>CrtSock &ndash; модуль для работы с сокетами в Delphi32</h1>
<div class="date">01.01.2007</div>


<div class="author">Автор: Paul Toth</div>
<p>WEB-сайт: www.multimania.com/tothpaul</p>
<p>CrtSock. Модуль для работы с сокетами.</p>
<p>Совместимость: Delphi 2+</p>
<p>Поддерживает TCP и UDP пакеты.</p>
<p>Не использует winsock.pas, поскольку обращается непосредственно к wsock32.dll.</p>
<p>Набор функций позволяет разрабатывать как клиентские, так и серверные приложения.</p>
<p>Перечень включенных в модуль функций:</p>
<pre>
// Server side :
//  - start a server
//  - wait for a client
function StartServer(Port:word):integer;
function WaitClient(Server:integer):integer;
function WaitClientEx(Server:integer; var ip:string):integer;
 
// Client side :
//  - call a server
function CallServer(Server:string;Port:word):integer;
 
// Both side :
//  - Assign CRT Sockets
//  - Disconnect server
procedure AssignCrtSock(Socket:integer;
                        Var Input,Output:TextFile);
procedure Disconnect(Socket:integer);
 
// BroadCasting (UDP)
function StartBroadCast(Port:word):integer;
function SendBroadCast(Server:integer;
                       Port:word; s:string):integer;
function SendBroadCastTo(Server:integer;
                         Port:word;
                         ip,s:string):integer;
function ReadBroadCast(Server:integer; Port:word):string;
function ReadBroadCastEx(Server:integer;
                         Port:word;
                         var ip:string):string;
 
// BlockRead
function SockAvail(Socket:integer):integer;
function DataAvail(Var F:TextFile):integer;
Function BlockReadsock(Var F:TextFile;
                       var s:string):boolean;
 
Function send(socket:integer;
              data:pointer;
              datalen,
              flags:integer):integer; stdcall; far;
Function recv(socket:integer;
              data:pchar;
              datalen,
              flags:integer):integer; stdcall; far;
</pre>


<p>Дополнительно в комплект входят модули для работы с FTP, HTTP, SMTP, POP3.</p>
<p>В качестве примера приведена демонстрационная программа, использующая все эти возможности.</p>

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
<h1>CrtSock - модуль для работы с сокетами в Delphi32</h1>

