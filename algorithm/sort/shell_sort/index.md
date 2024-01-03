---
Title: Сортировка методом Шелла
Date: 01.01.2007
---


Сортировка методом Шелла
========================

::: {.date}
01.01.2007
:::

    { **** UBPFD *********** by kladovka.net.ru ****
    >> Быстрый алгоритм сортировки больших массивов
     
    Сортировка вариантного массива методом Шелла.
     
    Зависимости: Variants
    Автор:       Delirium, Master_BRAIN@beep.ru, ICQ:118395746, Москва
    Copyright:   Delirium (Master BRAIN)
    Дата:        4 июня 2002 г.
    ********************************************** }
     
    procedure Sorting(Down:boolean;var Data:Variant);
    Var Skach,m,n:integer;
        St:boolean;
        Tmp:Variant;
    begin
    Skach:=VarArrayHighBound(Data,1)-1;
    While Skach>0 do
     begin
     Skach:=Skach div 2;
     repeat
      St:=True;
      for m:=0 to VarArrayHighBound(Data,1)-1-Skach do
       begin
       n:=m+Skach;
       if ( Down and (Data[n]<Data[m]) )
       or ( (not Down) and (Data[n]>Data[m]) ) then
        begin
        Tmp:=Data[m];
        Data[m]:=Data[n];
        Data[n]:=Tmp;
        St:=False;
        end;
       end;
      until St;
     end;
    end; 

Пример использования:

    procedure TForm1.Button1Click(Sender: TObject);
    var A:Variant;
        i:integer;
    begin
    A:=VarArrayCreate([0, Memo1.Lines.Count-1], varVariant);
    for i:=0 to Memo1.Lines.Count-1 do A[i]:=Memo1.Lines.Strings[i];
    Sorting(True,A);
    for i:=0 to Memo1.Lines.Count-1 do Memo1.Lines.Strings[i]:=A[i];
    end; 

------------------------------------------------------------------------

    { **** UBPFD *********** by kladovka.net.ru ****
    >> Сортировка различными методами
     
    Сортировка одномерного массива значений типа Double методами:
    4) Сортировка Шелла (ShellSort);
     
    Зависимости: Math
    Автор:       iZEN, izen@mail.ru
    Copyright:   адаптация для Delphi
    Дата:        14 сентября 2004 г.
    ********************************************** }
     
    { Сортировка ShellSort }
    procedure ShellSort(var data: array of double);
    var
      lo, hi, i, j, incr: Integer;
      t: double;
    begin
      lo := Low(data);//минимальный индекс массива
      hi := High(data);//максимальный индекс массива
      incr := hi div 2; // начальный инкремент
      while (incr > lo)
      do begin
         i := incr;
         while (i <= hi)
         do begin // Внутренний цикл простых вставок
            j := i - incr;
            while (j > lo - 1)
            do if (data[j] > data[j+incr])
               then begin
                    t := data[j];
                    data[j] := data[j+incr];
                    data[j+incr] := t;
                    j := j - incr;
                    end
               else j := lo - 1;//Останов
            Inc(i);
            end;
         incr := incr div 2;
         end;
    end;

------------------------------------------------------------------------

Соpтиpовка Шелла. Это еще одна модификация пyзыpьковой соpтиpовки.
Сyть ее состоит в том, что здесь выполняется сpавнение ключей, отстоящих
один от дpyгого на некотоpом pасстоянии d. Исходный pазмеp d обычно
выбиpается соизмеpимым с половиной общего pазмеpа соpтиpyемой
последовательности. Выполняется пyзыpьковая соpтиpовка с интеpвалом
сpавнения d. Затем величина d yменьшается вдвое и вновь выполняется
пyзыpьковая соpтиpовка, далее d yменьшается еще вдвое и т.д. Последняя
пyзыpьковая соpтиpовка выполняется пpи d=1. Качественный поpядок
соpтиpовки Шелла остается O(N^2), сpеднее же число сpавнений,
опpеделенное эмпиpическим пyтем - log2(N)^2*N.
Ускоpение достигается
за счет того, что выявленные "не на месте" элементы пpи d\>1,
быстpее "всплывают" на свои места.

Пpимеp иллюстpиpyет соpтиpовкy Шелла.

    {===== Пpогpаммный пpимеp =====}
     { Соpтиpовка Шелла }
     Procedure Sort( var a : seq);
     Var d, i, t : integer;
        k : boolean; { пpизнак пеpестановки }
       begin
       d:=N div 2;  { начальное значение интеpвала }
     
       while d>0 do begin { цикл с yменьшением интеpвала до 1 }
     
         { пyзыpьковая соpтиpовка с интеpвалом d }
         k:=true;
         while k do begin  { цикл, пока есть пеpестановки }
           k:=false; i:=1;
           for i:=1 to N-d do begin
             { сpавнение эл-тов на интеpвале d }
             if a[i]>a[i+d] then begin
               t:=a[i]; a[i]:=a[i+d]; a[i+d]:=t; { пеpестановка }
               k:=true;  { пpизнак пеpестановки }
               end; { if ... }
             end; { for ... }
           end; { while k }
         d:=d div 2;  { yменьшение интеpвала }
         end;  { while d>0 }
     end;

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

------------------------------------------------------------------------

    { 
     The following procedure sorts an Array with the 
     fast Shell-Sort algorithm. 
     Invented by Donald Shell in 1959, 
     the shell sort is the most efficient of the O(n2) 
     class of sorting algorithms 
    }
     
     
     Procedure Sort_Shell(var a: array of Word);
     var
       bis, i, j, k: LongInt;
       h: Word;
     begin
       bis := High(a);
       k := bis shr 1;// div 2 
      while k > 0 do
       begin
         for i := 0 to bis - k do
         begin
           j := i;
           while (j >= 0) and (a[j] > a[j + k]) do
           begin
             h := a[j];
             a[j] := a[j + k];
             a[j + k] := h;
             if j > k then
               Dec(j, k)
             else
               j := 0;
           end; // {end while] 
        end; // { end for} 
        k := k shr 1; // div 2 
      end;  // {end while} 
     
    end;
     

Взято с сайта: <https://www.swissdelphicenter.ch>
