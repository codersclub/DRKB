---
Title: Выделить подстроку (\@result) перед подстрокой (\@substr) в строке (\@str)
Author: Vit
Date: 01.01.2007
---


Выделить подстроку (\@result) перед подстрокой (\@substr) в строке (\@str)
==========================================================================

::: {.date}
01.01.2007
:::

      declare @i int
      declare @result varchar(4000)
      Set @substr=Replace(@substr, '%', '[%]')
      Set @substr=Replace(@substr, '_', '[_]')
      Set @i=Patindex('%'+@substr+'%',  @str)
      if @i>0 
        Set @Result=left(@str,@i-1)
      else 
        Set @Result=@str
      Return @Result

Автор: Vit
