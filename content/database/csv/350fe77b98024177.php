<h1>ASCII драйвер для CSV-файлов</h1>
<div class="date">01.01.2007</div>



<p>Использование драйвера ASCII для файлов с разделительной запятой </p>

<p>Delphi (и BDE) имеют способность использовать ASCII файлы для хранения таблиц. Драйвер ASCII имеет возможность транслировать значения данных ASCII-поля фиксированной длины или файла с разделительной запятой в поля и величины, которые могут отображаться компонентом TTable. Трансляция ASCII файла целиком зависит от сопровождающего файла схемы (Schema File). Файл схемы для файла ASCII данных определяет различные атрибуты, необходимые для преобразования данных ASCII файла в значения отдельных полей. Определения полей для файла с ASCII полями фиксированной длины достаточно простая задача, необходимо знать позиции всех полей, для всех строк они одинаковы. Для файлов с разделительной запятой данный процесс чуть более усложнен из-за того, что не все данные в таком файле во всех строках имеют одинаковую длину. Данный совет как раз и концентрируется на описании этой трудной темы, связанной с чтением данных из файлов с разделительной запятой, имеющих варьируемую длину поля. </p>

<p>Файл схемы </p>

<p>Файл схемы для файла данных ASCII содержит информацию, которая определяет оба типа файла (версии с разделительной запятой и полем с фиксированной длиной), а также определяет поля, которые представлены значениями данных в каждой строке файла данных ASCII. (Все поля файла схемы нечуствительны к регистру, поэтому написание "ascii" равнозначно написанию "ASCII".) Для того, чтобы файл схемы был признан в качестве такового, он должен иметь то же имя, что и файл данных ASCII, для которого он содержит схему, но иметь расширение .SCH (SCHema - схема). Атрибуты описания файла:</p>

<p>  File name: Располагаемый в квадратных скобках, данный атрибут определяет</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; имя файла ASCII данных (с расширением имени файла,</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; которое должно быть .TXT).</p>

<p>  Filetype:&nbsp; Определяет, имеет ли файл ASCII данных структуру файла с</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; полями фиксированной длины (используется атрибут FIXED) или </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; файлом с разделительной запятой (со значениями данных, которые </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; потенциально могут изменять длину (используется атрибут VARYING).</p>

<p>  Delimiter: Определяет символ, которым "окантуривают" значения данных типа</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; String (обычно двойные кавычки, десятичный ASCII код 34).</p>

<p>  Separator: Определяет символ, который используется для разделения отдельных </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; значений данных (обычно запятая). Данный символ должен быть </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; видимым символом, т.е. не может быть пробелом (десятичный ASCII </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; код 32).</p>

<p>  CharSet:&nbsp;&nbsp; Определяет драйвер языка (используется атрибут ASCII).</p>
<p>Расположенные ниже атрибуты файла являются определениями поля, задающими правила для каждой строки файла данных ASCII. Данные определения служат источником информации для Delphi и BDE, первоначально необходимой для создания виртуального поля в памяти, в свою очередь служащее для хранения значений данных; тип данных виртуального поля определяется после чтения и трансляции данных из ASCII файла, определения размера и применения атрибутов. Различные атрибуты, определяющие поле файла данных ASCII: </p>

<p>  Field:&nbsp;&nbsp;&nbsp; Имя виртуального поля (всегда будет "Field"), сопровождаемое</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; целым числом, определяющим порядковый номер поля относительно </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; других полей в файле данных ASCII. Например, первое поле -</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Field1, второе Field2, и т.д..</p>

<p>  Field name: Определяет выводимое имя поля, отображаемое в виде</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; заголовка колонки в TDBGrid. Соглашения имен для</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; таблиц ASCII такие же, как и для таблиц Paradox.</p>

<p>  Field type:&nbsp;&nbsp; Определяет, какой тип данных BDE должен использоваться при</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; трансляции значений данных каждого поля и сообщает</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Delphi тип виртуального поля, которое необходимо создать.</p>

<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Используйте определение Для значений типа</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ----------------------- ----------------------------</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; CHAR&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Символ</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; FLOAT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 64-битное число с плавающей точкой</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NUMBER&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 16-битное целое</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; BOOL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Boolean (T или F)</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; LONGINT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 32-битное длинное целое</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; DATE&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Поле Date.</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; TIME&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Поле Time.</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; TIMESTAMP&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Поле Date + Time.</p>

<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (Фактически формат для значений данных даты и времени</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; будет определяться текущими настройками конфигурации BDE, </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; страница с закладкой Date.)</p>

<p>  Data value length:&nbsp; Максимальная длина значения данных соответствующего поля. </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Данный атрибут определяет длину виртуального поля, </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; создаваемое Delphi для получения считываемых значений из</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ASCII-файла.</p>

<p>  Number of decimals: Приложение к полю типа FLOAT; определяет количество цифр</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; справа от десятичной точки; необходимо для включения в</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; определение виртуального поля.</p>

<p>  Offset:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Отступ от начала строки, позиция начала данных описываемого </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; поля; задается для всех строк файла.</p>
<p>Например, приведенное ниже определение поля относится к первому полю таблицы ASCII. Данная строка определяет значения данных типа String с именем "Text", максимальная длина значения данных составляет три символа (и в Delphi компонентах для работы с базами данных, типа TDBGrid, поле будет отображаться только тремя символами), десятичный порядок (значение данных типа String никогда не сможет иметь десятичные значения, тем более после запятой), и смещение относительно нулевой позиции (поскольку описываемая область первая, то она сама начинается с нулевой позиции, перед ней не находится ни одно поле). </p>

<p>  Field1=Text,Char,3,00,00</p>
<p>Вот пример файла схемы с тремя полями, первое поле имеет тип String, второе и третье тип Date. Данный файл схемы должен содержаться в файле с именем DATES.SCH и обеспечивать определения полей для файла данных ASCII с именем DATES.TXT.</p>
<p>  [DATES]</p>
<p>  Filetype=VARYING</p>
<p>  Delimiter="</p>
<p>  Separator=,</p>
<p>  CharSet=ascii</p>
<p>  Field1=Text,Char,3,00,00</p>
<p>  Field2=First Contact,Date,10,00,03</p>
<p>  Field3=Second,Date,10,00,13</p>
<p>Данная схема определяет поле с разделительной запятой, где все данные могут быть отнесены к типу String, значения полей "окантурены" двойными кавычками и отдельные значения полей разделены запятой (за исключением любых запятых, которые могут находится между разделительными запятыми, внутри отдельных значений полей типа String). Первое поле типа character имеет длину три символа, без определения десятичного порядка и с нулевым отступом от начала строки. Второе поле данных имеет длину 10, без определения десятичного порядка и отступ, равный трем. Третье поле данных имеет длину 10, без определения десятичного порядка и отступ, равный 13. </p>
<p>Для чтения файлов ASCII с разделительной запятой, параметры длины и отступа для определения поля относятся не к значениям данных в файлах ASCII (что явно противоположно для файлов с полями фиксированной длиной), а к виртуальным полям, определяемым в приложении, в котором будет размещены считываемые данные. Параметр длины должен отражать максимальную длину значений данных для каждого поля, не считая огриничительных кавычек и разделительной запятой. Это наиболее трудно при оценке значений данных типа String, поскольку фактическая длина значений данных может быть существенно различаться для каждой строки в файле данных ASCII. Параметр отступа для каждого поля не будет являться позицией значений данных в файле ASCII (что относится к файлам с полями фиксированной длины), а представляет собой совокупную длину всех предыдущих полей (и снова, определение полей в памяти, не значения данных в файле ASCII). </p>

<p>Вот файл данных с именем DATES.TXT, который соответствует описанному выше файлу схемы:</p>

<p>  "A",08/01/1995,08/11/19955 </p>
<p>  "BB",08/02/1995,08/12/1995 </p>
<p>  "CCC",08/03/1995,08/13/1995</p>
<p>Максимальная длина фактических значений данных в первом поле составляет три символа ("CCC"). Поскольку это первое поле и предшествующих полей не существует, отступ для данного поля равен нулю. Длина первого поля (3) используется в качестве отступа для второго поля. Длина второго поля, значение date, равно 10 и отражает максимальную длину значения данных этого поля. Совокупная длина первого и второго полей используется в качестве значения отступа для третьего поля (3 + 10 = 13). </p>
<p>Только когда соответствующая длина значения данных ASCII файла или длина каждого поля добавляется к длине предыдущих полей, вычисляется значение отступа и получается позиция очередного поля, только тогда данный процесс правильно считает данные. Если из-за неправильных установочных параметров в файле схемы данные транслируются неверно, то в большинстве типов полей могут возникнуть неблагоприятные эффекты типа обрезания строк, или интерпретирование цифр как нулей. Обычно в таком случае данные выводятся, но ошибки не возникает. Тем не менее, значения определенного формата в процессе трансляции в подходящий тип данных могут вызвать ошибку, если считываемые символы не соответствуют символам, например, в типе date. В контексте вышесказанного, ошибка с типом datе может возникнуть и-за того, что при неправильном определении в значения данных могут попасть данные другого, соседнего поля. При таком стечение обстоятельств трансляция данных прерывается, и в файле схемы требуется установка правильной длины поля и его отступа.</p><p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>


