---
Title: Вывод даты в нужном формате
Date: 01.01.2007
---


Вывод даты в нужном формате
===========================

::: {.date}
01.01.2007
:::

    function CheckDateFormat(SDate:  string):  string;
    var
      IDateChar: string;
      x, y: integer;
    begin
      IDateChar := '.,\/';
      for y := 1 to length(IDateChar) do
      begin
        x := pos(IDateChar[y], SDate);
        while x > 0 do
        begin
          Delete(SDate, x, 1);
          Insert('-', SDate, x);
          x := pos(IDateChar[y], SDate);
        end;
      end;
      CheckDateFormat := SDate;
    end;
     
     
    function DateEncode(SDate:string):longint;
    var
      year, month, day: longint;
      wy, wm, wd: longint;
      Dummy: TDateTime;
      Check: integer;
    begin
      DateEncode := -1;
      SDate := CheckDateFormat(SDate);
      Val(Copy(SDate, 1, pos('-', SDate) - 1), day, check);
      Delete(Sdate, 1, pos('-', SDate));
      Val(Copy(SDate, 1, pos('-', SDate) - 1), month, check);
      Delete(SDate, 1, pos('-', SDate));
      Val(SDate, year, check);
      wy := year;
      wm := month;
      wd := day;
      try
        Dummy := EncodeDate(wy, wm, wd);
      except
        year := 0;
        month := 0;
        day := 0;
      end;
      DateEncode := (year * 10000) + (month * 100) + day;
    end;

 

------------------------------------------------------------------------

Формат даты

У меня есть неотложная задача: в настоящее время я разрабатываю проект,
где я должен проверять достоверность введенных дат с применением маски
\_\_/\_\_/\_\_\_\_, например 12/12/1997.

Некоторое время назад я делал простой шифратор/дешифратор дат,
проверяющий достоверность даты. Код приведен ниже.

    function CheckDateFormat(SDate: string): string;
    var
      IDateChar: string;
      x, y: integer;
    begin
      IDateChar := '.,\/';
      for y := 1 to length(IDateChar) do
      begin
        x := pos(IDateChar[y], SDate);
        while x > 0 do
        begin
          Delete(SDate, x, 1);
          Insert('-', SDate, x);
          x := pos(IDateChar[y], SDate);
        end;
      end;
      CheckDateFormat := SDate;
    end;
     
    function DateEncode(SDate: string): longint;
    var
      year, month, day: longint;
      wy, wm, wd: longint;
      Dummy: TDateTime;
      Check: integer;
    begin
      DateEncode := -1;
      SDate := CheckDateFormat(SDate);
      Val(Copy(SDate, 1, pos('-', SDate) - 1), day, check);
      Delete(Sdate, 1, pos('-', SDate));
      Val(Copy(SDate, 1, pos('-', SDate) - 1), month, check);
      Delete(SDate, 1, pos('-', SDate));
      Val(SDate, year, check);
      wy := year;
      wm := month;
      wd := day;
      try
        Dummy := EncodeDate(wy, wm, wd);
      except
        year := 0;
        month := 0;
        day := 0;
      end;
      DateEncode := (year * 10000) + (month * 100) + day;
    end; 

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

 

 

 

 

 

 
