---
Title: Вернуть строку в DOS-кодировке
Author: Sh@dow
Date: 01.01.2007
Source: Vingrad.ru <https://forum.vingrad.ru>
---


Вернуть строку в DOS-кодировке
==============================

    -- Возвращает строку в DOS кодировке 
    -- dbo.WIN_DOS_STRING(expression)
    --    expression - строка в WIN кодировке
    CREATE FUNCTION dbo.WIN_DOS_STRING
    (
      @ws VARCHAR(8000)    -- строка
    )
    RETURNS VARCHAR(8000)
    AS  
    BEGIN
        DECLARE    @ss        int,                -- счетчик
                    @ds        varchar(8000),    -- DOS строка
                    @ls        int,                -- длина обр. строки
                    @os        int                -- код 1-го обраб-го символа
        SET @ds=''
        SET @ls=LEN(@ws)
        SET @ss=0
        WHILE @ss<@ls
        BEGIN
            SET @os=ASCII(SUBSTRING(@ws,1,1))
            SET @ds=@ds+CASE
                WHEN @os>=192 AND @os<=239 THEN  CHAR(@os-64)-- 128.180
                WHEN @os>=240 AND @os<=256 THEN  CHAR(@os-16)-- 224.239
                WHEN @os=168 THEN  CHAR(240) --Ё
                WHEN @os=184 THEN  CHAR(241) --ё
                ELSE CHAR(@os)
            END                        
            SET @ss=@ss+1
            SET @ws=SUBSTRING(@ws,2,LEN(@ws)-1)
        END
        RETURN @ds
    END 

