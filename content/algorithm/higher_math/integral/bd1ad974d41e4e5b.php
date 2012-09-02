<h1>Вычисление определенного интеграла методом трапеций с заданной точностью</h1>
<div class="date">01.01.2007</div>


<pre>
{ **** UBPFD *********** by kladovka.net.ru ****
&gt;&gt; Вычисление определенного интеграла методом трапеций с заданной точностью
 
Просто расчет площади под функцией, параметры: a,b - пределы интегрирования, a&lt;=b
eps - допустимая погрешность, практически гарантируется, что расхождение результата с истинным значением интеграла не превосходит по модулю указанную величину. Только не переборщите :-))
intF - подинтегральная функция. Естественно, желательно задавать функции, интегрируемые в смысле Римана. Объявление смотри в примере.
Примечание: Несобственные интегралы не считаем :-)
Проверок на переполнение нет, да и вообще нет проверок...
 
Зависимости: Ну какие могут быть зависимости?
Автор:       Romkin, romkin@pochtamt.ru, Москва
Copyright:   Romkin 2002
Дата:        19 ноября 2002 г.
********************************************** }
 
unit intfunc;
 
interface
 
type
  TIntFunc = function(X: Double):Double;
 
function TrapezeInt(a,b:Double; eps: Double; IntF: TIntFunc): Double;
 
implementation
 
function TrapezeInt(a,b:Double; eps: Double; IntF: TIntFunc): Double;
var
  //S - площадь на предыдущей итерации,
  //x - текущее значение аргумента
  //base - высота трапеции
  //n - число трапеций, удваивается на каждой итерации
  S, x, base: Double;
  i, n: Integer;
begin
  //Сначала приближение одной трапецией
  base := b-a; 
  Result := (IntF(a) + IntF(b))/2 * base;
  eps := eps / 10; //Вообще говоря, величина делителя зависит от функции
  n := 1;
  repeat
    S := Result; 
    base := base / 2;
    n := n * 2;
    //Новая площадь вычисляется на основе старой
    Result := Result / 2;
    //Ниже - просто вычисляем площади новых трапеций
    for i := 1 to n div 2 do
    begin
      x := a + base * (i * 2 - 1);
      Result := Result + IntF(x) * base;
    end;
  until abs(S-Result) &lt;= eps;
end;
 
end. 
</pre>

<p> Пример использования:</p>
<pre>
uses intFunc;
 
function intSin(x: Double): Double;
begin
  Result := sin(x);
end;
 
 
procedure TForm1.Button1Click(Sender: TObject);
begin
  Edit1.Text := FloatToStr(TrapezeInt(0,Pi, 0.00001, intSin));
  //результат у меня получился 1.99999990195429 - с запасом
  //Точный ответ - 2.0
end; 
</pre>

