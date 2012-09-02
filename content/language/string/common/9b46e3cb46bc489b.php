<h1>Справочник по функциям работы с PChar</h1>
<div class="date">01.01.2007</div>


<p>function StrLIComp(Strl, Str2: PChar; MaxLen: Cardinal) : Integer; &mdash; Работает как StrLComp, но без учета регистра символов.</p>
<p>function StrScantStr: PChar; Chr: Char) : PChar; &mdash; Отыскивает первое вхождение символа Chr в строку Str и возвращает указатель на него или nil в случае отстутствия.</p>
<p>function StrRScanfStr: PChar; Chr: Char) : PChar; &mdash; Работает как StrScan, но отыскивается последнее вхождение Chr.</p>
<p>function StrPos(Strl, Str2: PChar) : PChar; &mdash; Отыскивает первое вхождение строки Str2 в строку Strl и возвращает указатель на нее или nil в случае отстутствия.</p>

<p>function StrUpperfStr: PChar) : PChar; &mdash; Преобразует строку к верхнему регистру.</p>

<p>function StrLower(Str: PChar): PChar; &mdash; Преобразует строку к нижнему регистру.</p>
<p>function StrPaslStr: PChar): String; &mdash; Преобразует строку Str в строку типа string.</p>
<p>function StrAlloc(Size: Cardinal): PChar; &mdash; Размещает в куче памяти новую строку размером Size и возвращает указатель на нее.</p>
<p>function StrBufSize(Str: PChar): Cardinal; &mdash; Возвращает размер блока памяти, выделенного для строки при помощи функции StrAlloc.</p>
<p>function StrNewfStr: PChar): PChar ; &mdash; Размещает в куче памяти копню строки Str и возвращает указатель на нее.</p>
<p>procedure StrDispose(Str: PChar); &mdash; Уничтожает строку, размещенную при помощи StrAlloc или StrNew.</p>
<p>function StrLenfStr: PChar): &mdash; Возвращает число символов в строке Str (без учета завершающего нулевого).</p>
<p>function StrEndfStr: PChar): PChar; &mdash; Возвращает указатель на завершающий нулевой символ строки Str.</p>
<p>function StrMove(Dest, Source: PChar; Count: Cardinal): PChar; &mdash; Копирует из строки Source в строку Dest ровно Count символов, причем строки могут перекрываться.</p>

<p>function StrCopy(Dest, Source: PChar): PChar; &mdash; Копирует Source в Dest и возвращает указатель на Dest.</p>

<p>function StrECopy(Dest, Source: PChar): PChar; &mdash; Копирует Source в Dest и возвращает указатель на завершающий символ Dest.</p>

<p>function StrLCopy(Dest, Source: PChar; MaxLen: Cardinal): PChar; &mdash; Работает как StrCopy, но копирует не более MaxLen символов.</p>

<p>function StrPCopy(Dest: PChar; const Source: String): PChar; &mdash; Копирует строку Source (типа string) в Dest и возвращает указатель на Dest.</p>

<p>function StrPLCopy(Dest: PChar; const Source: string; MaxLen: Cardinal): PChar; &mdash; Работает как StrPCopy, но копирует не более MaxLen символов.</p>

<p>function StrCat(Dest, Source: PChar): PChar; &mdash; Дописывает Source к концу Dest и возвращает указатель на Dest.</p>
<p>function StrLCatfDest, Source: PChar; MaxLen: Cardinal) : PChar; &mdash; Работает как StrCat, но копирует не более MaxLen-StrLen(Dest) символов.</p>

<p>function StrCoirip(Strl, Str2: PChar): Integer; &mdash; Сравнивает две строки (посимвольно). Возвращает значение: &lt;0 &#8212; при Strl &lt;Str2, 0 &#8212; при Strl =Str2, &gt;0 &#8212; при Strl &gt;Str2.</p>
<p>function StrIComp(Strl, Str2: PChar): Integer; &mdash; Работает как StrComp, но без учета регистра символов.</p>

<p>function StrLComp(Strl, Str2: PChar; MaxLen: Cardinal): Integer; &mdash; Работает как StrComp, но сравнение происходит на протяжении не более чем MaxLen символов.</p>

