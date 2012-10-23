<h1>Метод Монте-Карло</h1>
<div class="date">01.01.2007</div>

<p>Рассмотрим произвольный квадрат с центром в начале координат и вписанный в него круг. Будем рассматривать только первую координатную четверть. В ней будет находиться четверть круга и четверть квадрата. Обозначим радиус круга r, тогда четверть квадрата тоже будет квадратом(очевидно) со стороной r.</p>
<p>Будем случайным образом выбирать точки в этом квадрате и считать количество точек, попавших в четверть круга. Благодаря теории вероятности мы знаем, что отношение попаданий в четверть круга к попаданиям 'в молоко' равно отношению площадей - пи/4. Вот, собственно, и весь алгоритм... Чем больше взятых наугад точек мы проверим, тем точнее будет отношение площадей.</p>
<p>Вот простенькая программа на Паскале, считающая пи этим способом... Четыре первых знака требуют на моем PentiumII-300 около 5 минут...</p>
<pre>
uses Crt;
const
 n=10000000;
 r=46340;
 r2=46340*46340;
var
 i,pass : LongInt;
 x,y : real;
{$F+}
begin
 WriteLn('Поехали!');
 Randomize;
 pass:=0;
 for i:=1 to n do
  begin
   x:=Random(r+1);
   y:=Random(r+1);
   if ( x*x+y*y &lt; r2 ) then INC(pass);
  end;
 TextColor(GREEN);
 WriteLn('Число ПИ получилось равным: ',(pass/i*4):0:5);
 ReadLn;
end.
</pre>
<p><a href="https://algolist.manual.ru" target="_blank">https://algolist.manual.ru</a></p>
