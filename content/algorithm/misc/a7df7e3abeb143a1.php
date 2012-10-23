<h1>Тест простоты Рабина</h1>
<div class="date">01.01.2007</div>

<p><img src="/pic/embim1864.gif" width="1" height="1" vspace="1" hspace="1" border="0" alt=""><br>
<img src="/pic/embim1865.png" width="160" height="1" vspace="1" hspace="1" border="0" alt=""><br>
&nbsp;<br>
<p>&nbsp;</p>
&#169; Борисенко, мех-мат МГУ</p>
<p>Напомним необходимые нам результаты из элементарной теории чисел и алгебры</p>
<p>Малая теорема Ферма. Пусть p -- простое число. Тогда для всякого целого числа b, отличного от нуля, справедливо сравнение bp-1 == 1 (mod p).</p>
<p>Малая теорема Ферма является непосредственным следствием теоремы Лагранжа (порядок любого элемента группы делит порядок группы) и того факта, что кольцо Zp в случае простого p является полем, т.е. все его ненулевые элементы принадлежат группе обратимых элементов. Порядок группы обратимых элементов кольца Zp равен p-1.</p>
<p>Простейший тест проверки простоты числа m состоит в проверке малой теоремы Ферма. Выберем произвольное целое число b (например, b = 2), и возведем его в степень m - 1 по модулю m. Если мы получим не единицу, то по малой теореме Ферма число m составное. Беда состоит в том, что если</p>
bm-1 == 1 (mod m),</p>
<p>то ничего нельзя сказать об m. Древние греки ошибочно полагали, что все числа m, удовлетворяющие обращению малой теоремы Ферма для основания 2, простые: если</p>
2m-1 == 1 (mod m),</p>
<p>то m -- простое число. Минимальный контрпример к этому утверждению был найден только в XVII веке:</p>
2340 == 1 (mod 341),</p>
<p>но число 341 -- не простое, 341 = 11 * 31.</p>
<p>(Действительно, 2340 = (2^10)34 = 102434, но 1024 = 3 * 341 + 1 == 1 (mod 341), поэтому 102434 == 1 (mod 341).)</p>
<p>То, что 341 не удовлетворяет малой теореме Ферма, может быть показано с помощью других оснований:</p>
3340 == 56 (mod 341)</p>
<p>Тем не менее существуют числа, которые не являются простыми, но которые ведут себя как простые в малой теореме Ферма. Такие числа называются кармайкловыми.</p>
<p>Определение. Число m называется кармайкловым, если оно не простое и для всякого b, взаимно простого с m, выполняется утверждение малой теоремы Ферма:</p>
bm-1 == 1 (mod m).</p>
<p>Минимальные кармайкловы числа -- это 561, 1105, 1729, ...</p>
<p>Множество кармайкловых чисел бесконечно, и их плотность стремится к нулю на бесконечности. Несложно доказать следующее утверждение.</p>
<p>Предложение 5. Пусть</p>
m = p1e1 * p2e2 * ... * pkek --</p>
<p>представление целого числа m в виде произведения степеней простых. Число m является кармайкловым тогда и только тогда, когда</p>
<p>1) для всякого i показатель степени ei = 1;</p>
<p>2) k &gt;= 3;</p>
<p>3) для всякого i число pi - 1 делит m - 1.</p>
<p>Доказательство. Докажем только обратную, наиболее интересную импликацию. Пусть число m удовлетворяет условиям 1-3.</p>
<p>Рассмотрим произвольное b, взаимно простое с m. По Китайской теореме об остатках, кольцо Zm представляется в виде прямой суммы</p>
Zm == Zp1 + Zp2 + ... + Zpk.</p>
<p>При этом изоморфизме элемен b представляется в виде строки</p>
b == (b1, b2, ..., bk)</p>
<p>Тогда</p>
bm-1 == (b1m-1, b2m-1, ..., bkm-1.</p>
<p>По малой теореме Ферма, для всякого i</p>
bim-1 == 1 (mod pi),</p>
<p>поскольку (m - 1) делится на (pi - 1).</p>
<p>Поэтому</p>
bm-1 == (1, 1, ..., 1)</p>
<p>т.е. bm-1 == 1 (mod m).</p>
<p>Пример. Покажем, что число 561 является кармайкловым. Действительно, 561 = 3 * 11 * 17. Имеем</p>
(3 - 1) | 560, (11 - 1) | 560, (17 - 1) | 560.</p>
<p>Следовательно, число 561 удовлетворяет условиям предложения 5.</p>
<p>Итак, для кармайкловых чисел тест простоты, основанный на теореме Ферма, не работает. Тем не менее его модификация, предложенная Рабином, применима к любым целым числам.</p>
<p>Тест Рабина является вероятностным. Это означает, что он использует датчик случайных чисел и, таким образом, работает не детерминированно. Для входного целого числа m тест Рабина может выдать один из следующих двух ответов.</p>
<p>1. Число m является составным.</p>
<p>2. Не знаю.</p>
<p>В случае первого ответа число m действительно является составным, тест Рабина предъявляет доказательство этого факта. Второй ответ может быть выдан как для простого, так и для составного числа m. Однако для любого составного числа m вероятность второго ответа не превышает 1/4. Ценность теста Рабина состоит именно в неравенстве, ограничевающем сверху вероятность второго ответа для произвольного составного числа m.</p>
<p>Таким образом, если мы применим 100 раз тест Рабина к числу m и получим 100 ответов "не знаю", то можно с большой вероятностью утверждать, что число m простое. Более точно, вероятность получения ста ответов "не знаю" для составного числа m не превышает (1/4)100, т.е. практически равна нулю. Тем не менее тест Рабина не предъявляет доказательства того, что число m простое.</p>
<p>Перейдем непосредственно к изложению теста Рабина. Мы проверяем простоту входного числа m. Допустим сразу, что число m нечетное. (Существует только одно четное простое число -- 2.) Тогда число m - 1 четное. Представим его в виде</p>
m - 1 = 2t * sгде s -- нечетное число. Выберем случайное число b такое, что</p>
b =/= 0, b =/= 1 (mod m), 1 &lt; b &lt; mПри выборе b используется датчик случайных чисел.</p>
<p>Используя алгоритм быстрого возведения в степень по модулю m, вычислим следующую последовательность элементов кольца Zm:</p>
<p> &nbsp;&nbsp;&nbsp; x0 == bs (mod m),&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (1)</p>
<p> &nbsp;&nbsp;&nbsp; x1 == x0 * x0 (mod m),</p>
<p> &nbsp;&nbsp;&nbsp; x2 == x1 * x1 (mod m),</p>
<p> &nbsp;&nbsp;&nbsp; ...</p>
<p> &nbsp;&nbsp;&nbsp; xt == xt-1 * xt-1 == bm - 1 (mod m)</p>
<p>(На каждом шаге мы возводим в квадрат число, полученное на предыдущем шаге.)</p>
<p>Тест Рабина выдает ответ 'm -- составное число' в случае, если</p>
<p>1) xt =/= 1 (mod m), или</p>
<p>2) в последовательности x0, x1, x2, ..., xt имеется фрагмент вида ..., *, 1, ... где звездочкой обозначено число, отличное от единицы или минус единицы по модулю m.</p>
<p>В противном случае тест Рабина выдает ответ "не знаю". Последовательность x0, x1, ..., xt в этом "плохом" случае либо начинается с единицы, либо содержит (-1) где-нибудь не в конце.</p>
<p>Cуществует алгоритм, доказывающий простоту, со сложностью O(ln3n), согласно которому необходимо провести тест Рабина со всеми числами <br>
&nbsp;<br>
<p>&nbsp;</p>
2 &lt;= b &lt; 70ln2m,а затем проверить, не является ли m степенью простого числа. Однако его правильность зависит от недоказанной в настоящее время гипотезы Римана.</p>
<p>Этот алгоритм, опираясь на недоказанный факт, в принципе может 'соврать' в отношении доказательства простоты, хотя если тест Рабина говорит, что число составное, значит так оно и есть. На практике он работает очень даже неплохо.</p>
<p>&nbsp;<br>
Теорема (законность теста Рабина). <img src="/pic/embim1866.gif" width="1" height="1" vspace="1" hspace="1" border="0" alt=""><br>
<img src="/pic/embim1867.png" width="160" height="1" vspace="1" hspace="1" border="0" alt=""><br>
<p>&nbsp;</p>
<p>1. Если тест Рабина выдает ответ 'm -- составное число', то m действительно является составным.</p>
<p>2. Вероятность ответа 'не знаю' для составного числа m не превосходит 1/4.</p>
<p>Доказательство. Докажем только первое утверждение. Если xt =/= 1 (mod m), то m не удовлетворяет малой теореме Ферма и, следовательно, не является простым. Если же последовательность (1) содержит фрагмент ..., a, 1, ..., где a =/= +-1 (mod m), то имеем</p>
a2 == 1 (mod m), a =/= 1, a =/= -1 (mod m)</p>
<p>Если бы m было простым, то кольцо Zm являлось бы полем.</p>
<p>Но в любом поле есть только два квадратных корня из единицы: это единица и минус единица. (По теореме Безу, число корней многочлена не превосходит его степени, квадратные корни из единицы -- это корни многочлена x2 - 1.) Следовательно, число m не является простым.</p>
<p>&nbsp;<br>
Пример программы <img src="/pic/embim1868.gif" width="1" height="1" vspace="1" hspace="1" border="0" alt=""><br>
<img src="/pic/embim1869.png" width="160" height="1" vspace="1" hspace="1" border="0" alt=""><br>
<p>&nbsp;</p>
<pre>
{IsPrime.Pas ver. 2.0 (c) Max Alekseyev &lt;relf@os2.ru&gt;, 2:5015/60@FidoNet}
{Реализация вероятностного алгоритма Миллера-Рабина с 20 раундами.
Для примера выдает простые на отрезке [1000000000,1000100000].
Вероятность ошибки (то, что составное число будет названо простым) меньше
4^(-Rounds).}
 
const Rounds=20;
 
function mulmod(x,y,m:longint):longint; assembler;
asm
{$IFDEF USE32}
  mov eax,x
  mul y
  div m
  mov eax,edx
{$ELSE}
  db $66; mov ax,word ptr x
  db $66; mul word ptr y
  db $66; div word ptr m
  mov ax,dx
  db $66; shr dx,16
{$ENDIF}
end;
 
function powmod(x,a,m:longint):longint;
var r:longint;
begin
  r:=1;
  while a&gt;0 do
  begin
    if odd(a) then r:=mulmod(r,x,m);
    a:=a shr 1;
    x:=mulmod(x,x,m);
  end;
  powmod:=r;
end;
 
function isprime(p:longint):boolean;
var q,i,a:longint;
begin
if odd(p) and (p&gt;1) then
begin
  isprime:=true;
  q:=p-1;
  repeat q:=q shr 1; until odd(q);
  for i:=1 to Rounds do
  begin
    {$IFDEF USE32}
         a:=Random(p-2)+2; {$ELSE} a:=2+Trunc(Random*(p-2)); {$ENDIF}
    if powmod(a,p-1,p)&lt;&gt;1 then
    begin
      isprime:=false; break;
    end;
    a:=powmod(a,q,p);
    if a&lt;&gt;1 then
    begin
      while (a&lt;&gt;1) and (a&lt;&gt;p-1) do a:=mulmod(a,a,p);
      if a=1 then
      begin
        isprime:=false; break;
      end;
    end;
  end;
end else isprime:=(p=2);
end;
 
var t:longint;
begin
  Randomize; {Don't forget to reset Random Generator!}
  for t:=1000000000 to 1000100000 do if isprime(t) then writeln(t);
end.
</pre>

<p><a href="https://algolist.manual.ru" target="_blank">https://algolist.manual.ru</a></p>
