---
Title: Статическая реализация очереди на основе массива
Date: 01.01.2007
Source: <https://algolist.manual.ru>
---


Статическая реализация очереди на основе массива
================================================

При представлении очереди вектором в статической памяти в дополнение к
обычным для дескриптора вектора параметрам в нем должны находиться два
указателя: на начало очереди (на первый элемент в очереди) и на ее конец
(первый свободный элемент в очереди). При включении элемента в очередь
элемент записывается по адресу, определяемому указателем на конец, после
чего этот указатель увеличивается на единицу. При исключении элемента из
очереди выбирается элемент, адресуемый указателем на начало, после чего
этот указатель уменьшается на единицу.

Очевидно, что со временем указатель на конец при очередном включении
элемента достигнет верхней границы той области памяти, которая выделена
для очереди. Однако, если операции включения чередовались с операциями
исключения элементов, то в начальной части отведенной под очередь памяти
имеется свободное место. Для того, чтобы места, занимаемые исключенными
элементами, могли быть повторно использованы, очередь замыкается в
кольцо: указатели (на начало и на конец), достигнув конца выделенной
области памяти, переключаются на ее начало. Такая организация очереди в
памяти называется кольцевой очередью. Возможны, конечно, и другие
варианты организации: например, всякий раз, когда указатель конца
достигнет верхней границы памяти, сдвигать все непустые элементы очереди
к началу области памяти, но как этот, так и другие варианты требуют
перемещения в памяти элементов очереди и менее эффективны, чем кольцевая
очередь.

В исходном состоянии указатели на начало и на конец указывают на начало
области памяти. Равенство этих двух указателей (при любом их значении)
является признаком пустой очереди. Если в процессе работы с кольцевой
очередью число операций включения превышает число операций исключения,
то может возникнуть ситуация, в которой указатель конца "догонит"
указатель начала. Это ситуация заполненной очереди, но если в этой
ситуации указатели сравняются, эта ситуация будет неотличима от ситуации
пустой очереди. Для различения этих двух ситуаций к кольцевой очереди
предъявляется требование, чтобы между указателем конца и указателем
начала оставался "зазор" из свободных элементов. Когда этот "зазор"
сокращается до одного элемента, очередь считается заполненной и
дальнейшие попытки записи в нее блокируются. Очистка очереди сводится к
записи одного и того же (не обязательно начального) значения в оба
указателя. Определение размера состоит в вычислении разности указателей
с учетом кольцевой природы очереди.

Программный пример иллюстрирует организацию очереди и операции на ней.

     {==== Программный пример ====}
     unit Queue;                 { Очередь FIFO - кольцевая }
     Interface
     const SIZE=...;             { предельный размер очереди }
     type data = ...;            { эл-ты могут иметь любой тип }
     Procesure QInit;
     Procedure Qclr;
     Function QWrite(a: data) : boolean;
     Function QRead(var a: data) : boolean;
     Function Qsize : integer;
     Implementation              { Очередь на кольце  }
     var QueueA : array[1..SIZE] of data;   { данные очереди }
        top, bottom : integer;   { начало  и конец  }
     Procedure QInit;            {** инициализация - начало=конец=1 }
       begin top:=1; bottom:=1; end;
     Procedure Qclr;             {**очистка - начало=конец }
       begin top:=bottom; end;
     Function QWrite(a : data) : boolean;  {**  запись в конец  }
       begin
       if bottom mod SIZE+1=top then { очередь полна } QWrite:=false
       else begin
         { запись, модификация указ.конца с переходом по кольцу }
         Queue[bottom]:=a; bottom:=bottom mod SIZE+1; QWrite:=true;
       end;    end;  { QWrite }
     Function QRead(var a: data) : boolean;  {** выборка из начала }
     begin
       if top=bottom then QRead:=false  else
         { запись, модификация указ.начала с переходом по кольцу }
       begin  a:=Queue[top]; top:=top mod SIZE + 1; QRead:=true;
      end;   end; { QRead }
     Function QSize : integer;    {** определение размера }
     begin
       if top <= bottom then QSize:=bottom-top
       else QSize:=bottom+SIZE-top;
     end; { QSize }
     END. 

