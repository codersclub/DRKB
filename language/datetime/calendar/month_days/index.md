---
Title: Дни в месяце
Author: Ревенко Алексей
Date: 01.01.2007
---


Дни в месяце
============

Вариант 1:

Author: Ревенко Алексей

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

    // Количество дней в любом месяце любого
    // года можно получить с помощью EndOfAMonth
     
    var
      YYYY, MM, DD: Word;
      D: TDateTime;
    begin
      DecodeDate(Date, YYYY, MM, DD);
      D := EndOfAMonth(YYYY, {Номер месяца});
      DecodeDate(D, YYYY, MM, DD); // DD - номер последнего дня в месяце
    end;




------------------------------------------------------------------------

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

Получить число дней в месяце

    function DaysOfMonth(mm, yy: Integer): Integer; 
    begin 
      if mm = 2 then  
      begin 
        Result := 28; 
        if IsLeapYear(yy) then Result := 29; 
      end  
      else  
      begin 
        if mm < 8 then  
        begin 
          if (mm mod 2) = 0 then 
            Result := 30 
          else 
            Result := 31; 
        end  
        else  
        begin 
          if (mm mod 2) = 0 then 
            Result := 31 
          else 
            Result := 30; 
        end; 
      end; 
    end; 
     
    procedure TForm1.Button1Click(Sender: TObject); 
    var 
      days: Integer; 
    begin 
      days := DaysOfMonth(7, 2001); 
      ShowMessage('July 2001 has ' + IntToStr(days) + ' days'); 
    end; 




------------------------------------------------------------------------

Вариант 3:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

Вычислить последний день текущего месяца:

    function LastDayOfCurrentMonth: TDate;
     var
       y, m, d: Word;
     begin
       DecodeDate(now, y, m, d);
       m := m + 1;
       if m  12 then
       begin
         y := y + 1;
         m := 1;
       end;
       Result := EncodeDate(y, m, 1) - 1;
     end;
     
     procedure TForm1.Button1Click(Sender: TObject);
     begin
       ShowMessage(DateToStr(LastDayOfCurrentMonth));
     end;


