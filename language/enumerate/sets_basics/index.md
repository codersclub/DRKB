---
Title: Что такое множества?
Date: 01.01.2007
---


Что такое множества?
====================

Множества - это наборы однотипных, логически связанных друг с другом
объектов. Характер связей между объектами лишь подразумевается
программистом и никак не контролируется Object Pascal. Количество
элементов, входящих в множество, может меняться в пределах от 0 до 256
(множество, не содержащее элементов, называется пустым). Именно
непостоянством количества своих элементов множества отличаются от
массивов и записей.

Два множества считаются эквивалентными тогда и только тогда, когда все
их элементы одинаковы, причем порядок следования элементов в множестве
безразличен. Если все элементы одного множества входят также и в другое,
говорят о включении первого множества во второе. Пустое множество
включается в любое другое.

Пример определения и задания множеств:

    type 
      digitChar = set of '0'..'9'; 
      digit = set of 0. .9; 
    var 
      sl,s2,s3 : digitChar; 
      s4,s5,s6 : digit; 
    begin 
      si := ['1', '2', '3']; 
      s2 := ['3', '2', '1']; 
      s3 := ['2', '3']; 
      s4 := [0..3, 6]; 
      s5 := [4, 5]; 
      s6 := [3..9]; 
    end. 

В этом примере множества `s1` и `s2` эквивалентны,
а множество `s3` включено в `s2`, но не эквивалентно ему.

Описание типа множества имеет вид:

    <имя типа> = set of <базовый тип>;

Здесь \<имя типа\> - правильный идентификатор;  
set, of - зарезервированные слова (множество, из);  
\<базовый тип\> - базовый тип элементов множества,
в качестве которого может использоваться любой порядковый тип,
кроме Word, Integer, Longint, Int64.

Для задания множества используется так называемый _конструктор множества:_
список спецификаций элементов множества, отделенных друг от друга
запятыми; список обрамляется квадратными скобками. Спецификациями
элементов могут быть константы или выражения базового типа, а также
тип-диапазон того же базового типа.

Над множествами определены следующие операции:

**\* пересечение множеств** - результат содержит элементы, общие для обоих
множеств; например, s4\*s6 содержит [3], s4\*s5 -пустое множество (см.
выше);

**\+ объединение множеств** - результат содержит элементы первого множества,
дополненные недостающими элементами из второго множества:

    S4+S5 содержит [0, 1, 2, 3, 4, 5, 6];
    S5+S6 содержит [3, 4, 5, 6, 7, 8, 9];

**\- разность множеств** - результат содержит элементы из первого множества,
которые не принадлежат второму:

    S6-S5 содержит [3, 6, 7, 8, 9];
    S4-S5 содержит [0, 1, 2, 3, 6];

**= проверка эквивалентности** - возвращает True, если оба множества
эквивалентны;

**\<\> проверка неэквивалентности** - возвращает True, если оба множества
неэквивалентны;

**\<= проверка вхождения** - возвращает True, если первое множество включено
во второе;

**\>= проверка вхождения** - возвращает True, если второе множество включено
в первое;

**_in_ проверка принадлежности** - в этой бинарной операции первый элемент -
выражение, а второй - множество одного и того же типа; возвращает True,
если выражение имеет значение, принадлежащее множеству:

    3 in s6 возвращает True;
    2*2 in s1 возвращает False.

Дополнительно к этим операциям можно использовать две процедуры.

**include** - включает новый элемент во множество. Обращение к процедуре:

    Include(S,I)

Здесь `S` - множество, состоящее из элементов базового типа TSet Base;  
`I` - элемент типа TSetBase, который необходимо включить во множество.

**exclude** - исключает элемент из множества. Обращение:

    Exclude(S,I)

Параметры обращения - такие же, как у процедуры include. В отличие от
операций **+** и **-**, реализующих аналогичные действия над двумя множествами,
процедуры оптимизированы для работы с одиночными элементами множества и
поэтому отличаются высокой скоростью выполнения.

**Учебная программа PRIMSET**

В следующем примере, иллюстрирующем приемы работы с множествами,
реализуется алгоритм выделения из первой сотни натуральных чисел всех
простых чисел.
> Простыми называются целые числа, которые не делятся без
> остатка на любые другие целые числа, кроме 1 и самого себя. К простым
> относятся 1, 2, 3, 5, 7, 11, 13 и т. д...

В его основе лежит прием,
известный под названием "решето Эратосфена". В соответствии с этим
алгоритмом вначале формируется множество BeginSet, состоящее из всех
целых чисел в диапазоне от 2 до N. В множество primerset (оно будет
содержать искомые простые числа) помещается 1. Затем циклически
повторяются следующие действия:

- взять из BeginSet первое входящее в него число Next и поместить его В
PrimerSet;

- удалить из BeginSet число Next и все другие числа, кратные ему, Т. е.
2\*Next, 3\*Next И Т.Д.

Цикл повторяется до тех пор, пока множество BeginSet не станет пустым.

Эту программу нельзя использовать для произвольного N, так как в любом
множестве не может быть больше 256 элементов.

    procedure TfmExample.bbRunClick(Sender: TObject); 
    // Выделение всех простых чисел из первых N целых 
    const 
      N = 255; // Количество элементов исходного множества 
    type 
      SetOfNumber = set of 1..N; 
    var 
      n1,Next,i: Word; // Вспомогательные переменные 
      BeginSet, // Исходное множество 
      PrimerSet: SetOfNumber; // Множество простых чисел 
      S : String; 
    begin 
      BeginSet := [2..N]; 
      // Создаем исходное множество 
      PrimerSet:= [1]; // Первое простое число 
      Next := 2; // Следующее простое число 
      while BeginSet о [ ] do // Начало основного цикла 
      begin 
        nl := Next; //nl-число, кратное очередному простому (Next) 
        // Цикл удаления из исходного множества непростых чисел: 
        while nl <= N do 
        begin 
          Exclude(BeginSet, nl); 
          n1 := nl + Next // Следующее кратное 
        end; // Конец цикла удаления 
        Include(PrimerSet, next); 
        // Получаем следующее простое, которое есть первое 
        // число, не вычеркнутое из исходного множества 
        repeat 
          inc(Next) 
        until (Next in BeginSet) or (Next > N) 
      end; 
      // Конец основного цикла 
      // Выводим результат: 
      S := '1'; 
      for i := 2 to N do 
        if i in PrimerSet then 
          S := S+', '+IntToStr(i); 
      mmOutput.Lines.Add(S) 
    end; 

Перед тем как закончить рассмотрение множеств, полезно провести
небольшой эксперимент. Измените описание типа `SetOfNumber` следующим
образом:

    type SetOfNumber = set of 1..1; 

и еще раз запустите программу из предыдущего примера. На экран будет
выведено **1, 3, 5, 7**

Множества BeginSet и PrimerSet состоят теперь из одного элемента, а
программа сумела поместить в них не менее семи!

Секрет этого прост: внутреннее устройство множества таково, что каждому
его элементу ставится в соответствие один двоичный разряд (один бит);
если элемент включен во множество, соответствующий разряд имеет значение 1,
в противном случае - 0. В то же время минимальной единицей памяти
является один байт, содержащий 8 бит, поэтому компилятор выделил
множествам по одному байту, и в результате мощность каждого из них стала
равна 8 элементам. Максимальная мощность множества - 256 элементов. Для
таких множеств компилятор выделяет по 16 смежных байт.

И еще один эксперимент: измените диапазон базового типа на 1..256. Хотя
мощность этого типа составляет 256 элементов, при попытке компиляции
программы компилятор сообщит об ошибке:

    Sets may have at most 256 elements
    (Множества могут иметь не более 256 элементов)

т. к. нумерация элементов множества начинается с нуля независимо от объявленной в
программе нижней границы. Компилятор разрешает использовать в качестве
базового типа целочисленный тип-диапазон с минимальной границей 0 и
максимальной 255 или любой перечисляемый тип не более чем с 256
элементами (максимальная мощность перечисляемого типа - 65536
элементов).
