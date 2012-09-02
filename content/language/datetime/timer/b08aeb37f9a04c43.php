<h1>Реализация функции Delay</h1>
<div class="date">01.01.2007</div>


<pre>
procedure Delay(dwMilliseconds: Longint);
 var
   iStart, iStop: DWORD;
 begin
   iStart := GetTickCount;
   repeat
     iStop := GetTickCount;
     Application.ProcessMessages;
   until (iStop - iStart) &gt;= dwMilliseconds;
 end;
</pre>
<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>
<p class="note">Примечание от Vit
<p>Функция будет "безбожно" жрать процессорное время. Если ожидаемые интервалы &nbsp;задержек достаточно велики, то очень желательно её дополнить следующим образом:</p>
<pre>
procedure Delay(dwMilliseconds: Longint);

 var
   iStart, iStop: DWORD;
 begin
   iStart := GetTickCount;
   repeat
     iStop := GetTickCount;
     sleep(10);
     Application.ProcessMessages;
   until (iStop - iStart) &gt;= dwMilliseconds;
 end;
</pre>
<p>Команда Sleep будет отдавать время другим приложением, но точность отмеряемого интервала пострадает на 0.01 секунды, что сопоставимо с общей погрешностью предложенного метода.</p>
<hr />
<pre>
procedure Delay(msecs: Longint);
 var
   targettime: Longint;
   Msg: TMsg;
 begin
   targettime := GetTickCount + msecs;
   while targettime &gt; GetTickCount do
     if PeekMessage(Msg, 0, 0, 0, PM_REMOVE) then
     begin
       If Msg.message = WM_QUIT Then
       begin
         PostQuitMessage(msg.wparam);
         Break;
       end;
       TranslateMessage(Msg);
       DispatchMessage(Msg);
     end;
 end;
 
 { 
  Note: 
  The elapsed time is stored as a DWORD value. 
  Therefore, the time will wrap around to zero if the system is 
  run continuously for 49.7 days. 
}
</pre>
<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>
<hr />
<pre>
{ 
  The Sleep function suspends the execution of the current 
  thread for a specified interval. 
}
 
 Sleep(dwMilliseconds: Word);
 
</pre>
<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>
<p class="note">Примечание от Vit</p>
<p>Эта функция страдает многими недостатками, во-первых ни о какой точности речь и не идёт, погрешности среднепотолочные, во-вторых при количестве милисекунд большем 100 функция будет создавать эффект "подвисания" приложения, так как во время её работы приложение не будет отвечать на внешние воздействия. Собственно сама по себе функция sleep вовсе не для отсчёта времени и не для задержки на определённый интервал, её назначение в другом - отдать процессорное время в течение заданного интервала другим процессам. Код можно подправить примерно таким образом:</p>
<pre>
Procedure Delay (IntervalinSeconds:integer);
var i:integer;

begin
  For i:=0 to IntervalinSeconds*100 do
   begin
      sleep(10);
      Application.ProcessMessages;      
   end;
end;
</pre>
<p>Это "поправит" подвисание, но не улучшит точность. Эта функция хороша для задержек на период от секунд до несколько минут когда точность не важна.</p>
<p>Можно так же помудрив сделать и возможность прерывания ожидания по нажатию кнопки, примерно так:</p>
<pre>
var Canceled:boolean; // должна быть объявлена как глобальная переменная модуля
 
.....
Function Delay (IntervalinSeconds:integer):boolean; //возвращает true если отработала не прерываясь
var i:integer;
begin
  Canceled:=false; 
  For i:=0 to IntervalinSeconds*100 do
   begin
      sleep(10);
      Application.ProcessMessages;      
      if Canceled then break;
   end;
  Result:=not Canceled;
end;
 
........
 
Procedure TForm1.onButton1Click(Sender:TObject);
begin
  Canceled:=true;
end;
</pre>
<p class="author">Автор: Vit</p>
<hr />
<pre>
{ 
  Including the Sleep in the loop prevents the app from hogging 
  100% of the CPU for doing practically nothing but running around the loop. 
}
 
 procedure PauseFunc(delay: DWORD);
 var
   lTicks: DWORD;
 begin
   lTicks := GetTickCount + delay;
   repeat
     Sleep(100);
     Application.ProcessMessages;
   until (lTicks &lt;= GetTickCount) or Application.Terminated;
 end;
 
 
</pre>
<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>
<hr />
<pre>
procedure Delay(Milliseconds: Integer);
 {by Hagen Reddmann}
 var
   Tick: DWord;
   Event: THandle;
 begin
   Event := CreateEvent(nil, False, False, nil);
   try
     Tick := GetTickCount + DWord(Milliseconds);
     while (Milliseconds &gt; 0) and
           (MsgWaitForMultipleObjects(1, Event, False, Milliseconds, QS_ALLINPUT) &lt;&gt; WAIT_TIMEOUT) do
     begin
       Application.ProcessMessages;
       Milliseconds := Tick - GetTickcount;
     end;
   finally
     CloseHandle(Event);
   end;
 end;
 
</pre>
<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>
