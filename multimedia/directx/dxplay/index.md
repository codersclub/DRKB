---
Title: DXPlay
Author: SDil, http://daddy.mirgames.ru
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


DXPlay
======

Многие игры в нынешнее время поддерживают мультиплеер. Почему?

Потому
что сейчас люди уже перестали довольствоватся Ai'ем, который играет в
частности 'линейно', его нельзя обмануть, пошутить над его действиями
или разозлить... =) С ним играть можно только на уровне обучения игры,
а далее - сеть, живые игроки... ;).
Если это маленькое вступление
заставило вас захотеть добавить в свою игру мультиплеер то эта статья
для вас.

- Итак, сразу к делу. Сделаем самую легкую программу, с одной
кнопкой. =)

- Кидаем ее на форму, не забыв кинуть DXPlay.

- В этой программе
давайте сделаем чтобы форма подключения DXPlay выводилась при запуске.
Идем в настройки DXPlay и устанавливаем любой Guid путем нажатия кнопки
New, этот параметр (imho) "устанавливает" уникальности вашему
мультиплееру.

- Далее так: `TForm1<Events<OnCreate`, и в процедуру кидаем:

        try
           DXPlay1.Open; //Пытаемся открыть форму подключения
        except
           on E: Exception do
           begin
              Application.ShowMainForm := False;
              Application.HandleException(E);
              Application.Terminate; //Если не подключаемся или ошибка выходим их программы
           end;
        end;

    Теперь при запуске программы у вас будет выводится форма DXPlay.

- После:

        uses
           Windows, Messages, SysUtils, Variants, Classes, Graphics, Controls, Forms,
           Dialogs, StdCtrls, DXPlay;

    Пишем:

        const
           DXMESE = 1;
        type
           TDXMessage = record
              MessageType: DWORD; //Тип сообщения
              Mes: Integer; //Тип пересылаемых данны, может быть несколько, к примеру - Mes2: String;
           end;

- Далее, кликаем два раза на кнопку, создавая тем самым процедуру нажатия
кноки, и пишем туда:

    Перед begin:

        Var
           Msg: ^TDXMessage; //Ссылаемя на TDXMessage
           MsgSize: Integer; //Размер сообщения

    После:

        MsgSize := SizeOf(TDXMessage); // Нужно узнать размер сообщения.
        GetMem(Msg, MsgSize);
        try
           Msg.MessageType := DXMESE; //Указываем тип сообщения
           Msg.Mes:=random(100); {Само сообщения, может быть что угодно, вплоть до нахождения курсора мышки}
           DXPlay1.SendMessage(DPID_ALLPLAYERS,msg,msgsize); //Отправлем мессагу всем игрокам
           DXPlay1.SendMessage(DXPlay1.LocalPlayer.ID,msg,msgsize); //Отпраляем себе
        finally
           FreeMem(Msg); //Освобождаем память сообщения Msg
        end;

- Для приема делаем следующее - DXPlay1\<Events\<OnMessage и пишем :

    Button1.Left:=TDXMessage(Data^).Mes; {Устанавливаем положения кнопки по горизонтали в соответсвии с полученным числом}
    Button1.Caption:=inttostr(TDXMessage(Data^).Mes); //Пишем это число

- Итак, это уже конец, осталось чуть-чуть:

    В процедуре уничтожения формы (FormDestroy) (Tform1\<Events\<OnDestroy)
    пишем:

        DXPlay1.Close; //Завершение подключения DXPlay.

- И последний штрих - В Unit добавляем DirectX.

- Все, запускаем и радуемся нашей первой программе с мультиплеером! =)

