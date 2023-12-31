---
Title: Использование многомерного массива
Author: Steve Schafer
Date: 01.01.2007
---


Использование многомерного массива
==================================

::: {.date}
01.01.2007
:::

    type RecType = integer; {<-- здесь задается тип элементов массива}
     
    const MaxRecItem = 65520 div sizeof(RecType);
     
    type = MyArrayType = array[0..MaxRecItem] of RecType;
    type = MyArrayTypePtr = ^MyArrayType;
     
    var MyArray: MyArrayTypePtr;
    begin
      ItemCnt := 10; {количество элементов массива, которые необходимо распределить}
      GetMem(MyArray, ItemCnt * sizeof(MyArray[1])); {распределение массива}
      MyArray^[3] := 10; {доступ к массиву}
      FreeMem(MyArray, ItemCnt * sizeof(MyArray[1])); {освобождаем массив после работы с ним}
    end;

Michael Day

Взято из Советов по Delphi от [Валентина Озерова](mailto:webmaster@webinspector.com)

Сборник Kuliba

------------------------------------------------------------------------
Вариант 2:

Автор: Steve Schafer

    type
      PRow = ^TRow;
      TRow = array[0..16379] of Single;
     
      PMat = ^TMat;
      TMat = array[0..16379] of PRow;
     
    var
      Mat: PMat;
      X, Y, Xmax, Ymax: Integer;
     
    begin
      Write('Задайте размер массива: ');
      ReadLn(Xmax, Ymax);
      if (Xmax <= 0) or (Xmax > 16380) or (Ymax <= 0) or (Ymax > 16380) then
      begin
        WriteLn('Неверный диапазон. Не могу продолжить.');
        Exit;
      end;
      GetMem(Mat, Xmax * SizeOf(PRow));
      for X := 0 to Xmax - 1 do
      begin
        GetMem(Mat[X], Ymax * SizeOf(Single));
        for Y := 0 to Ymax - 1 do
          Mat^[X]^[Y] := 0.0;
      end;
      WriteLn('Массив инициализирован и готов к работе.');
      WriteLn('Но эта программа закончила свою работу.');
    end.
     
     

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
