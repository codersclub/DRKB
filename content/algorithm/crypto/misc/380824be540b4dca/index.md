---
Title: Повышение криптоустойчивости шифрования текста любым алгоритмом
Date: 01.01.2007
---


Повышение криптоустойчивости шифрования текста любым алгоритмом
===============================================================

::: {.date}
01.01.2007
:::

    { **** UBPFD *********** by kladovka.net.ru ****
    >> Повышение криптоустойчивости шифрования текста любым алгоритмом
     
    Данная функция (AddDisturbToText) представляет собой подготовительную 
    операцию перед шифрацией текста любым алгоритмом. Функция 
    добавляет в текст случайное количество непечатных символов, 
    располагая их хаотически. Таким образом подготовленный текст, 
    после шифрации одним и тем-же ключом, не зависимо от алгоритма, 
    каждый раз будет выглядеть по разному и количественно и качественно, 
    что практически сводит на нет любой статистический анализ. При 
    расшифровке, непечатные символы элементарно вычищаются функцией 
    RemoveDisturbFromText.
     
    Зависимости: SysUtils
    Автор:       Delirium, VideoDVD@hotmail.com, ICQ:118395746
    Copyright:   Delirium (Master BRAIN) 2004
    Дата:        28 февраля 2004 г.
    ********************************************** }
     
    const
     NPCS:set of char = [ #0..#8, #11, #12, #14..#31, #127];
     
    // Добавление в текст непечатных символов
    function AddDisturbToText(Source:String):String;
    var n, c:integer;
    begin
    Randomize;
    Result:=Source;
    n:=(Length(Source)*2)+Random(Length(Source));
    while Length(Result)<n
    do
     begin
     c:=Random(128);
     if Chr(c) in NPCS
     then Insert(Chr(c), Result, Random(Length(Result))+1)
     end;
    end;
     
    // Убрать из текста непечатные символы
    function RemoveDisturbFromText(Source:String):String;
    var i:integer;
    begin
    Result:=Source;
    i:=1;
    while i<Length(Result)
    do if Result[i] in NPCS
       then Delete(Result, i, 1)
       else Inc(i);
    end;
