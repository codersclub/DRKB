---
Title: Основы 3D-математики - векторные и матричные преобразования
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Основы 3D-математики - векторные и матричные преобразования
============================================================

## Векторы

Вектор - направленный отрезок, имеющий направление и длину.
Векторы обозначаются так: a = (x,y,z), например, b = (0,1,-2).

Еще одно представление вектора: AB = (x,y,z).

    AB = (x,y,z) = (bx-ax,by-ay,bz-az),

где A и B - 2 точки, A(ax,ay,az) и B(bx,by,bz),  
A - начало вектора, B - конец вектора.

**Длина вектора**

Длина вектора, `|a|`, считается так:

    |a| = sqrt(ax2+ay2+az2).

**Сложение векторов.**

    a + b = c;
    a + b = (ax + bx, ay + by, az + bz).

т. е. как результат мы получаем вектор.

**Вычитание векторов.**

    c - a = b;
    c - a = (cx - ax, cy - ay, cz - az).

как результат - также мы получаем вектор.

**Cкалярное произведение векторов.(dot)**

Скалярное произведение 2х векторов - произведение длин 2х векторов на
cos угла между ними **α**. Скалярное произведение векторов - это длина
проекции вектора a на вектор b.

    a . b = |a| |b| cos α;

или

    a . b = axbx + ayby + azbz;

**Следствие:**  
α - угол между двумя векторами:

    cos α = a . b / (|a| |b|);

**Проекция одного вектора на другой.**

Для того, чтобы вычислить проекцию вектора b на вектор а требуется
просто произвести скалярное умножение этих векторов, а затем получить
произведение получившегося результата на вектор b. Обозначим искомый
вектор как c. тогда:

    c = (a . b) b;

фактически, мы находим длину проекции и, умножая ее на вектор, проекцию
которого мы нашли, маштабируем его до нужного размера.

Умножение вектора на вектор.(cross)

Умножая вектор a на вектор b, мы получим вектор, перпендикулярный
плоскости, которую определяют вектора a и b.

    a x b = ( aybz - byaz, azbx - bzax, axby - bxay );

фактически, таким образом находиться вектор нормали к полигонам.

## Матрицы

Здесь я постарался вкратце изложить то, что мы будем делать с матрицами.

**Скалярное произведение векторов:**

    [ a ] [ d ]
    [ b ] * [ f ] = a*d + b*f + c*g
    [ c ] [ g ]

**Векторное произведение:**

    [ a ] [ d ] [ b*f - c*e ]
    AxB = [ b ] x [ e ] = [ c*d - a*f ]
    [ c ] [ f ] [ a*e - b*d ]

**Сложение матриц:**

    [ 1 2 3 ] [ 10 11 12 ] [ 1+10 2+11 3+12 ]
    [ 4 5 6 ] + [ 13 14 15 ] = [ 4+13 5+14 6+15 ]
    [ 7 8 9 ] [ 16 17 18 ] [ 7+16 8+17 9+18 ]

**Умножение матриц:**

    [ 1 2 3 ] [ 10 11 12 ] [ 1*10+2*13+3*16 1*11+2*14+3*17 1*12+2*15+3*18 ]
    [ 4 5 6 ] * [ 13 14 15 ] = [ 4*10+5*13+6*16 4*11+5*14+6*17 4*12+5*15+6*18 ]
    [ 7 8 9 ] [ 16 17 18 ] [ 7*10+8*13+9*16 7*11+8*14+9*17 7*12+8*15+9*18 ]

Очень важным является тот факт, что (A*B)*С = A*(B*C)

## Векторные и матричные преобразования

**Параллельный перенос:**

Переносим точку (x,y,z) на вектор (dx,dy,dz), в результате получим точку
с координатами (x+dx, y+dy, z+dz);

**Поворот:**

Поворачиваем точку (x,y) на угол α :

    x' = x cos α - y*sin α
    y' = x sin α + y*cos α

для трехмерного случая - аналогично для каждой плоскости.

ясно, что если нам потребуется (а нам потребуется :) ) проводить для
каждой точки в пространстве параллельный перенос + поворот в
пространстве, то придеться сделать огромное количество преобразований.

можно построить матрицы преобразований, помножив точку - вектор на
которую, мы получим результат - координаты искомой точки.

матрица параллельного переноса:

    [ 1 0 0 0 ]
    [ 0 1 0 0 ]
    [ 0 0 1 0 ]
    [ x y z 1 ]

матрица растяжения/сжатия:

    [ z 0 0 0 ]
    [ 0 y 0 0 ]
    [ 0 0 x 0 ]
    [ 0 0 0 1 ]

матрица поворота вокруг оси x:

    [ 0   0       0      0 ]
    [ 0   cos α   sin α  0 ]
    [ 0   -sin α  cos α  0 ]
    [ 0   0       0      1 ]

матрица поворота вокруг оси y:

    [ cos α  0  -sin α  0 ]
    [ 0      1  0       0 ]
    [ sin α  0  cos α   0 ]
    [ 0      0  0       1 ]

матрица поворота вокруг оси z:

    [ cos α  sin α  0  0 ]
    [-sin α  cos α  0  0 ]
    [ 0      0      1  0 ]
    [ 0      0      0  1 ]

теперь - зачем нужны матрицы в 3D-програмировании, если можно все
сделать с помощью векторов, и если, например, поворот точки с помощью
векторов занимает меньше операций, чем используя матрицы.

например, мы отодвигаем камеру и поворачиваем ее. для этого требуется
произвести серию операций (переносов, поворотов) с точками (вершинами
полигонов) в 3D-сцене. т.е. для каждой точки произвести сначала
параллельный перенос, а затем - повороты по всем осям. при использовании
векторов мы просто проведем все эти операции отдельно для каждой
точки... что весьма ресурсоемко. или - матричные параллельные переносы,
повороты... еще более ресурсоемко, но вспомним:

    (A*B)*C = A*(B*C)

для матриц.. а нам требуется провести такие преобразования:
a*A*B*C*D, где - а-точка-вектор, над которым требуется произвести
действия, а A,B,C,D - матрицы переноса и поворотов. Мы вполне можем не
последовательно умножать точку-вектор a на матрицы переносов, а сначала
перемножить эти матрицы, а затем просто умножать получившуюся матрицу на
каждую точку, которую требуется сместить - перемножение 4х матриц, а
затем умножение 1 вектора на 1 матрицу на каждую точку по сравнению с
подвержением каждой точки векторным преобразованиям - весьма и весьма
значительное сокращение производимых операций.

