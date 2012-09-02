<h1>Преобразование количества секунд в формат TTime</h1>
<div class="date">01.01.2007</div>


<pre>
{ **** UBPFD *********** by delphibase.endimus.com ****
&gt;&gt; Преобразование количества секунд в формат TTIME (ЧЧ:ММ:СС).
 
Преобразование количества секунд в формат TTIME (ЧЧ:ММ:СС).
На выходе функции, получаем TTIME
 
Зависимости: system, sysutils
Автор:       VID, vidsnap@mail.ru, ICQ:132234868, Махачкала
Copyright:   VID
Дата:        14 июня 2002 г.
***************************************************** }
 
function SecToTime(Sec: Integer): TTime;
var
  H, M, S: INTEGER;
  HS, MS, SS: string;
begin
  S := Sec;
  M := Round(INT(S / 60));
  S := S - M * 60; //Seconds
  H := Round(INT(M / 60)); //Hours
  M := M - H * 60; //Minutes
  if H &lt; 10 then
    HS := '0' + Inttostr(H)
  else
    HS := inttostr(H);
  if M &lt; 10 then
    MS := '0' + Inttostr(M)
  else
    MS := inttostr(M);
  if S &lt; 10 then
    SS := '0' + inttostr(S)
  else
    SS := inttostr(S);
  RESULT := StrToTime(HS + ':' + MS + ':' + SS);
end;
</pre>
<p>Пример использования: </p>
<p>ShowMessage(TimeToStr(SecToTime(50)));</p>
<p>//получаем сообщение:</p>
<p>"00:00:50 "</p>
