<h1>Справочник по функциям работы с файлами</h1>
<div class="date">01.01.2007</div>


<p>function File0pen(const FileName: string; Mode: Word) : Integer;        Открывает существующий FileName файл в режиме Mode  Значение, возвращаемое в случае успеха, &#8212; дескриптор открытого файла. В противном случае &#8212; код ошибки DOS.</p>
<p>function FileCreate(const PileName: string): Integer;        Создает файл с именем FileName. Возвращает то же, что и FileOpen.</p>
<p>function FileRead(Handle: Integer; var Buffer; Count: Longint): Longint;        Считывает из файла с дескриптором Handle Count байт в буфер Buffer. Возвращает число реально прочитанных байт или -1 при ошибке.</p>
<p>function FileWrite(Handle: Integer; const Buffer);        Записывает в файл с дескриптором Handle Count байт из буфера Buffer. Возвращает число реально записанных байт или -1 при ошибке.</p>

<p>function FileSeek(Handle: Integer; Offset: Longint; Origin: Integer): Longint;        Позиционирует файл с дескриптором Handle в новое положение. При Origin = 1,2,3 положение смещается на Offset байт от начала файла, текущей позиции и конца файла соответственно. Возвращает новое положение или -1 при ошибке.</p>
<p>procedure FileClose(Handle:Integer)        Закрывает файл с дескриптором Handle.</p>

<p>function FileAge(const FileName:String)        Возвращает значения даты и времени создания файла или -1, если файл не существует.</p>

<p>function FileExists(const        FileName:String):boolean; Возвращает True если файл FileName существует к найден.</p>
<p>function FindFirst(const Path: string; Attr: Integer; var SearchRec: TSearchRec): Integer;        Ищет первый файл, удовлетворяющий маске поиска, заданной в Path и с атрибутами Attr. В случае успеха заполняет запись SearchRec (см. примеч. 3) и возвращает 0, иначе возвращает код ошибки DOS.</p>
<p>function FindNext(var SearchRec: TSearchRec): Integer;        Продолжает процесс поиска файлов, удовлетворяющих маске поиска. Параметр SearchRec должен быть заполнен при помощи FindFirst. Возвращает 0, если очередной файл найден, или код ошибки DOS. Изменяет SearchRec.</p>
<p>procedure FindClose(var SearchRec: TSearchRec);         Завершает процесс поиска файлов, удовлетворяющих маске поиска.</p>
<p>function FileQetDate(Handle: Integer) : Longint;        Возвращает время создания файла с дескриптором Handle (в формате DOS) или -1, если дескриптор недействителен.</p>
<p>procedure FileSetDate(Handle: Integer;)        Устанавливает время создания файла с дескриптором Handle (в формате DOS).</p>
<p>function FileGetAttr(const FileName: string): Integer;        Возвращает атрибуты (см. примеч. 2) файла с именем FileName или код ошибки DOS, если файл не найден.</p>
<p>function FileSetAttrtconst FileName: string; Attr:        Устанавливает атрибуты файла с именем FileName.</p>
<p>function DeleteFile(const  FileName:String)        Уничтожает файл с именем FileName и в случае успеха возвращает True.</p>
<p>function RenameFile(const OldName, NewName: string): Boolean;        Переименовывает файл с именем OldName в NewName и возвращает True в случае успеха.</p>
<p></p>
<p>function ChangeFileExt(const FileName, Extension: string): string;        Изменяет расширение в имени файла FileName на Extension и возвращает новое значение FileName. Имя файла не изменяется.</p>
<p>function ExtractFilePath(const FileName: string): string;        Извлекает из строки с полным именем файла FileName часть, содержащую путь к нему.</p>

<p>function ExtractFileName(const FileName: string): string;        Извлекает из строки с полным именем файла FileName часть, содержащую его имя и расширение.</p>

<p>function ExtractFileExt(const FileName: string): string;        Извлекает из строки с полным именем файла FileName часть, содержащую его расширение.</p>
<p>function ExpandFileName(const FileName: string): string;        Возвращает полное имя файла FileName, добавляя при необходимости путь к нему и переводя все символы в верхний регистр.</p>
<p>function FileSearch(const Name, DirList: string): strings-        Производит поиск файла с именем Name в группе каталогов, заданных параметром DirList. Имена каталогов должны отделяться друг от друга точкой с запятой. Возвращает в случае успеха полное имя файла или пустую строку, если файл не найден.</p>
<p>function DiskFree(Drive: Byte): Longint;        Возвращает количество в байтах свободного места на заданном диске. Значение параметра Drive: 0 &#8212; для текущего диска, 1 &#8212; для А, 2 &#8212; для В и т. д. Если параметр неверен, функция возвращает -1.</p>

<p>function DiskSize(Drive: Byte): Longint;        Возвращает размер диска Drive в байтах. Параметр Drive означает то же, что и в DiskFree.</p>

<p>function FileDateToDateTime(FileDate: Longint): TDateTime;        Преобразует дату и время в формате DOS в принятый в Delphi формат TDateTime.</p>
<p>function DateTimeToFileDate(DateTime: TDateTime): Longint;        Преобразует дату и время из формата TDateTime в формат DOS.</p>
