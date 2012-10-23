<h1>ODBC соединения</h1>
<div class="date">01.01.2007</div>


<p>...я обращал ваше внимание на трудности коннекта Delphi-приложений с Watcom. За исключением досадной проблемы с чуствительностью регистров у ODBC драйверов (которая пропадает после установки соответствующих заплаток), мое приложение действительно лучше соединяется с базой данных Watcom, чем LIBS. Вот функция, которую я использую для подключения к серверу:</p>

<pre>
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
</pre>

<p>Эта функция находится в модуле с формой диалога подключения, на которой расположены три поля редактирования: идентификатор пользователя, пароль и имя базы данных. При щелчке пользователем на кнопке OK, значение из поля с именем базы данных используется для поиска в файле ODBC.INI:</p>

<pre>
ServerName := ODBCIni.ReadString(DatabaseEdit.Text, 'Database', '');
</pre>

<p>Этой строчкой мы получаем фактическое имя файла базы данных, к которому нам необходимо получить доступ ('SERVER NAME' - параметр соединения).</p>

<p>Во время разработки я выставил в своем компоненте TDatabase следующие параметры:</p>

<p> Connected: FALSE</p>
<p> DatabaseName: DCAC {это псевдоним, используемый приложением}</p>
<p> KeepConnection: TRUE</p>
<p> LoginPrompt: FALSE</p>
<p> Name: MyDatabase</p>
<p> TransIsolation: tiReadCommitted</p>

<p>AliasName, DriverName и Params в режиме проектирования остаются пусты, DriverName не используется совсем, т.к. во время выполнения приложения используется AliasName (они являются взаимоисключающими, вы можете установить что-то одно, но не оба сразу).</p>
<p>Вот секции Interbase и Watcom моего файла ODBC.INI:</p>

<p> [DCAC_IB]</p>
<p> Driver=C:\WIN\SYSTEM\BLINT04.DLL</p>
<p> Description=DC Aquatics (Interbase)</p>
<p> Database=D:\DCAC_IB\DCAC.GDB</p>

<p> [DCAC_WSQL]</p>
<p> Driver=D:\WSQL\wsqlodbc.dll</p>
<p> Description=DC Aquatics (Watcom)</p>
<p> Database=D:\DCAC_WAT\DCAC.DB</p>
<p> Start=D:\wsql\db32w %d</p>

<p>Если мне необходимо подключиться к базе данных Watcom, все, что мне нужно сделать - изменить содержимое поля редактирования имени базы данных в диалоге подключения на 'DCAC_WSQL'. Если мне нужно использовать базу данных Interbase, я набираю 'DCAC_IB'. Работает замечательно.</p>
<p>Надеюсь это поможет... успехов...</p>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
