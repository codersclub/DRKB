---
Title: Выделить подстроку (@result) после подстроки (@substr) в строке (@str)
Author: Vit
Date: 01.01.2007
---


Выделить подстроку (@result) после подстроки (@substr) в строке (@str)
=========================================================================

      declare @i int
      declare @result varchar(4000)
      Set @substr=Replace(@substr, '%', '[%]')
      Set @substr=Replace(@substr, '_', '[_]')
      Set @i=Patindex('%'+@substr+'%',  @str)
      if @i>0 
        Set @Result=right(@str,len(@str)-@i)
      else 
        Set @Result=@str
      Return @Result
