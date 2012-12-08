---
Title: НОД и НОК
Date: 01.01.2007
---


НОД и НОК
=========

::: {.date}
01.01.2007
:::

НОД, решение ax+by=1, нахождение обратного элемента по модулю
![](/pic/embim1817.gif){width="1" height="1"}\
![](/pic/embim1818.png){width="160" height="1"}\
 \

 

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"}
  --- -------------------
  ·   Алгоритм Евклида\
       

  --- -------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"}
  --- ----------------------------
  ·   Бинарный алгоритм Евклида\
       

  --- ----------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"}
  --- --------------------------------------
  ·   Алгоритм решения уравнения ax+by = 1
  --- --------------------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"}
  --- --------------------------------------------------------
  ·   Расширенный алгоритм Евклида:\
      Даны x, y. Находит a, b, v: ax+by = d, где d=НОД(x, y)

  --- --------------------------------------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"}
  --- -----------------------------------------------------------------
  ·   Нахождение обратного элемента по модулю\
      Обратный элемент для x из Zn - такой a из Zn, что ax = 1(mod n)

  --- -----------------------------------------------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"}
  --- ------
  ·   НОК\
       

  --- ------
:::

 \
Алгоритм Евклида. ![](/pic/embim1819.gif){width="1" height="1"}\
![](/pic/embim1820.png){width="160" height="1"}\

 

1\. Вычислим r - остаток от деления числа a на b, a = bq+r, 0 \<= r \< b.

2\. Если r = 0, то b есть искомое число.

3\. Если r =/= 0, то заменим пару чисел (a,b) парой (b,r)\

и перейдем к шагу 1.

    int NOD(int a,int b)
     {
        while(a!=0 && b!=0)
        {
           if(a>=b) a=a%b;
               else b=b%a;
        }
     return a+b; // Одно - ноль
     }

При вычислении наибольшего общего делителя (a,b) с помощью алгоритма
Евклида будет выполнено не более 5p операций деления с остатком, где p
есть количество цифр в десятичной записи меньшего из чисел a и b.

 \
Бинарный алгоритм Евклида. ![](/pic/embim1821.gif){width="1"
height="1"}\
![](/pic/embim1822.png){width="160" height="1"}\

 

Этот алгоритм использует соотношения для НОД:\
 \
НОД(2\*a, 2\*b) = 2\*НОД(a,b)\
НОД(2\*a, b) = НОД(a,b) при нечетном b,\
 \
Он иллюстрируется следующей программой:\

 

      m:= a; n:=b; d:=1;
      {НОД(a,b) = d * НОД(m,n)}
      while not ((m=0) or (n=0)) do begin
        if (m mod 2 = 0) and (n mod 2 = 0) then begin
          d:= d*2; m:= m div 2; n:= n div 2;
        end else if (m mod 2 = 0) and (n mod 2 = 1) then begin
          m:= m div 2;
        end else if (m mod 2 = 1) and (n mod 2 = 0) then begin
          n:= n div 2;
        end else if (m mod 2=1) and (n mod 2=1) and (m>=n)then begin
          m:= m-n;
        end else if (m mod 2=1) and (n mod 2=1) and (m<=n)then begin
          n:= n-m;
        end;
      end;
      {m=0 => ответ=d*n; n=0 =>  ответ=d*m}  

 \
Алгоритм решения уравнения ax+by = 1. ![](/pic/embim1823.gif){width="1"
height="1"}\
![](/pic/embim1824.png){width="160" height="1"}\

 

1.Определим матрицу E:

+-----------------------------------+-----------------------------------+
| E =                               | ( 1 0 )\                          |
|                                   | ( 0 1 )                           |
+-----------------------------------+-----------------------------------+

2\. Вычислим r - остаток от деления числа a на b, a=bq+r, 0 \<= r \< b.

3\. Если r=0, то второй столбец матрицы E даёт вектор ( x, y ) решений
уравнения.

4\. Если r =/= 0, то заменим матрицу E матрицей

+-----------------------------------+-----------------------------------+
| E \*                              | ( 0 1 )\                          |
|                                   | ( 1 -q )                          |
+-----------------------------------+-----------------------------------+

5\. Заменим пару чисел (a,b) на (b,r) и перейдем к шагу 2.

 \
Расширенный алгоритм Евклида. ![](/pic/embim1825.gif){width="1"
height="1"}\
![](/pic/embim1826.png){width="160" height="1"}\

 

Алгоритм Евклида можно расширить так, что он не только даст НОД(a,b)=d,
но и найдет целые числа x и y, такие что ax + by = d.

Псевдокод.

НА ВХОДЕ: два неотрицательных числа a и b: a\>=b

НА ВЫХОДЕ: d=НОД(a,b) и целые x,y: ax + by = d.

1\. Если b=0 положить d:=a, x:=1, y:=0 и возвратить (d,x,y)

2\. Положить x2:=1, x1:=0, y2:=0, y1:=1

3\. Пока b\>0

   3.1 q:=\[a/b\], r:=a-qb, x:=x2-qx1, y:=y2-qy1

   3.2 a:=b, b:=r, x2:=x1, x1:=x, y2:=y1, y1:=y

4\. Положить d:=a, x:=x2, y:=y2 и возвратить (d,x,y)

Исходник на Си.

/\* Author:  Pate Williams (c) 1997 \*/

    #include <stdio.h>
     
    #define DEBUG
     
     
    void extended_euclid(long a, long b, long *x, long *y, long *d)
     
    /* calculates a * *x + b * *y = gcd(a, b) = *d */
     
    {
     
      long q, r, x1, x2, y1, y2;
     
     
      if (b == 0) {
     
        *d = a, *x = 1, *y = 0;
     
        return;
     
      }
     
      x2 = 1, x1 = 0, y2 = 0, y1 = 1;
     
      #ifdef DEBUG
      printf("------------------------------");
      printf("-------------------\n");
      printf("q    r    x    y    a    b    ");
      printf("x2   x1   y2   y1\n");
      printf("------------------------------");
      printf("-------------------\n");
      #endif
     
      while (b > 0) {
     
        q = a / b, r = a - q * b;
     
        *x = x2 - q * x1, *y = y2 - q * y1;
     
        a = b, b = r;
     
        x2 = x1, x1 = *x, y2 = y1, y1 = *y;
     
        #ifdef DEBUG
        printf("%4ld %4ld %4ld %4ld ", q, r, *x, *y);
        printf("%4ld %4ld %4ld %4ld ", a, b, x2, x1);
        printf("%4ld %4ld\n", y2, y1);
        #endif
     
      }
     
      *d = a, *x = x2, *y = y2;
     
      #ifdef DEBUG
      printf("------------------------------");
      printf("-------------------\n");
      #endif
     
    }
     
     
     
    int main(void)
    {
     
      long a = 4864, b = 3458, d, x, y;
     
      extended_euclid(a, b, &x, &y, &d);
     
      printf("x = %ld y = %ld d = %ld\n", x, y, d);
     
      return 0;
    }

Алгоритм работает за O(log2n) операций.

 \
Нахождение обратного элемента по модулю
![](/pic/embim1827.gif){width="1" height="1"}\
![](/pic/embim1828.png){width="160" height="1"}\
 \

 

Для начала заметим, что элемент a кольца Zn обратим тогда и только
тогда, когда НОД(a,n)=1. То есть ответ есть не всегда. Из определения
обратного элемента прямо следует алгоритм.

Псевдокод.

НА ВХОДЕ: а из Zn.

НА ВЫХОДЕ: обратный к а в кольце, если он существует.

1\. Использовать расширенный алгоритм Евклида для нахождения

  x и y, таких что ax + ny = d, где d=НОД(a,n).

2\. Если d \> 1, то обратного элемента не существует.

   Иначе возвращаем x.

Исходник на Си.

    /*  Author:  Pate Williams (c) 1997 */
     
     
    #include <stdio.h>
     
    void extended_euclid(long a, long b, long *x, long *y, long *d)
     
    /* calculates a * *x + b * *y = gcd(a, b) = *d */
     
    {
      long q, r, x1, x2, y1, y2;
     
      if (b == 0) {
     
        *d = a, *x = 1, *y = 0;
     
        return;
      }
     
      x2 = 1, x1 = 0, y2 = 0, y1 = 1;
     
      while (b > 0) {
     
        q = a / b, r = a - q * b;
     
        *x = x2 - q * x1, *y = y2 - q * y1;
     
        a = b, b = r;
     
        x2 = x1, x1 = *x, y2 = y1, y1 = *y;
     
      }
     
      *d = a, *x = x2, *y = y2;
     
    }
     
     
    long inverse(long a, long n)
     
    /* computes the inverse of a modulo n */
     
    {
     
      long d, x, y;
     
     
      extended_euclid(a, n, &x, &y, &d);
     
      if (d == 1) return x;
     
      return 0;
     
    }
     
     
    int main(void)
     
    {
     
      long a = 5, n = 7;
     
     
      printf("the inverse of %ld modulo %2ld is %ld\n", a, n, inverse(a, n));
     
      a = 2, n = 12;
     
      printf("the inverse of %ld modulo %2ld is %ld\n", a, n, inverse(a, n));
     
      return 0;
    }

 \
НОК. ![](/pic/embim1829.gif){width="1" height="1"}\
![](/pic/embim1830.png){width="160" height="1"}\

 

НОК( a , b) = a\*b / НОД(a, b)\

 

<https://algolist.manual.ru>