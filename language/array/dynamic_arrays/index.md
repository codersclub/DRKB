---
Title: Примеры работы с динамическими массивами
Author: Даниил Карапетян (delphi4all@narod.ru)
Date: 01.01.2007
---


Примеры работы с динамическими массивами
========================================

Вариант 1:

Очень простой пример...

    const
      MaxBooleans = (High(Cardinal) - $F) div sizeof(boolean);
     
    type
      TBoolArray = array[1..MaxBooleans] of boolean;
      PBoolArray = ^TBoolArray;
     
    var
      B: PBoolArray;
      N: integer;
     
    begin
      N := 63579;
    {= получение памяти под динамический массив.. =}
      GetMem(B, N * sizeof(boolean));
    {= работа с массивом... =}
      B^[3477] := FALSE;
    {= возвращение памяти в кучу =}
    {$IFDEF VER80}
      FreeMem(B, N * sizeof(boolean));
    {$ELSE}
      FreeMem(B);
    {$ENDIF}
    end.

------------------------------------------------------------------------

Вариант 2:

> Возможно создавать динамически-изменяющиеся массивы в Delphi?

Да. Для начала вам необходимо создать тип массива, использующего самый
большой размер, который вам, вероятно, может понадобиться. В
действительности, при создании типа никакой памяти не распределяется.
Вот когда вы создаете переменную этого типа, тогда компилятор пытается
распределить для вас необходимую память. Вместо этого создайте
переменную, являющуюся указателем на этот тип. Этим вы заставите
компилятор распределить лишь четыре байта, необходимые для размещения
указателя.

Прежде, чем вы сможете пользоваться массивом, вам необходимо
распределить для него память. Используя AllocMem, вы можете точно
управлять выделяемым размером памяти. Для того, чтобы определить
необходимое количество байт, которые вы должны распределить, просто
умножьте размер массива на размер отдельного элемента массива. Имейте в
виду, что самый большой блок, который вы сможете распределить в любой
момент в 16-битной среде равен 64Kб. Самый большой блок, который вы
можете в любой момент распределить в 32-битной среде равен 4Гб. Для
определения максимального числа элементов, которые вы можете иметь в
вашем конкретном массиве (в 16-битной среде), разделите 65,520 на размер
отдельного элемента. Например: 65520 div SizeOf(LongInt)

Пример объявления типа массива и указателя:

    type
      ElementType = LongInt;
     
    const
      MaxArraySize = (65520 div SizeOf(ElementType));
    (* в 16-битной среде *)
     
    type
      MyArrayType = array[1..MaxArraySize] of ElementType;
     
    var
      P: ^MyArrayType;
     
    const
      ArraySizeIWant: Integer = 1500;

Затем, для распределения памяти под массив, вы могли бы использоваться
следующую процедуру:

    procedure AllocateArray;
    begin
      if ArraySizeIWant <= MaxArraySize then
        P := AllocMem(ArraySizeIWant * SizeOf(LongInt));
    end;

Не забывайте о том, что величина ArraySizeIWant должна быть меньше или
равна MaxArraySize.

Вот процедура, которая с помощью цикла устанавливает величину каждого
члена:

    procedure AssignValues;
    var
      I: Integer;
    begin
      for I := 1 to ArraySizeIWant do
        P^[I] := I;
    end;

Имейте в виду, что вам необходимо самому организовать контроль
допустимого диапазона. Если вы распределили память для массива с пятью
элементами, и пытаетесь назначить какое-либо значение шестому, вы
получите ошибку и, возможно, порчу памяти.

Помните также о том, что после использования массива всю распределенную
память необходимо освободить. Вот пример того, как избавиться от этого
массива:

    procedure DeallocateArray;
    begin
      P := AllocMem(ArraySizeIWant * SizeOf(LongInt));
    end;

Ниже приведен пример динамического массива:

    unit Unit1;
     
    interface
     
    uses
      SysUtils, WinTypes, WinProcs, Messages, Classes, Graphics,
      Controls, Forms, Dialogs, StdCtrls;
     
    type
      ElementType = Integer;
     
    const
      MaxArraySize = (65520 div SizeOf(ElementType));
    { в 16-битной среде }
     
    type
    { Создаем тип массива. Убедитесь в том, что вы установили
    максимальный диапазон, который вам, вероятно, может понадобиться. }
      TDynamicArray = array[1..MaxArraySize] of ElementType;
      TForm1 = class(TForm)
        Button1: TButton;
        procedure FormCreate(Sender: TObject);
        procedure Button1Click(Sender: TObject);
        procedure FormDestroy(Sender: TObject);
      private
    { Private declarations }
      public
    { Public declarations }
      end;
     
    var
      Form1: TForm1;
    { Создаем переменную типа указатель на ваш тип массива. }
      P: ^TDynamicArray;
     
    const
    { Это типизированные константы. В действительности они
    являются статическими переменными, инициализирующимися
    во время выполнения указанными в исходном коде значениями.
    Это означает, что вы можете использовать типизированные
    константы точно также, как и любые другие переменные.
    Удобство заключается в автоматически инициализируемой величине. }
      DynamicArraySizeNeeded: Integer = 10;
     
    implementation
     
    {$R *.DFM}
     
    procedure TForm1.FormCreate(Sender: TObject);
    begin
    { Распределяем память для нашего массива. Будь внимательны
    и распределяйте размер, в точности необходимый для размещения нового массива.
    Если вы попытаетесь записать элемент, выходящий за допустимый диапазон,
    компилятор не ругнется, но объект исключения вам обеспечен. }
      DynamicArraySizeNeeded := 500;
      P := AllocMem(DynamicArraySizeNeeded * SizeOf(Integer));
    { Как присвоить значение пятому элементу массива. }
      P^[5] := 68;
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
    { Вывод данных. }
      Button1.Caption := IntToStr(P^[5]);
    end;
     
    procedure TForm1.FormDestroy(Sender: TObject);
    begin
    { Освобождаем распределенную для массива память. }
      FreeMem(P, DynamicArraySizeNeeded * SizeOf(Integer));
    end;
     
    end.

------------------------------------------------------------------------

Вариант 3:

Source: Советы по Delphi от [Валентина Озерова](mailto:webmaster@webinspector.com) Сборник Kuliba

Вот "демо-модуль", демонстрирующий три различных способа (далеко не
все) создания динамических массивов. Все три способа для распределения
достаточного количества памяти из кучи используют GetMem, tList
используют для добавления элементов в список массива и используют
tMemoryStream для того, чтобы распределить достаточно памяти из кучи и
иметь к ней доступ, используя поток. Старый добрый GetMem вполне
подходит для такой задачи при условии, что массив не слишком велик
(\<64K).

PS. Я не стал ловить в коде исключения (с помощью блоков
Try...Finally}, которые могли бы мне помочь выявить ошибки, связанные с
распределением памяти. В реальной системе вы должны быть уверены в своем
грациозном владении низкоуровневыми операциями с памятью.

    {++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++}
    { Форма, демонстрирующая различные методы создания массива с         }
    { динамически изменяемым размером. Разместите на форме четыре кнопки,}
    { компоненты ListBox и SpinEdit и создайте, как показано ниже,       }
    { обработчики событий, возникающие при нажатии на кнопки. Button1,   }
    { Button2 и Button3 демонстрируют вышеуказанных метода. Button4      }
    { очищает ListBox для следующего примера.                            }
    {++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++}
    unit Dynarry1;
     
    interface
     
    uses
      SysUtils, WinTypes, WinProcs, Messages, Classes, Graphics, Controls,
      Forms, Dialogs, StdCtrls, Spin;
     
    type
      TForm1 = class(TForm)
        Button1: TButton;
        Button2: TButton;
        Button3: TButton;
        SpinEdit1: TSpinEdit;
        ListBox1: TListBox;
        Button4: TButton;
        procedure Button1Click(Sender: TObject);
        procedure Button2Click(Sender: TObject);
        procedure Button3Click(Sender: TObject);
        procedure Button4Click(Sender: TObject);
      private
    { Private declarations }
      public
    { Public declarations }
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.DFM}
    type
      pSomeType = ^SomeType;
      SomeType = Integer;
     
    procedure TForm1.Button1Click(Sender: TObject);
    type
      pDynArray = ^tDynArray;
      tDynArray = array[1..1000] of SomeType;
    var
      DynArray: pDynArray;
      I: Integer;
    begin
    { Распределяем память }
      GetMem(DynArray, SizeOf(SomeType) * SpinEdit1.Value);
    { Пишем данные в массив }
      for I := 1 to SpinEdit1.Value do
        DynArray^[I] := I;
    { Читаем данные из массива }
      for I := SpinEdit1.Value downto 1 do
        ListBox1.Items.Add('Элемент ' + IntToStr(DynArray^[I]));
    { Освобождаем память }
      FreeMem(DynArray, SizeOf(SomeType) * SpinEdit1.Value);
    end;
     
     
    procedure TForm1.Button2Click(Sender: TObject);
    var
      List: tList;
      Item: pSomeType;
      I: Integer;
    begin
    { Создаем список }
      List := tList.Create;
    { Пишем данные для списка }
      for I := 1 to SpinEdit1.Value do
        begin
    { Распределяем уникальный экземпляр данных }
          New(Item); Item^ := I;
          List.Add(Item);
        end;
    { Читаем данные из списка - базовый индекс списка 0, поэтому вычитаем из I единицу }
      for I := SpinEdit1.Value downto 1 do
        ListBox1.Items.Add('Элемент ' +
          IntToStr(pSomeType(List.Items[I - 1])^));
    { Освобождаем лист }
      for I := 1 to SpinEdit1.Value do
        Dispose(List.Items[I - 1]);
      List.Free;
    end;
     
     
    procedure TForm1.Button3Click(Sender: TObject);
    var
      Stream: tMemoryStream;
      Item: SomeType;
      I: Integer;
    begin
    { Распределяем память потока }
      Stream := tMemoryStream.Create;
      Stream.SetSize(SpinEdit1.Value);
    { Пишем данные в поток }
      for I := 1 to SpinEdit1.Value do
    { Stream.Write автоматически отслеживает позицию записи,
    поэтому при записи данных за ней следить не нужно }
        Stream.Write(I, SizeOf(SomeType));
    { Читаем данные из потока }
      for I := SpinEdit1.Value downto 1 do
        begin
          Stream.Seek((I - 1) * SizeOf(SomeType), 0);
          Stream.Read(Item, SizeOf(SomeType));
          ListBox1.Items.Add('Элемент ' + IntToStr(Item));
        end;
    { Освобождаем поток }
      Stream.Free;
    end;
     
     
    procedure TForm1.Button4Click(Sender: TObject);
    begin
      ListBox1.Items.Clear;
    end;
     
     
    end.


------------------------------------------------------------------------

Вариант 4:

Author: Даниил Карапетян (delphi4all@narod.ru)

Автор справки: Алексей Денисов (aleksey@sch103.krasnoyarsk.su)

Массив, который может менять свой размер во время работы программы,
нужен тогда, когда неизвестно количество элементов на стадии разработки
программы. Например, Вам не известен размер изображения, которое нужно
будет поместить в память.

Этот динамический массив основан на массиве Delphi. Поэтому обращение к
нему быстро и удобно. Тип TArray - это массив нужного типа. 128
элементов можно заменить любым другим числом, хоть 0. Повлиять это может
только на отладку программы, так как Delphi выведет (если уместится)
именно это количество элементов. PArray - это указатель на TArray. При
обращении к элементам массива для Delphi главное, чтобы этот элемент
существовал в памяти, то есть, чтобы под него была выделена память. А
проверять, находится ли номер нужного элемента между 0 и 127 Delphi не
будет.

Главным методом объекта является SetCount. Он сделан таким образом, что
при изменении количество элементом старые данные не теряются, а новые
элементы всегда обнуляются. Процедура Reset обнуляет все существующие
элементы. Для того чтобы сделать этот массив, например, массивом целых
чисел нужно поменять все double на integer или еще что-то.

Если Ваша программа часто обращается к элементам массива, то имеет смысл
создать переменную типа PArray и присвоить ей адрес данных (поле p
динамического массива), а дальше обращаться к ней, как к самому
обыкновенному массиву. Только не забудьте обновлять эту переменную при
изменении количества элементов.

    type
      TForm1 = ...
        ...
      end;
     
      TArray = array [0..127] of double;
      PArray = ^TArray;
      TDynArray = object
        p: PArray;
        count: integer;
        constructor Create(ACount: integer); { инициализация }
        procedure SetCount(ACount: integer); { установка количества
                                               элементов }
        procedure Reset; { обнуление данных }
     
        destructor Destroy; { уничтожение }
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.DFM}
     
    constructor TDynArray.Create(aCount: integer);
    begin
      p := nil;
      count := 0;
      SetCount(ACount);
    end;
     
    procedure TDynArray.SetCount(ACount: integer);
    var
      np: PArray;
    begin
      if count = ACount then Exit;
      if p = nil then begin { память не была выделена }
     
        if ACount <= 0 then begin { новое количество элементов
                                    в массиве равно 0 }
          count := 0;
        end else begin  { новое количество элементов в массиве
                          больше 0 }
          GetMem(p, ACount * sizeof(double)); { выделение памяти }
          fillchar(p^, ACount * sizeof(double), 0); { обнуление данных }
          count := ACount;
     
        end;
      end else begin
        if ACount <= 0 then begin { новое количество элементов в
                                    массиве равно 0 }
          FreeMem(p, count * sizeof(double)); { освобождение памяти }
          count := 0;
        end else begin
          GetMem(np, ACount * sizeof(double)); { выделение памяти }
     
          if ACount > count then begin { требуется увеличить
                                         количество элементов }
            move(p^, np^, count * sizeof(double)); { перемещение
                                    старых данных на новое место }
            fillchar(np^[count], (ACount - count) * sizeof(double),
              0); { обнуление новых элементов массива }
          end else begin
     
            move(p^, np^, ACount * sizeof(double)); { перемещение 
                               части старых данных на новое место }
          end;
          FreeMem(p, count * sizeof(double)); { освобождение старой
                                                памяти }
          p := np;
          count := ACount;
        end;
      end;
    end;
     
    procedure TDynArray.Reset;
    begin
      fillchar(p^, count * sizeof(double), 0); { обнуление данных }
     
    end;
     
    destructor TDynArray.Destroy;
    begin
      SetCount(0);
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    var
      a: TDynArray;
      i: integer;
      s: string;
    begin
      a.Create(3);
      a.p[0] := 10;
      a.p[1] := 20;
      { второй элемент не указывается, но вследствии обнуления
        при создании массива он равен 0 }
      s := 'Элементы в массиве:';
      for i := 0 to a.count - 1 do
     
        s := s + #13#10 + IntToStr(i+1) + ': ' + FloatToStr(a.p[i]);
      ShowMessage(s);
     
      a.SetCount(4);
      a.p^[3] := 50;
      { значения первых элементов не теряются }
      s := 'Элементы в массиве:';
      for i := 0 to a.count - 1 do
        s := s + #13#10 + IntToStr(i+1) + ': ' + FloatToStr(a.p[i]);
      ShowMessage(s);
     
      a.Destroy;
    end;

------------------------------------------------------------------------

Вариант 5:

Author: Виталий

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

Я хочу написать об использовании динамических массивов. Для того чтобы с
ними работать можно использовать два вида объявлния в типах

    type
      DAr = array of real;
    var
      A: DAr;

или сразу

    var A:array of real; 

Таким образом мы объяыили ссылку на область памяти. Для того чтобы
указать размер воспользуемся процедурой SetLength, ее можно использовать
в любых местах и определять размера массива тот, который необходим в
данную минуту.

    SetLength(A,7)

Так мы создали массив состоящий из 7 элементов начиная с 0. Важно!
Первый элемент в динамическом массиве всегда нулевой. Для определения
верхний границы используем функцию Hihg

    I:=High(A);

I - верхняя граница. Для определения длины Length(A), для определения
нижней границы Low(A). При нулевой длине массива High, возращает -1.
Пример:

    var
      a,b: array of integer;
    begin
      SetLength(a,2);
      SetLength(b,2);
      a[0]:=2;
      b[0]:=3;
      a:=b;
      b[0]:=4;
    end;

После этих манипуляций а[0] равно 4. Дело в том при присвоении a:=b не
происходит копирование т.к. а, b, это всего лишь указатели на область
памяти. Для копирования необходимо использовать функцию Copy.

Я надеюсь что это кому-нибудь поможет в работе.

Всего наилучшего. Виталий

P.S. Не советую изменять длину массивов в DLL, у меня при этом возникала
ошибка Acess violation побороть ее мне так и не удалось.


------------------------------------------------------------------------

Вариант 6:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

Иногда разработчик, работая с массивами, не знает какого размера массив
ему нужен. Тогда Вам пригодится использование динамических массивов.

    var
      intArray : array of integer;

При таком объявлении размер массива не указывается. Что бы использовать
его дальше необходимо определить его размер (обратите внимание, что
размер динамического массива можно устанавливать в программе):

    begin
      intArray:=(New(IntArray,100); //Размер массива? 100
    end;


------------------------------------------------------------------------

Вариант 7:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

**Создать динамический массив**

Массив, который может менять свой размер во время работы программы,
нужен тогда, когда неизвестно количество элементов на стадии разработки
программы. Например, Вам не известен размер изображения, которое нужно
будет поместить в память.

Этот динамический массив основан на массиве Delphi. Поэтому обращение к
нему быстро и удобно. Тип TArray - это массив нужного типа. 128
элементов можно заменить любым другим числом, хоть 0. Повлиять это может
только на отладку программы, так как Delphi выведет (если уместится)
именно это количество элементов. PArray - это указатель на TArray. При
обращении к элементам массива для Delphi главное, чтобы этот элемент
существовал в памяти, то есть, чтобы под него была выделена память. А
проверять, находится ли номер нужного элемента между 0 и 127 Delphi не
будет.

Главным методом объекта является SetCount. Он сделан таким образом, что
при изменении количество элементом старые данные не теряются, а новые
элементы всегда обнуляются.

Процедура Reset обнуляет все существующие элементы.

Для того чтобы сделать этот массив, например, массивом целых чисел нужно
поменять все double на integer или еще что-то.

Если Ваша программа часто обращается к элементам массива, то имеет смысл
создать переменную типа PArray и присвоить ей адрес данных (поле p
динамического массива), а дальше обращаться к ней, как к самому
обыкновенному массиву. Только не забудьте обновлять эту переменную при
изменении количества элементов.

    type
    TForm1 = ...
    ...
    end;
     
      TArray = array [0..127] of double;
      PArray = ^TArray;
      TDynArray = object
      p: PArray;
      count: integer;
      constructor Create(ACount: integer); { инициализация }
      procedure SetCount(ACount: integer); { установка количества элементов }
      procedure Reset; { обнуление данных }
      destructor Destroy; { уничтожение }
    end;
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.DFM}
     
    constructor TDynArray.Create(aCount: integer);
    begin
      p := nil;
      count := 0;
      SetCount(ACount);
    end;
     
    procedure TDynArray.SetCount(ACount: integer);
    var
      np: PArray;
    begin
      if count = ACount then
      Exit;
      { память не была выделена }
      if p = nil then
      begin
        { новое количество элементов в массиве равно 0 }
        if ACount <= 0 then
        begin
          count := 0;
        end
        { новое количество элементов в массиве больше 0 }
        else
        begin
          { выделение памяти }
          GetMem(p, ACount * sizeof(double));
          { обнуление данных }
          fillchar(p^, ACount * sizeof(double), 0);
          count := ACount;
        end;
      end
      else
      begin
        { новое количество элементов в массиве равно 0 }
        if ACount <= 0 then
        begin
          { освобождение памяти }
          FreeMem(p, count * sizeof(double));
          count := 0;
        end
        else
        begin
          { выделение памяти }
          GetMem(np, ACount * sizeof(double));
          { требуется увеличить количество элементов }
          if ACount > count then
          begin
            { перемещение старых данных на новое место }
            move(p^, np^, count * sizeof(double));
            { обнуление новых элементов массива }
            fillchar(np^[count], (ACount - count) * sizeof(double), 0);
          end
          else
          begin
            { перемещение части старых данных на новое место }
            move(p^, np^, ACount * sizeof(double));
          end;
          { освобождение старой памяти }
          FreeMem(p, count * sizeof(double));
          p := np;
          count := ACount;
        end;
      end;
    end;
     
    procedure TDynArray.Reset;
    begin
      { обнуление данных }
      fillchar(p^, count * sizeof(double), 0);
    end;
     
    destructor TDynArray.Destroy;
    begin
      SetCount(0);
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    var
      a: TDynArray;
      i: integer;
      s: string;
    begin
      a.Create(3);
      a.p[0] := 10;
      a.p[1] := 20;
      { второй элемент не указывается, но вследствие обнуления
      при создании массива он равен 0 }
      s := 'Элементы в массиве:';
      for i := 0 to a.count - 1 do
        s := s + #13#10 + IntToStr(i+1) + ': ' + FloatToStr(a.p[i]);
      ShowMessage(s);
     
      a.SetCount(4);
      a.p^[3] := 50;
      { значения первых элементов не теряются }
      s := 'Элементы в массиве:';
      for i := 0 to a.count - 1 do
        s := s + #13#10 + IntToStr(i+1) + ': ' + FloatToStr(a.p[i]);
      ShowMessage(s);
     
      a.Destroy;
    end;

