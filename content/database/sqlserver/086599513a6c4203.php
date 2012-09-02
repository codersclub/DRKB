<h1>Сохранить BLOB-поле в файл</h1>
<div class="date">01.01.2007</div>


<pre>
  DECLARE @BufLen [int]
  DECLARE @BufPos [int]
  DECLARE @Buffer [varbinary](4096)
  DECLARE @Stream [int]
  DECLARE @HR [int]
 
  SELECT @BufPos = 1, @BufLen = DATALENGTH(MyField) FROM MyTable WHERE SomeField=@SomeID
 
  EXEC @HR = sp_OACreate 'ADODB.Stream',@Stream OUT 
  EXEC @HR = sp_OASetProperty @Stream,'Type',1
  EXEC @HR = sp_OAMethod @Stream,'Open' 
 
  WHILE @BufLen &gt; 0 
  BEGIN
    SELECT @Buffer = SUBSTRING(MyField,@BufPos,4096) FROM MyTable WHERE SomeField=@SomeID
    EXEC @HR = sp_OAMethod @Stream,'Write',null,@Buffer
    SELECT @BufLen = @BufLen - 4096, @BufPos = @BufPos + 4096
  END
  EXEC @HR = sp_OAMethod @Stream, 'SaveToFile',Null,@Filename,2
  EXEC @HR = sp_OAMethod @Stream, 'Close'
  EXEC @HR = sp_OADestroy @Stream
</pre>
<p class="author">Автор: Vit</p>
