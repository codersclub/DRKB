---
Title: Как узнать номер недели данного дня в году?
Date: 01.01.2007
---


Как узнать номер недели данного дня в году?
===========================================

Вариант 1:

    function WeekOfYear(ADate : TDateTime) : word;
    var
      day : word;
      month : word;
      year : word;
      FirstOfYear : TDateTime;
    begin
      DecodeDate(ADate, year, month, day);
      FirstOfYear := EncodeDate(year, 1, 1);
      Result := Trunc(ADate - FirstOfYear) div 7 + 1;
    end;
     
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      ShowMessage(IntToStr(WeekOfYear(Date)));
    end;

------------------------------------------------------------------------

Вариант 2:

    function WeekNum(const ADate: TDateTime): word;
    var
      Year: word;
      Month: word;
      Day: word;
    begin
      DecodeDate(ADate + 4 - DayOfWeek(ADate + 6), Year, Month, Day);
      result := 1 + trunc((ADate - EncodeDate(Year, 1, 5) +
          DayOfWeek(EncodeDate(Year, 1, 3))) / 7);
    end;

------------------------------------------------------------------------

Вариант 3:

Source: <https://forum.sources.ru>

    function WeekOfYear(Dat: TDateTime): Word;
    // Интерпретация номеров дней:
    // ISO: 1 = Понедельник, 7 = Воскресенье
    // Delphi SysUtils: 1 = Воскресенье, 7 = Суббота
    var
      Day,
      Month,
      Year: Word;
      FirstDate: TDateTime;
      DateDiff : Integer;
    begin
      day := SysUtils.DayOfWeek(Dat)-1;
      Dat := Dat + 3 - ((6 + day) mod 7);
      DecodeDate(Dat, Year, Month, Day);
      FirstDate := EncodeDate(Year, 1, 1);
      DateDiff  := Trunc(Dat - FirstDate);
      Result    := 1 + (DateDiff div 7);
    end;


------------------------------------------------------------------------

Вариант 4:

Source: <https://www.swissdelphicenter.ch>

Получить номер недели по дате

    var
       FirstWeekDay: Integer = 2;
       { Wochentag, mit dem die Woche beginnt 
       (siehe Delphi-Wochentage) 
       2 : Montag (nach DIN 1355) }
       FirstWeekDate: Integer = 4;
       { 1 : Beginnt am ersten Januar 
        4 : Erste-4 Tage-Woche (nach DIN 1355) 
        7 : Erste volle Woche }
     
       { liefert das Datum des ersten Tages der Woche }
       { get date of first day of week}
     function WeekToDate(AWeek, AYear: Integer): TDateTime;
     begin
       Result := EncodeDate(AYear, 1, FirstWeekDate);
       Result := Result + (AWeek - 1) * 7 - ((DayOfWeek(Result) + (7 - FirstWeekDay)) mod 7);
     end;
     
     { liefert die Wochennummer und das Jahr, zu dem die Woche gehort }
     { get weeknumber and year of the given week number}
     procedure DateToWeek(ADate: TDateTime; var AWeek, AYear: Word);
     var
       Month, Day: Word;
     begin
       ADate := ADate - ((DayOfWeek(ADate) - FirstWeekDay + 7) mod 7) + 7 - FirstWeekDate;
       DecodeDate(ADate, AYear, Month, Day);
       AWeek := (Trunc(ADate - EncodeDate(AYear, 1, 1)) div 7) + 1;
     end;
     
     
     {Week to date example}
     procedure TForm1.Button1Click(Sender: TObject);
     begin
       ShowMessage(FormatDateTime('dd.mm.yyyy', WeekToDate(51, 2000)));
     end;
     
     {Date to week example}
     procedure TForm1.Button2Click(Sender: TObject);
     var
       week, year: Word;
     begin
       DateToWeek(now, week, year);
       ShowMessage(IntToStr(week));
       ShowMessage(IntToStr(year));
     end;


 
