---
Title: Региональные стандарты
Author: Vit
Date: 01.01.2007
---

Региональные стандарты
=====================

В Дельфи есть предопределенные переменные языковых установок и форматов:


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

