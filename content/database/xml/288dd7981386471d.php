<h1>Сбростить BDE базу данных в XML файл</h1>
<div class="date">01.01.2007</div>


<pre>
Procedure CreateXML(Alias:string; XMLName:string);
 var i,j,x,y:integer;
     f:TextFile;
     Tables:TStringList;
     Table:TTable;
 
 Function FixValue(Value:string):string;
   var n:integer;
 begin
   Result:='';
   For n:=1 to length(Value) do
     if Value[n] in ['0'..'9','a'..'z','A'..'Z','.',',','-',' ','/','*',':','{','}','_','@','\','+','%'] then
       result:=Result+Value[n]
     else
       result:=Result+'&amp;#'+inttostr(ord(Value[n]))+';';
 end;
 
 Procedure WriteValue(Indent:integer; Name, ParamName, ParamValue, Value:string);
   var temp:string;
   const Empty='                                                             ';
 begin
   Temp:=Copy(empty,1,Indent);
   temp:=temp+'&lt;'+Name;
   if ParamName='' then temp:=temp+'&gt;' else temp:=temp+' '+Paramname+'="'+FixValue(ParamValue)+'"&gt;';
   Temp:=Temp+FixValue(Value)+'&lt;/'+Name+'&gt;';
   Writeln(f,temp);
 end;
 
 Procedure WriteTag(Indent:integer; Name, ParamName, ParamValue:string; Open:boolean=True);
   var temp:string;
   const Empty='                                                             ';
 begin
   Temp:=Copy(empty,1,Indent);
   if Open then temp:=temp+'&lt;'+Name else temp:=temp+'&lt;/'+Name;
   if ParamName='' then temp:=temp+'&gt;' else temp:=temp+' '+Paramname+'="'+FixValue(ParamValue)+'"&gt;';
   Writeln(f,temp);
 end;
 
begin
 Tables:=TStringList.Create;
 Table:=TTable.Create(nil);
 try
   session.GetTableNames(Alias, '*.db',False, False, Tables);
   Table.DatabaseName:=Alias;
   assignFile(f,XMLName);
   reWrite(f);
   WriteTag(0, Alias, '', '', True);
   for i:=0 to Tables.Count-1 do
     begin
       Table.Active:=false;
       Table.TableName:=Tables[i];
       WriteTag(1, Table.tablename, '', '', True);
       Table.Active:=true;
       Table.First;
       For j:=0 to Table.RecordCount-1 do
         begin
           WriteTag(2, 'Rec', '', '', True);
           For x:=0 to Table.fields.count-1 do  
             WriteValue(4, Table.fields[x].FieldName, '', '', Table.fields[x].asstring);
           WriteTag(2, 'Rec', '', '', False);
           Table.Next;
         end;
       WriteTag(1, Table.tablename, '', '', False);
     end;
   WriteTag(0, Alias, '', '', False);
   CloseFile(f);
 finally
   Tables.free;
   Table.free;
 end;
 
end;
 
 
 
procedure TForm1.Button1Click(Sender: TObject);
begin
 CreateXML('MyDatabase', 'c:\XMLFile.xml');
end;
</pre>
<p>XML формируется в ввиде</p>
<pre>
 &lt;MyDatabase&gt;
   &lt;Table1&gt;
     &lt;Rec&gt;
       &lt;Field1&gt;Value1&lt;/Field1&gt;
       &lt;Field2&gt;Value2&lt;/Field2&gt;
       &lt;Field3&gt;Value3&lt;/Field3&gt;
     &lt;/Rec&gt;
     &lt;Rec&gt;
       &lt;Field1&gt;Value1&lt;/Field1&gt;
       &lt;Field2&gt;Value2&lt;/Field2&gt;
       &lt;Field3&gt;Value3&lt;/Field3&gt;
     &lt;/Rec&gt;
   &lt;/Table1&gt;
   &lt;Table2&gt;
     &lt;Rec&gt;
       &lt;Field1&gt;Value1&lt;/Field1&gt;
       &lt;Field2&gt;Value2&lt;/Field2&gt;
       &lt;Field3&gt;Value3&lt;/Field3&gt;
     &lt;/Rec&gt;
     &lt;Rec&gt;
       &lt;Field1&gt;Value1&lt;/Field1&gt;
       &lt;Field2&gt;Value2&lt;/Field2&gt;
       &lt;Field3&gt;Value3&lt;/Field3&gt;
     &lt;/Rec&gt;
   &lt;/Table2&gt;
 &lt;/MyDatabase&gt;
</pre>

<p class="author">Автор: Vit</p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>

