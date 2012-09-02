<h1>Методы использования и создания BSP-деревьев</h1>
<div class="date">01.01.2007</div>

Автор: Роман Акопов</p>
<p>Опубликовано: 12.02.2001</p>
<p>Версия текста: 1.1</p>
<p>Интро</p>
<p>Эта статья объясняет как BSP деревья (binary space partition, двоичное деление пространства) могут быть использованы частью алгоритмов прорисовки для удаления односторонних поверхностей, частичной z-сортировки, удаления невидимых частей. </p>
<p>Использование BSP деревьев.</p>
<p>Уровень состоит из комнаты в комнате. Игрок не может выйти за пределы квадрата ABHG. Для начала несколько определений. Векторы помечены буквами A-H, поверхности a-g. Таким образом мы можем определить поверхность как a = (A,B) e = (E,C) f = (C,D) g = (F,D). Мы говорим, что точка слева от поверхности, если она слева от вектора соединяющего точки линии в соответствующем порядке. Точка g' слева от (F,D), а g" слева от (D,F). Таким образом, на рисунке выше нет ничего левее поверхности a, всё правее. Помните, что это зависит только от нашего определения поверхности a и не является свойством поверхности как таковой. Если бы мы определили a как (B,A), то всё было бы слева и нечего справа. Поверхность это сторона стены видимая игроку. Стена e для примера имеет две стороны помеченные e' и e". Не все стены имеют две стороны, если игрок никогда не увидит одной из сторон стены, то её у неё нет. Например у стены a одна сторона. Поверхность полностью определяется двумя упорядоченными парами векторов и упорядоченной парой сторон. </p>
<p>Каждая вершина дерева обозначает поверхность. Всё левее этой поверхности - левое поддерево, всё правее - правое. Отметим, что поверхность d не находится ни полностью левее, ни полностью правее f. Поэтому мы разбили её на две поверхности d1 и d2 и разместили в разные ветви дерева. Так что иногда нам нужно создать новые поверхности, разбивая старые, чтобы построить BSP дерево. Как BSP дерево строится, я объясню позже. Сейчас я объясню алгоритм, с помощью которого можно быстро прорисовать BSP дерево. Будем считать, что игрок расположен в позиции x на рисунке и смотрит вверх. Мы начинаем с вершины дерева - поверхностей f. Мы стоим справа от поверхностей f так что мы пойдём влево. Это потому что мы хотим начать с ближайших полигонов. Мы так добираемся до вершины слева и повторяем эту операцию. Надо так продолжать до тех пор, пока мы не дойдём до "листа" этого дерева. Тогда мы прорисовываем предыдущую вершину и её правую ветвь. Запишем порядок обхода вершин нами: a,d1,b1,f",d2,c1,e',b2,c3,g',c2. В данном примере мы рисовали всегда сперва левые ветви, а потом правые ветви BSP дерева. Это не всегда будет так. Помните, что вы всегда рисуете ВС&#1025; BSP дерево, но, в отличие от других алгоритмов, вам теперь не придётся сравнивать значения в z-буфера для каждого пикселя. Вы рисуете скопом, почти без проверок, это значительно быстрее. В знаменитой игре Quake этот алгоритм использовался наряду с z-буфером. При рисовании BSP дерева z-буфер заполнялся без проверок. Проверка видимости с помощью z-буфера осуществлялась позже, при рисовании движущихся объектов, которые не могут быть заранее включены в BSP дерево. В принципе можно и движущиеся объекты хранить в виде BSP деревьев. А потом прорисовывать их на разные копии экрана и объединять на основе z-буферов. </p>
<p>Создание BSP деревьев.</p>
<p>Дерево, всегда, как бы помогает создать само себя. Основная проблема - это знать, где остановиться. Отметьте, что вершины в "листьях" не несут смысловой нагрузки, и единственное условие объединения поверхностей это то, что они могут быть нарисованы в любом порядке без ошибок рисования. То есть, где бы ни стоял игрок (естественно из допустимых позиций) эти поверхности никогда зрительно не перекроют друг друга. Итак, начнём: выберем поверхность, например f. Лучше всегда выбирать поверхность, которая разбивает поменьше других поверхностей. Разобьём поверхности b и d, так как они не находятся ни точно слева, ни точно справа от f. Разобьём все поверхности на две категории те, что слева (они все будут в левой ветви) и те, что справа (они будут в правой ветви). </p>
<p>Мы можем завершить формирование левой ветви. Вершины a,d1,b1 никогда не будут зрительно перекрывать друг друга. С другой стороны, то есть справа, поверхность e может иногда закрывать d2. Так что мы выбираем e и делим с помощью поверхности e как с помощью поверхности f. Это заставляет нас разбить c, но a не разбивается так как она не входит в число разбиваемых поверхностей. </p>
<p>Итак, c1 и d2 никогда не перекроют друг друга. Затем, разобьём по поверхности g, разбивая опять c, и все получившиеся разбиения будут представлять собой листья. </p>
<p>Естественно, что проще (в смысле и проще организовывать структуры данных, и проще писать создание BSP дерева) разбивать до тех пор пока не останется по одной поверхности в вершине. Одна поверхность всегда может служить "листом". Это показано на следующем дереве. </p>
<p>По своей структуре реализация создания BSP деревьев немного напоминает QuickSort. Только там, чтобы отсортировать числа их не надо делить... </p>
<p>BSP деревья и другие алгоритмы рисования</p>
<p>Алгоритм художника</p>
<p>Наверное самое распространённое применение BSP деревьев это отсечение невидимых частей. BSP деревья предоставляют элегантный способ сортировки полигонов по дальности от наблюдателя. Этот факт может быть использован в алгоритме рисования "сзади вперёд" или в сканировании спереди назад. BSP деревья хорошо подходят для показа статических (не меняющих форму и положение) объектов, так как дерево может быть полностью построено заранее. А затем его рисование из любой точки наблюдения происходит за время пропорциональное количеству полигонов. То есть имеется линейная зависимость между количеством полигонов и временем их рисования. Дорисовка не статических объёктов будет обсуждена позже. Идея алгоритма художника заключается в том, чтобы сначала рисовать те полигоны которые дальше, а затем те которые ближе. Дальние полигоны будут затёрты ближними. Необходимым условием успешной прорисовки алгоритмом художника является то, что все пары полигонов можно сравнивать по расстоянию. То есть что если точка полигона 1 дальше точки полигона 2, то любая точка полигона 1 должна быть дальше любой точки полигона 2.</p>
<p>В случае BSP деревьев выполняются оба условия, так что применение алгоритма художника к BSP деревьям является вполне приемлемым, а его оптимизированное исполнение уже приведено выше. </p>
<p>Z-буфер</p>
<p>Часто рисуемая 3D сцена не является статической. Иными словами в ней присутствуют некоторые меняющие положение, форму или и то, и другое объекты. Включение их в BSP дерево связано с непомерными расходами времени на его перерасчёт и сводит на нет всю выгоду использования BSP деревьев. Однако, в процессе рисования BSP дерева мы можем заполнять Z-буфер. Как ? А безо всяких проверок. Просто писать в него значения Z-координат. То что BSP дерево прорисуется правильно мы уверены, но, при этом, мы к концу прорисовки будем иметь корректно заполненный Z-буфер который является универсальным средством отсечения невидимых частей. Рисуя динамические объекты с помощью Z-буфера (уже с проверками), полученного на предыдущей стадии, мы получим корректный результат. В принципе, если меняется только положение объекта, а не его форма, то можно и его (объект) представить в виде BSP дерева. На самом деле всё гораздо проще. Дело в том, что очень часто динамические объекты не пересекаются со статическими (монстры Quake не бегают в стенах) и поэтому гораздо удобнее рисовать не по-пиксельно а всего монстра за раз, всё равно он или весь перед, или весь сзади любой стены. </p>
<p>Пирамида видимости</p>
<p>В подавляющем большинстве 3D программ область видимости ограничена пирамидой. </p>
<p>Естественно что если рисуемый полигон находится, например, выше верхней грани пирамиды и мы должны нарисовать ветвь выше этого полигона, то этого делать не надо. В действительности даже отсечение всего что позади камеры даёт уже очень большую оптимизацию. Скажем в нашем примере если бы x смотрел влево то можно бы было не рисовать ветвь начиная в g то есть лишь около 2/3 полигонов. </p>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
