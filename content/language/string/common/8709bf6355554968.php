<h1>Справочник по функциям работы со строками</h1>
<div class="date">01.01.2007</div>


<p>function NewStrtconst(S: String): PString; &mdash; Создает копию строки S и возвращает указатель на нее.</p>
<p>procedure DisposeStr(P: PString) ; &mdash; Уничтожает строку, на которую указывает Р.</p>
<p>procedure AssignStr(var P: PString; const S: strings) &mdash; Уничтожает строку, на которую указывает Р и затем присваивает ему адрес созданной копии строки S.</p>
<p>procedure AppendStrfvar Dest: string; const S: string); &mdash; Добавляет строку S в конец строки Dest.</p>
<p>function Uppercase(const S: string): string; &mdash; Преобразует символы 'a'..'z' в строке S к верхнему регистру.</p>

<p>function LowerCase(const S: string): string; &mdash; Преобразует символы 'A'..'Z' в строке S к нижнему регистру.</p>

<p>function CompareStr(const SI, S2: string): Integer; &mdash; Сравнивает две строки S1 и S2 с учетом регистра символов. Возвращаемое значение равно 0 в случае равенства строк или разности кодов пары первых несовпадающих символов.</p>

<p>function CompareText(const SI, S2: string): Integer; &mdash; Сравнивает две строки без учета регистра символов.</p>
<p>function AnsiUpperCase(const S: string): string; &mdash; Преобразует символы в строке к верхнему регистру с учетом языкового драйвера.</p>

<p>function AnsiLowerCase(const S: string) : string; &mdash; Преобразует символы в строке к нижнему регистру с учетом языкового драйвера.</p>

<p>function AnsiCompareStr(const SI, S2: string): Integer; &mdash; Сравнивает две строки с использованием языкового драйвера и с учетом регистра символов.</p>
<p>function AnsiCompareText(const SI, S2 : string) : Integer; &mdash; Сравнивает две строки с использованием языкового драйвера и без учета регистра символов.</p>
<p>function IsValidldent(const Ident: string): Boolean; &mdash; Возвращает True, если строка Ident может служить идентификатором в программе на Object Pascal (т. е. содержит только буквы и цифры, причем первый символ &#8212; буква).</p>
<p>function IntToStr(Value: Longint): string; &mdash; Преобразует целое число в строку.</p>

<p>function IntToHex(Value: Longint; Digits: Integer): s t r ing ; &mdash; Преобразует целое число в строку с его шестнадцатиричным представлением.</p>
<p>function StrToInt(const S: string): Longint; &mdash; Преобразует строку в целое число. При ошибке возникает исключительная ситуация EConvertError.</p>
<p>function StrToIntDef(const S: string; Default; Longint): Longint ; &mdash; Работает как StrToInt, но при ошибке возвращает значение Default.</p>

<p>function LoadStr(Ident: Word) : string; &mdash; Загружает строку с индексом Ident из ресурсов приложения.</p>
<p>function FmtLoadStr(Ident: Word; const Args: array of const): string; &mdash; Загружает строку с индексом Ident из ресурсов приложения с форматированием (см. описание функции Format).</p>

