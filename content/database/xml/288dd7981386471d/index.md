---
Title: Сбростить BDE базу данных в XML файл
Author: Vit
Date: 01.01.2007
---


Сбростить BDE базу данных в XML файл
====================================

::: {.date}
01.01.2007
:::

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
           result:=Result+'&#'+inttostr(ord(Value[n]))+';';
     end;
     
     Procedure WriteValue(Indent:integer; Name, ParamName, ParamValue, Value:string);
       var temp:string;
       const Empty='                                                             ';
     begin
       Temp:=Copy(empty,1,Indent);
       temp:=temp+'<'+Name;
       if ParamName='' then temp:=temp+'>' else temp:=temp+' '+Paramname+'="'+FixValue(ParamValue)+'">';
       Temp:=Temp+FixValue(Value)+'</'+Name+'>';
       Writeln(f,temp);
     end;
     
     Procedure WriteTag(Indent:integer; Name, ParamName, ParamValue:string; Open:boolean=True);
       var temp:string;
       const Empty='                                                             ';
     begin
       Temp:=Copy(empty,1,Indent);
       if Open then temp:=temp+'<'+Name else temp:=temp+'</'+Name;
       if ParamName='' then temp:=temp+'>' else temp:=temp+' '+Paramname+'="'+FixValue(ParamValue)+'">';
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

XML формируется в ввиде

     <MyDatabase>
       <Table1>
         <Rec>
           <Field1>Value1</Field1>
           <Field2>Value2</Field2>
           <Field3>Value3</Field3>
         </Rec>
         <Rec>
           <Field1>Value1</Field1>
           <Field2>Value2</Field2>
           <Field3>Value3</Field3>
         </Rec>
       </Table1>
       <Table2>
         <Rec>
           <Field1>Value1</Field1>
           <Field2>Value2</Field2>
           <Field3>Value3</Field3>
         </Rec>
         <Rec>
           <Field1>Value1</Field1>
           <Field2>Value2</Field2>
           <Field3>Value3</Field3>
         </Rec>
       </Table2>
     </MyDatabase>

Автор: Vit

Взято с Vingrad.ru <https://forum.vingrad.ru>
