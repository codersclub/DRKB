---
Title: Число текущей недели
Date: 01.01.2007
---


Число текущей недели
====================

::: {.date}
01.01.2007
:::

    function WeekOfYear(ADate: TDateTime): word;
    var
      day: word;
      month: word;
      year: word;
      FirstOfYear: TDateTime;
    begin
      DecodeDate(ADate, year, month, day);
      FirstOfYear := EncodeDate(year, 1, 1);
      Result := Trunc(ADate - FirstOfYear) div 7 + 1;
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      ShowMessage(IntToStr(WeekOfYear(Date)));
    end;
     

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

 

 

------------------------------------------------------------------------

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

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

 

 

------------------------------------------------------------------------

    function WeekOfYear(Dat: TDateTime): Word;
    // Интерпретация номеров дней:
    // ISO: 1 = Понедельник, 7 = Воскресенье
    // Delphi SysUtils: 1 = Воскресенье, 7 = Суббота
    var
      Day, Month, Year: Word;
      FirstDate: TDateTime;
      DateDiff: Integer;
    begin
      day := SysUtils.DayOfWeek(Dat) - 1;
      Dat := Dat + 3 - ((6 + day) mod 7);
      DecodeDate(Dat, Year, Month, Day);
      FirstDate := EncodeDate(Year, 1, 1);
      DateDiff := Trunc(Dat - FirstDate);
      Result := 1 + (DateDiff div 7);
    end;

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

 

 
