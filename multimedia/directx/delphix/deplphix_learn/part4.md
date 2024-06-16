---
Title: Изучаем DelphiX (Часть 4)
Date: 29.06.2006
Updated: 02.03.2009
tags: Delphi, DelphiX
source: https://gamedev.ru/pages/hex/articles/DelphiX?page=6
Author: hex (https://gamedev.ru/users/?id=14)
---

# Изучаем DelphiX

Влад Энгельгардт

29 июня 2006 (Обновление: 28 фев 2009)

## Часть 4: Разбираем классы.

*«Классы - это хорошо :)»*

В этой части, дорогие мои читатели, мы разберем классы. Здесь будет
рассказано, как создать грамотный, читаемый, и не тормозной код (на
сколько это возможно).

Для начала реализуем наше Д/З:

**1\. Сделай анимированные патроны.**

Для начала я заменил в DXImageList спрайт "pul" другой картинкой,
вот такой:

![](20606.jpg)

а размер кадра 26X40.

В конструктор патрона нужно вставить анимацию:

    constructor TPlayerFa.Create(AParent: TSprite);
    begin
      inherited Create(AParent);
      Image := form1.DXImageList1.Items.Find('pul');
      Width := Image.Width;
      Height := Image.Height;
      AnimCount := Image.PatternCount; // вот эти 
      AnimLooped := True;  // три строчки 
      AnimSpeed := 10 / 1000; // с которыми вы уже знакомы
    end;

Вот и всё с этим вопросом.

**2\. Реализуй, чтобы вторым игроком управлял не человек, а созданный тобой интеллект.**

Я не хочу потом повторяться, об этом ты прочитаешь в 5 части,
и она будет посвящена "AI".

**3\. Сделай так, чтобы вёлся счёт фрагов.**

Добавляем перед implementation в Var две переменные:

    Fragpl, fragpl2: integer;

И для отображения наших фрагов вставляем следующие строчки,
и он изменяется следующим образом:

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
        Brush.Style := bsClear;
        Font.Color := clWhite;
        Font.Size := 12;
        //это первого плеера фраги
        Textout(30, 35, 'Фраги первого игрока: '+inttostr(fragpl));
        //это второго плеера
        Textout(240, 35, 'Фраги второго игрока: '+inttostr(fragpl2));
        Textout(0, 0, 'FPS: '+inttostr(DXTimer1.FrameRate));
        Textout(0, 24, 'Спрайтов: '+inttostr(DXSpriteEngine1.Engine.AllCount));
        Release;
      end;
      DXDraw1.Flip;
    end;

И ещё маленький штрих, без которого никуда:

    procedure TPlayerone.DoCollision(Sprite: TSprite; var Done: Boolean);
    begin
      if Sprite is Tplayerfa then dead;
      fragpl2:=fragpl2+1;
    end;
     
    procedure TPlayertwo.DoCollision(Sprite: TSprite; var Done: Boolean);
    begin
      if Sprite is Tplayerfa then dead;
      fragpl:=fragpl+1;
    end;

4\. После смерти любого игрока, чтобы через 5 сек. происходил респаун.

Для этого на форму добавляем обыкновенный таймер.
Находится он в закладки System, и выглядит также как DXTimer.
И устанавливаем свойства следующим образом:

    Enabled = false
    Interval = 5000

А в событие OnTimer:

      if plres=true then
      begin
        with TPlayerone.Create(Dxspriteengine1.Engine) do
        begin
          PixelCheck := True;
          Image := form1.dxImageList1.Items.Find('krut');
          x:=random(450);
          y:=random(450);
          Width := Image.Width;
          Height := Image.Height;
        end;
      end;
     
      if plres=false then
      begin
        with TPlayertwo.Create(Dxspriteengine1.Engine) do
        begin
          PixelCheck := True;
          Image := form1.dxImageList1.Items.Find('krut');
          x:=random(450);
          y:=random(450);
          Width := Image.Width;
          Height := Image.Height;
        end;
      end;
      timer1.Enabled := false;
    end;

Теперь перед implementation в var добавляем переменную типа boolean:

    plres:boolean; // переменная респавна true= погиб 1 игрок false 2 игрок.

В событие FormCreate добавляем одну единственную команду:

    randomize;

И финальный штрих, процедуру DoCollision у каждого игрока изменяем
следующим образом:

    procedure TPlayerone.DoCollision(Sprite: TSprite; var Done: Boolean);
    begin
      if Sprite is Tplayerfa then
      begin
        dead;
        fragpl2:=fragpl2+1;
        plres:=true;
        form1.Timer1.enabled:=true;
      end;
    end;
     
    procedure TPlayertwo.DoCollision(Sprite: TSprite; var Done: Boolean);
    begin
      if Sprite is Tplayerfa then
      begin
        dead;
        fragpl:=fragpl+1;
        plres:=false;
        form1.Timer1.enabled:=true;
      end;
    end;

Вот и всё, что нужно было сделать дома :).

Ну что, приступим, для начала я расскажу о разных способах создания
спрайтов:

1\. Это наш способ, мы использовали его в этом туториале.
При создании формы, создавался объект, т.е. это выглядит так:

    procedure Tformmy.FormCreate(Sender: TObject);
    begin
      with TPlayer.Create(Dxspriteengine1.Engine) do
      begin
        PixelCheck := True;
        Image := dxImageList.Items.Find(skinspl1);
        x:=10;
        y:=12;
        Width := Image.Width;
        Height := Image.Height;
      end;
    end;

Здесь, при создании спрайта, мы определяем его свойства.
Значит, обрабатывать конструктор TPlayer нам ненужно.

Следующий способ, это способ конструктора.
В конструкторе мы заранее задаём свойства будущего спрайта,
но Create мы обрабатываем в FormCreate.
Вот пример:

    constructor TPlayerFa.Create(AParent: TSprite);
    begin
      inherited Create(AParent);
      Image := formmy.DXImageList.Items.Find(pus2);
      Width := Image.Width;
      Height := Image.Height;
      AnimCount := Image.PatternCount;
      AnimLooped := True;
      AnimSpeed := speedanimpul / 1000;
    end;

Обычно этот способ используют для патронов.

И последний способ - это создания типов. Например, мы создали класс:

    TPlayer = class(TImageSpriteex)
      private
        Speed:Single;
      public
        procedure DoMove(MoveCount: Integer); override;
    end;

Теперь перед implementation в var обозначаем наш класс как тип:

    var 
      Form1: TForm1;
      Player: TPlayer;
     
    Implementation

Теперь в свойствах DxDraw находим событие DXDrawInitialize и вставляем
следующее:

      Player := TPlayer.Create(DXSpriteEngine1.Engine);
      Player.Image := DXImageList.Items.Find('Player');
      Player.X := 250;
      Player.Y := 250;
      Player.Width := Player.Image.Width;
      Player.Height := Player.Image.Height; 

Удобство использования этого способа в том что, в любой момент можно
получить данные о спрайте, например, в одном из уроков, нам приходилось
выносить значение angle для патрона. С использованием этого способа, все
значения плеера, будут у нас под рукой.

И ещё очень важный момент, создавайте свои функции и процедуры, это
очень удобно.

Теперь насчёт Collision:  
Во-первых, если объект с чем-то взаимодействует, то не забываете в DoMove вставлять:

    Collision;

Во-вторых, там где нужен точный Collision, используйте:

    PixelСheck:=true;

Там, где точность при столкновении не нужна:

    PixelCheck := False;

или вообще ничего не писать.

`Angle`: это процедура очень удобная, но есть одно большое НО,
она не подходит для разворота очень больших объектов.
Происходит очень большое количество вычислений,
и игра начинает зверски тормозить или точнее уменьшается число Fps.

Анимация в DelphiX капризная вещь, иногда не дружит с PixelCheck,
иногда с Collision, но это бывает очень редко.
В анимации, как и в статичном спрайте,
главное правильно указывать Transparent Color,
хотя DelphiX пытается определить его сам
(и у него иногда это хорошо получается),
следует смотреть какой цвет он выбрал.

Размер кадра вычитывается ручками (если ты рисовал сам),
если ты создавал анимацию в каком-то редакторе,
то ты должен знать размер кадра т.к. ты его сам указывал.

С DXInput бывает всего одна проблема  - это смешивание кнопок,
т.е. на одной кнопке находится несколько действий.

Ну, вот думаю и всё что я могу тебе посоветовать по этому поводу.

Спросишь ты, а причём тут "Разбираем классы",
некоторое написанное выше заставляет наши спрайты меньше тормозить,
а разбираем мы их потому, что решаем - что хорошо, а что плохо.

Есть вопросы - пиши мне.

Скачать файл с ответами на Д/З можно здесь: [part4.rar](part4.rar).

