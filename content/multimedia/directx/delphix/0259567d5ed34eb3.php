<h1>Изучаем DelphiX (Часть 1)</h1>
<div class="date">01.01.2007</div>

<p class="p_Heading1">Часть 0: &#171;Теория&#187;.</p>
<p class="p_Heading1" style="text-align: right;">&#171;Теория, теория ну а практика, <br>
а практика потом&#187; &#8212; <br>
Так подумал автор, начиная <br>
<p>писать эту статью.</p>
&nbsp;</p>
<p>Ну что же, приступим:</p>
<p class="p_Heading1">1. Обзор DelphiX.</p>
<p class="p_Heading1">DelphiX &#8212; это набор компонентов, способный облегчить использование DirectX в Delphi приложениях и использовать всю мощь DirectX.</p>
<p>Основные компоненты DelphiX:</p>
<p>TDXDraw &#8212; (Это такой мониторчик) Дает доступ к поверхностям DirectDraw (проще говоря, эта вещь которая отображает всё) Проще говоря, сам DirectDraw.</p>
<p>TDXDib - Позволяет хранить DIB (Device Independent Bitmap)</p>
<p>TDXImageList &#8212; Позволяет хранить серии DIB, Jpg, bmp-файлов, что очень удобно для программ, содержащих спрайты. Позволяет загружать DIB`ы с диска во время выполнения программы.</p>
<p>TDXSound &#8212; Проигрыватель звуков в формате Wav.</p>
<p>TDXWave &#8212; &#171;Контейнер&#187; для wav-файла.</p>
<p>TDXWaveList &#8212; Позволяет хранить серии для wav-файлов.</p>
<p>TDXInput &#8212; Позволяет использовать DirectInput, т.е. получить доступ к устройствам ввода информации (мышь, клавиатура, джойстик).</p>
<p>TDXPlay &#8212; Компонент позволяющий обмениваться информацией на компьютерах.</p>
<p>TDXSpriteEngine &#8212; Спрайтовый движок.</p>
<p>TDXTimer &#8212; Более точный, чем TTimer.</p>
<p>TDXPaintBox &#8212; Альтернатива TImage, только DIB-версия.</p>
<p>В DelphiX есть самостоятельные компоненты, а есть вспомогательные, вот, например, DXSpriteEngine не может без DXDraw (где он будет отображать всё действия происходящие на сцене). Вот таблица зависимых и вспомогательных:</p>
<p><img src="/pic/clip0095.png" width="478" height="229" border="0" alt="clip0095"></p>
<p>2. Принцип написания кода и основные процедуры для классов.</p>
<p>Весь принцип очень прост и удобен, сейчас объясню: весь код строится по классам, в каждом классе свои процедуры, каждый новый тип юнита это новый класс и в каждом классе свои процедуры. Рассмотрим на живом примере: возьмём камень и бумагу. Бумага мнётся, камень нет. Так и здесь, в одном классе это свойство есть, в другом нет, рассмотрим кусок кода отвечающий за класс:</p>
<pre>
TPlayerFa = class(TImageSprite)
   protected
    procedure DoCollision(Sprite: TSprite; var Done: Boolean); override;
    procedure DoMove(MoveCount: Integer); override;
   public
    constructor Create(AParent: TSprite); override;
    destructor Destroy; override;
   end;
</pre>
<p>Здесь нам виден класс TplayerFa, его процедуры:</p>
<p>procedure DoCollision(Sprite: TSprite; var Done: Boolean); override;</p>
<p>&#8212; Это процедура столкновения, что будет происходить при столкновении</p>
<p>procedure DoMove(MoveCount: Integer); override;</p>
<p>&#8212; Это процедура движения, в ней указывается, как класс будет двигаться. <br>
<p>( в следующих частях я опишу и расскажу про все функции и их использование на практике)</p>
<p>constructor Create(AParent: TSprite); override;</p>
<p>&#8212; Это конструктор Create очень полезная вещь он отвечает за происходящим во время создания объекта.</p>
<p>destructor Destroy; override;</p>
<p>&#8212; Альтернатива, только при уничтожении объекта.</p>
<p>После написания класса каждая процедура расписывается, и всё, можно писать сам код. <br>
<p>(Но это мы будем делать позже.)</p>
<p>Часть 1: Первая игра.</p>
&#171;Как много игр то хороших, <br>
Да только сегодня не до них&#187; <br>
<p>Автор.</p>
<p>Теперь мы создадим первую, и надеюсь не последнюю игрушку, смысл у нас будет такой: Мы - маленький космический корабль, нам надо уничтожить большой статичный космический корабль (прим. автора: "Этот пример научит мыслить по DelphiX`ски").</p>
<p>Итак, запускаем Delphi (Для тех, кто в танке, у кого 6-ая, ищите на этом же сайте статью "DelphiX для Delphi6"). Вы, надеюсь, предварительно установили DelphiX, тогда ищем в панели с компонентами раздел DelphiX:</p>
<p><img src="/pic/clip0096.png" width="552" height="60" border="0" alt="clip0096"></p>
<p>Кидаем на форму следующие компоненты:</p>
<p><img src="/pic/clip0097.png" width="32" height="29" border="0" alt="clip0097">DXDraw &#8212; и проставляем в нем следующие опции в Object Inspector: <br>
Align = alClient - это нужно для того чтобы DXDraw &#171;обтянул&#187; всю форму. <br>
Display = 800x600x16 - почему, спросите вы, не 800x600x24? Да потому что не все видеокарты поддерживают 24 битный режим. <br>
<p>Options-doFullScreen = True, если хочешь чтобы твоя игра была на весь экран, и ещё надо в свойствах формы поставить: BorderStyle = bsnone.</p>
<p><img src="/pic/clip0098.png" width="32" height="32" border="0" alt="clip0098">TDXSpriteEngine &#8212; Сам движок для работы со спрайтами. В нём нужно только выбрать в поле DXDraw сам DXDraw1.</p>
<img src="/pic/clip0099.png" width="227" height="176" border="0" alt="clip0099"></p>
<p><img src="/pic/clip0100.png" width="32" height="32" border="0" alt="clip0100">TDXTimer &#8212; Он вообще-то и нужен, чтобы обновлять кадры, но он нам пригодится и для другого. Свойства следующие: <br>
Active Only = False - По-русски: "Быть активным всегда". Смысл: Работает даже если вы, работаете с другим приложением. <br>
<p>Interval = 0 - Частота повторения цикла, должна быть равна 0.</p>
<p><img src="/pic/clip0101.png" width="32" height="32" border="0" alt="clip0101">TDXImageList &#8212; В этом листе будут у нас хранится все спрайты. Свойства: <br>
DXDraw = DXDraw1 <br>
<p>После кликаем на Items: (TPictureCollection), появляется окно Editing DxImagelist1.Items. В нём кликаем по Add New и в Object Inspector в поле "Name" пишем название спрайта, назовем его "pla" - это будет сам игрок, загружаем его с помощью Picture... Игрок у меня будет вот такой:</p>
<img src="/pic/clip0102.png" width="43" height="43" border="0" alt="clip0102"></p>
<p>Только фон чёрный - для прозрачности. Устанавливаю в Object Inspector у данной картинки свойства Transparent = true и TransparentColor = clBlack. <br>
<p>Создаём ещё один спрайт под именем Pula проделываем тоже самое с ним, только TransparentColor = clWhite. Выглядит пуля вот так:</p>
<img src="/pic/clip0103.png" width="40" height="62" border="0" alt="clip0103"></p>
<p>И последнее что нам осталось, добавить этого босса, называем его "BOSS", вот он:</p>
<img src="/pic/clip0104.png" width="91" height="135" border="0" alt="clip0104"></p>
<p>TransparentColor = clWhite. На этом с DXImageList мы пока закончили.</p>
<p><img src="/pic/clip0105.png" width="32" height="32" border="0" alt="clip0105">TDXInput &#8212; Ну, а этот компонент будет отвечать за нажатые клавиши на клавиатуре. В нем никакие изменения делать не будем, только рассмотрим его (на будущее). Кликнем 2 раза по компоненту, и появится TDXInput Editor, выглядит он вот так:</p>
<img src="/pic/clip0106.png" width="391" height="276" border="0" alt="clip0106"></p>
<p>Первая закладка устанавливает свойства джойстика, вторая клавиатуры. Вот закладка со свойствами клавиатуры нам и нужна. Вот так она выглядит:</p>
<img src="/pic/clip0107.png" width="391" height="276" border="0" alt="clip0107"></p>
<p>Слева - условное название клавиш, а справа - их значение. Каждому условному названию может быть присвоено 3 клавиши. Всего условных названий 36 штук.</p>
<p>Ну что, теперь приступаем к написанию кода. Вначале нужно изменить класс формы на TDXForm вот пример:</p>
<p>До:</p>
<pre>
//...
type
  TForm1 = class(TForm)
    DXDraw1: TDXDraw;
    DXImageList1: TDXImageList;
    DXInput1: TDXInput;
//...
</pre>
<p>После:</p>
<pre>
//...
type
  TForm1 = class(TDXForm)
    DXDraw1: TDXDraw;
    DXImageList1: TDXImageList;
    DXInput1: TDXInput
//...
</pre>
<p>Дальше расписываем классы после implementation.</p>
<p>Вот так:</p>
<pre>
{$R *.DFM}
 
type
  TPlayerSprite = class(TImageSprite)       //Класс игрока
  protected
    procedure DoMove(MoveCount: Integer); override; // Движение
  end;
 
  TBoSS = class(TImageSprite) // Класс босса
   Protected
    // Столкновение
    procedure DoCollision(Sprite: TSprite; var Done: Boolean); override;
    procedure DoMove(MoveCount: Integer); override;
  public
    constructor Create(AParent: TSprite); override; //при создании
    destructor Destroy; override; // при смерти
  end;
 
TPlayerFa = class(TImageSprite)  
   protected
    procedure DoCollision(Sprite: TSprite; var Done: Boolean); override;
    procedure DoMove(MoveCount: Integer); override; 
   public
    constructor Create(AParent: TSprite); override;
    destructor Destroy; override;
  end;
</pre>
<p>Далее расписываем каждую процедуру для каждого класса. Вот образец:</p>
<pre>
Procedure TPlayerFa.DoMove(MoveCount: Integer);
Begin
  inherited DoMove(MoveCount);
end;
 
constructor TPlayerFa.Create(AParent: TSprite);
begin
end;
 
destructor TPlayerFa.Destroy;
begin
  inherited Destroy; // Обязательно 
end;
 
procedure TPlayerFa.DoCollision(Sprite: TSprite; var Done: Boolean);
begin
end;
</pre>
<p>Это нужно проделать с каждым классом, который содержит свои процедуры, указанные в классе.</p>
<p>Далее выбираем компонент DXTimer который уже на форме и в Object Inspector в закладке Events, находим пункт OnTimer. Два раза кликаем по пункту, создаётся процедура DXTimer1Timer, в ней пишем следующие строчки:</p>
<pre>
if not DXDraw1.CanDraw then exit; // Если нет DirectX выходим
  DXInput1.Update;
  DXSpriteEngine1.Move(LagCount);
  DXSpriteEngine1.Dead;
  DXDraw1.Surface.Fill(0);
  DXSpriteEngine1.Draw;
  DXDraw1.Flip;
</pre>
<p>Далее: <br>
<p>Кликая на форму в свободное место и Object Inspector в закладке Events, находим OnCreate. Создаём процедуру и пишем в ней:</p>
<pre>
with TBOSS.Create(Dxspriteengine1.Engine) do
begin
 PixelCheck := True;            // для столкновения просчитывает каждую точку
  Image := form1.dxImageList1.Items.Find('BOSS'); //ищем спрайт в ImageList`е
  x:=350; // x координаты 
  y:=10;  // y координаты
  Width := Image.Width;          //ширина равна ширине спрайта 
  Height := Image.Height;        //высота равна высоте спрайта
end;
 
with TPlayerSprite.Create(Dxspriteengine1.Engine) do
begin
 PixelCheck := True;
  Image := form1.dxImageList1.Items.Find('Pla');
  x:=350;
  y:=500;
  Width := Image.Width;
  Height := Image.Height;
end;
</pre>
<p>Сейчас объясню, зачем это всё. При создании формы мы создаём все статичные объекты сразу. Ну, что? Теперь можно перейти к процедурам и их заполнению :) Начнём с процедур босса. Они самые простые. Пред implementation в var добавить переменную</p>
<p>i:boolean; //переменная движения в сторону BOSSA</p>
<p>и в свойствах формы OnCreate добавить:</p>
<p>I:=true;</p>
<p>Только после этого пишем следующее:</p>
<pre>
Procedure TBoSS.DoMove(MoveCount: Integer);
   begin
   inherited DoMove(MoveCount);
   if x&gt;= 700 then I:= true;    // когда X&gt;= то  туда &gt;&gt;&gt;
   if x&lt;= 0 then I:= false;     // когда X&lt;= то  туда &lt;&lt;&lt;
   if  i= true then X := X+10;
   if i= false then X := X-10;
Collision;
end;
 
constructor TBOSS.Create(AParent: TSprite); //Здесь всё понятно
begin
  inherited Create(AParent);
  Image := form1.DXImageList1.Items.Find('BOSS');
  Width := Image.Width;
  Height := Image.Height;
end;
 
destructor TBOSS.Destroy;  //тут тоже
begin
  inherited Destroy;
end;
 
procedure TBoss.DoCollision(Sprite: TSprite; var Done: Boolean);
begin
  // если спрайт сталкивается с Tplayerfa, то умирает
  if Sprite is Tplayerfa then dead;
  Collision; // Включаем столкновение
end;
</pre>
<p>Ну, вроде, с одним объектом разобрались, переходим к игроку, тут одна процедура</p>
<pre>
Procedure TPlayerSprite.DoMove(MoveCount: Integer);
begin
  inherited DoMove(MoveCount);
 &nbsp;&nbsp; // при нажатии двигаем объект влево
 &nbsp;&nbsp; if isLeft in Form1.DXInput1.States then x:=x-5;
 &nbsp;&nbsp; // при нажатии двигаем объект вправо
 &nbsp;&nbsp; if isRight in Form1.DXInput1.States then x:=x+5;
 &nbsp;&nbsp; // при нажатие вверх создаётся наша пулька
 &nbsp;&nbsp; if isup in Form1.DXInput1.States then
 &nbsp;&nbsp; begin
 &nbsp;&nbsp;&nbsp;&nbsp; with TPlayerFa.Create(Engine) do
 &nbsp;&nbsp;&nbsp;&nbsp; begin
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; PixelCheck := True;
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Image := form1.dxImageList1.Items.Find('Pula');
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; //Чтобы пуля создавалась около нашего объекта
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; X := Self.X+Self.Width&nbsp; -40;
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; //Чтобы пуля создавалась около нашего объекта
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Y := Self.Y+Self.Height -80;
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Width := Image.Width;
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Height := Image.Height;
 &nbsp;&nbsp;&nbsp;&nbsp; end;
 &nbsp;&nbsp; end;
 &nbsp;&nbsp; if  y &gt;= form1.DXDraw1.SurfaceHeight-image.Height then  //не пускаем
 &nbsp;&nbsp;&nbsp;&nbsp; y := form1.DXDraw1.SurfaceHeight-image.Height;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; //объект
 &nbsp;&nbsp; if  x &gt;= form1.DXDraw1.SurfaceWidth -image.Width&nbsp; then  //за границы
 &nbsp;&nbsp;&nbsp;&nbsp; x := form1.DXDraw1.SurfaceWidth -image.Width;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; //формы
 &nbsp;&nbsp; if  y &lt;= 0 then
 &nbsp;&nbsp;&nbsp;&nbsp; y := 1;
 &nbsp;&nbsp; if  x &lt;= 0 then
 &nbsp;&nbsp;&nbsp;&nbsp; x:=1;
end;
</pre>
<p>И, наконец, последнее, это сама пуля и её процедуры:</p>
<pre>
Procedure TPlayerFa.DoMove(MoveCount: Integer); 
begin
   inherited DoMove(MoveCount);
   y:=y-3;  //проще некуда, неправда ли?
end;
 
procedure TPlayerFa.DoCollision(Sprite: TSprite; var Done: Boolean);
begin
  if Sprite is TBoss then dead;
    Collision;
end;
</pre>
<p>И на последок, для удобства в Object Inspector в закладке Events находим OnKeyDown, кликаем и пишем:</p>
<p>if Key=VK_ESCAPE then application.Terminate;</p>
<p>При вставке этого кода по нажатию клавиши ESC выходим из приложения.</p>
<p>Вот и всё! Это одно из самых примитивных игр на DelphiX, но ты её сам сделал.</p>
<p>Вот вам Д/З для улучшения знаний: <br>
1. Сделайте так, чтобы при уходе патрона из зоны видимости он уничтожался <br>
<p>2. Сделайте, чтобы патроны стреляли очередями, а не кучами как у меня</p>

<div class="author">Автор: hex</div>

<p>Взято с: <a href="https://www.gamedev.ru/" target="_blank">https://www.gamedev.ru/</a></p>

