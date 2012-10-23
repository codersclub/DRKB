<h1>Создание и использование типов данных</h1>
<div class="date">01.01.2007</div>


<p>Создание и использование типов данных</p>
&nbsp;</p>
Системные типы данных SQL Сервера используются при определении типа данных столбца таблицы в операторах create table (создать таблицу) и alter table (изменить таблицу), типа переменной в операторе declare (объявить), или типа параметра в операторе create procedure (создать процедуру). Эти операторы будут описаны в следующих главах этого руководства. Пользователь также может создавать свои типы данных и использовать их в этих операторах.</p>
&nbsp;</p>
В этой главе рассматриваются следующие темы:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="13">&#183;</td><td>Общий обзор типов данных;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="13">&#183;</td><td>Системные типы данных, предоставляемые SQL Сервером;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="13">&#183;</td><td>Как преобразовывать типы данных между собой;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="13">&#183;</td><td>Как смешанная арифметика выполняется в иерархии типов данных;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="13">&#183;</td><td>Как пользователь может определить свой тип данных;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="13">&#183;</td><td>Как получить информацию о типах данных.</td></tr></table></div>&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 21px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Что такое типы данных в Transact-SQL ?</td></tr></table></div>&nbsp;</p>
В языке Transact-SQL типы данных характеризуют тип информации, которая располагается в столбцах таблицы, передается как параметр сохраненной процедуре или хранится в локальной переменной. Например, тип данных int (целый) характеризует множество целых чисел в интервале от -231 до 231 , а тип данных tinyint (маленькое целое) указывает на числовой интервал от 0 до 255.</p>
SQL Сервер предоставляет несколько системных типов данных и два типа данных, которые может определить пользователь timestamp и sysname. Пользователь может использовать системную процедуру sp_addtype для создания своего типов данных, который базируется на имеющемся системном типе данных. (Типы данных, определенные пользователем, будут рассматриваться в разделе “Создание типов данных, определенных пользователем”.)</p>
Системные или заказные (пользовательские) типы данных должны быть уже определены, когда они используются для создания столбцов таблицы, локальных переменных или параметров. В следующем примере используются системные типы данных char (символьный), numeric (числовой) и money (денежный) для определения типов данных столбцов таблицы в операторе создания таблицы create table:</p>
&nbsp;</p>
create table sales_daily</p>
 &nbsp;&nbsp; (stor_id&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; char(4)</p>
 &nbsp;&nbsp;&nbsp; ord_num&nbsp;&nbsp; numeric(10,0)</p>
 &nbsp;&nbsp;&nbsp; ord_amt&nbsp;&nbsp;&nbsp; money)</p>
&nbsp;</p>
В следующем примере используется системный тип данных bit (битовый) для определения локальной переменной в операторе declare:</p>
&nbsp;</p>
declare @switch bit</p>
&nbsp;</p>
В следующих разделах более детально&nbsp; описывается, как задавать типы данных в столбцах таблицы, локальных переменных и параметрах. С помощью системной процедуры sp_help можно узнать, какие типы данных используются в существующих столбцах таблиц базы данных.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 21px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Использование системных типов данных</td></tr></table></div>&nbsp;</p>
В следующей таблице приведены системные типы данных, характеризующие различные виды информации, синонимы для названий этих типов, распознаваемые SQL Сервером, а также диапазон изменения данных и размеры памяти, используемой для хранения каждого&nbsp; типа данных. Системные типы данных указываются в этой таблице строчными буквами, хотя SQL Сервер позволяет указывать типы как строчными,&nbsp; так и прописными буквами. (Типы данных пользователя timestamp и sysname, как и все другие типы данных, определенные пользователем, являются чувствительными к регистру).&nbsp; Большинство названий системных типов данных SQL Сервера не являются зарезервированными словами, и их можно использовать для названия других объектов.</p>
&nbsp;</p>
Таблица 6-1: Системные типы данных SQL Сервера</p>
&nbsp;</p>
<table cellspacing="0" cellpadding="4" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td>Категории</p>
типов данных</p>
</td>
<td colspan="2" >Синонимы</p>
</td>
<td colspan="2" >Диапазон</p>
</td>
<td>Число байтов</p>
</td>
</tr>
<tr>
<td colspan="2" >Точные числовые: целые</p>
</td>
<td colspan="2" >&nbsp;</p>
</td>
<td colspan="2" >&nbsp;</p>
</td>
</tr>
<tr>
<td>tinyint</p>
</td>
<td colspan="2" >&nbsp;</p>
</td>
<td colspan="2" >от 0 до 255</p>
</td>
<td>1</p>
</td>
</tr>
<tr>
<td>smallint</p>
</td>
<td colspan="2" >&nbsp;</p>
</td>
<td colspan="2" >от 215-1 (32,767) до -215</p>
 (-32,768)</p>
</td>
<td>2</p>
</td>
</tr>
<tr>
<td>int</p>
</td>
<td colspan="2" >integer</p>
</td>
<td colspan="2" >от 231-1 (2,147,483,647) до</p>
 &nbsp;&nbsp;&nbsp; -231 (-2,147,483,648)</p>
</td>
<td>4</p>
</td>
</tr>
<tr>
<td colspan="2" >Точные числовые: десятичные</p>
</td>
<td colspan="2" >&nbsp;</p>
</td>
<td colspan="2" >&nbsp;</p>
</td>
</tr>
<tr>
<td>numeric (p,s)</p>
</td>
<td colspan="2" >&nbsp;</p>
</td>
<td colspan="2" >от 1038-1 до -1038</p>
</td>
<td>от 2 до 17</p>
</td>
</tr>
<tr>
<td>decimal (p,s)</p>
</td>
<td colspan="2" >dec</p>
</td>
<td colspan="2" >от 1038-1 до -1038</p>
</td>
<td>от 2 до 17</p>
</td>
</tr>
<tr>
<td colspan="2" >Приближенные числовые</p>
</td>
<td colspan="2" >&nbsp;</p>
</td>
<td colspan="2" >&nbsp;</p>
</td>
</tr>
<tr>
<td>float precision</p>
</td>
<td colspan="2" >&nbsp;</p>
</td>
<td colspan="2" >зависит от компьютера</p>
</td>
<td>4 или 8</p>
</td>
</tr>
<tr>
<td>double precision</p>
</td>
<td colspan="2" >&nbsp;</p>
</td>
<td colspan="2" >зависит от компьютера</p>
</td>
<td>8</p>
</td>
</tr>
<tr>
<td>real</p>
</td>
<td colspan="2" >&nbsp;</p>
</td>
<td colspan="2" >зависит от компьютера</p>
</td>
<td>4</p>
</td>
</tr>
<tr>
<td>Денежные</p>
</td>
<td colspan="2" >&nbsp;</p>
</td>
<td colspan="2" >&nbsp;</p>
</td>
<td>&nbsp;</p>
</td>
</tr>
<tr>
<td>smallmoney</p>
</td>
<td colspan="2" >&nbsp;</p>
</td>
<td colspan="2" >от 214,748.3647 до-214,748.3648</p>
</td>
<td>4</p>
</td>
</tr>
<tr>
<td>money</p>
</td>
<td colspan="2" >&nbsp;</p>
</td>
<td colspan="2" >от 922,337,203,685,477.5807 до</p>
  - 922,337,203,685,477.5808</p>
</td>
<td>8</p>
</td>
</tr>
<tr>
<td>Дата\время</p>
</td>
<td colspan="2" >&nbsp;</p>
</td>
<td colspan="2" >&nbsp;</p>
</td>
<td>&nbsp;</p>
</td>
</tr>
<tr>
<td>smalldatetime</p>
</td>
<td colspan="2" >&nbsp;</p>
</td>
<td colspan="2" >с 1 Января 1990 по 6 Июня 2079</p>
</td>
<td>4</p>
</td>
</tr>
<tr>
<td>datetime</p>
</td>
<td colspan="2" >&nbsp;</p>
</td>
<td colspan="2" >с 1 Января 1753 по 31 Декабря 9999</p>
</td>
<td>8
</td>
</tr>
</table>
Символьные</p>
<table cellspacing="0" cellpadding="4" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td>char(n)</p>
</td>
<td>character</p>
</td>
<td>255 символов или меньше</p>
</td>
<td>n</p>
</td>
</tr>
<tr>
<td>varchar(n)</p>
</td>
<td>character varying ,</p>
char varying</p>
</td>
<td>255 символов или меньше</p>
</td>
<td>длина введенной цепочки</p>
</td>
</tr>
<tr>
<td>nchar(n)</p>
</td>
<td>national char,</p>
national character</p>
</td>
<td>255 символов или меньше</p>
</td>
<td>n*@@ncharsize</p>
</td>
</tr>
<tr>
<td>nvarchar(n)</p>
</td>
<td>nchar varying,</p>
national char varying,</p>
national character</p>
varying</p>
</td>
<td>255 символов или меньше</p>
</td>
<td>@@ncharsize*</p>
число символов</p>
</td>
</tr>
<tr>
<td>text</p>
</td>
<td>&nbsp;</p>
</td>
<td>231-1 (2,147,483,647) байтов или меньше</p>
</td>
<td>0 или кратно 2K</p>
</td>
</tr>
<tr>
<td>Бинарные</p>
</td>
<td>&nbsp;</p>
</td>
<td>&nbsp;</p>
</td>
<td>&nbsp;</p>
</td>
</tr>
<tr>
<td>binary</p>
</td>
<td>&nbsp;</p>
</td>
<td>255 байтов или меньше</p>
</td>
<td>n</p>
</td>
</tr>
<tr>
<td>varbinary</p>
</td>
<td>&nbsp;</p>
</td>
<td>255 байтов или&nbsp; меньше</p>
</td>
<td>входная длина</p>
</td>
</tr>
<tr>
<td>image</p>
</td>
<td>&nbsp;</p>
</td>
<td>231-1(2,147,483,647) байтов или меньше</p>
</td>
<td>0 или кратно 2K</p>
</td>
</tr>
<tr>
<td>Битовые</p>
</td>
<td>&nbsp;</p>
</td>
<td>&nbsp;</p>
</td>
<td>&nbsp;</p>
</td>
</tr>
<tr>
<td>bit</p>
</td>
<td>&nbsp;</p>
</td>
<td>0 или 1</p>
</td>
<td>1 (один байт содержит до 8 битов)
</td>
</tr>
</table>
&nbsp;</p>
Описание каждого типа данных приводится далее.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Точные числовые типы: Целые</td></tr></table></div>&nbsp;</p>
SQL Сервер предоставляет три типа данных для задания целых чисел: tinyint (маленькое целое), smallint (малое целое) и int (целое). Эти типы данных являются точными числовыми, поскольку при выполнении арифметических операций с числами этих типов сохраняются все значящие цифры.</p>
Выбор нужного типа для хранения целых чисел основывается на ожидаемой&nbsp; величине этих чисел. Число байтов памяти, выделяемой для хранения чисел, зависит от типа данных.</p>
&nbsp;</p>
Таблица 6-2: Целые типы данных</p>
&nbsp;</p>
<table cellspacing="0" cellpadding="4" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td>Тип данных</p>
</td>
<td>Диапазон сохраняемых чисел</p>
</td>
<td>Число байтов памяти</p>
</td>
</tr>
<tr>
<td>tinyint</p>
</td>
<td>Все числа от 0 до 255, включительно. (Отрицательные значения не допускаются.)</p>
</td>
<td>1</p>
</td>
</tr>
<tr>
<td>smallint</p>
</td>
<td>Все числа от 215-1 до -215  (32,767 до -32,768), включительно.</p>
</td>
<td>2</p>
</td>
</tr>
<tr>
<td>int</p>
</td>
<td>Все числа от 231-1 до -231 (2,147,483,647 до</p>
-2,147,483,648), включительно</p>
</td>
<td>4
</td>
</tr>
</table>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td> Точные числовые типы: Десятичные числа</td></tr></table></div>&nbsp;</p>
Для хранения дробных чисел SQL Сервер предоставляет два других числовых типа данных numeric (числовой) и decimal (десятичный). Данные, которые хранятся в табличных столбцах типа numeric и decimal упаковываются для экономии дисковой памяти и сохраняются после арифметических операций с точностью до наименьшего значимого разряда. Типы данных numeric и decimal (десятичный) одинаковы во всех отношениях за исключением того, что&nbsp; только тип numeric с нулевой шкалой  может быть использован для столбца IDENTITY (счетчиковый).</p>
В определении точных числовых типов можно использовать два необязательных&nbsp; параметра, precision (точность) и scale (шкала), которые заключаются в скобки и разделяются запятой:</p>
&nbsp;</p>
datatype [(точность [, шкала])]</p>
&nbsp;</p>
SQL Сервер воспринимает каждую комбинацию этих параметров как отдельный тип данных. Например, numeric(10,0) и numeric(5,0) являются двумя отдельными типами данных. Точность и шкала определяют диапазон значений, которые можно хранить в табличных столбцах типа decimal или numeric:</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>Точность определяет максимальное число десятичных разрядов, которые могут храниться в столбце этого типа. Сюда включаются все разряды, расположенные как слева, так и справа от десятичной точки. Точность представления чисел можно выбрать из диапазона от 1 до 38 разрядов , или использовать точность в 18 разрядов, которая устанавливается по умолчанию;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>Шкала определяет максимальное число разрядов, которые могут располагаться справа от десятичной точки. Заметим, что шкала должна быть меньше или равна точности. Шкалу можно задавать от 0 до 38 разрядов, или использовать по умолчанию нулевую шкалу.</td></tr></table></div>&nbsp;</p>
Точные числовые значения со шкалой 0 выводятся без десятичной точки. Если в столбец таблицы вводится значение, которое превосходит либо точность, либо&nbsp; шкалу, установленную для этого столбца, то SQL Сервер укажет на ошибочное значение.</p>
Объем памяти, выделяемый для хранения в столбце значений типа numeric и decimal, зависит от точности, указанной для этого типа. Минимальный объем памяти для одно- или двухразрядных типов составляет 2 байта.&nbsp; Объем требуемой памяти возрастает на 1 байт на каждые два дополнительных разряда вплоть до максимальной величины, составляющей 17 байтов.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Приближенные числовые типы данных</td></tr></table></div>&nbsp;</p>
Для хранения числовых данных, которые округляются при выполнении арифметических операций, SQL Сервер предоставляет три приближенных числовых типа данных float (плавающий), double precision (двойная точность)  и real (действительный). Приближенные типы&nbsp; следует применять для данных, которые могут изменяться в широком диапазоне значений. К этим типам данных могут применяться&nbsp; все аггрегирующие функции и арифметические операции, за исключением операции вычисления по модулю ( %).</p>
Типы данных float и double precision построены на основе типов, содержащихся в операционной системе. Тип данных float допускает указание точности, которую нужно заключить в кавычки. Данные типа float с точностью от 1 до 15 разрядов храняться также как данные типа real, в то время как данные с более высокой точностью храняться также как данные типа double precision. Диапазон и точность представления данных этих трех типов зависят от используемого компьютера.</p>
В следующей таблице показаны диапазон, точность представления и объем памяти, предусмотренные для каждого приближенного числового типа. Заметим, что процедура isql выводит только 6 значащих разрядов после десятичной точки, а остаток округляет.</p>
&nbsp;</p>
Таблица 6-3: Приближенные числовые типы данных</p>
&nbsp;</p>
<table cellspacing="0" cellpadding="4" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td>Тип данных</p>
</td>
<td>Число байтов</p>
</td>
</tr>
<tr>
<td>float[(точность_по_умолчанию)]</p>
</td>
<td>  4, если точность &lt; 16,</p>
  8, если точность &gt;= 16</p>
</td>
</tr>
<tr>
<td>double precision</p>
</td>
<td>  8</p>
</td>
</tr>
<tr>
<td>real</p>
</td>
<td>  4
</td>
</tr>
</table>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Символьные типы данных</td></tr></table></div>&nbsp;</p>
Символьные типы данных используются для хранения символьных строк, состоящих из букв, цифр, символов, и заключенных в простые или двойные кавычки. Для работы с данными этого типа можно использовать ключевое слово like для поиска строк, содержащих указанную комбинацию символов, а также встроенные строковые функции. Строки, состоящие из цифр, можно&nbsp; преобразовать в данные точного или приближенного числового типа с помощью функции convert (преобразовать), а затем выполнять арифметические операции.</p>
Данные типа char(n) хранятся в массиве байтов фиксированной длины, а данные типа varchar(n) в массиве переменной длины, когда число символов алфавита не превосходит емкости одного байта, как например для строки на&nbsp; английском языке. “Национальные” двойники для данных этих типов, т.е. данные типа nchar(n) и nvarchar(n) хранятся соответственно в массивах фиксированной и переменной длины, но на хранения одного символа может выделяться несколько байтов, как например для строки на японском языке. Максимальное число символов в строке можно задать параметром n или&nbsp; по умолчанию ограничиться строкой в один символ. Для&nbsp; строк, длина которых превосходит емкость одного байта (т.е. 255), следует использовать тип данных text (текст).</p>
&nbsp;</p>
Таблица 6-4: Символьные типы данных</p>
&nbsp;</p>
<table cellspacing="0" cellpadding="4" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td>Тип данных</p>
</td>
<td>Метод&nbsp; хранения</p>
</td>
<td>Число Байтов</p>
</td>
</tr>
<tr>
<td>char(n)</p>
</td>
<td>Массив байтов фиксированной длины, например, для телефонных номеров или почтовых кодов</p>
</td>
<td>n</p>
</td>
</tr>
<tr>
<td>varchar(n)</p>
</td>
<td>Массив байтов переменной длины, например, для имен и фамилий, изменяющихся в широких пределах</p>
</td>
<td>Текущая длина строки</p>
</td>
</tr>
<tr>
<td>nchar(n)</p>
</td>
<td>Массив фиксированной длины для строк в мультибайтовом алфавите</p>
</td>
<td>n*@@ncharsize</p>
</td>
</tr>
<tr>
<td>nvarchar(n)</p>
</td>
<td>Массив переменной длины для строк в мультибайтовом алфавите</p>
</td>
<td>Текущая длина строки*@@ncharsize</p>
</td>
</tr>
<tr>
<td>text</p>
</td>
<td>Связанный список страниц данных, достигающий 2,147,483,647 байтов, для хранения печатных символов</p>
</td>
<td>0, пока&nbsp; текст не&nbsp; инициализирован; по 2K байтов на страницу после инициализации
</td>
</tr>
</table>
&nbsp;</p>
SQL Сервер укорачивает вводимые в столбец таблицы строки до ширины этого столбца, без специальных предупреждений и сообщений об ошибке, если не установлена опция string_truncation on. О команде установки опций set можно прочесть в Справочном руководстве SQL Сервера. Пустая строка (“” или “) хранится в виде одного пробела, а не как NULL (неопределенное значение). Следовательно, значением выражения “abc”+“”+“def” является строка “abc def “ , а не “abcdef”.</p>
&nbsp;</p>
Хранение строк в столбцах с фиксированной и переменной длиной отличается друг от друга в следующих отношениях:</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>Строки в столбцах фиксированной длины с конца дополняются пробелями до длины этого столбца. Для данных типа char отводится n байтов памяти; а для данных типа nchar число n умножается на значение переменной @@ncharsize, которое равно средней длине (в байтах) символа национального алфавита. Когда создается столбец типа char и nchar, в котором допускаются неопределенные значения, то SQL Сервер автоматически преобразует их в типы varchar и nvarchar соответственно и сохраняет значения в соответствии с этими типами данных. (Этого не происходит для переменных типа char и nchar, и параметров).</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>В строках, расположенных в столбцах переменной длиной, наоборот концевые пробелы удаляются, поэтому память затрачивается только на хранение значащих символов. Для столбцов типа varchar число байтов, использующихся для хранения данных, равно длине строки; а для столбцов nvarchar это число равно длине строки, умноженной на среднюю длину символов национального алфавита. Данные переменной длины могут требовать меньший объем памяти для хранения по сравнению с данными фиксированной длины, но доступ к ним происходит медленнее.</td></tr></table></div>&nbsp;</p>
Данные типа text могут достигать длины до 2,147,483,647 печатных символов (байтов) и память для них выделяется отдельными страницами, которые храняться в виде связанного списка. Для экономии памяти, столбцы типа text следует определять с опцией NULL. При первой записи непустого текста в такой столбец операторами insert (вставить) или update (обновить), SQL Сервер заводит текстовый указатель и выделяет полную страницу памяти размером 2K байтов для хранения этого текста. Каждая страница может хранить до 1800 байтов текста. Для добавления данных без сохранения больших блоков текста в журнале транзакций, следует использовать процедуру writetext (запись текста). Об этом можно получить информацию в Справочном Руководство SQL Сервера.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Двоичные типы данных</td></tr></table></div>&nbsp;</p>
Двоичные (бинарные) типы данных предназначены для хранения неформатированной двоичной информации, например, графических изображений в 16-ричном коде. Двоичные данные начинаются с символов вида ”0x” и могут содержать любую комбинацию цифр, а также строчные или прописные буквы от A до F.</p>
&nbsp;</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Замечание:  Обработка SQL Сервером двоичных данных зависит от реализации. Для данных в настоящем шестнадцатиричном коде следует использовать функции hextoint и inttohex. См. по этому поводу главу 10 “Использование встроенных функций в запросах”.</p>
&nbsp;</p>
Типы binary(n) и varbinary(n) используются для хранения данных размером до 255 байтов. Каждый байт памяти содержит 2 шестнадцатиричные цифры. Длину данных, вносимых в столбец, можно определить числом n или использовать по умолчанию длину в один байт. Если в столбец таблицы ввести данные, длина которых превышает число n, то SQL Сервер укорачивает введенные данные до указанной длины без предупреждений и сообщений об ошибке.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>Тип данных с фиксированной длиной binary(n) следует использовать для хранения наборов данных, в которых все члены набора имеют примерно одинаковую длину.  Поскольку данные в столбцах с этим типом дополняются нулями до длины столбца, то они могут потребовать для своего хранения несколько большего объема памяти , по сравнению с данными типа varbinary, но доступ к ним происходит немного быстрее;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>Тип данных с переменной длиной varbinary(n) следует использовать для хранения наборов данных, в которых размеры отдельных членов набора могут сильно изменяться. Объем памяти, необходимый для хранения таких данных, определяется действительной длиной этих данных, а не длиной столбца. При этом нули на концах двоичных строк отбрасываются.</td></tr></table></div>&nbsp;</p>
При создании столбца типа binary, в котором допускаются неопределенные значения, SQL Сервер автоматически преобразует его в тип varbinary и хранит данные в этом формате.</p>
Можно проводить поиск в двоичных строках с помощью ключевого слова like, а также применять к ним встроенные функции. Поскольку точный вид внутреннего представления двоичных данных зависит от аппаратного обеспечения, то вычисления, включающие двоичные данные, могут выдавать различные результаты на разных платформах.</p>
Двоичный тип данных image (изображение) следует использовать для хранения больших блоков двоичных данных на внешних страницах данных. В столбце типа image можно записать до 2,147,483,647 байтов информации, которая хранится в виде связанного списка страниц данных, отдельно от других табличных данных. При первой записи определенного значения в столбец типа image  операторами insert или update, SQL Сервер заводит текстовый указатель и выделяет полную страницу данных размером 2К для хранения этого значения. Каждая страница может содержать до 1800 байтов информации.</p>
Для экономии памяти, в столбцах типа image следует допускать неопределенное значение NULL. Следует также использовать процедуру writetext, чтобы при добавлении данных в столбец типа image в журнал транзакций не записывались большие блоки текста. Более детальную информацию по этому поводу можно посмотреть в Справочном руководство SQL сервера.</p>
&nbsp;</p>
Таблица 6-5: Бинарные типы данных</p>
&nbsp;</p>
<table cellspacing="0" cellpadding="4" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td>Тип данных</p>
</td>
<td>Число байтов памяти</p>
</td>
</tr>
<tr>
<td>binary(n)</p>
</td>
<td>n</p>
</td>
</tr>
<tr>
<td>varbinary(n)</p>
</td>
<td>Действительная длина данных</p>
</td>
</tr>
<tr>
<td>image</p>
</td>
<td>0 , когда не инициализирован, кратно 2К после инициализации
</td>
</tr>
</table>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Денежные типы данных</td></tr></table></div>&nbsp;</p>
Денежные типы данных money (денежный формат) и smallmoney (малый денежный формат), предназначены для хранения денежных величин. Их можно использовать для хранения сумм в долларах США или в других валютах, хотя SQL Сервер не обеспечивает преобразования одного вида валют в другой. Над денежными величинами можно выполнять любые арифметические операции, кроме операции взятия модуля, и&nbsp; все аггрегирующие функции.</p>
Данные типа money и smallmoney имеют точность до 1/10000 денежной единицы и округляются до двух знаков после десятичной точки при выводе.&nbsp; По умолчанию при печати после каждых трех цифр вставляется запятая.</p>
В следующей таблице приведены диапазон сохраняемых значений и объем памяти, необходимый для хранения денежных типов данных:</p>
&nbsp;</p>
Таблица 6-6: Денежные типы данных</p>
&nbsp;</p>
<table cellspacing="0" cellpadding="4" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td>Тип Данных</p>
</td>
<td>Диапазон</p>
</td>
<td>Число байтов</p>
</td>
</tr>
<tr>
<td>money</p>
</td>
<td>Денежные величины между +922,337,203,685,477.5807 и</p>
 -922,337,203,685,477.5808</p>
</td>
<td>8</p>
</td>
</tr>
<tr>
<td>smallmoney</p>
</td>
<td>Денежные величины между +214,748.3647 и</p>
-214,748.3648</p>
</td>
<td>4
</td>
</tr>
</table>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Типы данных для даты и времени</td></tr></table></div>&nbsp;</p>
Данные типа datetime (дата, время) и smalldatetime (укороченная дата и время) используются для хранения информации о времени и датах в пределах от 1 Января 1753 года до 31 Декабря 9999 года. Даты, не попадающие в эти пределы, должны храниться как данные типа char и varchar.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>В столбцах типа datetime хранятся даты в пределах между 1 Января 1753 года и 31 Декабря 9999 года. Значения типа datetime имеют точность до 1/300 секунды на тех платформах, которые поддерживают этот уровень точности. Объем памяти для хранения равен 8 байтам: 4 байта для числа дней по отношению к базовой дате 1 Января 1900 года и 4 байта для времени дня.</td></tr></table></div>&nbsp;</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>В столбцах типа smalldatetime хранятся даты от 1 Января 1900 года до 6 Июня 2079 года с точностью до минуты. Объем памяти, необходимый для их хранения, равен 4 байтам: 2 байта для числа дней после 1 Января 1900 года и 2 байта для числа минут после полуночи.</td></tr></table></div>&nbsp;</p>
Значения даты и времени должна быть заключены в простые или двойные кавычки. Они могут вводиться как строчными, так и заглавными буквами и могут содержать пробелы между различными частями даты. SQL Сервер распознает много форматов дат, которые будут описаны в Главе 8.</p>
Нулевые значения или значения вида 00/00/00 не являются датами и поэтому не воспринимаются при вводе.</p>
По умолчанию даты и время выводятся в следующем формате: “Apr 15 1987 10:23PM”. Можно использовать функцию convert (преобразование) для изменения формата вывода для даты и времени. Над значениями типа datetime можно выполнять некоторые арифметические операции с помощью встроенных функций.</p>
В следующей таблице показаны диапазоны сохраняемых значений и объемы памяти, необходимые для хранения данных этого типа:</p>
&nbsp;</p>
Таблица 6-7: Данные типа даты и времени</p>
&nbsp;</p>
<table cellspacing="0" cellpadding="4" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td>Тип данных</p>
</td>
<td>Диапазон</p>
</td>
<td>Число байтов</p>
</td>
</tr>
<tr>
<td>datetime</p>
</td>
<td>от 1 Января 1753 года до 31 Декабря 9999</p>
</td>
<td>8</p>
</td>
</tr>
<tr>
<td>smalldatetime</p>
</td>
<td>от 1 Января 1900 года до 6 Июня 2079</p>
</td>
<td>4
</td>
</tr>
</table>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Битовые типы данных (bit)</td></tr></table></div>&nbsp;</p>
Битовый тип используется для хранения двузначных данных типа истина и ложь, или да и нет. Битовые данные могут принимать только два значения: 0 или 1. Здесь допустимы также целые значения, но все числа, отличные от 0 или 1,&nbsp; интерпретируются как 1. На хранения данных этого типа выделяется один байт. Массивы битов собираются в байты. Например, на хранение массива из 7 битов в столбце таблицы будет выделен 1 байт, а на хранение 9 битов - 2 байта.</p>
Столбцы этого типа не могут содержать неопределенное значение NULL&nbsp; и не могут индексироваться. Столбец status в системной таблице syscolumns содержит&nbsp; уникальное смещение для столбцов этого типа.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Тип данных timestamp</td></tr></table></div>&nbsp;</p>
SQL Сервер также предоставляет пользовательский тип данных timestamp (текущее время). Данные этого типа необходимы в таблицах, которые просматриваются в приложениях Open Client™ DB-Library™.</p>
Каждый раз, когда в строку, содержащую поле timestamp, вставляются или обновляется данные, содержимое этого поля автоматически обновляется. Таблица может иметь только один столбец этого типа. Столбцу с названием timestamp автоматически присваивается системный тип данных timestamp, который определяется как varbinary(8)  NULL.</p>
Поскольку тип timestamp может определяться пользователем, его нельзя использовать для создания других типов данных. Этот тип данных следует указывать как “timestamp” и записывать строчными буквами.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Тип данных sysname</td></tr></table></div>&nbsp;</p>
Тип данных sysname предназначается конечным пользователям и поставляется вместе с инсталяционной лентой SQL Сервера для использования в системных таблицах. Он определяется следующим образом:</p>
&nbsp;</p>
varchar(30)&nbsp; “not null”</p>
&nbsp;</p>
Этот тип данных нельзя использовать при создании таблиц. Он является базовым для создания новых типов данных пользователя. В свою очередь, созданный на его базе тип данных, уже можно использовать в таблицах как user-defined datatype (тип данных, определенный пользователем). Более подробная информация о типах данных пользователей будет приведена в разделе “Создание типов данных пользователя”.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 21px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Преобразования типов данных</td></tr></table></div>&nbsp;</p>
Многие типы данных SQL Сервер автоматически преобразует друг в друга. Это называется неявным преобразованием. Пользователь может также явно&nbsp; выполнить преобразование типов с помощью функций convert (преобразовать), inttohex (целое в 16-ричное), hextoint (16-ричное в целое). Тем не менее некоторые типы данных нельзя ни явно, ни неявно преобразовать один к другому, из-за несовместимости этих типов.</p>
Например, в то время как SQL Сервер автоматически преобразует данные типа char в данные типа datetime, чтобы они интерпретировались как даты, тем не менее пользователь должен использовать функцию convert для явного преобразования данных типа char в данные типа int. Точно также с помощью функции convert нужно явно выполнять и обратное преобразование целых чисел в символьные строки, чтобы, например, можно было применить к ним функцию&nbsp; like.</p>
Функция convert вызывается следующим образом:</p>
&nbsp;</p>
convert (тип_данных, выражение, [стиль])</p>
&nbsp;</p>
Например, рассмотрим следующий оператор:</p>
&nbsp;</p>
select title, total_sales</p>
from titles</p>
where convert (char(20), total_sales) like "2%"</p>
&nbsp;</p>
Необязательный параметр стиль (style) используется для преобразования значения типа datetime в значения типа char или varchar для варьирования форматов представления дат.</p>
В главе 10 дается подробная информация о функциях convert, inttohex, hextoint.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 21px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Смешанная&nbsp; арифметика и иерархия типов данных</td></tr></table></div>&nbsp;</p>
При выполнении арифметических операций над данными различных типов, SQL Сервер должен определить тип результата, а также его точность и длину.</p>
Каждый системный тип данных занимает определенное место в иерархии типов данных, которая хранится в системной таблице systypes. Типы данных, определенные пользователем, наследуют иерархию системных типов, на которых они основаны.</p>
Следующий запрос отражает место (ранг), занимаемое каждым типом данных в этой иерархии. В дополнение к системной информации в результат этого запроса будет включаться информация о всех типах данных, определенных пользователями базы данных.</p>
&nbsp;</p>
select name,hierarchy</p>
from systypes</p>
order by hierarchy</p>
&nbsp;</p>
name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; hierarchy</p>
----------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -----------</p>
floatn &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 1&nbsp;&nbsp;&nbsp;&nbsp;</p>
float &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 2&nbsp;&nbsp;</p>
datetimn &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 3&nbsp;</p>
datetime &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 4&nbsp;&nbsp;</p>
real &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 5&nbsp;</p>
numericn &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 6&nbsp;</p>
numeric &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 7&nbsp;&nbsp;</p>
decimaln &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 8&nbsp;</p>
decimal &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 9&nbsp;</p>
moneyn &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 10&nbsp;</p>
money &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;11&nbsp;&nbsp;&nbsp;</p>
smallmoney &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;12&nbsp;</p>
smalldatetime &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;13&nbsp;&nbsp;&nbsp;&nbsp;</p>
intn &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;14&nbsp;&nbsp;&nbsp;</p>
int &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;15&nbsp;&nbsp;&nbsp;</p>
smallint &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 16&nbsp;</p>
tinyint &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;17&nbsp;</p>
bit &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;18&nbsp;</p>
varchar &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 19&nbsp;&nbsp;&nbsp;</p>
sysname &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 19&nbsp;&nbsp;&nbsp;</p>
nvarchar &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 19&nbsp;&nbsp;&nbsp;&nbsp;</p>
char &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;20&nbsp;</p>
nchar &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;20&nbsp;&nbsp;</p>
varbinary &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 21&nbsp;&nbsp;</p>
timestamp &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;21&nbsp;&nbsp;</p>
binary &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;22&nbsp;</p>
text &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;23&nbsp;</p>
image &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;24</p>
&nbsp;</p>
(Выбрано 28 строк)</p>
&nbsp;</p>
Иерархия типов данных определяет тип результата при вычислениях с аргументами разного типа. Результату присваивается наивысший по рангу тип аргумента,&nbsp; т.е. имеющий меньший номер в иерархии.</p>
В следующем примере данные из столбца qty  таблицы sales умножаются на содержимое столбца royalty таблицы roysched. Столбец qty имеет тип данных smallint, который занимает в иерархии 16 ранг, а столбец royalty  имеет тип int, который занимает 15 ранг. Следовательно, результат будет иметь тип int.</p>
&nbsp;</p>
smallint(qty) * int(royalty) = int</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Работа с денежными типами данных</td></tr></table></div>&nbsp;</p>
Если данные денежного типа комбинируютя с константами (литералами) и&nbsp; переменными для получения результата, который также должен иметь денежный тип, то следует использовать константы и переменные денежного типа, как это показано в следующем примере:</p>
&nbsp;</p>
select moneycol * $2.5 from mytable</p>
&nbsp;</p>
При комбинировании данных денежного типа с данными типами float или numeric, следует использовать функцию convert:</p>
&nbsp;</p>
select convert (money, moneycol * percentcol)</p>
 &nbsp;&nbsp; from debts, interest</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Указание точности и шкалы значений</td></tr></table></div>&nbsp;</p>
Для типов данных numeric и decimal любая комбинация значений точности и шкалы интерпретируется SQL Сервером как отдельный тип данных. При выполнении арифметических операций с двумя значениями типа numeric или&nbsp; decimal, одно из которых n1 имееет точность p1 и шкалу s1, а второе n2 - точностью p2 и шкалой s2, то SQL Сервер определяет точность и шкалу результата в соответствии со следующей таблицей.</p>
&nbsp;</p>
Таблица 6-8: Точность и шкала результата арифметических операций</p>
&nbsp;</p>
<table cellspacing="0" cellpadding="4" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td>Операция</p>
</td>
<td>Точность</p>
</td>
<td>Шкала</p>
</td>
</tr>
<tr>
<td>n1+n2</p>
</td>
<td>max(s1,s2)+max(p1-s1,p2-s2)+1</p>
</td>
<td>max(s1,s2)</p>
</td>
</tr>
<tr>
<td>n1-n2</p>
</td>
<td>max(s1,s2)+max(p1-s1,p2-s2)+1</p>
</td>
<td>max(s1,s2)</p>
</td>
</tr>
<tr>
<td>n1*n2</p>
</td>
<td>s1+s2+(p1-s1)+(p2-s2)+1</p>
</td>
<td>s1+s2</p>
</td>
</tr>
<tr>
<td>n1/n2</p>
</td>
<td>max(s1+p2+1,6)+p1-s1+p2</p>
</td>
<td>max(s1+p2-s2+1,6)
</td>
</tr>
</table>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 21px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Создание типов данных пользователя</td></tr></table></div>&nbsp;</p>
Одним из расширений языка Transact-SQL по отношению к SQL является возможность определения пользователем своих типов данных (нестандартных типов). Типы данных&nbsp; пользователя определяются через системные типы. Пользователь может присвоить название часто встречающемуся типу данных, чтобы упростить процесс определения столбцов с нестандартными (несистемными) типами данных.</p>
&nbsp;</p>
Замечание: Для использования нестандартного типа данных более чем в одной базе данных, необходимо создать его в модельной (model) базе данных. Такой тип данных становится доступным во всех вновь созданных базах данных.</p>
&nbsp;</p>
Однажды определенный тип данных можно использовать в любом столбце таблицы базы данных. Например, тип данных tid используется в столбцах таблиц titles.title_id, titleauthor.title_id, roysched.title_id базы данных pub2.</p>
Преимущество нестандартных типов данных состоит в том, что с ними можно связывать правила и значения по умолчанию, чтобы использовать их в нескольких таблицах. Более полная информация об этом будет дана в главе 12.</p>
Для создания нестандартных типов данных используется системная процедура sp_addtype (добавить тип). В качестве обязательных параметров этой процедуре передается название создаваемого типа данных и системный тип данных, на котором базируется новый тип, а в качестве необязательных параметров для нее можно указать спецификации NULL, NOTNULL или IDENTITY.</p>
Нестандартный тип данных может базироваться на любом системном типе данных, за исключением типа timestamp. Нестандартные типы данных получают те же ранги в иерархии, что и системные типы, на которых они основаны. В отличие от системных типов данных, в написании названий нестандартных типов различаются заглавные и строчные буквы.</p>
Процедура sp_addtype вызывается следующим образом:</p>
&nbsp;</p>
sp_addtype название_типа_данных,</p>
ситемный_тип_данных&nbsp; [(длина) | (точность [, шкала])]</p>
[, "identity" | вид_неопределенности]</p>
&nbsp;</p>
Далее показано, как определяется тип данных tid:</p>
&nbsp;</p>
sp_addtype tid, "char(6)", "not null"</p>
&nbsp;</p>
Параметры процедуры должны заключаться в простые или&nbsp; двойные кавычки в том случае, если они содержат пробелы или другие знаки пунктуации, или если ключевым словом является слово, отличное от null (например, identity или sp_helpgroup). В этом примере, из-за наличия скобок, в кавычки заключен параметр char(6), а, из-за пробела, параметр NOT NULL. Для параметра tid кавычки  не требуются.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Указание длины, точности и шкалы</td></tr></table></div>&nbsp;</p>
При определении нестандартных типов данных необходимо указывать дополнительные параметры для следующих системных типов данных, на которых базируется новый тип:</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>В типах данных char, nchar, varchar, nvarchar, binary и varbinary следует в скобках указать длину. Если этого не сделать, то SQL Сервер по умолчанию установит длину, равную одному символу;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>Для типа данных float следует в скобках указать точность. В противном случае SQL Сервер по умолчанию установит точность, которая зависит от реализации;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>Для типов данных numeric и decimal следует указать в скобках через запятую точность и шкалу. В противном случае SQL Сервер по умолчанию установит точность, равную 18, и шкалу, равную 0.</td></tr></table></div>&nbsp;</p>
Нельзя изменять длину, точность и шкалу нестандартного типа данных при его использовании в операторе создания таблицы create table.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Указание параметра неопределенности (Null)</td></tr></table></div>&nbsp;</p>
Параметр неопределенности указывает на возможность использования неопределенного значения в данных определяемого типа. В качестве этого параметра можно указать: “null”, “NULL”, “nonull”, “NONULL”, “not null” или “NOT NULL”. По определению, в данных типах bit и IDENTITY не допускаются неопределенные значения.</p>
Если опустить этот параметр, то SQL Сервер установит текущий для данной базы данных вид неопределенности (по умолчанию NOT NULL). Для совместимости со стандартами SQL необходимо использовать системную процедуру sp_dboption для установки опции allow nulls by default (разрешить неопределенность по умолчанию) в состояние истина (true).</p>
Возможность присутствия неопределенности в данных нестандартного типа можно переустановить, когда этот тип данных используется в операторе create table.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Связывание правил и умолчаний с нестандартными типами данных</td></tr></table></div>&nbsp;</p>
После того как создан новый тип данных, можно использовать системные процедуры sp_bindrule и sp_bindefault для связывания с ним правил и значений по умолчанию. С помощью системной процедуры sp_help можно увидеть список правил, умолчаний и другую информацию, связанную с типом данных.</p>
Создание правил и значений по умолчанию будет рассмотрено в главе 12. Более подробная информация о системных процедурах дается в Справочном Руководстве SQL Сервера.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Удаление нестандартных типов данных</td></tr></table></div>&nbsp;</p>
Для удаления нестандартных типов данных следует выполнить процедуру sp_droptype:</p>
&nbsp;</p>
sp_droptype название_типа_данных</p>
&nbsp;</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Замечание: Нельзя удалять тип данных, который используется в какой-нибудь таблице.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 21px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Получение информации о типах данных</td></tr></table></div>&nbsp;</p>
Для получения информации о системных и нестандартных типах данных следует выполнить системную процедуру sp_help. В результирующем отчете эта процедура указывает базовый тип данных, на основе которого был создан новый тип, допускаются ли для этого типа данных неопределенные значения, приводятся названия правил и умолчаний, связанных с новым типом данных и может ли этот тип данных использоваться для создания счетчиков (IDENTITY).</p>
В следующем примере приводится информация о системном типе данных money и нестандартном типе данных tid:</p>
&nbsp;</p>
sp_help money</p>
&nbsp;</p>
Type_name&nbsp;&nbsp; Storage_type  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Length&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Prec&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Scale&nbsp;</p>
---------------&nbsp;&nbsp;&nbsp;&nbsp; ------------&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; ------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -----</p>
money &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;money &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 8  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NULL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NULL</p>
&nbsp;</p>
Nulls&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Default_name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Rule_name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Identity</p>
-----&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ------------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ---------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; --------</p>
 &nbsp; 1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NULL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NULL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 0</p>
&nbsp;</p>
&nbsp;</p>
sp_help tid</p>
&nbsp;</p>
Type_name&nbsp;&nbsp; Storage_type&nbsp; Length&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Prec&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Scale&nbsp;</p>
----------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ------------&nbsp; ------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -----&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -----</p>
tid&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; varchar&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 6&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NULL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NULL</p>
&nbsp;</p>
Nulls&nbsp;&nbsp; Default_name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Rule_name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Identity</p>
-----&nbsp;&nbsp;&nbsp;&nbsp; ------------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ---------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; --------</p>
 &nbsp; 0&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NULL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NULL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 0</p>

