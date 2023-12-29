---
Title: Процедуры и функции RxLib
Author: Pegas
Date: 01.01.2007
---


Процедуры и функции RxLib
=========================

::: {.date}
01.01.2007
:::

Процедуры и функции RX\_lib

AppUtils unit:

 

AppBroadcast - Функция посылает сообщение Msg всем формам приложения.

FindForm - Функция перебирает формы приложения, проверяя для каждой из
них, является ли она экземпляром класса FormClass

FindShowForm - Функция перебирает формы приложения, проверяя для каждой
из них, является ли она экземпляром класса FormClass

GetDefaultIniName - Функция возвращает имя INI-файла "по умолчанию"
для приложения.

GetDefaultIniRegKey - Функция возвращает имя ключа регистрационной базы
данных Windows (Registry) "по умолчанию" для приложения

GetDefaultSection - Функция возвращает строку для указанной компоненты
Component,

GetUniqueFileNameInDir - Возвращает уникальное для заданного каталога
имя файла, InstantiateForm- функция создает экземпляр формы типа
FormClass

ReadFormPlacement - Процедура ReadFormPlacement используется для
восстановления формы

RestoreFormPlacement - Процедура RestoreFormPlacement используется для
восстановл. формы

RestoreGridLayout - Восстанавливает из INI-файла ширины колонок
компонент TCustomGrid

RestoreMDIChildren - Создает и показывает MDIChild-формы

SaveFormPlacement - Процедура используется для сохранения состояния
формы

SaveGridLayout

SaveMDIChildren

ShowDialog - Создание и модальное исполнение диалога

WriteFormPlacement - Процедура используется для сохранения состояния
формы,

BdeUtils unit:

 

AsyncQrySupported - Функция возвращает True, если драйвер
специфицированной базы данных Database поддерживает асинхронное
выполнение запросов

CheckOpen - Функция служит для обрамления вызовов функций BDE API,
открыв. курсоры

ConvertStringToLogicType - Процедура предназначена для конвертации
строки Value в BDE,

CurrentRecordDeleted - Функция определяет, является ли текущая запись
набора данных удаленной (помеченной как удаленная) или нет

DataSetFindValue - Функция пытается установить набор данных, переданный
в качестве параметра DataSet, на первую от начала запись,
удовлетворяющую заданному условию

DataSetPositionStr - Для драйверов DBase и Paradox функция возвращает
строку, содержащую текущий номер записи и полное число записей в DataSet

DataSetRecNo - Функция возвращает номер текущей записи в DataSet.

DataSetShowDeleted - Процедура устанавливает режим показа удаленных
записей в таблицах формата DBase.

DeleteRange - Удаление диапазона записей из таблицы.

ExecuteQuery - Процедура предназначена для выполнения SQL-запросов

ExportDataSet - Процедура служит для экспорта данных из таблицы БД или
результата запроса Source в выходную таблицу DestTable.

FetchAllRecords

FieldLogicMap - Функция возвращает для конкретного значения FldType
получить для целочисленное значение, идентифицирующее логический тип
данных BDE.

GetAliasPath - Функция возвращает физический путь для алиаса
(псевдонима) BDE

GetBDEDirectory - Функция возвращает имя каталога, в котором установлены
библиотеки BDE InitRSRun - Инициализация RUNTIME ReportSmith.

IsBookmarkStable - Return True, if specified DataSet supports stable
bookmarks

PackTable - Процедура предназначена для "упаковки" таблиц формата
DBase и Paradox

RestoreIndex - Восстанавливает свойство IndexFieldNames у Table

SetIndex -Устанавливает свойство IndexFieldNames у Table

SetToBookmark - Функция устанавливает ADataSet в позицию,
соответствующую переданному значению ABookmark

TransActive - Функция определяет, имеет ли база данных Database активную
транзакцию и в этом случае возвращает True, в противном случае результат
- False.

BoxProcs unit:

 

BoxDragOver - Предполагается вызывать из обработчика события OnDragOver.

BoxMoveAllItems - Копирует все элементы SrcList в DstList, затем очищает
SrcList.

BoxMoveFocusedItem - Предполагается использовать в обработчике события
OnDragDrop.

BoxMoveSelectedItems - Перемещает выделенные элементы из SrcList в
DstList

ClipIcon unit:

 

AssignClipboardIcon - Процедура заполняет иконку Icon данными из буфера
обмена (Clipboard)

CopyIconToClipboard

CreateIconFromClipboard - Функция создает объект класса TIcon, если
буфер обмена (Clipboard) содержит данные в формате CF\_ICON.

CreateRealSizeIcon - Функция создает иконку из объекта Icon класса TIcon

DrawRealSizeIcon - Функция рисует иконку Icon на устройстве Canvas,

GetIconSize - Процедура возвращает ширину и высоту иконки,

DateUtil unit:

 

CutTime - Устанавливает время в переданном аргументе ADate в значение
00:00:00:00.

DateDiff - Определяет разницу между датами, заданными Date1 и Date2 в
днях, месяцах и годах.

DaysBetween - Вычисляет число дней между датами Date1 и Date2,

DaysInPeriod - Вычисляет число дней между датами Date1 и Date2

DaysPerMonth

DefDateFormat - Функция возвращает строку формата даты по
ShortDateFormat,

DefDateMask - Функция возвращает строку маски для ввода даты

FirstDayOfNextMonth

FirstDayOfPrevMonth

GetDateOrder - Функция возвращает порядок расположения дня, месяца и
года в формате даты,

IncDate - Увеличивает дату ADate на заданное количество дней, месяцев и
лет, возвращая полученную дату как результат.

IncDay - Увеличивает дату на заданное количество дней, возвращая
полученную датуIncHour

IncMinute - Увеличивает время на заданное количество минут, возвращая
полученное время IncMonth

IncMSec

IncSecond

IncTime - Увеличивает время на заданное количество часов, минут, секи
мс, возвращая время IncYear

IsLeapYear- Проверяет является ли заданный параметром AYear год
високосным.

LastDayOfPrevMonth

MonthsBetween

StrToDateDef - Функция преобразует строку в дату в соответствии с
форматом ShortDateFormat

StrToDateFmt

StrToDateFmtDef

ValidDate - Функция определяет, представляет ли собой аргумент ADate
действительное значение существующей даты.

DBFilter unit

 

DropAllFilters - Процедура деактивирует все фильтры, установленные ранее
на набор данных DataSet, и освобождает захваченные ими ресурсы.

DBUtils unit:

 

AssignRecord - Процедура предназначена для копирования значений полей из
текущей записи набора данных Source в поля текущей записи набора данных
Dest,

CheckRequiredField - Процедура проверяет заполнение поля Field
значением, отличным от NULL

ConfirmDataSetCancel - Процедура проверяет, находится ли переданный
набор данных DataSet в режиме вставки или замены, модифицированы ли
данные текущей записи, и если да, то запрашивает, надо ли сохранять
сделанные изменения.

ConfirmDelete - Функция вызывает появление диалога с запросом
подтверждения на удаление записи, аналогичного диалогу, появляющемуся у
TDBGrid.

DataSetSortedSearch - Функция пытается установить набор данных,
переданный в качестве параметра, на первую от начала запись,
удовлетворяющую заданному условию

FormatAnsiSQLCondition - Функция сходна по назначению и результатам с
FormatSQLCondition

FormatSQLCondition - Функция возвращает строковое выражение,
соответствующее записи логического условия на языке SQL. Используется, в
основном, для подстановки параметров (макросов) TRxQuery.

FormatSQLDateRange - Возвращает логическое условие для языка SQL
нахождения значения поля, заданного FieldName в интервале, заданном
Date1 и Date2. Учитываются особые случаи:

RefreshQuery - Процедура "обновляет" данные для набора данных

RestoreFields - Процедура восстанавливает из INI-файла IniFile аттрибуты
полей набора данных, заданного в DataSet.

SaveFields

FileUtil unit:

 

BrowseComputer - BrowseComputer brings up a dialog to allow the user to
select a network computer

BrowseDirectory

ClearDir

CopyFile

DeleteFiles

DeleteFilesEx

DirExists - The DirExists function determines whether the directory
specified as the value of the Name parameter exists.

FileDateTime

FileLock - he FileLock function locks a region in an open file

FileUnlock

GetFileSize - Функция возвращает размер в байтах файла, заданного
параметром FileName.

GetSystemDir - The GetSystemDir function retrieves the path of the
Windows system directory

GetTempDir

GetWindowsDir

HasAttr - Функция возвращает True, если файл FileName имеет аттрибут
Attr.

LongToShortFileName

LongToShortPath

MoveFile - Процедура перемещает или переименовывает FileName в файл с
именем DestName.

NormalDir - Функция служит для нормализации имени каталога

ShortToLongFileName

ShortToLongPath

ValidFileName - Функция определяет, является ли имя, переданное как
параметр FileName, допустимым именем файла.

MaxMin unit:

 

Max

MaxFloat - Функция MaxFloat возвращает наибольшее число из массива
действительных чисел .

MaxInteger - Функция MaxInteger возвращает наибольшее число из массива
целых чисел

MaxOf - Функция MaxOf возвращает наибольшее значение из массива значений
Values

Min

MinFloat

MinInteger

MinOf

SwapInt - Процедура взаимно заменяет значения двух аргументов Int1 и
Int2 между собой.

SwapLong

Parsing unit:

 

GetFormulaValue - Функция вычисляет результат математического выражения,
заданного параметром Formula. Для вычислений используется объект типа
TRxMathParser.

PickDate unit:

 

PopupDate - Функция PopupDate вызывает появление диалога выбора даты

SelectDate - Функция SelectDate позволяет пользователю выбрать дату,
используя диалог выбора даты с календарем и кнопками навигации

SelectDateStr - Функция полностью аналогична функции SelectDate, за
исключением того, что значение даты передается в нее в виде строки.

RxGraph unit:

 

BitmapToMemory

GetBitmapPixelFormat

GrayscaleBitmap - This procedure transforms a color bitmap image into
grayscale

SaveBitmapToFile

SetBitmapPixelFormat - Процедура позволяет изменить число цветов (бит на
пиксель), используемое для отрисовки битового изображения ABitmap

RxHook unit

 

FindVirtualMethodIndex - Функция находит индекс виртуального метода
объекта класса AClass по адресу метода MethodAddr.

GetVirtualMethodAddress

SetVirtualMethodAddress

RxMenus Unit

 

procedure SetDefaultMenuFont(AFont: TFont);

RxShell unit

 

FileExecute

FileExecuteWait - Функция полностью аналогична функции FileExecute, но в
отличие от нее приостанавливает выполнение вызвавшего ее потока до
завершения запущенного приложения.

IconExtract - Функция создает объект класса TIcon из ресурсов
исполнимого файла FileName

WinAbout - Процедура вызывает стандартное диалоговое окно "About"
системы MSWindows.

Speedbar Unit

 

function FindSpeedBar(const Pos: TPoint): TSpeedBar;

SplshWnd Unit

 

ShowSplashWindow - Функция создает и отображает форму без заголовка с
установленным стилем fsStayOnTop, которую можно использовать как
заставку при загрузке приложения или при выполнении длительных операций

 

StrUtils unit:

 

AddChar - Добавляет слева к стpоке S символы C до длины S=N.

AddCharR - Добавляет справа к стpоке S символы C до длины S=N.

AnsiProperCase - Returns string, with the first letter of each word in
uppercase, all other letters in lowercase.

CenterStr

CompStr - Сравнивает строки S1 и S2 (с учетом регистра)

CompText - Сравнивает строки S1 и S2 (без учета регистра)

Copy2Space - Копирует с начала строки до первого пробела.

Copy2SpaceDel - Копирует с начала строки до первого пробела и удаляет
эту часть

Copy2Symb - Копирует с начала строки S до первого символа Symb и
возвращает эту часть исходной строки.

Copy2SymbDel

Dec2Hex - Пpеобpазует целое число N в шестнадцатеричное число, дополняя
слева нулями до длины A.

Dec2Numb - Пpеобpазует целое число N в число по основанию B, дополняя
слева нулями до длины A.

DelBSpace - Функция удаляет ведущие пpобелы из стpоки S.

DelChars - Функция даляет все символы Сhr из строки S.

DelESpace - Функция удаляет конечные пpобелы из стpоки S.

DelRSpace - Функция удаляет начальные и конечные пpобелы из стpоки S.

DelSpace - Функция удаляет все пробелы из строки.

DelSpace1 - Функция удаляет все, кpоме одного, пpобелы из стpоки S.

ExtractDelimited - Функция аналогична функции ExtractWord

ExtractQuotedString - ExtractQuotedString removes the Quote characters
from the beginning and end of a quoted string

ExtractSubstr - Функция предназначена для выделения подстроки из строки
S, если подстроки разделены символами из набора Delims.

ExtractWord - Выделяет N-ое слово из строки S, используя WordDelims
(типа TCharSet) как разделитель между словами.

ExtractWordPos - Выделяет N-ое слово из строки S, используя WordDelims
(типа TCharSet) как разделитель между словами

FindCmdLineSwitch

FindPart - FindCmdLineSwitch determines whether a string was passed as a
command line argument to the application.

GetCmdLineArg - GetCmdLineArg определяет, имеется ли параметр Switch
среди параметров командной строки, переданных в приложение, и возвращает
значение этого параметра

Hex2Dec - Пpеобpазует шестнадцатеpичное число в стpоке S в целое
десятичное.

IntToRoman - IntToRoman converts the given value to a roman numeric
string representation.

IsEmptyStr - Функция возвращает True, если строка S содержит только
символы из EmptyChars.

IsWild - Функция IsWild сравнивает строку InputString со строкой
WildCard, содержащей символы маски, и возвращает True, если строка
InputStr соответствует маске.

IsWordPresent - Определяет, присутствует ли слово W в строке S,
используя символы

WordDelims как возможные разделители между словами.

LeftStr - Добавляет строку S до длины N справа.

MakeStr - Фоpмиpует стpоку из N символов C.

MS - Фоpмиpует стpоку из N символов C.

Npos - Ищет позицию N-го вхождения подстроки C в стpоке S.

Numb2Dec - Пpеобpазует число по основанию B в стpоке S в целое
десятичное.

Numb2USA - Пpеобpазует числовую стpоку S к фоpмату США. Напpимеp:
Входная стpока: \'12365412\'; Выходная стpока: \'12,365,412\'.

OemToAnsiStr - OemToAnsiStr translates a string from the OEM character
set into the Windows character set.

QuotedString - QuotedString returns the given string as a quoted string,
using the provided

Quote character.

ReplaceStr - Функция заменяет в строке S все вхождения подстроки Srch на
подстроку, переданную в качестве аргумента Replace.

RightStr - Добавляет строку S до длины N слева.

RomanToInt - RomanToInt converts the given string to an integer value.

StrToOem - Конвертирует переданную в качестве аргумента AnsiStr строку
(в ANSI-кодировке Windows) в кодировку OEM.

Tab2Space - Преобразует знаки табуляции в строке S в Numb пробелов.

WordCount - Считает число слов в строке S, используя параметр WordDelims
(типа TCharSet) как разделитель между словами.

WordPosition - Возвращает позицию первого символа N-го слова в строке S,
используя параметр WordDelims (типа TCharSet) как разделитель между
словами.

VCLUtils unit:

 

ActivatePrevInstance - Функция ActivatePrevInstance предназначена для
активизации предыдущей копии приложения

ActivateWindow - Процедура ActivateWindow активизирует окно Windows,
обработчик которого специфицируется параметром Wnd.

AllocMemo - Функция предназначена для динамического выделения блока
памяти размером Size.

AnsiUpperFirstChar - Функция приводит к верхнему регистру первый символ
в переданной строке S, используя набор символов ANSI.

AssignBitmapCell - Процедура копирует прямоугольную область из картинки
Source в битовое изображение Dest,

CenterControl - Процедура центрирует элемент управления Control
относительно "родителя"

CenterWindow - Процедура центрирует окно Wnd на экране дисплея.

ChangeBitmapColor - создает новое графическое изображение, являющееся
копией переданного, однако заменяя цвет всех точек изображения,

CompareMem - Функция CompareMem сравнивает содержимое двух блоков памяти

CopyParentImage - Процедура копирует в заданный контекст устройства Dest
изображение,

CreateBitmapFromIcon

CreateIconFromBitmap

CreateRotatedFont - Создает "наклонный" шрифт

CreateTwoColorsBrushPattern - Функция создает битовое изображение,
состоящее из точек двух цветов: Color1 и Color2, чередующихся в
шахматном порядке.

DefineCursor - Загружает курсор из ресурса исполняемого модуля и
определяет его уникальный индекс в массиве курсоров Screen.Cursors.

Delay - Процедура вызывает задержку выполнения программы на заданное
параметром MSecs число миллисекунд.

DialogUnitsToPixelsX - Функция преобраз. диалоговые единицы в пиксели по
горизонтали.

DialogUnitsToPixelsY

DrawBitmapRectTransparent - Процедура DrawBitmapRectTransparent рисует
на устройстве Dest прямоугольный участок графического изображения

DrawBitmapTransparent - Процедура DrawBitmapTransparent рисует на
устройстве Dest графическое изображение Bitmap

DrawCellBitmap - Процедура DrawCellBitmap предназначена для отрисовки
битового изображения Bmp

DrawCellText - для отрисовки строки текста S в ячейке объекта -
наследника TCustomGrid.

DrawInvertFrame - Процедура рисует на экране инвертированную рамку,
определяемую координатами ScreenRect

FreeMemo - Процедура освобождает память, выделенную функцией AllocMemo.

FreeUnusedOLE

GetEnvVar - Возвращает значение переменной окружения DOS, заданной
параметром VarName.

GetMemoSize - Функция GetMemoSize возвращает размер блока памяти,
выделенного функцией

AllocMemo.

GetWindowsVersion - Функция возвращает версию Windows в виде строки,
содержащей название платформы и номер версии операционной системы.

GradientFillRect - Процедура GradientFillRect рисует прямоугольник Rect
на устройстве Canvas, цвет которого плавно изменяется от BeginColor до
EndColor в направлении Direction.

HeightOf - Функция возвращает высоту (в пикселях) переданного
прямоугольника R.

HugeDec - Decrement a huge pointer.

HugeInc

HugeMove

HugeOffset

ImageListDrawDisabled - Процедура рисует изображение из списка Images,
заданное индексом Index, на устройстве Canvas с координатами X, Y

IsForegroundTask - Функция проверяет, является ли приложение, вызвавшее
эту функцию, текущей активной (foreground) задачей Windows.

KillMessage - KillMessage deletes the requested message Msg from the
window message queue

LoadAniCursor - The LoadAniCursor function loads the specified animated
cursor resource from the executable (.EXE or .DLL) file associated with
the specified application instance.

LoadDLL - Функция загружает динамическую библиотеку или модуль, заданный
именем

LibName.

MakeBitmap - Функция создает объект класса TBitmap из ресурса вашего
приложения.

MakeBitmapID - Функция создает объект класса TBitmap из ресурса вашего
приложения.

MakeIcon - Функция создает объект класса TIcon из ресурса вашего
приложения.

MakeIconID

MakeModuleBitmap - Функция создает объект класса TBitmap из ресурса
любого загруженного модуля (исполняемого файла или DLL)

MakeModuleIcon - Функция создает объект класса TIcon из ресурса любого
загруженного модуля (исполняемого файла или DLL).

MergeForm - Процедура предназначена для вставки обычной формы AForm
(например, созданной в дизайнере и загруженной из DFM-файла) в элемент
управления AControl.

MinimizeText - Эта функция может быть использована для того, чтобы
сократить текстовую строку Text до длины, позволяющей отобразить ее
целиком на устройстве Canvas на участке длиной MaxWidth.

MsgBox - Функция представляет собой оболочку стандартной функции Windows
API MessageBox, только в качестве параметров принимает не PChar, а
строки в формате языка Pascal.

NotImplemented - Процедура вызывает появление диалогового окна с
сообщением "Функция не реализована" ("Function not yet
implemented"), PaintInverseRect

PixelsToDialogUnitsX - Функция преобр пиксели в диалоговые единицы по
горизонтали.

PixelsToDialogUnitsY

PointInPolyRgn - Функция возвращает True, если точка с координатами P
расположена внутри региона, ограниченного фигурой с вершинами, заданными
набором точек Points.

PointInRect - Функция возвращает True, если точка с координатами P
расположена внутри прямоугольника R.

RegisterServer - Функция предназначена для регистрации в Windows
элементов управления OLE (OCX, ActiveX)

ResourceNotFound - Процедура предназначена для вывода сообщения об
ошибке (с генерацией исключения EResNotFound) при ошибке загрузки
ресурса из исполняемого файла.

ShadeRect - Процедура служит для "штриховки" прямоугольника Rect

SplitCommandLine - Процедура SplitCommandLine разделяет командную строку
запуска любой программы на имя исполняемого файла и строку параметров.

StartWait - Процедура StartWait меняет изображение курсора мыши на
экране на то, которое определено типизированной константой WaitCursor
(по умолчанию crHourGlass), и увеличивает счетчик вызовов StartWait на
1.

StopWait - Процедура StopWait восстанавливает изображение курсора мыши
на экране по умолчанию, если оно было изменено процедурой StartWait.

WidthOf - Функция возвращает ширину (в пикселях) переданного
прямоугольника R.

Win32Check - Процедура предназначена для использования при вызове
функций Win32 API, возвращающих значение типа BOOL, которое определяет,
успешно ли выполнилась функция Win32 API.

Автор: Pegas

Взято с Vingrad.ru <https://forum.vingrad.ru>
