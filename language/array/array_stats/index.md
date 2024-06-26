---
Title: Поиск минимального (максимального) элемента массива, статистика элементов массива
Author: Vit
Date: 01.01.2007
---


Поиск минимального (максимального) элемента массива, статистика элементов массива
=================================================================================

Задачу поиска минимального элемента массива рассмотрим на примере
массива целых чисел.

Алгоритм поиска минимального (максимального) элемента массива довольно
очевиден: сначала делается предположение, что первый элемент массива
является минимальным (максимальным), затем остальные элементы массива
последовательно сравниваются с этим элементом. Если во время очередной
проверки обнаруживается, что проверяемый элемент меньше (больше)
принятого за минимальный (максимальный), то этот элемент становится
минимальным (максимальным) и продолжается проверка оставшихся элементов.

Диалоговое окно приложения поиска минимального элемента массива содержит
соответствующим образом настроенный компонент stringGridi, который
применяется для ввода элементов массива, два поля меток (Label1 и
Labeia), использующиеся для вывода информационного сообщения и
результата работы программы, и командную кнопку (Buttonl), при щелчке на
которой выполняется поиск минимального элемента массива. В табл. 5.4
приведены значения свойств компонента stringGridi.

Свойство                  |Значение
--------------------------|--------
ColCount                  |005
FixedCols                 |000
RowCount                  |001
DefaultRowHeight          |024
Height                    |024
DefaultColWidth           |064
Width                     |328
Options.goEditing         |True
Options.AlwaysShowEditing |True
Options.goTabs            |True

В листинге 5.6 приведена процедура обработки события Onclick для
командной кнопки Button1, которая вводит массив, выполняет поиск
мини-мального элемента и выводит результат - номер и значение
минимального элемента массива.

Листинг 5.6. Поиск минимального элемента массива

    unit lookmin_;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics,
      Controls, Forms, Dialogs, StdCtrls, Grids;
     
    type
      TForm1 = class(TForm)
        Label1: TLabel;
        Button1: TButton;
        Label2: TLabel;
        StringGridl: TStringGrid;
        procedure ButtonlClick(Sender: TObject);
      private
        { Private declarations }
      public
        { Public declarations }
      end;
     
    var
      Form1: TForm1;
     
    implementation
    {$R *.DFM}
     
     
    procedure TForm1.ButtonlClick(Sender: TObject);
    const
      SIZE = 5;
    var
      a: array[l..SIZE] of integer; // массив целых
      min: integer; // номер минимального элемента массива
      i: integer; // номер элемента, сравниваемого с минимальным
    begin
      // ввод массива for i:=1 to SIZE do
      a[i] := StrToInt(StringGridl.Cells[i - 1, 0]);
      // поиск минимального элемента
      min := 1; // пусть первый элемент минимальный
      for i := 2 to SIZE do
        if a[i] < a[min] then
          min := i;
      // вывод результата
      label2.caption := 'Минимальный элемент массива:'
        + IntToStr(a[min] + #13 + 'Номер элемента:' + IntToStr(min);
    end;
     
    end.

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

 

 

------------------------------------------------------------------------

**Примечание от Vit**

боюсь что код приведенный выше представляет интерес для студентов и тех
кто изучает алгоритмы програмирования, для тех же кто занимается
практической деятельностью изобретать велосипед нет смысла, всё уже
сделано до нас, осталосьт заглянуть в модуль Math от Delphi и найти в
нём функции нахождения требуемых величин:

    +---------------------------+-----------------------------------+
    | Функция модуля Math       | Описание                          |
    +---------------------------+-----------------------------------+
    | MaxIntValue               | Returns the largest signed value  |
    |                           | in an integer array               |
    +---------------------------+-----------------------------------+
    | MaxValue                  | Returns the largest signed value  |
    |                           | in an array                       |
    +---------------------------+-----------------------------------+
    | Mean                      | Returns the average of all values |
    |                           | in an array                       |
    +---------------------------+-----------------------------------+
    | MeanAndStdDev             | Calculates the mean and standard  |
    |                           | deviation of array elements       |
    +---------------------------+-----------------------------------+
    | MinIntValue               | Returns the smallest signed value |
    |                           | in an integer array               |
    +---------------------------+-----------------------------------+
    | MinValue                  | Returns smallest signed value in  |
    |                           | an array                          |
    +---------------------------+-----------------------------------+
    | MomentSkewKurtosis        | Calculates the mean, variance,    |
    |                           | skew, and kurtosis                |
    +---------------------------+-----------------------------------+
    | Norm                      | Returns the Euclidean \'L-2\'     |
    |                           | norm.                             |
    +---------------------------+-----------------------------------+
    | PopnStdDev                | Calculates the population         |
    |                           | standard deviation                |
    +---------------------------+-----------------------------------+
    | PopnVariance              | Calculates the population         |
    |                           | variance                          |
    +---------------------------+-----------------------------------+
    | StdDev                    | Returns the sample standard       |
    |                           | deviation for elements in an      |
    |                           | array.                            |
    +---------------------------+-----------------------------------+
    | Sum                       | Returns the sum of the elements   |
    |                           | in an array.                      |
    +---------------------------+-----------------------------------+
    | SumInt                    | Returns the sum of the elements   |
    |                           | in an integer array.              |
    +---------------------------+-----------------------------------+
    | SumOfSquares              | Returns the sum of the squared    |
    |                           | values from a data array.         |
    +---------------------------+-----------------------------------+
    | SumsAndSquares            | Returns the sum of the values and |
    |                           | the sum of the squared values in  |
    |                           | an array.                         |
    +---------------------------+-----------------------------------+
    | TotalVariance             | Returns the statistical variance  |
    |                           | from an array of values.          |
    +---------------------------+-----------------------------------+
    | Variance                  | Calculates statistical sample     |
    |                           | variance from an array of data.   |
    +---------------------------+-----------------------------------+

Впрочем, тем, кто изучает алгоритмику, неплохо было бы взглянуть на
исходники этого модуля Math, где и найти реализацию приведенных функций.

