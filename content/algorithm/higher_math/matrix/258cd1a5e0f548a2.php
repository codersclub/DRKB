<h1>Динамическая реализация стека на основе списка</h1>
<div class="date">01.01.2007</div>

<p>Стек представляется как линейный список, в котором включение элементов всегда производятся в начала списка, а исключение - также из начала. Для представления его нам достаточно иметь один указатель - top, который всегда указывает на последний записанный в стек элемент. В исходном состоянии (при пустом стеке) указатель top - пустой. Процедуры StackPush и StackPop сводятся к включению и исключению элемента в начало списка. Обратите внимание, что при включении элемента для него выделяется память, а при исключении - освобождается.</p>
<p>Перед включением элемента проверяется доступный объем памяти, и если он не позволяет выделить память для нового элемента, стек считается заполненным. При очистке стека последовательно просматривается весь список и уничтожаются его элементы. При списковом представлении стека оказывается непросто определить размер стека. Эта операция могла бы потребовать перебора всего списка с подсчета числа элементов. Чтобы избежать последовательного перебора всего списка мы ввели дополнительную переменную stsize, которая отражает текущее число элементов в стеке и корректируется при каждом включении/исключении. </p>
<pre>
 {==== Программный пример  ====}
 { Стек на 1-связном линейном списке }
 unit Stack;
 Interface
 type data = ...; { эл-ты могут иметь любой тип }
 Procedure StackInit;
 Procedure StackClr;
 Function StackPush(a : data) : boolean;
 Function StackPop(Var a : data) : boolean;
 Function StackSize : integer;
 Implementation
 type stptr = ^stit;  { указатель на эл-т списка }
      stit = record   { элемент списка }
        inf : data;   { данные }
        next: stptr;  { указатель на следующий эл-т }
        end;
 Var top : stptr; { указатель на вершину стека }
     stsize : longint;  { размер стека }
 {** инициализация - список пустой }
 Procedure StackInit;
   begin   top:=nil; stsize:=0;  end; { StackInit }
 {** очистка - освобождение всей памяти }
 Procedure StackClr;
  var x : stptr;
   begin   { перебор эл-тов до конца списка и их уничтожение }
   while top&lt;&gt;nil do
     begin  x:=top; top:=top^.next; Dispose(x);  end;
   stsize:=0;
 end; { StackClr }
 Function StackPush(a: data) : boolean;   { занесение в стек }
  var x : stptr;
   begin      { если нет больше свободной памяти - отказ }
   if MaxAvail &lt; SizeOf(stit) then StackPush:=false
   else   { выделение памяти для эл-та и заполнение инф.части }
     begin  New(x); x^.inf:=a;
                { новый эл-т помещается в голову списка }
       x^.next:=top; top:=x;
       stsize:=stsize+1; { коррекция размера }
       StackPush:=true;
     end;
 end; { StackPush }
 Function StackPop(var a: data) : boolean; { выборка из стека }
  var x : stptr;
   begin
   { список пуст - стек пуст }
   if top=nil then StackPop:=false
   else begin
     a:=top^.inf; { выборка информации из 1-го эл-та списка }
     { 1-й эл-т исключается из списка, освобождается память }
     x:=top; top:=top^.next; Dispose(top);
     stsize:=stsize-1; { коррекция размера }
     StackPop:=true;
 end;  end; { StackPop }
 Function StackSize : integer;  { определение размера стека }
   begin   StackSize:=stsize;   end; { StackSize }
 END. 
</pre>

<p><a href="https://algolist.manual.ru" target="_blank">https://algolist.manual.ru</a></p>
