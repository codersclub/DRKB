---
Title: Fast Report - сумма прописью
Author: Виталий Кубекин
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Fast Report - сумма прописью
=============================

WEB-сайт: http://www.delphiplus.org

Если задать вопрос программисту: "что делала Ваша первая программа",
то половина, наверное, ответит, что она печатала платежные поручения.
Какие проблемы встают обычно при написании такой программы? А проблемы
возникают следующие: как хранить платежные поручения, как их вводить и
изменять, как их распечатывать. Если бы Вы сейчас стали писать такую
программу, то какой генератор отчетов вы бы стали использовать? Я думаю,
половина ответов была бы - FastReport. Не секрет, что генератор отчетов
FastReport является одним из самых популярных генераторов отчетов в
нашей стране. И эта популярность легко объяснить удобством его
использования. Но в нем не хватает такой мелочи, как сумма прописью. Эта
проблема опытным программистом обычно решаются очень быстро или не
встает вообще. Но каждый опытный программист когда-то был начинающим.
Написанием процедуры вывода суммы прописью мы и займемся.

    // Для начала напишем несколько вспомогательных процедур.
    // Итак, процедура номер один:
     
    procedure Num(Value: byte);
    begin
      case Value of
        1: if Rend = true then Result := Result + 'один ' else Result := Result + 'одна ';
        2: if Rend = true then Result := Result + 'два ' else Result := Result + 'две ';
        3: Result := Result + 'три ';
        4: Result := Result + 'четыре ';
        5: Result := Result + 'пять ';
        6: Result := Result + 'шесть ';
        7: Result := Result + 'семь ';
        8: Result := Result + 'восемь ';
        9: Result := Result + 'девять ';
        10: Result := Result + 'десять ';
        11: Result := Result + 'одиннадцать ';
        12: Result := Result + 'двенадцать ';
        13: Result := Result + 'тринадцать ';
        14: Result := Result + 'четырнадцать ';
        15: Result := Result + 'пятнадцать ';
        16: Result := Result + 'шестнадцать ';
        17: Result := Result + 'семнадцать ';
        18: Result := Result + 'восемнадцать ';
        19: Result := Result + 'девятнадцать ';
      end
    end;
     
    // Эта процедура добавляет число прописью в диапазоне от 1 до 19 к результату.
     
    // Процедура номер два:
     
    procedure Num10(Value: byte);
    begin
      case Value of
        2: Result := Result + 'двадцать ';
        3: Result := Result + 'тридцать ';
        4: Result := Result + 'сорок ';
        5: Result := Result + 'пятьдесят ';
        6: Result := Result + 'шестьдесят ';
        7: Result := Result + 'семьдесят ';
        8: Result := Result + 'восемьдесят ';
        9: Result := Result + 'девяносто ';
      end;
    end;
     
    // Эта процедура добавляет десятки в диапазоне от 20 до 90 к результату.
     
    // Процедура номер три:
     
    procedure Num100(Value: byte);
    begin
      case Value of
        1: Result := Result + 'сто ';
        2: Result := Result + 'двести ';
        3: Result := Result + 'триста ';
        4: Result := Result + 'четыреста ';
        5: Result := Result + 'пятьсот ';
        6: Result := Result + 'шестьсот ';
        7: Result := Result + 'семьсот ';
        8: Result := Result + 'восемьсот ';
        9: Result := Result + 'девятьсот ';
      end
    end;
     
    // Эта процедура добавляет сотни в диапазоне от 100 до 900 к результату.
     
    // Дальше немного подробнее.
     
    // Итак, процедура номер четыре:
    // На входе число от 1 до 999
     
    procedure Num00;
    begin
      //Добавляем сотни если они есть
      Num100(ValueTemp div 100);
      //Отбрасываем сотни
      ValueTemp := ValueTemp mod 100;
      //Если меньше 20, то добавляем число прописью от 1 до 19
      if ValueTemp < 20
        then Num(ValueTemp)
      else begin
           //Добавляем десятки
        Num10(ValueTemp div 10);
           //Отбрасываем десятки
        ValueTemp := ValueTemp mod 10;
           //Добавляем число прописью от 1 до 9
        Num(ValueTemp);
      end;
    end;
     
    // Процедура номер пять:
     
    //Mult-Предел обработки числа
    //s1- единственное число, именительный падеж (например ‘миллион’)
    //s2- единственное число, родительный падеж (например ‘миллиона’)
    //s3- множественное число, родительный падеж (например ‘миллионов’)
     
    procedure NumMult(Mult: int64; s1, s2, s3: string);
    var ValueRes: int64;
    begin
       //Если число больше предела обработки, то обрабатываем
      if Value >= Mult then
      begin
           //Выделяем число в диапазоне от 1 до 999
        ValueTemp := Value div Mult;
        ValueRes := ValueTemp;
           //Добавляем число прописью в диапазоне от 1 до 999
        Num00;
           //Добавляем обозначение числа в диапазоне от 1 до 999 (например, миллионов)
        if ValueTemp = 1 then Result := Result + s1
        else if (ValueTemp > 1) and (ValueTemp < 5) then Result := Result + s2
        else Result := Result + s3;
           //Вычитаем обработанное число
        Value := Value - Mult * ValueRes;
      end;
    end;
     
    // Собственно, сама функция "сумма прописью":
     
    function TfrCalc.Propis(Value: int64): string;
    var
      Rend: boolean;
      ValueTemp, ValueOst: int64;
     
    //Описанные выше функции
    begin
       //Определяем если ноль
      if (Value = 0)
        then Result := 'ноль'
      else begin
        Result := '';
           //устанавливаем окончания мужского рода (триллион, миллиард, миллион)
        Rend := true;
           //обрабатываем триллионы
        NumMult(1000000000000, 'триллион ', 'триллиона ', 'триллионов ');
           //обрабатываем миллиарды
        NumMult(1000000000, 'миллиард ', 'миллиарда ', 'миллиардов ');
           //обрабатываем миллионы
     
        NumMult(1000000, 'миллион ', 'миллиона ', 'миллионов ');
           //устанавливаем окончания женского рода (тысячи)
        Rend := false;
           //обрабатываем тысячи
        NumMult(1000, 'тысяча ', 'тысячи ', 'тысяч ');
           //устанавливаем окончания мужского рода
        Rend := true;
        ValueTemp := Value;
        Num00;
      end;
    end;
     
    // Я думаю, в самой функции ничего сложного нет, а если есть то можно разобраться.
    // Теперь необходимо подключить нашу функцию к FastReport.
    // Добавим обработчик события OnUserFuncton класса TfrReport:
     
    procedure TForm1.frReport1UserFunction(const Name: string;
      p1, p2, p3: Variant; var Val: Variant);
    begin
      if AnsiCompareText('Пропись', Name) = 0 then
        val := Propis(Trunc(frParser.Calc(p1)));
    end;
     
    // Для того чтобы функция появилась в списке функций:
     
    frAddFunctionDesc(nil, 'Пропись', 'Дополнительные функции',
      'Пропись(<Число>)/Возвращает Число прописью');
     
    // Итак, функцию мы написали, но не хватает одной мелочи- названия валюты.
    // Итак, напишем еще тройку функций.
     
    // Функция номер один записывает в S1,S2,S3 строки разделенные ';',
    // например 'рубль;рубля;рублей'.
     
    procedure Fst(S: string; var S1: string; var S2: string; var S3: string);
    var
      pos: integer;
    begin
      S1 := ''; S2 := ''; S3 := ''; pos := 1;
     
      while ((pos <= Length(S)) and (S[pos] <> ';')) do
      begin
        S1 := S1 + S[pos];
        inc(pos);
      end;
      inc(pos);
     
      while ((pos <= Length(S)) and (S[pos] <> ';')) do
      begin
        S2 := S2 + S[pos];
        inc(pos);
      end;
      inc(pos);
     
      while ((pos <= Length(S)) and (S[pos] <> ';')) do
      begin
        S3 := S3 + S[pos];
        inc(pos);
      end;
      inc(pos);
    end;
     
    // Функция номер два возвращает запись о валюте с нужным склонением
     
    //Value – число для склонения
    //Skl1- единственное число, именительный падеж (рубль)
    //Skl2- единственное число, родительный падеж (рубля)
    //Skl3- множественное число, родительный падеж (рублей)
     
    function Ruble(Value: int64; Skl: string): string;
    var
      hk10, hk20: integer;
      Skl1, Skl2, Skl3: string;
    begin
      Fst(Skl, Skl1, Skl2, Skl3);
      hk10 := Value mod 10;
      hk20 := Value mod 100;
      if (hk20 > 10) and (hk20 < 20)
        then result := result + Skl3
      else if (hk10 = 1) then result := result + Skl1
      else if (hk10 > 1) and (hk10 < 5) then result := result + Skl2
      else result := result + Skl3;
    end;
     
    // И то же самое для копеек.
    // Функция номер три возвращает запись о копейках с нужным склонением
     
    //Value – число для склонения
    //Skp1- единственное число, именительный падеж (копейка)
    //Skp2- единственное число, родительный падеж (копейки)
    //Skp3- множественное число, родительный падеж (копеек)
     
    function Kopeika(Value: integer; Skp: string): string;
    var
      hk10, hk20: integer;
      Skp1, Skp2, Skp3: string;
    begin
      Fst(Skp, Skp1, Skp2, Skp3);
      hk10 := Value mod 10;
      hk20 := Value mod 100;
      if (hk20 > 10) and (hk20 < 20)
        then result := result + Skp3
      else if (hk10 = 1) then result := result + Skp1
      else if (hk10 > 1) and (hk10 < 5) then result := result + Skp2
      else result := result + Skp3;
    end;
     
    // Подключаем все это к FastReport.
    // Добавляем обработчик события OnUserFuncton класса TfrReport:
     
    procedure TForm1.frReport1UserFunction(const Name: string;
      p1, p2, p3: Variant; var Val: Variant);
    begin
      if AnsiCompareText('Рубль', Name) = 0 then
        val := Ruble(Trunc(frParser.Calc(p1)), frParser.Calc(p2));
     
      if AnsiCompareText('Копейка', Name) = 0 then
        val := Kopeika(Trunc(frParser.Calc(p1)), frParser.Calc(p2));
    end;
     
    // Для того чтобы функция появилась в списке функций:
    frAddFunctionDesc(nil, 'Рубль', 'Дополнительные функции',
      'Рубль(<Число>,<Рубль>,<Рубля>,<Рублей>)/Возвращает рубль прописью');

    frAddFunctionDesc(nil, 'Копейка', 'Дополнительные функции',
      'Копейка(<Число>,<Копейка>,<Копейки>,<Копеек>)/Возвращает копейки прописью');

Вот вроде бы и все, что хотелось написать.

