---
Title: Получить даты текущей недели с понедельника по пятницу
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Получить даты текущей недели с понедельника по пятницу
======================================================

    {
      Data sometimes have to be filtered regarding to working
      days (Mo.-Fri.) of the current Week.
      Following procs set your TDateTimePicker automatically. 
    } 
     
    function GetMonday(RefDay: TDate): TDate; 
    var 
      DoW: Integer; 
      DateOffset: Integer; 
    begin 
      DoW := DayOfWeek(RefDay); 
      // Montag der Woche 
      if DoW = 1 then DateOffset := -6  
      else  
        DateOffset := Dow - 2; 
      Result := RefDay - DateOffset; 
    end; 
     
    function GetFriday(RefDay: TDate): TDate; 
    var 
      DoW: Integer; 
      DateOffset: Integer; 
    begin 
      DoW := DayOfWeek(RefDay); 
         { 
         Friday of current week 
         Freitag der Woche 
         } 
      if DoW = 1 then DateOffset := -2  
      else  
        DateOffset := Dow - 6; 
      Result := RefDay - DateOffset; 
    end; 
     
    procedure SetWorkingDaysFilter(S, E: TDateTimePicker); 
    var 
      N: TDate; 
    begin 
      N      := Now; 
      S.Date := GetMonday(N); 
      E.Date := GetFriday(N); 
    end; 
     
    {Just as short as simple} 
    {Einfach und kurz} 
     
    type 
      TForm1 = class(TForm) 
        DStart: TDateTimePicker; 
        DEnd: TDateTimePicker; 
        btSetFilter: TButton; 
        procedure btSetFilterClick(Sender: TObject); 
      end; 
     
    procedure TForm1.btSetFilterClick(Sender: TObject); 
    begin 
      SetWorkingDaysFilter(DStart, DEnd); 
    end;
     



 
