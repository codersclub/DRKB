<h1>Изучаем DelphiX (Часть 5)</h1>
<div class="date">01.01.2007</div>

<p>Изучаем DelphiX. Часть 5: AI. </p>
Автор: Влад Энгельгардт </p>
"Все люди - всего на всего сложный AI" </p>
<p>Здравствуйте! Сегодня я реализую у вас на глазах, простенький Ai который будет стрелять по вам, и двигаться к вам. Бороться с ним будет "очень просто" (клавиатуру не поломайте), не смотря на его простенькое строение. В виде шаблона я возьму пример из части 4. </p>
<p>Начнём делать всё постепенно, нам ведь некуда тропится, правильно? </p>
<p>Для начала в Uses добавим модуль math. В этом модуле находятся процедуры с математикой. </p>
<p>Далее добавляем перед implementation в var: </p>
<pre>
  plres:boolean; // plres - респаун: true - погиб 1 игрок, false - 2 игрок
  fa:boolean;    //Выстрел нашего Ai true - стрелял, false - нет
  Player:TPlayerone;
  Playerai:TPlayertwo;
</pre>

<p>Процедура Domove изменяется у нашего Ai: </p>
<pre>
Procedure TPlayertwo.DoMove(MoveCount: Integer);
begin
  inherited DoMove(MoveCount);
  ang2:=angle;
  if  y &gt;= form1.DXDraw1.SurfaceHeight-image.Height then
    y := form1.DXDraw1.SurfaceHeight-image.Height;
  if  x &gt;= form1.DXDraw1.SurfaceWidth -image.Width  then
    x := form1.DXDraw1.SurfaceWidth -image.Width;
  if  y &lt;= 0 then
    y := 1;
  if  x &lt;= 0 then
    x:=1;
  begin
    if fa=true then
    begin
      if lngpolet-oldlngpolet&gt;=250 then
      begin
        Inc(lngpolet);
        with TPlayerFa.Create(Engine) do
        begin
          Image := form1.DXImageList1.Items.Find('pul');
          X:=self.X+cos256(ang2)*55;
          Y:=self.y+sin256(ang2)*55;
          anglefa:=ang2;
          oldlngpolet := lngpolet;
        end;
        fa:=false;
      end;
    end;
    lngpolet := lngpolet + MoveCount;
  end;
  Collision;
end;
</pre>

<p>&nbsp;<br>
<p>Теперь идём в FormCreate и удаляем там всё кроме </p>
<pre>
procedure TForm1.FormCreate(Sender: TObject);
begin
  randomize;
end;
</pre>

<p>Кликаем на DxDraw и в свойствах ищем: "OnInitialize" создаём событие, и вставляем: </p>
<pre>
  Playerai:= TPlayertwo.Create(DXSpriteEngine1.Engine);
  Playerai.Image := DXImageList1.Items.Find('krut');
  Playerai.X := 50;
  Playerai.Y := 250;
  Playerai.Width := Playerai.Image.Width;
  Playerai.Height := Playerai.Image.Height;
 
  Player:= TPlayerone.Create(DXSpriteEngine1.Engine);
  Player.Image := form1.dxImageList1.Items.Find('krut');
  Player.x:=350;
  Player.y:=250;
  Player.Width := Player.Image.Width;
  Player.Height := Player.Image.Height;
</pre>

<p>Теперь кидаем на форму простой таймер (я назвал его Ai). Параметры такие: </p>
<pre>
Enabled = true
Interval = 1
Name = Ai
</pre>

<p>Создаём событие OnTime и пишем следующее: </p>
<pre>
  playerai.angle:=trunc(1/sin256(trunc((player.y-playerai.y)/(player.x-playerai.x))));
  If (player.y-playerai.y &lt; 0)and(player.x-playerai.x &gt; 0) then 
    playerai.angle:=playerai.angle+192;
  If (player.y-playerai.y &lt; 0)and(player.x-playerai.x &lt; 0) then 
    playerai.angle:=playerai.angle+128;
  If (player.y-playerai.y &gt; 0)and(player.x-playerai.x &lt; 0) then 
    playerai.angle:=playerai.angle+64;
  if player.x &lt;= playerai.x then
    playerai.x:=playerai.x-2.5;
  if player.x &gt; playerai.x then
    playerai.x:=playerai.x+2.5;
  if player.y &lt;= playerai.y then
    playerai.y:=playerai.y-2.5;
  if player.y &gt; playerai.y then
    playerai.y:=playerai.y+2.5;
  if playerai.x &gt;= player.x-140 then
  begin
    playerai.x:=playerai.x-2.5;
  end;
 
  if playerai.y&gt;= player.y-140 then
  begin
    playerai.y:=playerai.y-2.5;
  end;
 
  if playerai.y &gt;=player.y-150 then
  begin
    if playerai.x &gt;=player.x-150 then
    begin
      fa:=true;
    end;
  end; 
</pre>

<p>Вот и всё, мы реализовали примитивный, и простенький Ai, ни капли не реалистичный, зато очень точный. Есть маленький совет: атакуйте издалека. </p>
<p>Ну а теперь Д/З: <br>
1. Осуществите более реалистичный разворот к игроку <br>
2. Реализуйте ошибки Ai (т.е. неточное попадание и т.д.) <br>
3. Чтобы AI не стрелял постоянно в одну и туже точку после гибели игрока <br>
<p>4. И вообще, придумайте что-то своё </p>
<p>На это Д/З я не буду писать решение в следующей части. Реализуйте это, и отправьте мне на e-mail, и если всё будет хорошо, ты получишь предложение, от которого нельзя отказаться. Жду!! </p>
<p>Всё, что мы на кодили, здесь: part5.rar. </p>
<p class="author">Автор: Влад Энгельгардт </p>
