<h1>DirectX и Delphi</h1>
<div class="date">01.01.2007</div>


<p>Перед тем как приступить я хотел бы сделать пару оговорок. Во-первых для использования DirectX в Delphi необходим файл с заголовками, где объявлены имена функций DirectX API либо какой-нибудь компонент, позволяющий обращаться к интерфейсу DirectX через свои методы. В момент написания сего опуса я использую компонент DelphiX (автор - Hiroyuki Hori), распространяемый бесплатно - http://www.yks.ne.jp/~hori/DelphiX-e.html. (если у вас есть что-нибудь получше и Вы поделитесь со мной - я буду очень признателен.) </p>
<p>И еще один адрес, по которому можно скачать компонент DelphiX : http://www.torry.ru/vcl/packs/hhdelphix.zip</p>

<p>По возможности я буду писать и названия методов DelphiX и названия соответствующих интерфейсов Directx API &#8211; чтоб вам легче было ориентироваться в DirectX SDK. Во-вторых при всем своем гипертрофированном самомнении я не могу назвать себя экспертом в области DirectX &#8211; так что не судите чересчур строго. Я надеюсь сие творение хоть как то сможет помочь делающим первые шаги в DirectX &#8211; если Вы круче меня &#8211; буду признателен за помощь и указание на ошибки (коих увы наверняка сделал немало (честное слово не нарочно :-) ) Оговорка без номера &#8211; я пишу эти строки в те времена когда последней версией DirectX является DirectX 6. </p>

<p>Ну что ж приступим пожалуй. </p>

<p>Как известно DirectX предназначен в основном для программирования игр под Windows 9x. Тем не менее можно придумать еще не мало ему применений (рано или поздно грядет таки эра повсеместного трехмерного пользовательского интерфейса). DirectX состоит из следующих компонентов: </p>

<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>DirectDraw® - предназначен для программирования всевозможных анимаций за счет быстрого доступа к изображению на экране и к видеопамяти, а также за счет использования возможностей аппаратуры (видеоадаптера) по манипуляции с буферами. </td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>DirectSound® - как видно из названия позволяет выводить звук, используя все что можно выжать из Вашей звуковой карты (ну почти все) </td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>DirectMusic™ - музыка. В отличие от DirectSound работает не с оцифрованным звуком (WAV) а с музыкальными командами, посылаемыми звуковой карте. </td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>DirectPlay® - упрощает жизнь программиста, решившегося добавить в своей программе возможность совместной работы (игры) по сети и по модему. (это наверняка хорошо знакомо любому геймеру) </td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>Direct3D® (мой любимый J) &#8211; содержит высокоуровневый интерфейс Retained Mode позволяющий легко выводить 3-хмерные графические обьекты, и низкоуровневый интерфейс Immediate Mode предоставляющий полный конроль над рендерингом. (если кто-нибудь знает как будет рендеринг по-русски &#8211; мой адрес в конце статьи) </td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>DirectInput® - поддержка устройств ввода. Пока джойстик, мышь, клавиатура и т.д. &#8211; впрочем можете быть уверены &#8211; если появится еще что &#8211; за Microsoft не заржавеет. </td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>DirectSetup &#8211; предназначен для установки DirectX. </td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>AutoPlay &#8211; самый обычный AutoPlay &#8211; позволяет запускать какую-нибудь программу (инсталяшку или саму игру) при установке CD-диска в дисковод. Вообще-то описание AutoPlay относится к Win 32 SDK и просто повторяется в DirectX SDK (думаю Microsoft включила его в DirectX SDK просто чтоб оно было под рукой у разработчика) </td></tr></table></div>
<p>Кое что о Direct3DRM®. (Reatined Mode) </p>

<p>Система координат </p>
<p>В Direct3D она соответствует так называемому правилу "левой руки". Суть правила в том, что если Вы растопырите пальцы левой руки так, что указательный палец будет направлен к экрану, большой к потолку, а средний параллельно столу туда, где обычно лежит мышиный коврик, то большому пальцу будет соответствовать координата Y, среднему &#8211; X, указательному Z. Говоря короче координата Z направлена как бы вглубь экрана (я во всяком случае нахожусь по эту его сторону :-)), координата Y &#8211; вверх, координата X &#8211; вправо (все рисунки из SDK). Возможно Вам это покажется непривычным. А что Вы тогда скажите на это &#8211; в DirectX цвета задаются тремя составляющими R,G,B, каждая из которых &#8211; число с плавающей точкой в диапазоне [0-1]. Например белый цвет &#8211; (1,1,1), серенький (0.5,0.5,0.5), красный (1,0,0) ну и т.д. </p>

<img src="/pic/clip0042.png" width="226" height="154" border="0" alt="clip0042"></p>

<p>Все трехмерные объекты задаются в виде набора (mesh) многоугольников (граней &#8211; faces). Каждый многоугольник должен быть выпуклым. Вообще-то лучше всего использовать треугольники &#8211; более сложные многоугольники все равно будут разбиты на треугольники (на это уйдет столь драгоценно процессорное время). Грани (faces) состоят из вершин (vertex). </p>

<img src="/pic/clip0043.png" width="457" height="176" border="0" alt="clip0043"></p>

<p>Грань становится видимой если она повернута так, что образующие ее вершины идут по часовой стрелке с точки зрения наблюдателя. Отсюда вывод &#8211; если Ваша грань почему-то не видна &#8211; переставьте вершины так, чтоб они были по часовой стрелке. Кроме того имеются другие объекты &#8211; источники света (прямой свет - directional light и рассеянный свет &#8211; ambient light), т.н. камера, текстуры, которые могут быть "натянуты" на грани и прочая, прочая… Наборы объектов составляют т.н. frames (затрудняюсь дать этому русское название). В Вашей программе всегда будет хоть один главный frame, называемый сцена (scene), не имющий фрейма-родителя, остальные фреймы принадлежат ему или друг другу. Я не буду долго разговаривать о том, как инициализировать все это хозяйство, для Дельфи-программиста достаточно разместить на форме компонент TDXDraw из библиотеки DelphiX. </p>

<p>Перейдем однако к делу. Запустите-ка Дельфи и откройте мою (честно говоря не совсем мою &#8211; большую часть кода написал Hiroyuki Hori &#8211; однако не будем заострять на этом внимание :-)) учебную программку - Sample3D. </p>
<p>Найдите метод </p>

<p>TMainForm.DXDrawInitializeSurface.</p>

<p>Этот метод запускается при инициализации компонента TDXDraw. Обратите внимание, что DXDraw инкапсулирует D3D, D3D2, D3Ddevice, D3DDevice2, D3DRM, D3DRM2, D3DRMDevice, D3DRMDevice2, DDraw &#8211; ни что иное как соответствующие интерфейсы DirectX. (только в названиях интерфейсов Microsoft вместо первой буквы D слово IDirect). Инициализация компонента очень подходящее место, чтоб выбрать кое какие режимы (что и делается в программке). Обратите внимание на DXDraw.D3DRMDevice2.SetRenderMode(D3DRMRENDERMODE_BLENDEDTRANSPARENCY or D3DRMRENDERMODE_SORTEDTRANSPARENCY); - Эти два флага установлены вот для чего &#8211; если у нас два треугольника находятся один под другим и оба видны (т.е. вершины у них по часовой) нужно их сперва отсортировать по координате Z чтоб понять кто кого загораживает. Включает такую сортировку флаг, названный скромненько эдак, по Microsots-ки: D3DRMRENDERMODE_SORTEDTRANSPARENCY. Однако как говаривал К. Прутков &#8211; смотри в корень. Корнем же у нас является метод </p>

<p>TMainForm.DXDrawInitialize(Sender: TObject);</p>

<p>Здесь сначала создаются два фрейма &#8211; Mesh и Light, для нашего видимого объектика и для лампочки, его освещающей. </p>

<p>MeshFrame.SetRotation(DXDraw.Scene, 0.0, 10.0, 0.0, 0.05);</p>

<p>(первые три цифры &#8211; координаты вектора вращения, последний параметр &#8211; угол полворота) . Тонкое (не очень правда :-)) отличие между методами SetRotation и AddRotation в том, что AddRotation поворачивает объект только один раз, а SetRotation &#8211; заставляет его поворачиваться на указанный угол при каждом следующей итерации (with every render tick) Потом создается т.н. MeshBuilder &#8211; специальный объект, инкапсулирующий методы для добавления к нему граней. Этот обьект может быть загружен из файла (и естественно сохранен в файл). По традиции файлы имеют расширение X. (насколько мне извесно эта традиция возникла еще до появления сериала X-Files :-)) В самом же деле &#8211; в конце 20 века задавать координаты каждого треугольника вручную… Можно заставит сделать это кого то еще &#8211; а потом просто загрузить готовый файл :-). Ну а если серьезно в DirectX SDK входит специальная утилита - conv3ds. {conv3ds converts 3ds models produced by Autodesk 3D Studio and other modelling packages into X Files. } </p>

<p>Однако создадим объект вручную &#8211; ну их эти Х-файлы. Наш объект будет состоять из 4-х граней (ни одного трехмерного тела с меньшим количеством граней я не смог придумать). Естественно каждая грань &#8211; треугольник, имеющий свой цвет. </p>

<p>MeshBuilder.Scale(3, 3, 3); - Увеличиваем в три раза по всем координатам.</p>

<p>Наконец MeshFrame.AddVisual(MeshBuilder); - наш MeshBuilder готов, присоединяем его как визуальный объект к видимому объекту Mesh. </p>

<p>DXDraw.Scene.SetSceneBackgroundRGB(0,0.7,0.7); -</p>

<p>Как понятно из названия метода цвет фона. (Видите &#8211; я не врал RGB-цвет действительно задается числами с плавающей точкой :-)) Интересные дела творятся в методе TMainForm.DXTimerTimer. (небольшая тонкость &#8211; это не обычный таймер, а DXTimer из библиотеки DelphiX) </p>

<p>DXDraw.Viewport.ForceUpdate(0, 0, DXDraw.SurfaceWidth, </p>
<p>  DXDraw.SurfaceHeight); </p>

<p>указываем область, которую нужно обновить (не мудрствуя лукаво &#8211; весь DXDraw.Surface) </p>

<p>DXDraw.Scene.Move(1.0); </p>

<p>- применяем все трехмерные преобразования, добавленные методами вроде AddRotation и SetRotation к нашей сцене. (вот где собака то порылась… :-) вычисления новых координат точек начнутся не сразу после метода AddRotation а только здесь) </p>
<p>DXDraw.Render &#8211; Рендерим (ну как же это по русски то? :-))</p>
<p>DXDraw.Flip &#8211; выводим результат рендеринга на экран (аминь :-)); </p>

<p>(в этом методе помещены также несколько строк, выводящих на экран число кадров в секунду и информацию о поддержке Direct3D аппаратурой или программно &#8211; пригодится при отладке) Метод FormKeyDown. </p>

<p>Здесь проверяется код нажатой клавиши &#8211; если Alt+Enter &#8211; переходим из оконного в полноэкранный режим (клево, правда? :-)) и наоборот. Напоследок пара слов о DXDrawClick. </p>

<p>Просто выводим FileOpenDialog &#8211; Вы можете поэкспериментировать с x-файлами. Пока все. Вот уж не думал, что это будет так трудно. Надеюсь хоть кто-то дочитал до этого места. </p>

<p>Пишите: aziz@telebot.net, error@softhome.net </p>

<p class="author">Автор: Азиз (JINX)</p><p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
