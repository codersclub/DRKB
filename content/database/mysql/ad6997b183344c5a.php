<h1>Как подсоединиться к MySQL?</h1>
<div class="date">01.01.2007</div>



<p>Perhaps you have already seen the uses clause. You may download mySQL.pas from <a href="https://www.fichtner.net/delphi" target="_blank">www.fichtner.net/delphi</a></p>
<pre>
uses mySQL;
 
procedure Connect;
var
  myServer: PMysql;
  Tables: PMYSQL_RES;
  TableRows: my_ulonglong;
  Table: PMYSQL_ROW;
begin
  myServer := mysql_init(nil);
  if myServer &lt;&gt; nil then
  begin
    if mysql_options(myServer, MYSQL_OPT_CONNECT_TIMEOUT, '30') = 0 then
    begin
      if mysql_real_connect(myServer, 'host', 'user', 'password', 'database', 3306,
        nil, CLIENT_COMPRESS) &lt;&gt; nil then
      begin
        Tables := mysql_list_tables(myServer, nil);
        if Tables &lt;&gt; nil then
        begin
          TableRows := mysql_num_rows(Tables);
          while TableRows &gt; 0 do
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
</pre>

<p>Взято с Delphi Knowledge Base: <a href="https://www.baltsoft.com/" target="_blank">https://www.baltsoft.com/</a></p>
