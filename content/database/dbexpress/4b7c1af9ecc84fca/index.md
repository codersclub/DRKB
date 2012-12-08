---
Title: Создание DBExpress-Connection в runtime
Date: 01.01.2007
---


Создание DBExpress-Connection в runtime
=======================================

::: {.date}
01.01.2007
:::

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

Взято с <https://delphiworld.narod.ru>
