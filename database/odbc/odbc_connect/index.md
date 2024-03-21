---
Title: ODBC соединения
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


ODBC соединения
===============

...я обращал ваше внимание на трудности коннекта Delphi-приложений с
Watcom. За исключением досадной проблемы с чуствительностью регистров у
ODBC драйверов (которая пропадает после установки соответствующих
заплаток), мое приложение действительно лучше соединяется с базой данных
Watcom, чем LIBS.

Вот функция, которую я использую для подключения к серверу:

    function TLogonForm.LogonToServer: Boolean;
    begin
      LogonToServer := FALSE;
      MyDatabase.AliasName := DatabaseEdit.Text;
      MyDatabase.Params.Values['USER NAME'] := UserIDEdit.Text;
      MyDatabase.Params.Values['PASSWORD'] := PasswordEdit.Text;
      MyDatabase.Params.Values['SERVER NAME'] := ServerName;
      try
        MyDatabase.Connected := TRUE;
        LogonToServer := TRUE;
      except
        on E: EDatabaseError do
          MessageDlg('Программа не в состоянии подключиться к
            серверу баз данных по следующей причине:
              ' + #10 + #10 + E.Message, mtError, [mbOK], 0);
      end;
    end;

Эта функция находится в модуле с формой диалога подключения, на которой
расположены три поля редактирования: идентификатор пользователя, пароль
и имя базы данных. При щелчке пользователем на кнопке OK, значение из
поля с именем базы данных используется для поиска в файле ODBC.INI:

    ServerName := ODBCIni.ReadString(DatabaseEdit.Text, 'Database', '');

Этой строчкой мы получаем фактическое имя файла базы данных, к которому
нам необходимо получить доступ ('SERVER NAME' - параметр соединения).

Во время разработки я выставил в своем компоненте TDatabase следующие
параметры:

- Connected: FALSE
- DatabaseName: DCAC {это псевдоним, используемый приложением}
- KeepConnection: TRUE
- LoginPrompt: FALSE
- Name: MyDatabase
- TransIsolation: tiReadCommitted

AliasName, DriverName и Params в режиме проектирования остаются пусты,
DriverName не используется совсем, т.к. во время выполнения приложения
используется AliasName (они являются взаимоисключающими, вы можете
установить что-то одно, но не оба сразу).

Вот секции Interbase и Watcom моего файла ODBC.INI:

    [DCAC_IB]

    Driver=C:\WIN\SYSTEM\BLINT04.DLL
    Description=DC Aquatics (Interbase)
    Database=D:\DCAC_IB\DCAC.GDB

    [DCAC_WSQL]

    Driver=D:\WSQL\wsqlodbc.dll
    Description=DC Aquatics (Watcom)
    Database=D:\DCAC_WAT\DCAC.DB
    Start=D:\wsql\db32w %d

Если мне необходимо подключиться к базе данных Watcom, все, что мне
нужно сделать - изменить содержимое поля редактирования имени базы
данных в диалоге подключения на 'DCAC\_WSQL'. Если мне нужно
использовать базу данных Interbase, я набираю 'DCAC\_IB'. Работает
замечательно.

Надеюсь это поможет...

Успехов...

