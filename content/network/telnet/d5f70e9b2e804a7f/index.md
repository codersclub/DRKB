---
Title: Управление приложением через Telnet
Date: 01.01.2007
---


Управление приложением через Telnet
===================================

::: {.date}
01.01.2007
:::

Итак, начнем с главного - почему для удаленного администрирования своей
программы следует использовать именно Telnet? Ответ на этот вопрос
достаточно прост:

Утилита Telnet есть на любом компьютере с операционной системой Windows,
UNIX, AIX и т.п., поэтому ее не требуется писать или устанавливать

Telnet является штатным средством удаленного администрирования.

Telnet подразумевает текстовый обмен, поэтому его очень легко
поддерживать в своей программе

Возможностей текстового терминала как правило достаточно для управления
программой, ее настройки и администрирования

Рассмотрим немного теории. Утилиту Telnet легче всего запустить через
Start-\>Run (Пуск -\> Выполнить). После запуска необходимо произвести
соединение с удаленным хостом, для чего выполняется используется меню
\"Connect-\>Remote System\". При этом выводится меню соединения, в
котором необходимо указать три параметра: хост, порт и тип терминала. В
качестве хоста указывается имя удаленного компьютера (или его IP адрес),
порт можно задать двумя путями - выбором/вводом символического имени
(например, telnet), или вводом номера порта. Мы будем пользоваться
вторым путем, т.е. будем использовать нестандартные номера портов. Тип
терминала оставим vt100.

Утилита Telnet поддерживает параметры командой строки:

telnet \[remote\_host\] \[port\]

где

remote\_host представляет собой имя или IP адрес удаленной машины.

port номер порта. Если соединение идет по стандартному порту, то этот
параметр опускается.

Пример:

telnet zaitsevov или telnet zaitsevov 5000

Протокол Telnet очень прост - сначала устанавливается TCP/IP соединение
с удаленной машиной. Затем, когда пользователь вводит символ, происходит
его передача удаленному хосту. Для простоты будем называть его сервером.

Далее возможно два режима работы - с локальным эхом или без локального
эха (режим по умолчанию). Если работа ведется с локальным эхом, то
каждый вводимый пользователем символ немедленно отображается на экране.
При работе без локального эха сервер обязан создавать эхо, дублирую
принимаемые данные клиенту. Это позволят тестировать канал (каждый
символ проходит по кругу) и организовывать ввод данных без эха
(например, для ввода пароля). Мои примеры ориентированы на работу без
локального эха.

При приеме любой информации от сервера утилита Telnet немедленно
отображает его на экране. Это позволяет серверу организовывать эхо и
выводить любую информацию в текстовом виде. При этом поддерживатся
некоторые управляющие коды, например, код \"забой\", стирающий один
символ.

Итак, приступим к разработке приложения. Создадим пустой проект и
поместим на форму компонент ServerSocket1 типа TServerSocket. Зададим
ему порт, например 5000. Напоминаю, что:

номер порта должен быть нестандартным, чтобы не пересекаться с другими
программами. При этом желательно считывать его из INI файла, что даст
возможность настройки при необходимости.

Свойство Active должно быть false и устанавливаться в true при запуске
программы. Иначе приложение свалится при попытке запуска второй копии
или при отсутствии сети. Установку Active := true следует делать в блоке
try \... except

Итак, в обработчике OnCreate формы пишем:

    begin
      try
        ServerSocket1.Active := true;
      except
        ShowMessage('Ошибки при активации ServerSocket');
      end;
    end;

Далее необходимо научиться определять моменты соединения и отключения
клиента. Для этого следует создать обработчики OnClientConnect и
OnClientDisconnect. Сразу отмечу, что при подключении клиента обычно
принято выдывать ему заголовок, ообщающий о том, что он соединился с
программой \*\*\* версии NN. С учетом этого обработчик OnClientConnect
будет иметь вид:

    procedure TMain.ServerSocket1ClientConnect(Sender: TObject; Socket: TCustomWinSocket);
    begin
      Socket.SendText('Connected. Программа Telnet1 Example на проводе.'+#$0D+#$0A);
      Socket.SendText('Enter password : ');
      Connected := false;
      Memo1.Lines.Add('Произошло соединение с пользователем');
    end;

При этом я хочу подчеркнуть особенность - нормально поддерживается одно
соединение, для нескольких необходимы некоторые усложнения и мых их пока
опустим.

Особенности:

Выводить информацию при соединении желательно на английском языке. Это
позволяет избежать ситуации, когда на компьтере администратора не
окажется поддержки русского языка и Telnet выведет ему абракадабру. У
меня это наблюдается постоянно на английской NT 4 - приходится каждый
раз лазить в настройки Telnet и задавать русский CharSet.

При соединении следует спросить пароль. Иначе каждый, кому нечего
делать, залезет в программу и будет там ковыряться (из практики -
преценденты были).

Переменная Connected отмечает, что пользователь еще не соединился с
программой (т.е. не провел свою идентификацию). Рассмотрим сразу
обработчик OnClientDisconnect, он еще проще:

    // Поддержка связи по TCP/IP для удаленного конфигурирования - действия при отключении
    procedure TMain.ServerSocket1ClientDisconnect(Sender: TObject; Socket: TCustomWinSocket);
    begin
      Connected := false;
      Memo1.Lines.Add('Соединение разорвано');
    end;

Итак, теперь настало время для самого интересного - написания
обработчика OnClientRead. Этот обработчик вызывается всякий раз, когда
от клиента приходят данные. Т.е. в свете приведенных выше теоретических
замечаний это будет происходить при вводе каждого отдельного символа.
Задачи обработчика:

Создавать (при необходимости) эхо для всех принимаемых символов.
Очевидно, что при вводе паролей эхо создавать не нужно. При созании эха
необходимо учитывать, что символ с кодом FF (буква \"я\") должен
повторяться дважды, иначе он будет погложен Telnet - ом как служебный и
не отобразится

Накапливать вводимые символы, ожидая прихода признака конца команы. Как
правило, признаком конца команды считают перевод код строки (следует
заметить, что тут разработчик сам себе стандарт, но отклоняться от
общепринятых правил не рекомендуется. Для накопления принимаемой
информации стоит завести буферную переменную, в моем случае она будет
называться TelnetS.

При получении символа с кодом 08h (\"BackSpace\") необходимо не помещать
ее в буфер, а стереть из буфера последний символ. Но в виде эха его
отправить необходимо, т.к. это приведет к стиранию символа на экране
Telnet (при подавлении эха он останется на экране, но сотрется в буфере
программы, что приведет к путанице).

При обнаружении символа перевода строки (код \$0D) следует считать
содержимое буфера командой и интерпретировать. Как - это отдельный
разговор

Все вышеописанное реализует примерно следующий код:

     
    // Поддержка связи по TCP/IP для удаленного конфигурирования - действия при получении данных
    procedure TForm1.ServerSocket1ClientRead(Sender: TObject; Socket: TCustomWinSocket);
    var
      s, st: string;
    begin
      s := Socket.ReceiveText;
     
      // Это код перевода строки ? Если да, то выполняем команду и передаем ее ответ клиенту
      if ord(s[1]) = $0D then
      begin
        st := ExecuteCMD(TelnetS);
        if st <> '' then
          st := #$0D + #$0A + st;
        st := st + #$0D + #$0A + '>';
        TelnetSendText(Socket, st);
        TelnetS := '';
        exit;
      end;
     
      // Это код клавиши BackSpace. Если да, то передадим его клиенту
      // и удалим последний символ из буфера
      if ord(s[1]) = $08 then
      begin
        Delete(TelnetS, length(TelnetS), 1);
        TelnetSendText(Socket, s);
        exit;
      end;
     
      // Добавим очередной символ к буферу
      TelnetS := TelnetS + s;
     
      // Передадим его клиенту для организации эха
      if connected then
        TelnetSendText(Socket, s);
    end;

Как легко заметить, приведенный выше код реализует эхо, обрабатывает
BackSpace и дожидается ввода команды, считая код \$OD (Enter) признаком
завершения ввода команды. При обнаружении этого кода вызывается функция
пользователя ExecuteCMD, которая должна разобрать и проанализировать
команду, выполнить ее и вернуть (при необходомости) ответ пользователю.
Эта же функция занимается проверкой вводимого пользователем пароля. Так
ка передача ответа/эха имеет некоторые особенности, например,
необходимость удвоения символа с кодом FF и подавления передачи для
реализации невидимого ввода, имеет смысл выполнить ее в виде отдельной
функции:

    // Передача ответа/эха клиенту
    function TForm1.TelnetSendText(Socket: TCustomWinSocket; AText: string): boolean;
    var
      i: integer;
      St: string;
    begin
      Result := false;
      if not(connected) then
        exit;
      St := '';
      for i := 1 to length(AText) do
        if AText[i] <> #$FF then
          st := st + AText[i]
        else
          st := st + #$FF + #$FF;
      Socket.SendText(st);
    end;
     
    // В моем примере функция ExecuteCMD имеет вид:
    // Интерретатор команд
    function TForm1.ExecuteCMD(ACmd: string): string;
    var
      UCmd, Params: string;
    begin
      Result := '';
      Memo1.Lines.Add('Выполняется: '+ACmd);
      if not(connected) then
      begin
        if UpperCase(ACmd) = '123' then
        begin
          Connected := true;
          Result := 'Пользователь идентифицирован!';
        end;
        exit;
      end;
     
      // Выделение команды
      UCmd := ACmd;
      Params := '';
      if pos(' ', UCmd) > 0 then
      begin
        Params := Copy(UCmd, pos(' ', UCmd)+1, Length(UCmd));
        UCmd := Copy(UCmd, 1, pos(' ', UCmd)-1);
      end;
      UCmd := Trim(UpperCase(UCMD));
      Memo1.Lines.Add('Выделена команда: '+UCmd);
     
      // ? или HLP или HELP - вывод справки
      if (UCmd = '?') or (UCmd = 'HLP') or (UCmd = 'HELP') then
      begin
        Result :=
        'Краткая справка по командам Telnet интерфейса'+CRLF+
        ' ?, HLP, HELP - вызов справки'+CRLF+
        ' EXIT - завершение работы по Telnen интерфейсу'+CRLF+
        ' HALT - немедленный останов программы'+CRLF+
        ' VER - версия программы'+CRLF+
        ' MESS <собщение> - вывод сообщения для пользователя'+CRLF+
        ' INP <собщение> - вывод сообщения для пользователя и возврат его ответа';
        exit;
      end;
     
      if (UCmd = 'EXIT') then
      begin
        ServerSocket1.Socket.Connections[0].Close;
        exit;
      end;
     
      if (UCmd = 'VER') then
      begin
        Result := 'Версия 1.00 от 27.01.2001 (C) Зайцев Олег';
        exit;
      end;
     
      if (UCmd = 'HALT') then
        halt;
     
      if (UCmd = 'MESS') then
      begin
        ShowMessage(Params);
        exit;
      end;
     
      if (UCmd = 'INP') then
      begin
        Result := InputBox(Params,'Введите ответ', '');
        exit;
      end;
     
      Result := 'Неизвестная команда ' + ACmd;
    end;

Реальная система команд естественно определяется разработчиком, но
рекомендуется предусмотреть следующие команды:

?, HLP, HELP для вывода справочной информации (практика показала, что
при поддерке 20-30 команд больше половины забываются за месяц)

EXIT - завершение обмена

И, наконец, в завершении следует отметить одну особенность -
пользователь может завершить обмен корректно (путем ввода команды EXIT
(если таковая поддерживается) или выбором опции \"Отключить\" в Telnet;
и некорректно - путем закрытия Telnet во время обмена. В этом случае в
программе будет ошибка сокета 10054. Ее имеет смысл поймать и подавить
при помощи обработчика OnClientError следующего вида:

    procedure TForm1.ServerSocket1ClientError(Sender: TObject; Socket: TCustomWinSocket;
      ErrorEvent: TErrorEvent; var ErrorCode: Integer);
    begin
      // Обработка события "разрыв соединения"
      if ErrorCode = 10054 then
      begin
        Socket.Close;
        ErrorCode := 0;
      end;
    end;

И в завершении хочется сказать, что подобная система внедрена в
несколько моих программ, испрользуемых в ОАО Смоленскэнерго и отлично
себя зарекомендовала, т.к. предприятие большое и возможность удаленной
настройки/управления в ряде случаев освобождает разработчика от ненужной
беготни.

Взято с <https://delphiworld.narod.ru>