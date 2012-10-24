<h1>Строка в WIN-кодировке</h1>
<div class="date">01.01.2007</div>

<div class="author">Автор: Sh@dow</div>

<pre>
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
    WHILE @ss&lt;@ls
    BEGIN
        SET @os=ASCII(SUBSTRING(@ds,1,1))
        SET @ws=@ws+CASE
            WHEN @os&gt;=128 AND @os&lt;=180 THEN  CHAR(@os+64)-- 192.239
            WHEN @os&gt;=224 AND @os&lt;=239 THEN  CHAR(@os+16)-- 240.256
            WHEN @os=240 THEN  CHAR(168) --Ё
            WHEN @os=241 THEN  CHAR(184) --ё
            ELSE CHAR(@os)
 
    END                        
        SET @ss=@ss+1
        SET @ds=SUBSTRING(@ds,2,LEN(@ds)-1)
    END
    RETURN @ws
END 
</pre>

<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
