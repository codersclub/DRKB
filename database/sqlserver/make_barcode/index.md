---
Title: Сформировать штрихкод
Author: Sh@dow
Date: 01.01.2007
Source: Vingrad.ru <https://forum.vingrad.ru>
---


Сформировать штрихкод
=====================

     /*возвращает строку для формирования штрихкода со стартовыми, 
    стоповыми символами и контрольной суммой по кодировке code128 
    подсистемы B на входе строка, состоящая из цифр (если 
    какой-то другой символ, то он обрабатывается как 0) */
     
    CREATE FUNCTION dbo.getcode128
    (@string as varchar(50) )
    RETURNS varchar(50)
     AS  
    BEGIN 
     
    DECLARE @position int, @stringnew varchar(50), @sum int, @codestart int, @codestop int
    SET @position = 1
    SET @stringnew = ''
    set @codestart=104
    set @codestop=106
    set @sum=@codestart
     
    WHILE @position <= DATALENGTH(@string)
       BEGIN
       SELECT @stringnew=@stringnew+SUBSTRING(@string, @position, 1), 
              @sum=@sum+@position*
              (case when SUBSTRING(@string, @position, 1)='1' then 17 else
              case when SUBSTRING(@string, @position, 1)='2' then 18 else
              case when SUBSTRING(@string, @position, 1)='3' then 19 else
              case when SUBSTRING(@string, @position, 1)='4' then 20 else
              case when SUBSTRING(@string, @position, 1)='5' then 21 else
              case when SUBSTRING(@string, @position, 1)='6' then 22 else
              case when SUBSTRING(@string, @position, 1)='7' then 23 else
              case when SUBSTRING(@string, @position, 1)='8' then 24 else
              case when SUBSTRING(@string, @position, 1)='9' then 25 else
              16
              end
              end
              end
              end
              end
              end
              end
              end
              end)
       SET @position = @position + 1
       END
     
    set @stringnew=dbo.code128toWin(@codestart)+@stringnew+dbo.code128toWin(@sum-@sum/103*103)+dbo.code128toWin(@codestop)
     
    return (@stringnew)
     
    END 
