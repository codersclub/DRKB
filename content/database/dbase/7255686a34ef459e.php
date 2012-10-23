<h1>Как создать dBASE таблицу во время выполнения</h1>
<div class="date">01.01.2007</div>


<p>Данная процедура полезна для создания временных таблиц :</p>
<pre>
 procedure MakeDataBase;
 begin
   with TTable.Create(nil) do
   begin
     DatabaseName  := 'c:\temp';  (* alias *)
     TableName     := 'test.dbf';
     TableType     := ttDBase;
     with FieldDefs do
     begin
       Add('F_NAME', ftString,20,false);
       Add('L_NAME', ftString,30,false);
     end;
     CreateTable;
     { create a calculated index }
     with IndexDefs do
     begin
       Clear;
       { don't forget ixExpression in calculated indexes! }
       AddIndex('name','Upper(L_NAME)+Upper(F_NAME)',[ixExpression]);
     end;
   end;
 end;
</pre>

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
