<h1>Двоичная математика</h1>
<div class="date">06.09.2003</div>

<p>Введение</p>

Наряду с обычными логическими операция над логическими типами Boolean, часто приходится выполнять операции и над отдельными битами, обычно используемыми, как флаги. Для эффективной работы необходимо понимание логических операций.</p>
Паскаль поддерживает следующие логические операции </p>
AND &#8211; логическое И;</p>
OR - (включающие) логическое ИЛИ;</p>
XOR - (исключающие) логическое ИЛИ;</p>
NOT - отрицание или инверсия бита;</p>
SHL &#8211; логический сдвиг влево;</p>
SHR &#8211; логический сдвиг вправо.</p>
Другие логические операции над числами в Паскаль не включены, но доступны через ассемблерные вставки.</p>
Каждый бит может иметь только два состояния ЛОЖЬ (FALSE) или ИСТИНА (TRUE)</p>
Состояние бита можно описывать и другими словами, часть которых пришла из математики, часть из электроники, часть из логики.</p>
Для значения ЛОЖЬ, альтернативные варианты такие &#8211; НЕТ, НОЛЬ, ВЫКЛЮЧЕНО, НЕ УСТАНОВЛЕНО, СБРОШЕНО, FALSE, F, 0, - и другие.</p>
Для значения ИСТИНА, альтернативные варианты такие &#8211; ДА, ЕДИНИЦА, ВКЛЮЧЕНО,&nbsp; УСТАНОВШЕНО, ВЗВЕДЕНО, TRUE, T, 1, + и другие.</p>
Рассмотрим эти операции по отдельности </p>
AND &#8211; логическое И, эта операции выглядит так</p>
<table align="center" cellspacing="0" cellpadding="4" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr >
<td >A</p>
</td>
<td >B</p>
</td>
<td >Y</p>
</td>
</tr>
<tr >
<td >0</p>
</td>
<td >0</p>
</td>
<td >0</p>
</td>
</tr>
<tr >
<td >0</p>
</td>
<td >1</p>
</td>
<td >0</p>
</td>
</tr>
<tr >
<td >1</p>
</td>
<td >0</p>
</td>
<td >0</p>
</td>
</tr>
<tr >
<td >1</p>
</td>
<td >1</p>
</td>
<td >1
</td>
</tr>
</table>
Выражение истинно, когда истинны оба бита. Присказка «И там И там»</p>
OR - (включающие) логическое ИЛИ, эта операции выглядит так </p>
<table align="center" cellspacing="0" cellpadding="4" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr >
<td >A</p>
</td>
<td >B</p>
</td>
<td >Y</p>
</td>
</tr>
<tr >
<td >0</p>
</td>
<td >0</p>
</td>
<td >0</p>
</td>
</tr>
<tr >
<td >0</p>
</td>
<td >1</p>
</td>
<td >1</p>
</td>
</tr>
<tr >
<td >1</p>
</td>
<td >0</p>
</td>
<td >1</p>
</td>
</tr>
<tr >
<td >1</p>
</td>
<td >1</p>
</td>
<td >1
</td>
</tr>
</table>
Выражение истинно, когда истинен хотя бы один бит. Присказка «ИЛИ там ИЛИ там, включая и там и там»</p>
XOR - (исключающие) логическое ИЛИ, эта операции выглядит так</p>
<table align="center" cellspacing="0" cellpadding="4" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr >
<td >A</p>
</td>
<td >B</p>
</td>
<td >Y</p>
</td>
</tr>
<tr >
<td >0</p>
</td>
<td >0</p>
</td>
<td >0</p>
</td>
</tr>
<tr >
<td >0</p>
</td>
<td >1</p>
</td>
<td >1</p>
</td>
</tr>
<tr >
<td >1</p>
</td>
<td >0</p>
</td>
<td >1</p>
</td>
</tr>
<tr >
<td >1</p>
</td>
<td >1</p>
</td>
<td >0
</td>
</tr>
</table>
Выражение истинно, когда истинен только один бит. Присказка «ИЛИ там ИЛИ там, исключая и там и там»</p>
NOT - отрицание или инверсия бита, эта операции применяется только к одному биту, действие простое текущее значение бита изменяется на противоположное</p>
<table align="center" cellspacing="0" cellpadding="4" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr >
<td >A</p>
</td>
<td >Y</p>
</td>
</tr>
<tr >
<td >0</p>
</td>
<td >1</p>
</td>
</tr>
<tr >
<td >1</p>
</td>
<td >0
</td>
</tr>
</table>
SHL &#8211; логический сдвиг влево, операции применяется только к группе битов, одного из целочисленных типов Паскаля, например к байту, слову и т.д. </p>
Сдвиг байта влево на один разряд.</p>
<table align="center" cellspacing="0" cellpadding="4" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr >
<td >Разряды</p>
</td>
<td >B7</p>
</td>
<td >B6</p>
</td>
<td >B5</p>
</td>
<td >B4</p>
</td>
<td >B3</p>
</td>
<td >B2</p>
</td>
<td >B1</p>
</td>
<td >B0</p>
</td>
</tr>
<tr >
<td >До</p>
</td>
<td >1</p>
</td>
<td >0</p>
</td>
<td >0</p>
</td>
<td >1</p>
</td>
<td >1</p>
</td>
<td >1</p>
</td>
<td >0</p>
</td>
<td >1</p>
</td>
</tr>
<tr >
<td >После</p>
</td>
<td >0</p>
</td>
<td >0</p>
</td>
<td >1</p>
</td>
<td >1</p>
</td>
<td >1</p>
</td>
<td >0</p>
</td>
<td >1</p>
</td>
<td >0
</td>
</tr>
</table>
Сдвиг байта влево на два разряда.</p>
<table align="center" cellspacing="0" cellpadding="4" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr >
<td >Разряды</p>
</td>
<td >B7</p>
</td>
<td >B6</p>
</td>
<td >B5</p>
</td>
<td >B4</p>
</td>
<td >B3</p>
</td>
<td >B2</p>
</td>
<td >B1</p>
</td>
<td >B0</p>
</td>
</tr>
<tr >
<td >До</p>
</td>
<td >1</p>
</td>
<td >0</p>
</td>
<td >0</p>
</td>
<td >1</p>
</td>
<td >1</p>
</td>
<td >1</p>
</td>
<td >0</p>
</td>
<td >1</p>
</td>
</tr>
<tr >
<td >После</p>
</td>
<td >0</p>
</td>
<td >1</p>
</td>
<td >1</p>
</td>
<td >1</p>
</td>
<td >0</p>
</td>
<td >1</p>
</td>
<td >0</p>
</td>
<td >0
</td>
</tr>
</table>
Байт смещается влево на один или более разрядов, позиции справа замещаются нулями, позиции слева теряются.</p>
SHR &#8211; логический сдвиг вправо, операции применяется только к группе битов, одного из целочисленных типов Паскаля, например к байту, слову и т.д. </p>
Сдвиг байта вправо на один разряд.</p>
<table align="center" cellspacing="0" cellpadding="4" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr >
<td >Разряды</p>
</td>
<td >B7</p>
</td>
<td >B6</p>
</td>
<td >B5</p>
</td>
<td >B4</p>
</td>
<td >B3</p>
</td>
<td >B2</p>
</td>
<td >B1</p>
</td>
<td >B0</p>
</td>
</tr>
<tr >
<td >До</p>
</td>
<td >1</p>
</td>
<td >0</p>
</td>
<td >0</p>
</td>
<td >1</p>
</td>
<td >1</p>
</td>
<td >1</p>
</td>
<td >0</p>
</td>
<td >1</p>
</td>
</tr>
<tr >
<td >После</p>
</td>
<td >0</p>
</td>
<td >1</p>
</td>
<td >0</p>
</td>
<td >0</p>
</td>
<td >1</p>
</td>
<td >1</p>
</td>
<td >1</p>
</td>
<td >0
</td>
</tr>
</table>
Сдвиг байта вправо на два разряда.</p>
<table align="center" cellspacing="0" cellpadding="4" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr >
<td >Разряды</p>
</td>
<td >B7</p>
</td>
<td >B6</p>
</td>
<td >B5</p>
</td>
<td >B4</p>
</td>
<td >B3</p>
</td>
<td >B2</p>
</td>
<td >B1</p>
</td>
<td >B0</p>
</td>
</tr>
<tr >
<td >До</p>
</td>
<td >1</p>
</td>
<td >0</p>
</td>
<td >0</p>
</td>
<td >1</p>
</td>
<td >1</p>
</td>
<td >1</p>
</td>
<td >0</p>
</td>
<td >1</p>
</td>
</tr>
<tr >
<td >После</p>
</td>
<td >0</p>
</td>
<td >0</p>
</td>
<td >1</p>
</td>
<td >0</p>
</td>
<td >0</p>
</td>
<td >1</p>
</td>
<td >1</p>
</td>
<td >1
</td>
</tr>
</table>
Байт смещается вправо на один или более разрядов, позиции слева замещаются нулями, позиции справа теряются.</p>
На этом описание операций заканчивается, и переходим к практическим примерам. Но вначале немного слов о нотации</p>
Применяемая нотация при отображении чисел в литературе</p>
Числа в символьной форме принято отображать, так что бы младшие разряды были справа, а строки слева, при этом если используется выравнивание, то оно тоже подчиняется этим правилам.</p>
Нумерация разрядов начинается с нуля в соответствии со степень разряда и описывается формулой K*M^N, где K это коэффициент&nbsp; в диапазоне от 0 до M-1, M это основание числа, а N это степень. Число в степени 0 для всех оснований равно 1.</p>
Посмотрим на примере следующей таблицы для четырех основных оснований.</p>
Для числа 100</p>
<table align="center" cellspacing="0" cellpadding="4" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr >
<td ><p>Основание</p>
</td>
<td ><p>Значение</p>
</td>
<td ><p>Формула</p>
</td>
</tr>
<tr >
<td ><p>2</p>
</td>
<td ><p>4</p>
</td>
<td ><p>1*2^2 + 0*2^1 +0*2^0</p>
</td>
</tr>
<tr >
<td ><p>8</p>
</td>
<td ><p>64</p>
</td>
<td ><p>1*8^2 + 0*8^1 +0*8^0</p>
</td>
</tr>
<tr >
<td ><p>10</p>
</td>
<td ><p>100</p>
</td>
<td ><p>1*10^2 + 0*10^1 + 0*2^0</p>
</td>
</tr>
<tr >
<td ><p>16</p>
</td>
<td ><p>256</p>
</td>
<td ><p>1*16^2 + 0*16^1 + 0*2^0
</td>
</tr>
</table>
Для числа 123</p>
<table align="center" cellspacing="0" cellpadding="4" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr >
<td ><p>Основание</p>
</td>
<td ><p>Значение</p>
</td>
<td ><p>Формула</p>
</td>
</tr>
<tr >
<td ><p>2</p>
</td>
<td ><p>X</p>
</td>
<td ><p>Не допустимая комбинация</p>
</td>
</tr>
<tr >
<td ><p>8</p>
</td>
<td ><p>83</p>
</td>
<td ><p>1*8^2 + 2*8^1 + 3*8^0</p>
</td>
</tr>
<tr >
<td ><p>10</p>
</td>
<td ><p>123</p>
</td>
<td ><p>1*10^2 + 2*10^1 + 3*10^0</p>
</td>
</tr>
<tr >
<td ><p>16</p>
</td>
<td ><p>291</p>
</td>
<td ><p>1*16^2 + 2*16^1 + 3*16^0
</td>
</tr>
</table>
Практические примеры</p>
В начале несколько простых примеров по использованию логических операций, а в заключение будет рассмотрено применение этих приемов для работы с каталогами.</p>
Получение позиции бита или его значения</p>
<pre>
1 shl N
</pre>
В&nbsp; данном примере единица сдвигается влево на нужное количество разрядов, и в результате получаем двоичное значение, равное 2^N, где в установлен один единственный бит, соответствующий разряду числа. Этот прием может использоваться с переменной для расчета позиции во время выполнения или во время компиляции, во втором случае код генерироваться не будет, а компилятор просто рассчитает значение и подставит его в программу, не генерируя дополнительного кода. Это удобно для указания номера бита, не представляя его в виде десятичной или шестнадцатеричной константы. Но чаще бывает удобнее использовать именованные константы, поскольку они более информативны, примеры этого будут приведены в конце статьи.</p>
Установка бита</p>
Для установки отдельного бита или группы битов используется операция ИЛИ, использование иллюстрируется ниже приведенным кодом в виде отдельной функции и результатом выполнения в виде таблицы.</p>
<pre>
function SetBit(Src: Integer; bit: Integer): Integer;
begin
  Result := Src or (1 shl Bit);
end;
</pre>
&nbsp;</p>
Здесь происходит следующее:</p>
Сначала мы рассчитываем позицию бита &#8211; (1 shl Bit), затем устанавливаем полученный бит и возвращаем результат через предопределенную переменную Result.</p>
Пример использования:</p>
<pre>
DummyValue := SetBit(DummyValue, 2);
</pre>
&nbsp;</p>
<table align="center" cellspacing="0" cellpadding="4" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr >
<td >Разряды</p>
</td>
<td >B7</p>
</td>
<td >B6</p>
</td>
<td >B5</p>
</td>
<td >B4</p>
</td>
<td >B3</p>
</td>
<td >B2</p>
</td>
<td >B1</p>
</td>
<td >B0</p>
</td>
</tr>
<tr >
<td >До (1)</p>
</td>
<td >1</p>
</td>
<td >0</p>
</td>
<td >0</p>
</td>
<td >1</p>
</td>
<td >1</p>
</td>
<td >1</p>
</td>
<td >0</p>
</td>
<td >1</p>
</td>
</tr>
<tr >
<td >После</p>
</td>
<td >1</p>
</td>
<td >0</p>
</td>
<td >0</p>
</td>
<td >1</p>
</td>
<td >1</p>
</td>
<td >1</p>
</td>
<td >0</p>
</td>
<td >1</p>
</td>
</tr>
<tr >
<td >До (2)</p>
</td>
<td >1</p>
</td>
<td >0</p>
</td>
<td >0</p>
</td>
<td >1</p>
</td>
<td >1</p>
</td>
<td >0</p>
</td>
<td >0</p>
</td>
<td >1</p>
</td>
</tr>
<tr >
<td >После</p>
</td>
<td >1</p>
</td>
<td >0</p>
</td>
<td >0</p>
</td>
<td >1</p>
</td>
<td >1</p>
</td>
<td >1</p>
</td>
<td >0</p>
</td>
<td >1
</td>
</tr>
</table>
Как видим, вне зависимости от начального состояние бита, после выполнения операции бит становится равны единице.</p>
Сброс бита</p>
Для сброса отдельного бита или группы битов используется операция И совместно с&nbsp; инверсной маской, использование иллюстрируется ниже приведенным кодом в виде отдельной функции и результатом выполнения в виде таблицы.</p>
<pre>
function ResetBit(Src: Integer; bit: Integer): Integer;
begin
  Result := Src and not (1 shl Bit);
end;
</pre>
Здесь происходит следующее:</p>
Сначала мы рассчитываем позицию бита &#8211; (1 shl Bit), затем с помощью операции NOT инвертируем полученную маску, устанавливая, не затрагиваемые биты маски в единицу, а затрагиваемый бит в ноль, затем сбрасываем этот бит, а результат возвращаем результат через предопределенную переменную Result.</p>
Пример использования:</p>
<pre>
DummyValue := ResetBit(DummyValue, 2);
</pre>
&nbsp;</p>
<table align="center" cellspacing="0" cellpadding="4" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr >
<td >Разряды</p>
</td>
<td >B7</p>
</td>
<td >B6</p>
</td>
<td >B5</p>
</td>
<td >B4</p>
</td>
<td >B3</p>
</td>
<td >B2</p>
</td>
<td >B1</p>
</td>
<td >B0</p>
</td>
</tr>
<tr >
<td >До (1)</p>
</td>
<td >1</p>
</td>
<td >0</p>
</td>
<td >0</p>
</td>
<td >1</p>
</td>
<td >1</p>
</td>
<td >1</p>
</td>
<td >0</p>
</td>
<td >1</p>
</td>
</tr>
<tr >
<td >После</p>
</td>
<td >1</p>
</td>
<td >0</p>
</td>
<td >0</p>
</td>
<td >1</p>
</td>
<td >1</p>
</td>
<td >0</p>
</td>
<td >0</p>
</td>
<td >1</p>
</td>
</tr>
<tr >
<td >До (2)</p>
</td>
<td >1</p>
</td>
<td >0</p>
</td>
<td >0</p>
</td>
<td >1</p>
</td>
<td >1</p>
</td>
<td >0</p>
</td>
<td >0</p>
</td>
<td >1</p>
</td>
</tr>
<tr >
<td >После</p>
</td>
<td >1</p>
</td>
<td >0</p>
</td>
<td >0</p>
</td>
<td >1</p>
</td>
<td >1</p>
</td>
<td >0</p>
</td>
<td >0</p>
</td>
<td >1
</td>
</tr>
</table>
Как видим, вне зависимости от начального состояние бита, после выполнения операции бит становится равны нулю.</p>
Переключение бита</p>
Для переключения отдельного бита или группы битов используется операция исключающие ИЛИ, использование иллюстрируется ниже приведенным кодом в виде отдельной функции и результатом выполнения в виде таблицы.</p>
<pre>
function InvertBit(Src: Integer; bit: Integer): Integer;
begin
  Result := Src xor (1 shl Bit);
end;
</pre>
&nbsp;</p>
Здесь происходит следующее:</p>
Сначала мы рассчитываем позицию бита &#8211; (1 shl Bit), затем с помощью операции XOR переключаем бит, а результат возвращаем результат через предопределенную переменную Result.</p>
Пример использования:</p>
<pre>
DummyValue := InvertBit(DummyValue, 2);
</pre>
&nbsp;</p>
<table align="center" cellspacing="0" cellpadding="4" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr >
<td >Разряды</p>
</td>
<td >B7</p>
</td>
<td >B6</p>
</td>
<td >B5</p>
</td>
<td >B4</p>
</td>
<td >B3</p>
</td>
<td >B2</p>
</td>
<td >B1</p>
</td>
<td >B0</p>
</td>
</tr>
<tr >
<td >До (1)</p>
</td>
<td >1</p>
</td>
<td >0</p>
</td>
<td >0</p>
</td>
<td >1</p>
</td>
<td >1</p>
</td>
<td >1</p>
</td>
<td >0</p>
</td>
<td >1</p>
</td>
</tr>
<tr >
<td >После</p>
</td>
<td >1</p>
</td>
<td >0</p>
</td>
<td >0</p>
</td>
<td >1</p>
</td>
<td >1</p>
</td>
<td >0</p>
</td>
<td >0</p>
</td>
<td >1</p>
</td>
</tr>
<tr >
<td >До (2)</p>
</td>
<td >1</p>
</td>
<td >0</p>
</td>
<td >0</p>
</td>
<td >1</p>
</td>
<td >1</p>
</td>
<td >0</p>
</td>
<td >0</p>
</td>
<td >1</p>
</td>
</tr>
<tr >
<td >После</p>
</td>
<td >1</p>
</td>
<td >0</p>
</td>
<td >0</p>
</td>
<td >1</p>
</td>
<td >1</p>
</td>
<td >1</p>
</td>
<td >0</p>
</td>
<td >1
</td>
</tr>
</table>
Как видим, состояние бита B2 изменяется на противоположное.</p>
Проверка бита</p>
Для проверки бита используется операция AND и анализ результата на равенство нулю.</p>
<pre>
if Value and (1 shl N) &lt;&gt; 0 then ... установлен
if Value and (1 shl N) = 0 then ... не установлен
</pre>
чаще всего это используется в другой форме, вместо расчета позиции используется именованная константа, например</p>
<pre>
const
  B2 = 4  // B2 (1 shl 2)
Begin
  if Value and B2 = B2 then ... установлен
  if Value and B2 = 0  then ... не установлен
end;
</pre>
&nbsp;</p>
Это более наглядно, особенно если константе дано более значимое имя, чем B2, например, для проверки готовности передатчика мы можем определить константу с именем TxReady,&nbsp; тогда это будет выглядеть очень красиво.</p>
<pre>
const
  TxReady = 4 
Begin
  if Value and TxReady then begin
    ...  обработка готовности передатчика
  end;
end;
</pre>
&nbsp;</p>
<p>Ну, вот с базисом мы покончили и пора приступить к более полезным и практическим примерам. В качестве примера выберем поиск папок и файлов. Пример был разработан для FAQ конференции fido7.ru.delphi, в дальнейшем был немного модернизирован по замечаниям от Юрия Зотова. </p>
<pre>
procedure ScanDir(StartDir: string; Mask:string; List:TStrings);
var
  SearchRec : TSearchRec;
begin
  if Mask = '' then Mask := '*.*';
  if StartDir[Length(StartDir)] &lt;&gt; '\' then StartDir := StartDir + '\';
  if FindFirst(StartDir + Mask, faAnyFile, SearchRec) = 0 then
  begin
    repeat
      Application.ProcessMessages;        
      if (SearchRec.Attr and faDirectory) &lt;&gt; faDirectory  
      then
        List.Add(StartDir + SearchRec.Name)
      else if (SearchRec.Name &lt;&gt; '..') and (SearchRec.Name &lt;&gt; '.')
      then  
      begin
        List.Add(StartDir + SearchRec.Name + '\');
        ScanDir(StartDir + SearchRec.Name + '\', Mask, List);
      end;
    until FindNext(SearchRec) &lt;&gt; 0;
    FindClose(SearchRec);
  end;
end;
</pre>
&nbsp;</p>
Рассмотрим ключевые моменты, относящиеся к данной статье.</p>
<pre>
if FindFirst(StartDir + Mask, faAnyFile, SearchRec) = 0 then
</pre>
&nbsp;</p>
Здесь является битовой маской, описанной в модуле SysUtils, ее значение равно $3F, она предназначена для включения в поиск специальных файлов и одновременно для изоляции лишних бит из структуры TsearchRec, отдельные биты данной маски описаны как именованные константы.</p>
<table align="center" cellspacing="0" cellpadding="4" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr >
<td >Нименование</p>
</td>
<td >Значение</p>
</td>
<td colspan="2" >Описание</p>
</td>
</tr>
<tr >
<td >FaReadOnly&nbsp;&nbsp; </p>
</td>
<td >$00000001</p>
</td>
<td >Read-only files</p>
</td>
<td >Файлы с защитой от записи</p>
</td>
</tr>
<tr >
<td >faHidden &nbsp; &nbsp; &nbsp; &nbsp;</p>
</td>
<td >$00000002 &nbsp; &nbsp; &nbsp; &nbsp;</p>
</td>
<td >Hidden files</p>
</td>
<td >Невидимые файлы</p>
</td>
</tr>
<tr >
<td >faSysFile</p>
</td>
<td >$00000004</p>
</td>
<td >System files</p>
</td>
<td >Системные файлы</p>
</td>
</tr>
<tr >
<td >faVolumeID&nbsp;&nbsp; </p>
</td>
<td >$00000008</p>
</td>
<td >Volume ID files</p>
</td>
<td >Метка тома</p>
</td>
</tr>
<tr >
<td >faDirectory</p>
</td>
<td >$00000010</p>
</td>
<td >Directory files</p>
</td>
<td >Папки</p>
</td>
</tr>
<tr >
<td >faArchive</p>
</td>
<td >$00000020</p>
</td>
<td >Archive files</p>
</td>
<td >Архивные файлы (для системы архивации)</p>
</td>
</tr>
<tr >
<td >faAnyFile</p>
</td>
<td >$0000003F</p>
</td>
<td >Any file</p>
</td>
<td >Все файлы &#8211; комбинация выше указанных флагов
</td>
</tr>
</table>
<pre>
if (SearchRec.Attr and faDirectory) &lt;&gt; faDirectory  
</pre>
&nbsp;</p>
здесь мы видим проверку флага faDirectory, работает это следующим образом, сначала изолируются не нужные биты, затем проводится проверка на неравенство нулю, поскольку все остальные биты изолированы, то возможны только два значения, ноль, если флаг не установлен и не ноль установлен, в зависимости от результата выполняется, или часть&nbsp; THEN,&nbsp; или часть&nbsp; ELSE. Других вещей касаемо нашей статьи в примере нет и поэтому рассматривать больше нечего. Прочие логические операции работают с булевыми, а не с битовыми значения.</p>
В заключение статьи можно еще привести примеры использования масок для изоляции битов и выполнения операций над оставшимися битами, возьмем для примера какую ни будь абстрактную комбинацию бит и выполним, что ни будь с ними.</p>
Например, у нас есть такая структура некоторого устройства, и при поступлении данных происходит прерывание, обработка которого поступает в наш обработчик и в другие вместе с кодом состояния, если мы обработали сообщение, то мы должны возвратить значение TRUE, если то FALSE и тогда управление будет передано следующему в цепочке обработчику. Бит TxReady проверять не надо, управление будет поступать, только тогда когда он установлен.</p>
abcccddd &#8211; где </p>
a&nbsp;&nbsp; &#8211; бит готовности</p>
b&nbsp;&nbsp; &#8211; бит разрешения прерывания</p>
ccc &#8211; тип операции</p>
ddd &#8211; счетчик</p>
<pre>
function MyHandler(Code: byte): Boolean;
const
  TxReady     = $80;
  IntBit      = $40;
  TypeMask    = $38;
  CounterMask = $07;
var
  I: Integer;
  TypeBits: Byte;
begin
  if (Code and Intbit) = Intbit 
  then
  begin
    // изллируем биты типа и смещаем вправо для дальнейшей обработки
    TypeBits := (Code and TypeMask) shr 3; 
    Case TypeBits of
      0: begin
                                   for I := 1 to (Code and CounterMask) do
            begin
              считываем N данных, количесво указано в битах CounterMask,
              которые мы изолировали и использовали в качестве значения 
              для окончания цикла.
            end;
            Result := TRUE; // обрабатали, пусть больше никто не трогает
         end;
      1: begin
           команда 1, что то делаем
           Result := TRUE; // обрабатали, пусть больше никто не трогает
         end;
      2: begin
           команда 2, что то делаем
           Result := TRUE; // обрабатали, пусть больше никто не трогает
         end;
      else Result := FALSE; // другие команды не наше дело
    end;
  end
  else
  begin
    Result := FALSE; // пусть другой обрабатывает
  end;
end;
</pre>
&nbsp;</p>
Ошибки при работе с битами</p>
Например, для сложения бит мы можем использовать два варианта или операцию + или операцию OR. Первый вариант является ошибочным.</p>
AnyValue + 2, если бит два установлен, то в результате этой операции произойдет перенос в следующий разряд, а сам бит окажется сброшенным вместо его установки, так можно поступать если только если есть уверенность в результате, то если заранее известно начальное значение. А вот в случае использования варианта AnyValue or 2, такой ошибки не произойдет. Тоже относится к операции вычитания для сброса бита.</p>
faAnyFiles &#8211; faDirectory ошибки не даст, а вот AnyFlags &#8211; AnyBit может, дать правильный вариант, а может нет. Зато AnyFlags and not AnyBit всегда даст то что замали, использования этой техники будет правильнее и для работы с аттрибутами файлов - faAnyFiles and not faDirectory. В качестве домашнего задания попробуйте выполнить это на бумаге для разных комбинацияй бит.</p>
Еще одна распростаненая ошибка, это логическая при выполнении операций над групами бит. Например неверено выполнять операцию сравнения над следующей конструкцией AnyFlags and 5 &lt;&gt; 0, если истина должна быть при установке обеих бит, надо писать так AnyFlags and 5 = 5, зато если устраивает истина при установке любого из бит, выражение AnyFlags and 5 &lt;&gt; 0 будет верныи.</p>
На этом статья закончена и вы смогли получить начальные сведения по выполнению логических операций с битами, в заключении приведу и таблицу весовых коэффициентов, чтобы было легче рассчитывать константы.</p>
Приложения</p>
Таблица весовых множителей для 32 битного числа</p>
<table align="center" width="640" cellspacing="0" cellpadding="4" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr >
<td >Бит</p>
</td>
<td >Dec</p>
</td>
<td >Hex</p>
</td>
<td >Бит</p>
</td>
<td >Dec</p>
</td>
<td >Hex</p>
</td>
<td >Бит</p>
</td>
<td >Dec</p>
</td>
<td >Hex</p>
</td>
<td >Бит</p>
</td>
<td >Dec</p>
</td>
<td >Hex</p>
</td>
</tr>
<tr >
<td >0</p>
</td>
<td >1</p>
</td>
<td >1</p>
</td>
<td >8</p>
</td>
<td >256</p>
</td>
<td >100</p>
</td>
<td >16</p>
</td>
<td >65536</p>
</td>
<td >10000</p>
</td>
<td >24</p>
</td>
<td >16777216</p>
</td>
<td >1000000</p>
</td>
</tr>
<tr >
<td >1</p>
</td>
<td >2</p>
</td>
<td >2</p>
</td>
<td >9</p>
</td>
<td >512</p>
</td>
<td >200</p>
</td>
<td >17</p>
</td>
<td >131072</p>
</td>
<td >20000</p>
</td>
<td >25</p>
</td>
<td >33554432</p>
</td>
<td >2000000</p>
</td>
</tr>
<tr >
<td >2</p>
</td>
<td >4</p>
</td>
<td >4</p>
</td>
<td >10</p>
</td>
<td >1024</p>
</td>
<td >400</p>
</td>
<td >18</p>
</td>
<td >262144</p>
</td>
<td >40000</p>
</td>
<td >26</p>
</td>
<td >67108864</p>
</td>
<td >4000000</p>
</td>
</tr>
<tr >
<td >3</p>
</td>
<td >8</p>
</td>
<td >8</p>
</td>
<td >11</p>
</td>
<td >2048</p>
</td>
<td >800</p>
</td>
<td >19</p>
</td>
<td >524288</p>
</td>
<td >80000</p>
</td>
<td >27</p>
</td>
<td >134217728</p>
</td>
<td >8000000</p>
</td>
</tr>
<tr >
<td >4</p>
</td>
<td >16</p>
</td>
<td >10</p>
</td>
<td >12</p>
</td>
<td >4096</p>
</td>
<td >1000</p>
</td>
<td >20</p>
</td>
<td >1048576</p>
</td>
<td >100000</p>
</td>
<td >28</p>
</td>
<td >268435456</p>
</td>
<td >10000000</p>
</td>
</tr>
<tr >
<td >5</p>
</td>
<td >32</p>
</td>
<td >20</p>
</td>
<td >13</p>
</td>
<td >8192</p>
</td>
<td >2000</p>
</td>
<td >21</p>
</td>
<td >2097152</p>
</td>
<td >200000</p>
</td>
<td >29</p>
</td>
<td >536870912</p>
</td>
<td >20000000</p>
</td>
</tr>
<tr >
<td >6</p>
</td>
<td >64</p>
</td>
<td >40</p>
</td>
<td >14</p>
</td>
<td >16384</p>
</td>
<td >4000</p>
</td>
<td >22</p>
</td>
<td >4194304</p>
</td>
<td >400000</p>
</td>
<td >30</p>
</td>
<td >1073741824</p>
</td>
<td >40000000</p>
</td>
</tr>
<tr >
<td >7</p>
</td>
<td >128</p>
</td>
<td >80</p>
</td>
<td >15</p>
</td>
<td >32768</p>
</td>
<td >8000</p>
</td>
<td >23</p>
</td>
<td >8388608</p>
</td>
<td >800000</p>
</td>
<td >31</p>
</td>
<td >2147483648</p>
</td>
<td >80000000
</td>
</tr>
</table>
&nbsp;</p>

С уважением,</p>
Анатолий Подгорецкий</p>
6 сентября 2003 года</p>

<div class="author">Автор: Анатолий Подгорецкий, http://www.podgoretsky.com</div>


