<h1>Пример создания хранимой процедуры</h1>
<div class="date">01.01.2007</div>


<pre>
Create Procedure MyStoredProcedure
  @Parameter1 varchar(50),
  @Parameter2 int,
  @OutputParameter varchar(100) output
As
Begin
   Set @Parameter1=isNull(@Parameter1, '')
   Set @OutputParameter=@Parameter1+cast(@Parameter2 as varchar(10))
   Return 0
End
</pre>

<p>Примечания:</p>

<p>1) Begin..End для обрамления процедуры не обязательны. Дельфи приучил меня </p>
их использовать и мне легче читать с ними код, но вполне можно обходится и без них.
На ваше усмотрение:
<p>&nbsp;</p>
<pre>
Create Procedure MyStoredProcedure
  @Parameter1 varchar(50),
  @Parameter2 int,
  @OutputParameter varchar(100) output
As
   Set @Parameter1=isNull(@Parameter1, '')
   Set @OutputParameter=@Parameter1+cast(@Parameter2 as varchar(10))
   Return 0
</pre>

<p>&nbsp;</p>
<p>2) Хранимая процедура всегда должна создаваться отдельным SQL запросом. Нельзя создать одним запросом несколько хранимых процедур. При написании скрипта для Query Analyser для создания нескольких процедур можно использовать директиву GO, которая воспринимается Query Analyser'ом как разделить отдельных запросов:</p>
<pre>
Create Procedure MyStoredProcedure
  @Parameter1 varchar(50),
  @Parameter2 int,
  @OutputParameter varchar(100) output
As
Begin
   Set @Parameter1=isNull(@Parameter1, '')
   Set @OutputParameter=@Parameter1+cast(@Parameter2 as varchar(10))
   Return 0
End
Go
 
Create Procedure MyStoredProcedure2
As
Select GetDate()
Go
</pre>

<p>Директива GO не является оператором SQL и при выполнения запроса из клиентского приложения не будет пониматься. Кроме того директиву GO невозможно закоментировать.</p>

<hr />

<p>Пример её вызова:</p>

<pre>
Declare @Param1 varchar(50), @Param2 int, @OutputParam varchar(100)
 
Select @Param1='Просто строка ', @Param2=2
 
Exec MyStoredProcedure
  @Parameter1=@Param1,
  @Parameter2=@Param2,
  @OutputParameter=@OutputParam output
 
Select @OutputParam
</pre>

<p class="author">Автор: Vit</p>

