---
Title: Сохранить значение текстовой переменной в файле
Author: Vit
Date: 01.01.2007
---


Сохранить значение текстовой переменной в файле
===============================================

    Declare 
      @Stream int, 
      @Buffer varbinary(8000), 
      @HR int
   
    Exec @HR = sp_OACreate 'ADODB.Stream',@Stream OUT 
    Exec @HR = sp_OASetProperty @Stream,'Type',1
    Exec @HR = sp_OAMethod @Stream,'Open'
    Set @Buffer = cast(@MyVariable as varbinary(8000))
    Exec @HR = sp_OAMethod @Stream,'Write',null, @Buffer
    Exec @HR = sp_OAMethod @Stream, 'SaveToFile',Null,'c:\MyFile.txt',2
    Exec @HR = sp_OAMethod @Stream, 'Close'
    Exec @HR = sp_OADestroy @Stream
