<h1>Как узнать, доступен ли в сети сервер MS SQL?</h1>
<div class="date">01.01.2007</div>


<p>Здесь представлена функция, выполняющая проверку доступности MS SQL сервера.</p>

<pre>
function CheckMSSQLServer(fServerName, fUserName, fPsw : String) : Bool; 
Var 
  wDb : TDatabase; 
begin  // Check if MS SQL Server is reachable 
  // Важно! BDE Должна быть установлена
  Result := False; 
  wDb := TDatabase.Create(nil); 
 
  with wDb do 
    begin 
      DatabaseName := 'wDbDatabaseName'; // arbitrary name, must be unique 
                                         // in current Session 
      Params.Values['SERVER Name'] := fServerName; 
      Params.Values['USER Name']   := fUserName; 
      Params.Values['PASSWORD']    := fPsw; 
      LoginPrompt := False; 
    end; 
 
  try 
    wDb.DriverName := 'MSSQL'; 
    try 
      wDb.Connected := True; 
      wDb.Connected := False; 
    except 
      ShowMessage('Server is not reachable'); 
    end; 
    Result := True; 
  finally 
    wDb.Free; 
  end; 
end;
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>


