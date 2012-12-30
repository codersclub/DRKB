---
Title: Поиск в базе данных
Date: 01.01.2007
---


Поиск в базе данных
===================

::: {.date}
01.01.2007
:::

перевод одноимённой статьи с delphi.about.com

Самая распространённая задача, которую решают приложения работающие с
базами данных - это поиск необходимых записей по заданному критерию. В
Delphi, компоненты ADOExpress включают в себя методы поиска записей,
аналогичные тем, которые используются в BDE.

В данной статье будут рассмотрены различные способы поиска данных
разработке ADO-приложений в Delphi

Обычно алгоритм поиска строится по следующей схеме: начинаем поиск с
начала таблицы, проверяем поле в каждой строке на предмет удовлетворения
нашему критерию, останавливаем цикл на выбранной записи.

Давайте рассмотрим несколько способов расположения данных, полученных из
БД посредствам компонента ADODataset (для Таблицы и для Запроса).

Locate

Этот универсальный метод поиска устанавливает текущую запись как первую
строку, удовлетворяющую набору критериев поиска. Используя метод Locate
мы можем искать значения одного или более полей, расположенных в массиве
переменных. В приведённом ниже коде, метод Locate ищет первую запись,
содержащую строку \'Zoom\' в поле \'Name\'. Если вызов Locate возвращает
True - то запись найдена и установлена как текущая.

    AdoTable1.Locate('Name','Zoom',[]);
     
    {...или...}
     
    var ffield, fvalue: string;
        opts : TLocateOptions;
             
    ffield := 'Name';
    fvalue := 'zoom';
    opts := [loCaseInsensitive];
     
    if not AdoTable1.Locate(ffield, fvalue, opts) then
      ShowMessage(fvalue + ' not found in ' + ffield);

Lookup

Метод Lookup не перемещает курсор в соответствующую строку, а только
возвращает её значение. Lookup возвращает массив переменных, содержащих
значения из полей, указанных в разделённом точкой с запятой списке имён,
значения которых должны быть возвращены из интересующей нас строки. Если
соответствующих нашему запросу строк не найдено, то Lookup вернёт пустую
(Null) переменную.

Следующий пример заполняет заполняет массив переменных LookupRes

    var LookupRes: Variant;
     
    LookupRes := ADOTable1.Lookup
      ('Name', 'Zoom', 'Author; Description');
     
    if not VarIsNull(LookupRes) then
     ShowMessage(VarToStr(LookupRes[0])) //имя автора

Одно из преимуществ методов Locate и Lookup, состоит в том, что они не
требуют, чтобы таблица была проиндексирована.  Однако, функция Locate
будет работать намного быстрее, если таблица будет проиндексирована.

Индексирование

Индексирование помогает находить и сортировать записи намного быстрее.
Вы можете создавать индексы основанные на одном поле либо на нескольких
полях. Индексирование нескольких полей позволяет Вам различать записи, в
которых первое поле может иметь то же самое значение. В большинстве
случаев при частом поиске/сортировке желательно индексировать поля.
Например, если Вы ищете определённый тип приложения в поле Type, то Вы
можете создать индекс на это поле для ускорения поиска по типу. Следует
упомянуть, что первичный ключ таблицы автоматически проиндексирован, а
так же Вы не можете индексировать поля с типом данных OLE Object. И ещё,
обратите внимание, что если многие из значений в поле те же самые, то
индексирование в данном случае не ускорит процесс получения данных из
БД.

BDE (не ADO) Delphi предоставляет нам определённые функции для работы с
таблицами базы данных, которые позволяют нам производить поиск
необходимых значений. Вот некоторые из них Goto, GoToKey, GoToNearest,
Find, FindKey, Find Nearest, и т.д. Для более полной справки по этим
методам, Вам следует посмотреть в справке Delphi, в разделе: Searching
for records based on indexed fields. ADO напротив не поддерживает эти
методы. Вместо этого он представляет метод Seek.

Seek

В ADO метод Seek использует индекс для поиска данных. Наример, при
поиске в базе данных Access, если не задать индекс, то база данных будет
использовать Первичный индексный ключ.

Seek используется для поиска записей с указанным значением (или
значениями) в поле (либо полях) на которых основан текущий индекс. Если
Seek не находит желаемую строку, то никакой ошибки не выдаётся, а курсор
устанавливается в конец данных. Seek возвращает значение boolean,
указывающее на успешность поиска: True если запись была найдена либо
False если записей удовлетворяющих нашим требований не было найдено.

Метод GetIndexNames в компоненте TADOTable возвращает список (например:
ячеек combo box) доступных индексов для таблицы.

ADOTable1.GetIndexNames(ComboBox1.Items);

Этот же список доступен в режиме разработки в свойстве IndexName
компонента TADOTable. Свойство IndexFieldNames может использоваться как
альтернативный метод для определения индекса используемого в таблице. В
IndexFieldNames, мы указываем имя каждого поля для использования в
таблице.

Метод Seek имеет следующее определение:

function Seek(const KeyValues: Variant; SeekOption: TSeekOption =
soFirstEQ): Boolean;

· KeyValues массив значений Variant. Так как индекс состоит из одного
или более столбцов, то массив содержит значения, которые будут
сравниваться с соответствующими столбцами.

· SeekOption указывает на тип сравнивания между колонками индекса и
соответствующим KeyValues.

SeekOption  Назначение 

soFirstEQ  Указатель на запись позиционируется в первую удовлетворяющую
требованиям запись, если она найдена, либо в конец таблицы, если не
найдена

soLastEQ  Указатель на запись позиционируется на последнюю
удовлетворяющую требованиям запись если она найдена, либо в конец
таблицы если нет. 

soAfterEQ  Указатель на запись позиционируется на удовлетворяющую
требованиям запись, если таковая найдена, либо сразу после той, которая
была найдена.

soAfter  Указатель на запись позиционируется сразу после той, которая
была найдена. 

soBeforeEQ  Указатель на запись позиционируется на удовлетворяющую
требованиям запись, если таковая найдена, либо перед той, которая была
найдена.

soBefore  Указатель на запись позиционируется перед той записью, которая
была найдена. 

Примечание 1

метод Seek поддерживает курсоры только на стороне сервера (server-side).
Seek не будет работать, если значение свойства CursorLocation равно
clUseClient. Для этого используется метод Supports для определения
основного провайдера, поддерживающего Seek.

Примечание 2

Когда Вы используйте метод Seek для нескольких полей, то Seek поля
должны быть в том же самом порядке как поля в основной таблице. Если это
не так, то метод Seek выдаст ошибку.

Примечание 3

Вы не сможете использовать метод Seek в компоненте TADOQuery.

Чтобы определять, была ли соответствующая запись найдена, мы используем
свойства BOF или EOF (в зависимости от направления поиска). Следующий
код использует индекс, указанный в ComboBox, чтобы найти значение,
содержащееся в окне редактирования Edit1.

    var strIndex: string;
     
    strIndex := ComboBox1.Text; //из примера выше
     
    if ADOTable1.Supports(coSeek) then begin
     with ADOTable1 do begin
       Close;
       IndexName := strIndex;
       CursorLocation := clUseServer;
       Open;
       Seek (Edit1.Text, soFirstEQ);
      end;
      if ADOTable1.EOF then
       ShowMessage ('Record value NOT found');
    end

Взято из <https://forum.sources.ru>