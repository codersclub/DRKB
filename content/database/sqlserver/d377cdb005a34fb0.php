<h1>Как узнать версию сервера?</h1>
<div class="date">01.01.2007</div>



<p>This function gets the connected MS SQL Server version. It returns the version info in 3 OUT parameters.</p>

<p> &nbsp; &nbsp; &nbsp; &nbsp;VerNum &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;: double  &nbsp; &nbsp; &nbsp; &nbsp;eg. 7.00623</p>
<p> &nbsp; &nbsp; &nbsp; &nbsp;VerStrShort  &nbsp; &nbsp; &nbsp; &nbsp;: string  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;eg. '7.00.623'</p>
<p> &nbsp; &nbsp; &nbsp; &nbsp;VerStrLong  &nbsp; &nbsp; &nbsp; &nbsp;: string  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;eg. 'Microsoft SQL Server&nbsp; 7.00 - 7.00.623 (Intel X86)  &nbsp; &nbsp; &nbsp; &nbsp;Nov 27 1998 22:20:07&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Copyright (c) 1988-1998 Microsoft Corporation &nbsp; &nbsp; &nbsp; &nbsp;Enterprise Edition on&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Windows NT 5.0 (Build 2195: Service Pack 1)'</p>

<p>I have tested it with MSSQL 7 and MSSQL 2000. I assume it should work for the others. Any feedback and fixes for different versions would be appreciated.</p>

<p>The TQuery parameter that it recieves is a TQuery component that is connected to an open database connection.</p>

<pre>
procedure GetSqlVersion(Query: TQuery;
  out VerNum: double;
  out VerStrShort: string;
  out VerStrLong: string);
var
  sTmp, sValue: string;
  i: integer;
begin
  // @@Version does not return a Cursor.
  // Read the value from the Record Buffer
  // Can be used to read all sys functions from MS Sql
  sValue := '';
  Query.SQL.Text := 'select @@Version';
  Query.Open;
  SetLength(sValue, Query.RecordSize + 1);
  Query.GetCurrentRecord(PChar(sValue));
  SetLength(sValue, StrLen(PChar(sValue)));
  Query.Close;
 
  if sValue &lt;&gt; '' then
    VerStrLong := sValue
  else
  begin
    // Don't know this version
    VerStrLong := '?';
    VerNum := 0.0;
    VerStrShort := '?.?.?.?';
  end;
 
  if VerStrLong &lt;&gt; '' then
  begin
    sTmp := trim(copy(VerStrLong, pos('-', VerStrLong) + 1, 1024));
    VerStrShort := copy(sTmp, 1, pos(' ', sTmp) - 1);
    sTmp := copy(VerStrShort, 1, pos('.', VerStrShort));
 
    for i := length(sTmp) + 1 to length(VerStrShort) do
    begin
      if VerStrShort[i] &lt;&gt; '.' then
        sTmp := sTmp + VerStrShort[i];
    end;
 
    VerNum := StrToFloat(sTmp);
  end;
end;
</pre>

<p>Взято с Delphi Knowledge Base: <a href="https://www.baltsoft.com/" target="_blank">https://www.baltsoft.com/</a></p>
