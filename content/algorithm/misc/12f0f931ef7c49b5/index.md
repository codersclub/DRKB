---
Title: Как посчитать возраст человека?
Date: 01.01.2007
---


Как посчитать возраст человека?
===============================

::: {.date}
01.01.2007
:::

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
      Label1.Caption := Format('Your age is %d', [CalculateAge(StrToDate('01.01.1903'), Date)]); 
    end; 

Взято с сайта <https://www.swissdelphicenter.ch/en/tipsindex.php>
