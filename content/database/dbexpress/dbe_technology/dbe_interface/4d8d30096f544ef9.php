<h1>ISQLConnection</h1>
<div class="date">01.01.2007</div>


<p>Интерфейс ISQLConnection обеспечивает работу соединения. Он передает запросы серверу и возвращает результаты, создавая экземпляры интерфейса iSQLCommand; управляет транзакциями; поддерживает передачу метаданных при помощи интерфейса ISQLMetaData. </p>
<p>Для открытия соединения используется метод </p>
<p>function connect(ServerName: PChar; UserName: PChar; Password: PChar): SQLResult; stdcall; </p>
<p>где ServerName &#8212; имя базы данных, UserName И Password &#8212; имя и пароль пользователя. </p>
<p>Закрывает соединение метод </p>
<p>function disconnect: SQLResult; stdcall; </p>
<p>Параметры соединения управляются методами </p>
<p>function SetOption(eConnectOption: TSQLConnectionOption; lvalue: Longlnt): SQLResult; stdcall; </p>
<p>function GetOption(eDOption: TSQLConnectionOption; PropValue: Pointer; MaxLength: Smalllnt; out Length: Smalllnt): SQLResult; stdcall; </p>
<p>Для обработки запроса, проходящего через соединение, создается интерфейс ISQLCommand&nbsp; </p>
<p>function getSQLCommand(out pComm: ISQLCommand): SQLResult; stdcall; </p>
<p>Обработка транзакций осуществляется тремя методами: </p>
<p>function beginTransaction(TranID: LongWord): SQLResult; stdcall; </p>
<p>function commit(TranID: LongWord): SQLResult; stdcall; </p>
<p>function rollback(TranID: LongWord): SQLResult; stdcall; </p>
<p>При помощи метода </p>
<p>function getErrorMessage(Error: PChar): SQLResult; overload; stdcall; </p>
<p>организована обработка исключительных ситуаций в компоненте TSQLConnection. В нем реализована защищенная процедура SQLError, которую можно использовать в собственных компонентах и при необходимости дорабатывать. </p>
<p>Например, можно написать собственную процедуру контроля ошибок примерно по такому образцу: </p>
<pre>
procedure CheckError(IConn: ISQLConnection); </p>
 var FStatus: SQLResult; 
 &nbsp;&nbsp;&nbsp; FSize:SmallInt; 
 &nbsp;&nbsp;&nbsp; FMessage: pChar; 
begin 
  FStatus := IConn.getErrorMessageLen(FSize);&nbsp; 
  if (FStatus = SQL_SUCCESS)and(FSize &gt; 0) then 
 &nbsp;&nbsp; begin 
 &nbsp;&nbsp;&nbsp;&nbsp; FMessage := AllocMem(FSize + I); 
 &nbsp;&nbsp;&nbsp;&nbsp; FStatus := IConn.getErrorMessage(FMessage); 
 &nbsp;&nbsp;&nbsp;&nbsp; if FStatus = SQL_SUCCESS then 
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; MessageDlg (FMessage, mtError, [rnbOK] , 0) 
 &nbsp;&nbsp;&nbsp;&nbsp; else 
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; MessageDlg('Checking error', mtWarning, [mbOK], 0) ; 
 &nbsp;&nbsp;&nbsp;&nbsp; if Assigned(FMessage) then FreeMem(FMessage); 
 &nbsp; end; 
end; 
</pre>
<p>Доступ к интерфейсу isQLConnection можно получить через свойство </p>
<p>property SQLConnection: ISQLConnection;&nbsp; </p>
<p>компонента TSQLConnection. </p>

