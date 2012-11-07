<h1>Пишем игры на MIDletPascal</h1>
<div class="date">01.01.2007</div>


<p>Введение</p>
<p>В последнее время, игры для мобильных устройств, приобретают всё большую популярность. В частности, достаточно широко распространены Java игры для сотовых телефонов. Каждый владелец современного телефона, имеет на руках готовую игровую платформу, способную развлечь своего хозяина в любой момент. Именно из-за этого факта, большая часть разработчиков компьютерных игр переметнула на рынок мобильных устройств...<br>
 <br>
Итак, &#8220;нормальные&#8221; люди пишут Java игры естественно на языке Java (J2ME). Но т.к. цели у нас пока не слишком грандиозные... идём выбирать что-нибудь проще. Из наиболее простых языков (надстроек) знаю лишь два: Mobile BASIC и MIDletPascal. Как раз о последнем и пойдёт речь в данной статье, т.к. он имеет хоть и скудные, но более продвинутые возможности в отличии от первого.<br>
 <br>
<p>Материал данной статьи не является полным описанием возможностей MIDletPascal, это более похоже на вводный курс, демонстрирующий применение наиболее необходимых для написания игр возможностей языка.</p>
<p>Установка и настройка</p>
<img src="/pic/clip0152.gif" width="496" height="380" border="0" alt="clip0152"></p>
<p>Прежде чем начать, нам необходимо иметь 2 вещи: компилятор и эмулятор. Первый предназначен для компиляции Pascal кода в Java байткод. А при помощи второго мы будем лицезреть наши достижения не &#8220;тревожа&#8221;, по пустякам, телефон...<br>
 <br>
Пишем на MIDletPascal следовательно компилятор берём с официального сайта http://midletpascal.com. На момент написания данного материала, последней версией считалась &#8220;MIDletPascal, Version 2.02&#8221; за 14 января 2006 г.<br>
 <br>
Эмулятором будет &#8220;Kwyshell MidpX Emulator&#8221;.Для тех, кто не хочет качать среду интегрирующуюся в explorer и портящую его внешнюю красоту своими безобразными кнопками с такими же безобразными иконками советую скачать урезанную его версию :)<br>
 <br>
Итак, первым делом нам необходимо установить сам MIDletPascal. После успешного окончания установки, запускаем его и приступаем к настройке работы с эмулятором. Для этого заходим в пункт меню &#8220;Configure - Program options...&#8221; и во вкладке &#8220;Emulator&#8221; добавляем новый (или изменяем свойства стандартного). В &#8220;Run command&#8221; необходимо прописать путь к скачанному нами эмулятору и параметры его запуска. Эта строка должна выглядеть приблизительно так &#8220;C:\MP\Midp2Exe.exe -jar %JAR% -r&#8221;. Сохраняем изменения и возвращаемся к главному окну программы.<br>
 <br>
<p>Теперь всё готово для начала работы в новой для нас среде. Создаём новый шаблон проекта &#8220;File - New Project...&#8221;. Выбрав имя будущего проекта и его месторасположение на диске, жмём на &#8220;Create&#8221;. В окне редактора появится банальный код банальной до слёз программы выводящей &#8220;Hello world!&#8221;. Можно скомпилировать и запустить мидлет нажатием &#8220;F9&#8221;, ничего сверхъестественного мы не увидим, но будет приятно когда хоть что-то аналогичное &#8220;созданное Вами&#8221; запустится на любимой моторолке, нокии или что там у Вас...</p>
<p>Первая программа</p>
<img src="/pic/clip0153.gif" width="176" height="189" border="0" alt="clip0153"></p>
<p>Я надеюсь, что Вы не впервые сели за Pascal и хоть какой-то опыт написания программ на этом замечательном языке у Вас имеется, так что давайте попробуем написать &#8220;продвинутый Hello World!&#8221; попутно разучив методы работы с некоторыми функциями и принцип написания мидлетов вцелом.<br>
 <br>
Темой будет звёздное небо (аналог стандартной заставки в Windows) и парящий над ним (сами знаете какой) текст...<br>
<p></p>
<pre>
program Hello;
type
// Описываем тип-элемент Звезда
TStar = record
X, Y, Z : Integer; // Положение в пространстве
end;
const
MAX_STARS = 150; // Кол-во звёздочек
HELLO = 'HELLO WORLD!'; // "Та самая надпись" :)
SPEED = 200; // Скорость, в единицах/сек
var
i : Integer;
// Наши звёздочки :) 
Stars : array [1..MAX_STARS] of TStar;
// Ширина и высота дисплея
scr_W : Integer;
scr_H : Integer;
// Время
time, dt : Integer;
// Рисует текущую звёздочку (i), цвета (c)
procedure SetPix(c: Integer);
var
sx, sy : Integer;
begin
// Данные действия, проецируют 3D точку на 2D полоскость дисплея
sx := trunc(scr_W / 2 + Stars[i].X * 200 / (Stars[i].Z + 200));
sy := trunc(scr_H / 2 - Stars[i].Y * 200 / (Stars[i].Z + 200));
SetColor(c, c, c); // Устанавливаем цвет
Plot(sx, sy); // Выводим пиксель этого цвета
end;
begin
// Для начала, получим размеры экрана
scr_W := GetWidth; 
scr_H := GetHeight;
// Затем, случайным образом раскидаем звёздочки
randomize;
for i := 1 to MAX_STARS do
begin
Stars[i].X := random(scr_W * 4) - scr_W * 2;
Stars[i].Y := random(scr_H * 4) - scr_H * 2;
Stars[i].Z := random(1900);
end;
 
// Очистка содержимого дисплея (чёрный цвет) 
SetColor(0, 0, 0);
FillRect(0, 0, scr_W, scr_H); 
 
time := GetRelativeTimeMs;
// Главный цикл отрисовки
repeat
dt := GetRelativeTimeMs - time; // Сколько мс прошло, с прошлой отрисовки
time := GetRelativeTimeMs; // Засекаем время
for i := 1 to MAX_STARS do
begin
// Затираем звёздочку с предыдущего кадра
SetPix(0);
// Изменяем её позицию в зависимости прошедшего с последней отрисовки времени
Stars[i].Z := Stars[i].Z - SPEED * dt/1000;
// Если звезда "улетела" за позицию камеры - генерируем её вдали
if Stars[i].Z &lt;= -200 then
begin
Stars[i].X := random(scr_W * 4) - scr_W * 2;
Stars[i].Y := random(scr_H * 4) - scr_H * 2;
Stars[i].Z := 1900; // Откидываем звезду далеко вперёд :)
end;
// Рисуем звёздочку в новом положении (цвет зависит от Z координаты)
SetPix(trunc(255 - 255 * (Stars[i].Z + 200) / 2100));
end;
// Выводим текст по центру экрана
SetColor(255, 0, 0);
DrawText(HELLO, (scr_W - GetStringWidth(HELLO))/2, 0);
// Всё что было нами нарисовано - выводим на дисплей
repaint;
until GetKeyClicked = KE_KEY0; // Закрыть приложение при нажатии "0"
end.
</pre>

<p>Собственно, запустив эту программу на своём телефоне, Вашему счастью не будет предела.</p>
<p>Вывод спрайтов</p>
<img src="/pic/clip0154.gif" width="128" height="128" border="0" alt="clip0154"></p>
<p>Рисование точек, эллипсов, прямых это весело по началу. Но вскоре захочется вставить какой-нибудь рисунок, картинку, спрайт и т.п.<br>
 <br>
Как раз для этих случаев MIDletPascal имеет в своём распоряжении набор функций для работы с графикой загруженной из внешних файлов или ресурсов.<br>
 <br>
Итак, для опытов с графикой, предлагаю попытаться вспомнить о старой, и многими уже давно забытой игре на Dendy - "Battle City". Для начала нам понадобится 4 изображения одного и того же танка повёрнутого на углы pi/2 * n. Эти изображения должны быть в виде png файлов размером 16х16 пикселей, с именами вида tankN.png (где N - порядковый номер изображения, начиная с 0). Почему такие мелкие? Да потому, что далеко не на всех телефонах стоят дисплеи с разрешением выше 128х128 (по крайней мере, так было на момент написания статьи ;).<br>
<p></p>
<img src="/pic/clip0155.gif" width="64" height="16" border="0" alt="clip0155"></p>
<p>Нарисовав это чудо техники, создадим новый проект, и первым же делом добавим эти файлы в ресурс при помощи &#8220;Project - Import resource file...&#8221;. Наш танк должен уметь ездить по нажатию на соответствующие клавиши и ни в коем случае не выезжать за пределы поля! Приступим к написанию кода:</p>
<pre>
program Tank;
const
SPEED = 1; // Скорость движения танка
var
i : Integer;
// Внешний вид танка при различных углах поворота
tank : array [0..3] of image;
dir : Integer; // направление
X, Y : Integer; // позиция
key : Integer;
begin
// Инициализация
for i := 0 to 3 do // Подгружаем все картинки из ресурса
tank[i] := LoadImage('/tank' + chr(48 + i) + '.png'); // 48 - код нуля
dir := 0; // смотрим строго направо
X := 32; // позиция танка по X
Y := 32; // и по Y соответственно :)
 
// Подготовка поля вывода
SetColor(0, 0, 0);
FillRect(0, 0, GetWidth, GetHeight);
 
// Отрисовка и обработка ввода
repeat
// Стираем танк
FillRect(X, Y, 16,16);
// Получаем код зажатой клавиши
key := GetKeyPressed;
// Вот что бывает, когда нет возможности использовать case ;)
if key = KE_KEY6 then
begin
dir := 0;
X := X + SPEED;
end else
if key = KE_KEY8 then
begin
dir := 1;
Y := Y + SPEED;
end else
if key = KE_KEY4 then
begin
dir := 2;
X := X - SPEED;
end else
if key = KE_KEY2 then
begin
dir := 3;
Y := Y - SPEED;
end;
// контролируем выход за границы экрана
if X &lt; 0 then X := 0;
if Y &lt; 0 then Y := 0;
if X &gt; GetWidth - 16 then X := GetWidth - 16;
if Y &gt; GetHeight - 16 then Y := GetHeight - 16;
// Рисуем танк новой позиции
DrawImage(tank[dir], X, Y);
// Вывод этого безобразия на экран и задержка на 20 мс 
repaint; 
delay(20);
until GetKeyClicked = KE_KEY0; // Закрыть приложение при нажатии "0"
end.
</pre>
<p>Целью написания полноценной игры я не задавался, так что оставлю врагов, стрельбу и препятствия на Вашей совести... ;)</p>
<p>Звук и Музыка</p>
<img src="/pic/clip0156.gif" width="128" height="128" border="0" alt="clip0156"></p>
<p>Игры, как правило, состоят не только из поочерёдно сменяющихся картинок, но и имеют хоть какое-то, но звуковое сопровождение. MIDletPascal поддерживает проигрывание всего одного аудиопотока! Т.е. слышать звук разрывающихся снарядов, под пятую сонату Бетховена не получится. Это есть жирный минус и один из многих камней в огород MIDletPascal. Впрочем, разработчики оставили возможность подключения своих модулей написанных на Java... но мы же пишем на Pascal! ;)<br>
 <br>
Итак, мы имеем возможность проигрывания midi, wav, mp3 и au файлов. Но в то же время, накладываются ограничения самого телефона, и об этом не стоит забывать. Существует возможность loop&#8217;инга, т.е. проигрывания одного и того же звука несколько раз подряд.<br>
 <br>
<p>Прежде чем что-либо писать, необходимо найти какой-нибудь midi файл, и обозвав его &#8220;music.mid&#8221; добавить в ресурс проекта. Теперь можно приступать к написанию кода. Далее опишу код простой программки выводящей пучок &#8220;болтающихся под музыку щупалец&#8221;, заодно познакомив с некоторыми математическими функциями:</p>
<pre>
program vis;
const
S = 12; // Кол-во щупалец
N = 8; // Кол-во звеньев в каждом из них
var
i, j : Integer;
x, y : Real;
tx, ty : Real;
k, d : Real;
// Углы поворота звеньев относительно друг-друга
a : array [1..N] of Real;
// Длина одного звена
len : Real;
 
begin
// Инициализация звука
if not OpenPlayer('/music.mid', 'audio/midi') then // загрузка музыки
Halt; // ошибка при загрузке (не поддерживается midi формат или звук отключен)
if not SetPlayerCount(-1) then // проигрывать бесконечное число раз 
Halt;
if not StartPlayer then // начать проигрывание
Halt;
// Нам необходимо создать что-то графическое...
// Расчёт длины звена, в зависимости от размеров экрана
if GetWidth &gt; GetHeight then
len := GetHeight/2/N
else
len := GetWidth/2/N;
randomize;
k := random(360) * pi / 180;
d := pi * 2 / S; // просто оптимизиация
// Главный цикл
repeat
// Расчёт коэфицента поворота
if random(50) = 0 then
k := random(360) * pi / 180;
// Поворот всех щупалец
a[1] := a[1] + sin(k)/10;
// Интерполяция углов между щупальцами
for i := 2 to N do
a[i] := a[i] + (a[i - 1] - a[i]) * 0.1;
// Рисуем результат (под музыку ;)
SetColor(0, 0, 0);
FillRect(0, 0, GetWidth, GetHeight); // Стираем всё
for j := 0 to S - 1 do
begin
x := 0.5 * GetWidth;
y := 0.5 * GetHeight;
for i := 2 to N do
begin
SetColor(255, trunc(255 - 255 * i/N), 255);
// Немного школьной тригонометрии :) 
tx := x + cos(j * d + a[i]) * len;
ty := y + sin(j * d + a[i]) * len;
DrawLine(trunc(x), trunc(y), trunc(tx), trunc(ty));
x := tx;
y := ty;
end;
end;
// Вывод на дисплей
repaint;
until GetKeyClicked = KE_KEY0; // Закрыть приложение при нажатии "0"
StopPlayer;
end.
</pre>
<p>Самыми медленными операциями в этой программе являются вызовы тригонометрических функций (sin и cos). Существует возможность их оптимизации при помощи использования заранее рассчитанных таблиц значений. Помимо этого, скорость работы данного приложения на различных телефонах может быть различной...</p>
<p>Заключение</p>
<p>Хочу сказать несколько слов по поводу MIDletPascal IDE... До Delphi IDE ему, конечно же, дальше некуда, и постоянно выскакивающие ошибки при компиляции, суть которых не понятна (часто обычный pascal код разобрать не может :) Но вцелом, среда достаточно удобная. Сам язык является по сути &#8220;обрезанным&#8221; паскалем. Имеются записи (record), массивы (array) и другие полезные &#8220;штучки&#8221;, но никакого ООП присущего той же Java не имеется. Т.е. язык по сути является обычным процедурным паскалем без некоторых операторов (case например)<br>
 <br>
<p>Также имеются дополнительные возможности, такие как: работа с HTTP, отправка SMS, стандартный пользовательский интерфейс, подключение Java модулей и др. Но при серьёзном подходе к написанию мидлетов, MIDletPascal будет ограничивать Вас везде, куда бы Вы ни сунулись... ;)</p>
<p>Ссылки по теме</p>
<p>- http://mobilebasic.com<br>
- http://midletpascal.com<br>
<p>- <a href="https://www.j2meforums.com/yabbse/index.php?board=4" target="_blank">https://www.j2meforums.com/yabbse/index.php?board=4</a></p>

<div class="author">Автор: XProger</div>
<p><a href="https://www.mirgames.ru" target="_blank">https://www.mirgames.ru</a></p>

