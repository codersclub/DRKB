<h1>Вернуть строку в DOS-кодировке</h1>
<div class="date">01.01.2007</div>


<pre>
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
    WHILE @ss&lt;@ls
    BEGIN
        SET @os=ASCII(SUBSTRING(@ws,1,1))
        SET @ds=@ds+CASE
            WHEN @os&gt;=192 AND @os&lt;=239 THEN  CHAR(@os-64)-- 128.180
            WHEN @os&gt;=240 AND @os&lt;=256 THEN  CHAR(@os-16)-- 224.239
            WHEN @os=168 THEN  CHAR(240) --Ё
            WHEN @os=184 THEN  CHAR(241) --ё
            ELSE CHAR(@os)
        END                        
        SET @ss=@ss+1
        SET @ws=SUBSTRING(@ws,2,LEN(@ws)-1)
    END
    RETURN @ds
END 
</pre>
<p class="author">Автор: Sh@dow</p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
