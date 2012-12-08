---
Title: Шифрование текстовых полей таблицы InterBase
Author: Vemer
Date: 01.01.2007
---


Шифрование текстовых полей таблицы InterBase
============================================

::: {.date}
01.01.2007
:::

Автор: Vemer

WEB-сайт: http://delphibase.endimus.com

    { **** UBPFD *********** by delphibase.endimus.com ****
    >> Шифрование текстовых полей таблицы Interbase
     
    Простенько но шустро шифрует текстовую строку VarChar в текстовую
    строку VarChar, пригодную для сохранения в текстовом поле базы Interbase.
    НЕ ЗАТРАГИВАЕТ ПРОБЕЛЫ!
    Метод генерации (в начале) и изменения ключа (в 2-местах!) в вашей программе
    лучше изменить от исходного в сторону усложнения, но не трогать "And 127" в конце.
    Для работы с Char возможно стоит добавить "Trim(S1);" в самое начало.
     
    Зависимости: Windows, SysUtils, DB
    Автор:       Vemer, Vemer@List.Ru, Петрозаводск
    Copyright:   Vemer
    Дата:        16 ноября 2003 г.
    ***************************************************** }
     
    function Morf(S1: string; T: Boolean): string;
    var
      LS: Byte; //длина строки
      KB: Byte; //ключ, байт
      I: Byte; //Счетчик
      B: Byte; //байт строки
      W: Smallint; //буфер для ключа
      S2: string; //результат
    begin
      LS := Length(S1);
      S2 := '';
      KB := LS * LS; //-------Изменить/Усложнить!And 127 не трогать!
      if T = False then // Выбор между шифрованием и дешифрованием
      begin
        for I := 1 to LS do
        begin //шифрование
          B := Byte(S1[I]);
          if B > 32 then
          begin
            W := B + KB;
            if W > 255 then
              W := W - 223;
            B := W;
          end; //If
          S2 := S2 + Chr(B);
          KB := (KB + (I * 2)) and 127;
          //-(1) Изменить/Усложнить! And 127 не трогать!
        end; //For
      end
      else
      begin //дешифровка
        for I := 1 to LS do
        begin
          B := Byte(S1[I]);
          if B > 32 then
          begin
            W := B - KB;
            if W < 33 then
              W := W + 223;
            B := W;
          end; //If
          S2 := S2 + Chr(B);
          KB := (KB + (I * 2)) and 127;
          //---(2) Сделать как в (1)! And 127 не трогать!
        end; //For
      end; //Else
     
      Result := S2;
    end;
    Пример использования: 
     
    // В вычисляемом поле для отображения текста в нормальном виде:
    TableNewName.Value := Morf(TableName.Value, True);
     
    // Для занесения в таблицу в зашифрованном виде например из Edit:
    TableName.Value := Morf(Edit.Text, False);
