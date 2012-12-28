---
Title: Упорядочивание случайных чисел
Date: 01.01.2007
---


Упорядочивание случайных чисел
==============================

::: {.date}
01.01.2007
:::

    { **** UBPFD *********** by kladovka.net.ru ****
    >> Упорядочивание случайных чисел
     
    Как то спросил я у товарищей мастеров: «Как можно научить 
    random не повторятся в определенном пределе?», ответ 
    был примерно таков (вернее два): «…сравнивать надо…», 
    «…кто сказал, что числа не должны повторятся…». Так, что 
    получается либо они не знают, как это сделать, либо на 
    самом деле это невозможно без сравнения.
     
    Тогда пришлось написать такую не большую "процедурку" 
    (см. ниже), заполнения массива случайными не повторяющимися числами. 
    Только здесь существует одно условие передаваемый в процедуру 
    массив должен быть таким, какой определен в процедуре или можно 
    написать две (или более) процедуры overload.
     
    Если кто не знает, как сделать тоже вот пользуйтесь.
     
    Зависимости: System, Windows
    Автор:       16xmax, 16xmax@rambler.ru, Самара
    Copyright:   Кошеленко Дмитрий т.е. Я
    Дата:        18 апреля 2004 г.
    ********************************************** }
     
    type
      SortDir = (SU, SD, US); // типы сортировок: SU – возрастающая, SD – убывающая, US без сортировки
     
        procedure rnd(arr: array of integer; sort: SortDir);
        label 1; // метка возврата для регенерации числа
     
        var
           i, j, l, m: integer; // необходимые переменные
     
        begin
          for i:=Low(arr) to High(arr) do // цикл от первого значения до последнего массива
              begin
                1: // метка возврата
                randomize; // холостой прогон генератора
                l:=random(High(arr)+1); // генерация числа от верхнего значения массива +1
                j:=Low(arr); // присвоение счетчику сравнения минимального значения массива
                if i=Low(arr) then //если счетчик цикла равен первому значению тогда
                   arr[i]:=l // просто вносим его в массив
                    else // иначе
                      while j<i do // пока счетчик сравнения меньше счетчика цикла выполняем
                            if l=arr[j] then // если сгенерированное число уже есть в массиве тогда
                               goto 1 // возвращаемся к метке возврата
                                else //иначе
                                  begin
                                    arr[i]:=l; // вносим число в массив
                                    inc(j); // увеличиваем счетчик сравнения на единицу
                                  end;
              end;
          if sort=SU then // если переменная сортировки равна: по возрастающей тогда
             for i:=Low(arr) to High(arr)-1 do // с первого значения до предпоследнего прогоняем массив
                 for j:=i+1 to High(arr) do // со второго значения до последнего прогоняем массив для сравнения и сортировки
                     begin
                       l:=arr[i]; //присваиваем значение первое
                       m:=arr[j]; // присваиваем значение второе
                       if l<m then begin arr[i]:=m; arr[j]:=l; end; // если первое меньше второго тогда меняем их местами
                     end;
          if sort=SD then // если переменная сортировки равна: по возрастающей тогда
             for i:=Low(arr) to High(arr)-1 do // с первого значения до предпоследнего прогоняем массив
                 for j:=i+1 to High(arr) do // со второго значения до последнего прогоняем массив для сравнения и сортировки
                     begin
                       l:=arr[i]; //присваиваем значение первое
                       m:=arr[j]; // присваиваем значение второе
                       if l>m then begin arr[i]:=m; arr[j]:=l; end; // если первое больше второго тогда меняем их местами
                     end;
        end; 

Пример использования:

     
    var
       c: array[0..255] of integer;
    ...
     
    begin
      rnd(c, su);
    ...
    end; 