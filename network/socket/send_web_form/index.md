---
Title: Как отправить веб-форму на сервер?
Date: 12.12.1999
author: E.J.Molendijk
---


Как отправить веб-форму на сервер?
==================================

::: {.date}
01.01.2007
:::

Как отправить вебформу на сервер при помощи TClientSocket (напрямую и
через прокси)

    { 
    Copyright (c) 1999 by E.J.Molendijk
     
    Присоедините следующие события к Вашему ClientSocket: 
    procedure T...Form.ClientSocket1Write; 
    procedure T...Form.ClientSocket1Read; 
    procedure T...Form.ClientSocket1Disconnect; 
    procedure T...Form.ClientSocket1Error; 
     
    Так же пример показывает, как направлять передачу через прокси-сервер.
     
     
    Для отправки на вебсервер используется следующий формат:
    Напрямую: 'POST ' + PostAddr + 'HTTP/1.0' + HTTP_Data + Content 
    Через проксю:  'POST http://' Webserver + PostAddr + 'HTTP/1.0' + HTTP_Data + Content 
    } 
     
     
    Const 
      WebServer = 'www.somehost.com'; 
      WebPort   = 80; 
      PostAddr  = '/cgi-bin/form'; 
     
      { Следующие переменные используются только для вебсервера: } 
      ProxyServer ='proxy.somewhere.com'; 
      ProxyPort   = 3128; 
     
      // В заголовке post необходимы некоторые данные
      HTTP_Data = 
        'Content-Type: application/x-www-form-urlencoded'#10+ 
        'User-Agent: Delphi/5.0 ()'#10+    { Отрекламируем Delphi 5! } 
        'Host: somewhere.com'#10+ 
        'Connection: Keep-Alive'#10; 
     
    type 
      T...Form = class(TForm) 
        ... 
      private 
        { Private declarations } 
        HTTP_POST   : String; 
        FContent    : String; 
        FResult     : String; // Эта переменная будет содержать ответ сервера
      public 
        { Public declarations } 
      end; 
     
     
    { Эти функции сделают некоторое url-кодирование } 
    { Например.   'John Smith' => 'John+Smith'  } 
    function HTTPTran(St : String) : String; 
    var i : Integer; 
    begin 
      Result:=''; 
      for i:=1 to length(St) do 
        if St[i] in ['a'..'z','A'..'Z','0','1'..'9'] then 
          Result:=Result+St[i] 
        else if St[i]=' ' then 
          Result:=Result+'+' 
        else 
          Result:=Result+'%'+IntToHex(Byte(St[i]),2); 
    end; 
     
    procedure T...Form.ClientSocket1Write(Sender: TObject; 
      Socket: TCustomWinSocket); 
    begin 
      // Постим данные
      Socket.SendText(HTTP_POST+FContent); 
    end; 
     
    procedure T...Form.ClientSocket1Read(Sender: TObject; 
      Socket: TCustomWinSocket); 
    begin 
      // Получаем результат
      FResult:=FResult+Socket.ReceiveText; 
    end; 
     
    procedure T...Form.ClientSocket1Disconnect(Sender: TObject; 
      Socket: TCustomWinSocket); 
    begin 
      // ЗДЕСЬ МОЖНО ОБРАБОТАТЬ FResult // 
    end; 
     
    procedure T...Form.ClientSocket1Error(Sender: TObject; 
      Socket: TCustomWinSocket; ErrorEvent: TErrorEvent; 
      var ErrorCode: Integer); 
    begin 
      ErrorCode := 0; // Игнорируем ошибки
    end; 
     
     
    { 
    А эта подпрограмма, которую можно использовать для постинга данных формы.
    } 
    procedure T...Form.PostTheForm; 
    begin 
      // Очищаем результаты
      FResult:=''; 
     
      // Вы можете ввести поля формы, которые необходимы
      // Вот некоторые примеры:
      FContent:= 
       'Name='+    HTTPTran('John Smith')            +'&'+ 
       'Address='+ HTTPTran('1 Waystreet')          +'&'+ 
       'Email='+   HTTPTran('jsmith@somewhere.com') +'&'+ 
       'B1=Submit'+ 
       #10; 
     
      // Вычисляем длину содержимого
      FContent:= 
        'Content-Length: '+IntToStr(Length(FContent))+#10+#10+FContent; 
     
      {-- Начало прокси ---} 
      { если Вы используете прокси, то раскоментируйте этот код
      ClientSocket1.Host := ProxyServer; 
      ClientSocket1.Port := ProxyPort; 
      HTTP_POST := 'POST http://'+WebServer+PostAddr+' HTTP/1.0'#10; 
      {--- Конец прокси ---} 
     
      {--- Начало соединения напрямую --- } 
      { удалите этот код, еслы Вы будете использовать прокси }
      ClientSocket1.Host := WebServer; 
      ClientSocket1.Port := WebPort; 
      HTTP_POST := 'POST '+PostAddr+' HTTP/1.0'#10; 
      {--- Конец соединения напрямую ---} 
     
      // Соединяем заголовок
      HTTP_Post := HTTP_Post + HTTP_Data; 
     
      // Пытаемся открыть соединение
      ClientSocket1.Open; 
    end;

Взято из <https://forum.sources.ru>
