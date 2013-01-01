---
Title: Строка в WIN-кодировке
Author: Sh\@dow
Date: 01.01.2007
---


Строка в WIN-кодировке
======================

::: {.date}
01.01.2007
:::

     -- Возвращает строку в WIN кодировке, на базе WIN_DOS_String()
    -- dbo.DOS_WIN_STRING(expression)
    --    expression - строка в DOS кодировке
    CREATE FUNCTION dbo.DOS_WIN_STRING
    (
      @ds VARCHAR(8000)    -- строка в DOS кодировке
    )
    RETURNS VARCHAR(8000)
    AS  
    BEGIN
        DECLARE    @ss        int,        -- счетчик
                @ws        varchar(8000),    -- WIN строка
                @ls        int,        -- длина обр. строки
                @os        int        -- код 1-го обраб-го символа
        SET @ws=''
        SET @ls=LEN(@ds)
        SET @ss=0
        WHILE @ss<@ls
        BEGIN
            SET @os=ASCII(SUBSTRING(@ds,1,1))
            SET @ws=@ws+CASE
                WHEN @os>=128 AND @os<=180 THEN  CHAR(@os+64)-- 192.239
                WHEN @os>=224 AND @os<=239 THEN  CHAR(@os+16)-- 240.256
                WHEN @os=240 THEN  CHAR(168) --Ё
                WHEN @os=241 THEN  CHAR(184) --ё
                ELSE CHAR(@os)
     
        END                        
            SET @ss=@ss+1
            SET @ds=SUBSTRING(@ds,2,LEN(@ds)-1)
        END
        RETURN @ws
    END 

Автор: Sh\@dow

Взято с Vingrad.ru <https://forum.vingrad.ru>
