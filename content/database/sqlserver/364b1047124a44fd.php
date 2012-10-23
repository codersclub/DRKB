<h1>Запись файла</h1>
<div class="date">01.01.2007</div>


<p>Пример простейшей процедуры на Transact-SQL, создающей файл и</p>
<p>записывающий в неё что нибудь. Для этого используется WindowsScripting.</p>
<p>WindowsScripting - если грубо - это набор OLE-объектов, которые можно использовать для целей управления системой. Их удобно использовать там, где невозможно достучаться к функциям Win32 API напрямую, например, в SQL Server-е.</p>
<p>Ниже приводится исходник на Transact-SQL с комментариями, как это сделать</p>
<p>Надеюсь, что он достаточно хорошо прокомментирован.</p>
<pre>
DECLARE @FileName varchar(255), 
----текст, который необходимо записать в файл---
@sFileText varchar(8000),
----директория файла---
@sFileDir varchar(8000),
----имя файла----------
@sFileName varchar(8000),
@FS int, 
@FileID int, 
@hr int,
@OLEResult int, 
@source varchar(30), 
@desc varchar (200),
@bFolder bit
--функция sp_OACreate создаёт OLE объект 'Scripting.FileSystemObject'----
EXECUTE @OLEResult = sp_OACreate 'Scripting.FileSystemObject', @FS OUTPUT
--обязательно обработать ошибочные ситуации---
IF @OLEResult &lt;&gt; 0 
BEGIN
GOTO Error_Handler
END
select @sFileDir = 'c:\'
select @sFileName = @sFileDir + '123.log'
/*
у Scripting.FileSystemObject есть много интересных методов для работы с файлами 
и директориями, подробнее их можно подсмотреть, например, в MSDN.
*/
--проверить - существует ли заданная директория, для этого вызовем функцию 'FolderExists'
--ранее созданого OLE объекта---
execute @OLEResult = sp_OAMethod @FS,'FolderExists',@bFolder OUT, @sFileDir
IF @OLEResult &lt;&gt; 0 Or @bFolder = 0
BEGIN
  --а если не существует - то создать её----
  execute @OLEResult = sp_OAMethod @FS,'CreateFolder',@bFolder OUT, @sFileDir
  IF @OLEResult &lt;&gt; 0 And @bFolder = 0
  BEGIN
 &nbsp;&nbsp; GOTO Error_Handler&nbsp;&nbsp;&nbsp; 
  END
END
--создать файл---
execute @OLEResult = sp_OAMethod @FS,'CreateTextFile',@FileID OUTPUT,@FileName
IF @OLEResult &lt;&gt; 0 
BEGIN
  GOTO Error_Handler
END
--создадим строку, которую будем записывать в файл---
set @sFileText = 'Hello first file!' + char(0)
-----------------записать строку в файл---
execute @OLEResult = sp_OAMethod @FileID, 'WriteLine', NULL, @sFileText
IF @OLEResult &lt;&gt; 0 
BEGIN
  GOTO Error_Handler
END
goto Done
Error_Handler:&nbsp; --обработаем ошибку---
EXEC @hr = sp_OAGetErrorInfo null, @source OUT, @desc OUT
Done:&nbsp;&nbsp;&nbsp; 
--очистим за собой всяческий OLE-мусор----
EXECUTE @OLEResult = sp_OADestroy @FileID
EXECUTE @OLEResult = sp_OADestr 
</pre>

<div class="author">Автор: AQL</div>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
