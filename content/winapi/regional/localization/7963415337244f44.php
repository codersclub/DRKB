<h1>Как получить информацию о локальных настройках системы?</h1>
<div class="date">01.01.2007</div>


<p>Delphi имеет функцию GetLocaleInfo, которая позволяет получать различную информацию о локальных настройках, таких как системный язык, символ валюты, количество десятичных знаков и т.д.</p>
<p>Далее приведена функция, которая возвращает значение в зависимости от параметра "flag":</p>
<pre>
........ 
function TForm1.GetLocaleInformation(Flag: Integer): String; 
var 
  pcLCA:    Array[0..20] of Char; 
begin 
  if( GetLocaleInfo(LOCALE_SYSTEM_DEFAULT,Flag,pcLCA,19) &lt;= 0 ) then begin 
    pcLCA[0] := #0; 
  end; 
  Result := pcLCA; 
end; 
........ 
</pre>

<p>Пример использования функции:</p>
<pre>
........ 
procedure TForm1.Button1Click(Sender: TObject); 
begin 
  ShowMessage(GetLocaleInformation(LOCALE_SENGLANGUAGE)); 
end; 
........ 
</pre>
<p>"Flag" может содержать следующее значение (если посмотреть в Windows.pas):</p>
<p>  LOCALE_NOUSEROVERRIDE       { do not use user overrides }</p>
<p>  LOCALE_USE_CP_ACP           { use the system ACP }</p>
<p>  LOCALE_ILANGUAGE            { language id }</p>
<p>  LOCALE_SLANGUAGE            { localized name of language }</p>
<p>  LOCALE_SENGLANGUAGE         { English name of language }</p>
<p>  LOCALE_SABBREVLANGNAME      { abbreviated language name }</p>
<p>  LOCALE_SNATIVELANGNAME      { native name of language }</p>
<p>  LOCALE_ICOUNTRY             { country code }</p>
<p>  LOCALE_SCOUNTRY             { localized name of country }</p>
<p>  LOCALE_SENGCOUNTRY          { English name of country }</p>
<p>  LOCALE_SABBREVCTRYNAME      { abbreviated country name }</p>
<p>  LOCALE_SNATIVECTRYNAME      { native name of country }</p>
<p>  LOCALE_IDEFAULTLANGUAGE     { default language id }</p>
<p>  LOCALE_IDEFAULTCOUNTRY      { default country code }</p>
<p>  LOCALE_IDEFAULTCODEPAGE     { default oem code page }</p>
<p>  LOCALE_IDEFAULTANSICODEPAGE { default ansi code page }</p>
<p>  LOCALE_IDEFAULTMACCODEPAGE  { default mac code page }</p>
<p>  LOCALE_SLIST                { list item separator }</p>
<p>  LOCALE_IMEASURE             { 0 = metric, 1 = US }</p>
<p>  LOCALE_SDECIMAL             { decimal separator }</p>
<p>  LOCALE_STHOUSAND            { thousand separator }</p>
<p>  LOCALE_SGROUPING            { digit grouping }</p>
<p>  LOCALE_IDIGITS              { number of fractional digits }</p>
<p>  LOCALE_ILZERO               { leading zeros for decimal }</p>
<p>  LOCALE_INEGNUMBER           { negative number mode }</p>
<p>  LOCALE_SNATIVEDIGITS        { native ascii 0-9 }</p>
<p>  LOCALE_SCURRENCY            { local monetary symbol }</p>
<p>  LOCALE_SINTLSYMBOL          { intl monetary symbol }</p>
<p>  LOCALE_SMONDECIMALSEP       { monetary decimal separator }</p>
<p>  LOCALE_SMONTHOUSANDSEP      { monetary thousand separator }</p>
<p>  LOCALE_SMONGROUPING         { monetary grouping }</p>
<p>  LOCALE_ICURRDIGITS          { # local monetary digits }</p>
<p>  LOCALE_IINTLCURRDIGITS      { # intl monetary digits }</p>
<p>  LOCALE_ICURRENCY            { positive currency mode }</p>
<p>  LOCALE_INEGCURR             { negative currency mode }</p>
<p>  LOCALE_SDATE                { date separator }</p>
<p>  LOCALE_STIME                { time separator }</p>
<p>  LOCALE_SSHORTDATE           { short date format string }</p>
<p>  LOCALE_SLONGDATE            { long date format string }</p>
<p>  LOCALE_STIMEFORMAT          { time format string }</p>
<p>  LOCALE_IDATE                { short date format ordering }</p>
<p>  LOCALE_ILDATE               { long date format ordering }</p>
<p>  LOCALE_ITIME                { time format specifier }</p>
<p>  LOCALE_ITIMEMARKPOSN        { time marker position }</p>
<p>  LOCALE_ICENTURY             { century format specifier (short date) }</p>
<p>  LOCALE_ITLZERO              { leading zeros in time field }</p>
<p>  LOCALE_IDAYLZERO            { leading zeros in day field (short date) }</p>
<p>  LOCALE_IMONLZERO            { leading zeros in month field (short date) }</p>
<p>  LOCALE_S1159                { AM designator }</p>
<p>  LOCALE_S2359                { PM designator }</p>
<p>  LOCALE_ICALENDARTYPE        { type of calendar specifier }</p>
<p>  LOCALE_IOPTIONALCALENDAR    { additional calendar types specifier }</p>
<p>  LOCALE_IFIRSTDAYOFWEEK      { first day of week specifier }</p>
<p>  LOCALE_IFIRSTWEEKOFYEAR     { first week of year specifier }</p>
<p>  LOCALE_SDAYNAME1            { long name for Monday }</p>
<p>  LOCALE_SDAYNAME2            { long name for Tuesday }</p>
<p>  LOCALE_SDAYNAME3            { long name for Wednesday }</p>
<p>  LOCALE_SDAYNAME4            { long name for Thursday }</p>
<p>  LOCALE_SDAYNAME5            { long name for Friday }</p>
<p>  LOCALE_SDAYNAME6            { long name for Saturday }</p>
<p>  LOCALE_SDAYNAME7            { long name for Sunday }</p>
<p>  LOCALE_SABBREVDAYNAME1      { abbreviated name for Monday }</p>
<p>  LOCALE_SABBREVDAYNAME2      { abbreviated name for Tuesday }</p>
<p>  LOCALE_SABBREVDAYNAME3      { abbreviated name for Wednesday }</p>
<p>  LOCALE_SABBREVDAYNAME4      { abbreviated name for Thursday }</p>
<p>  LOCALE_SABBREVDAYNAME5      { abbreviated name for Friday }</p>
<p>  LOCALE_SABBREVDAYNAME6      { abbreviated name for Saturday }</p>
<p>  LOCALE_SABBREVDAYNAME7      { abbreviated name for Sunday }</p>
<p>  LOCALE_SMONTHNAME1          { long name for January }</p>
<p>  LOCALE_SMONTHNAME2          { long name for February }</p>
<p>  LOCALE_SMONTHNAME3          { long name for March }</p>
<p>  LOCALE_SMONTHNAME4          { long name for April }</p>
<p>  LOCALE_SMONTHNAME5          { long name for May }</p>
<p>  LOCALE_SMONTHNAME6          { long name for June }</p>
<p>  LOCALE_SMONTHNAME7          { long name for July }</p>
<p>  LOCALE_SMONTHNAME8          { long name for August }</p>
<p>  LOCALE_SMONTHNAME9          { long name for September }</p>
<p>  LOCALE_SMONTHNAME10         { long name for October }</p>
<p>  LOCALE_SMONTHNAME11         { long name for November }</p>
<p>  LOCALE_SMONTHNAME12         { long name for December }</p>
<p>  LOCALE_SMONTHNAME13         { long name for 13th month (if exists) }</p>
<p>  LOCALE_SABBREVMONTHNAME1    { abbreviated name for January }</p>
<p>  LOCALE_SABBREVMONTHNAME2    { abbreviated name for February }</p>
<p>  LOCALE_SABBREVMONTHNAME3    { abbreviated name for March }</p>
<p>  LOCALE_SABBREVMONTHNAME4    { abbreviated name for April }</p>
<p>  LOCALE_SABBREVMONTHNAME5    { abbreviated name for May }</p>
<p>  LOCALE_SABBREVMONTHNAME6    { abbreviated name for June }</p>
<p>  LOCALE_SABBREVMONTHNAME7    { abbreviated name for July }</p>
<p>  LOCALE_SABBREVMONTHNAME8    { abbreviated name for August }</p>
<p>  LOCALE_SABBREVMONTHNAME9    { abbreviated name for September }</p>
<p>  LOCALE_SABBREVMONTHNAME10   { abbreviated name for October }</p>
<p>  LOCALE_SABBREVMONTHNAME11   { abbreviated name for November }</p>
<p>  LOCALE_SABBREVMONTHNAME12   { abbreviated name for December }</p>
<p>  LOCALE_SABBREVMONTHNAME13   { abbreviated name for 13th month (if exists) }</p>
<p>  LOCALE_SPOSITIVESIGN        { positive sign }</p>
<p>  LOCALE_SNEGATIVESIGN        { negative sign }</p>
<p>  LOCALE_IPOSSIGNPOSN         { positive sign position }</p>
<p>  LOCALE_INEGSIGNPOSN         { negative sign position }</p>
<p>  LOCALE_IPOSSYMPRECEDES      { mon sym precedes pos amt }</p>
<p>  LOCALE_IPOSSEPBYSPACE       { mon sym sep by space from pos amt }</p>
<p>  LOCALE_INEGSYMPRECEDES      { mon sym precedes neg amt }</p>
<p>  LOCALE_INEGSEPBYSPACE       { mon sym sep by space from neg amt }</p>
<p>  LOCALE_FONTSIGNATURE        { font signature }</p>
<p>  LOCALE_SISO639LANGNAME      { ISO abbreviated language name }</p>
<p>  LOCALE_SISO3166CTRYNAME     { ISO abbreviated country name }</p>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

