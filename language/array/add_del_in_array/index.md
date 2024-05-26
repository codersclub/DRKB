---
Title: Удаление и добавление значений динамического массива
Author: http://sunsb.dax.ru
Date: 01.01.2007
---


Удаление и добавление значений динамического массива
====================================================

Вариант 1:

Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>

    type 
      TArrayString = array of string; 
     
    procedure DeleteArrayIndex(var X: TArrayString; Index: Integer); 
    begin 
      if Index > High(X) then Exit; 
      if Index < Low(X) then Exit; 
      if Index = High(X) then 
      begin 
        SetLength(X, Length(X) - 1); 
        Exit; 
      end; 
      Finalize(X[Index]); 
      System.Move(X[Index +1], X[Index], 
      (Length(X) - Index -1) * SizeOf(string) + 1); 
      SetLength(X, Length(X) - 1); 
    end; 
     
    // Example : Delete the second item from array a 
    // Beispiel : Losche das 2. Element vom array a 
     
    procedure TForm1.Button2Click(Sender: TObject); 
    var 
      a: TArrayString; 
    begin 
      DeleteArrayIndex(a, 2); 
    end; 


------------------------------------------------------------------------

Вариант 2:

Author: http://sunsb.dax.ru

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

Крутая штука динамический массив. Очень быстрая и здоровая реализация.
Единственное, чего на мой взгляд не хватает, это механизма удаления
элемента из середины массива и соответственно вставки в середину.
Насколько я понял ( и проверил ), в памяти массив хранится по-разному в
зависимости от типа его элементов. Скажм если в массиве строки
(!! не shortString ) - хранятся указатели на них, а если прямоугольники
(TRect) - то непосредственно сами прямоугольники.

Ниже привожу подпрограммы удаления и добавления элемента.

    procedure delElem( var A:TRectArray; Index:integer );
    var Last : integer;
    begin
       Last:= high( A );
       if Index <  Last then move( A[Index+1], A[ Index ],
           (Last-Index) * sizeof( A[Index] )  );
       setLength( A, Last );
    end;
     
    procedure addElem( var A: TRectArray; Index: integer;
                                           ANew: TRect );
    var Len : integer;
    begin
       Len:= Length( A );
       if Index > = Len then Index := Len+1;
       setLength( A, Len+1);
       move( A[Index], A[ Index+1 ],
             (Len-Index) * sizeof( A[Index] ));
       A[Index] := ANew;
    end;

Подпрограмма delElem полностью универсальна, а в addElem Вам нужно
поменять тип добовляемого елемента (ANew) на требуемый.



