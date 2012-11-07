<h1>СОМ хранилища: подпольная файловая система</h1>
<div class="date">01.01.2007</div>

<p>Перед многими программистами рано или поздно постает вопрос: "В каком формате хранить данные своей программы". Хорошо, если это тип данных с фиксированной длинной, а если надо сохранить разнородные данные, да еще чтоб в одном файле(чтоб потом не разбираться с десятком другим файлов с данными)... Тут на помощь приходить сама Windows(жуть какую сказал: "Windows... и на помощь") с технологией структурированного хранилища данных.</p>
<p>Определения</p>
<p>Структурированные хранилища данных - это файлы особой "самодокументированной" структуры, в которых могут мирно уживаться разнородные данные (от простого текста, до фильмов, архивов и... программ). Так как эта технология есть неотъемлемой частью Windows, то доступ к ней возможен из любого средства программирования, которое поддерживает технологию COM. Одним из таких приложений является и Delphi, на основе которого будет описана технология доступа к структурированным хранилищам данных.</p>

<p>Структура хранилищ</p>

<p>Как уже было сказано, COM хранилища - файлы особой структуры (рис.1) и напоминают иерархическую файловую систему. Так в них есть корневое хранилище (Root Entry) в котором могут содержаться как отдельные потоки("файлы"), так и хранилища второго уровня("каталоги"), в них в свою очередь хранилища третьего уровня и т.д. Управление каждым хранилищем и потоком осуществляется посредством отдельного экземпляра интерфейса: IStorage - для хранилищ и IStream - для потоков. А теперь рассмотрим конкретнее некоторые операции над ними.</p>

<p>Создание и открытие хранилищ</p>

<p>Создание структурированных хранилищ осуществляется с использованием функции StgCreateDocFile, из модуля ActiveX.pas. Синтаксис этой функции выгладит таким образом:<br>

<pre class="delphi">function StgCreateDocfile(pwcsName: POleStr; grfMode: Longint; reserved: Longint; out stgOpen: IStorage): HResult; stdcall;</pre>
<p>где:<br>
pwcsName - название хранилища(т.е. название файла).<br>
grfMode - флаги доступа(комбинация значений STGM_*).<br>
reserved - он и в Африке RESERVED.<br>
StgOpen - ссылка на интерфейс IStorage нашего главного хранилища. Результат функции как всегда транслируем в исключения Delphi посредством OleCheck.
</p>

<p>Для открытия хранилища используется функция StgOpenStorage:<br>
<pre class="delphi">function StgOpenStorage(pwcsName: POleStr; stgPriority: IStorage; grfMode: Longint; snbExclude: TSNB; reserved: Longint; out stgOpen: IStorage): HResult; stdcall;
</pre>
<p>неизвестный параметр - stgPriority указывает на ранее открытый экземпляр главного хранилища (почти всегда nil).</p>
<p>Когда хранилище открыто (запись данных)...</p>
<p>Рассмотрим более подробно методы интерфейса IStorage.</p>

<p>Создание потока - IStorage.CreateStream.</p>
<pre class="delphi">function CreateStream(pwcsName: POleStr; grfMode: Longint; reserved1: Longint;reserved2: Longint; out stm: IStream): HResult; stdcall;
</pre>
<p>параметры:<br>
pwcsName - название потока.<br>
grfMode - Флаги доступа<br>
reserved1, reserved2 - соответственно.<br>
stm - указатель на созданный поток.
</p>

<p>Открытие потока - IStorage.OpenStream.</p>

<pre class="delphi">function OpenStream(pwcsName: POleStr; reserved1: Pointer; grfMode: Longint;reserved2: Longint; out stm: IStream): HResult; stdcall;
</pre>

<p>параметры:<br>
pwcsName - название потока.<br>
reserved1 - nil<br>
grfMode - флаги доступа<br>
reserved2 - 0<br>
stm - указатель на открытый поток.
</p>

<p>Создание подхранилища - IStorage.CreateStorage.</p>

<pre class="delphi">function CreateStorage(pwcsName: POleStr; grfMode: Longint; dwStgFmt: Longint; reserved2: Longint; out stg: IStorage): HResult;stdcall;
</pre>

<p>Открытие подхранилища - IStorage.OpenStorage.</p>

<pre class="delphi">
function OpenStorage(pwcsName: POleStr; const stgPriority: IStorage; grfMode: Longint; snbExclude: TSNB; reserved: Longint;out stg: IStorage): HResult; stdcall;
</pre>

<p>Теперь мы можем приступить к чтению(записи) данных из(в) потоков посредством интерфейсов IStream. Тут можно заметить до боли знакомые (для Дельфийцев) методы работы с потоками:Read,Write, Seek, SetSize, CopyTo... а если так, то почему бы не перевести их в более простую и понятную(по крайней мере для меня) объектную форму. Для этого воспользуемся наработками Borland собранными в модуле AxCtrls.pas, точнее классом TOleStream, который интерпретирует вызовы методов интерфейса IStream в соответствущие методы класса TStream.</p>
<p>А для того чтоб не быть пустословным - приведу небольшой примерчик:</p>

<pre class="delphi">
Implementation
 Uses ActiveX,AxCtrls,ComObj;
{$R *.dfm}
procedure TForm1.Button1Click(Sender: TObject);
var Stg:IStorage;
    Strm:IStream;
    OS:TOleStream;
    S:String;
begin
 OleCheck(StgCreateDocfile('Testing.stg',STGM_READWRITE or STGM_SHARE_EXCLUSIVE ,0,Stg));
 OleCheck(Stg.CreateStream('Testing',STGM_READWRITE or STGM_SHARE_EXCLUSIVE,0,0,Strm));
 OS:=TOleStream.Create(Strm);
 try
  S:='This is the test';
  OS.WriteBuffer(Pointer(S)^,Length(S));
 finally
  OS.free;
  Strm:=nil;
  Stg:=nil;
 end;
end;
 
end.
</pre>

<p>В этом фрагменте мы создаем новое хранилище с одним потоком в который записываем строку S. Естественно, ничто нам не мешает вместо:</p>

<pre class="delphi">S:='This is the test';
OS.WriteBuffer(Pointer(S)^,Length(S));
</pre>

<p>Написать например:</p>

<pre class="delphi">Image1.Picture.Bitmap.SaveToStream(OS);
</pre>

<p>и тем самым записать в поток "Testing" изображение(вот она... "универсальная мусоросвалка").</p>
<p>Теперь ненамного отвлечемся от Delphi и посмотрим на наш файл с точки зрения, скажем, Far (или VC)... Посмотрели? А теперь откройте там же любой текстовый документ созданных в Word'е. Как видим структура та же что и в нашем файле. То же можно сказать и о Excel. Но как проверить на прибегая к помощи notepad какой файл является хранилищем, а какой нет? Для этого все в том же модуле ActiveX.pas предусмотрена функция StgIsStorageFile:</p>

<pre class="delphi">function StgIsStorageFile(pwcsName: POleStr): HResult; stdcall;</pre>

<p>которая принимает значение S_OK( 0 ) - если файл является структурированным хранилищем данных и S_FALSE ( 1 ) - если файл не есть им, кроме того эта функция может принимать значения: STG_E_INVALIDFILENAME и STG_E_FILENOTFOUND соответственно если имя файла задано неправильно и если файла с таким именем не существует.</p>

<p>Чтение</p>

<p>Чтение данных из хранилища производится также как и чтение из стандартного потока Delphi. Все, что для этого требуется - это создать объект наследник TOleStream с использованием возвращаемого функцией IStorage.OpenStorage значения stm:</p>

<pre class="delphi">
procedure TForm1.Button2Click(Sender: TObject);
var Stg:IStorage;
    Strm:IStream;
    OS:TOleStream;
    S:String;
begin
 OleCheck(StgOpenStorage('Testing.stg',nil,STGM_READWRITE or STGM_SHARE_EXCLUSIVE, nil,0,Stg));
 OleCheck(Stg.OpenStream('Testing',0,STGM_READWRITE or STGM_SHARE_EXCLUSIVE,0,Strm));
 OS:=TOleStream.Create(Strm);
 try
  SetLength(S,OS.Size);
  OS.ReadBuffer(Pointer(S)^,OS.Size);
  Edit1.Text:=S;
 finally
  OS.free;
  Strm:=nil;
  Stg:=nil;
 end;
end;
</pre>

<p>после выполнения этого кода мы в Edit1 увидим ранее записанное нами:"This is the test".</p>
<p>Последовательное перемещение по структурам хранилища</p>
<p>Хорошо... мы создали хранилище, записали в него данные и прочитали их. Но мы это сделали зная имя потока в котором записаны наши данные. Но как быть, если мы не знаем структуры хранилища? Для этого в Интерфейсе IStorage предусмотрен механизм перечисления его элементов, который содержится в интерфейсе IEnumStatStg, указатель на который возвращается функцией IStorage.EnumElements:</p>

<pre class="delphi">function EnumElements(reserved1: Longint; reserved2: Pointer; reserved3: Longint;out enm: IEnumStatStg): HResult; stdcall;
</pre>

<p>употребление этой функции происходит таким образом:

<pre class="delphi">OleCheck(Stg.EnumElements(0,nil,0,Enum));</pre>

<p>После этого используем только методы интерфейса IEnumStatStg:</p>

<pre class="delphi">
Next(celt:Longint; out elt; pceltFetched: PLongint): HResult; stdcall;- выборка информации следующего елемента хранилища
Skip(celt:longint):HResult;stdcall; - пропуск количества елементов заданных в celt
Reset:HResult;stdcall; - Reset - он и в Африке Reset. Clone(out enm:IEnumStatStg):HResult;stdcall; - Клонирование интерфейса
</pre>

<p>На данный момент для нас самым важным из этих методов есть метод Next:</p>

<pre class="delphi">Next(celt:Longint; out elt; pceltFetched: PLongint): HResult; stdcall;</pre>

<p>Который принимает следующие параметры:<br>
Celt - количество елементов структуры, которое будет извлечено при его вызове.<br>
Elt - Масив приемник елементов типа TStatStg.<br>
PceltFetched - указатель на переменную куда будет записано действительное количество извлеченных елементов.
</p>

<p>Для примера воспользуемся любым doc файлом и перечислим его потоки(и подхранилища если они есть):</p>

<pre class="delphi">
procedure TForm1.Button2Click(Sender: TObject);
var Stg:IStorage;
    Enum:IEnumStatStg;
    Data:TStatStg;
begin
 OleCheck(StgOpenStorage('D:\1.doc',nil,STGM_READWRITE or STGM_SHARE_EXCLUSIVE,nil,0,Stg));
 OleCheck(Stg.EnumElements(0,nil,0,Enum));
 try
  While Enum.Next(1,Data,nil)=S_Ok do
   ListBox1.Items.Add(Format('%s(%d)',[Data.pwcsName,Data.cbSize]));
 finally
  Stg:=nil;
  Enum:=nil;
 end;
end;
</pre>

<p>кроме cbSize структура TStatStg содержит такие поля:<br>
pwcsName: POleStr; - Название потока или хранилища<br>
dwType: Longint; - Тип елемента (флаги типа STGTY_*)<br>
cbSize: Largeint; - Размер конкретного елемента<br>
mtime: TFileTime; - Дата последней модификации<br>
ctime: TFileTime; - Дата создания<br>
atime: TFileTime; - Дата последнего обращения<br>
grfMode: Longint; - Флаг доступа<br>
grfLocksSupported: Longint; - Не используется в хранилищах<br>
clsid: TCLSID; - Идентификатор класса хранилища<br>
grfStateBits: Longint; - Статусные биты<br>
reserved: Longint; - Зарезервирован
</p>

<p>Создание дополнительных хранилищ</p>
<p>Для создания дополнительных хранилищ главного хранилища используется метод интерфейса IStorage под названием CreateStorage:</p>

<pre class="delphi">function CreateStorage(pwcsName: POleStr; grfMode: Longint; dwStgFmt: Longint; reserved2: Longint; out stg: IStorage): HResult;stdcall;</pre>

<p>параметры:</p>
<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>pwcsName - название подхранилища.</td></tr></table></div>
<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>grfMode - флаги доступа</td></tr></table></div>
<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>dwStgFmt,reserved2 - зарезервированы (принимают значение 0).</td></tr></table></div>
<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>stg - указатель на интерфейс содержащий ссылку на подхранилище.</td></tr></table></div>
<p>После вызова этого метода посредством переменной stg вам стают доступны методы по использованию подхранилища:</p>
<pre class="delphi">
procedure TForm1.Button2Click(Sender: TObject);
var Stg,Temp:IStorage;
    Str:IStream;
    OS:TOleStream;
    S:String;
begin
 OleCheck(StgOpenStorage('Testing.stg',nil,STGM_READWRITE or STGM_SHARE_EXCLUSIVE,nil,0,Stg));
 OleCheck(Stg.CreateStorage('SubStorage',STGM_READWRITE or STGM_SHARE_EXCLUSIVE,0,0,Temp));
 OleCheck(Temp.CreateStream('SubTesting',STGM_READWRITE or STGM_SHARE_EXCLUSIVE,0,0,Str));
 try
  OS:=TOleStream.Create(Str);
  S:='SubTesting the stream';
  OS.WriteBuffer(Pointer(S)^,Length(S));
 finally
  Temp:=nil;
  Stg:=nil;
 end;
end;
</pre>

<p>после проделанной операции в файле 'Testing.stg' появится новое подхранилище "SubStorage" c одним потоком "SubTesting" в котором записана строка "SubTesting the stream".</p>
<p>Чтение из такого подхранилища может быть реализовано следующим образом:</p>

<pre class="delphi">
procedure TForm1.Button2Click(Sender: TObject);
var Stg,Temp:IStorage;
    Str:IStream;
    OS:TOleStream;
    S:String;
begin
 OleCheck(StgOpenStorage('Testing.stg',nil,STGM_READWRITE or STGM_SHARE_EXCLUSIVE,nil,0,Stg));
 OleCheck(Stg.OpenStorage('SubStorage',nil,STGM_READWRITE or STGM_SHARE_EXCLUSIVE,nil,0,Temp));
 OleCheck(Temp.OpenStream('SubTesting',nil,STGM_READWRITE or STGM_SHARE_EXCLUSIVE,0,Str));
 try
  OS:=TOleStream.Create(Str);
  SetLength(S,OS.Size);
  OS.ReadBuffer(Pointer(S)^,OS.Size);
  Edit1.Text:=S;
 finally
  Temp:=nil;
  Stg:=nil;
 end;
end;
</pre>

<p>Дополнительные возможности</p>
<p>К дополнительным возможностям можно отнести наличие таких методов в интерфейсе IStorage:<br>
<p>function CopyTo(ciidExclude: Longint; rgiidExclude: PIID; snbExclude: TSNB; const stgDest: IStorage): HResult; stdcall;</p>
<p>Копирование содержимого хранилища в другое хранилище:<br>
<p>function MoveElementTo(pwcsName: POleStr; const stgDest: IStorage;pwcsNewName: POleStr; grfFlags: Longint): HResult; stdcall;</p>
<p>Перемещение хранилища в другое хранилище:<br>
<p>function Commit(grfCommitFlags: Longint): HResult; stdcall;</p>
<p>Подтверждение изменетий внесенных в хранилище. Используется совместно с флагом STGM_TRANSACTED при открытии или создании хранилища:<br>
<p>function Revert: HResult; stdcall;</p>
<p>Отмена изменений вносимых в хранилище. Используется совместно с флагом STGM_TRANSACTED при открытии или создании хранилища:<br>
<p>function DestroyElement(pwcsName: POleStr): HResult; stdcall;</p>
<p>Удаление элемента из хранилища:<br>
<p>function RenameElement(pwcsOldName: POleStr; pwcsNewName: POleStr): HResult; stdcall;</p>
<p>Переименование элемента хранилища:<br>
<p>function SetElementTimes(pwcsName: POleStr; const ctime: TFileTime; const atime: TFileTime; const mtime: TFileTime): HResult; stdcall;</p>
<p>Обновление информации о дате создания, модификации и последнего обращения к элементу хранилища.</p>
<p>Сжатие хранилищ</p>
<p>Как и файловая система, ее аналог - структурированные хранилища данных подвержены фрагментации. Они неспособности "экономично" заполнять освободившееся пространство от удаленных элементов. А самое главное, что в них не предусмотрен механизм автоматического сжатия данных и освобождения незанятых ресурсов диска. Но на каждый фрагмент есть свой "дефрагмент". Так сжать хранилище можно воспользовавшись методом интерфейса IStorage под названием CopyTo:<br>
function CopyTo(ciidExclude: Longint; rgiidExclude: PIID; snbExclude: TSNB; const stgDest: IStorage): HResult; stdcall;<br>
<p>при этом все нужные данные переписываются в новое хранилище, а ненужные (т.е. уже удаленные) исчезают навеки. Примером для такого сжатия может служить код:</p>
<pre class="delphi">
procedure TForm1.Button2Click(Sender: TObject);
var Stg,Temp:IStorage;
    Enum:IEnumStatStg;
    Data:TStatStg;
begin
 OleCheck(StgOpenStorage('D:\1.doc',nil,STGM_READ or STGM_SHARE_EXCLUSIVE,nil,0,Stg));
 OleCheck(StgCreateDocFile('D:\1c.doc',STGM_READWRITE or STGM_SHARE_EXCLUSIVE,0,Temp));
 try
 Stg.CopyTo(0,nil,nil,Temp);
 finally
  Temp:=nil;
  Stg:=nil;
 end;
end;
</pre>
</p>
<p>конечно такой метод эффективен если данный обрабатываются непосредственно в хранилище, а не действует принцип: "Все прочитал... удалил... изменил... написал наново".</p>
<table cellspacing="0" cellpadding="0" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td colspan="2" >Флаги доступа к хранилищам и потокам</p>
</td>
<td rowspan="10" width="1" style="width: 1px; border: solid 1px #000000;"><br>
</td>
</tr>
<tr>
<td><p>STGM_DIRECT</p>
</td>
<td><p>Каждое изменение содержания сразу же записывается в файл</p>
</td>
</tr>
<tr>
<td><p>STGM_TRANSACTED</p>
</td>
<td><p>Изменения записываются в буфер, а потом по команде Commit в файл. Команда Revert отменяет изменения</p>
</td>
</tr>
<tr>
<td><p>STGM_SIMPLE</p>
</td>
<td><p>Упрощенный вариант хранения данных:</p>
<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>Нет поддержки подхранилищ</td></tr></table></div>
<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>Нельзя повторно открыть поток для записи</td></tr></table></div>
<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>Все потоки имеют длину не меньше 4096</td></tr></table></div>
<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>Поддерживается ограниченное количество методов интерфейсов IStorage и IStream.</p>
</td></tr></table></div>
</td>
</tr>
<tr>
<td><p>STGM_READ</p>
</td>
<td><p>Открытие только для чтения</p>
</td>
</tr>
<tr>
<td><p>STGM_WRITE</p>
</td>
<td><p>То же для записи</p>
</td>
</tr>
<tr>
<td><p>STGM_READWRITE</p>
</td>
<td><p>Чтение и запись</p>
</td>
</tr>
<tr>
<td><p>STGM_SHARE_DENY_READ</p>
</td>
<td><p>Запрет параллельного чтения</p>
</td>
</tr>
<tr>
<td><p>STGM_SHARE_DENY_WRITE</p>
</td>
<td><p>Запрет параллельной записи</p>
</td>
</tr>
<tr>
<td><p>STGM_SHARE_EXCLUSIVE</p>
</td>
<td><p>Полный запрет на параллельное использование файла</p>
</td>
</tr>
<tr>
<td><p>STGM_PRIORITY</p>
</td>
<td><p>Блокирует возможность параллельного внесения изменений в файл по команде Commit</p>
</td>
<td>
</td>
</tr>
<tr>
<td><p>STGM_DELETEONRELEASE</p>
</td>
<td><p>Файл автоматически стирается при освобождении интерфейса. Используется для временных файлов</p>
</td>
<td>
</td>
</tr>
<tr>
<td><p>STGM_CREATE</p>
</td>
<td><p>Стирает существующий файл с тем же именем</p>
</td>
<td>
</td>
</tr>
<tr>
<td><p>STGM_CONVERT</p>
</td>
<td><p>Создает новый файл в поток CONTENTS которого заносит данные из существующего файла с тем же именем , если такой существует</p>
</td>
<td>
</td>
</tr>
<tr>
<td><p>STGM_FAILSAFE</p>
</td>
<td><p>Если существует файл с таким же именем - возвращает значение STG_E_FILEALREADYEXISTS</p>
</td>
<td>
</td>
</tr>
<tr>
<td><p>STGM_NOSCRATCH</p>
</td>
<td><p>При установленном флаге STGM_TRANSACTED вместо внешнего буфера используется незадействованное пространство в самом файле. Более эффективное использование ресурсов компьютера</p>
</td>
<td>
<p></p>
</td>
</tr>
</table>
<p></p>
<div class="author">Автор: Михаил Продан</div>
<p><a href="https://tdelphi.spb.ru" target="_blank">https://tdelphi.spb.ru</a></p>
