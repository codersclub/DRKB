<h1>Как отчитывать промежутки времени с точностью, большей чем 60 мсек?</h1>
<div class="date">01.01.2007</div>


<p>Для начала описываешь процедуру, которая будет вызываться по сообщению от таймера :</p>
<pre>
procedure FNTimeCallBack(uTimerID, uMessage: UINT;dwUser, dw1, dw2: DWORD);stdcall;
begin
//
//  Тело процедуры.
end; 
</pre>

<p>а дальше в программе (например по нажатию кнопки) создаешь Таймер и вешаешь на него созданную процедуру</p>
<pre>
uTimerID:=timeSetEvent(10,500,@FNTimeCallBack,100,TIME_PERIODIC); 
</pre>

<p>Подробности смотри в Help.Hу и в конце убиваешь таймер:</p>
<pre>
timeKillEvent(uTimerID); 
</pre>

<p>И все. Точность этого способа до 1 мсек. минимальный интервал времени можно задавать 1 мсек.</p>

<p class="author">Автор: Leonid Tserling</p>
<p>tlv@f3334.dd.vaz.tlt.ru </p>
<p class="author">Автор: StayAtHome</p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>

