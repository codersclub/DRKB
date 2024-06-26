---
Title: Подключиться к интернету, определить активные соединения, определить и сохранить параметры соединения
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Подключиться к интернету, определить активные соединения, определить и сохранить параметры соединения
=====================================================================================================

Как из Вашей программы подключиться к Интернету, определить активные
соединения, определить и сохранить параметры соединения?
Все эти функции
находятся в rasapi32.dll. Описания этих функций для Delphi есть в модуле
res.pas. Его можно скачать на сайте program.dax.ru (14 Кбайт).

Эта программа заполняет ListBox1 всеми соединениями, ListView1 - всеми
активными соединениями. При двойном щелчке по соединению в Edit1 и Edi2
кладутся имя пользователя и пароль (если он сохранен). Кнопка "Dial
Up" устанавливает соединение, "Save" сохраняет имя пользователя и
пароль. "Hang Up" разрывает соединение. "Update Entries" и "Udate
Conns" обновляют информацию о соединениях. В том случае, если связь
разорвалась сама, для установления соединения необходимо сначала нажать
"Hang Up".

Скачать необходимые для компиляции файлы проекта можно на
program.dax.ru. Дустапны проекты для Delphi3 и для Delphi5.

    uses Ras;
     
    var
      CurrentState: string = '';
     
    { Эта функция возвращает строку с
      рассшифровкой значений state и error: }
    function StateStr(state: TRasConnState; error: longint): string;
    var buf: array [0..511] of char; { В рelp-е написано,
                                       что 512 байт хватит всегда }
    begin
      if error <> 0 then begin
        case RasGetErrorString(error, @buf, sizeof(buf)) of
          0: result := buf;
          ERROR_INVALID_PARAMETER: result := 'Invalid parameter';
          else result := 'Error code: ' + IntToStr(error);
        end;
      end else case state of
        RASCS_OpenPort: result := 'Opening port';
        RASCS_PortOpened: result := 'Port opened';
        RASCS_ConnectDevice: result := 'Connecting device';
        RASCS_DeviceConnected: result := 'Device connected';
        RASCS_AllDevicesConnected: result := 'All devices connected';
        RASCS_Authenticate: result := 'Start authenticating';
        RASCS_AuthNotify: result := 'Authentication: notify';
        RASCS_AuthRetry: result := 'Authentication: retry';
        RASCS_AuthCallback: result := 'Authentication: callback';
        RASCS_AuthChangePassword: result := 'Authentication: change password';
        RASCS_AuthProject: result := 'Authentication: projecting';
        RASCS_AuthLinkSpeed: result := 'Authentication: link speed';
        RASCS_AuthAck: result := 'Authentication: acknowledge';
        RASCS_ReAuthenticate: result := 'Authentication: reauthenticate';
        RASCS_Authenticated: result := 'Authenticated';
        RASCS_PrepareForCallback: result := 'Preparing for callback';
        RASCS_WaitForModemReset: result := 'Waiting for modem reset';
        RASCS_WaitForCallback: result := 'Waiting for callback';
        RASCS_Projected: result := 'Projected';
        RASCS_StartAuthentication: result := 'Start authentication';
        RASCS_CallbackComplete: result := 'Callback complete';
        RASCS_LogonNetwork: result := 'Logging on network';
     
        RASCS_Interactive: result := 'Interactive';
        RASCS_RetryAuthentication: result := 'Retry Authentication';
        RASCS_CallbackSetByCaller: result := 'Callback set by caller';
        RASCS_PasswordExpired: result := 'Password expired';
     
        RASCS_Connected: result := 'Connected';
        RASCS_Disconnected: result := 'Disconnected';
        else result := 'Unknown state';
      end;
    end;
     
    // Заполнение s всеми соединениями:
    procedure FillEntries(s: TStrings);
    var
      EntryCount, bufsize: longint;
      entries: LPRasEntryName;
      i: integer;
    begin
      s.Clear;
      s.BeginUpdate;
      bufsize := 0;
      // Определение количества соединений:
      RasEnumEntries(nil, nil, nil, bufsize, EntryCount);
      if EntryCount > 0 then begin
        // Выделение памяти под информацию о соединениях:
        GetMem(entries, bufsize);
        FillChar(entries^, bufsize, 0);
        entries^.dwSize := sizeof(TRasEntryName);
        // Получение информации о соединениях:
        RasEnumEntries(nil, nil, entries, bufsize, EntryCount);
        // Заполнение s названиями соединений:
        for i := 0 to EntryCount - 1 do begin
          s.Add(entries^.szEntryName);
          inc(entries);
        end;
        // Освобождение памяти:
        dec(entries, EntryCount);
        FreeMem(entries);
      end;
      s.EndUpdate;
    end;
     
     
     
    // Заполнение items всеми активными соединениями:
    procedure FillConnections(items: TListItems);
    var
      conns: LPRasConn;
      ConnCount, bufsize: longint;
      li: TListItem;
      i: integer;
      status: TRASCONNSTATUS;
    begin
      items.BeginUpdate;
      items.Clear;
      bufsize := 0;
      // Определение количества активных соединений:
      RasEnumConnections(nil, bufsize, ConnCount);
      if ConnCount > 0 then begin
        // Выделение памяти:
        GetMem(conns, bufsize);
        conns^.dwSize := sizeof(TRasConn);
        // Заполнение conns информацией об активных соединениях:
        RasEnumConnections(conns, bufsize, ConnCount);
        status.dwSize := sizeof(TRasConnStatus);
        // Заполнение items названиями соединений:
        for i := 0 to ConnCount - 1 do begin
          li := items.Add;
          li.Data := pointer(conns^.hrasconn);
          li.Caption := conns^.szEntryName;
          li.SubItems.Add(conns^.szDeviceType);
          li.SubItems.Add(conns^.szDeviceName);
          RasGetConnectStatus(conns^.hrasconn, status);
          li.SubItems.Add(StateStr(status.rasconnstate, status.dwError));
          inc(conns);
        end;
        // Освобождение памяти:
        dec(conns, ConnCount);
        FreeMem(conns);
      end;
      items.EndUpdate;
    end;
     
    { Процедура разрывает соединение и
      дожидается завершения операции: }
    procedure HangUpAndWait(conn: integer);
    var
      status: TRasConnStatus;
    begin
      RasHangUp(conn); // Разрыв соединения
      status.dwSize := sizeof(TRasConnStatus);
      // Ожидание уничтожения соединения:
      repeat
        Application.ProcessMessages;
        sleep(0);
      until RasGetConnectStatus(conn, status) = ERROR_INVALID_HANDLE;
    end;
     
    { Эта процедура будет вызываться при любых изменениях в
      соединении: }
    procedure RasNotifier(msg: integer; state: TRasConnState;
      error: Cardinal); stdcall;
    begin
      CurrentState := StateStr(state, error);
      Form1.ListBox2.Items.Add(CurrentState);
      // Обновление информации об актывных соединениях:
      FillConnections(Form1.ListView1.Items);
      if error <> 0 then begin
        Form1.Timer1.Enabled := false;
        Form1.Caption := CurrentState;
      end else begin
        Form1.Timer1.Enabled := false;
        Form1.Timer1.Enabled := true;
        Form1.Timer1.Tag := 0;
      end;
    end;
     
    procedure TForm1.FormCreate(Sender: TObject);
    begin
      { Установка свойств компонентов (может быть реализована
        через ObjectInspector: }
      Timer1.Enabled := false;
      Button1.Caption := 'Update Entries';
      Button2.Caption := 'Update Conns';
      Button3.Caption := 'Hang Up';
      Button4.Caption := 'Dial Up';
      Button5.Caption := 'Save';
      ListView1.ViewStyle := vsReport; // Вид таблицы
      // Добавление колонок:
      ListView1.Columns.Add.Caption := 'Name';
      ListView1.Columns.Add.Caption := 'Device Type';
      ListView1.Columns.Add.Caption := 'Device Name';
      ListView1.Columns.Add.Caption := 'State';
      // Заполнение компонентов информацией:
      FillEntries(ListBox1.Items);
      FillConnections(ListView1.Items);
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      // Обновление списка соединений:
      FillEntries(ListBox1.Items);
    end;
     
    procedure TForm1.Button2Click(Sender: TObject);
    begin
      // Обновление информации об актывных соединениях:
      FillConnections(ListView1.Items);
    end;
     
    procedure TForm1.Button3Click(Sender: TObject);
    begin
      { Если соединений нет - выход, если одно - выделить его, если
        несколько, но ни одно не выделено - выход }
      case ListView1.Items.Count of
        0: Exit;
        1: ListView1.Selected := ListView1.Items[0];
        else if ListView1.Selected = nil then Exit;
      end;
      // Разрыв соединения:
      HangUpAndWait(longint(ListView1.Selected.Data));
      // Обновление информации об актыв  FillConnections(ListView1.Items);
    end;
     
    procedure TForm1.Button4Click(Sender: TObject);
    var
      params: TRasDialParams;
      hRas: THRasConn;
    begin
      if ListBox1.ItemIndex < 0 then Exit;
      ListBox2.Clear;
     
      // Заполнение params
      FillChar(params, sizeof(TRasDialParams), 0);
      params.dwSize := sizeof(TRasDialParams);
      StrPCopy(params.szEntryName, ListBox1.Items[ListBox1.ItemIndex]);
      StrPCopy(params.szUserName, Edit1.Text);
      StrPCopy(params.szPassword, Edit2.Text);
      // Установка связи:
      RasDial(nil, nil, params, 0, @RasNotifier, hRas);
    end;
     
    procedure TForm1.Button5Click(Sender: TObject);
    var params: TRasDialParams;
    begin
      // Сохранение имени пользователя и пароля:
      params.dwSize := sizeof(TRasDialParams);
      StrPCopy(params.szEntryName, ListBox1.Items[ListBox1.ItemIndex]);
      StrPCopy(params.szUserName, Edit1.Text);
      StrPCopy(params.szPassword, Edit2.Text);
      RasSetEntryDialParams(nil, params, false);
    end;
     
    procedure TForm1.ListBox1DblClick(Sender: TObject);
    var
      params: TRasDialParams;
      passw: longbool;
    begin
      if ListBox1.ItemIndex < 0 then Exit;
      // Определение имени пользователя и пароля:
      fillchar(params, sizeof(TRasDialParams), 0);
      params.dwSize := sizeof(TRasDialParams);
      StrPCopy(params.szEntryName, ListBox1.Items[ListBox1.ItemIndex]);
      RasGetEntryDialParams(nil, params, passw);
      Edit1.Text := params.szUserName;
      if passw then begin
        // Пароль доступен
        Edit2.Text := params.szPassword;
        Button4.SetFocus;
      end else begin
        // Пароль не доступен
        Edit2.Text := '';
        Edit2.SetFocus;
      end;
    end;
     
    procedure TForm1.Timer1Timer(Sender: TObject);
    begin
      { Если действие происходит дольше секунды - в заголовок окна
        помещается информация о действии и время, которое оно
        происходит }
      Form1.Caption := CurrentState + ' - ' + IntToStr(Timer1.Tag);
      Timer1.Tag := Timer1.Tag + 1;
    end;

