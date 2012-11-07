<h1>GLScene</h1>
<div class="date">01.01.2007</div>

<p>Легкий путь в GLScene</p>
Автор: gamebiztalk</p>
<p>        Первый материал в рубрике "Технологии" ставит своей целью рассказать о возможностях GLScene и оценить (качественно, на уровне кода и примеров) трудоемкость кодирования на примере демосцены или игры.</p>
<p>        Конечно, GLScene сложно назвать игровым движком - это всего лишь объектная надстройка над OpenGL для Borland Delphi версий 4.0-7.0. Тем не менее, в ней есть все необходимые инструменты для управления камерами, текстурами, графическими моделями, анимацией, звуком, обработки коллизий и создания интерфейса пользователя. К несомненным плюсам GLScene относятся расширяемость, доступность исходных текстов графической библиотеки и качественная поддержка. Потому пусть вас не смущают мнения о том, что Borland Delphi не самое лучшее средство для разработки игр - по силам GLScene игры с вполне современной графикой. Библиотека поддерживает большое число функций от мультитекстурирования объектов различной формы, манипуляции осями координат и рендеринга ландшафтов по карте высот до трассировки лучей, теней в реальном времени и непременно шейдеров. Иными словами, с интересной идеей, опытным 3D-дизайнером и желанием довести проект до финала система Delphi и библиотека GLScene - не самые худшие варианты для Shareware- и недорогих коммерческих игр.</p>
<p>        В GLScene, пожалуй, не все возможности удобны: дизайнер 3D-сцен, доступный в IDE, ограничен функционально, а, скажем, рендеринг ландшафтов довольно громоздок и запутан. С другой стороны, эта библиотека интересна тем, что в программах допускается использовать функции OpenGL и, как следствие, расширять и без того не маленькие ее возможности.</p>
<p>Внутри сцены</p>
<p>Стабильная версия библиотека GLScene и множество примеров доступна на сайте http://www.glscene.org/. Мы рекомендуем вам воспользоваться CVS-клиентом и получить самые последние версии модулей. Дело в том, что над совершенствованием библиотеки трудится множество программистов, и компоненты обновляются практически еженедельно. Следующее, что нужно сделать, загрузить документацию с сайта http://www.caperaven.co.za/ - в ней содержится краткое описание модулей и классов GLScene.</p>
<p>Установить GLScene довольно просто; надо лишь открыть соответствующий версии Delphi DPK-файл и нажать кнопку Install. Все модули будут скомпилированы, и в панели компонентов появится секция GLScene с множеством значков-компонентов. Основными являются компоненты GLScene для хранения иерархии визуальных 3D-объектов, GLSceneViewer для отображения сцены в оконном режиме и GLFullScreenViewer - в полноэкранном, GLCadencer для обновления сцены и обработки команд. Кроме того, вам могут понадобиться компоненты GLMaterialLibrary для хранения текстур и материалов и GLGuiLayout для построения интерфейса пользователя. Информация о прочих полезных компонентах собрана в списке.</p>
<p>GLMemoryViewer - служебный компонент для "невидимого" рендеринга 3D-объектов; этот компонент используется для некоторых специальных объектов, например, для расчета теней</p>
ScreenSaver- компонент для создания экранных заставок</p>
GLSDLViewer-компонент для отображения SDL-информации</p>
GLPolygonPFXManager, GLPointLightPFXManager, GLFireFXManager, GLThorFXManager<br>
<p>компоненты для управления визуальными эффектами</p>
GLBitmapFont, GLWindowsBitmapFont <br>
<p>компоненты для описания растрового или Windows-шрифта</p>
GLBitmapHDS, GLCustomHDS, GLHeightTileFileHDS <br>
<p>служебные компоненты для рендеринга ландшафтов</p>
GLCollision<br>
<p>компонент для обработки столкновений</p>
GLSoundLibrary, GLSMWaveOut, GLSMFMMod, GLSMBass<br>
<p>компоненты для работы со звуком</p>
GLNavigator, GLUserInterface<br>
<p>компоненты управление сценой и GUI-программы</p>
Сконструировать простую сцену можно без программирования - пользуясь лишь инспектором свойств и редактором GLScene. Для каждой сцены надо определить объект-камеру, задать положение источника света и затем создать необходимое число 3D-объектов: плоскостей, кубов, сфер, торусов, порталов, ландшафтов и т.д. Ваши действия при этом таковы:</p>
1. Создать новое приложение и поместить в форму компоненты GLScene и GLSceneViewer. Визуальный компонент при этом можно растянуть по всей области окна, задав значение alClient в свойстве Align.</p>
2. Дважды щелкнуть по компоненту GLScene и в появившемся окне создать необходимые объекты: камеру, освещение и невидимый объект DummyCube. DummyCube позволяет группировать 3D-объекты по категориям. Например, все статичные наземные объекты можно расположить в одном DummyCube, а динамичные - в другом. Создание объектов выполняется из контекстного меню или кнопками Add camera/Add object.</p>
Следует иметь ввиду, что каждый объект появляется в координатах с точками (0,0,0), Это не абсолютные, а относительные координаты. Скажем, если вы объявите объект DummyCube, сместите его в точку (2,3,4), а затем создадите объект GLCube, вложенный в DummyCube, то координаты (0,0,0) куба-наследника будут отсчитываться от точки (2,3,4) объекта-предка.</p>
3. Для каждого объекта можно задать направление осей координат (свойство Direction), положение в пространстве (свойство Position) и ряд вспомогательных свойств, которые зависят от его типа. Например, вид проекции, способ освещения, размеры 3D-объекта и т.п.</p>
4. Настроить свойство Material, в котором определяется цвет объекта или текстура, накладываемая на него. Для каждого объекта материалы можно настроить по отдельности, но лучше создать библиотеку материалов GLMaterialLibrary и ссылаться на нее при необходимости в свойствах MaterialLibrary и LibMaterialName.</p>
5. Задать свойство Camera для GLSceneViewer - т.е. указать на одну из существующих камер (в GLScene можно определить несколько камер, но активной может быть только одна).</p>
После этого можно запускать приложение и любоваться созданными вами 3D-объектами. Конечно, пока они неподвижно замерли в пространстве. Чтобы анимировать их - заставить вращаться по осям координат, менять размеры и положение в пространстве, надо ввести дополнительный код.</p>
6. Добавить к форме компонент GLCadencer и в свойстве Scene сослаться на компонент GLScene.</p>
7. Определить событие OnProgress и затем в нем задавать какие-то действия. Например, вращение объекта на 1 градус: object.Turn(1).</p>
Подобным образом созданы многочисленные примеры к объектной библиотеке GLScene. Они сгруппированы по нескольким папкам - в каждой находятся несколько программ, объясняющих, как управлять 3D-объектами (папка Mesh) и материалами (папка Materials), создавать визуальные эффекты с помощью партиклов (папка SpecialFX), обрабатывать столкновения (папка Collision) и т.д. Знакомство с GLScene лучше начать с этих примеров - они позволяют разобраться с координатной системой, преобразованиями и перемещениями объектов в пространстве. Дополнительные примеры и даже небольшие игры доступны на сайте www.caperaven.co.za, а также в news-конференции на сервере talkto.net.</p>
Тонкая ручная работа</p>
Конструировать сцену можно и при исполнении программы. Это бывает необходимо для динамических сцен, когда геометрия уровня загружается из файлов или массивов и постоянно меняется. Инициализировать объекты GLScene можно в событии OnCreate главной формы, например:</p>
<pre>
GLCameraMain:=TGLCamera(GLDummyCube1.AddNewChild(TGLCamera)); 
GLCameraMain.DepthOfView:=1000; 
GLCameraMain.FocalLength:=100; 
GLCameraMain.Direction.SetVector(0,0,-1); 
GLCameraMain.Position.SetPoint(0,128,0); 
GLCameraMain.Pitch(-45); 
GLLightMain:=TGLLightSource(GLCameraMain.AddNewChild(TGLLightSource)); 
GLLightMain.Position.SetPosition(5,15,-15);
</pre>
<p>Инициализацию объектов, загрузку моделей и текстур можно выделить в отдельные процедуры. Скажем, процедура LoadTextures загружает текстуры в память, а InitGLObjects - создает объекты с помощью метода AddNewChild. Состояние сцены, как уже говорилось, изменяется в событии OnProgress объекта GLCadencer. Здесь не только можно вращать объекты, но и обрабатывать нажатия клавиш. Если подключить к программе модуль Keyboard, то функцией IsKeyDown можно фиксировать нажатия и перемещать камеру:</p>
<pre>
speed:=0.1; 
if IsKeyDown(VK_UP) then 
GLCamera1.Translate(speed, 0, speed); 
if IsKeyDown(VK_DOWN) then 
GLCamera1.Translate(-speed, 0, speed); 
</pre>
<p>События от мыши можно обрабатывать и традиционным для Delphi способом - на вкладке Events объекта GLSceneViewer или GLFullScreenViewer перечислены события OnClick, OnDblClick, OnMouseDown, OnMouseMove. С их помощью можно выбирать 3D-объекты мышью, перемещать их - экранные координаты в пространственные конвертируются с помощью специальных функций.</p>
<p>Логику компьютерной игры имеет смысл выделить в отдельный модуль, в котором через массивы, записи или классы описываются переменные, массивы и состояния игры, а также, возможно, выполняется рендеринг. Из главной же формы лишь вызывать соответствующие методы. Скажем, зафиксировать нажатие кнопки мыши в объекте можно в событии OnMouseDown объекта GLSceneViewer, а для обработки действий вызвать специальный метод:</p>
<p>// pick - выбранный объект</p>
<p> 
<p>GameMap.ShowSpecialFX(pick);</p>
<p>Дополнительная информация об объекте, как правило, передается через свойство Tag и TagFloat - если ее много, то можно пойти на хитрость и указать в Tag порядковый номер массива, в котором хранятся детальные сведения об объекте (его координатах, состоянии и т.п.). Все эти "хитрости" зависят от сложности игровой программы и используемых в ней форматов и структур - ведь иногда проще наследовать стандартные объекты GLScene, реализовав дополнительные методы и свойства для управления ими...</p>
Как управлять объектами и материалами, добавлять спецэффекты, отображать надписи и обрабатывать столкновения иллюстрируют следующие примеры на GLScene. Объектная надстройка на OpenGL умеет многое, хотя, возможно, и не все. Но зато она находится в постоянном развитии, неплохо документирован (кроме сайта http://www.caperaven.co.za/, можно побывать и в разделах general и support news-конференций), включает в себя множество примеров и пользуется большой популярностью среди Delphi-программистов (а многие используют GLScene для создания компьютерных игр).</p>
<p>Несколько фрагментов кода, созданных на Delphi/GLScene, - наверное, наиболее наглядный способ разобраться в идеологии GLScene и понять, насколько удобна эта библиотека в реальных приложениях.</p>
<p>1. Использование библиотеки материалов</p>
С помощью компонента GLMaterialLibrary в памяти хранятся текстуры и материалы - это могут быть загружаемые BMP/JPEG-изображения или создаваемые в памяти растровые изображения. Для каждого материала задается его название и ряд дополнительных параметров: режим Blending, доступность, текстурные координаты и др.</p>
<pre>
with GLMatLibrary.Materials.Add do 
begin 
  Name := 'light'; 
  Material.Texture.Image.LoadFromFile('textures\light.jpg'); 
  Material.Texture.TextureMode:=tmModulate; 
  Material.BlendingMode := bmTransparency; 
  Material.Texture.Disabled := False; 
end;  
</pre>
Текстура может быть создана и в оперативной памяти с помощью стандартного объекта TBitmap:</p>
<pre>
texturebw:=TBitmap.Create; 
texturebw.Width := 32; 
texturebw.Height := 32; 
for i:=0 to 31 do 
  for j:=0 to 31 do 
    if Random&lt;0.5 then texturebw.Canvas.Pixels[i,j]:=clSilver else texturebw.Canvas.Pixels[i,j]:=clWhite; 
with GLMatLibrary.Materials.Add do 
  begin 
    Name := 'bw'; 
    Material.Texture.Image.Assign(texturebw); 
    Material.Texture.TextureMode:=tmModulate; 
    Material.Texture.Disabled := False; 
  end;  
</pre>

2. Описание и обработка коллизий для объектов GLSphere</p>
<pre>
// CollisionManagerObjects - менеджер коллизий 
if GLSphere.Behaviours.CanAdd(TGLBCollision) then 
  begin 
    myCollision:=TGLBCollision.Create(nil); 
    myCollision.Manager := CollisionManagerObjects; 
    myCollision.BoundingMode := cbmSphere; 
    GLSphere.Behaviours.Add(myCollision); 
  end; 
</pre>

В событии OnProgress объекта GLCadencer: 
<p>CollisionManagerObjects.CheckCollisions;</p>
Событию OnCollision менеджера коллизий передаются ссылки на два столкнувшихся объекта object1,object2, можно анализировать тип, тег, класс объекта:</p>
<pre>if object1.classname='TGLSphere' Then ShowMessage('столкновение со сферой'); 
if object2.Tag=100 Then object2.Visible:=False; // скрытие объекта  
</pre>

3. Выбор объекта мышкой</p>
Нажата мышка в окне GLScreenViewer или GLFullScreenViewer, как определить какой объект выделить? Это можно с помощью следующего кода: В событии OnMouseDown или OnMouseUp описать следующий код:</p>
// pick - переменная класса TGLCustomSceneObject</p>
pick:=(GLScreenViewer1.Buffer.GetPickedObject(x, y) as TGLCustomSceneObject);</p>
После этого можно анализировать тип объекта и вызывать те или иные процедуры для управления выбранным объектом.</p>
4. Вывод надписей</p>
Текстовые надписи создаются, как и другие объекты GLScene, но прежде надо загрузить в память шрифт, а при использовании растрового шрифта задать соответствие между кодами символов и положением их в графическом файле.</p>
GLBitmapFont.Glyphs.LoadFromFile('textures/toonfont.bmp');</p>
Текстовую надпись можно масштабировать, вращать, задавать прозрачность и перемещать по координатам X,Y.</p>
<pre>GLMyText :=TGLHUDText(GLDummyText.AddNewChild(TGLHUDText)); 
GLMyText.BitmapFont := GLBitmapFont; 
GLMyText.Text := 'TEXT'; 
GLMyText.Position.SetPoint(10,470,0); 
GLMyText.ModulateColor.Color := clrSilver; 
GLMyText.ModulateColor.Alpha := 0.5; 
GLMyText.Scale.SetVector(0.6,0.8,1); 
</pre>

5. Отображение FPS</p>
Число кадров в секунду возвращает функция FramesPerSecond объекта GLSceneViewer. Добавив в форму компонент Timer, надо в событии OnTimer ввести две строки - значение FPS появляется в заголовке окна:</p>
<pre>Caption:=Format('%.1f FPS', [GLSceneViewer1.FramesPerSecond]); 
GLSceneViewer1.ResetPerformanceMonitor; 
</pre>

6. Анимация 3D-персонажей</p>
GLScene поддерживает загрузку и отображение статичных и анимированных 3D-моделей. Соответствующие объекты создаются аналогично: инициализировать переменную, загрузить модуль, выбрать анимацию и способ ее повтора:</p>
<pre>GLActorMain.LoadFromFile('models/goblin.md2'); 
GLActorMain.AnimationMode:=aamLoop; 
GLActorMain.Interval:=100; 
</pre>

// можно использовать номер или символьный идентификатор</p>
GLActorMain.SwitchToAnimation(0);</p>
При переключении анимации можно проверить завершилась ли текущая (newani - новая анимация, символьный идентификатор):</p>
if GLActorMain.CurrentAnimation&lt;&gt;newani then GLActorMain.SwitchToAnimation(newani);</p>
7. Спецэффекты огня</p>
Партиклы можно привязывать к любому объекту GLScene. Настройка свойств соответствующих менеджеров выполняется просто - к примеру, для огня задается радиус, параметры цвета, число частиц, направление огня и обязательно указывается объект GLCadencer, обновляющий состояние сцены:</p>
<pre>myFire := TGLFireFXManager.Create(self); 
myFire.OuterColor.Red := 0.9; 
myFire.FireRadius := 2; 
myFire.ParticleSize := 1; 
myFire.ParticleLife := 1; 
myFire.MaxParticles := 512; 
myFire.Cadencer := GLCadencer1; 
myFire.InitialDir.SetVector(0,1,0);  
</pre>

На втором этапе эффект (объект myFire) добавляется к 3D-объекту.</p>
<pre>if GLSphere.Effects.CanAdd(TGLBFireFX) then 
begin 
  myFireFX := TGLBFireFX.Create(nil); 
  PickFire.Effects.Add(myFireFX); 
  myFire.InnerColor.Color:= clrGreen; 
  myFire.OuterColor.Color:= clrYellow; 
  myFireFX.Manager := myFire; 
  myFire.Disabled := False; 
end;  
</pre>

В завершении можно организовать взрыв, определив его минимальную и максимальную начальную скорости и мощность; эту функцию можно вызвать из события OnProgress объекта GLCadencer:</p>
myFire.IsotropicExplosion(4, 6, 5);</p>
Приведенные выше сведения - далеко не все, на что способна библиотека. Так, ничего не сказано о шейдерах, поддержка которых уже введена в GLScene. Обо всем этом можно узнать из news-конференций, сайтов поддержки и веб-ресурсов, посвященных OpenGL. Надо сказать, что все то, что делается на чистом OpenGL, можно создать и с помощью GLScene.</p>
