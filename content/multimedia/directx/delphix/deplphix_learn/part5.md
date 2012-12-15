---
Title: Изучаем DelphiX (Часть 5)
Date: 29.06.2006
Updated: 02.03.2009
tags: Delphi, DelphiX
source: https://gamedev.ru/pages/hex/articles/DelphiX?page=7
Author: hex (https://gamedev.ru/users/?id=14)
---

# Изучаем DelphiX 

Влад Энгельгардт

29 июня 2006 (Обновление: 28 фев 2009)

## Часть 5: AI.

*"Все люди - всего навсего сложный AI"*

Здравствуйте! Сегодня я реализую у вас на глазах, простенький Ai,
который будет стрелять по вам, и двигаться к вам.
Бороться с ним будет "очень просто" (клавиатуру не поломайте),
несмотря на его простенькое строение.
В виде шаблона я возьму пример из части 4.

Начнём делать всё постепенно, нам ведь некуда тропится, правильно?

Для начала в Uses добавим модуль math. В этом модуле находятся процедуры
с математикой.

Далее добавляем перед implementation в var:

      plres:boolean; // plres - респаун: true - погиб 1 игрок, false - 2 игрок
      fa:boolean;    //Выстрел нашего Ai true - стрелял, false - нет
      Player:TPlayerone;
      Playerai:TPlayertwo;

Процедура Domove изменяется у нашего AI:

    Procedure TPlayertwo.DoMove(MoveCount: Integer);
    begin
      inherited DoMove(MoveCount);
      ang2:=angle;
      if  y >= form1.DXDraw1.SurfaceHeight-image.Height then
        y := form1.DXDraw1.SurfaceHeight-image.Height;
      if  x >= form1.DXDraw1.SurfaceWidth -image.Width  then
        x := form1.DXDraw1.SurfaceWidth -image.Width;
      if  y <= 0 then
        y := 1;
      if  x <= 0 then
        x:=1;
      begin
        if fa=true then
        begin
          if lngpolet-oldlngpolet>=250 then
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

Теперь идём в FormCreate и удаляем там всё кроме

    procedure TForm1.FormCreate(Sender: TObject);
    begin
      randomize;
    end;

Кликаем на DxDraw и в свойствах ищем: "OnInitialize" создаём событие,
и вставляем:

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

Теперь кидаем на форму простой таймер (я назвал его Ai).
Параметры такие:

    Enabled = true
    Interval = 1
    Name = Ai

Создаём событие OnTime и пишем следующее:

      playerai.angle:=trunc(1/sin256(trunc((player.y-playerai.y)/(player.x-playerai.x))));
      If (player.y-playerai.y < 0)and(player.x-playerai.x > 0) then 
        playerai.angle:=playerai.angle+192;
      If (player.y-playerai.y < 0)and(player.x-playerai.x < 0) then 
        playerai.angle:=playerai.angle+128;
      If (player.y-playerai.y > 0)and(player.x-playerai.x < 0) then 
        playerai.angle:=playerai.angle+64;
      if player.x <= playerai.x then
        playerai.x:=playerai.x-2.5;
      if player.x > playerai.x then
        playerai.x:=playerai.x+2.5;
      if player.y <= playerai.y then
        playerai.y:=playerai.y-2.5;
      if player.y > playerai.y then
        playerai.y:=playerai.y+2.5;
      if playerai.x >= player.x-140 then
      begin
        playerai.x:=playerai.x-2.5;
      end;
     
      if playerai.y>= player.y-140 then
      begin
        playerai.y:=playerai.y-2.5;
      end;
     
      if playerai.y >=player.y-150 then
      begin
        if playerai.x >=player.x-150 then
        begin
          fa:=true;
        end;
      end;

Вот и всё, мы реализовали примитивный, и простенький Ai, ни капли не
реалистичный, зато очень точный. Есть маленький совет: атакуйте
издалека.

Ну а теперь Д/З:

1. Осуществите более реалистичный разворот к игроку
2. Реализуйте ошибки Ai (т.е. неточное попадание и т.д.)
3. Чтобы AI не стрелял постоянно в одну и туже точку после гибели игрока
4. И вообще, придумайте что-то своё

На это Д/З я не буду писать решение в следующей части.

Реализуйте это, и отправьте мне на e-mail,
и если всё будет хорошо, ты получишь предложение,
от которого нельзя отказаться.
Жду!!

Всё, что мы на кодили, здесь: [part5.rar](part5.rar).
