---
Title: Функции преобразования чисел с плавающей точкой
Date: 01.01.2007
---


Функции преобразования чисел с плавающей точкой
===============================================

Преобразование числа с плавающей точкой (далее в этом разделе просто
числа) в текстовую строку и обратно всегда было достаточно сложной
задачей. Для ее решения в Delphi есть функции сразу трех уровней
сложности.

Первый - самый простой - представлен функцией FloatToStr:

    function FloatToStr( Value : Extended): string;

Число, заданное параметром Value, преобразуется в возвращаемую функцией
строку. Формат преобразования соответствует типу преобразования `g`
функции Format, причем длина выходной строки принимается равной 15
символам.

Больше возможностей для управления форматом вывода дает функция:

    function FloatToStrF(Value: Extended; Format: TFloatFormat; Precision, Digits: Integer): string;

Здесь `Value` - преобразуемое значение,  
`Format` - один из предопределенных форматов.
Хотя этот параметр имеет тип TFloatFormat, он
имеет очень много общего с типами преобразований в функции Format
(ссылки на них есть в предлагаемой таблице).  
Параметр `Precision` задает
общее число символов в выходной строке и не должен превышать 7 для
фактического параметра типа Single, 15 - для Double и 18 - для
Extended.  
`Digits` - это параметр, интерпретируемый в зависимости от
значения параметра Format:

|Формат|Значение|
|--------|--------|
|ffExponent|Научный формат, соответствует типу `е`. `Precision` задает общее число символов, `Digits` - число знаков в показателе экспоненты (0-4).|
|ffFixed|Формат с фиксированной точкой; соответствует типу `f`. `Precision` задает общее число символов, `Digits` - число знаков после запятой (0-18). Если значение `Precision` мало для представления числа, используется научный формат.|
|ffGeneral|Обобщенный формат, соответствует типу `g` (см. описание функции Format).|
|ffNumber|Отличается от `ffFixed` наличием символов-разделителей тысяч (см. тип преобразования `п`).|
|ffCurrency|Соответствует типу преобразования `т`. Параметр `Digits` задает число символов после десятичной точки в выходной строке (0-18).|


В случае, когда в функцию переданы значения Value, соответствующие
особым случаям сопроцессора ("не-число", плюс и минус бесконечность),
она возвращает соответственно строки \'NAN\', \'INF\' и \'-INF\'.

Наконец, возможность полного управления форматом предоставляет функция
FormatFloat:

    function FormatFloat(const Format: string; Value: Extended): string;

Она преобразует число в строку в соответствии со спецификатором формата,
содержащимся в параметре Format. Правила его задания следующие:

|Спецификатор|Значение|
|:----------:|--------|
|0|Поле для цифры. Если форматируемая величина имеет в этой позиции цифру, то вставляется она, в противном случае вставляется 0.|
|#|Поле для цифры. Если форматируемая величина имеет в этой позиции цифру, то вставляется она, в противном случае ничего не вставляется.|
|.|Поле для десятичной точки. Сюда вставляется символ, определенный константой DecimalSeparator.|
|,|Поле для разделителя тысяч. Оно означает, что группы по три цифры, считая влево от десятичной точки, будут разделяться специальным символом (он задан константой ThousandSeparator). Местоположение поля может быть произвольным.|
|Е+, Е-, е+, е-|Признаки представления числа в научном формате. Появление любого из этих аргументов означает, что число будет преобразовано с характеристикой и мантиссой. Вставка нулей после такого аргумента позволяет определить ширину мантиссы. Разница между Е+, е+ и Е-, е-в том, что в первых двух случаях ставится "+" при выводе положительных чисел.|
|'XX' "XX"|Символы, заключенные в обычные или двойные кавычки, напрямую включаются в выходную строку.|
|;|Разделяет спецификаторы формата для положительных, отрицательных и нулевых чисел.||0|Поле для цифры. Если форматируемая величина имеет в этой позиции цифру, то вставляется она, в противном случае вставляется 0.|

**Примечания:**

1. Число всегда округляется до той точности, которую позволяет заданное
программистом количество полей для размещения цифр (\'0\' и \'#\').

2. Если у преобразуемого числа слева от десятичной точки получается
больше значащих цифр, чем задано полей для их размещения, то цифры все
равно добавляются в строку. Если полей недостаточно справа от точки,
происходит округление.

3. Символ \';\' позволяет задать три разных формата вывода для чисел с
разным знаком. При различном количестве форматов они применяются
следующим образом:

- один: применяется для всех чисел;
- два: первый применяется для чисел, больших или равных нулю, второй -
для отрицательных;
- три: первый применяется для положительных, второй - для
отрицательных чисел, третий - для нуля.

Если форматы для отрицательных чисел или нуля пусты, применяется формат
для положительных чисел.

Если пуст формат для положительных чисел или спецификатор формата вообще
не задан (пустая строка), то числа форматируются согласно обобщенному
формату (как в функции FloatToStr). Такое форматирование применяется
также в случае, если число значащих цифр слева от десятичной точки
превысило 18 и не задан научный формат.

Применение спецификатора иллюстрируется в таблице на примере
преобразования четырех чисел:

|Спецификатор|1234|-1234|0.5|0|
|--------|--------|--------|--------|--------|
|0|1234|-1234|1|0|
|0.00|1234.00|-1234.00|0.50|0.00|
|#.##|1234|-1234|.5| |
|#.##0.00|1,234.00|-1,234.00|0.50|0.00|
|#,##0.00;(#,##0.00)|1,234.00|(1,234.00)|0.50|0.00|
|#,##0.00;;Zero|1,234.00|-1,234.00|0.50|Zero|
|0.000Е+00|1.234Е+03|-1.234Е+03|5.000Е-01|0.000Е+00|
|#.###Е-0|1.234ЕЗ|-1.234ЕЗ|5Е-1|0Е0|

Две следующие функции применяют те же правила, что и рассмотренные выше
функции, но отличаются параметрами:

    function FloatToText(Buffer: PChar; Value: Extended; Format: TFloatFormat; Precision, Digits: Integer) : Integer;        

Соответствует FloatToStrF, но выходная строка помещается в буфер Buffer
(без начальной длины!), а число символов в ней возвращается самой
функцией.

    function FloatToTextFmt(Buffer: PChar; Value: Extended; Format: PChar): Integer;

Соответствует FormatFloat, но выходная строка помещается в буфер
Buffer (без начальной длины!), а число символов в ней возвращается самой
функцией.

Наконец, процедура:

    procedure FloatToDecimal(var Result: TFloatRec; Value: Extended; Precision, Decimals: Integer);

Производит подготовительный анализ преобразуемого числа, занося в
поля записи Result различные его характеристики.

Перейдем к рассмотрению функций преобразования текстовой строки в число.
Их две - соответственно для строк типа string и PChar:

    function StrToPloat(const S: string): Extended;
    function TextToFloat(Buffer: PChar; var Value: Extended): Boolean;

Общие правила для передаваемой в функцию строки таковы:

- допускаются как научный, так и фиксированный форматы;

- в качестве десятичной точки должен выступать символ, который
содержится в DecimalSeparator;

- не допускаются символы-разделители тысяч (ThousandSeparator), а также
символы обозначения денежньк единиц.

В случае ошибки преобразования функция StrToFloat генерирует
исключительную ситуацию EConvertError, a TextToFloat - возвращает
значение False.
