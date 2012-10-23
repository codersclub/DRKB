<h1>Регионарные стандарты</h1>
<div class="date">01.01.2007</div>

В Дельфи есть предопределенные переменные языковых установок и форматов:</p>
<pre>
 
// SysUtils
 
 var CurrencyString: string;
 var CurrencyFormat: Byte;
 var NegCurrFormat: Byte;
 var ThousandSeparator: Char;
 var DecimalSeparator: Char;
 var CurrencyDecimals: Byte;
 var DateSeparator: Char;
 var ShortDateFormat: string;
 var LongDateFormat: string;
 var TimeSeparator: Char;
 var TimeAMString: string;
 var TimePMString: string;
 var ShortTimeFormat: string;
 
 var LongTimeFormat: string;
 var ShortMonthNames: array[1..12] of string;
 var LongMonthNames: array[1..12] of string;
 var ShortDayNames: array[1..7] of string;
 var LongDayNames: array[1..7] of string;
 
 var SysLocale: TSysLocale;
 var EraNames: array[1..7] of string;
 var EraYearOffsets: array[1..7] of Integer;
 var TwoDigitYearCenturyWindow: Word = 50;
 
 var TListSeparator: Char;
</pre>
<div class="author">Автор: Vit</div>

