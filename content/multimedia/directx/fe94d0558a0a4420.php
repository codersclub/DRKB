<h1>Advanced Draw</h1>
<div class="date">01.01.2007</div>

Автор: Daddy<br>
<p>WEB-сайт: http://daddy.mirgames.ru</p>
<p>Кручу-верчу, обмануть хочу, или как использовать продвинутые методы вывода спрайтов. В классе TSprite есть три метода: DoDraw, DoCollision и DoMove Чтобы заставить спрайт созданный таким образом:</p>
<pre>
TPlayer = class(TImageSprite)
end;
</pre>
<p>выводится через продвинутые методы (DrawRotate, DrawAplha, DrawSub, DrawWave, StretchDraw), нужно "заглушить" стандартный вывод при создании объекта. Вот так:</p>
<pre>
type
   THero = class(TImageSprite)
      Angle:integer;
   protected
      procedure DoCollision(Sprite: TSprite; var Done: Boolean); override;
      procedure DoMove(MoveCount: Integer); override;
      procedure DoDraw; override; // вот здесь
   end;
</pre>
<p>Теперь в процедуре DoDraw выводим спрайт нужным нам способом. Вот так:</p>
<pre>
 
procedure THero.DoDraw;
begin
   image.drawrotate(form1.DXDraw.Surface,
                    round(x)+16,
                    round(y)+16,
                    image.width,
                    image.height,
                    round(animpos),0.5,0.5,Angle);
end;
</pre>
<p>Посмотрите этот dodraw.zip примерчик, для более ясного понимания. А теперь недокументированная фишка! Забываем то, что написано выше и читаем дальше. Cоздадим спрайт таким образом:</p>
<pre>
TPlayer = class(TImageSpriteEx)
protected
   procedure DoMove(MoveCount: Integer); override;
end;
</pre>
<p>И теперь в процедуре DoMove можно задать Angle (угол поворота спрайта) и Alpha (прозрачность спрайта). Примерно так:</p>
<pre>
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
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
