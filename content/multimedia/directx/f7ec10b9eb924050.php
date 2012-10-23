<h1>Blitting, спрайты и анимация</h1>
<div class="date">01.01.2007</div>


<p>Для тех, кто интересуется, что это за слово такое "JEDI"&#8211; выберите в Delphi 5 пункт меню Help-&gt;About и наберите слово JEDI, удерживая нажатой клавишу Alt. Вы узнаете, что JEDI &#8211; это аббревиатура, расшифровывающаяся как Join Endeavor of Delphi Innovators. (на русский это можно перевести приблизительно &#8211; Совместные Усилия Дельфийских Новаторов или еще лучше - все для Delphi, все для победы) :-).</p>
<p>Звучит красиво, но нам-то что до этого? На самом деле нам до этого есть дело &#8211; в рамках проекта JEDI (кстати, некоммерческого и держащегося на энтузиазме, пусть и с официальным одобрением Borland), в рамках именно этого проекта были созданы заголовочные файлы DirectX для Delphi. Так скачаем же их! (http://www.delphi-jedi.org/DelphiGraphics/)</p>
<p>Итак, заголовочные фалы у нас есть. Более того &#8211; мы умеем инициализировать Direct Draw, создавать Surface'ы и загружать на них картинки. (Если Вы забыли как это делается &#8211; перечитайте первые две главы).</p>
<p>Наконец то мы приблизились к самому интересному. Спрайты. Анимация. Blitting.</p>
<p>Blitting -непереводимое на русский язык слово. Тоже кстати аббревиатура - bit block transfer &#8211; пересылка блоков бит. Благодаря этой пересылке, мы можем скопировать прямоугольную область из одной части Surface'а в другую или из одного Surface'а в другой. Такое копирование происходит пересылкой байт в видеопамяти, отсюда и название - bit block transfer. Да конечно, ничего удивительного в копировании прямоугольных участков Вы не видите &#8211; это можно и без DirectDraw сделать кучей способов… Стоп! Прежде чем Вы начнете перечислять эти способы &#8211; Blitting с использованием DirectDraw самый быстрый. Тем паче, что большинство современных видеоадаптеров поддерживают его на аппаратном уровне. Чувствуете, к чему я клоню? Стоит разобраться с Blitting'ом внимательнее.</p>
<p>Итак, для копирования прямоугольных участков интерфейс IDirectDrawSurface имеет два метода: IDirectDrawSurface4::Blt и IDirectDrawSurface4::BltFast. Как видно из названия второй быстрее &#8211; с него и начнем.</p>
<pre>
function BltFast(dwX: DWORD;
  dwY: DWORD;
  lpDDSrcSurface: IDirectDrawSurface4;
  lpSrcRect: PRect;
  dwTrans: DWORD): HResult;
</pre>


<p>Копирует прямоугольный участок из Surface'а-источника, задаваемого параметром lpDDSrcSurface. Первые два параметра метода &#8211; dwX и dwY &#8211; координаты верхнего левого угла прямоугольника на принимающем Surface'е - в эту точку будет скопирован прямоугольный участок, размеры которого задаются структурой типа TRect (параметр lpSrcRect типа PRect &#8211; указатель на TRect). (для тех, кто не знаком с типом TRect &#8211; познакомьтесь с ним в справке Delphi) Параметр dwTrans &#8211; набор флагов, о них чуть позже. Использовать BltFast можно, например, так:</p>
<pre>
// копируем прямоугольник, размер которого задается переменной
// Kvadratik из Surface'а AnotherSurface в PrimarySurface.
PrimarySurface.BltFast(10, 10, AnotherSurface, Kvadratik,
  DDBLTFAST_NOCOLORKEY or DDBLTFAST_WAIT);
</pre>


<p>Если вызвать этот метод, передав в качестве параметров dwX и dwY нулевые значения, а вместо указателя на ограничивающий прямоугольник lpSrcRect &#8211; nil, то будет скопирован весь Surface-источник.</p>
<p>Вторая функция</p>
<pre>
function Blt(lpDestRect: PRect;
  lpDDSrcSurface: IDirectDrawSurface4;
  lpSrcRect: PRect;
  dwFlags: DWORD;
  lpDDBltFx: PDDBltFX): HResult;
</pre>

<p>Здесь координаты принимающего (lpDestRect) и передающего (lpSrcRect) Surface'ов задаются с помощью структур TRect. Размеры передающего и принимающего прямоугольников могут быть не равны! Функция Blt выполнит масштабирование автоматически. Но возможности Blt этим не ограничиваются: можно использовать его для закрашивания областей экрана определенным цветом (dwFlags:=DDBLT_COLORFILL, lpDDBltFx.dwFillColor:= цвет), можно зеркально переворачивать копируемый прямоугольник по горизонтали или по вертикали (dwFlags:=DDBLT_DDFX, lpDDBltFx.dwDDFX:=DDBLTFX_MIRRORUPDOWN или DDBLTFX_MIRRORLEFTRIGHT), поворачивать его на 90, 180, 270 градусов (dwFlags:=DDBLT_DDFX, lpDDBltFx.dwDDFX:= DDBLTFX_ROTATE90 или DDBLTFX_ROTATE180 или DDBLTFX_ROTATE270), поворачивать на любой заданный угол (угол задается в 1/100-х градуса) (dwFlags:= DDBLT_ROTATIONANGLE, lpDDBltFx.dwRotationAngle:=угол поворота)…. и делать еще многое другое. За все эти удовольствия приходится расплачиваться быстродействием &#8211; Blt обладает многими возможностями, которых нет в BltFast, но работает чуть медленнее.</p>
<p>Кстати о скорости. Несмотря на потрясающую скорость Blitting-операций, использующих всю мощь аппаратного ускорения, может возникнуть ситуация, когда видеоадаптер еще не успел закончить пересылку одного блока байт, а наша программа уже просит его сделать другую. Что будет в таком случае? Катастрофа? Нет. Просто функция Blt или BltFast вернет код ошибки DDERR_WASSTILLDRAWING. Чтобы такого не происходило, можно указать Blitting-функциям, что им следует ждать, не возвращая управления до тех пор, пока видеоадаптер не выполнит операцию. Для этого при вызове функции Blt параметру dwFlags нужно присвоить значение DDBLT_WAIT, а при вызове BltFast - значение DDBLTFAST_WAIT параметру dwTrans.</p>
<p>Самое время рассказать, наконец, поподробнее о параметре dwTrans функции BltFast. Кроме флага, используемого для приостановки программы на время неготовности видеоадаптера, этот параметр используется для указания цветового ключа (Color Key).</p>
<p>Цветовой ключ &#8211; очень полезная штука, из разряда тех, которые следовало бы изобрести, если бы их не было. Цветовой ключ &#8211; это один или, несколько цветов, предназначенных для изображения "прозрачного" цвета. Пикселы окрашенные этим цветом не копируются при Blitting'е. Это позволяет создавать иллюзию непрямоугольного изображения, хотя при Blitting'е копируются только прямоугольные области. Делается это вот как: рисуем (или просим нарисовать кого-нибудь у кого это хорошо получается) какую-нибудь картинку, ограниченную прямоугольной областью. Все пикселы этой прямоугольной области, которые не относятся к картинке, закрашиваем каким-то особым цветом, который не использовался в самой картинке. Этот особый цвет назначаем в качестве цветового ключа &#8211; при Blitting'е он не будет копироваться, и вместо пикселов, окрашенных этим цветом, останутся пикселы фона &#8211; возникнет иллюзия прозрачности. Такая картинка, в прямоугольной области, заполненной цветовым ключом называется "спрайт".</p>
<p>Итак, параметр dwTrans функции BltFast может принимать следующие, кроме уже знакомого нам DDBLTFAST_WAIT, значения:</p>
<p>DDBLTFAST_NOCOLORKEY &#8211; цветовой ключ не используется;</p>
<p>DDBLTFAST_SRCCOLORKEY - используется цветовой ключ Surface'а &#8211;источника;</p>
<p>DDBLTFAST_DESTCOLORKEY - используется цветовой ключ Surface'а &#8211;приемника;</p>
<p>Аналогично, при использовании цвтового ключа с функцией Blt, ее параметру dwFlags присваивают значение DDBLT_KEYSRC (цветовой ключ источника) или DDBLT_KEYDEST (цветовой ключ приемника).</p>
<p>Для задания цветового ключа предназначена специальная структура TDDColorKey. Вот ее описание</p>
<pre>
TDDColorKey = packed record
  dwColorSpaceLowValue: DWORD;
  dwColorSpaceHighValue: DWORD;
end;
</pre>


<p>Как видите это запись, состоящая из двух полей типа DWORD, поле dwColorSpaceLowValue &#8211; означает нижнюю границу диапазона цветов, который используется в качестве цветового ключа, dwColorSpaceHighValue - верхнюю границу диапазона цветов.</p>
<p>Пример задания цветового ключа:</p>
<pre>
{для 8 - битового палитрового режима}
dwColorSpaceLowValue := 26;
dwColorSpaceHighValue := 26;
// 26 - ой элемент палитры будет использоваться как цветовой ключ.
 
{для 24 - битового безпалитрового режима}
dwColorSpaceLowValue = RGB(255, 128, 128);
dwColorSpaceHighValue = RGB(255, 128, 128);
// Цвет RGB(255, 128, 128) – будет считаться прозрачным.
</pre>

<p>Естественно, для Blitting'а спрайт должен находится на каком-то Surface. А у Surface'а для указания цветового ключа есть специальный метод: IDirectDrawSurface4.SetColorKey, который принимает в качестве параметра указатель на структуру типа TDDColorKey, описывающую цветовой ключ.</p>
<p>Итак, с помощью Blitting'а можно вывести на экран спрайт. Можно перемещать его по экрану, каждый раз восстанавливая фон, который был под спрайтом и выводя спрайт в соседнее место. А что если не просто перемещать спрайт, а сделать так, чтобы при перемещении сама картинка спрайта менялась? Так можно получить анимацию, бегущую лошадь, например. Для этого при каждом Blitting'е нужно выводить не одну и ту же картинку спрайта, а картинку следующей фазы движения, заставляя, например, ту же лошадь перебирать ногами. Естественно для этого нужно заранее нарисовать картинку со всеми фазами движения и загрузить ее на какой-то Surface, выводя с этого Surface'а при каждой итерации только определенную часть картинки, соответствующую текущей фазе анимации. А если анимированных спрайтов не один, а много? Алгоритм работы программы в этом случаем может быть таков:</p>
<p>Алгоритм 1.</p>
<p>Подготовить два Surface'а &#8211; Primary (видимый на экране) и BackBuffer &#8211; они будут учавствовать во flip-цепочке (см. первую главу). Кроме того, понадобятся Surface'ы для хранения фонового изображения и для хранения всех изображений всех спрайтов. Загрузить на Surface'ы соответствующие изображения (см. вторую главу).</p>
<p>Занести в BackBuffer-Surface изображение фоновой картинки, выполнив BltFast с соответствующего Surface'а (тем самым удалив на нем спрайты если они там были).</p>
<p>Занести в BackBuffer-Surface изображения всех спрайтов, поверх картинки фона, используя цветовые ключи, каждый в соответствующие координаты, и каждый в соответствующей фазе движения. Это можно сделать либо функцией BltFast либо функцией Blt.</p>
<p>Выполнить Flip. Очередной кадр анимации появится на экране. Подождать некоторое время (если необходимо) и повторить с шага 2.</p>
<p>Этот примерный алгоритм можно усовершенствовать, ведь на шаге 2 перерисовывается вся картинка фона, можно, зная координаты всех спрайтов, перерисовывать только ту часть фоновой картинки, на которой находятся спрайты, требующие перемещения.</p>
<p>Пожалуй, пришло время попробовать все это на практике. Посмотрите на мой пример (DDrawPrimer3.zip 80K ). Программа-пример инициализирует DirectDraw, создает три Surface'а, два размером 640Х480 (т.е. на весь экран) (FPrimarySurface и FPictureSurface), и один маленький (FSpriteSurface), для хранения изображения спрайта, и загружает на них соответствующие картинки, на FPrimarySurface и FPictureSurface &#8211; изображение фона, а на FSpriteSurface &#8211; изображения спрайта. В этом нет ничего нового, с этим Вы уже познакомились в первых двух главах. Вы можете открыть изображение из файла Sprite.bmp, которое загружается на FSpriteSurface и убедится, что там находятся изображения для всех фаз анимации спрайта (я пытался нарисовать что-то вроде жучка, перебирающего ногами, но похоже получилось нечто, больше смахивающее на муравья). В моем примере для простоты, я несколько отошел от Алгоритма 1 &#8211; вместо рисования на BackBuffer'e c последующим вызовом функции Flip я рисую непосредственно на главном, видимом Surface. Это может привести к небольшому миганию спрайта при перерисовке, но я думаю, в нашем примере это не так уж и существенно &#8211; мне не хотелось его слишком усложнять.</p>
<p>В каждой итерации на PrimarySurface сначала выводится фоновая картинка, тем самым стирается старое изображения спрайта, а затем новое изображение спрайта (на котором жучок уже чуть-чуть сдвинул лапки) выводится в новые координаты. Просмотрите текст программы, она, на мой взгляд, снабжена достаточным количеством комментариев. Вы можете несколько модифицировать мою программу, обновляя каждый раз не всю фоновую картинку, а только прямоугольный участок, на котором находится изображение спрайта, которое нужно стереть. Попробуйте также выводить не одно изображение спрайта, а несколько, двигая их в разных направлениях.</p>
<p>Если Вы хорошо знакомы с объектно-ориентированным подходом в программировании, Вы, безусловно, подвергнете Алгоритм 1 беспощадной (и справедливой) критике. В самом деле, почему бы не создать специальный класс спрайта, который сам бы перерисовывал себя при каждой итерации, зная свои старые и новые координаты. Можно было бы снабдить этот класс методами, автоматически меняющими картинку спрайта при анимации, регулирующими скорость анимации и т.п. Что ж, это очень неплохая идея. Я надеюсь рассказанная мной информация послужит Вам подспорьем для создания чего-то подобного. Впрочем можно воспользоваться и каким-либо готовым спрайтовым "движком", например тем, что входит в состав набора компонент DelphiX. Спрайтовый Engine от Hiroyuki Hori очень неплох. Примеры его использования входят в поставку DelphiX &#8211; они находятся в каталогах \Samples\Sprite\Basic и \Samples\Sprite\Shoot.</p>
<p>На этом я пока заканчиваю рассказ о DirectDraw &#8211; присылайте свои предложения и замечания: aziz@telebot.com или error@softhome.net.</p>
<div class="author">Автор: Азиз (JINX)</div>

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
