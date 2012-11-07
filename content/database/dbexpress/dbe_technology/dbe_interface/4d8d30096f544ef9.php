<h1>ISQLConnection</h1>
<div class="date">01.01.2007</div>


<p>Интерфейс ISQLConnection обеспечивает работу соединения. Он передает запросы серверу и возвращает результаты, создавая экземпляры интерфейса iSQLCommand; управляет транзакциями; поддерживает передачу метаданных при помощи интерфейса ISQLMetaData.</p>
<p>Для открытия соединения используется метод</p>
<p>function connect(ServerName: PChar; UserName: PChar; Password: PChar): SQLResult; stdcall;</p>
<p>где ServerName &#8212; имя базы данных, UserName И Password &#8212; имя и пароль пользователя.</p>
<p>Закрывает соединение метод</p>
<p>function disconnect: SQLResult; stdcall;</p>
<p>Параметры соединения управляются методами</p>
<p>function SetOption(eConnectOption: TSQLConnectionOption; lvalue: Longlnt): SQLResult; stdcall;</p>
<p>function GetOption(eDOption: TSQLConnectionOption; PropValue: Pointer; MaxLength: Smalllnt; out Length: Smalllnt): SQLResult; stdcall;</p>
<p>Для обработки запроса, проходящего через соединение, создается интерфейс ISQLCommand</p>
<p>function getSQLCommand(out pComm: ISQLCommand): SQLResult; stdcall;</p>
<p>Обработка транзакций осуществляется тремя методами:</p>
<p>function beginTransaction(TranID: LongWord): SQLResult; stdcall;</p>
<p>function commit(TranID: LongWord): SQLResult; stdcall;</p>
<p>function rollback(TranID: LongWord): SQLResult; stdcall;</p>
<p>При помощи метода</p>
<p>function getErrorMessage(Error: PChar): SQLResult; overload; stdcall;</p>
<p>организована обработка исключительных ситуаций в компоненте TSQLConnection. В нем реализована защищенная процедура SQLError, которую можно использовать в собственных компонентах и при необходимости дорабатывать.</p>
<p>Например, можно написать собственную процедуру контроля ошибок примерно по такому образцу:</p>
<pre>
procedure CheckError(IConn: ISQLConnection);</p>
 var FStatus: SQLResult; 
     FSize:SmallInt; 
     FMessage: pChar; 
begin 
  FStatus := IConn.getErrorMessageLen(FSize);  
  if (FStatus = SQL_SUCCESS)and(FSize &gt; 0) then 
    begin 
      FMessage := AllocMem(FSize + I); 
      FStatus := IConn.getErrorMessage(FMessage); 
      if FStatus = SQL_SUCCESS then 
        MessageDlg (FMessage, mtError, [rnbOK] , 0) 
      else 
        MessageDlg('Checking error', mtWarning, [mbOK], 0) ; 
      if Assigned(FMessage) then FreeMem(FMessage); 
   end; 
end; 
</pre>
<p>Доступ к интерфейсу isQLConnection можно получить через свойство</p>
<p>property SQLConnection: ISQLConnection;</p>
<p>компонента TSQLConnection.</p>

