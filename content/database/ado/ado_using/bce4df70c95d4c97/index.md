---
Title: Параметры
Date: 01.01.2007
---


Параметры
=========

::: {.date}
01.01.2007
:::

Параметры

Многие компоненты ADO, инкапсулирующие набор записей, должны
обеспечивать применение параметров запросов. Для этого в них
используется специальный класс TParameters.

Для каждого параметра из коллекции класса TParameters создается
отдельный класс TParameter.

Этот класс является наследником класса коллекции TCollection и
инкапсулирует индексированный список отдельных параметров (см. ниже).
Напомним, что для работы с параметрами обычных запросов в компонентах
запросов и хранимых процедур используется класс TParams (например в
компонентах dbExpress), также происходящий от класса коллекции.

Методы этих двух классов совпадают, а свойства имеют некоторые отличия.
Для представления параметров команд в ADO имеется специальный объект
параметров, который активно используется в процессе работы компонентов
АDO, инкапсулирующих набор данных.

Поэтому для компонентов ADO в VCL был создан собственный класс
параметров.

Класс TParameters

Главное, для чего предназначен класс TParameters, --- содержать список
параметров. Индексированный список параметров представлен свойством
property Items\[Index: Integer\]: TParameter; Текущие значения
параметров можно получить из индексированного свойства

property ParamValues\[const ParamName: String\]: Variant;

При этом доступ к конкретному значению осуществляется по имени
параметра:

Editl.Text := ADODataSet.Parameters.ParamValues\[\'ParamOne\'\];

Список параметров можно обновлять при помощи методов

function AddParameter: TParameter;

и

function CreateParameter(const Name: WideString; DataType: TDataType;

Direction: TParameterDirection; Size: Integer; Value: OleVariant):
TParameter;

Первый метод просто создает новый объект параметра и добавляет его к
списку. Затем необходимо задать все свойства нового параметра:

var NewParam: TParameter;

NewParam := ADODataSet.Parameters.AddParameter;

NewParam.Name := \'ParamTwo\';

NewParam.DataType := ftlnteger; 

NewParam.Direction := pdlnput;

NewParam.Value := 0;

Метод CreateParameter создает новый параметр и определяет его свойства: 

Name --- имя параметра;

DataType --- тип данных параметра, соответствующий типу поля таблицы БД
(тип TFieldType);

Direction --- тип параметра, в дополнение к стандартным типам dUnknown,
pdlnput, pdOutput, pdlnputOutput,тип TParameterDirection имеет
дополнительный тип pdReturnValue, определяющий любое возвращаемое
значение;

size --- максимальный размер значения параметра; 

value --- значение параметра.

При работе с параметрами полезно вызывать их, используя имена, а не
абсолютные индексы в списке. Для этого можно использовать метод

function ParamByName(const Value: WideString): TParameter;

Список параметров всегда должен соответствовать запросу или хранимой
процедуре. Для обновления списка используется метод

procedure Refresh;

Также вы можете создать список параметров для не связанного с данным
объектом параметров запроса. Для этого используется метод

function ParseSQL(SQL: String; DoCreate: Boolean): String;

где DoCreate определяет, удалять ли перед анализом существующие
параметры.

Класс TParameter

Класс TParameter инкапсулирует отдельный параметр. Имя параметра
определяется свойством

property Name: WideString;

Тип данных, которому должно соответствовать его значение, задается
свойством

TDataType = TFieldType;

property DataType: TDataType;

И так как параметры взаимодействуют с полями таблиц БД, то тип данных
параметров совпадает с типами данных полей. От типа данных зависит
размер параметра

property Size: Integer;

который может быть изменен для строкового или символьного типа данных и
им подобных.

Само значение параметра содержится в свойстве

property Value: OleVariant; 

А свойство

type

TParameterAttribute = (paSigned, paNullable, paLong);

TParameterAttributes = set of TParameterAttribute; property Attributes:
TParameterAttributes;

контролирует значение, присваиваемое параметру:

paSigned --- значение может быть символьным;

paNullable --- значение параметра может быть пустым;

paLong --- значение может содержать данные типа BLOB.

Тип параметра задается свойством

type TParameterDirection = (pdUnknown, pdlnput, pdOutput, pdlnputOutput,
pdReturnValue);

property Direction: TParameterDirection;

pdUnknown --- неизвестный тип, источник данных попытается определить его
самостоятельно;

pdinput --- входной параметр, используется в запросах и хранимых
процедурах;

pdOutput --- выходной параметр, используется в хранимых процедурах;

pdlnputOutput --- входной и выходной параметр одновременно, используется
в хранимых процедурах;

pdReturnValue --- параметр для передачи значения.

Если параметр должен передавать большие бинарные массивы (например,
изображения или файлы), то значение параметра можно загрузить, используя
методы

procedure LoadFromFile(const FileName: String; DataType: TDataType);

И

procedure LoadFromStream(Stream: TStream; DataType: TDataType);
