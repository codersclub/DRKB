---
Title: Как отчитывать промежутки времени с точностью, большей чем 60 мсек?
Author: Leonid Tserling
Date: 01.01.2007
---


Как отчитывать промежутки времени с точностью, большей чем 60 мсек?
===================================================================

::: {.date}
01.01.2007
:::

Для начала описываешь процедуру, которая будет вызываться по сообщению
от таймера :

    procedure FNTimeCallBack(uTimerID, uMessage: UINT;dwUser, dw1, dw2: DWORD);stdcall;
    begin
    //
    //  Тело процедуры.
    end; 

а дальше в программе (например по нажатию кнопки) создаешь Таймер и
вешаешь на него созданную процедуру

    uTimerID:=timeSetEvent(10,500,@FNTimeCallBack,100,TIME_PERIODIC); 

Подробности смотри в Help.Hу и в конце убиваешь таймер:

    timeKillEvent(uTimerID); 

И все. Точность этого способа до 1 мсек. минимальный интервал времени
можно задавать 1 мсек.

Автор: Leonid Tserling

tlv\@f3334.dd.vaz.tlt.ru

Автор: StayAtHome

Взято с Vingrad.ru <https://forum.vingrad.ru>