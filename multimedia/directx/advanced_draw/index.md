---
Title: Advanced Draw
Author: Daddy, http://daddy.mirgames.ru
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Advanced Draw
=============

_Кручу-верчу, обмануть хочу,_ или как использовать продвинутые методы
вывода спрайтов. В классе TSprite есть три метода: DoDraw, DoCollision и
DoMove Чтобы заставить спрайт созданный таким образом:

    TPlayer = class(TImageSprite)
    end;

выводится через продвинутые методы (DrawRotate, DrawAplha, DrawSub,
DrawWave, StretchDraw), нужно "заглушить" стандартный вывод при
создании объекта. Вот так:

    type
       THero = class(TImageSprite)
          Angle:integer;
       protected
          procedure DoCollision(Sprite: TSprite; var Done: Boolean); override;
          procedure DoMove(MoveCount: Integer); override;
          procedure DoDraw; override; // вот здесь
       end;

Теперь в процедуре DoDraw выводим спрайт нужным нам способом. Вот так:

     
    procedure THero.DoDraw;
    begin
       image.drawrotate(form1.DXDraw.Surface,
                        round(x)+16,
                        round(y)+16,
                        image.width,
                        image.height,
                        round(animpos),0.5,0.5,Angle);
    end;

Посмотрите этот dodraw.zip примерчик, для более ясного понимания. А
теперь недокументированная фишка! Забываем то, что написано выше и
читаем дальше. Cоздадим спрайт таким образом:

    TPlayer = class(TImageSpriteEx)
    protected
       procedure DoMove(MoveCount: Integer); override;
    end;

И теперь в процедуре DoMove можно задать Angle (угол поворота спрайта) и
Alpha (прозрачность спрайта). Примерно так:

    type
       THero = class(TImageSpriteEx)
          Angle:integer;
       protected
          procedure DoCollision(Sprite: TSprite; var Done: Boolean); override;
          procedure DoMove(MoveCount: Integer); override;
       end;
     
    procedure TPlayer.DoMove(MoveCount: Integer);
    begin
       X:=100;
       Y:=100;
       Angle:=60;
       Alpha:=150;
    end;

