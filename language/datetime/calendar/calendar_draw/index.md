---
Title: Программа рисует на форме календарь на 2002 год
Date: 01.01.2007
---


Программа рисует на форме календарь на 2002 год
===============================================

::: {.date}
01.01.2007
:::

В связи с наступающим Новым годом я решил посвятить выпуск календарю.
Ниже приведенная программа рисует на форме календарь на 2002 год. Для
каждого месяца сначала выводится его название (используется глобальная
переменная LongMonthNames модуля SysUtils), далее выводятся сокращенные
названия дней недели (глобальная переменная ShortDayNames модуля
SysUtils) и, наконец, выводятся сами числа. Количество дней в месяце
записано в массиве months. Чтобы определить, високосный это год или нет,
используется функция IsLeapYear.

    const year = 2002; // Год календаря
     
    var months: array [1..12] of byte;
     
    procedure TForm1.FormCreate(Sender: TObject);
    begin
      Form1.Caption := 'Календарь на ' + IntToStr(year) + ' год';
      Form1.Color := clWhite;
      // Длины месяцев:
      months[1] := 31;
      months[2] := 28 + ord(IsLeapYear(year));
      months[3] := 31;
      months[4] := 30;
      months[5] := 31;
      months[6] := 30;
      months[7] := 31;
      months[8] := 31;
      months[9] := 30;
      months[10] := 31;
      months[11] := 30;
      months[12] := 31;
    end;
     
    procedure TForm1.FormPaint(Sender: TObject);
    const // Настройки размеров календаря:
      MonthDX = 150;
      MonthDY = 135;
      DayDX = 20;
      DayDY = 15;
      MonthH = 20;
    var
      month, i: integer;
      day: integer;
      s: string[2];
    begin
      with Form1.Canvas do for month := 1 to 12 do begin
        // Вывод названия месяца:
        Font.Name := 'Times';
        Font.Size := 13;
        TextOut((month - 1) mod 3 * MonthDX, (month - 1) div 3 * MonthDY,
          LongMonthNames[month]);
     
        Font.Name := 'Courier';
        Font.Size := 8;
        // Вывод названий дней недели:
        for day := 1 to 7 do
          TextOut((month - 1) mod 3 * MonthDX,
            day mod 7 * DayDY + (month - 1) div 3 * MonthDY + MonthH,
            ShortDayNames[(day + 1) mod 7 + 1]);
     
        // Определение дня недели первого числа месяца:
        day := DayOfWeek(EncodeDate(year, month, 1)) - 2;
        if day < 0 then inc(day, 7);
        // Вывод чисел:
        for i := 1 to months[month] do begin
          str(i: 2, s);
          TextOut(day div 7 * DayDX + (month - 1) mod 3 * MonthDX + DayDX,
            day mod 7 * DayDY + (month - 1) div 3 * MonthDY + MonthH, s);
          inc(day);
        end;
      end;
    end;
     
     

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

 
