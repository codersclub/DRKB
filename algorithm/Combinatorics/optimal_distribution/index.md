---
Title: Алгоритм оптимального распределения камней по ящикам
Date: 04.03.2003
Author: Александр Шарахов, alsha@mailru.com
---


Алгоритм оптимального распределения камней по ящикам
====================================================

    { **** UBPFD *********** by kladovka.net.ru ****
    >> Алгоритм оптимального распределения камней по ящикам
     
    Зависимости: нет
    Автор:       Александр Шарахов, alsha@mailru.com, Москва
    Copyright:   Александр Шарахов
    Дата:        4 марта 2003 г.
    ********************************************** }
     
    {-------------------------------------------------------------------------------
     
                Алгоритм оптимального распределения камней по ящикам
     
                   (с) Александр Шарахов (alsha@mailru.com) 2002
     
    --------------------------------------------------------------------------------
     
      Разрешается использовать в некоммерческих продуктах и свободно распространять
    при условии сохранения исходного текста.
     
    --------------------------------------------------------------------------------
     
      Литература.
     
      Прототипом алгоритма послужила "Задача о куче камней", которую рассматривал
    И.В. Романовский в своей книге "Алгоритмы решения экстремальных задач", "Наука",
    М., 1977, с.248.
     
      Алгоритм существенно переработан и дополнен, исправлены найденные ошибки.
     
    --------------------------------------------------------------------------------
     
      Постановка задачи. Входные данные.
     
      Имеется StoneCount камней и BoxCount ящиков. Веса камней (целые положительные
    числа) заданы в массиве StonesArray[0..StoneCount-1]. Требуется распределить
    камни по ящикам так, чтобы вес самого тяжелого ящика был минимальным.
    Очевидно, частным случаем является задача обеспечения равенства веса всех ящиков.
     
      Возможны 2 варианта распределения:
      1. Экономный вариант (FillAllBoxes=false). Ясно, что среди камней может
    встретиться настолько тяжелый камень, что вес самого тяжелого ящика будет равен
    весу этого камня, и для размещения всех камней может оказаться достаточно
    меньшего количества ящиков. Использование всех ящиков никак не изменит вес самого
    тяжелого ящика. Поэтому в экономном варианте разрешается использовать не все
    имеющиеся ящики.
      2. Расточительный вариант (FillAllBoxes=true). Здесь требуется обязательно
    использовать все имеющиеся ящики. При этом вес ящиков, в которых находится ровно
    один камень, не учитывается. Для остальных ящиков решается задача минимизации
    веса самого тяжелого ящика.
     
      Кроме того, для каждого из указанных вариантов, задав Equalize=true, можно
    заказать выравнивание веса ящиков, т.е. потребовать, чтобы вес самого легкого
    ящика был максимальным.
     
    --------------------------------------------------------------------------------
     
      Комментарии к решению. Выходные данные.
     
      Если массив StonesArray[0..StoneCount-1] не отсортирован, то в начале работы
    процедура выполняет сортировку его элементов по убыванию. Встроенная сортировка
    неэффективна при больших StoneCount, поэтому целесообразно сортировать данные
    до вызова процедуры более эффективным алгоритмом.
     
      Для решения задачи применяется метод ветвей и границ. Промежуточные данные
    в процессе вычислений хранятся в оперативной памяти. Потребности в памяти
    составляют SizeOf(integer) * (Max(Stones[i]) + 3 * StoneCount + BoxCount).
     
      Результат работы процедуры (размещение камней по ящикам) помещается в массив
    BoxesArray[0..StoneCount-1], размер которого должен быть установлен до ее вызова.
    Элементами этого массива являются индексы камней, увеличенные на 1. Индексы
    первых камней в ящиках помечены знаком минус.
     
      Дополнительная информация о решении помещается в переменные:
    NeedBoxes - количество использованных ящиков, BigBoxes - количество ящиков,
    в которых находится ровно один "большой" камень (FillAllBoxes=true),
    BoxSize - размер ящиков, MaxWeight - максимальный вес ящика (может быть больше
    BoxSize, если FillAllBoxes=true), MinWeight - минимальный вес ящика.
     
      При работе процедуры возможно появление ошибочных ситуаций. Возвращаемые коды
    ошибок: -1 - неверные входные данные, -2 - недостаточно оперативной памяти.
     
      Работа алгоритма проверена на Delphi6 + Windows98.
     
    -------------------------------------------------------------------------------}
     
    unit OptBox; // Sha 2002
     
    interface
     
    procedure OptimizeBoxes(var StonesArray, BoxesArray: array of integer;
                                StoneCount, BoxCount: integer;
                                FillAllBoxes, Equalize: boolean;
                            var NeedBoxes, BigBoxes, BoxSize, MaxWeight, MinWeight: integer);
     
    implementation
     
    procedure OptimizeBoxes(var StonesArray, BoxesArray: array of integer;
                                StoneCount, BoxCount: integer;
                                FillAllBoxes, Equalize: boolean;
                            var NeedBoxes, BigBoxes, BoxSize, MaxWeight, MinWeight: integer);
    var
      Boxes: array[1..$3FFFFFFF] of integer absolute BoxesArray;
      Stones: array[1..$3FFFFFFF] of integer absolute StonesArray;
      Place: array of integer; //[0..Stones[1]] В Place[w] - индекс тяжелейшего среди всех с весом не более w
      Left, Right: array of integer; //[0..StoneCount+1] Левые и правые соседи для каждого камня
      Used: array of integer; //[1..StoneCount] Использованные камни, первый в ящике - отрицательный
      Space: array of integer; //[1..BoxCount] В Space[i] - свободное место в i-том ящике
      StoneNo, UsedNo, SpaceNo: integer; //Индексы в соответствующих масивах
      Zero: integer; //Камни с номерами 1..Zero лежат каждый в своем большом ящике
      SumTotal: integer; //Общий вес всех камней
      SumMin, SumMax, SumTest: integer; //Оценки веса самого тяжелого ящика
      SpaceMin, SpaceMax, SpaceTest: integer;//Оценки недовеска самого легкого ящика
      RestSpace, CurSpace: integer; //Остатки места: общий и в текущем ящике
      ErrorCode: integer; //0=OK, -1=ошибка в параметрах, -2=недостаточно памяти
      i, j, Weight: integer; //Временные
      NewBox, EraseBox, BoxOK: boolean; //Создать ящик, убить ящик, ящик заполнен удовлетворительно
      Sorted: boolean; //Камни отсортированы (тяжелые раньше)
    label
      BoxingFailed, EqulizingFailed;
    begin;
     
      //Проверим отсортированность массива
      Sorted:=true;
      for i:=1 to StoneCount-1 do if Stones[i]<Stones[i+1] then begin;
        Sorted:=false; break;
        end;
     
      //Если массив не отсортирован, сортируем камни по убыванию веса (тяжелые раньше)
      if not Sorted then for i:=1 to StoneCount-1 do begin;
        Weight:=Stones[i];
        for j:=i+1 to StoneCount do if Weight<Stones[j] then begin;
          Stones[i]:=Stones[j]; Stones[j]:=Weight; Weight:=Stones[i];
          end;
        end;
     
      //Не надо мучить мою программу плохими данными
      ErrorCode:=0;
      if (StoneCount<=0) or (BoxCount<=0)
      or (length(StonesArray)<StoneCount) or (length(BoxesArray)<StoneCount)
      or (Stones[1]>=512*1024*1024) or (Stones[StoneCount]<=0)
      then ErrorCode:=-1;
     
      //Выделение памяти
      if ErrorCode=0 then try
        SetLength(Place, Stones[1] + 1);
        SetLength(Left, StoneCount + 2);
        SetLength(Right, StoneCount + 2);
        SetLength(Used, StoneCount + 1); //Нулевой элемент не используется
        SetLength(Space, BoxCount + 1); //Нулевой элемент не используется
        except ErrorCode:=-2; end;
     
      if ErrorCode<>0 then begin;
        NeedBoxes:=ErrorCode; BigBoxes:=0; BoxSize:=0; MaxWeight:=0; MinWeight:=0;
        end
      else begin; //Если ErrorCode=0 будем решать задачу
     
        SumTotal:=0; Weight:=Stones[1];
        for i:=1 to StoneCount do begin;
          SumTotal:=SumTotal+Stones[i]; //Подсчет суммарного веса
          for j:=Stones[i] to Weight do Place[j]:=i; //Заполняем Place[]
          Weight:=Stones[i]-1;
          end;
        for j:=0 to Weight do Place[j]:=StoneCount+1; //Нет камней с таким весом
     
        //Решение, которое всегда есть
        NeedBoxes:=1; BigBoxes:=0; BoxSize:=SumTotal;
        Boxes[1]:=-1; for i:=2 to StoneCount do Boxes[i]:=i;
     
        //Начальные значения оценок размера ящика:
        //- для верхней решение точно существует,
        //- ниже нижней решения точно нет.
        SumMax:=SumTotal; //Оценка решения сверху
        if FillAllBoxes then SumMin:=Stones[StoneCount] //Oценка решения снизу
        else begin;
          SumMin:=(SumTotal+BoxCount-1) div BoxCount; //Если в каждом ящике поровну
          if SumMin<Stones[1] then SumMin:=Stones[1]; //Если есть большие камни
          end;
     
        //Мы будем проверять, подходит ли нам яшик размером (верхняя + нижняя граница)/2,
        //затем в соответствии с результатом проверки сдвинем одну из границ:
        //нижнюю - вверх, верхнюю - вниз.
        //Когда границы совпадут, мы получим минимальный размер ящика.
        repeat;
     
          SumTest:=(SumMin+SumMax) shr 1; //Округляем среднее вниз
     
          //Подсчет перегруженных и полностью загруженных ящиков
          //Т.к. в таких ящиках помещается (а может быть даже выступает при этом :)
          //ровно один камень, то эти ящики можно исключить при поиске решения
          Weight:=0; Zero:=0;
          while (Zero<StoneCount) and (Stones[Zero+1]>=SumTest) do begin;
            Weight:=Weight+Stones[Zero+1]; inc(Zero);
            end;
     
          //Остаток свободного пространства во всех коробках
          RestSpace:=SumTest*(BoxCount-Zero)-(SumTotal-Weight);
          if RestSpace<0 then begin;
            SumMin:=SumTest+1; //Решения нет
            goto BoxingFailed;
            end;
     
          UsedNo:=Zero; //Не использован ни один камень после Zero
          SpaceNo:=Zero; //Не заполнили ни одного ящика после Zero
     
          //Начальное заполнение массивов индексов соседей
          for i:=Zero to StoneCount do begin;
            Right[i]:=i+1; //Индекс правого соседа Right[Zero..StoneCount] (для всех камней)
            Left[i+1]:=i; //Индекс левого соседа Left[Zero+1..StoneCount+1] (для неиспользованных)
            end;
          Right[StoneCount+1]:=StoneCount+1; //Соседи граничных - они сами
          Left[Zero]:=Zero;
     
          if Zero<StoneCount then repeat; //Раскладываем камни правее Zero
     
            //Новый ящик
            BoxOK:=true; //Старый ящик перезаполнять не надо
            NewBox:=true; //Начнем формировать новый ящик
            inc(SpaceNo); //Номер нового ящика
            CurSpace:=SumTest; //Ящик пуст, т.е. свободен полностью
            StoneNo:=Zero; //Будем брать соседа Zero справа, т.е. самый тяжелый из оставшихся
     
            repeat; //Продолжим заполнение ящика
     
              //Отменяем предыдущие назначения
              if not BoxOK then repeat; //Плохой ящик - подправим
                StoneNo:=Used[UsedNo]; EraseBox:=false; //Вернем этот камень
                if StoneNo<0 then begin; //Если камень был первым в ящике
                  StoneNo:=-StoneNo; EraseBox:=true; //Флаг, что ящик надо убить
                  end;
                dec(UsedNo); //Удаляем камень из списка использованных
                Left[Right[StoneNo]]:=StoneNo; //Возвращаем его в левый и правый списки
                for i:=Left[StoneNo] to StoneNo-1 do Right[i]:=StoneNo;
                CurSpace:=CurSpace+Stones[StoneNo]; //Освобождаем занятое им пространство
                if EraseBox then begin; //Убьем ящик
                  dec(SpaceNo); //Стало на ящик меньше
                  if SpaceNo<=Zero then begin; //Если это был последний ящик
                    SumMin:=SumTest+1; //Решения нет
                    goto BoxingFailed;
                    end;
                  CurSpace:=Space[SpaceNo]; //Свободное пространство в предыдущем ящике
                  end;
                until not EraseBox; //Последним отменяем непервый камень в ящике
     
              //Делаем новые назначения
              while (UsedNo<StoneCount) //Пока есть камни
              and (CurSpace>=Stones[Left[StoneCount+1]]) do begin; //и есть место для самого мелкого
                if BoxOK then begin; //Если ящик хороший (не после отмены) решаем что брать дальше
                  //Если новый ящик или места хватит любому будем брать соседа Zero
                  if NewBox or (CurSpace>=Stones[1]) then StoneNo:=Zero
                  //Если есть слишком тяжелые - первого подхоящего
                  else if StoneNo<Place[CurSpace]-1 then StoneNo:=Place[CurSpace]-1;
                  end; //Иначе соседа текущего
                BoxOK:=true; //Теперь ящик хороший - забыть про отмены
                StoneNo:=Right[StoneNo]; //Берем (делаем текущим) новый камень
                if StoneNo=StoneCount+1 then break; //Если нет больше подходящих камней
                inc(UsedNo); Used[UsedNo]:=StoneNo; //Фиксируем взятие
                if NewBox then begin;
                  NewBox:=false; Used[UsedNo]:=-StoneNo;
                  end;
                CurSpace:=CurSpace-Stones[StoneNo]; //Вычисляем недовесок в текущем ящике
                Left[Right[StoneNo]]:=Left[StoneNo]; //Левый сосед правого соседа взят
                //Новый правый сосед у всех левее текущего
                for i:=Left[StoneNo] to StoneNo-1 do Right[i]:=Right[StoneNo];
                end;
     
              //Требуется отмена, если текущий недовесок превысил остаток свободного пространства
              BoxOK:=(CurSpace<=RestSpace)
              until BoxOK; //Вываливаемся, если заполнили нормально
     
            Space[SpaceNo]:=CurSpace; //Сохраним недовесок текущего ящика
            RestSpace:=RestSpace-CurSpace; //Подсчет остатка свободного пространства
            until UsedNo=StoneCount; //Пока не кончатся все камни
     
          //Если мы здесь, значит решение найдено для ящиков размером SumTest
     
          //Определяем минимальное свободное пространство по всем ящикам
          if Zero<SpaceNo then begin;
            CurSpace:=Space[Zero+1];
            for i:=Zero+2 to SpaceNo do if CurSpace>Space[i] then CurSpace:=Space[i];
            end
          else CurSpace:=0;
     
          //Вычисляем максимальный вес ящика (правее Zero) для найденного решения
          SumMax:=SumTest-CurSpace;
     
          //Сохраняем найденное решение
          NeedBoxes:=SpaceNo; BigBoxes:=Zero; BoxSize:=SumMax;
          for i:=1 to Zero do Boxes[i]:=-i; //Первые Zero ящиков
          for i:=Zero+1 to StoneCount do Boxes[i]:=Used[i]; //Остальные
     
    BoxingFailed:
          until SumMin>=SumMax;
     
        if Equalize and (BigBoxes+1<NeedBoxes) then begin;
     
          //Вернемся к ранее найденному решению
          Zero:=BigBoxes;
     
          //Суммарный вес камней Zero+1..StoneCount
          Weight:=0; for i:=1 to Zero do Weight:=Weight+Stones[i];
          Weight:=SumTotal-Weight;
     
          //Начальные значения оценок максимального пространства в ящике:
          //- для верхней решение точно существует,
          //- ниже нижней решения точно нет.
          SpaceMin:=BoxSize - Weight div (NeedBoxes-Zero); //Оценка решения снизу
          SpaceMax:=SpaceMin; //Oценка решения сверху
          Weight:=BoxSize;
          for i:=StoneCount downto Zero+1 do begin;
            j:=Boxes[i];
            if j>=0 then Weight:=Weight-Stones[j]
            else begin;
              Weight:=Weight-Stones[-j];
              if SpaceMax<Weight then SpaceMax:=Weight;
              Weight:=BoxSize;
              end;
            end;
     
          //Мы будем проверять, можно ли распределить камни по ящикам так, чтобы
          //в самом легком из них осталось места не больше (верхняя + нижняя граница)/2,
          //затем в соответствии с результатом проверки сдвинем одну из границ:
          //нижнюю - вверх, верхнюю - вниз.
          //Когда границы совпадут, мы получим максимальный вес самого легкого ящика.
          while SpaceMin<SpaceMax do begin;
     
            SpaceTest:=(SpaceMin+SpaceMax) shr 1; //Округляем среднее вниз
     
            UsedNo:=Zero; //Не использован ни один камень после Zero
            SpaceNo:=Zero; //Не заполнили ни одного ящика после Zero
     
            //Начальное заполнение массивов индексов соседей
            for i:=Zero to StoneCount do begin;
              Right[i]:=i+1; //Индекс правого соседа Right[Zero..StoneCount] (для всех камней)
              Left[i+1]:=i; //Индекс левого соседа Left[Zero+1..StoneCount+1] (для неиспользованных)
              end;
            Right[StoneCount+1]:=StoneCount+1; //Соседи граничных - они сами
            Left[Zero]:=Zero;
     
            repeat; //Раскладываем камни правее Zero
     
              //Новый ящик
              BoxOK:=true; //Старый ящик перезаполнять не надо
              NewBox:=true; //Начнем формировать новый ящик
              inc(SpaceNo); //Номер нового ящика
              CurSpace:=BoxSize; //Ящик пуст, т.е. свободен полностью
              StoneNo:=Zero; //Будем брать соседа Zero справа, т.е. самый тяжелый из оставшихся
     
              repeat; //Продолжим заполнение ящика
     
                //Отменяем предыдущие назначения
                if not BoxOK then repeat; //Плохой ящик - подправим
                  StoneNo:=Used[UsedNo]; EraseBox:=false; //Вернем этот камень
                  if StoneNo<0 then begin; //Если камень был первым в ящике
                    StoneNo:=-StoneNo; EraseBox:=true; //Флаг, что ящик надо убить
                    end;
                  dec(UsedNo); //Удаляем камень из списка использованных
                  Left[Right[StoneNo]]:=StoneNo; //Возвращаем его в левый и правый списки
                  for i:=Left[StoneNo] to StoneNo-1 do Right[i]:=StoneNo;
                  CurSpace:=CurSpace+Stones[StoneNo]; //Освобождаем занятое им пространство
                  if EraseBox then begin; //Убьем ящик
                    dec(SpaceNo); //Стало на ящик меньше
                    if SpaceNo<=Zero then begin; //Если это был последний ящик
                      SpaceMin:=SpaceMin+1; //Решения нет
                      goto EqulizingFailed;
                      end;
                    CurSpace:=Space[SpaceNo]; //Свободное пространство в предыдущем ящике
                    end;
                  until not EraseBox; //Последним отменяем непервый камень в ящике
     
                //Делаем новые назначения
                while (UsedNo<StoneCount) //Пока есть камни
                and (CurSpace>=Stones[Left[StoneCount+1]]) do begin; //и есть место для самого мелкого
                  if BoxOK then begin; //Если ящик хороший (не после отмены) решаем что брать дальше
                    //Если новый ящик или места хватит любому будем брать соседа Zero
                    if NewBox or (CurSpace>=Stones[1]) then StoneNo:=Zero
                    //Если есть слишком тяжелые - первого подхоящего
                    else if StoneNo<Place[CurSpace]-1 then StoneNo:=Place[CurSpace]-1;
                    end; //Иначе соседа текущего
                  BoxOK:=true; //Теперь ящик хороший - забыть про отмены
                  StoneNo:=Right[StoneNo]; //Берем (делаем текущим) новый камень
                  if StoneNo=StoneCount+1 then break; //Если нет больше подходящих камней
                  inc(UsedNo); Used[UsedNo]:=StoneNo; //Фиксируем взятие
                  if NewBox then begin;
                    NewBox:=false; Used[UsedNo]:=-StoneNo;
                    end;
                  CurSpace:=CurSpace-Stones[StoneNo]; //Вычисляем недовесок в текущем ящике
                  Left[Right[StoneNo]]:=Left[StoneNo]; //Левый сосед правого соседа взят
                  //Новый правый сосед у всех левее текущего
                  for i:=Left[StoneNo] to StoneNo-1 do Right[i]:=Right[StoneNo];
                  end;
     
                //Требуется отмена, если текущий недовесок превысил лимит
                BoxOK:=(CurSpace<=SpaceTest)
                  and ((SpaceNo<NeedBoxes) and (UsedNo<>StoneCount)
                    or (SpaceNo=NeedBoxes) and (UsedNo=StoneCount));
                until BoxOK; //Вываливаемся, если заполнили нормально
     
              Space[SpaceNo]:=CurSpace; //Сохраним недовесок текущего ящика
              until UsedNo=StoneCount; //Пока не кончатся все камни
     
            //Если мы здесь, значит решение найдено для недовесков размером SpaceTest
     
            //Определяем максимальное свободное пространство по всем ящикам (правее Zero)
            SpaceMax:=Space[Zero+1];
            for i:=Zero+2 to SpaceNo do if SpaceMax<Space[i] then SpaceMax:=Space[i];
     
            //Сохраняем только изменения основного решения
            for i:=Zero+1 to StoneCount do Boxes[i]:=Used[i];
     
    EqulizingFailed:
            end; //для while SpaceMin<SpaceMax
          end; //для Equalize
     
        //Находим MaxWeight, MinWeight и правим BigBoxes для нашего решения
        MaxWeight:=-1; MinWeight:=-1;
        Weight:=0;
        for i:=StoneCount downto 1 do begin;
          j:=Boxes[i];
          if j>=0 then Weight:=Weight+Stones[j]
          else begin;
            Weight:=Weight+Stones[-j];
            if MaxWeight<Weight then MaxWeight:=Weight;
            if (MinWeight>Weight) or (MinWeight<0) then MinWeight:=Weight;
            if (i<=BigBoxes) and (Weight<=BoxSize) then dec(BigBoxes);
            Weight:=0;
            end;
          end;
     
        end; //для ErrorCode=0
     
      //Вернем память
      Place:=nil;
      Left:=nil;
      Right:=nil;
      Used:=nil;
      Space:=nil;
      end;
     
    end. 
     

Пример использования:

    unit BagU;
     
    interface
     
    uses
      OptBox, SysUtils, Classes, Controls, Forms, StdCtrls;
     
    type
      TForm1 = class(TForm)
        bCalculate: TButton;
        edBoxCount: TEdit;
        cbFillAllBoxes: TCheckBox;
        cbEqualize: TCheckBox;
        mStones: TMemo;
        mBoxes: TMemo;
        lBoxCount: TLabel;
        lStones: TLabel;
        lBoxes: TLabel;
        procedure bCalculateClick(Sender: TObject);
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.dfm}
     
    procedure TForm1.bCalculateClick(Sender: TObject);
    var
      Boxes: array of integer;
      Stones: array of integer;
      BoxCount, StoneCount: integer;
      FillAllBoxes, Equalize: boolean;
      BoxSize, NeedBoxes, BigBoxes, MaxWeight, MinWeight: integer;
      i, j, k: integer;
      s: string;
    begin;
      mBoxes.Lines.Clear;
      try
        FillAllBoxes:=cbFillAllBoxes.Checked;
        Equalize:=cbEqualize.Checked;
        BoxCount:=StrToInt(Trim(edBoxCount.Text));
        StoneCount:=mStones.Lines.Count;
        SetLength(Boxes,StoneCount);
        SetLength(Stones,StoneCount);
        for i:=0 to StoneCount-1 do Stones[i]:=StrToInt(Trim(mStones.Lines[i]));
     
        OptimizeBoxes(Stones, Boxes, StoneCount, BoxCount, FillAllBoxes, Equalize,
          NeedBoxes, BigBoxes, BoxSize, MaxWeight, MinWeight);
     
        if NeedBoxes>0 then begin;
          mBoxes.Lines.Add(Format('Надо ящиков: %d',[NeedBoxes]));
          mBoxes.Lines.Add(Format('В т.ч. больших: %d',[BigBoxes]));
          mBoxes.Lines.Add(Format('Размер ящиков: %d',[BoxSize]));
          mBoxes.Lines.Add(Format('Макс. загрузка: %d',[MaxWeight]));
          mBoxes.Lines.Add(Format('Мин. загрузка: %d',[MinWeight]));
          k:=0;
          for i:=0 to StoneCount-1 do begin;
            j:=Boxes[i];
            if j<0 then begin;
              j:=-j; inc(k); if k<=BigBoxes then s:='o' else s:='';
              mBoxes.Lines.Add(Format('------------%s %d',[s,k]));
              end;
            mBoxes.Lines.Add(IntToStr(Stones[j-1]));
            end;
          end;
        except end;
      Boxes:=nil;
      Stones:=nil;
      end;
     
    end. 
     
     
