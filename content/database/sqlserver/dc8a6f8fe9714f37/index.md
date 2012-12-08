---
Title: Создать скрипт базы данных путем запроса
Author: Vit
Date: 01.01.2007
---


Создать скрипт базы данных путем запроса
========================================

::: {.date}
01.01.2007
:::

      DECLARE 
               @SQL int, 
               @SP int, 
               @i int, @j int, @s varchar(200), @k int, @l sysname, 
               @ERROR int, 
               @Source varchar(8000), 
               @Description varchar(8000) 
     
    --©Drkb v.3(2007): www.drkb.ru
     
      exec @error = sp_OACreate 'SQLDMO.SQLServer', @SQL out 
      if @error<>0 
      begin 
               exec sp_OAGetErrorInfo @SQL, @Source out, @Description out 
               print ISNULL(@Source,'')+', '+ ISNULL(@Description,'') 
      end 
     
      exec @error = sp_OASetProperty @SQL, 'LoginSecure ', 'TRUE' 
      if @error<>0 
      begin 
               exec sp_OAGetErrorInfo @SQL, @Source out, @Description out 
               print ISNULL(@Source,'')+', '+ ISNULL(@Description,'') 
      end 
     
      exec @error = sp_OAMethod @SQL, 'Connect(".")'
      if @error<>0 
      begin 
               exec sp_OAGetErrorInfo @SQL, @Source out, @Description out 
               print ISNULL(@Source,'')+', '+ ISNULL(@Description,'') 
      end 
     
      set @s='Databases("'+DB_NAME()+'").DatabaseRoles' 
             exec @error = sp_OAGetProperty @SQL, @s, @SP out 
             if @error<>0 
      begin 
               exec sp_OAGetErrorInfo @SQL, @Source OUT, @Description OUT 
                      print isnull(@Source,'')+', '+ isnull(@Description,'') 
             end
               
             set @s='Databases("'+DB_NAME()+'").DatabaseRoles.Count' 
             exec @error = sp_OAGetProperty @SQL, @s, @j out 
             if @error<>0 
      begin 
                      exec sp_OAGetErrorInfo @SQL, @Source OUT, @Description OUT 
                      print isnull(@Source,'')+', '+ isnull(@Description,'') 
             end
             set @i=1 
             while @i<=@j 
      begin 
                      set @s='Item(' +ltrim(str(@i))+ ').Name' 
                      exec @error = sp_OAGetProperty @SP, @s, @l out 
                      if @error<>0 
        begin 
                               exec sp_OAGetErrorInfo @SP, @Source out, @Description out 
                               print ISNULL(@Source,'')+', '+ ISNULL(@Description,'') 
                      end 
                      if left(@l,3) <> 'db_' 
        begin
                               set @s='Item(' +ltrim(str(@i))+ ').Script(266663,"'+@Path+'",6)' 
                               exec @error = sp_OAMethod @SP, @s, @Description out 
                                print @Description 
                                if @error<>0 
           begin 
                                         exec sp_OAGetErrorInfo @SP, @Source out, @Description out 
                                         print ISNULL(@Source,'')+', '+ ISNULL(@Description,'') 
                                end 
                      end 
                      set @i=@i+1 
      end 
     
             set @SP = null
     
             set @s='Databases("'+DB_NAME()+'").Defaults' 
             exec @error = sp_OAGetProperty @SQL, @s, @SP out 
             if @error<>0 
      begin 
                      exec sp_OAGetErrorInfo @SQL, @Source OUT, @Description OUT 
                      print isnull(@Source,'')+', '+ isnull(@Description,'') 
             end
             set @s='Databases("'+DB_NAME()+'").Defaults.Count' 
             exec @error = sp_OAGetProperty @SQL, @s, @j out 
             if @error<>0 
      begin 
                      exec sp_OAGetErrorInfo @SQL, @Source OUT, @Description OUT 
                      print isnull(@Source,'')+', '+ isnull(@Description,'') 
             end
     
             set @i=1 
             while @i<=@j 
      begin 
                      set @s='Item(' +ltrim(str(@i))+ ').Name' 
                      exec @error = sp_OAGetProperty @SP, @s, @l out 
                      if @error<>0 
        begin 
                               exec sp_OAGetErrorInfo @SP, @Source out, @Description out 
                               print ISNULL(@Source,'')+', '+ ISNULL(@Description,'') 
                      end 
                      set @s='Item(' +ltrim(str(@i))+ ').Script(266663,"'+@Path+'",6)' 
                      exec @error = sp_OAMethod @SP, @s, @Description out 
                      print @Description 
                      if @error<>0 
        begin 
                               exec sp_OAGetErrorInfo @SP, @Source out, @Description out 
                               print ISNULL(@Source,'')+', '+ ISNULL(@Description,'') 
                      end 
                      set @i=@i+1 
             end 
             set @SP = null
     
             set @s='Databases("'+DB_NAME()+'").FullTextCatalogs' 
             exec @error = sp_OAGetProperty @SQL, @s, @SP out 
             if @error<>0 begin 
                      exec sp_OAGetErrorInfo @SQL, @Source OUT, @Description OUT 
                      print isnull(@Source,'')+', '+ isnull(@Description,'') 
             end
             set @s='Databases("'+DB_NAME()+'").FullTextCatalogs.Count' 
             exec @error = sp_OAGetProperty @SQL, @s, @j out 
             if @error<>0 
      begin 
                      exec sp_OAGetErrorInfo @SQL, @Source OUT, @Description OUT 
                      print isnull(@Source,'')+', '+ isnull(@Description,'') 
             end
             set @i=1 
             wh
    ile @i<=@j 
      begin 
                      set @s='Item(' +ltrim(str(@i))+ ').Name' 
                      exec @error = sp_OAGetProperty @SP, @s, @l out 
                      if @error<>0 
        begin 
                               exec sp_OAGetErrorInfo @SP, @Source out, @Description out 
                               print ISNULL(@Source,'')+', '+ ISNULL(@Description,'') 
                      end 
                      set @s='Item(' +ltrim(str(@i))+ ').Script(266663,"'+@Path+'",6)' 
                      exec @error = sp_OAMethod @SP, @s, @Description out 
                      print @Description 
                      if @error<>0 
        begin 
                               exec sp_OAGetErrorInfo @SP, @Source out, @Description out 
                               print ISNULL(@Source,'')+', '+ ISNULL(@Description,'') 
                      end 
                      set @i=@i+1 
             end 
             set @SP = null
     
             set @s='Databases("'+DB_NAME()+'").Rules' 
             exec @error = sp_OAGetProperty @SQL, @s, @SP out 
             if @error<>0 
      begin 
                      exec sp_OAGetErrorInfo @SQL, @Source OUT, @Description OUT 
                      print isnull(@Source,'')+', '+ isnull(@Description,'') 
             end
             set @s='Databases("'+DB_NAME()+'").Rules.Count' 
             exec @error = sp_OAGetProperty @SQL, @s, @j out 
             if @error<>0 
      begin 
                      exec sp_OAGetErrorInfo @SQL, @Source OUT, @Description OUT 
                      print isnull(@Source,'')+', '+ isnull(@Description,'') 
             end
             set @i=1 
             while @i<=@j 
      begin 
                      set @s='Item(' +ltrim(str(@i))+ ').Name' 
                      exec @error = sp_OAGetProperty @SP, @s, @l out 
                      if @error<>0 
        begin 
                               exec sp_OAGetErrorInfo @SP, @Source out, @Description out 
                               print ISNULL(@Source,'')+', '+ ISNULL(@Description,'') 
                      end 
                      set @s='Item(' +ltrim(str(@i))+ ').Script(266663,"'+@Path+'",6)' 
                      exec @error = sp_OAMethod @SP, @s, @Description out 
                      print @Description 
                      if @error<>0 
        begin 
                               exec sp_OAGetErrorInfo @SP, @Source out, @Description out 
                               print ISNULL(@Source,'')+', '+ ISNULL(@Description,'') 
                      end 
                      set @i=@i+1 
             end 
             set @SP = null
     
             set @s='Databases("'+DB_NAME()+'").StoredProcedures' 
             exec @error = sp_OAGetProperty @SQL, @s, @SP out 
             if @error<>0 
      begin 
                      exec sp_OAGetErrorInfo @SQL, @Source OUT, @Description OUT 
                      print isnull(@Source,'')+', '+ isnull(@Description,'') 
             end
             set @s='Databases("'+DB_NAME()+'").StoredProcedures.Count' 
             exec @error = sp_OAGetProperty @SQL, @s, @j out 
             if @error<>0 
      begin 
                      exec sp_OAGetErrorInfo @SQL, @Source OUT, @Description OUT 
                      print isnull(@Source,'')+', '+ isnull(@Description,'') 
             end
             set @i=1 
             while @i<=@j 
      begin 
                      set @s='Item(' +LTRIM(STR(@i))+ ').Name' 
                      exec @error = sp_OAGetProperty @SP, @s, @l out 
                      if @error<>0 
        begin 
                               exec sp_OAGetErrorInfo @SP, @Source out, @Description out 
                               print ISNULL(@Source,'')+', '+ ISNULL(@Description,'') 
                      end 
                      if left(@l,3) <> 'dt_' 
        begin
                               set @s='Item(' +LTRIM(STR(@i))+ ').Script(266663,"'+@Path+'",6)' 
                               exec @error = sp_OAMethod @SP, @s, @Description out 
                               print @Description 
                               if @error<>0 
          begin 
                                        exec sp_OAGetErrorInfo @SP, @Source out, @Description out 
                                        print ISNULL(@Source,'')+', '+ ISNULL(@Description,'') 
                               end 
                      end
                      set @i=@i+1 
             end 
             set @SP = null
     
             set @s='Databases("'+DB_NAME()+'").UserDefinedDatatypes' 
             exec @error = sp_OAGetProperty @SQL, @s, @SP out 
             if @error<>0 
      begin 
                      exec sp_OAGetErrorInfo @SQL, @Source OUT, @Description OUT 
                      print isnull(@Source,'')+', '+ isnull(@Description,'') 
             end
             set @s='Databases("'+DB_NAME()+'").UserDefinedDatatypes.Count' 
             exec @error = sp_OAGetProperty @SQL, @s, @j out 
             if @error<>0 
      begin 
                      exec sp_OAGetErrorInfo @SQL, @Source OUT, @Description OUT 
                      print isnull(@Source,'')+', '+ isnull(@Description,'') 
             end
             set @i=1 
             while @i<=@j 
      begin 
                      set @s='Item(' +ltrim(str(@i))+ ').Name' 
                      exec @error = sp_OAGetProperty @SP, @s, @l out 
                      if @error<>0 
        begin 
                               exec sp_OAGetErrorInfo @SP, @Source out, @Description out 
                               print ISNULL(@Source,'')+', '+ ISNULL(@Descripti
    on,'') 
                      end 
                      set @s='Item(' +ltrim(str(@i))+ ').Script(266663,"'+@Path+'",6)' 
                      exec @error = sp_OAMethod @SP, @s, @Description out 
                      print @Description 
                      if @error<>0 
        begin 
                               exec sp_OAGetErrorInfo @SP, @Source out, @Description out 
                               print ISNULL(@Source,'')+', '+ ISNULL(@Description,'') 
                      end 
                      set @i=@i+1 
             end 
             set @SP = null
     
             set @s='Databases("'+DB_NAME()+'").UserDefinedFunctions' 
             exec @error = sp_OAGetProperty @SQL, @s, @SP out
             if @error<>0 
      begin 
                      exec sp_OAGetErrorInfo @SQL, @Source OUT, @Description OUT 
                      print isnull(@Source,'')+', '+ isnull(@Description,'') 
             end
             set @s='Databases("'+DB_NAME()+'").UserDefinedFunctions.Count' 
             exec @error = sp_OAGetProperty @SQL, @s, @j out 
             if @error<>0 
      begin 
                      exec sp_OAGetErrorInfo @SQL, @Source OUT, @Description OUT 
                      print isnull(@Source,'')+', '+ isnull(@Description,'') 
             end
             set @i=1 
             while @i<=@j 
      begin 
                      set @s='Item(' +ltrim(str(@i))+ ').Name' 
                      exec @error = sp_OAGetProperty @SP, @s, @l out -- имя пользовательской функции 
                      if @error<>0 
        begin 
                               exec sp_OAGetErrorInfo @SP, @Source out, @Description out 
                               print ISNULL(@Source,'')+', '+ ISNULL(@Description,'') 
                      end 
                      set @s='Item(' +ltrim(str(@i))+ ').Script(266663,"'+@Path+'",6)' 
                      exec @error = sp_OAMethod @SP, @s, @Description out 
                      print @Description 
                      if @error<>0 
        begin 
                               exec sp_OAGetErrorInfo @SP, @Source out, @Description out 
                               print ISNULL(@Source,'')+', '+ ISNULL(@Description,'') 
                      end 
                      set @i=@i+1 
             end 
             set @SP = null
     
             set @s='Databases("'+DB_NAME()+'").Users' 
             exec @error = sp_OAGetProperty @SQL, @s, @SP out 
             if @error<>0 
      begin 
                      exec sp_OAGetErrorInfo @SQL, @Source OUT, @Description OUT 
                      print isnull(@Source,'')+', '+ isnull(@Description,'') 
             end
             set @s='Databases("'+DB_NAME()+'").Users.Count' 
             exec @error = sp_OAGetProperty @SQL, @s, @j out 
             if @error<>0 
      begin 
                      exec sp_OAGetErrorInfo @SQL, @Source OUT, @Description OUT 
                      print isnull(@Source,'')+', '+ isnull(@Description,'') 
             end
             set @i=1 
             while @i<=@j 
      begin 
                      set @s='Item(' +ltrim(str(@i))+ ').Name' 
                      exec @error = sp_OAGetProperty @SP, @s, @l out -- имя пользователя 
                      if @error<>0 
        begin 
                               exec sp_OAGetErrorInfo @SP, @Source out, @Description out 
                               print ISNULL(@Source,'')+', '+ ISNULL(@Description,'') 
                      end 
                      set @s='Item(' +ltrim(str(@i))+ ').Script(266663,"'+@Path+'",6)' 
                      exec @error = sp_OAMethod @SP, @s, @Description out 
                      print @Description 
                      if @error<>0 
        begin 
                               exec sp_OAGetErrorInfo @SP, @Source out, @Description out 
                               print ISNULL(@Source,'')+', '+ ISNULL(@Description,'') 
                      end 
                      set @i=@i+1 
             end 
     
             set @SP = null
             set @s='Databases("'+DB_NAME()+'").Views' 
             exec @error = sp_OAGetProperty @SQL, @s, @SP out 
             if @error<>0 
      begin 
                      exec sp_OAGetErrorInfo @SQL, @Source OUT, @Description OUT 
                      print isnull(@Source,'')+', '+ isnull(@Description,'') 
             end
             set @s='Databases("'+DB_NAME()+'").Views.Count' 
             exec @error = sp_OAGetProperty @SQL, @s, @j out 
             if @error<>0 
      begin 
                      exec sp_OAGetErrorInfo @SQL, @Source OUT, @Description OUT 
                      print isnull(@Source,'')+', '+ isnull(@Description,'') 
             end
             set @i=1 
             while @i<=@j 
      begin 
                      set @s='Item(' +ltrim(str(@i))+ ').Name' 
                      exec @error = sp_OAGetProperty @SP, @s, @l out 
                      if @error<>0 
        begin 
                               exec sp_OAGetErrorInfo @SP, @Source OUT, @Description OUT 
                               print isnull(@Source,'')+', '+ isnull(@Description,'') 
                      end
                      if left(@l,3) <> 'sys' 
        begin
                               set @s='Item(' +ltrim(str(@i))+ ').Script(266663,"'+@Path+'",6)' 
                               exec @error = sp_OAMethod @SP, @s, @Description out 
                               print @Description 
                               if @error<>0 
          begin 
                                        exec sp_OAGetErrorInfo @SP, @Source OUT, @Descrip
    tion OUT 
                                        print isnull(@Source,'')+', '+ isnull(@Description,'') 
                               end
                      end
                      set @i=@i+1 
             end 
             set @SP = null
     
             set @s='Databases("'+DB_NAME()+'").Tables' 
             exec @error = sp_OAGetProperty @SQL, @s, @SP out 
             if @error<>0 
      begin 
                      exec sp_OAGetErrorInfo @SQL, @Source OUT, @Description OUT 
                      print isnull(@Source,'')+', '+ isnull(@Description,'') 
             end
             set @s='Databases("'+DB_NAME()+'").Tables.Count' 
             exec @error = sp_OAGetProperty @SQL, @s, @j out 
             if @error<>0 
      begin 
                      exec sp_OAGetErrorInfo @SQL, @Source OUT, @Description OUT 
                      print isnull(@Source,'')+', '+ isnull(@Description,'') 
             end
             set @i=1 
             while @i<=@j 
      begin 
                      set @s='Item(' +ltrim(str(@i))+ ').Name' 
                      exec @error = sp_OAGetProperty @SP, @s, @l out 
                      if @error<>0 
        begin 
                               exec sp_OAGetErrorInfo @SP, @Source OUT, @Description OUT 
                               print isnull(@Source,'')+', '+ isnull(@Description,'') 
                      end
                      if left(@l,3) <> 'dt_' and left(@l,3) <> 'sys' 
        begin
                               set @s='Item(' +ltrim(str(@i))+ ').Script(266663,"'+@Path+'",,6)' 
                               exec @error = sp_OAMethod @SP, @s, @Description out 
                               print @Description 
                               if @error<>0 
          begin 
                                        exec sp_OAGetErrorInfo @SP, @Source OUT, @Description OUT 
                                        print isnull(@Source,'')+', '+ isnull(@Description,'') 
                               end
                      end
                      set @i=@i+1 
             end 
             set @SP = null
      exec @error = sp_OADestroy @SQL 
      if @error<>0 
      begin 
               exec sp_OAGetErrorInfo @SQL, @Source OUT, @Description OUT 
               print isnull(@Source,'')+', '+ isnull(@Description,'') 
      end
     

Автор: Vit
