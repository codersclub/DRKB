<h1>Как узнать номер автоинкремента при вставке новой записи?</h1>
<div class="date">01.01.2007</div>



<p>We have a table in MsAccess like :</p>

<p>Test, Fields (id=autoinc, name=text);</p>

<p>First we have to have a function like the one below :</p>

<pre>
function GetLastInsertID: integer;
begin
  // datResult = TADODataSet
  datResult.Active := False;
  datResult.CommandText := 'select @@IDENTITY as [ID]';
  datResult.Active := True;
  Result := datResult.FieldByName('id').AsInteger;
  datResult.Active := False;
end;
</pre>


<p>Now before getting the last inserted record record id = autoincrement field, in other words calling the above function. You have to do a SQL insert like the following</p>
<pre>
procedure InsertRec;
begin
  // datCommand = TADOCommand
  datCommand.CommandText := 'insert into [test] ( [name] ) values ( "Test" )';
  datCommand.Execute;
end;
</pre>

<p>Now if we like to know which is the last autoinc value ( notice that the getlastinsertid proc. only works after the insertrec proc)</p>
<pre>
procedure Test;
begin
  InsertRec;
  Showmessage(format('lastinsertid : %d', [GetLastInsertID]));
end;
</pre>


<p>Hope you can make this work, it works for me, any questions feel free to ask</p>
<p>Взято с Delphi Knowledge Base: <a href="https://www.baltsoft.com/" target="_blank">https://www.baltsoft.com/</a></p>
