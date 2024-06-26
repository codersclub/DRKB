---
Title: Расстояние (разность) между двумя строками. Функция Левенштейна
Author: Андрей aka wicked, wilk@ua.fm
Date: 10.08.2002
---


Расстояние (разность) между двумя строками. Функция Левенштейна
===============================================================

    { **** UBPFD *********** by kladovka.net.ru ****
    >> Расстояние (разность) между двумя строками. Функция Левенштейна
     
    Зависимости: System
    Автор:       Андрей aka wicked, wilk@ua.fm, ICQ:92356239, Тернополь
    Copyright:   описание алгоритма взято с http://www.merriampark.com/ld.htm, реализация моя
    Дата:        10 августа 2002 г.
    ********************************************** }
     
    const cuthalf = 100; // константа, ограничивающая макс. длину 
                         // обрабатываемых строк
     
    var buf: array [0..((cuthalf * 2) - 1)] of integer; // рабочий буффер, заменяет 
                                                        // матрицу, представленную
                                                        // в описании
     
    function min3(a, b, c: integer): integer; // вспомогательная функция
    begin
      Result := a;
      if b < Result then Result := b;
      if c < Result then Result := c;
    end;
     
    // реализация функции в принципе соответствует описанию с одной оговоркой:
    // матрица из описания заменена статическим буффером, длина которого 
    // равна удвоенной максимальной длине строк
    // это сделано для 1) экономии памяти и во избежание её перераспределений
    // 2) повышения быстродействия (у меня функция работает 
    // в обработчике onfilterRecord)
    // таким образом, в реализации половинами буффера представлены только 
    // две последние строки матрицы, которые меняются местами каждую 
    // итерацию внешнего цикла (по i)... для определения того, какая из половин 
    // буффера является "нижней строкой", служит переменная flip
    // т. е. при flip = false первая половина буффера является предпоследней
    // строкой, а вторая - последней; при flip = true наоборот, 
    // первая половина - последняя строка, вторая половина - предпоследняя
     
    function LeveDist(s, t: string): integer; 
    var i, j, m, n: integer;
        cost: integer;
        flip: boolean; 
    begin
      s := copy(s, 1, cuthalf - 1);
      t := copy(t, 1, cuthalf - 1);
      m := length(s);
      n := length(t);
      if m = 0 then Result := n
      else if n = 0 then Result := m
      else begin
        flip := false;
        for i := 0 to n do buf[i] := i;
        for i := 1 to m do begin
          if flip then buf[0] := i
          else buf[cuthalf] := i;
          for j := 1 to n do begin
            if s[i] = t[j] then cost := 0
            else cost := 1;
            if flip then
              buf[j] := min3((buf[cuthalf + j] + 1), 
                             (buf[j - 1] + 1), 
                             (buf[cuthalf + j - 1] + cost))
            else
              buf[cuthalf + j] := min3((buf[j] + 1), 
                                       (buf[cuthalf + j - 1] + 1), 
                                       (buf[j - 1] + cost));
          end;
          flip := not flip;
        end;
        if flip then Result := buf[cuthalf + n]
        else Result := buf[n];
      end;
    end; 

Пример использования:

    // на форме имеются поля Edit1 и Edit2, метка Label1
    .....
    Label1.Caption := IntToStr(LeveDist(Edit1.Text, Edit2.Text));
    ..... 
