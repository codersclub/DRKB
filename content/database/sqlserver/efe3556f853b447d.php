<h1>Аналог функции FormatDateTime на TSQL</h1>
<div class="date">01.01.2007</div>


<pre>
CREATE FUNCTION dbo.FormatDateTime(@Format varchar(1000), @Time datetime)
RETURNS varchar(1000) AS
 
/*©Drkb v.3(2007): www.drkb.ru, 
 ®Vit (Vitaly Nevzorov) - <a href="mailto:nevzorov@yahoo.com*/">nevzorov@yahoo.com*/</a>
 
 
BEGIN
  Declare @temp varchar(20)
 
/*Special substitutions to avoid formating prepared strings*/
  Declare @dddd varchar(35)  Set @dddd='QQQQQQQQQQQQQQQQQQQQQQQQQQQQQQQ'
  Declare @ddd varchar(35)   Set @ddd= 'WWWWWWWWWWWWWWWWWWWWWWWWWWWWWWW'
  Declare @mmmm varchar(35)  Set @mmmm='EEEEEEEEEEEEEEEEEEEEEEEEEEEEEEE'
  Declare @mmm varchar(35)   Set @mmm= 'RRRRRRRRRRRRRRRRRRRRRRRRRRRRRRR'
  Declare @am varchar(35)    Set @am=  'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA'
  Declare @pm varchar(35)    Set @pm=  'PPPPPPPPPPPPPPPPPPPPPPPPPPPPPPP'
 
 
  if PATINDEX('%dddd%' , @Format)&gt;0 Set @Format=Replace(@Format,'dddd', @dddd)
  if PATINDEX('%ddd%' , @Format)&gt;0 Set @Format= Replace(@Format,'ddd', @ddd)
  if PATINDEX('%mmmm%' , @Format)&gt;0 Set @Format=Replace(@Format,'mmmm',@mmmm)
  if PATINDEX('%mmm%' , @Format)&gt;0  Set @Format=Replace(@Format,'mmm', @mmm)
 
  if PATINDEX('%doy%' , @Format)&gt;0 
  begin
    Declare @Doy int
 
    Set @Doy=Case Month(@Time)
               When 1 Then 0   
               When 2 Then 31  -- Jan
               Else 
                 Case 
                   When Year(@Time)%4=0 and Year(@Time)%400&lt;&gt;0 Then 31+29
                   Else 31+28
                 End -- Feb 
             End
 
    Set @Doy=Case Month(@Time)
               When 4 Then @Doy+31 -- Mar
               When 5 Then @Doy+31+30 -- Apr
               When 6 Then @Doy+31+30+31-- May
               When 7 Then @Doy+31+30+31+30-- Jun
               When 8 Then @Doy+31+30+31+30+31-- Jul
               When 9 Then @Doy+31+30+31+30+31+31-- Aug
               When 10 Then @Doy+31+30+31+30+31+31+30-- Sep
               When 11 Then @Doy+31+30+31+30+31+31+30+31-- Oct
               When 12 Then @Doy+31+30+31+30+31+31+30+31+30-- Nov
               Else @Doy
             End 
 
    Set @Doy=@Doy+Day(@Time)    
 
    Set @Format= Case 
                   When @Doy&lt;10 Then   Replace(@Format,'doy', '00'+cast(@Doy as varchar(1)))
                   When @Doy&gt;=100 Then Replace(@Format,'doy', cast(@Doy as varchar(3)))
                   Else Replace(@Format,'doy', '0'+cast(@Doy as varchar(2)))
                 End 
  end 
 
 
  if PATINDEX('%dd%' , @Format)&gt;0 
  begin
    if DATENAME(d, @time)&lt;10
      Set @Format= Replace(@Format,'dd', '0'+DATENAME(d, @time))
    else
      Set @Format= Replace(@Format,'dd', DATENAME(d, @time))
  end 
 
  if PATINDEX('%d%' , @Format)&gt;0 Set @Format= Replace(@Format,'d', DATENAME(d, @time))
  if PATINDEX('%yyyy%' , @Format)&gt;0 Set @Format= Replace(@Format,'yyyy', Year(@Time))
  if PATINDEX('%yy%' , @Format)&gt;0 Set @Format= Replace(@Format,'yy', Right(Cast(Year(@Time) as varchar(4)),2))
 
  if PATINDEX('%hh%' , @Format)&gt;0 
  begin
    if PATINDEX('%am/pm%' , @Format)&gt;0
    begin
      Set @Format=
        Case DATENAME(hh, @time)
          When 0 Then  Replace(@Format,'hh', '12')
          When 1 Then  Replace(@Format,'hh', '01')
          When 2 Then  Replace(@Format,'hh', '02')
          When 3 Then  Replace(@Format,'hh', '03')
          When 4 Then  Replace(@Format,'hh', '04')
          When 5 Then  Replace(@Format,'hh', '05')
          When 6 Then  Replace(@Format,'hh', '06')
          When 7 Then  Replace(@Format,'hh', '07')
          When 8 Then  Replace(@Format,'hh', '08')
          When 9 Then  Replace(@Format,'hh', '09')
          When 10 Then Replace(@Format,'hh', '10')
          When 11 Then Replace(@Format,'hh', '11')
          When 12 Then Replace(@Format,'hh', '12')
          When 13 Then Replace(@Format,'hh', '01')
          When 14 Then Replace(@Format,'hh', '02')
          When 15 Then Replace(@Format,'hh', '03')
          When 16 Then Replace(@Format,'hh', '04')
          When 17 Then Replace(@Format,'hh', '05')
          When 18 Then Replace(@Format,'hh', '06')
          When 19 Then Replace(@Format,'hh', '07')
          When 20 Then Replace(@Format,'hh', '08')
          When 21 Then Replace(@Format,'hh', '09')
          When 22 Then Replace(@Format,'hh', '10')
          When 23 Then Replace(@Format,'hh', '11')
          When 24 Then Replace(@Format,'hh', '12')
        End 
      Set @Format=
        Case 
          When DATENAME(hh, @time)&lt;12  Then Replace(@Format,'am/pm', @am)
          Else Replace(@Format,'am/pm', @pm)
        End 
    end
    else
    begin
      if DATENAME(hh, @time)&lt;10
        Set @Format= Replace(@Format,'hh', '0'+cast(DATENAME(hh, @time) as varchar(2)))
      else
        Set @Format= Replace(@Format,'hh', DATENAME(hh, @time))
    end
  end 
 
  if PATINDEX('%h%' , @Format)&gt;0 
  begin
    if PATINDEX('%am/pm%' , @Format)&gt;0
      begin
        Set @Format=
          Case DATENAME(hh, @time)
            When 0 Then  Replace(@Format,'hh', '12')
            When 1 Then  Replace(@Format,'hh', '1')
            When 2 Then  Replace(@Format,'hh', '2')
            When 3 Then  Replace(@Format,'hh', '3')
            When 4 Then  Replace(@Format,'hh', '4')
            When 5 Then  Replace(@Format,'hh', '5')
            When 6 Then  Replace(@Format,'hh', '6')
            When 7 Then  Replace(@Format,'hh', '7')
            When 8 Then  Replace(@Format,'hh', '8')
            When 9 Then  Replace(@Format,'hh', '9')
            When 10 Then Replace(@Format,'hh', '10')
            When 11 Then Replace(@Format,'hh', '11')
            When 12 Then Replace(@Format,'hh', '12')
            When 13 Then Replace(@Format,'hh', '1')
            When 14 Then Replace(@Format,'hh', '2')
            When 15 Then Replace(@Format,'hh', '3')
            When 16 Then Replace(@Format,'hh', '4')
            When 17 Then Replace(@Format,'hh', '5')
            When 18 Then Replace(@Format,'hh', '6')
            When 19 Then Replace(@Format,'hh', '7')
            When 20 Then Replace(@Format,'hh', '8')
            When 21 Then Replace(@Format,'hh', '9')
            When 22 Then Replace(@Format,'hh', '10')
            When 23 Then Replace(@Format,'hh', '11')
            When 24 Then Replace(@Format,'hh', '12')
          End 
        Set @Format=
          Case 
            When DATENAME(hh, @time)&lt;12  Then Replace(@Format,'am/pm', @am)
            Else Replace(@Format,'am/pm', @pm)
          End 
      end
    else
      begin
        Set @Format= Replace(@Format,'h', DATENAME(hh, @time))
      end
  end
 
  if PATINDEX('%mm%' , @Format)&gt;0 
  begin
    if Month(@Time)&lt;10
      Set @Format= Replace(@Format,'mm', '0'+cast(Month(@Time) as varchar(2)))
    else
      Set @Format= Replace(@Format,'mm', Month(@Time))
  end 
 
  if PATINDEX('%m%' , @Format)&gt;0 Set @Format= Replace(@Format,'m', Month(@Time))
 
  if PATINDEX('%nn%' , @Format)&gt;0 
  begin
    if DATENAME(mi, @time)&lt;10
      Set @Format= Replace(@Format,'nn', '0'+cast(DATENAME(mi, @time) as varchar(2)))
    else
      Set @Format= Replace(@Format,'nn', DATENAME(mi, @time))
  end 
 
  if PATINDEX('%n%' , @Format)&gt;0 Set @Format= Replace(@Format,'n', DATENAME(mi, @time))
 
  if PATINDEX('%ss%' , @Format)&gt;0 
  begin
    if DATENAME(ss, @time)&lt;10
      Set @Format= Replace(@Format,'ss', '0'+cast(DATENAME(ss, @time) as varchar(2)))
    else
      Set @Format= Replace(@Format,'ss', DATENAME(ss, @time))
  end 
 
  if PATINDEX('%s%' , @Format)&gt;0 Set @Format= Replace(@Format,'s', DATENAME(ss, @time))
 
  if PATINDEX('%'+@dddd+'%' , @Format)&gt;0 
  begin
     Set @Format=
       Case DAtepart(weekday, @time) 
         When 1 Then Replace(@Format,@dddd, 'Sunday')
         When 2 Then Replace(@Format,@dddd, 'Monday')
         When 3 Then Replace(@Format,@dddd, 'Tuesday')
         When 4 Then Replace(@Format,@dddd, 'Wednesday')
         When 5 Then Replace(@Format,@dddd, 'Thursday')
         When 6 Then Replace(@Format,@dddd, 'Friday')
         When 7 Then Replace(@Format,@dddd, 'Saturday')
       End  
  end 
 
  if PATINDEX('%'+@ddd+'%' , @Format)&gt;0 
  begin
     Set @Format=
       Case DAtepart(weekday, @time) 
         When 1 Then Replace(@Format,@ddd, 'Sun')
         When 2 Then Replace(@Format,@ddd, 'Mon')
         When 3 Then Replace(@Format,@ddd, 'Tue')
         When 4 Then Replace(@Format,@ddd, 'Wed')
         When 5 Then Replace(@Format,@ddd, 'Thu')
         When 6 Then Replace(@Format,@ddd, 'Fri')
         When 7 Then Replace(@Format,@ddd, 'Sat')
       End  
  end 
 
  if PATINDEX('%'+@mmmm+'%' , @Format)&gt;0 
  begin
     Set @Format=
       Case DAtepart(month, @time) 
         When 1  Then Replace(@Format,@mmmm, 'January')
         When 2  Then Replace(@Format,@mmmm, 'February')
         When 3  Then Replace(@Format,@mmmm, 'March')
         When 4  Then Replace(@Format,@mmmm, 'April')
         When 5  Then Replace(@Format,@mmmm, 'May')
         When 6  Then Replace(@Format,@mmmm, 'June')
         When 7  Then Replace(@Format,@mmmm, 'July')
         When 8  Then Replace(@Format,@mmmm, 'August')
 
         When 9  Then Replace(@Format,@mmmm, 'September')
         When 10 Then Replace(@Format,@mmmm, 'October')
         When 11 Then Replace(@Format,@mmmm, 'November')
         When 12 Then Replace(@Format,@mmmm, 'December')
       End  
  end 
 
  if PATINDEX('%'+@mmm+'%' , @Format)&gt;0 
  begin
     Set @Format=
       Case DAtepart(month, @time) 
         When 1  Then Replace(@Format,@mmm, 'Jan')
         When 2  Then Replace(@Format,@mmm, 'Feb')
         When 3  Then Replace(@Format,@mmm, 'Mar')
         When 4  Then Replace(@Format,@mmm, 'Apr')
         When 5  Then Replace(@Format,@mmm, 'May')
         When 6  Then Replace(@Format,@mmm, 'Jun')
         When 7  Then Replace(@Format,@mmm, 'Jul')
         When 8  Then Replace(@Format,@mmm, 'Aug')
         When 9  Then Replace(@Format,@mmm, 'Sep')
         When 10 Then Replace(@Format,@mmm, 'Oct')
         When 11 Then Replace(@Format,@mmm, 'Nov')
         When 12 Then Replace(@Format,@mmm, 'Dec')
       End  
  end 
 
  if PATINDEX('%'+@am+'%' , @Format)&gt;0 Set @Format=Replace(@Format, @am,'AM')
  if PATINDEX('%'+@pm+'%' , @Format)&gt;0 Set @Format=Replace(@Format, @pm,'PM')
 
  Return @Format
 
 
</pre>
<p>Поддерживает любые маски стандартных форматов, писал по спецификации:</p>
<p>Цитата</p>
<p>d Displays the day as a number without a leading zero (1-31).</p>
<p>dd Displays the day as a number with a leading zero (01-31).</p>
<p>ddd Displays the day as an abbreviation (Sun-Sat)</p>
<p>dddd Displays the day as a full name (Sunday-Saturday)</p>
<p>m Displays the month as a number without a leading zero (1-12). If the m specifier immediately follows an h or hh specifier, the minute rather than the month is displayed.</p>
<p>mm Displays the month as a number with a leading zero (01-12). If the mm specifier immediately follows an h or hh specifier, the minute rather than the month is displayed.</p>
<p>mmm Displays the month as an abbreviation (Jan-Dec)</p>
<p>mmmm Displays the month as a full name (January-December)</p>
<p>yy Displays the year as a two-digit number (00-99).</p>
<p>yyyy Displays the year as a four-digit number (0000-9999).</p>
<p>h Displays the hour without a leading zero (0-23).</p>
<p>hh Displays the hour with a leading zero (00-23).</p>
<p>n Displays the minute without a leading zero (0-59).</p>
<p>nn Displays the minute with a leading zero (00-59).</p>
<p>s Displays the second without a leading zero (0-59).</p>
<p>ss Displays the second with a leading zero (00-59).</p>
<p>am/pm Uses the 12-hour clock for the preceding h or hh specifier, and displays 'am' for any hour before noon, and 'pm' for any hour after noon. The am/pm specifier can use lower, upper, or mixed case, and the result is displayed accordingly.</p>
<p>Пример использования:</p>
<pre>
Declare @MyDate datetime
Set @MyDate=GetDate()
 
Select 
  dbo.FormatDateTime('dd/mm/yyyy', @MyDate),
  dbo.FormatDateTime('dd mmm yy', @MyDate),
  dbo.FormatDateTime('mmmm''dd yyyy hh:nn', @MyDate)
</pre>

<p>Результат будет типа:</p>
<p>27/07/2006</p>
<p>27 Jul 06</p>
<p>July'27 2006 14:21</p>

<p>Любой неописанный мусор в маске останется где он был, функция никаких ошибок не генерит, интерпретируются только описанные форматы:</p>
<pre>
Declare @MyDate datetime
Set @MyDate=GetDate()
 
Select 
  dbo.FormatDateTime('Сегодня у нас yyyy-mm-dd (dddd), чёрт бы его побрал!', @MyDate)
</pre>

<p>Результат будет типа:</p>
<p>Сегодня у нас 2006-07-27 (Thursday), чёрт бы его побрал!</p>

<p>Несмотря на громоздкость функция работает достаточно быстро.</p>

<div class="author">Автор: Vit</div>
