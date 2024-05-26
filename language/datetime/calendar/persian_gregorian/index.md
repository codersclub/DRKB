---
Title: Преобразовать Персидскую дату в дату по Грегорианскому календарю
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch>
---


Преобразовать Персидскую дату в дату по Грегорианскому календарю
================================================================

    function Persia_to_Ger_date(aa: ShortString; ResultKind: Byte = 0): ShortString;
     
       function TrueTo1(co: Boolean): Integer;
       begin
         if co then TrueTo1 := 1
          else
            TrueTo1 := 0;
       end;
     
        const
       Conm_mons: array[0..11] of Byte = (31,28,31,30,31,30,31,31,30,31,30,31);
       LeapYearSh: array[0..4] of Integer = (1375,1379,1383,1387,1391);
       LeapYearMi: array[0..4] of Integer = (1996,2000,2004,2008,2012);
       monthes: array[0..11] of ShortString = ('Jan', 'Feb', 'Mar', 'Apr',
         'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
     type
       date = record
         da_day, da_mon, da_year: Integer;
       end;
     var
       m_mons: array[0..11] of BYTE;
       LastDayCountSh, LastDayCountMi: integer;
       a, b: date;
       sYY, sMM, sDD: ShortString;
       I: Integer;
     begin
       for I := Low(Conm_mons) to High(Conm_mons) do
         m_mons[I] := Conm_mons[I];
     
       a.da_day  := StrToNum(Copy(aa, DayPosInDate, DayLen));
       a.da_mon  := StrToNum(Copy(aa, MonthPosInDate, MonthLen));
       a.da_year := StrToNum(Copy(aa, YearPosInDate, YearLen));
       b.da_year := a.da_year + 621;
       Inc(b.da_year, TrueTo1(((a.da_mon > 10) or ((a.da_mon = 10) and (a.da_day >= 12)))
         or ((LeapYearSh[(a.da_year - 1374) div 4] <> a.da_year) and
         ((a.da_mon = 10) and (a.da_day = 11)))));
       Inc(m_mons[1], TrueTo1(LeapYearMi[(b.da_year - 1996) div 4] = b.da_year));
       if (a.da_mon <= 7) then LastDayCountSh := ((a.da_mon - 1) * 31 + a.da_day)
       else
          LastDayCountSh := (186 + (a.da_mon - 7) * 30 + a.da_day);
       if (b.da_year = (a.da_year + 622)) then LastDayCountMi :=
           LastDayCountSh - 286 - TrueTo1(LeapYearSh[(a.da_year - 1375) div 4] = a.da_year)
       else
          LastDayCountMi := (LastDayCountSh + 79);
     
       b.da_day := LastDayCountMi;
       b.da_mon := 0;
       while (LastDayCountMi > m_mons[b.da_mon]) do
       begin
         Dec(LastDayCountMi, m_mons[b.da_mon]);
         Inc(b.da_mon);
         b.da_day := LastDayCountMi;
       end;
       Inc(b.da_mon);
       if b.da_year < 1000 then sYY := sYY + '0';
       if b.da_year < 100 then sYY := sYY + '0';
       if b.da_year < 10 then sYY := sYY + '0';
       sYY := sYY + IntToStr(b.da_year);
     
       if b.da_mon < 10 then sMM := sMM + '0';
       sMM := sMM + IntToStr(b.da_mon);
     
       if b.da_day < 10 then sDD := sDD + '0';
       sDD := sDD + IntToStr(b.da_day);
     
       case ResultKind of
         0: Persia_to_Ger_date := sYY + '/' + sMM + '/' + sDD;
         1: Persia_to_Ger_date := sYY + ' ' + monthes[b.da_mon - 1] + ' ' + sDD;
       end;
     end;


 
