---
Title: Создание DBExpress соединения в runtime
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Создание DBExpress соединения в runtime
=======================================

    {
      The normal way for Delphi and Kylix is just to check dbExpress,
      put a TSQLConnection on a form then double-click the TSQLConnection to display
      the Connection Editor and set parameter values (database path, connection name etc.)
      to indicate the settings.
     
      But in our example, all goes by runtime (path and login) with dbExpress we don't need
      an alias or the BDE either.
    }
     
    procedure TVCLScanner.PostUser(const Email, FirstName, LastName: WideString);
    var
      Connection: TSQLConnection;
      DataSet: TSQLDataSet;
    begin
      Connection := TSQLConnection.Create(nil);
      with Connection do
      begin
        ConnectionName := 'VCLScanner';
        DriverName := 'INTERBASE';
        LibraryName := 'dbexpint.dll';
        VendorLib := 'GDS32.DLL';
        GetDriverFunc := 'getSQLDriverINTERBASE';
        Params.Add('User_Name=SYSDBA');
        Params.Add('Password=masterkey');
        Params.Add('Database=milo2:D:\frank\webservices\umlbank.gdb');
        LoginPrompt := False;
        Open;
      end;
      DataSet := TSQLDataSet.Create(nil);
      with DataSet do
      begin
        SQLConnection := Connection;
        CommandText := Format('INSERT INTO kings VALUES("%s","%s","%s")',
          [Email, FirstN, LastN]);
        try
          ExecSQL;
        except
        end;
      end;
      Connection.Close;
      DataSet.Free;
      Connection.Free;
    end;

