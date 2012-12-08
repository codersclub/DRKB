---
Title: Как сделать ADO-connection
Date: 01.01.2007
---


Как сделать ADO-connection
==========================

::: {.date}
01.01.2007
:::

    uses
      ComObj;
     
    function OpenConnection(ConnectionString: AnsiString): Integer;
    var
      ADODBConnection: OleVariant;
    begin
      ADODBConnection := CreateOleObject('ADODB.Connection');
      ADODBConnection.CursorLocation := 3; // User client
      ADODBConnection.ConnectionString := ConnectionString;
      Result := 0;
      try
        ADODBConnection.Open;
      except
        Result := -1;
      end;
    end;
     
    function DataBaseConnection_Test(bMessage: Boolean): AnsiString;
    var
      asTimeout, asUserName, asPassword, asDataSource, ConnectionString: AnsiString;
      iReturn: Integer;
      OldCursor: TCursor;
    begin
      OldCursor := Screen.Cursor;
      Screen.Cursor := crHourGlass;
      asTimeout := '150';
      asUserName := 'NT_Server';
      asPassword := 'SA';
      asDataSource := 'SQL Server - My DataBase';
     
      ConnectionString := 'Data Source = ' + asDataSource +
        'User ID = ' + asUserName +
        'Password = ' + asPassword +
        'Mode = Read|Write;Connect Timeout = ' + asTimeout;
      try
        iReturn := OpenConnection(ConnectionString);
     
        if (bMessage) then
        begin
          if (iReturn = 0) then
            Application.MessageBox('Connection OK!', 'Information', MB_OK)
          else if (iReturn = -1) then
            Application.MessageBox('Connection Error!', 'Error', MB_ICONERROR +
              MB_OK);
        end;
     
        if (iReturn = 0) then
          Result := ConnectionString
        else if (iReturn = -1) then
          Result := '';
      finally
        Screen.Cursor := OldCursor;
      end;
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      DataBaseConnection_Test(True);
    end;

Взято с сайта: <https://www.swissdelphicenter.ch>
