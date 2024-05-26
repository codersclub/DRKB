---
Title: Как преобразовать строку в дату?
Author: Vit
Date: 01.05.2002
---


Как преобразовать строку в дату?
================================

Вариант 1:

Author: Vit

Код распознаёт и русский и английский языки.
Кстати вполне корректно обрабатывает и падежи типа:

- 2 мая 2002
- май месяц 1999 года, 3е число
- 3е мая 1999 года
- Солнечный апрельский день в 1998м году, 20е число

Корректно распознаёт что-нибудь типа

- July 3, 99

но естественно не способен распознать

- 01-jan-03

т.е. если год двузначный, то должен быть больше 31. Иначе необоходим
дополнительный параметр, указывающий годом считать первую или вторую
найденную цифру в строке

     
    Function StringToDate(Temp:String):TDateTime;

      type TDateItem=(diYear, diMonth, diDay, diUnknown);
           TCharId=(ciAlpha, ciNumber, ciSpace);
     
      //языковые настройки.
      //Для включения нового языка добавляем раскладку сюда,
      //дополняем тип alpha и меняем /единственную строку
      //где используется эта константа
      const
        eng_monthes:array[1..12] of string=('jan', 'feb', 'mar', 'apr', 'may', 'jun', 'jul', 'aug', 'sep', 'oct', 'nov', 'dec');
        rus_monthes:array[1..12] of string=('янв', 'фев', 'мар', 'апр', 'ма', 'июн', 'июл', 'авг', 'сен', 'окт', 'ноя', 'дес');
        alpha:set of char=['a'..'z','а'..'я'];
     
      //временные переменные
      var month, day, year:string;
          temp1:string;
          i, j:integer;
          ci1, ci2:TCharId;
     
      Function GetWord(var temp:string):string;
      begin
        //возвращаем следующее слово из строки
        //и вырезаем это слово из исходной строки
        if pos(' ', temp)>0 then
          begin //берём слово до пробела
            result:=trim(copy(temp, 1, pos(' ', temp)));
            temp:=copy(temp, pos(' ', temp)+1, length(temp));
          end
        else //это последнее слово в строке
          begin
            result:=trim(temp);
            temp:='';
          end;
      end;
     
      Function GetDateItemType(temp:string):TDateItem;
        var i, j:integer;
      begin
        //распознаём тип слова
        i:=StrToIntDef(temp,0); //попытка преобразовать слово в цифру
        Case i of
          0: Result:=diMonth; //не число, значит или месяц или мусор
          1..31:Result:=diDay;//числа от 1 до 31 считаем днём
          else Result:=diYear;//любые другие числа считаем годами
        End;
      end;
     
      Function GetCharId(ch:char):TCharId;
      begin
        //узнаём тип символа, нужно для распознавания "склееных" дней или лет с месяцем 
        Case ch of
         ' ':Result:=ciSpace;
         '0'..'9':Result:=ciNumber;
         else Result:=ciAlpha;
        End;
      end;
     
     
    begin
      temp:=trim(ansilowercase(temp));
      month:='';
      day:='';
      year:='';
      //замена любого мусора на пробелы
      For i:=1 to length(temp) do
        if not (temp[i] in alpha+['0'..'9']) then temp[i]:=' ';
     
      //удаление лишних пробелов
      while pos('  ', temp)>0 do
        Temp:=StringReplace(temp, '  ',' ',[rfReplaceAll]);
     
      //вставка пробелов если месяц слеплен с днём или годом
      ci1:=GetCharId(temp[1]);
      i:=1;
      Repeat
        inc(i);
        ci2:=GetCharId(temp[i]);
        if ((ci1=ciAlpha) and (ci2=ciNumber)) or ((ci1=ciNumber) and (ci2=ciAlpha)) then
          insert(' ', temp, i);
        ci1:=ci2;
      Until i>=length(temp);
     
      //собственно парсинг
      while temp>'' do
        begin
          temp1:=GetWord(temp);
          Case GetDateItemType(temp1) of
            diMonth: if month='' then  //только если месяц ещё не определён, уменьшает вероятность ошибочного результата
                       for i:=12 downto 1 do  // обязателен отсчёт в обратную сторону чтоб не путать май и март
                         if (pos(eng_monthes[i],temp1)=1) or (pos(rus_monthes[i],temp1)=1) then  //сюда добавляем ещё язык если надо
                           month:=inttostr(i);
            diDay:   Day:=temp1;
            diYear:  Year:=temp1;
          End;
        end;
     
     
      //проверка - все ли элементы определены
      if (month='') or (Day='') or (Year='') then raise Exception.Create('Could not be converted!');
     
      //поправка на двузначный год
      if length(year)<3 then year:='19'+year;
     
      //кодирование результата
      Result:=EncodeDate(Strtoint(Year), Strtoint(month), Strtoint(Day));
    end;


------------------------------------------------------------------------

Вариант 2:

Source: <https://forum.sources.ru>

Функция StrToDate преобразует только числа, поэтому, если у Вас месяцы в
виде имён, то прийдётся использовать VarToDateTime.

    var
      D1, D2, D3 : TDateTime;
    begin
    D1 := VarToDateTime('December 6, 1969');
    D2 := VarToDateTime('6-Apr-1998');
    D3 := VarToDateTime('1998-Apr-6');
    ShowMessage(DateToStr(D1)+' '+DateToStr(D2)+' '+
    DateToStr(D3));
    end;


------------------------------------------------------------------------

Вариант 3:

Source: Delphi Knowledge Base: <https://www.baltsoft.com/>

> When extracting data from text or other operating systems the format of
> date strings can vary dramatically. Borland function StrToDateTime()
> converts a string to a TDateTime value, but it is limited to the fact
> that the string parameter must be in the format of the current locale\'s
> date/time format. eg. "MM/DD/YY HH:MM:SS"

**Answer:**

This is of little use when extracting dates such as ..

1. "Friday 18 October 2002 08:34am (45 secs)"  
   or "Wednesday 15 May 2002 06:12 (22 secs)"
2. "20020431"
3. "12.Nov.03"
4. "14 Hour 31 Minute 25 Second 321 MSecs"

This function will evaluate a DateTime string in accordance to the
DateTime specifier format string supplied. The following specifiers are
supported ...

Format| Description
------|---------------
dd    | the day as a number with a leading zero or space (01-31).
ddd   | the day as an abbreviation (Sun-Sat)
dddd  | the day as a full name (Sunday-Saturday)
mm    | the month as a number with a leading zero or space (01-12).
mmm   | the month as an abbreviation (Jan-Dec)
mmmm  | the month as a full name (January-December)
yy    | the year as a two-digit number (00-99).
yyyy  | the year as a four-digit number (0000-9999).
hh    | the hour with a leading zero or space (00-23)
nn    | the minute with a leading zero or space (00-59).
ss    | the second with a leading zero or space (00-59).
zzz   | the millisecond with a leading zero (000-999).
ampm  | Specifies am or pm flag hours (0..12)
ap    | Specifies a or p flag hours (0..12)

(Any other character corresponds to a literal or delimiter.)

**NOTE:**  
One assumption I have to make is that DAYS, MONTHS, HOURS and
MINUTES have a leading ZERO or SPACE (ie. are 2
chars long) and MILLISECONDS are 3 chars long (ZERO or
SPACE padded)

Using function

    DateTimeStrEval(const DateTimeFormat : string; const DateTimeStr : string) : TDateTime; 

The above Examples (1..4) can be evaluated as ... (Assume DT1 to DT4
equals example strings 1..4)

    MyDate := DateTimeStrEval('dddd dd mmmm yyyy hh:nnampm (ss xxxx)', DT1);
    MyDate := DateTimeStrEval('yyyymmdd', DT2);
    MyDate := DateTimeStrEval('dd-mmm-yy', DT3);
    MyDate := DateTimeStrEval('hh xxxx nn xxxxxx ss xxxxxx zzz xxxxx', DT4);

    uses SysUtils, DateUtils
     
      // =============================================================================
      // Evaluate a date time string into a TDateTime obeying the
      // rules of the specified DateTimeFormat string
      // eg. DateTimeStrEval('dd-MMM-yyyy hh:nn','23-May-2002 12:34)
      //
      // Delphi 6 Specific in DateUtils can be translated to ....
      //
      // YearOf()
      //
      // function YearOf(const AValue: TDateTime): Word;
      // var LMonth, LDay : word;
      // begin
      //   DecodeDate(AValue,Result,LMonth,LDay);
      // end;
      //
      // TryEncodeDateTime()
      //
      // function TryEncodeDateTime(const AYear,AMonth,ADay,AHour,AMinute,ASecond,
      //                            AMilliSecond : word;
      //                            out AValue : TDateTime): Boolean;
      // var LTime : TDateTime;
      // begin
      //   Result := TryEncodeDate(AYear, AMonth, ADay, AValue);
      //   if Result then begin
      //     Result := TryEncodeTime(AHour, AMinute, ASecond, AMilliSecond, LTime);
      //     if Result then
      //        AValue := AValue + LTime;
      //   end;
      // end;
      //
      // (TryEncodeDate() and TryEncodeTime() is the same as EncodeDate() and
      //  EncodeTime() with error checking and boolean return value)
      //
      // =============================================================================
     
    function DateTimeStrEval(const DateTimeFormat: string;
      const DateTimeStr: string): TDateTime;
    var
      i, ii, iii: integer;
      Retvar: TDateTime;
      Tmp,
        Fmt, Data, Mask, Spec: string;
      Year, Month, Day, Hour,
        Minute, Second, MSec: word;
      AmPm: integer;
    begin
      Year := 1;
      Month := 1;
      Day := 1;
      Hour := 0;
      Minute := 0;
      Second := 0;
      MSec := 0;
      Fmt := UpperCase(DateTimeFormat);
      Data := UpperCase(DateTimeStr);
      i := 1;
      Mask := '';
      AmPm := 0;
     
      while i < length(Fmt) do
      begin
        if Fmt[i] in ['A', 'P', 'D', 'M', 'Y', 'H', 'N', 'S', 'Z'] then
        begin
          // Start of a date specifier
          Mask := Fmt[i];
          ii := i + 1;
     
          // Keep going till not valid specifier
          while true do
          begin
            if ii > length(Fmt) then
              Break; // End of specifier string
            Spec := Mask + Fmt[ii];
     
            if (Spec = 'DD') or (Spec = 'DDD') or (Spec = 'DDDD') or
              (Spec = 'MM') or (Spec = 'MMM') or (Spec = 'MMMM') or
              (Spec = 'YY') or (Spec = 'YYY') or (Spec = 'YYYY') or
              (Spec = 'HH') or (Spec = 'NN') or (Spec = 'SS') or
              (Spec = 'ZZ') or (Spec = 'ZZZ') or
              (Spec = 'AP') or (Spec = 'AM') or (Spec = 'AMP') or
              (Spec = 'AMPM') then
            begin
              Mask := Spec;
              inc(ii);
            end
            else
            begin
              // End of or Invalid specifier
              Break;
            end;
          end;
     
          // Got a valid specifier ? - evaluate it from data string
          if (Mask <> '') and (length(Data) > 0) then
          begin
            // Day 1..31
            if (Mask = 'DD') then
            begin
              Day := StrToIntDef(trim(copy(Data, 1, 2)), 0);
              delete(Data, 1, 2);
            end;
     
            // Day Sun..Sat (Just remove from data string)
            if Mask = 'DDD' then
              delete(Data, 1, 3);
     
            // Day Sunday..Saturday (Just remove from data string LEN)
            if Mask = 'DDDD' then
            begin
              Tmp := copy(Data, 1, 3);
              for iii := 1 to 7 do
              begin
                if Tmp = Uppercase(copy(LongDayNames[iii], 1, 3)) then
                begin
                  delete(Data, 1, length(LongDayNames[iii]));
                  Break;
                end;
              end;
            end;
     
            // Month 1..12
            if (Mask = 'MM') then
            begin
              Month := StrToIntDef(trim(copy(Data, 1, 2)), 0);
              delete(Data, 1, 2);
            end;
     
            // Month Jan..Dec
            if Mask = 'MMM' then
            begin
              Tmp := copy(Data, 1, 3);
              for iii := 1 to 12 do
              begin
                if Tmp = Uppercase(copy(LongMonthNames[iii], 1, 3)) then
                begin
                  Month := iii;
                  delete(Data, 1, 3);
                  Break;
                end;
              end;
            end;
     
            // Month January..December
            if Mask = 'MMMM' then
            begin
              Tmp := copy(Data, 1, 3);
              for iii := 1 to 12 do
              begin
                if Tmp = Uppercase(copy(LongMonthNames[iii], 1, 3)) then
                begin
                  Month := iii;
                  delete(Data, 1, length(LongMonthNames[iii]));
                  Break;
                end;
              end;
            end;
     
            // Year 2 Digit
            if Mask = 'YY' then
            begin
              Year := StrToIntDef(copy(Data, 1, 2), 0);
              delete(Data, 1, 2);
              if Year < TwoDigitYearCenturyWindow then
                Year := (YearOf(Date) div 100) * 100 + Year
              else
                Year := (YearOf(Date) div 100 - 1) * 100 + Year;
            end;
     
            // Year 4 Digit
            if Mask = 'YYYY' then
            begin
              Year := StrToIntDef(copy(Data, 1, 4), 0);
              delete(Data, 1, 4);
            end;
     
            // Hours
            if Mask = 'HH' then
            begin
              Hour := StrToIntDef(trim(copy(Data, 1, 2)), 0);
              delete(Data, 1, 2);
            end;
     
            // Minutes
            if Mask = 'NN' then
            begin
              Minute := StrToIntDef(trim(copy(Data, 1, 2)), 0);
              delete(Data, 1, 2);
            end;
     
            // Seconds
            if Mask = 'SS' then
            begin
              Second := StrToIntDef(trim(copy(Data, 1, 2)), 0);
              delete(Data, 1, 2);
            end;
     
            // Milliseconds
            if (Mask = 'ZZ') or (Mask = 'ZZZ') then
            begin
              MSec := StrToIntDef(trim(copy(Data, 1, 3)), 0);
              delete(Data, 1, 3);
            end;
     
            // AmPm A or P flag
            if (Mask = 'AP') then
            begin
              if Data[1] = 'A' then
                AmPm := -1
              else
                AmPm := 1;
              delete(Data, 1, 1);
            end;
     
            // AmPm AM or PM flag
            if (Mask = 'AM') or (Mask = 'AMP') or (Mask = 'AMPM') then
            begin
              if copy(Data, 1, 2) = 'AM' then
                AmPm := -1
              else
                AmPm := 1;
              delete(Data, 1, 2);
            end;
     
            Mask := '';
            i := ii;
          end;
        end
        else
        begin
          // Remove delimiter from data string
          if length(Data) > 1 then
            delete(Data, 1, 1);
          inc(i);
        end;
      end;
     
      if AmPm = 1 then
        Hour := Hour + 12;
      if not TryEncodeDateTime(Year, Month, Day, Hour, Minute, Second, MSec, Retvar) then
        Retvar := 0.0;
      Result := Retvar;
    end;

