---
Title: Как получить информацию о локальных настройках системы?
Date: 01.01.2007
Source: <https://forum.sources.ru>
---

Как получить информацию о локальных настройках системы?
=======================================================

Delphi имеет функцию GetLocaleInfo, которая позволяет получать различную
информацию о локальных настройках, таких как системный язык, символ
валюты, количество десятичных знаков и т.д.

Далее приведена функция, которая возвращает значение в зависимости от
параметра "flag":

    ........
    function TForm1.GetLocaleInformation(Flag: Integer): String;
    var
      pcLCA:    Array[0..20] of Char;
    begin
      if( GetLocaleInfo(LOCALE_SYSTEM_DEFAULT,Flag,pcLCA,19) <= 0 ) then begin
        pcLCA[0] := #0;
      end;
      Result := pcLCA;
    end;
    ........

Пример использования функции:

    ........
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      ShowMessage(GetLocaleInformation(LOCALE_SENGLANGUAGE));
    end;
    ........

"Flag" может содержать следующее значение (если посмотреть в Windows.pas):

Значение                     | Описание
-----------------------------|----------------------------
LOCALE\_NOUSEROVERRIDE       | do not use user overrides
LOCALE\_USE\_CP\_ACP         | use the system ACP
LOCALE\_ILANGUAGE            | language id
LOCALE\_SLANGUAGE            | localized name of language
LOCALE\_SENGLANGUAGE         | English name of language
LOCALE\_SABBREVLANGNAME      | abbreviated language name
LOCALE\_SNATIVELANGNAME      | native name of language
LOCALE\_ICOUNTRY             | country code
LOCALE\_SCOUNTRY             | localized name of country
LOCALE\_SENGCOUNTRY          | English name of country
LOCALE\_SABBREVCTRYNAME      | abbreviated country name
LOCALE\_SNATIVECTRYNAME      | native name of country
LOCALE\_IDEFAULTLANGUAGE     | default language id
LOCALE\_IDEFAULTCOUNTRY      | default country code
LOCALE\_IDEFAULTCODEPAGE     | default oem code page
LOCALE\_IDEFAULTANSICODEPAGE | default ansi code page
LOCALE\_IDEFAULTMACCODEPAGE  | default mac code page
LOCALE\_SLIST                | list item separator
LOCALE\_IMEASURE             | 0 = metric, 1 = US
LOCALE\_SDECIMAL             | decimal separator
LOCALE\_STHOUSAND            | thousand separator
LOCALE\_SGROUPING            | digit grouping
LOCALE\_IDIGITS              | number of fractional digits
LOCALE\_ILZERO               | leading zeros for decimal
LOCALE\_INEGNUMBER           | negative number mode
LOCALE\_SNATIVEDIGITS        | native ascii 0-9
LOCALE\_SCURRENCY            | local monetary symbol
LOCALE\_SINTLSYMBOL          | intl monetary symbol
LOCALE\_SMONDECIMALSEP       | monetary decimal separator
LOCALE\_SMONTHOUSANDSEP      | monetary thousand separator
LOCALE\_SMONGROUPING         | monetary grouping
LOCALE\_ICURRDIGITS          | # local monetary digits
LOCALE\_IINTLCURRDIGITS      | # intl monetary digits
LOCALE\_ICURRENCY            | positive currency mode
LOCALE\_INEGCURR             | negative currency mode
LOCALE\_SDATE                | date separator
LOCALE\_STIME                | time separator
LOCALE\_SSHORTDATE           | short date format string
LOCALE\_SLONGDATE            | long date format string
LOCALE\_STIMEFORMAT          | time format string
LOCALE\_IDATE                | short date format ordering
LOCALE\_ILDATE               | long date format ordering
LOCALE\_ITIME                | time format specifier
LOCALE\_ITIMEMARKPOSN        | time marker position
LOCALE\_ICENTURY             | century format specifier (short date)
LOCALE\_ITLZERO              | leading zeros in time field
LOCALE\_IDAYLZERO            | leading zeros in day field (short date)
LOCALE\_IMONLZERO            | leading zeros in month field (short date)
LOCALE\_S1159                | AM designator
LOCALE\_S2359                | PM designator
LOCALE\_ICALENDARTYPE        | type of calendar specifier
LOCALE\_IOPTIONALCALENDAR    | additional calendar types specifier
LOCALE\_IFIRSTDAYOFWEEK      | first day of week specifier
LOCALE\_IFIRSTWEEKOFYEAR     | first week of year specifier
LOCALE\_SDAYNAME1            | long name for Monday
LOCALE\_SDAYNAME2            | long name for Tuesday
LOCALE\_SDAYNAME3            | long name for Wednesday
LOCALE\_SDAYNAME4            | long name for Thursday
LOCALE\_SDAYNAME5            | long name for Friday
LOCALE\_SDAYNAME6            | long name for Saturday
LOCALE\_SDAYNAME7            | long name for Sunday
LOCALE\_SABBREVDAYNAME1      | abbreviated name for Monday
LOCALE\_SABBREVDAYNAME2      | abbreviated name for Tuesday
LOCALE\_SABBREVDAYNAME3      | abbreviated name for Wednesday
LOCALE\_SABBREVDAYNAME4      | abbreviated name for Thursday
LOCALE\_SABBREVDAYNAME5      | abbreviated name for Friday
LOCALE\_SABBREVDAYNAME6      | abbreviated name for Saturday
LOCALE\_SABBREVDAYNAME7      | abbreviated name for Sunday
LOCALE\_SMONTHNAME1          | long name for January
LOCALE\_SMONTHNAME2          | long name for February
LOCALE\_SMONTHNAME3          | long name for March
LOCALE\_SMONTHNAME4          | long name for April
LOCALE\_SMONTHNAME5          | long name for May
LOCALE\_SMONTHNAME6          | long name for June
LOCALE\_SMONTHNAME7          | long name for July
LOCALE\_SMONTHNAME8          | long name for August
LOCALE\_SMONTHNAME9          | long name for September
LOCALE\_SMONTHNAME10         | long name for October
LOCALE\_SMONTHNAME11         | long name for November
LOCALE\_SMONTHNAME12         | long name for December
LOCALE\_SMONTHNAME13         | long name for 13th month (if exists)
LOCALE\_SABBREVMONTHNAME1    | abbreviated name for January
LOCALE\_SABBREVMONTHNAME2    | abbreviated name for February
LOCALE\_SABBREVMONTHNAME3    | abbreviated name for March
LOCALE\_SABBREVMONTHNAME4    | abbreviated name for April
LOCALE\_SABBREVMONTHNAME5    | abbreviated name for May
LOCALE\_SABBREVMONTHNAME6    | abbreviated name for June
LOCALE\_SABBREVMONTHNAME7    | abbreviated name for July
LOCALE\_SABBREVMONTHNAME8    | abbreviated name for August
LOCALE\_SABBREVMONTHNAME9    | abbreviated name for September
LOCALE\_SABBREVMONTHNAME10   | abbreviated name for October
LOCALE\_SABBREVMONTHNAME11   | abbreviated name for November
LOCALE\_SABBREVMONTHNAME12   | abbreviated name for December
LOCALE\_SABBREVMONTHNAME13   | abbreviated name for 13th month (if exists)
LOCALE\_SPOSITIVESIGN        | positive sign
LOCALE\_SNEGATIVESIGN        | negative sign
LOCALE\_IPOSSIGNPOSN         | positive sign position
LOCALE\_INEGSIGNPOSN         | negative sign position
LOCALE\_IPOSSYMPRECEDES      | mon sym precedes pos amt
LOCALE\_IPOSSEPBYSPACE       | mon sym sep by space from pos amt
LOCALE\_INEGSYMPRECEDES      | mon sym precedes neg amt
LOCALE\_INEGSEPBYSPACE       | mon sym sep by space from neg amt
LOCALE\_FONTSIGNATURE        | font signature
LOCALE\_SISO639LANGNAME      | ISO abbreviated language name
LOCALE\_SISO3166CTRYNAME     | ISO abbreviated country name

