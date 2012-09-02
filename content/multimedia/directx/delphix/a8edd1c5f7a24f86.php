<h1>Изучаем DelphiX (Часть 3)</h1>
<div class="date">01.01.2007</div>

<p>Изучаем DelphiX. Часть 3: Крутим спрайты. </p>
Автор: Влад Энгельгардт </p>
"Крутимся не накрутимся:)" </p>
<p>В DelphiX существует маленькая проблема, это разворот спрайтов. Она решается относительно просто, сейчас я объясню, как и что. </p>
<p>Для начала создадим новый проект в Delphi, подстроим его под шаблон (об этом написано в одной из частей цикла). Далее скачиваем мною модернизированный DXSprite.pas (Dxsprite.rar), в папке, где у вас установлен DelphiX есть папочка Source, копируем его туда. В DXSprite.pas я добавил всего одну процедуру Angle это и есть процедура разворота, как она работает можете посмотреть, сами поковырявшись в исходниках. Ну что приступим, для начала создадим простенький пример (в архиве с исходниками в папке 3.1). </p>
<p>Создаём новый класс: </p>
<pre>
TPlayerone = class(TImageSprite)
  protected
    procedure DoMove(MoveCount: Integer); override;
end;
</pre>

<p>Соответственно и процедуру DoMove к этому классу: </p>

<pre>
Procedure TPlayerone.DoMove(MoveCount: Integer);
begin
  inherited DoMove(MoveCount);
  x:=x+cos256(Angle)*speed; //обработчик движения по X
  y:=y+sin256(Angle)*speed; //обработчик движения по Y
  if  y &gt;= form1.DXDraw1.SurfaceHeight-image.Height then
    y := form1.DXDraw1.SurfaceHeight-image.Height;
  if  x &gt;= form1.DXDraw1.SurfaceWidth -image.Width  then
    x := form1.DXDraw1.SurfaceWidth -image.Width;
  if  y &lt;= 0 then
    y := 1;
  if  x &lt;= 0 then
    x:=1;
  begin
    speed:=0;     //когда ничего не делаем, скорость равна 0
    if isLeft in Form1.DXInput1.States then angle:=angle-5;
    if isRight in Form1.DXInput1.States then angle:=angle+5;
    if isup in Form1.DXInput1.States then speed:=4;
    if isDown in Form1.DXInput1.States then speed:=-4;
  end;
end;
</pre>
<p>&nbsp;
И перед implementation в Var добавляем: 
<p>&nbsp;</p>
<pre>
var
  Form1: TForm1;
  speed: integer;  // Это у нас переменная скорости объекта
</pre>

<p>Не забудь в DXtimer добавить: </p>
<pre>
procedure TForm1.DXTimer1Timer(Sender: TObject; LagCount: Integer);
begin
  if not DXDraw1.CanDraw then exit;
  DXInput1.Update;
  DXSpriteEngine1.Move(LagCount);
  DXSpriteEngine1.Dead;
  DXDraw1.Surface.Fill(0);
  DXSpriteEngine1.Draw;
  DXDraw1.Flip;
end;
</pre>

<p>И в процедуре FormCreate создаём наш спрайт: </p>
<pre>
procedure TForm1.FormCreate(Sender: TObject);
begin
  with TPlayerone.Create(Dxspriteengine1.Engine) do
  begin
    PixelCheck := True;
    Image := form1.dxImageList1.Items.Find('krut');
    x:=350;
    y:=250;
    Width := Image.Width;
    Height := Image.Height;
  end;
end;
</pre>

<p>Далее в DXImageList добавляем спрайт "krut" он у меня выглядит вот так: </p>
<img src="/pic/clip0112.png" width="43" height="43" border="0" alt="clip0112"></p>
<p>И всё, простейший пример с Angle готов. </p>
<p>Теперь давайте усложним наш пример и сделаем так что бы игрок стрелял в ту сторону куда он смотрит, для этого создаём новый класс для патрона. Выглядит он так: </p>
<pre>
TPlayerFa = class(TImageSprite)
  protected
    procedure DoMove(MoveCount: Integer); override;
  private
    anglefa:integer; // Угол под которым летит пуля
  public
    constructor Create(AParent: TSprite); override;
    destructor Destroy; override;
end;
</pre>

<p>Перед implementation добавляется ещё одна переменная ang: </p>
<pre>
var
  Form1: TForm1;
  speed,ang: integer;
</pre>

<p>Она нужна для выноса значения Angle плеера. А зачем нужен вынос, спросишь ты, да всё очень просто, он нужен для патрона, чтобы указывать ему, под каким углом лететь т.е. под каким углом находиться плеер под таким углом и летит патрон. </p>
<p>Маленько модернизируем класс плеера: </p>
<pre>
TPlayerone = class(TImageSprite)
  private
    lngpolet:integer;  // мы же не хотим, чтобы наши пули летали кучами
    oldlngpolet:integer; // а мы сделаем чтобы летали стаями :)
  protected
    procedure DoMove(MoveCount: Integer); override;
end; 
</pre>

<p>Сразу, чтобы не забыть конструктор и деструктор для патрона: </p>
<pre>
constructor TPlayerFa.Create(AParent: TSprite);
begin
  inherited Create(AParent);
  Image := form1.DXImageList1.Items.Find('pul');
  Width := Image.Width;
  Height := Image.Height;
end;
 
destructor TPlayerFa.Destroy;
begin
  inherited Destroy;
end;
</pre>

<p>Ну а теперь движение патрона: </p>
<pre>
procedure TPlayerFa.DoMove(MoveCount: Integer);
begin
  inherited DoMove(MoveCount);
  angle := anglefa;
  x:=x+cos256(angle)*7; // цифра 7 здесь скорость патрона и изменять её надо
  y:=y+sin256(angle)*7; // пропорционально
  if X&gt;= 800 then Dead;
  if y&gt;= 600 then Dead;
  if X&lt;= 0 then Dead;
  if y&lt;= 0 then Dead;
  Collision;
end;
</pre>

<p>Надеюсь, ты помнишь, на прошлых уроках я рассказывал тебе об DXInput, так вот теперь нам понадобятся дополнительные кнопочки. Их значения ты можешь поменять, два раза кликнув на самом компоненте. Так вот, гляди процедуру DoMove у игрока: </p>
<pre>
Procedure TPlayerone.DoMove(MoveCount: Integer);
begin
  inherited DoMove(MoveCount);
  ang:=angle; // наша переменная для патрона
  x:=x+cos256(Angle)*speed;
  y:=y+sin256(Angle)*speed;
  if  y &gt;= form1.DXDraw1.SurfaceHeight-image.Height then
    y := form1.DXDraw1.SurfaceHeight-image.Height;
  if  x &gt;= form1.DXDraw1.SurfaceWidth -image.Width  then
    x := form1.DXDraw1.SurfaceWidth -image.Width;
  if  y &lt;= 0 then
    y := 1;
  if  x &lt;= 0 then
    x:=1;
  begin
    speed:=0;
    if isLeft in Form1.DXInput1.States then angle:=angle-5;
    if isRight in Form1.DXInput1.States then angle:=angle+5;
    if isup in Form1.DXInput1.States then speed:=4;
    if isDown in Form1.DXInput1.States then speed:=-4;
    if isbutton1 in Form1.DXInput1.States then
    begin
      if lngpolet-oldlngpolet&gt;=250 then
      begin
        Inc(lngpolet);
        with TPlayerFa.Create(Engine) do
        begin
          Image := form1.DXImageList1.Items.Find('pul');
          X:=self.X+cos256(ang)*50;  // здесь 50 расстояние патрона от плеера
          Y:=self.y+sin256(ang)*50;   //они должны быть пропорциональны
          anglefa:=ang; // передаём угол
          oldlngpolet := lngpolet;
        end;
      end;
    end;
    lngpolet := lngpolet + MoveCount;
  end;
end;   
</pre>

<p>И последнее что осталось это создать спрайт "pul" в DXimageList. Он выглядит у меня вот так: </p>
<img src="/pic/clip0113.png" width="24" height="21" border="0" alt="clip0113"></p>
<p>Что, устал? Ну, расслабься, если хочешь. Дальше мы сделаем следующее: <br>
1. Добавим второго плеера <br>
<p>2. И научимся делать стрэйфы </p>
<p>Для начала установим новую раскладку в Dxinput. Для этого два раза кликнем по кампоненту Dxinput и преходим в закладку Keybord: </p>
<img src="/pic/clip0114.png" width="391" height="276" border="0" alt="clip0114"></p>
<p>Сразу маленький совет: чтобы на одной кнопке у тебя не было 300 действий для каждой метки, назначай только одну кнопку. </p>
<p>Я выбрал такой вариант для первого игрока: <br>
Up- Num 8 <br>
Down - Num 5 <br>
Left - Num 4 <br>
Right - Num 6 <br>
Button1 - Num 0 <br>
Button2 - Num 7 <br>
Button3 - Num 9 <br>
Для второго игрока: <br>
Button4 - T <br>
Button5 -G <br>
Button6 -F <br>
Button7- H <br>
Button8 -E <br>
Button9 -R <br>
<p>Button10 -Y </p>
<p>Посмотрите на клаву и поймёте раскладку. Ну что, приступаем, для начала перед Implementation добавим ещё две переменные, только уже для второго игрока: </p>
<pre>
var
  Form1: TForm1;
  speed,speed2,ang,ang2: integer;
implementation
Теперь соответственно добавляем 2 игрока и модернизируем первого: 
TPlayerone = class(TImageSprite)
  private
    lngpolet:integer;
    oldlngpolet:integer;
  protected
    procedure DoMove(MoveCount: Integer); override;
    //Добавили столкновение
    procedure DoCollision(Sprite: TSprite; var Done: Boolean); override;
end;
 
TPlayertwo = class(TImageSprite)
  private
    lngpolet:integer;
    oldlngpolet:integer;
  protected
    procedure DoMove(MoveCount: Integer); override;
    procedure DoCollision(Sprite: TSprite; var Done: Boolean); override;
end;
</pre>

<p>и теперь обрабатываем DoCollision у обоих плееров: </p>
<pre>
procedure TPlayerone.DoCollision(Sprite: TSprite; var Done: Boolean);
begin
  if Sprite is Tplayerfa then dead;
end;
 
procedure TPlayertwo.DoCollision(Sprite: TSprite; var Done: Boolean);
begin
  if Sprite is Tplayerfa then dead;
end;
</pre>

<p>Процедура DoMove у первого игрока в корне изменяется: </p>
<pre>
Procedure tPlayerone.DoMove(MoveCount: Integer);
begin
  inherited DoMove(MoveCount);
  ang:=angle;
  x:=x+cos256(Angle)*speed;
  y:=y+sin256(Angle)*speed;
  if  y &gt;= form1.DXDraw1.SurfaceHeight-image.Height then
    y := form1.DXDraw1.SurfaceHeight-image.Height;
  if  x &gt;= form1.DXDraw1.SurfaceWidth -image.Width  then
    x := form1.DXDraw1.SurfaceWidth -image.Width;
  if  y &lt;= 0 then
    y := 1;
  if  x &lt;= 0 then
    x:=1;
  begin
    speed:=0;
    if isLeft in Form1.DXInput1.States then angle:=angle-5;
    if isRight in Form1.DXInput1.States then angle:=angle+5;
    if isup in Form1.DXInput1.States then speed:=4;
    if isDown in Form1.DXInput1.States then speed:=-4;
    if isbutton2 in Form1.DXInput1.States then
    begin
      x:= x+cos256 (angle+64)*3; // это у нас стрейф
      y:= y+sin256 (angle+64)*3; // 3 - на сколько быстро стрейфиться
    end;
    if isbutton3 in Form1.DXInput1.States then
    begin
      x:= x+cos256 (angle-64)*3; //тоже стрейф, только в
      y:= y+sin256 (angle-64)*3; //другую сторону
    end;
    if isbutton1 in Form1.DXInput1.States then
    begin
      if lngpolet-oldlngpolet&gt;=250 then
      begin
        Inc(lngpolet);
        with TPlayerFa.Create(Engine) do
        begin
          Image := form1.DXImageList1.Items.Find('pul');
          X:=self.X+cos256(ang)*50;
          Y:=self.y+sin256(ang)*50;
          anglefa:=ang;
          oldlngpolet := lngpolet;
        end;
      end;
    end;
    lngpolet := lngpolet + MoveCount;
  end;
  Collision;
end;
</pre>

<p>Аналогично и у второго плеера: </p>
<pre>
Procedure TPlayertwo.DoMove(MoveCount: Integer);
begin
  inherited DoMove(MoveCount);
  ang2:=angle;
  x:=x+cos256(Angle)*speed2;
  y:=y+sin256(Angle)*speed2;
  if  y &gt;= form1.DXDraw1.SurfaceHeight-image.Height then
    y := form1.DXDraw1.SurfaceHeight-image.Height;
  if  x &gt;= form1.DXDraw1.SurfaceWidth -image.Width  then
    x := form1.DXDraw1.SurfaceWidth -image.Width;
  if  y &lt;= 0 then
    y := 1;
  if  x &lt;= 0 then
    x:=1;
  begin
    speed2:=0;
    if isbutton6 in Form1.DXInput1.States then angle:=angle-5;
    if isbutton7 in Form1.DXInput1.States then angle:=angle+5;
    if isbutton4 in Form1.DXInput1.States then speed2:=4;
    if isbutton5 in Form1.DXInput1.States then speed2:=-4;
    if isbutton9 in Form1.DXInput1.States then
    begin
      x:= x+cos256 (angle-64)*3;
      y:= y+sin256 (angle-64)*3;
    end;
    if isbutton10 in Form1.DXInput1.States then
    begin
      x:= x+cos256 (angle+64)*3;
      y:= y+sin256 (angle+64)*3;
    end;
    if isbutton8 in Form1.DXInput1.States then
    begin
      if lngpolet-oldlngpolet&gt;=250 then
      begin
        Inc(lngpolet);
        with TPlayerFa.Create(Engine) do
        begin
          Image := form1.DXImageList1.Items.Find('pul');
          X:=self.X+cos256(ang2)*50;
          Y:=self.y+sin256(ang2)*50;
          anglefa:=ang2;
          oldlngpolet := lngpolet;
        end;
      end;
    end;
    lngpolet := lngpolet + MoveCount;
  end;
  Collision;
end;
</pre>

<p>И последнее в FormCreate добавляем, чтобы второй игрок креатился: </p>
<pre>
procedure TForm1.FormCreate(Sender: TObject);
begin
  with TPlayerone.Create(Dxspriteengine1.Engine) do
  begin
    PixelCheck := True;
    Image := form1.dxImageList1.Items.Find('krut');
    x:=350;
    y:=250;
    Width := Image.Width;
    Height := Image.Height;
  end;
 
  with TPlayertwo.Create(Dxspriteengine1.Engine) do
  begin
    PixelCheck := True;
    Image := form1.dxImageList1.Items.Find('krut');
    x:=50;
    y:=250;
    Width := Image.Width;
    Height := Image.Height;
  end;
</pre>

<p>И пару советов, для дебага можно выводить любую переменную на экран. Для этого в DXTimer добавим следующие строчки: </p>
<pre>
procedure TForm1.DXTimer1Timer(Sender: TObject; LagCount: Integer);
begin
  if not DXDraw1.CanDraw then exit;
  DXInput1.Update;
  DXSpriteEngine1.Move(LagCount);
  DXSpriteEngine1.Dead;
  DXDraw1.Surface.Fill(0);
  DXSpriteEngine1.Draw;
  with DXDraw1.Surface.Canvas do
  begin
    Brush.Style := bsClear; //стиль
    Font.Color := clWhite; //цвет текста
    Font.Size := 12; // размер
    Textout(0, 0, 'FPS: '+inttostr(DXTimer1.FrameRate)); //вывод текста
    Textout(0, 24, 'спрайты: '+inttostr(DXSpriteEngine1.Engine.AllCount));
    Release;
  end;
  DXDraw1.Flip;
end;
</pre>

<p>Здесь я вывожу Fps (кадры в секунду), и количество спрайтов на экране. </p>
<p>Д/З: <br>
1. Сделай анимированные патроны. <br>
2. Реализуй, чтобы вторым игроком управлял не человек, а созданный тобой интеллект. <br>
3. Сделай так, чтобы вёлся счёт фрагов. <br>
<p>4. После смерти любого игрока, чтобы через 5 сек. происходил респаун. </p>
<p>Вот архив всего, что мы сегодня натворили: part3.rar(18kB). </p>
<p>Если у вас возникли какие-то вопросы или проблемы, пишите мне. </p>
<p class="author">Автор: Влад Энгельгардт </p>
