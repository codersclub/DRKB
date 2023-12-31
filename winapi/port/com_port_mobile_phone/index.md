---
Title: Работа с сотовыми телефонами
Date: 01.01.2007
---


Работа с сотовыми телефонами
============================

::: {.date}
01.01.2007
:::

Взаимодействие с мобильными телефонами

Вы, наверное, не раз видели или даже пользовались программами, которые
отображают любую информацию о вашем телефоне. Сейчас вы узнаете, как
самим сделать такую программу!

Для начала положим на форму Memo, CheckBox "Соединиться",
кнопку «Послать команду», Edit.

А) Подключение

Итак, в «Public declarations» объявляем 2 функции и 2 процедуры,
потом объявляем 4 глобальные переменные:

    …
    public
    { Public declarations }
     
    function OpenCOMPort: Boolean;
      function SetupCOMPort: Boolean; //для настройки порта
        procedure Connect;
          procedure Disconnect;
            …
            var
            Form1: TForm1;
            ComFile: THandle; //Хэндл создаваемого нами файла
            ComString: string; //(COM1, COM2 или COM3)
            ComSpeed: Integer; //Скорость взаимодействия с COM-портом
            Status: Boolean; //подключен или не подключен (чтобы в дальнейшем проверять статус)

Жмём Ctrl+C и записываем дальше:

    procedure TForm1.Connect;
    begin
      ComString := 'COM2';
      ComSpeed := 19200;
      if OpenCOMPort = true then //Открываем порт…
        if SetupCOMPort = true then //…и конфигурируем его
          Memo1.Lines.Add('Подключились...');
      Sleep(1500); //засыпаем на полторы секунды чтобы дать время на соединение
    end;
     
    procedure TForm1.Disconnect;
    begin
      CloseHandle(ComFile);
      Memo1.Lines.Add('Отключились.');
    end;
     
    function TForm.OpenCOMPort: Boolean;
    var DeviceName: array[0..80] of Char;
      Device: string;
    begin
      Device := ComString;
      StrPCopy(DeviceName, Device);
      ComFile := CreateFile(DeviceName,
        GENERIC_READ or GENERIC_WRITE,
        0,
        nil,
        OPEN_EXISTING,
        FILE_ATTRIBUTE_NORMAL,
        0);
      if ComFile = INVALID_HANDLE_VALUE then
        begin
          Result := False;
          Status := Result;
        end
      else
        begin
          Result := True;
          Status := Result;
        end;
     
    end;
     
    function TForm1.SetupCOMPort: Boolean;
    const RxBufferSize = 256;
      TxBufferSize = 256;
    var DCB: TDCB;
      Config: string;
      CommTimeouts: TCommTimeouts;
    begin
      Result := True;
      if not SetupComm(ComFile, RxBufferSize, TxBufferSize) then
        Result := False;
      if not GetCommState(ComFile, DCB) then
        Result := False;
     
      Config := 'baud=' + IntToStr(ComSpeed) + ' parity=n data=8 stop=1'; //Устанавливаем скорость
      if not BuildCommDCB(@Config[1], DCB) then
        Result := False;
      if not SetCommState(ComFile, DCB) then
        Result := False;
     
      with CommTimeouts do
        begin
          ReadIntervalTimeout := 0;
          ReadTotalTimeoutMultiplier := 0;
          ReadTotalTimeoutConstant := 1000;
          WriteTotalTimeoutMultiplier := 0;
          WriteTotalTimeoutConstant := 1000;
        end;
      if not SetCommTimeouts(ComFile, CommTimeouts) then
        Result := False;
    end;

Теперь два раза щёлкаем по CheckBox и записываем код:

    procedure TForm1.CheckBox1Click(Sender: TObject);
    begin
      if CheckBox1.Checked then
        Connect
      else
        Disconnect;
    end;

В событии формы OnDestroy записываем:

    procedure TForm1.FormDestroy(Sender: TObject);
    begin
      if Status = true then //При выходе из программы отключаемся
        Disconnect;
    end;

Б) Шлём команды и принимаем ответы

Щёлкаем два раза по кнопке «Послать команду» и записываем код:

    procedure TForm1.Button1Click(Sender: TObject);
    var BytesWritten: DWORD;
      s: string;
      d: array[1..1500] of Char;
      BytesRead: DWORD;
      i: Integer;
      Result: string;
    begin
      s := Edit1.Text; //Берём команды из Edit1…
      s := s + #13 + #10;
      WriteFile(ComFile, s[1], Length(s), BytesWritten, nil); //…и посылаем их телефону
      Result := '';
      if not ReadFile(ComFile, d, SizeOf(d), BytesRead, nil) then
        begin
          MessageDlg('Ошибка чтения!', mtError, [mbOK], 0);
            exit;
        end;
     
      s := '';
      for i := 1 to BytesRead do //Считываем ответ от телефона
        s := s + d[I];
      Result := s;
      Memo1.Lines.Add(Result); //Выводим ответ от телефона в Memo
    end;

Вот и всё! Теперь подключите телефон, запускайте программу, ставьте
галку в CheckBox\'е, и, после того, как вам написали в Memo, что вы
подключились вводите в Edit любую AT-команду и жмите «Послать команду».
Удачи!

В) Некоторые полезные команды AT

Этими командами вы можете воспользоваться, для посылки телефону (из поля
Edit):

AT+CGMI - производитель

AT+CGMM - модель телефона

AT+CPAS - состояние

AT+COPS? - оператор

AT+CGSN - номер IMEI

AT+CGMR - версия прошивки

AT+CBC - степень зарядки телефона

AT+CREG? - статус сети

AT\^SCID - номер SIM-карты

AT+CIMI - номер IMSI

AT\^SPIC - попыток до блокировки SIM-карты

Более подробно о командах вы сможете узнать из pdf-инструкции
s35i\_c35i\_m35i\_atc\_commandset\_v01.pdf (можно утащить по адресу:
http://www.like.e-technik.uni-erlangen.de/...andset\_v01.pdf)

Автор: Лазуткин Алексей (alessio19\@mail.ru),  
помощь в написании: av3nger (av3nger\@hakep.com)
