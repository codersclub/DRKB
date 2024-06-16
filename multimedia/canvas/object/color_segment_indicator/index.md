---
Title: Процедура выводит на Canvas семисегментный индикатор, позволяя управлять включенными сегментами
author: Pavel Manzharov, pavel_man@hotmail.com
Date: 25.02.2003
---


Процедура выводит на Canvas семисегментный индикатор, позволяя управлять включенными сегментами
===============================================================================================

    { **** UBPFD *********** by delphibase.endimus.com ****
    >> Процедура выводит на Canvas семисегментный индикатор,
    позволяя управлять включенными сегментами
     
    Процедура выводит на Canvas индикатор семисегментного кода
    Вход:
    SegStr - Строка содержащая символы горящих сегментов(используемые символы ABCDEFGH)
    x,y - координаты верхнего левого угла вывода индикатора
    Scale - масштаб индикатора от 1 и выше (множитель)
    Hndl - Handle Canvas на который выводится изображение
     
    Зависимости: Стандартные
    Автор:       Pavel Manzharov, pavel_man@hotmail.com, ICQ:4838921, Москва
    Copyright:   Pavel Manzharov
    Дата:        25 февраля 2003 г.
    ***************************************************** }
     
    {Процедура выводит на Canvas индикатор семисегментного кода
    Вход:
         SegStr - Строка содержащая символы горящих сегментов
           (используемые символы ABCDEFGH)
         x,y - координаты верхнего левого угла вывода индикатора
         Scale - масштаб индикатора от 1 и выше (множитель)
         Hndl - Handle Canvas на который выводится изображение}
     
    procedure Display7Seg(SegStr: string; x, y: integer; Scale: extended; hndl:
      hdc);
    const
      // Цвет горящих сегментов
      ColorOn: Tcolor = clBlue;
      // Цвет погашенных сенментов
      ColorOff: TColor = clltGray;
    var
      // Canvas на который выводится изображение
      Canvas1: TCanvas;
      // Координаты выводимого сегмента
      x1, x2, y1, y2: integer;
    begin
      // Создаем Canvas
      Canvas1 := TCanvas.Create;
      // Проверяем масштаб и если он меньше 1 присваиваем ему 1
      if Scale < 1 then
        scale := 1;
      // Укажем что вывод осуществляется на Canvas переданный в параметрах
      Canvas1.Handle := Hndl;
      // Установим толщину линий сегментов равной масштабу
      Canvas1.Pen.Width := Trunc(Scale);
      // Пересчитаем координаты вывода с учетом масштаба для всех сегментов
      {A}
      x1 := Trunc(x + 1 * scale);
      x2 := Trunc(x1 + 5 * scale);
      y1 := y;
      y2 := y;
      if StrPos(Pchar(SegStr), 'A') <> nil then
        Canvas1.Pen.Color := ColorOn
      else
        Canvas1.Pen.Color := ColorOff;
      Canvas1.MoveTo(x1, y1);
      Canvas1.LineTo(x2, y2);
      {G}
      y1 := Trunc(y + 6 * Scale);
      y2 := y1;
      if StrPos(Pchar(SegStr), 'G') <> nil then
        Canvas1.Pen.Color := ColorOn
      else
        Canvas1.Pen.Color := ColorOff;
      Canvas1.MoveTo(x1, y1);
      Canvas1.LineTo(x2, y2);
      {D}
      y1 := Trunc(y + 12 * Scale);
      y2 := y1;
      if StrPos(Pchar(SegStr), 'D') <> nil then
        Canvas1.Pen.Color := ColorOn
      else
        Canvas1.Pen.Color := ColorOff;
      Canvas1.MoveTo(x1, y1);
      Canvas1.LineTo(x2, y2);
      {H}
      x1 := Trunc(x + 8 * Scale);
      x2 := x1;
      if StrPos(Pchar(SegStr), 'H') <> nil then
        Canvas1.Pen.Color := ColorOn
      else
        Canvas1.Pen.Color := ColorOff;
      Canvas1.MoveTo(x1, y1);
      Canvas1.LineTo(x2, y2);
      {F}
      x1 := x;
      x2 := x;
      y1 := Trunc(y + 1 * scale);
      y2 := Trunc(y + 5 * scale);
      if StrPos(Pchar(SegStr), 'F') <> nil then
        Canvas1.Pen.Color := ColorOn
      else
        Canvas1.Pen.Color := ColorOff;
      Canvas1.MoveTo(x1, y1);
      Canvas1.LineTo(x2, y2);
      {E}
      y1 := Trunc(y + 7 * scale);
      y2 := Trunc(y + 11 * scale);
      if StrPos(Pchar(SegStr), 'E') <> nil then
        Canvas1.Pen.Color := ColorOn
      else
        Canvas1.Pen.Color := ColorOff;
      Canvas1.MoveTo(x1, y1);
      Canvas1.LineTo(x2, y2);
      {C}
      x1 := Trunc(x + 7 * scale);
      x2 := x1;
      if StrPos(Pchar(SegStr), 'C') <> nil then
        Canvas1.Pen.Color := ColorOn
      else
        Canvas1.Pen.Color := ColorOff;
      Canvas1.MoveTo(x1, y1);
      Canvas1.LineTo(x2, y2);
      {B}
      y1 := Trunc(y + 1 * scale);
      y2 := Trunc(y + 5 * scale);
      if StrPos(Pchar(SegStr), 'B') <> nil then
        Canvas1.Pen.Color := ColorOn
      else
        Canvas1.Pen.Color := ColorOff;
      Canvas1.MoveTo(x1, y1);
      Canvas1.LineTo(x2, y2);
      // После вывода последнего сегмента освободим Canvas
      Canvas1.Free;
    end;

Пример использования:

    Hndl := Form1.Canvas.Handle;
    Display7Seg('ABCDE',100,20,8,Hndl); 
