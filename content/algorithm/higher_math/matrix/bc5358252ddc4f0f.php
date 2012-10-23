<h1>Основы 3D-математики &ndash; векторные и матричные преобразования</h1>
<div class="date">01.01.2007</div>


<p>Векторы</p>

<p>Вектор - направленный отрезок, имеющий направление и длину. Векторы обозначаются так: a = (x,y,z), например, b = (0,1,-2). Еще одно представление вектора : AB = (x,y,z).</p>

<p>AB = (x,y,z) = (bx-ax,by-ay,bz-az),</p>

<p>где A и B - 2 точки, A(ax,ay,az) и B(bx,by,bz), A - начало вектора, B - конец вектора.</p>

<p>Длина вектора</p>

<p>Длина вектора, |a|, считается так:</p>

<p>|a| = sqrt(ax2+ay2+az2).</p>

<p>Сложение векторов.</p>

<p>a + b = c;</p>
<p>a + b = (ax + bx, ay + by, az + bz).</p>

<p>т. е. как результат мы получаем вектор.</p>

<p>Вычитание векторов.</p>

<p>c - a = b;</p>
<p>c - a = (cx - ax, cy - ay, cz - az).</p>

<p>как результат - также мы получаем вектор.</p>

<p>Cкалярное произведение векторов.(dot)</p>

<p>Скалярное произведение 2х векторов - произведение длин 2х векторов на cos угла между ними. Скалярное произведение векторов - это длина проекции вектора a на вектор b.</p>

<p>a . b = |a| |b| cos ?;</p>
<p>или</p>
<p>a . b = axbx + ayby + azbz;</p>

<p>Следствие: ? - угол между двумя векторами: cos ? = a . b / (|a| |b|);</p>

<p>Проекция одного вектора на другой.</p>

<p>Для того, чтобы вычислить проекцию вектора b на вектор а требуется просто произвести скалярное умножение этих векторов, а затем получить произведение получившегося результата на вектор b. Обозначим искомый вектор как c. тогда:</p>

<p>c = (a . b) b;</p>

<p>фактически, мы находим длину проекции и, умножая ее на вектор, проекцию которого мы нашли, маштабируем его до нужного размера.</p>

<p>Умножение вектора на вектор.(cross)</p>

<p>Умножая вектор a на вектор b, мы получим вектор, перпендикулярный плоскости, которую определяют вектора a и b.</p>

<p>a x b = ( aybz - byaz , azbx - bzax , axby - bxay );</p>

<p>фактически, таким образом находиться вектор нормали к полигонам.</p>

<p>Матрицы</p>

<p>Здесь я постарался вкратце изложить то, что мы будем делать с матрицами.</p>
<p>скалярное произведение векторов:</p>

<p>[ a ] [ d ]</p>
<p>[ b ] * [ f ] = a*d + b*f + c*g</p>
<p>[ c ] [ g ]</p>

<p>Векторное произведение:</p>

<p>[ a ] [ d ] [ b*f - c*e ]</p>
<p>AxB = [ b ] x [ e ] = [ c*d - a*f ]</p>
<p>[ c ] [ f ] [ a*e - b*d ]</p>

<p>Сложение матриц:</p>

<p>[ 1 2 3 ] [ 10 11 12 ] [ 1+10 2+11 3+12 ]</p>
<p>[ 4 5 6 ] + [ 13 14 15 ] = [ 4+13 5+14 6+15 ]</p>
<p>[ 7 8 9 ] [ 16 17 18 ] [ 7+16 8+17 9+18 ]</p>

<p>Умножение матриц:</p>

<p>[ 1 2 3 ] [ 10 11 12 ] [ 1*10+2*13+3*16 1*11+2*14+3*17 1*12+2*15+3*18 ]</p>
<p>[ 4 5 6 ] * [ 13 14 15 ] = [ 4*10+5*13+6*16 4*11+5*14+6*17 4*12+5*15+6*18 ]</p>
<p>[ 7 8 9 ] [ 16 17 18 ] [ 7*10+8*13+9*16 7*11+8*14+9*17 7*12+8*15+9*18 ]</p>

<p>Очень важным является тот факт, что (A*B)*С = A*(B*C)</p>

<p>Векторные и матричные преобразования</p>

<p>Параллельный перенос:</p>
<p>Переносим точку (x,y,z) на вектор (dx,dy,dz), в результате получим точку с координатами (x+dx, y+dy, z+dz);</p>

<p>Поворот:</p>
<p>Поворачиваем точку (x,y) на угол ? :</p>

<p>x' = x cos ? - y*sin ?</p>
<p>y' = x sin ? + y*cos ?</p>

<p>для трехмерного случая - аналогично для каждой плоскости.</p>
<p>ясно, что если нам потребуется (а нам потребуется :) ) проводить для каждой точки в пространстве параллельный перенос + поворот в пространстве, то придеться сделать огромное количество преобразований.</p>
<p>можно построить матрицы преобразований, помножив точку - вектор на которую, мы получим результат - координаты искомой точки.</p>

<p>матрица параллельного переноса:</p>

<p>[ 1 0 0 0 ]</p>
<p>[ 0 1 0 0 ]</p>
<p>[ 0 0 1 0 ]</p>
<p>[ x y z 1 ]</p>

<p>матрица растяжения/сжатия:</p>

<p>[ z 0 0 0 ]</p>
<p>[ 0 y 0 0 ]</p>
<p>[ 0 0 x 0 ]</p>
<p>[ 0 0 0 1 ]</p>

<p>матрица поворота вокруг оси x:</p>

<p>[ 0 0 0 0 ]</p>
<p>[ 0 cos ? sin ? 0 ]</p>
<p>[ 0 -sin ? cos ? 0 ]</p>
<p>[ 0 0 0 1 ]</p>

<p>матрица поворота вокруг оси y:</p>

<p>[ cos ? 0 -sin ? 0 ]</p>
<p>[ 0 1 0 0 ]</p>
<p>[ sin ? 0 cos ? 0 ]</p>
<p>[ 0 0 0 1 ]</p>

<p>матрица поворота вокруг оси z:</p>

<p>[ cos ? sin ? 0 0 ]</p>
<p>[-sin ? cos ? 0 0 ]</p>
<p>[ 0 0 1 0 ]</p>
<p>[ 0 0 0 1 ]</p>

<p>теперь - зачем нужны матрицы в 3D-програмировании, если можно все сделать с помощью векторов, и если, например, поворот точки с помощью векторов занимает меньше операций, чем используя матрицы.</p>

<p>например, мы отодвигаем камеру и поворачиваем ее. для этого требуется произвести серию операций (переносов, поворотов) с точками (вершинами полигонов) в 3D-сцене. т.е. для каждой точки произвести сначала параллельный перенос, а затем - повороты по всем осям. при использовании векторов мы просто проведем все эти операции отдельно для каждой точки... что весьма ресурсоемко. или - матричные параллельные переносы, повороты.... еще более ресурсоемко, но вспомним:</p>

<p>(A*B)*C = A*(B*C)</p>

<p>для матриц.. а нам требуется провести такие преобразования: a*A*B*C*D, где - а-точка-вектор, над которым требуется произвести действия, а A,B,C,D - матрицы переноса и поворотов. Мы вполне можем не последовательно умножать точку-вектор a на матрицы переносов, а сначала перемножить эти матрицы, а затем просто умножать получившуюся матрицу на каждую точку, которую требуется сместить - перемножение 4х матриц, а затем умножение 1 вектора на 1 матрицу на каждую точку по сравнению с подвержением каждой точки векторным преобразованиям - весьма и весьма значительное сокращение производимых операций.</p>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
