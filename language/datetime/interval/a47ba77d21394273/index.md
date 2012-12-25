---
Title: Как подсчитать возраст по дню рождения?
Date: 01.01.2007
---


Как подсчитать возраст по дню рождения?
=======================================

::: {.date}
01.01.2007
:::

    { BrthDate:  Date of birth }
     
    function TFFuncs.CalcAge(brthdate: TDateTime): Integer;
    var
      month, day, year, bmonth, bday, byear: word;
    begin
      DecodeDate(BrthDate, byear, bmonth, bday);
      if bmonth = 0 then
        result := 0
      else
      begin
        DecodeDate(Date, year, month, day);
        result := year - byear;
        if (100 * month + day) < (100 * bmonth + bday) then
          result := result - 1;
      end;
    end;

------------------------------------------------------------------------

    procedure TForm1.Button1Click(Sender: TObject);
    var
      Month, Day, Year, CurrentMonth, CurrentDay, CurrentYear: word;
      Age: integer;
    begin
      DecodeDate(DateTimePicker1.Date, Year, Month, Day);
      DecodeDate(Date, CurrentYear, CurrentMonth, CurrentDay);
      if (Year = CurrentYear) and (Month = CurrentMonth) and (Day = CurrentDay) then
        Age := 0
      else
      begin
        Age := CurrentYear - Year;
        if (Month > CurrentMonth) then
          dec(Age)
        else if Month = CurrentMonth then
          if (Day > CurrentDay) then
            dec(Age);
      end;
      Label1.Caption := IntToStr(Age);
    end;

Взято с Delphi Knowledge Base: <https://www.baltsoft.com/>

------------------------------------------------------------------------

    function CalculateAge(Birthday, CurrentDate: TDate): Integer;
    var
      Month, Day, Year, CurrentYear, CurrentMonth, CurrentDay: Word;
    begin
      DecodeDate(Birthday, Year, Month, Day);
      DecodeDate(CurrentDate, CurrentYear, CurrentMonth, CurrentDay);
     
      if (Year = CurrentYear) and (Month = CurrentMonth) and (Day = CurrentDay) then
      begin
        Result := 0;
      end
      else
      begin
        Result := CurrentYear - Year;
        if (Month > CurrentMonth) then
          Dec(Result)
        else
        begin
          if Month = CurrentMonth then
            if (Day > CurrentDay) then
              Dec(Result);
        end;
      end;
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      Label1.Caption := Format('Your age is %d',
        [CalculateAge(StrToDate('01.01.1903'), Date)]);
    end;

Взято с сайта: <https://www.swissdelphicenter.ch>

------------------------------------------------------------------------

    DecodeDate(DM.Table.FieldByName('Born').AsDateTime, Year, Month, Day); // Дата рождения
    DecodeDate(Date, YYYY, MM, DD); // Текущая дата
     
    if (MM >= Month) and (DD >= Day) then
      Edit2.Text := IntToStr((YYYY - Year))
    else
      Edit2.Text := IntToStr((YYYY - Year) - 1);

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
