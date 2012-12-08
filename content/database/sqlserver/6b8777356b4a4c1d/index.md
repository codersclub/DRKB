---
Title: Загрузить файл в BLOB-поле
Author: Vit
Date: 01.01.2007
---


Загрузить файл в BLOB-поле
==========================

::: {.date}
01.01.2007
:::

      DECLARE @HR [int]
      DECLARE @Stream [int]
      DECLARE @Buffer [varbinary](4096)
      DECLARE @Size [int]
      DECLARE @Pos [int] SET @Pos = 0
      DECLARE @BufSize [int] SET @BufSize = 4096
      DECLARE @Image [binary](16)
     
      EXEC @HR = sp_OACreate 'ADODB.Stream',@Stream OUT 
      EXEC @HR = sp_OASetProperty @Stream,'Type',1
      EXEC @HR = sp_OAMethod @Stream,'Open' 
      EXEC @HR = sp_OAMethod @Stream,'LoadFromFile',null, @Filename
      EXEC @HR = sp_OAMethod @Stream,'Size',@Size OUTPUT
     
      if not exists(SELECT * FROM MyTable WHERE SomeField=SomeID)
        INSERT INTO MyTable VALUES(SomeID,'')
     
      SELECT top 1 @Image = TEXTPTR(MyField) FROM MyTable WHERE SomeField=SomeID
     
      Set @Pos=0
     
      WHILE @Pos < @Size BEGIN
        SET @BufSize = CASE WHEN @Size - @Pos < 4096 THEN @Size - @Pos ELSE 4096 END
        EXEC @HR = sp_OAMethod @Stream,'Read',@Buffer OUTPUT,@BufSize
     
        UPDATETEXT MyTable.MyField @Image @Pos 0 @Buffer
        SET @Pos = @Pos + @BufSize
      END
     
      EXEC @HR = sp_OAMethod @Stream, 'Close'
      EXEC @HR = sp_OADestroy @Stream

Автор: Vit
