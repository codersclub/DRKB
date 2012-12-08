---
Title: Кодировка полиалфавитным шифром Вигeнера
Date: 01.01.2007
---


Кодировка полиалфавитным шифром Вигeнера
========================================

::: {.date}
01.01.2007
:::

    { **** UBPFD *********** by kladovka.net.ru ****
    >> Кодировка полиалфавитным шифром Вигeнера - xor кодировка
     
    Кодировка полиалфавитным шифром Вигeнера - xor кодировка
    одна функция для кодирования и декодирования
    Input - входная строка. При кодировании это незакодированная строка, при декодировнии это закодированная строка.
    Key - слово ключ один и тот же в обоих случаях.
     
    При совпадении символов во входной строке и строке ключе на выходе получается символ '#0'.
     
    Зависимости: Стандартные модули
    Автор:       Ru, DiVo_Ru@rambler.ru, Одесса
    Copyright:   DiVo 2002 creator Ru
    Дата:        18 ноября 2002 г.
    ********************************************** }
     
    function VigenerCoDec(Input,Key:pchar):pchar
    var
    i,j:integer;
    tmps,text:string;
    begin
     text:=Input;
     for i:=1 to length(text) do
     begin
      if i>length(key) then j:=i mod length(key) else j:=i;
      tmps:=tmps+chr((ord(text[i]))xor(ord(key[j])));
     end;
     result:=pchar(tmps);
    end; 

Пример использования:

    Text:=edit1.text;
    K:=edit2.text;
    Edit3.text:=VigenerCoDec(Text,K);
     
    Закодировать:
    Input:='Привет я РУ'; Key:='hello'; result:='ГуднйзHвH++';
    Восстановить:
    Input:='ГуднйзHвH++'; Key:='hello'; result:='Привет я РУ'; 
