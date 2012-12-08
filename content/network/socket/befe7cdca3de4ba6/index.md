---
Title: Как запросить страницу с сайта?
Author: Fantasist
Date: 01.01.2007
---


Как запросить страницу с сайта?
===============================

::: {.date}
01.01.2007
:::

Это можно сделать с помощью TClientSocket.

    unit Unit1;
     
    interface
     
    uses Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
      StdCtrls, ScktComp;
     
    const Request: AnsiString = 'GET / HTTP/1.1' + #$D#$A +
      'Accept: application/vnd.ms-excel, application/msword, */*' + #$D#$A +
        'Accept-Language: en-us' + #$D#$A +
        'Accept-Encoding: gzip, deflate' + #$D#$A +
        'User-Agent: Mozilla/4.0 (compatible; MSIE 4.01; Windows 98)' + #$D#$A +
        'Host: vingrad.com' + #$D#$A +
        'Connection: Keep-Alive' + #$D#$A + #$D#$A;
     
    type
      TForm1 = class(TForm)
        Skt: TClientSocket;
        Button1: TButton;
        Memo1: TMemo;
        procedure Button1Click(Sender: TObject);
        procedure SktRead(Sender: TObject; Socket: TCustomWinSocket);
        procedure SktConnect(Sender: TObject; Socket: TCustomWinSocket);
      private
    { Private declarations }
      public
    { Public declarations }
      end;
     
    var Form1: TForm1;
     
    implementation
     
    {$R *.DFM}
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      Skt.Host := 'vingrad.ru';
      Skt.Port := 80;
      Skt.Open;
    end;
     
    procedure TForm1.SktRead(Sender: TObject; Socket: TCustomWinSocket);
    begin
      Memo1.Lines.Text := Memo1.Lines.Text + Socket.ReceiveText;
    end;
     
    procedure TForm1.SktConnect(Sender: TObject; Socket: TCustomWinSocket);
    begin
      Socket.SendText(Request);
    end;
    end.

Request - это запрос который посылает мой IE5.

В принципе, по протоколу HTTP он может ограничиваться:

\'GET / HTTP/1.1\'+\#13+\#13. Если хотите запросить оределенный
документ: \'GET /\<полный путь\> HTTP/1.1\'+\#13+\#13.

Конечно, всегда можно воспользоваться готовыми компонентами.

Автор: Fantasist

------------------------------------------------------------------------

    {
    Присоедините следующий обработчик к Вашему TClientSocket. 
    Он получает файл с сервера и помещает его в строковую переменную FText string variable. Однако он не убирает заголовок, который так же посылается вебсервером.
     
    Не забудьте задать правильный адрес сервера в объекте Socket. Установите порт 80. А затем откройте его при помощи команды "Socket.Open;".
     
    Автор: E.J.Molendijk
    } 
     
     
    Const 
      WebPage = '/index.html'; 
    Var 
      FText   : String; 
     
    procedure TForm1.SocketWrite(Sender: TObject; 
      Socket: TCustomWinSocket); 
    begin 
      Socket.SendText('GET '+Webpage+' HTTP/1.0'#10#10); 
    end; 
     
    procedure TForm1.SocketRead(Sender: TObject; 
      Socket: TCustomWinSocket); 
    begin 
      FText := FText +  Socket.ReceiveText 
    end; 
     
    procedure TForm1.SocketConnecting(Sender: TObject; 
      Socket: TCustomWinSocket); 
    begin 
      FText := ''; 
    end; 
     
    procedure TForm1.SocketDisconnect(Sender: TObject; 
      Socket: TCustomWinSocket); 
    begin 
    { --- } 
    { ЗДЕСЬ ВЫ МОЖЕТЕ ОБРАБАТЫВАТЬ ВАШ FText !!! } 
    { --- } 
    end; 
     
    procedure TForm1.SocketError(Sender: TObject; 
      Socket: TCustomWinSocket; ErrorEvent: TErrorEvent; 
      var ErrorCode: Integer); 
    begin 
      ErrorCode:=0; { Ошибки игнорируем }
    end;

Взято из <https://forum.sources.ru>
