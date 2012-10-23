<h1>OpenGL для начинающих</h1>
<div class="date">01.01.2007</div>

<p>*************************************<br>
************ Часть I ****************<br>
*************************************<br>
&nbsp;<br>
00 Введение<br>
===========<br>
&nbsp;<br>
Решив разобраться с OpenGL и просмотрев DRBK, я увидел печальную картину - <br>
то что там есть никак не дает пинка в нужном направлении для написания программ,<br>
использующих OpenGL. Ниже я постарался собрать в пучок результаты моих <br>
исследований и получил этот текст и MyOpenGL.pas. <br>
&nbsp;<br>
Я совсем не претендую на правильность терминов в описании и на то, как надо <br>
писать OpenGL-программы. Но простую OpenGL-программу вы точно сможете написать, <br>
использовав MyOpenGL.pas, после прочтения нижеследующего, как на VCL, так и на <br>
чистом WinAPI.<br>
&nbsp;<br>
Может кому пригодится для начала - написанное достаточно просто &gt;:-)<br>
&nbsp;<br>
Были использованы следующие источники<br>
* Исходники Jan Horn (http://www.sulaco.co.za, http://home.global.co.za/~jhorn)<br>
В частности Skyboxes и Гаусово размытие. Второе уже есть в DRKB без имени автора<br>
Работа с графикой и мультимедиа &gt; DerectX, OpenGL &gt; OpenGL - радиальное размытие <br>
(названия функций, основа программы и много другое взяты оттуда).<br>
* Учебник по OpenGL (главы 1.3, 1.5) с www.ru-coding.com.<br>
* MS SDK &gt; OpenGL Programmer's Reference, поставляемый вместе с Delphi <br>
(общая справка)<br>
* модуль EasyGL.pas Данилова Андрея (http://dasoft.land.ru)<br>
(своровал пару идей по оформлению VCL).<br>
* Статья по рисованию вращающего сердечка на OpenGL (не помню где брал).<br>
* Перевод Народного учебника по OpenGL от NeHe (http://nehe.gamedev.net). <br>
Брать тут - http://pmg.org.ru/nehe/nehehtml.zip<br>
(ну очень хороший учебник, хоть и на C; must see).<br>
&nbsp;<br>
01 Контексты устройства и воспроизведения<br>
=========================================<br>
&nbsp;<br>
"DC (Device Context - контекст устройства). Это то, на чём мы рисуем, <br>
и в Delphi контекст устройства представлен как TCanvas" (см. 1)<br>
<p>Получить его можно следующим образом</p>
<pre>var
 DC: hDC;
...
 DC := GetDC(Form1.Hanle);
или
 DC := Form1.Canvas.Handle;
</pre>
<p>&nbsp;<br>
"Графическая система OpenGL, как и любое другое приложение Windows, также нуждается <br>
в ссылке на окно, на котором будет осуществляться воспроизведение - специальной <br>
ссылке на контекст воспроизведения - величина типа HGLRC (Handle openGL Rendering <br>
Context, ссылка на контекст воспроизведения OpenGL). Для получения этого контекста <br>
OpenGL нуждается в величине типа HDC (контекст воспроизведения) окна, на который <br>
будет осуществляться вывод."<br>
Создать его можно следующим образом<br>
<p>&nbsp;</p>
<pre>uses OpenGL;
...
var
  DC: hDC;
  RC: hGLRC;
...
  DC := GetDC(Form1.Handle);   // получаем контекст устройства
  SetDCPixelFormat(DC);        // устанавливаем формат точки (см. 2)
  RC := wglCreateContext(DC);  // создать новый контекст воспроизведения
  wglMakeCurrent(DC, RC);      // устанавливаем его текущим
</pre>

<p>&nbsp;<br>
Здесь SetDCPixelFormat(DC) самописная функция, код см. в MyOpenGL.pas.<br>
&nbsp;<br>
Дополнительно <br>
1. Работа с графикой и мультимедиа &gt; GDI - графика в Delphi<br>
2. Работа с графикой и мультимедиа &gt; DerectX, OpenGL &gt; Работа с OpenGL - Введение <br>
3. Работа с графикой и мультимедиа &gt; DerectX, OpenGL &gt; Работа с OpenGL - Минимальная программа <br>
&nbsp;<br>
02 Инициализация и завершение работы с OpenGL<br>
=============================================<br>
&nbsp;<br>
Поскольку часть операций при инициализации зависит от размеров окна и должна повторяться<br>
при каждом изменении размеров окна, то эта часть вынесена в отдельную процедуру, которая <br>
выполняется при инициализации и при изменении размеров окна.<br>
<p>&nbsp;</p>
<pre>{------------------------------------------------------------------}
{  Инициализация OpenGL                                            }
{------------------------------------------------------------------}
procedure glInit(Wnd: hWND);
const
  // Константы, задающие свойства материала фигур
  mat1_amb : array [0..2] of Single = (0.2, 0.2, 0.2);
  mat1_dif : array [0..2] of Single = (0.8, 0.8, 0.0);
  mat1_spec: array [0..2] of Single = (0.6, 0.6, 0.6);
  mat1_shininess = 10;
 
  // Константы для источника света
  light_pos  : array [0..3] of glFloat=(100.0, 100.0, 0.0, 1.0);
  light_amb  : array [0..3] of glFloat=(0.6, 0.6, 0.6, 1.0);
  light_dif  : array [0..3] of glFloat=(1.0, 1.0, 1.0, 1.0);
  light_spec : array [0..3] of glFloat=(1.0, 1.0, 1.0, 1.0);
  light_spot_direction : array [0..3] of glFloat=(1.0, 1.0, 1.0, 1.0);
 
  // Цвет тумана
  fogColor: array [0..3] of GLfloat = (0, 1.0, 0, 1.0);
var
  fogMode: GLint;
begin
  // Инициализация контекста воспроизведения OpenGL
  DC := GetDC(Wnd);            // Получить контекст устройства для окна
  SetDCPixelFormat(DC);        // Установить формата пикселов
  RC := wglCreateContext(DC);  // создать новый контекст воспроизведения
  wglMakeCurrent(DC, RC);      // Установить его текущим
 
  // Свойства материала для режима glEnable(GL_COLOR_MATERIAL)
  glMaterialfv(GL_FRONT, GL_AMBIENT,  @mat1_amb);
  glMaterialfv(GL_FRONT, GL_DIFFUSE,  @mat1_dif);
  glMaterialfv(GL_FRONT, GL_SPECULAR, @mat1_spec);
  glMaterialf (GL_FRONT, GL_SHININESS,mat1_shininess);
 
  // Свойства источника света GL_LIGHT1 для режима glEnable(GL_LIGHTING)
  // Стандартный источник одна команда:  glEnable(GL_LIGHT0);
  glLightfv(GL_LIGHT1, GL_POSITION,@light_pos);
  glLightfv(GL_LIGHT1, GL_AMBIENT, @light_amb);    // направленность
  glLightfv(GL_LIGHT1, GL_DIFFUSE, @light_dif);    // рассеивание
  glLightfv(GL_LIGHT1, GL_SPECULAR, @light_spec);
  glLightfv(GL_LIGHT1, GL_SPOT_DIRECTION, @light_spot_direction);
  // разрешить источник света GL_LIGHT1
  glEnable(GL_LIGHT1);
 
  // Свойства тумана для режима glEnable(GL_FOG)
  fogMode := GL_EXP;                     // GL_EXP2, GL_LINEAR
  glFogi(GL_FOG_MODE, fogMode);          // установить режим
  glFogfv(GL_FOG_COLOR, @fogColor);      // цвет тумана
  glFogf(GL_FOG_DENSITY, 0.002);         // плотность  - 0.2%
  glHint(GL_FOG_HINT, GL_DONT_CARE);     // GL_NICEST, GL_FASTEST.
 
  glClearColor(0.0, 0.0, 0.2, 1.0);      // Установить цвет фона - синий
  glClearDepth(1.0);                     // Очистить буфер глубины
  glDepthFunc(GL_LESS);                  // Тип теста глубины
  glShadeModel(GL_SMOOTH);               // плавное цветовое сглаживание
 
 
  // glEnable(..) - включить режим, glDisable(..) - отключить
  glEnable(GL_LIGHTING);                 // разрешить осещенность
  //glEnable(GL_FOG);                    // разрешить тумана
  glEnable(GL_DEPTH_TEST);               // разрешить тест глубины, с использованием
                                         // функции определенной в glDepthFunc
  glEnable(GL_NORMALIZE);                // разрешить нормали (различение передней
                                         // и задней сторон плоских объектов)
  glEnable(GL_COLOR_MATERIAL);           // разрешить использование материалов на объектах
  glEnable(GL_TEXTURE_2D);               // разрешить наложение текстур
  //glEnable(GL_BLEND);                  // разрешить смешивание (напр. прозрачность)
                                         // не совместимо с glEnable(GL_DEPTH_TEST)
  glLoadTexture('1.bmp', Texture);       // загружаем текстуру
end;
 
 
{------------------------------------------------------------------}
{  Обработчик на изменение размеров окна                           }
{------------------------------------------------------------------}
procedure glOnResize(Width, Height: Integer);
begin
  if (Height = 0) then Height := 1;        // Предупреждаем деление на 0
  glViewport(0, 0, Width, Height);         // Устанавливаем область отображения
                                           // на все окно
  // Настройка матрицы проекции
  glMatrixMode(GL_PROJECTION);             // Выбираем матрицу проекции
  glLoadIdentity();                        // Устанавливаем ее единичной
  // Устанавливаем тип проеции - Ортогональный
  glOrtho(-Width div 2, Width div 2, -Height div 2, Height div 2, -800, 800); 
 
  // Настройка видовой матрицы
  glMatrixMode(GL_MODELVIEW);              // Выбираем матрицу проекции
  glLoadIdentity();                        // Устанавливаем ее единичной
end;
</pre>
<br>
Инициализация OpenGL производится последовательным вызовом этих двух процедур - <br>
сначала gLInit (в ее начале происходит создание контекста воспроизведения, упомянутого<br>
в первой главе), а потом glOnResize.<br>
Отмечу, что включение/выключение режимов можно делать когда угодно, а не только при<br>
инициализации.<br>
&nbsp;<br>
<p>Завершение работы с OpenGL проводит функция glKill.</p>
<pre>{------------------------------------------------------------------}
{  Завершение работы с OpenGL                                      }
{------------------------------------------------------------------}
procedure glKill(Wnd: hWND);
begin
  wglMakeCurrent(DC, 0);
  wglDeleteContext(RC);
  ReleaseDC(Wnd, DC);
end;
</pre>

<p>&nbsp;<br>
&nbsp;<br>
03 Создание и рисование примитивов<br>
==================================<br>
&nbsp;<br>
Ниже будет описан процесс отрисовки, использующий таймер. <br>
&nbsp;<br>
Сначала подготавливаем объекты сцены процедурой сферу и треугольник, а<br>
потом командой SwapBuffers(..) выводим сцену на экран.<br>
Для улучшения понимания здесь порезанный вариант MyOpenGL.glDraw.<br>
<p>&nbsp;</p>
<pre>{------------------------------------------------------------------}
{  Создание объектов под отрисовку                                 }
{------------------------------------------------------------------}
procedure glDraw();
var
  Obj: GLUquadricObj;
begin
  // очистка Экрана и буфера глубины
  glClear(GL_COLOR_BUFFER_BIT or GL_DEPTH_BUFFER_BIT);
 
  ...
 
  // Пример рисования разноцветного треугольника
  glBegin(GL_POLYGON);
    glColor(0.0, 0.5, 0.0, 0.0);
    glVertex3F(-50, -sqrt(3)*50, 0);        // 1-я вершина
    glColor(0.5, 0.0, 0.0, 0.0);
    glVertex3F(-100, -sqrt(3)*100, 0);      // 2-я вершина
    glColor(0.0, 0.0, 0.5, 0.0);
    glVertex3F(-125, -sqrt(3)*100, 0);      // 3-я вершина
  glEnd;
 
  ...
 
  // Пример рисования сферы
  glColor(1.0, 1.0, 1.0, 0.5);           // установить цвет объекта
  Obj := gluNewQuadric;
  gluSphere(Obj, 100, 25, 25);           // создать сферу  R = 100, детализация - 25х25
 
  ...
 
  // Выводим на экран подготовленную сцену
  SwapBuffers(DC);
end;
</pre>

<p>&nbsp;<br>
&nbsp;<br>
По таймеру выполняем<br>
<p>&nbsp;</p>
<pre>  glDraw();
</pre>
<p>&nbsp;<br>
gluNewQuadric используется для создания объемных фигур одной командой<br>
<p>&nbsp;</p>
<pre>var
  Obj : GLUquadricObj;
...
  Obj := gluNewQuadric;
  // Режимы отображения фигуры
  gluQuadricDrawStyle(Obj, GLU_FILL);            // GLU_POINT, GLU_LINE, GLU_SILHOUETTE  
  gluQuadricOrientation (Obj, GLU_INSIDE);       // GLU_OUTSIDE
  gluQuadricNormals (Obj, GLU_SMOOTH);           // - нормаль для каждой точки
                                                 // GLU_FLAT - для сегмента
                                                 // GLU_NONE - не строить нормалей 
  gluQuadricTexture(Obj, GL_TRUE);               // - разрешить наложение текущей текстуры
  // Создание фигуры 
  gluSphere(Obj, 100, 25, 25);                   // сфера  R = 100, детализация - 25х25
или
  gluCylinder(Obj, 10, 100, 150, 30, 1);         // цилиндр - R0 = 10, R1 = 100, H = 150, детализация - 30 плоскостей
или
  gluDisk(Obj, 10, 100, 30, 1);                  // Диск - R0 = 10, R1 = 100, детализация - 100
или  
  gluPartialDisk(Obj, 10, 100, 30, 100, 0, 120); // треть диска с параметрами как у верхнего
...
  //Освобождаем память
  gluDeleteQuadric(Obj);
</pre>

<p>&nbsp;<br>
&nbsp;<br>
Quadric-объекты являются надстройкой над конструкцией glBegin-glEnd.<br>
Для glBegin определены следующие константы<br>
(подробнее см. SDK OpenGL)<br>
GL_POINTS - последовательность точек<br>
GL_LINES - линии (пара точек; пара точек) <br>
GL_LINE_STRIP - ломаная (аналог последовательности lineto)<br>
GL_LINE_LOOP - замкнутая <br>
GL_TRIANGLES - треугольник<br>
GL_TRIANGLE_STRIP - объединенная группа треугольников<br>
GL_TRIANGLE_FAN<br>
GL_QUADS - четырехугольник<br>
GL_QUAD_STRIP - объединенная группа четырехугольников<br>
GL_POLYGON - плоский полигон <br>
Так же стоит обратить внимание на glPolygonMode, позволяющий по различному отображать<br>
строемую фигуру (см. код для Quadric)<br>
&nbsp;<br>
04 Преобразования координат и проекции<br>
======================================<br>
<p>&nbsp;</p>
<p>Цитата </p>
<p>&nbsp;<br>
Q: Возникла такая ситуация. Есть несколько объектов. Hyжно повеpнyть<br>
некотоpые из них. Функция glRotate() повоpачивает всю сценy. Сyществyет<br>
ли функция, котоpая повоpачивает только некотоpые (не все) вершины?<br>
&nbsp;<br>
&nbsp;<br>
"Для задания различных преобразований объектов сцены в OpenGL используются <br>
операции над матрицами, при этом различают три типа матриц: видовая, проекций <br>
и текстуры. Все они имеют размер 4x4"<br>
&nbsp;<br>
В каждый момент можем работать только с одним из типов матрицы. Выбрать нужную <br>
можно следующим образом<br>
<p>&nbsp;</p>
<pre>  // mode = 
  // GL_MODELVIEW  - выбрать видовую матрицу
  // GL_PROJECTION - выбрать матрицу проекций
  // GL_TEXTURE    - выбрать матрицу текстур  
  glMatrixMode(&lt;mode&gt;);
</pre>

<p>&nbsp;<br>
&nbsp;<br>
По умолчанию все матрицы нулевые, поэтому при инициализации их заполняем,<br>
разумеется выбрав сначала тип матрицы.<br>
Можно заполнить какой-то конкретной или просто единичной, как в MyOpenGL.glInit.<br>
<p>(Единичная - это та, у которой на диагонали единицы, а остальные нули).</p>

<p>  // отличие glLoadMatrixf от glLoadMatrixg заключается в том, как будет </p>
<p>  // восприниматься входной массив, определяющий матрицу</p>
<p>  // так - &lt;строка1&gt;, &lt;строка2&gt;, &lt;строка3&gt;, &lt;строка4&gt;</p>
<p>  // или так - &lt;столбец1&gt;, &lt;столбец2&gt;, &lt;столбец3&gt;, &lt;столбец4&gt; </p>
<p>  glLoadMatrixf(&lt;указатель на массив из 16 элементов типа double&gt;); </p>
<p>или</p>
<p>  glLoadMatrixg(&lt;указатель на массив из 16 элементов типа double&gt;); </p>
<p>или</p>
<p>  glLoadIdentity();&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // заполнение единичной</p>
<p>&nbsp;<br>
&nbsp;<br>
" Часто нужно сохранить содержимое текущей матрицы для дальнейшего использования, <br>
<p>для чего используют команды"</p>
<p>  glPushMatrix();&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // сохранить матрицу (в стеке)&nbsp; </p>
<p>  glPopMatrix();&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // извлечь матрицу (из стека)</p>
<p>Вспоминаем, что такое стек )<br>
Для GL_MODELVIEW-матриц глубина стека не менее 32, для других типов не менее 2. <br>
&nbsp;<br>
Далее попробую объяснить для чего нужны различные матрицы и как их использовать.<br>
Итак, задача такова, что надо создать трехмерную фигуру, изменить ее и потом <br>
отобразить на плоскость окна. Реализация OpenGL такова, что при этом имеем четыре<br>
перехода из одних координат в другие.<br>
Координаты объекта (4D) =&gt; Видовые координаты (4D) =&gt; Усеченные координаты (4D) =&gt; <br>
Нормализованные координаты (3D) =&gt; Оконные координаты (2D)<br>
(4D - это точка имеет 4 координаты, первые 3 - ее 3D координаты, последняя <br>
дополнительная составляющая).<br>
Переход от координат объекта к видовым осуществляется при использовании GL_MODELVIEW<br>
матрицы. По видовым координатам вычисляются усеченные координаты, используя GL_PROJECTION <br>
матрицу (название усеченные координаты идет от того, что для любой точки фигуры <br>
(x1, x2, x3, x4), верно -1 &lt;= x_i &lt;= 1, то есть GL_PROJECTION матрица отображает фигуру <br>
в 4D-куб c длиной стороны 2 и центром в (0, 0, 0, 0)). Нормализванные координаты <br>
получаются из усеченных следующим преобразованием <br>
(x1', x2', x3') = (x1/x4, x2/x4, x3/x4).<br>
Размер окна, куда будет отображаться фигура заданная в нормализованных координатах, <br>
определяется функцией glViewPort. <br>
&nbsp;<br>
<p>Теперь, думаю, код glOnResize достаточно понятен.</p>
<pre>  // 1
  glViewport(0, 0, Width, Height);         // Устанавливаем область отображения
                                           // на все окно
  // 2
  // Настройка матрицы проекции
  glMatrixMode(GL_PROJECTION);             // Выбираем матрицу проекции
  glLoadIdentity();                        // Устанавливаем ее единичной
  // Устанавливаем тип проеции - Ортогональный
  glOrtho(-Width div 2, Width div 2, -Height div 2, Height div 2, -800, 800); 
 
  // 3
  // Настройка видовой матрицы
  glMatrixMode(GL_MODELVIEW);              // Выбираем матрицу проекции
  glLoadIdentity();                        // Устанавливаем ее единичной
</pre>

<p>&nbsp;<br>
Блоки 1, 2 и 3 можно менять местами. Единственное отличие, если поменять местами 2 и 3, то<br>
что текущая матрица будет не GL_MODELVIEW, а GL_PROJECTION.<br>
&nbsp;<br>
Примечание: GL_PROJECTION матрицу лучше выбирать так, чтобы <br>
* GL_MODELVIEW была единичной;<br>
* исходные размеры объекта были в пределах отрезка [-1; 1].<br>
<p>&nbsp;</p>
<p>Цитата </p>
<p>&nbsp;<br>
A: Для того, чтобы пpименить pазные пpеобpазования к pазным объектам сцены, надо<br>
<p>делать так:</p>
<p>  glMatrixMode(GL_MODELVIEW);</p>
<p>  glLoadIdentity();</p>
<p>  glRotate, glScale, glTranslate // ... --- в общем, всё что нyжно...</p>
<p>&nbsp;<br>
Затем pисyешь объекты...<br>
<p>После того, как наpисовал, yказываешь новое пpеобpазование:</p>
<p>  glLoadIdentity(); glRotate, glScale, glTranslate // ...</p>
<p>&nbsp;<br>
Снова pисyешь объекты. И так повтоpяешь, сколько надо.<br>
&nbsp;<br>
&nbsp;<br>
<p>А теперь все это так, как было бы в коде (напр. в MyOpenGL.glDraw)</p>
<pre>  // Указываем, что работать будем с видовой матрицей
  // Если она и так была текущей, то можно не выполнять 
  glMatrixMode(GL_MODELVIEW);
  // Сбрасываем до единичной
  // (Считаем, что GL_PROJECTION подобрана, как указано выше)
  glLoadIdenty(); 
  glTranslatef(100.0, 0.0, 0.0);  // Добавим к матрице перенос на 100 вдоль ОХ
  glPushMatrix;                   // сохраняем матрицу в стек - она нам еще понадобится
  ...
  // Рисуем какую-нить фигуру1
  ...
  glRotate (-90, 0.0 , 1.0, 0.0); // Поворот на -90 градусов вокруг оси OY
  glRotate(60, 1.0, 0.0, 0.0);    // Поворот на 60 градусов вокруг оси OX.   
  ...
  // Рисуем фигуру2
  ...
  glPopMatrix;                    // восстанавливаем матрицу из стека
  ...
  glTranslatef(0.0, 10.0, 0.0);   // двигаем на 10 по оси OX
  ...
  // Рисуем фигуру3
  ...
</pre>

<p>&nbsp;<br>
После этого имеем - фигура1 перенесена от центра на 100 по оси ОХ. Фигура2 имеет <br>
матрицу - соответствующую следующим последовательным действиям: перенос на 100, поворот, <br>
поворот. glPopMatrix - возвращает нас к исходной матрице, содержащей только перенос на 100, <br>
потому GL_MODELVIEW-матрица у фигуры3 - это перенос на 100 + перенос на 10 по оси ОY.<br>
Вообще говоря, последовательность неких действий - это домножение исходной матрицы на<br>
матрицы, отвечающие этим действиям. Поскольку умножение матриц некоммуникативно (AB &lt;&gt; BA),<br>
то и при смене чередовании элементов последовательности, получим другой результат. <br>
&nbsp;<br>
Дополнительно - www.ru-coding.com/ogl_1_3.php<br>
&nbsp;<br>
04а GL_PROJECTION<br>
=================<br>
&nbsp;<br>
Считаем, что GL_MODELVIEW матрица единичная.<br>
&nbsp;<br>
Задание матрицы проекции, которое могло быть напр. в MyOpenGL.glOnResize<br>
Перспективная проекция<br>
<p>&nbsp;</p>
<pre>  glFrustum( - Width div 2, Width div 2, - Height div 2, Height div 2, 100, 300);
  glTranslatef(0, 0, -200);
</pre>

<p>&nbsp;<br>
&nbsp;<br>
Ортогональная проекция<br>
<p>&nbsp;</p>
<pre>  glOrtho(- Width div 2, Width div 2, -Height div 2, Height div 2, -800, 800);
</pre>

<p>&nbsp;<br>
&nbsp;<br>
Примерный смысл для параметров команд glFrustum и glOrtho. <br>
Первые четыре, расписанные как (left, top) и (right, bottom) определяют прямоугольник.<br>
Лучше представить его как окно, через которое мы смотрим на мир (т. е. на группу объектов,<br>
которые были получены при преобразовании их исходных координат их GL_MODELVIEW-матрицами). <br>
Чем оно больше (больше значения параметров), тем больше объекты (по размерам) можем <br>
видеть (по другому - как будто отходим назад от объектов). При симметричных координатах - <br>
смотрим на центр.<br>
Если провести через все углы линии ортогональные прямоугольнику, то высекаемый ими объем <br>
будет тем, что мы видим в мире. Поскольку объекты в бесконечности никого не интересуют <br>
(напр. не видны из-за малого размера при перспективной проекции), то логично ввести <br>
плоскость, параллельную плоскости окна и если объект оказался за ней, то забыть о его <br>
существовании - это сильно упрощает OpenGL расчеты. Логично ввести такую же плоскость и <br>
для объектов сблизи (хотя бы из соображений симметрии ;-)), т. е. если объект ближе чем <br>
она, то он не выводится. Пятый и шестой параметры - как раз и задают расположение второй <br>
и первой плоскости: при перспективной проекции - как растояние от окна до требуемых <br>
плоскостей (следствие: всегда пятый параметр меньше шестого и оба больше 0), при <br>
ортогональной - расстояние от начала координат (поскольку при ортогональной проекции <br>
нет искажении из-за того как далеко от нас находится центр, то можно представить его <br>
где-либо перед нами и соответсвенно задать координаты плоскостей отсечения).<br>
Если мы рисуем объекты вокруг центра координат, напр. так создаются Quadric-объекты, то <br>
для перспективной проекции также надо добавить сдвиг, помещающий центр координат МЕЖДУ<br>
плоскостями отсечения (этот же сдвиг можно сделать и в GL_MODELVIEW матрице). <br>
Для ортогональной этого делать не надо - центр и так где-то перед нами.<br>
Другой способ задавать перспективную проекцию - это воспользоваться gluPerspective. <br>
Примечание: чем меньше расстояние между плоскостями отсечения, тем быстрее все считается. <br>
&nbsp;<br>
05 Текструры<br>
============<br>
&nbsp;<br>
Текстуру сначала надо загрузить и получить ее идентификатор (хендл). <br>
перед созданием объекта текстура выбирается по своему идентификатору<br>
(делается текущей) и автоматом прилепляется к объекту (GLUquadricObj).<br>
<p>&nbsp;</p>
<pre>uses 
  OpenGL;
...
var
  Texture: glUint; 
...
// функция для установки текущей текстуры по идентификатору texture
// в openGL.pas ее почему то нет :(, потому импортируем
procedure glBindTexture(target: GLenum; texture: GLuint); stdcall; external opengl32;
...
// Где-то вначале программы, перед использованием glDraw
LoadTexture('1.bmp', Texture);
...
{------------------------------------------------------------------}
{  Создание объектов под отрисовку                                 }
{------------------------------------------------------------------} 
procedure glDraw();
var
  Obj : GLUquadricObj;
begin
  ...
  // 1-ый вариант
  glBindTexture(GL_TEXTURE_2D, Texture); // устанавливаем текущую текстуру Texture
  Obj:=gluNewQuadric;
  gluQuadricTexture(Obj, GL_TRUE);       // при создании объекта наложить текущую текстуру
  gluSphere(Obj, 100, 25, 25);           // создать сферу  R = 100, детализация - 25х25
  ...
или так
  ...
  // 2-ой вариант
  glBindTexture(GL_TEXTURE_2D, Texture); // устанавливаем текущую текстуру Texture
  // Рисуем фигуру, на которую наложится текстура при помощи glTexCoord2f
  glBegin(GL_QUADS);
    glNormal3f( 0.0, 0.0, 1.0);
    // 1-я точка текстуры + 1-я точка объекта
    glTexCoord2f(0.0, 0.0); 
    glVertex3f(-100.0, -100.0,  0.0);  
    // 3-я точка текстуры + 2-я точка объекта
    glTexCoord2f(1.0, 0.0); 
    glVertex3f( 100.0, -100.0,  0.0);
    // 3-я точка текстуры + 3-я точка объекта
    glTexCoord2f(1.0, 1.0); 
    glVertex3f( 100.0,  100.0,  0.0);
    // 1-я точка текстуры + 1-я точка объекта
    glTexCoord2f(0.0, 1.0); 
    glVertex3f(-100.0,  100.0,  0.0);
  glEnd();
</pre>
<br>
При этом должен быть разрешен режим наложения текстур (по умолчанию - отключен) <br>
<p>&nbsp;</p>
<p>  glEnable(GL_TEXTURE_2D);</p>
<p>&nbsp;<br>
&nbsp;<br>
Примечание:<br>
Функция MyOpenGL.glLoadTexture поддерживает загрузку только 8 и 24-битных изображений. <br>
&nbsp;<br>
Дополнительно<br>
www.ru-coding.com/ogl_1_5.php<br>
&nbsp;<br>
06 Unit MyOpenGL.pas<br>
====================<br>
<p>&nbsp;</p>
<pre>unit MyOpenGL;
 
interface
 
uses windows, OpenGL;
 
procedure glOnResize(Width, Height : Integer);
procedure glInit(Wnd: hWND);
procedure glKill(Wnd: hWND);
procedure glDraw();
procedure glLoadTexture(Filename: String; var Texture: GLuint);
 
implementation
 
procedure glBindTexture(target: GLenum; texture: GLuint); stdcall; external opengl32;
function  gluBuild2DMipmaps(Target: GLenum; Components, Width, Height: GLint; Format, atype: GLenum; Data: Pointer): GLint; stdcall; external glu32;
procedure glGenTextures(n: GLsizei; var textures: GLuint); stdcall; external opengl32;
procedure SetDCPixelFormat(DC: hDC); forward;
 
var
  DC: hDC;                                 // контекст устройства
  RC: hGLRC;                               // контекст воспроизведения
  Texture: GLuint;                         // хэндл текстуры
  Angle: Integer = 0;                      // угол поворота сферы
 
{------------------------------------------------------------------}
{  Обработчик на изменение размеров окна                           }
{------------------------------------------------------------------}
procedure glOnResize(Width, Height: Integer);
begin
  if (Height = 0) then Height := 1;        // Предупреждаем деление на 0
  glViewport(0, 0, Width, Height);         // Устанавливаем область отображения
                                           // на все окно
  // Настройка матрицы проекции
  glMatrixMode(GL_PROJECTION);             // Выбираем матрицу проекции
  glLoadIdentity();                        // Устанавливаем ее единичной
  // Устанавливаем тип проеции - Ортогональный
  glOrtho(-Width div 2, Width div 2, -Height div 2, Height div 2, -800, 800);
 
  // Настройка видовой матрицы
  glMatrixMode(GL_MODELVIEW);              // Выбираем матрицу проекции
  glLoadIdentity();                        // Устанавливаем ее единичной
end;
 
{------------------------------------------------------------------}
{  Инициализация OpenGL                                            }
{------------------------------------------------------------------}
procedure glInit(Wnd: hWND);
const
  // Константы, задающие свойства материала фигур
  mat1_amb : array [0..2] of Single = (0.2, 0.2, 0.2);
  mat1_dif : array [0..2] of Single = (0.8, 0.8, 0.0);
  mat1_spec: array [0..2] of Single = (0.6, 0.6, 0.6);
  mat1_shininess = 10;
 
  // Константы для источника света
  light_pos  : array [0..3] of glFloat = (100.0, 100.0, 0.0, 1.0);
  light_amb  : array [0..3] of glFloat = (0.6, 0.6, 0.6, 1.0);
  light_dif  : array [0..3] of glFloat = (1.0, 1.0, 1.0, 1.0);
  light_spec : array [0..3] of glFloat = (1.0, 1.0, 1.0, 1.0);
  light_spot_direction : array [0..3] of glFloat = (1.0, 1.0, 1.0, 1.0);
 
  // Цвет тумана
  fogColor: array [0..3] of GLfloat = (0, 1.0, 0, 1.0);
var
  fogMode: GLint;
begin
  // Инициализация контекста воспроизведения OpenGL
  DC := GetDC(Wnd);            // Получить контекст устройства для окна
  SetDCPixelFormat(DC);        // Установить формата пикселов
  RC := wglCreateContext(DC);  // создать новый контекст воспроизведения
  wglMakeCurrent(DC,RC);       // Установить его текущим
 
  // Свойства материала для режима glEnable(GL_COLOR_MATERIAL)
  glMaterialfv(GL_FRONT, GL_AMBIENT,  @mat1_amb);
  glMaterialfv(GL_FRONT, GL_DIFFUSE,  @mat1_dif);
  glMaterialfv(GL_FRONT, GL_SPECULAR, @mat1_spec);
  glMaterialf (GL_FRONT, GL_SHININESS,mat1_shininess);
 
  // Свойства источника света GL_LIGHT1 для режима glEnable(GL_LIGHTING)
  // Стандартный источник одна команда:  glEnable(GL_LIGHT0);
  glLightfv(GL_LIGHT1, GL_POSITION,@light_pos);
  glLightfv(GL_LIGHT1, GL_AMBIENT, @light_amb);    // направленность
  glLightfv(GL_LIGHT1, GL_DIFFUSE, @light_dif);    // рассеивание
  glLightfv(GL_LIGHT1, GL_SPECULAR, @light_spec);
  glLightfv(GL_LIGHT1, GL_SPOT_DIRECTION, @light_spot_direction);
  // разрешить источник света GL_LIGHT1
  glEnable(GL_LIGHT1);
 
  // Свойства тумана для режима glEnable(GL_FOG)
  fogMode := GL_EXP;                     // GL_EXP2, GL_LINEAR
  glFogi(GL_FOG_MODE, fogMode);          // установить режим
  glFogfv(GL_FOG_COLOR, @fogColor);      // цвет тумана
  glFogf(GL_FOG_DENSITY, 0.002);         // плотность  - 0.2%
  glHint(GL_FOG_HINT, GL_DONT_CARE);     // GL_NICEST, GL_FASTEST.
 
  glClearColor(0.0, 0.0, 0.2, 1.0);      // Установить цвет фона - синий
  glClearDepth(1.0);                     // Очистить буфер глубины
  glDepthFunc(GL_LESS);                  // Тип теста глубины
  glShadeModel(GL_SMOOTH);               // плавное цветовое сглаживание
 
 
  // glEnable(..) - включить режим, glDisable(..) - отключить
  glEnable(GL_LIGHTING);                 // разрешить осещенность
  //glEnable(GL_FOG);                    // разрешить тумана
  glEnable(GL_DEPTH_TEST);               // разрешить тест глубины, с использованием
                                         // функции определенной в glDepthFunc
  glEnable(GL_NORMALIZE);                // разрешить нормали (различение передней
                                         // и задней сторон плоских объектов)
  glEnable(GL_COLOR_MATERIAL);           // разрешить использование материалов на объектах
  glEnable(GL_TEXTURE_2D);               // разрешить наложение текстур
  //glEnable(GL_BLEND);                  // разрешить смешивание (напр. прозрачность)
                                         // не совместимо с glEnable(GL_DEPTH_TEST)
  glLoadTexture('1.bmp', Texture);       // загружаем текстуру
end;
 
{------------------------------------------------------------------}
{  Завершение работы с OpenGL                                      }
{------------------------------------------------------------------}
procedure glKill(Wnd: hWND);
begin
  wglMakeCurrent(DC, 0);
  wglDeleteContext(RC);
  ReleaseDC(Wnd, DC);
end;
 
 
{------------------------------------------------------------------}
{  Создание объектов под отрисовку                                 }
{------------------------------------------------------------------}
procedure glDraw();
var
  Obj: GLUquadricObj;
begin
  // очистка Экрана и буфера глубины
  glClear(GL_COLOR_BUFFER_BIT or GL_DEPTH_BUFFER_BIT);
 
  glMatrixMode(GL_MODELVIEW);            // Переключаемся на видовую матрицу
  glLoadIdentity;                        // Сбрасываем все преобразования
 
  // Пример рисования разноцветного треугольника
  glBegin(GL_POLYGON);
  glColor(0.0, 0.5, 0.0, 0.0);            // Цвет 1-ой вершины
  glVertex3F(-50, -sqrt(3)*50, 0);        // 1-я вершина
  glColor(0.5, 0.0, 0.0, 0.0);            // Цвет 2-ой вершины
  glVertex3F(-100, -sqrt(3)*100, 0);      // 2-я вершина
  glColor(0.0, 0.0, 0.5, 0.0);            // Цвет 3-ей вершины
  glVertex3F(-125, -sqrt(3)*100, 0);      // 3-я вершина
  glEnd;
 
  // Следующая фигура будет нарисована повернутой
  // Поворачиваем сферу так, чтобы северный полюс на текстуре
  // смотрел в нужную сторону
  glRotate(-90, 0.0, 1.0, 0.0);
  glRotate(60, 1.0, 0.0, 0.0);
  // здесь поворот сферы вокруг оси
  glRotate(-Angle, 0.0, 0.0, 1.0);
 
  // Пример рисования сферы
  glColor(1.0, 1.0, 1.0, 0.5);           // установить цвет объекта
  glBlendFunc(GL_SRC_ALPHA,GL_ONE);      // Функция смешивания для непрозрачности,
                                         // базирующаяся на значении альфы
                                         // Отрабатывает только при glEnable(GL_BLEND)
  glBindTexture(GL_TEXTURE_2D, Texture); // установить текущую текстуру Texture
  Obj:=gluNewQuadric;
  gluQuadricTexture(Obj, GL_TRUE);       // разрешить наложить текущую текстуру на
                                         // создаваемый объект
  gluSphere(Obj, 100, 25, 25);           // создать сферу  R = 100, детализация - 25х25
  gluDeleteQuadric(Obj);                 // Освобождаем память
 
  Angle := (Angle + 5) mod 360;
 
  // Выводим на экран подготовленную сцену
  SwapBuffers(DC);
end;
 
{------------------------------------------------------------------}
{  Выбор приемлемого формата точки для данного DC                  }
{------------------------------------------------------------------}
procedure SetDCPixelFormat(DC: hDC);
var
  pfd: TPixelFormatDescriptor;
  nPixelFormat: Integer;
begin
  FillChar(pfd, SizeOf(pfd), 0);
  with pfd do
  begin
    nSize      := sizeof(pfd);
    nVersion   := 1;
    dwFlags    := PFD_DRAW_TO_WINDOW or
                  PFD_SUPPORT_OPENGL or
                  PFD_DOUBLEBUFFER;
    iPixelType := PFD_TYPE_RGBA;
    cColorBits := 16;
    cDepthBits := 64;
    iLayerType := PFD_MAIN_PLANE;
   end;
 
  nPixelFormat := ChoosePixelFormat(DC, @pfd);
  SetPixelFormat(DC, nPixelFormat, @pfd);
end;
 
{------------------------------------------------------------------}
{  Загрузка 8 или 24-битного bmp-файла текстуры                    }
{------------------------------------------------------------------}
procedure glLoadTexture(Filename: String; var Texture: GLuint);
type BitmapHeader=
     record
     FH: BitmapFileHeader;
     IH: BitmapInfoHeader;
     end;
var
  ColorTable: array of TRGBQuad;
  Data: array of Byte;
  RGBData: array of TRGBTriple;
  Bmp: BitmapHeader;
  tmp, i, L: Cardinal;
  F: hFile;
begin
  F := CreateFile(PChar(FileName), GENERIC_READ, FILE_SHARE_READ, nil, OPEN_EXISTING, 0, 0);
  if F = INVALID_HANDLE_VALUE then
    begin
      MessageBox(0,PChar('File '+ FileName + ' not found'), 'glLoadTexture',0);
      exit;
    end;
 
  ReadFile(F, Bmp, sizeof(BitmapHeader),tmp, nil );
  L := Bmp.IH.biWidth * Bmp.IH.biHeight;
  SetLength(RGBData, L);
  case Bmp.IH.biBitCount of
    8:
      begin
        SetLength(ColorTable, round(exp(Bmp.IH.biBitCount*Ln(2))));
        ReadFile(F, ColorTable[0], SizeOf(TRGBQuad) * round(exp(Bmp.IH.biBitCount*Ln(2))), tmp, nil);
        SetLength(Data, L);
 
        ReadFile(F, Data[0], SizeOf(Byte) * L, tmp, nil);
        for i := 0 to L - 1 do
          begin
            RGBData[L - i - 1].rgbtRed   := ColorTable[Data[i]].rgbBlue;
            RGBData[L - i - 1].rgbtGreen := ColorTable[Data[i]].rgbGreen;
            RGBData[L - i - 1].rgbtBlue  := ColorTable[Data[i]].rgbRed;
          end;
       end;
    24:
      begin
        SetLength(Data, L * 3);
        ReadFile(F, Data[0], SizeOf(Byte) * L * 3, tmp, nil);
        for i := 0 to L - 1 do
          begin
            RGBData[L - i - 1].rgbtRed   := Data[3 * i];
            RGBData[L - i - 1].rgbtGreen := Data[3 * i + 1];
            RGBData[L - i - 1].rgbtBlue  := Data[3 * i + 2];
          end;
      end;
    else MessageBox(0, 'Format not support', 'glLoadTexture', 0);
    end; { end case}
  CloseHandle(F);
 
  // Далее код из BMP.pas от Jan Horn
  glGenTextures(1, Texture);
  glBindTexture(GL_TEXTURE_2D, Texture);
  glTexEnvi(GL_TEXTURE_ENV, GL_TEXTURE_ENV_MODE, GL_MODULATE);  {Texture blends with object background}
  //  glTexEnvi(GL_TEXTURE_ENV, GL_TEXTURE_ENV_MODE, GL_DECAL);  {Texture does NOT blend with object background}
  {
    Select a filtering type. BiLinear filtering produces very good results with little performance impact
    GL_NEAREST               - Basic texture (grainy looking texture)
    GL_LINEAR                - BiLinear filtering
    GL_LINEAR_MIPMAP_NEAREST - Basic mipmapped texture
    GL_LINEAR_MIPMAP_LINEAR  - BiLinear Mipmapped texture
  }
  glTexParameteri(GL_TEXTURE_2D, GL_TEXTURE_MAG_FILTER, GL_LINEAR); { only first two can be used }
  glTexParameteri(GL_TEXTURE_2D, GL_TEXTURE_MIN_FILTER, GL_LINEAR); { all of the above can be used }
 
  gluBuild2DMipmaps(GL_TEXTURE_2D, 3, Bmp.IH.biWidth, Bmp.IH.biHeight, GL_RGB, GL_UNSIGNED_BYTE, RGBData);
  // Use when not wanting mipmaps to be built by openGL
  // glTexImage2D(GL_TEXTURE_2D, 0, 3, Bmp.IH.biWidth, Bmp.IH.biHeight, 0, GL_RGB, GL_UNSIGNED_BYTE, RGBData);
end;
 
end.
</pre>

<p>&nbsp;<br>
&nbsp;<br>
&nbsp;<br>
07 Собранный пример VCL<br>
=======================<br>
&nbsp;<br>
На форме таймер, в проект включен MyOpenGL.pas. В той же папке лежит 8 или <br>
24-битный bmp-фаил.<br>
<p>&nbsp;</p>
<pre>unit Unit1;
 
interface
 
uses
  Windows, Messages, SysUtils, Variants, Classes, Graphics, Controls, Forms,
  Dialogs, ExtCtrls, MyOpenGL;
 
type
  TForm1 = class(TForm)
    Timer1: TTimer;
    procedure FormDestroy(Sender: TObject);
    procedure FormResize(Sender: TObject);
    procedure Timer1Timer(Sender: TObject);
    procedure FormCreate(Sender: TObject);
  private
    { Private declarations }
  public
    { Public declarations }
  end;
 
var
  Form1: TForm1;
implementation
{$R *.dfm}
 
procedure TForm1.FormDestroy(Sender: TObject);
begin
  glKill(Form1.Handle);
end;
 
procedure TForm1.FormResize(Sender: TObject);
begin
  glOnResize(Form1.ClientWidth,Form1.ClientHeight);
end;
 
procedure TForm1.Timer1Timer(Sender: TObject);
begin
  glDraw();
end;
 
procedure TForm1.FormCreate(Sender: TObject);
begin
  glInit(Form1.Handle);
  glOnResize(Form1.ClientWidth,Form1.ClientHeight);
end;
 
end.
</pre>
<br>
&nbsp;<br>
&nbsp;<br>
08 Собранный пример WinApi<br>
==========================<br>
&nbsp;<br>
В той же папке лежит 8 или 24-битный bmp-файл. <br>
<p>&nbsp;</p>
<pre>program a;
 
uses
  windows,
  messages,
  MyOpenGL in 'MyOpenGL.pas';
 
var
  MainWnd: hWND;
 
function WindowProc(Wnd: HWND; Msg: Integer; wParam: wParam; lParam:lParam):lResult;stdcall;
begin
  case Msg of
    WM_DESTROY:
      begin
        glKill(MainWnd);
        postquitmessage(0);
        Result := 0;
        exit;
     end;
    WM_TIMER:
      begin
        glDraw();                       // Рисуем сцену
        Result := 0;
      end;
    WM_SIZE:
      begin
        // В lParam содержатся размеры клиентской области ;-)
        glOnResize(loWord(lParam), hiWord(lParam));
        Result := 0;
      end;
    else
      Result := DefWindowProc(Wnd, Msg, wParam, lParam);
  end;
end;
 
var
  Mesg: TMsg;
  wc : TWndClassEx;
begin
  wc.cbSize := sizeof(wc);
  wc.style := CS_HREDRAW or CS_VREDRAW;
  wc.lpfnWndProc := @WindowProc;
  wc.cbClsExtra := 0;
  wc.cbWndExtra := 0;
  wc.hInstance := hInstance;
  wc.hIcon := LoadIcon(0, IDI_WINLOGO);
  wc.hCursor := LoadCursor(0, IDC_ARROW);
  wc.hbrBackground := COLOR_BTNFACE+2;
  wc.lpszMenuName := nil;
  wc.lpszClassName := 'aWnd';
  RegisterClassEx(wc);
 
  // Создаем окно 400х400
  MainWnd := CreateWindowEx (0, 'aWnd', 'MyOpenGL', WS_OVERLAPPEDWINDOW or WS_VISIBLE, 100, 100, 400, 400, 0, 0, hInstance, nil);
 
  // Создаем контекст воспроизведения OpenGL и его параметры
  glInit(MainWnd);
  // Задаем матрицы OpenGL для размера окна 400х400
  glOnResize(400, 400);
 
  // Устанавливаем таймер 10мс для перерисовки сцены
  SetTimer(MainWnd, 1, 10, nil);
 
  while GetMessage(Mesg, 0, 0, 0) do
  begin
    TranslateMessage(Mesg);
    DispatchMessage(Mesg);
  end;
end.
</pre>

<p>*************************************<br>
************ Часть II ***************<br>
*************************************<br>
&nbsp;<br>
В этой части будут только указаны исправления кода MyOpenGL.pas, которые <br>
надеюсь без труда сделаете сами, или просто общие сведения.<br>
&nbsp;<br>
09 Списки <br>
=========<br>
&nbsp;<br>
"Список - это некоторый набор команд OpenGL, который можно создать один раз, <br>
например, перед началом работы программы, а потом им пользоваться вызывая его. <br>
По логике он аналогичен процедуре (или функции, как хотите). Отличие его от <br>
процедуры в том, что при формировании списка библиотека сохраняет его в <br>
каком-то своем, оптимизированном формате и вызовы списка приводят к значительно <br>
меньшим вычислительным затратам чем вызов функции, делающей тоже самое. Особенно <br>
хорошо это заметно на картах, где операции со списками реализованы аппаратно."<br>
(Взято с http://firststeps.ru/mfc/opengl/r.php?41)<br>
&nbsp;<br>
<p>Где-то до использования MyOpenGL.glDraw (напр. в MyOpenGL.glInit)</p>
<pre>// Глобальная переменная для MyOpenGL.pas
var
  MyList: GLuint;
...
  // указываем, что в списке два набора команд
  MyList := glGenLists(2);
  // Создаем первый набор команд
  // Флаг GL_COMPILE указывает что его надо только создать
  // Использование GL_COMPILE_AND_EXECUTE сразу же еще и выполнило бы этот набор
  // В первом наборе будем рисовать треугольник
  glNewList(MyList, GL_COMPILE);
    glBegin(GL_POLYGON);
      glVertex3F(0.0, 0.0, 0.0);
      glVertex3F(100.0, 0.0, 0.0);
      glVertex3F(50.0, sqrt(3)*50, 0.0);
    glEnd;
  // Указываем что завершили создание набора команд
  glEndList();
 
  // Создаем второй набор команд
  // Во втором наборе к матрице GL_MODELVIEW будет добавляться параллельный
  // перенос на 50 по оси OX и на 1 по оси OZ (это чтобы поверх остального)
  // Поставить переменные значения в перенос нельзя, так как это будет уже 
  // другая матрица. Хотя может я и ошибаюсь.
  glNewList(MyList + 1, GL_COMPILE);
    glTranslatef(50, sqrt(3) * 12.5, 1);
  // Указываем что завершили создание набора команд
  glEndList();
</pre>

<p>&nbsp;<br>
&nbsp;<br>
MyOpenGL.glDraw можно переписать так. В итоге получим, что рисуется одна <br>
неподвижная фигура (зеленая), а другая вращающаяся, выполненая как и первая, <br>
<p>и перенесенная в центр первой и на уровень выше первой (красная).</p>

<pre>procedure glDraw();
begin
  // очистка Экрана и буфера глубины
  glClear(GL_COLOR_BUFFER_BIT or GL_DEPTH_BUFFER_BIT);
 
  // Сбрасываем GL_MODELVIEW до единичной
  glLoadIdentity();
 
  // Устанавливаем зеленый цвет для фигур 
  glColor(0.0, 1.0, 0.0, 1);
  // Создаем фигуру, используя набор команд MyList
  glCallList(MyList);
 
  // Добавляем значение к углу поворота
  Angle := (Angle + 5) mod 360;
  // Вызываем второй набор команд, который хранится по MyList + 1
  // В результате к GL_MODELVIEW добавляется перенос
  glCallList(MyList + 1);
  // Добавим к GL_MODELVIEW-матрице еще и поворот на угол Angle
  glRotate(Angle, 0.0, 0.0, 1.0);
  // Устанавливаем красный цвет для фигур 
  glColor(1.0, 0.0, 0.0, 1);
  // Создаем фигуру, используя набор команд MyList
  // Поскольку GL_MODELVIEW-матрица у нее другая, то и распалагается
  // она уже иначе, чем первая фигура
  glCallList(MyList);
 
  // Выводим на экран подготовленную сцену
  SwapBuffers(DC);
end;
</pre>
<br>
&nbsp;<br>
Ну и в MyOpenGL.glKill стоит добавить<br>
<p>&nbsp;</p>
<pre>  glDeleteLists(MyList, 2); // удаляем все элементы списка :-)
</pre>

<p>&nbsp;<br>
&nbsp;<br>
Примечание: устоявшееся понятие "список отображениия" - список, в котором все <br>
наборы команд - это рисование фигуры (шаблон). См. Народный учебник, Глава 12.<br>
&nbsp;<br>
10 Собранный пример WinAPI без таймера для отрисовки<br>
====================================================<br>
&nbsp;<br>
Взято у Jan Horn (http://www.sulaco.co.za, http://home.global.co.za/~jhorn)<br>
Как обычно, в папке проекта есть MYOpenGL.pas и 1.bmp :-)<br>
&nbsp;<br>
Идеи таковы: <br>
* пока приложение не обработает всю свою очередь сообщений, перерисовка<br>
выполняться не будет;<br>
* Если нажали кнопку, то в массиве "Статус кнопок" для соответсвующего <br>
элемента выстанавливается значение True, которое скинется после<br>
обработки этого нажатия в ProcessKey. Такая схема позволяет запретить<br>
<p>накопление нажатий. </p>

<pre>program a;
 
uses
  windows,
  messages,
  MyOpenGL in 'MyOpenGL.pas';
 
var
  MainWnd: hWND;
  FPSCount: Integer;                // Число FPS
  keys : array [0..255] of Boolean; // Статусы кнопок
 
function IntToStr(Num: Integer) : String;
begin
  Str(Num, result);
end;
 
// Обработка кнопок
procedure ProcessKeys;
begin
  if (keys[VK_UP]) then
  begin
    // Что-то делаем
    //...
    // Сбрасываем нажатие этой кнопки
    keys[VK_UP] := False;
  end;
  if Keys[Ord('H')] then
  begin
    // Что-то делаем
    //...
    // Сбрасываем нажатие этой кнопки
    Keys[Ord('H')] := FALSE;
  end;
end;
 
function WindowProc(Wnd: HWND; Msg: Integer; wParam: wParam; lParam:lParam):lResult;stdcall;
begin
  case Msg of
    WM_DESTROY:
      begin
        glKill(MainWnd);
        postquitmessage(0);
        Result := 0;
        exit;
     end;
    WM_KEYDOWN:
      begin
        keys[wParam] := True;
        Result := 0;
      end;
    WM_KEYUP:
      begin 
        keys[wParam] := False;
        Result := 0;
      end;
    WM_TIMER:
      begin
        FPSCount := Round(FPSCount * 1000/{FPS-интервал - у нас 1с}1000);
        SetWindowText(MainWnd, PChar('FPS: ' + IntToStr(FPSCount)));
        FPSCount := 0;
      end;
    WM_SIZE:
      begin
        glOnResize(loWord(lParam), hiWord(lParam));
        Result := 0;
      end;
    else
      Result := DefWindowProc(Wnd, Msg, wParam, lParam);
  end;
end;
 
var
  Mesg: TMsg;
  wc : TWndClassEx;
  finished: Boolean = False; // Флаг завершения работы OpenGL
begin
  wc.cbSize := sizeof(wc);
  wc.style := CS_HREDRAW or CS_VREDRAW;
  wc.lpfnWndProc := @WindowProc;
  wc.cbClsExtra := 0;
  wc.cbWndExtra := 0;
  wc.hInstance := hInstance;
  wc.hIcon := LoadIcon(0, IDI_WINLOGO);
  wc.hCursor := LoadCursor(0, IDC_ARROW);
  wc.hbrBackground := COLOR_BTNFACE + 2;
  wc.lpszMenuName := nil;
  wc.lpszClassName := 'aWnd';
  RegisterClassEx(wc);
 
  // Создаем окно 400х400
  MainWnd := CreateWindowEx (0, 'aWnd', 'MyOpenGL', WS_OVERLAPPEDWINDOW or WS_VISIBLE, 100, 100, 400, 400, 0, 0, hInstance, nil);
 
  // Создаем контекст воспроизведения OpenGL и его параметры
  glInit(MainWnd);
  // Задаем матрицы OpenGL для размера окна 400х400
  glOnResize(400, 400);
 
  // Устанавливаем таймер на 1с для отображения FPS в заголовке окна
  SetTimer(MainWnd, 1, 1000, nil);
 
  while not finished do
  begin
    // Если очередь сообщений для окна пуста, то проводим
    // расчет и отрисовку сцены, иначе обрабатываем
    // очередь сообщений
    if (PeekMessage(Mesg, 0, 0, 0, PM_REMOVE)) then
    begin
      // Если было получено WM_QUIT, то выход
      if (Mesg.message = WM_QUIT) then
        finished := True
      else
      begin
        TranslateMessage(Mesg);
        DispatchMessage(Mesg);
      end;
    end
    else
    begin
      // Увеличиваем счетчик отрисованных кадров
      Inc(FPSCount);
      // Рисуем-с кадр
      glDraw();
 
      // Если была до этого нажата ESC, то сразу выходим
      if (keys[VK_ESCAPE]) then
        finished := True
      else
        ProcessKeys;
    end;
  end;
 
end.
</pre>
<p>&nbsp;
&nbsp;<br>
&nbsp;<br>
&nbsp;<br>
11 Разное<br>
=========<br>
&nbsp;<br>
<p>а. Получение текста последней ошибки OpenGL</p>
<p>  MessageBox(0, gluErrorString(glGetError), 'OpenGL error', MB_OK);</p>
<p>&nbsp;<br>
&nbsp;<br>
б. Восстановление состояния режима<br>
Лампа GL_LIGHT0 будет включена или выключена в зависимости от ее состоянием<br>
перед началом блока<br>
&nbsp;<br>
<p>&nbsp;</p>
<p>glPushAttrib(GL_LIGHT0); </p>
<p>...</p>
<p>glEnable(GL_LIGH0);</p>
<p>...</p>
<p>glPopAttrib();</p>
<p>&nbsp;<br>
&nbsp;<br>
12 Вывод текста в OpenGL<br>
========================<br>
&nbsp;<br>
Код получен объединением кода Jan Horn, NeHe (уроки 13 и 14) и DRKB <br>
Работа с графикой и мультимедиа &gt; DerectX, OpenGL &gt; OpenGL: Каким обpазом <br>
выбиpать pазмеp шpифта.<br>
&nbsp;<br>
Итак, можем выводить текст как растровое изображение и как векторное (буквы<br>
это 3D объекты). Идея такова, что для алфавита подготавливается список <br>
(см 09), а при вводе текст разбивается на буквы и потом последовательно для<br>
каждой буквы печатаемой строки выполняется соответствующий набор команд из <br>
списка.<br>
&nbsp;<br>
Ниже код, который реализует как растровый, так и как векторный вывод.<br>
<p>(необходимо лишь закоментировать указанные строки).</p>
<pre>var
  CharList: GLuint;                              // Вот этот список
  gmf: array [0..255] of GLYPHMETRICSFLOAT;      // массив требуется для векторного
...
{----------------------------------------------------------------}
{  Создание списка букв                                          }
{----------------------------------------------------------------}
procedure glBuildFont;
var
  Font: hFont;
begin
  // Список для 256 букв алфавита
  CharList := glGenLists(256);
  // Создаем шрифт, подробнее см. SDK
  Font := CreateFont(-28, 0, 0, 0, FW_BOLD, 0, 0, 0, RUSSIAN_CHARSET,
          OUT_TT_PRECIS, CLIP_DEFAULT_PRECIS, ANTIALIASED_QUALITY,
          FF_DONTCARE or DEFAULT_PITCH, 'Comic Sans MS');
  // Устанавливаем шрифт для DC
  SelectObject(DC, Font);
 
  // Создаем команды списка.
  // Выбираем один из двух вариантов
 
  // Если используем wglUseFontBitmaps то - это растровое изображение
  if not wglUseFontBitmaps(DC, 0, 256, CharList) then
или
  // Если используем wglUseFontOutlines то - это векторное изображение    
  if not wglUseFontOutlines(DC, 0, 255, CharList, 0, 0.2, WGL_FONT_POLYGONS, @gmf) then
 
 
     MessageBox(0, 'Font not create', 'glBuildFont', MB_OK);
 
  // Удаляем шрифт, так как соответствующий список уже создан
  DeleteObject(Font);
end;
 
{----------------------------------------------------------------}
{  Вывод строки на экран                                         }
{----------------------------------------------------------------}
procedure glPrint(X, Y: Integer; text: String);
begin
  // Расчитывается позиция на экране. Требуется только для растрового
  // вывода. То есть при векторном выводе X и Y gLPrint игнорируются, 
  // поэтому перед выводом надо будет воспользоваться glTranslatef 
  glRasterPos2i(X, Y);
  glPushAttrib(GL_LIST_BIT);
  // Указыывем, что первая буква алфавита рисуется 1-ым набором команд
  glListBase(1);
  // Выводим текст
  glCallLists(length(text), GL_UNSIGNED_BYTE, PChar(text));
  glPopAttrib();
end;
...
// Где-то перед использованием вывода текста, напр. в MyOpenGL.glInit
// после создания контеста воспроизведения RC
  glBuildFont;
...
// Когда работа с текстом будет уже не нужна, то очистим список
// Напр. в MyOpenGL.glKill перед освобождением RC 
  glDeleteLists(CharList, 256);
</pre>
<br>
Добавление теста на сцену немного различается. Далее добавляемый код в<br>
процедуру построения сцены (напр. в MyOpenGL.glDraw).<br>
Для растрового текста<br>
<p>&nbsp;</p>
<pre>  // Устанавливаем цвет букв
  glColor3f(1.0, 0.0, 1.0);
  // Добавляем текст на сцену
  glPrint(-150, 0, 'Даст ист фантастиш');
</pre>
<p>&nbsp;<br>
Вывод векторного шрифта несколько сложнее, поскольку команды списка создают <br>
3D объекты с определенными размерами (все буквы маленького размераа типа 0.01) <br>
(для растровых шрифтов велична букв определяется только первым параметром<br>
функции CreateFont в glBuildFont) и поэтому, если у матрица проекций работает <br>
не с такими размерами (у меня она работает с размерами как напр. 100), то надо <br>
увеличить текст glScale. Так же надо подобрать режимы, чтобы текст смотрелся <br>
по-настоящему 3D.<br>
<p>&nbsp;</p>
<p>  // Подбираем нужный режим</p>
<p>  glEnable(GL_LIGHT0);&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // Включаем стандартную лампу</p>
<p>  glDisable(GL_LIGHT1);&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // Отключаем пользовательскую лампу </p>
<p>  glDisable(GL_NORMALIZE);&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // Отключаем режим нормалей</p>
<p>  glLoadIdentity;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // Загружаем в GL_MODELVIEW единичную матрицу</p>
<p>  glTranslatef(-150, 0.0, 0.0);&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // Добавим перенос от центра</p>
<p>  glScale(100, 100, 1.0);&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // Растягиваем текст на 100 по ОХ и OY </p>
<p>  glRotate(45, 1.0, 1.0, 0.0);&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // Добавим поворот</p>
<p>  glColor(1.0, 0.0, 1.0);&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // Установим цвет букв</p>
<p>  glPrint(0, 0, 'Даст ист фантастиш');&nbsp;&nbsp; // Добавим текст на сцену</p>
<p>  // Возвращаем все как было</p>
<p>  glDisable(GL_LIGHT0);&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // Выключаем стандартную лампу</p>
<p>  glEnable(GL_NORMALIZE);&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // Включаем режим нормалей</p>
<p>  glEnable(GL_LIGHT1);&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // Включаем пользовательскую лампу</p>
<p>&nbsp;<br>
&nbsp;<br>
13 Компонент для работы с OpenGL<br>
================================<br>
&nbsp;<br>
Напр. на http://glscene.org - GL_Scene - версии для Delphi5-7.<br>
Умеет много чего, в частности импорт 3DS файлов.<br>
&nbsp;<br>
14 Загрузка объектов под отрисовку из файла<br>
===========================================<br>
&nbsp;<br>
Почти всегда хочется, чтобы в функции создании сцены (у меня это MyOpenGL.glDraw)<br>
объекты под отрисовку загружались с файла. Обычно реализуют свой формат хранения<br>
фигур и функции для работы с ним. Я ленивый, потому предлагаю свой способ - <br>
хранить не объекты, а набор gl-комманд ему соответствующий, который будет <br>
<p>загружаться в список. Например рассмотрим такой фаил.</p>
<p>2</p>
<p>glNewList</p>
<p>glBegin 4</p>
<p>glVertex3f 0 0 0</p>
<p>glVertex3f 100,4 0 0</p>
<p>glVertex3f 50 100 0</p>
<p>glEnd</p>
<p>glEndList </p>
<p>glNewList</p>
<p>glRotate 10 0 1 0 </p>
<p>glEndList</p>
<p>&nbsp;<br>
2 - это то что в списке 2 набора команд. Соответвенно в самой программе это<br>
будет использоваться так (на примере MyOpenGL)<br>
Примечания: <br>
1. дробная часть указывается через запятую!<br>
<p>2. Для glBegin значения констант смотреть в OpenGL.pas </p>
<pre>uses MyGLU;
...
var
  List: GLuint;
  Count: Integer;
...
// Где-то до использования создания сцены, напр. в MyOpenGL.glInit
  Count := gluLoadList('1.gls', List);    // моя функция загрузки скрипта из файла из MyGLU.pas
...
// Где-то в функции создания сцены, напр. в MyOpenGL.glDraw
  for i := 0 to Count - 1 do
  begin
    glCallList(List + i);             // Вызываем i-ый набор команд; нумерация с нулевого 
  end;
</pre>

<p>&nbsp;<br>
&nbsp;<br>
По-моему замечательная идея ;-) Возможно у нее уже есть реализация. <br>
А теперь черновой код MyGLU.pas (поддерживаются не все функции gl, да и контроль ошибок<br>
минимальный). Дописывать я его уже наверно не буду; если вам понравилась идея, то<br>
доработать его думаю труда не составит - все прозрачно.<br>
<p>&nbsp;</p>
<pre>unit MyGLU;
 
interface
 
uses windows, OpenGL, SysUtils;
 
// Функция создает список, используя команды из текстового файла
// Возвращаемое значение - число элементов созданного списка  
function gluLoadList(FileName: String; var List: GLuint): Integer;
 
implementation
 
var
  Param: array [1..10] of Extended;
 
// Получение из входной строки S подслов, которые конвертируется в Float
// и помещаются в соответствующий Param[i]. S начинает обрабатываться
// с S[Pos].
function GetParam(S: String; Pos: Integer): Integer;
var
  i, j: Integer;
  Value: String;
begin
  for i := 1 to 10 do Param[i] := 0;
  j := 1;
  Value := '';
  for i := Pos + 1 to Length(S) do
    if (S[i] = ' ')  then
    begin
      Param[j] := StrToFloat(Value);
      if j = 10 then
      begin
        Result := 10;
        MessageBox(0, PChar('Too many params!'), 'GetParam', MB_OK);
        exit;
      end
      else j := j + 1;
      Value := '';
    end
    else Value := Value + S[i];
  if Value &lt;&gt; '' then Param[j] := StrToFloat(Value);
  Result := j;
end;
 
function gluLoadList(FileName: String; var List: GLuint): Integer;
var
  F: TextFile;
  S, Command: String;
  Count, CurrList, i: Integer;
  Obj: GLUquadricObj;
begin
  if not FileExists(FileName) then
    begin
    MessageBox(0, PChar('File '+FileName + ' not found'), 'glLoadList', MB_OK);
    end;
 
  AssignFile(F, FileName);
  Reset(F);
  readln(F, S);
  Count := StrToInt(S);
  CurrList := 0;              // сдвиг; иначе номер набора команд.
  List := glGenLists(Count);
 
  Obj := gluNewQuadric;
 
     // читаем из файла, если видим знакомую команду, то выполняем
     while not EOF(F) do
     begin
       Command := '';
       readln(F, S);
       for i := 1 to Length(S) do
         if S[i] = ' ' then break
           else Command := Command + S[i];
 
       GetParam(S, i);
 
       Command := UpperCase(Command);
 
       if Command = 'GLNEWLIST' then
         glNewList(List + CurrList, GL_COMPILE);
       if Command = 'GLENDLIST' then
       begin
         glEndList;
         CurrList := CurrList + 1;
       end;
 
       if Command = 'GLBEGIN' then
          glBegin(round(Param[1]));
       if Command = 'GLEND' then
          glEnd;
 
       if Command = 'GLROTATE' then
         glRotate(Param[1], Param[2], Param[3], Param[4]);
       if Command = 'GLSCALE' then
         glScale(Param[1], Param[2], Param[3]);
       if Command = 'GLTRANSLATEF' then
         glTranslatef(Param[1], Param[2], Param[3]);
 
 
       if Command = 'GLVERTEX3F' then
         glVertex3f(Param[1], Param[2], Param[3]);
       if Command = 'GLCOLOR' then
         glColor(Param[1], Param[2], Param[3], Param[4]);
 
       if Command = 'GLLOADIDENTITY' then
         glLoadIdentity;
       if Command = 'GLPUSHMATRIX' then
         glPushMatrix;
       if Command = 'GLPOPMATRIX' then
         glPopMatrix;
 
 
       if Command = 'GLUSPHERE' then
         gluSphere(Obj, Param[1], round(Param[2]), round(Param[3]));
       if Command = 'GLUCYLINDER' then
         gluCylinder(Obj, Param[1], Param[2], Param[3], round(Param[4]), round(Param[5]));
       if Command = 'GLUDISK' then
         gluDisk(Obj, Param[1], Param[2], round(Param[3]), round(Param[4]));
 
     end;
  glEndList;
 
  gluDeleteQuadric(Obj);
 
  CloseFile(F);
  Result := Count;
end;
 
end.
</pre>

<p>&nbsp;<br>
&nbsp;<br>
15 Bmp - формат<br>
===============<br>
&nbsp;<br>
Вообщем то к OpenGL это никакого отношения не имеет, но загрузку текстур все-таки<br>
зачастую приходится производить из него, так что полезно представлять что это такое.<br>
Описание самое простейшее, многое выкинуто, но для общего понимания и загрузки<br>
текстур из bmp-файлов - этого будет достаточно.<br>
&nbsp;<br>
В начале каждого bmp-файла идет служебная информация - общая информация о файле <br>
TBitmapFileHeader и потом общая информация о bmp-изображении - TBitmapInfoHeader.<br>
<p>Определения типов из windows.pas (комментарии мои)</p>
<pre>type
  tagBITMAPFILEHEADER = packed record
    bfType: Word;                         // тип файла - для Bmp = BM ~ $42$4D
    bfSize: DWORD;                        // размер файла в байтах
    bfReserved1: Word;                    // зарезервировано
    bfReserved2: Word;                    // зарезервировано
    bfOffBits: DWORD;                     // номер байта; со следующего начнется "изображение"
  end;
  TBitmapFileHeader = tagBITMAPFILEHEADER;
 
  tagBITMAPINFOHEADER = packed record
    biSize: DWORD;                        // размер структуры BitmapInfoHeader, байт
    biWidth: Longint;                     // ширина изображения
    biHeight: Longint;                    // высота изображения; отрицательна, если изображение
                                          // надо перевернуть
    biPlanes: Word;                       // число плоскостей изображения, всегда 1
    biBitCount: Word;                     // число бит на точку; ОЧЕНЬ ВАЖНЫЙ ПАРАМЕТР
    biCompression: DWORD;                 // Флаг компрессии - обычно BI_RGB (=0) 
    biSizeImage: DWORD;                   // Размер изображения в байтах
    biXPelsPerMeter: Longint;             // разрешение точек на метр по OX И по OY
    biYPelsPerMeter: Longint;
    biClrUsed: DWORD;                     // используемое количество цветов
    biClrImportant: DWORD;                // Обычно = biClrUsed
  end;
  TBitmapInfoHeader = tagBITMAPINFOHEADER;
  end;
</pre>
&nbsp;
&nbsp;<br>
Код поясняющий это 
<p>&nbsp;</p>
<pre>// Для простоты определим тип, состоящий из двух нужных нам
type 
  TBitmapHeader = record
    FH: TBitmapFileHeader;
    IH: TBitmapInfoHeader;
  end;
...
var
  Bmp: TBitmapHeader;
  tmp: Cardinal;
  F: hFile;
...
  // Для доступа к файлу, определяемого FileName, я использую WinAPI-функцию
  // Примерный смысл параметров, думаю, ясен
  F := CreateFile(PChar(FileName), GENERIC_READ, FILE_SHARE_READ, nil, OPEN_EXISTING, 0, 0);
  // Читаем данные из файла F, данные помещаются в Bmp, количество байт которых
  // хотим прочитать - это третий параметр, количество прочитанных байт будет
  // помещено в tmp
  ReadFile(F, Bmp, sizeof(TBitmapHeader), tmp, nil);
  ...
  //
  // Ширина изображения для примера
  MessageBox(0, PChar(IntToStr(Bmp.IH.biWidth)), 'Width', MB_OK);
  ...
  // Закрываем файл
  CloseHandle(F);
</pre>

<p>&nbsp;<br>
После этого заголовка (в байтах это Bmp.FH.bmOffBits) хранится изображение.<br>
Следует различать две группы bmp-изображений 1, 4, 8-битные и 16, 24, 32-битные.<br>
Для первой группы сначала идет палитра - то есть перечисение цветов в формате<br>
Red-Green-Blue-Alpha (TRGBQuad), содержащая biClrUsed-цветов (обычно это <br>
равно 2 ^ biBitCount), потом идут точки изображения - каждая точка пишется в<br>
соответсвующее количество бит (1, 4, 8) - это просто номер цвета из палитры.<br>
Для второй группы палитры нет, а сразу идут точки - для 24 и 32-битных <br>
изображений - в формате RGB и RGBA (по байту на составляющую, что и дает <br>
соответствующую битность); для 16-битных несколько хитрее, потому опущу описание.<br>
&nbsp;<br>
При загрузке текстуры передаются - ширина, высота изображения и массив RGB точек.<br>
Для 24- и 32- битных bmp файлов - массив получается элементарно. Для 1, 4 и 8-<br>
битных необходимо этот массив формировать на основе палитры.<br>
&nbsp;<br>
Примечания<br>
* Точки изображения пробегаются с нижнего левого угла.<br>
* Цвета в BMp-файле зранятся в последовательности BGR, потому при загрузке в <br>
тестуру надо менять R и B цвета местами.<br>
* На самом деле, есть еще такое понятие как байтовое выравнивание в точках,<br>
при ширине изображения кратной 4 (для текстур это разумеется верно) об этом <br>
можно не беспокоится.<br>
&nbsp;<br>
Пример загрузки 8- и 24-битных изображений можно посмотреть в <br>
MyOpenGL.glLoadTexture. <br>
<p>&nbsp;</p>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
<div class="author">Автор: Zoobastik</div>

