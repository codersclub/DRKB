---
Title: Как подсоединиться к MySQL?
Date: 01.01.2007
Source: Delphi Knowledge Base: <https://www.baltsoft.com/>
---


Как подсоединиться к MySQL?
===========================

Возможно, вы уже видели директиву USES.//

Вы можете скачать mySQL.pas с
[www.fichtner.net/delphi](https://www.fichtner.net/delphi)

    uses mySQL;
     
    procedure Connect;
    var
      myServer: PMysql;
      Tables: PMYSQL_RES;
      TableRows: my_ulonglong;
      Table: PMYSQL_ROW;
    begin
      myServer := mysql_init(nil);
      if myServer <> nil then
      begin
        if mysql_options(myServer, MYSQL_OPT_CONNECT_TIMEOUT, '30') = 0 then
        begin
          if mysql_real_connect(myServer, 'host', 'user', 'password', 'database', 3306,
            nil, CLIENT_COMPRESS) <> nil then
          begin
            Tables := mysql_list_tables(myServer, nil);
            if Tables <> nil then
            begin
              TableRows := mysql_num_rows(Tables);
              while TableRows > 0 do
              begin
                Table := mysql_fetch_row(Tables);
                Tabelle := Table[0];
                Dec(TableRows);
              end;
            end;
          end;
        end;
      end;
    end;

