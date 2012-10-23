<h1>Изучаем DelphiX (Часть 2)</h1>
<div class="date">01.01.2007</div>

<p>Изучаем DelphiX. Часть 2: Усложняем нашу игру. </p>

Хех! загружу:" </p>
<p>Прежде чем начать, объясню решение Д/З: </p>
<p>1. Сделайте так, чтобы при уходе патрона из зоны видимости он уничтожался: </p>
<p>Это очень легко сделать достаточно в процедуру DoMove патрона вставить: </p>
<pre>
if y&lt;= 0 then Dead;
if y&gt;= 600 then Dead;
</pre>

<p>Нужно это для того, чтобы повысилось качество игры. </p>
<p>2. Сделайте, чтобы патроны стреляли очередями, а не кучами как у меня: </p>
<p>Вот эта задача была посложнее первой. Во-первых, как я сделал в первой части этого туториала, делать нельзя из-за причины небольшой "кривости" DelphiX, он может держать только определённое количество спрайтов, а если их больше он или выходит или подвисает. Так что, делаем вот так: </p>
<p>В класс с плеером добавляем две переменные, он теперь выглядит так (я добавил комментарии к тем строчкам которые изменились): </p>
<pre>
TPlayerSprite = class(TImageSprite)
   Private 
    lngpolet:integer;    //расстояние которое пролетела пуля 
    oldlngpolet:integer; //расстояние которое пролетела предыдущая пуля
  protected
    procedure DoMove(MoveCount: Integer); override;
  end;
</pre>

Процедура DoMove класса PlayerSprite изменяется следующим образом: 
<p>&nbsp;</p>
<pre>
Procedure TPlayerSprite.DoMove(MoveCount: Integer);
Begin
  inherited DoMove(MoveCount);
  if isLeft in Form1.DXInput1.States then x:=x-5;
  if isRight in Form1.DXInput1.States then X:=x+5;
  if isup in Form1.DXInput1.States then
  begin
    if lngpolet-oldlngpolet&gt;=250 then // Если расстояние между пулями меньше 250,
                                      // то пуля не создаётся
    begin
      Inc(lngpolet);
      with TPlayerFa.Create(Engine) do
      begin
        PixelCheck := True;
        Image := form1.dxImageList1.Items.Find('Pula');
        X := Self.X+Self.Width  -40;
        Y := Self.Y+Self.Height -80;
        Width := Image.Width;
        Height := Image.Height;
      end;
      oldlngpolet := lngpolet; //после создания пули - последняя становится первой
    end;
  end;
  if  y &gt;= form1.DXDraw1.SurfaceHeight-image.Height then
    y := form1.DXDraw1.SurfaceHeight-image.Height;
  if  x &gt;= form1.DXDraw1.SurfaceWidth -image.Width  then
    x := form1.DXDraw1.SurfaceWidth -image.Width;
  if  y &lt;= 0 then
    y := 1;
  if  x &lt;= 0 then
    x:=1;
  lngpolet := lngpolet + MoveCount;  // расстояние увеличиваем, когда пуля движется
end;
</pre>

<p>Вот и всё, что требовалось сделать. </p>
<p>В этой части вы узнаете: <br>
1. Создание анимации. <br>
2. Создание примитивного AI. <br>
<p>3. Создадим простенькие взрывы. </p>
<p>Создание анимации. </p>
<p>Анимация в DelphiX строится следующим образом: </p>
<img src="/pic/clip0108.png" width="120" height="38" border="0" alt="clip0108"></p>
<p>Это пример покадровой анимации. У каждого кадра должен быть одинаковый размер. </p>
<p>В данной ситуации: <br>
Ширина: 40 <br>
<p>Высота: 38 </p>
<p>Давайте теперь, применим ее к нашей игре. <br>
<p>Идём в DXImageList, находим наш спрайт Pula и загружаем картинку с анимацией. Далее устанавливаем свойства спрайта следующим образом: </p>
<img src="/pic/clip0109.png" width="300" height="175" border="0" alt="clip0109"></p>
<p>и в процедуре DoMove класса PlayerSprite изменяем код следующим образом: </p>
<pre>
Procedure TPlayerSprite.DoMove(MoveCount: Integer);
begin
  inherited DoMove(MoveCount);
  if isLeft in Form1.DXInput1.States then  x:=x-5;
  if isRight in Form1.DXInput1.States then X:=x+5;
  if isup in Form1.DXInput1.States then
  begin
    if lngpolet-oldlngpolet&gt;=250 then
    begin
      Inc(lngpolet);
      with TPlayerFa.Create(Engine) do
      begin
        PixelCheck := True;
        Image := form1.dxImageList1.Items.Find('Pula');
        X := Self.X+Self.Width  -40;
        Y := Self.Y+Self.Height -80;
        Width := Image.Width;
        Height := Image.Height;
        AnimCount := Image.PatternCount; //число кадров
        AnimLooped := True;              //повторять ли анимацию
        AnimSpeed := 10 / 1000;          //скорость анимации
      end;
      oldlngpolet := lngpolet;
    end;
  end;
  if  y &gt;= form1.DXDraw1.SurfaceHeight-image.Height then
    y := form1.DXDraw1.SurfaceHeight-image.Height;
  if  x &gt;= form1.DXDraw1.SurfaceWidth -image.Width  then
    x := form1.DXDraw1.SurfaceWidth -image.Width;
  if  y &lt;= 0 then
    y := 1;
  if  x &lt;= 0 then
    x:=1;
  lngpolet := lngpolet + MoveCount;
end;
</pre>

<p>Можно проделать тоже самое с другими классами для придания реалистичности игры. </p>
<p>Cоздание примитивного AI. </p>
<p>Для начала маленько улучшим наш класс плеера, добавим в него столкновение, и он теперь выглядит следующим образом: </p>
<pre>
TPlayerSprite = class(TImageSprite)
   private
    lngpolet:integer;
    oldlngpolet:integer; 
  protected
    procedure DoMove(MoveCount: Integer); override;
    //добавляем
    procedure DoCollision(Sprite: TSprite; var Done: Boolean); override;
  end;
</pre>

<p>Далее создаём процедуру DoCollision и вставляем в неё следующее: </p>
<pre>
procedure TPlayerSprite.DoCollision(Sprite: TSprite; var Done: Boolean);
begin
  if Sprite is TPlayerFa then Dead;
  Collision;
end;
</pre>

<p>Дальше пред implementation добавляем 1 переменную: </p>
<pre>
  plx:double;            //X плеера
</pre>

<p>Далее обновим класс TPlayerFa и он станет таким: </p>
<pre>
TPlayerFa = class(TImageSprite)
  private
    stril:Integer; // Как вы заметили, добавилась переменная
  protected
    procedure DoCollision(Sprite: TSprite; var Done: Boolean); override;
    procedure DoMove(MoveCount: Integer); override;
   public
    constructor Create(AParent: TSprite); override;
    destructor Destroy; override;
  end;
</pre>
<p>А в TPlayerFa добавляем строчку: </p>
<pre>
Procedure TPlayerFa.DoMove(MoveCount: Integer);
begin
   y:=y-stril; // когда стреляет игрок, с этой скоростью будет двигаться пуля
   y:=y+stri; // когда стреляет AI, с этой скоростью будет двигаться пуля
   if y&lt;= 0 then Dead;
   if y&gt;= 600 then Dead;
end;
</pre>
<p>А процедура TBoSS.DoMove становиться такой: </p>
<pre>
Procedure TBoSS.DoMove(MoveCount: Integer);
  begin
   inherited DoMove(MoveCount);
   if x&gt;= 600 then I:= false;
   if x&lt;= 0 then I:= true;
   if i= true then X := X+5;
   if i= false then X := X-5;
   if plx=x then //если равна х плеера стреляем
   begin
     with TPlayerFa.Create(Engine) do
      begin
      PixelCheck := True;
      Image := form1.dxImageList1.Items.Find('Pula');
      X := Self.X+Self.Width-70;
      Y := Self.Y+Self.Height+10;
      Width := Image.Width;
      Height := Image.Height;
      stril:=5;        //скорость патрона
      end;
   end;
    Collision;
end;
</pre>
<p>И естественно полнеет и TPlayerSprite: </p>
<pre>
Procedure TPlayerSprite.DoMove(MoveCount: Integer);
begin
  inherited DoMove(MoveCount);
  plx:=x;            //чтобы наш комп видел нашего плеера
  if isLeft in Form1.DXInput1.States then
  begin
    x:=x-5;
    plx:=x;
  end;
  if isRight in Form1.DXInput1.States then
  begin
    X:=x+5;
    plx:=x;
  end;
  if isup in Form1.DXInput1.States then
  begin
    if lngpolet-oldlngpolet&gt;=250 then
    begin
      Inc(lngpolet);
      with TPlayerFa.Create(Engine) do
      begin
        PixelCheck := True;
        Image := form1.dxImageList1.Items.Find('Pula');
        X := Self.X+Self.Width  -40;                    
        Y := Self.Y+Self.Height -80 ;                   
        Width := Image.Width;
        Height := Image.Height;
        stril:=-4;
      end;
      oldlngpolet := lngpolet;
    end;
  end;
  if  y &gt;= form1.DXDraw1.SurfaceHeight-image.Height then  
    y := form1.DXDraw1.SurfaceHeight-image.Height;               
  if  x &gt;= form1.DXDraw1.SurfaceWidth -image.Width  then  
    x := form1.DXDraw1.SurfaceWidth -image.Width;                 
  if  y &lt;= 0 then
    y := 1;
  if  x &lt;= 0 then
    x:=1;
  lngpolet := lngpolet + MoveCount;
  Collision;
end;
</pre>
<p>И поменялся конструктор PlayerFa: </p>
<pre>
constructor TPlayerFa.Create(AParent: TSprite);
begin
  inherited Create(AParent);
  Image := form1.DXImageList1.Items.Find('Pula');
  Width := Image.Width;
  Height := Image.Height;
  AnimCount := Image.PatternCount;    //число кадров
  AnimLooped := True;                 //повторять ли анимацию
  AnimSpeed:= 10 / 1000;
  Collision;
end;
</pre>
<p>Создадим простенькие взрывы. </p>
<p>Для начала загрузим спрайт взрыва в DXImageList вот он: <img src="/pic/clip0110.png" width="192" height="32" border="0" alt="clip0110"></p>
<p>Назовём его "ex" и установим размер кадра на 32Х48 (PatternHeight - PatternWidth) </p>
<p>Дальше, в класс TPlayerSprite в private добавляем procedure Hit; и создаём обработчик: </p>
<pre>
procedure TplayerSprite.Hit;
begin
  Collisioned := False;
    Image := Form1.dxImageList1.Items.Find('Ex');
    Width := Image.Width;
    Height := Image.Height;
    AnimCount := Image.PatternCount;
    AnimLooped := False;
    AnimSpeed := 15/1000;
    AnimPos := 0;
end;
</pre>
<p>и в процедуре TPlayerSprite.DoCollision вставляем следущий код: </p>
<pre>
procedure TPlayerSprite.DoCollision(Sprite: TSprite; var Done: Boolean);
begin
  if sprite is Tplayerfa then
  begin
    TPlayerSprite(Sprite).Hit;
    dead;
  end;
  Done := False;
end;
</pre>
<p>Этот код надо разместить и в Tboss. DoCollision. </p>
<p>И под конец маленький бонус: <br>
<p>Можно создать бэкграунд, без создания нового класса достаточно в FormCreate написать: </p>
<pre>
  with TBackgroundSprite.Create(DXSpriteEngine1.Engine) do
  begin
    SetMapSize(1,1);
    Image := dxImageList1.Items.Find('bgr');
    Z:= -2;
    Tile := True;
  end;
</pre>
<p>Где bgr спрайт-бэкграунд. <br>
<p>Вот мой БГ: </p>
<img src="/pic/clip0111.png" width="175" height="112" border="0" alt="clip0111"></p>
<p>Нравиться? Здесь можно скачать исподники всей этой части. <br>
<p>part2.rar(77,5 kB) </p>
<div class="author">Автор: Влад Энгельгардт </div>
