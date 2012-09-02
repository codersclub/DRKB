<h1>Вычисление определенного интеграла методом левых и правых прямоугольников с заданной точностью</h1>
<div class="date">01.01.2007</div>


<pre>
{ **** UBPFD *********** by kladovka.net.ru ****
&gt;&gt; Вычисление определенного интеграла методом левых и правых прямоугольников с заданной точностью
 
"Просто расчет площади под функцией, параметры: a,b - пределы интегрирования, a&lt;=b
eps - допустимая погрешность, практически гарантируется, что расхождение результата с истинным значением интеграла не превосходит по модулю указанную величину. Только не переборщите :-))
intF - подинтегральная функция. Естественно, желательно задавать функции, интегрируемые в смысле Римана. Объявление смотри в примере.
Примечание: Несобственные интегралы не считаем :-)
Проверок на переполнение нет, да и вообще нет проверок..."
(Romkin (Москва))
 
Модуль сделан на основе функции вычисления опред. интеграла методом трапеций от Romkin'а (Москва).
 
Зависимости: Нет
Автор:       Алексей Глеб, noodlesf@mail.ru, Чернигов
Copyright:   с подачи Romkin'а (Москва)
Дата:        18 мая 2003 г.
********************************************** }
 
Unit IntPram;
 
Interface
 
Type
  TIntFunc=Function(X: Double): Double;
 
Function LeftPramInt(a, b: Double; eps: Double; IntF: TIntFunc): Double;
Function RightPramInt(a, b: Double; eps: Double; IntF: TIntFunc): Double;
 
Implementation
 
Function LeftPramInt(a, b: Double; eps: Double; IntF: TIntFunc): Double;
Var
  //S - площадь на предыдущей итерации,
  //step - "толщина" прямоугольника
  //gran - передвигаемая от a до b граница
  //n - число прямоугольников, удваивается на каждой итерации
  S, step, gran: Double;
  n: integer;
Begin
  //Сначала приближение одного прямоугольника
  step:=b-a;
  Result:=IntF(a)*step;
  n:=1;
  Repeat
    S:=Result;
    n:=n*2;
    step:=(b-a)/n;
    Gran:=a;
    Result:=0;
    //Ниже - просто вычисляем площади новых прямоугольников
    while gran&lt;b do
    Begin
      Result:=Result+IntF(gran)*step;
      gran:=gran+step;
    End;
  Until abs(S-Result)&lt;=eps;
End;
 
Function RightPramInt(a, b: Double; eps: Double; IntF: TIntFunc): Double;
Var
  //S - площадь на предыдущей итерации,
  //step - "толщина" прямоугольника
  //gran - передвигаемая от a до b граница
  //n - число прямоугольников, удваивается на каждой итерации
  S, step, gran: Double;
  n: integer;
Begin
  //Сначала приближение одного прямоугольника
  step:=b-a;
  Result:=IntF(b)*step;
  n:=1;
  Repeat
    S:=Result;
    n:=n*2;
    step:=(b-a)/n;
    Gran:=b;
    Result:=0;
    //Ниже - просто вычисляем площади новых прямоугольников
    while a&lt;gran do
    Begin
      Result:=Result+IntF(gran)*step;
      gran:=gran-step;
    End;
  Until abs(S-Result)&lt;=eps;
End;
 
End. 
</pre>

<p> Пример использования:</p>
<pre>
uses IntPram;
 
function IntSqrt(x: Double): Double;
begin
  Result:=Sqrt(x);
end;
 
procedure TForm1.Button1Click(Sender: TObject);
begin
  label1.Caption:=FloatToStr(LeftPramInt(0, Pi, 0.00001, S));
  label2.Caption:=FloatToStr(RightPramInt(0, Pi, 0.00001, S));
end; 
</pre>

