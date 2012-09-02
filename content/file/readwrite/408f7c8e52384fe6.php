<h1>Отображение файлов в память</h1>
<div class="date">01.01.2007</div>


<p>Отображение файла в память <br>
<p>Для работы с файлом динамической подкачки страниц виртуальной памяти в windows 32 используется механизм отображения файлов в адресное пространство приложения. Соответствующие функции api доступны любому приложению и могут применяться к любому файлу (кстати, таким способом загружаются в адресное пространство процесса исполняемые файлы и dll). В результате отображения приложение может работать с файловыми данными как с размещенными в динамической памяти. В большинстве случаев такая возможность не только повышает скорость работы с данными, но и предоставляет программисту уникальные средства обработки сразу всех записей файла. Например, он может с помощью единственного оператора проверить, входит ли заданный образец поиска в какую-либо строку текстового файла. </p>
<p>Отображение файла осуществляется в три приема. Вначале файл создается обращением к функции: </p>
<p>function filecreate (filename: string): integer; <br>
<p>или открывается с помощью: </p>
<p>function fileopen (const filename: string; mode: longword): integer; <br>
<p>В обеих функциях filename &#8212; имя файла, возможно, с маршрутом доступа. Параметр mode определяет режим доступа к файлу и может принимать одно из следующих значений: fmopenread &#8212; только чтение; fmopenwrite &#8212; только запись; fmopenreadwrite &#8212; чтение и запись. С помощью операции or эти константы можно комбинировать с одной из следующих нескольких функций, регулирующих совместный доступ к файлу: fmshareexclusive &#8212; совместный доступ запрещен; fmsharedenywrite &#8212; другим приложениям запрещается запись; fmsharedenyread &#8212; другим приложениям запрещается чтение; fmscharedenynone &#8212; совместный доступ неограничен. Обе функции возвращают дескриптор созданного (открытого) файла или 0, если операция оказалась неудачной. </p>
<p>На втором этапе создается объект отображения в память. Для этого используется функция: </p>
<p>function createfilemapping (hfile: thandle; lpfilemappingattributes: psecurityattributes; flprotect, dwmaximumsizehigh, dwmaximumsizelow: dword; lpname: pchar): thandle; <br>
<p>Здесь hfile &#8212; дескриптор файла; lpfilemappingattributes &#8212; указатель на структуру, в которой определяется, может ли создаваемый объект порождать дочерние объекты (обычно не может &#8212; nil); flprotect &#8212; определяет тип защиты, применяемый к окну отображения файла (см. об этом ниже); dwmaximumsizehigh, dwmaximumsizelow &#8212; соответственно старшие и младшие 32 разряда числа, содержащего размер файла (если вы будете отображать файлы длиной до 4 Гбайт, поместите в dwmaximumsizehigh 0, если в dwmaximumsizelow &#8212; длину файла; а если оба параметра равны 0, то размер окна отображения равен размеру файла); lpname &#8212; имя объекта отображения или nil. </p>
<p>Параметр flprotect задает тип защиты, применяемый к окну просмотра файла, и может иметь одно из следующих значений: page_readonly &#8212; файл можно только читать (файл должен быть создан или открыт в режиме fmopenread); page_readwrite &#8212; файл можно читать и записывать в него новые данные (файл открывается в режиме fmopenreadwrite); page_writecopy &#8212; файл открыт для записи и чтения, однако обновленные данные сохраняются в отдельной защищенной области памяти (отображенные файлы могут разделяться приложениями, в этом режиме каждое приложение сохраняет изменения в отдельной области памяти или участке файла подкачки); файл открывается в режиме fmopenreadwrite или fmopenwrite; (этот тип защиты нельзя использовать в windows 95/98). С помощью операции or к параметру flprotect можно присоединить такие атрибуты: sec_commit &#8212; выделяет для отображения физическую память или участок файла подкачки; sec_image &#8212; информация об атрибутах отображения берется из образа файла; sec_nocashe &#8212; отображаемые данные не кэшируются и записываются непосредственно на диск; sec_reserve &#8212; резервируются страницы раздела без выделения физической памяти. </p>
<p>Функция возвращает дескриптор объекта отображения или 0, если обращение было неудачным. </p>
<p>Наконец, на третьем этапе создается окно просмотра, то есть собственно отображение данных в адресное пространство программы. </p>
<p>function mapviewoffile(hfilemappingobject: thandle;dwdesiresaccess: dword; dwfileoffsethigh, dwfileiffsetlow, dwnumberofbytestomap: dword): pointer; </p>
<p>Здесь hfilemappingobject &#8212; дескриптор объекта отображения; dwdesiresaccess &#8212; определяет способ доступа к данным и может иметь одно из следующих значений: file_map_write &#8212; разрешает чтение и запись (при этом в функции createfilemapping должен использоваться атрибут page_readwrite); file_map_read &#8212; разрешает только чтение (в функции createfilemapping должен использоваться атрибут page_readonly или page_readwrite); file_map_all_access &#8212; то же, что и file_map_write; file_map_copy &#8212; данные доступны для записи и чтения, однако обновленные данные сохраняются в отдельной защищенной области памяти (в функции createfilemapping должен использоваться атрибут page_writecopy); dwfileoffsethigh, dwfileiffsetlow &#8212; определяют соответственно старшие и младшие разряды смещения от начала файла, начиная с которого осуществляется отображение; dwnumberofbytestomap &#8212; определяет длину окна отображения (0 &#8212; длина равна длине файла). Функция возвращает указатель на первый байт отображенных данных или nil, если обращение к функции оказалось безуспешным. </p>
<p>После использования отображенных данных ресурсы окна отображения нужно освободить функцией: </p>
<p>function unmapviewoffile(lpbaseaddress: pointer): bool; <br>
<p>единственный параметр обращения к которой должен содержать адрес первого отображенного байта, то есть адрес, возвращаемый функцией mapviewoffile. Закрытие объекта отображения и самого файла осуществляется обращением к функции: </p>
<p>function closehandle(hobject: thandle). <br>
<p>В листинге 3 приводится текст модуля (file&#173;&#173;inmemory.dpr), который создает окно.</p>
<p>Листинг 3</p>
<pre>
unit unit1; 
 
interface 
 
uses 
windows, messages, sysutils, classes, graphics, controls, forms, dialogs, stdctrls, comctrls, spin; 
 
type 
tform1 = class(tform) 
btmem: tbutton; 
btfile: tbutton; 
se: tspinedit; 
label1: tlabel; 
pb: tprogressbar; 
label2: tlabel; 
lbmem: tlabel; 
lbfile: tlabel; 
procedure btmemclick(sender: tobject); 
procedure btfileclick(sender: tobject); 
private 
{ private declarations } 
public 
{ public declarations } 
end; 
 
var 
form1: tform1; 
 
implementation 
 
{$r *.dfm} 
 
 
procedure tform1.btmemclick(sender: tobject); 
// Создание файла методом его отображения 
type 
preal = ^real; 
var 
hfile, hmap: thandle; 
adrbase, adrreal: preal; 
k: integer; 
fsize: cardinal; 
begtime: tdatetime; 
begin 
begtime := time; // Засекаем время пуска 
// Готовим progressbar: 
pb.max := se.value; 
pb.position := 0; 
pb.show; 
fsize := se.value * sizeof(real); // Длина файла 
hfile := filecreate('test.dat'); // Создаем файл 
if hfile = 0 then // Ошибка: возбуждаем исключение 
raise exception.create('Ошибка создания файла'); 
try 
// Отображаем файл в память 
hmap := createfilemapping( 
hfile, nil, page_readwrite, 0, fsize, nil); 
if hmap = 0 then // Ошибка: возбуждаем исключение 
raise exception.create('Ошибка отображения файла'); 
try 
// Создаем окно просмотра: 
adrbase := mapviewoffile(hmap, file_map_write, 0, 0, fsize); 
if adrbase = nil then // Ошибка: возбуждаем исключение 
raise exception.create('Невозможно просмотреть файл'); 
// Сохраняем начальный адрес для правильной ликвидации 
// окна просмотра: 
adrreal := adrbase; 
for k := 1 to se.value do 
begin 
adrreal^ := random; // Помещаем в файл новое число 
// Перед наращиванием текущего адреса необходимо 
// привести его к типу integer или cardinal: 
adrreal := pointer(integer(adrreal) + sizeof(real)); 
lbmem.caption := inttostr(k); 
pb.position := k; 
application.processmessages; 
end; 
// Освобождаем окно просмотра: 
unmapviewoffile(adrbase) 
finally 
// Освобождаем отображение 
closehandle(hmap) 
end 
finally 
// Закрываем файл 
closehandle(hfile) 
end; 
// Сообщаем время счета 
pb.hide; 
lbmem.caption := timetostr(time-begtime) 
end; 
 
procedure tform1.btfileclick(sender: tobject); 
// Создание файла обычным методом 
var 
f: file of real; 
k: integer; 
begtime: tdatetime; 
r: real; // Буферная переменная для обращения к write 
begin 
begtime := time; // Засекаем начальное время счета 
// Готовим progressbar: 
pb.max := se.value; 
pb.position := 0; 
pb.show; 
// Создаем файл: 
assignfile(f, 'test.dat'); 
rewrite(f); 
for k := 1 to se.value do 
begin 
r := random; // Параметрами обращения к write 
write(f, r); // могут быть только переменные 
lbfile.caption := inttostr(k); 
pb.position := k; 
application.processmessages; 
end; 
closefile(f); 
pb.hide; 
lbfile.caption := timetostr(time-begtime) 
end; 
 
end. 
</pre>
<p>Проект создает дисковый файл, состоящий из 100 тыс. случайных вещественных чисел (можно выбрать другую длину файла, если изменить значение редактора Длина массива). Файл с именем test.dat создается путем отображения файла в память (кнопка Память) и традиционным способом (кнопка Файл). В обоих случаях показывается время счета. Чем больше частота процессора и объем свободной оперативной памяти, тем больше будет разница во времени (листинг 3). </p>
<p>Источник: http://www.delphi.h5.ru/ </p>
