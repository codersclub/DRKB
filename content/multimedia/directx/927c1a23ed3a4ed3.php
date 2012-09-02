<h1>DXPlay</h1>
<div class="date">01.01.2007</div>

Автор: SDil<br>
<p>WEB-сайт: http://daddy.mirgames.ru </p>
<p>Многие игры в нынешнее время поддерживают мультиплеер, почему? Потому что сейчас люди уже перестали довольствоватся Ai&#8217;ем, который играет в частности &#8216;линейно&#8217;, его нельзя обмануть, пошутить над его действиями или разозлить... =) С ним играть можно только на уровне обучения игры, а далее &#8211; сеть, живые игроки&#8230; ;). Если это маленькое вступление заставило вас захотеть добавить в свою игру мультиплеер то эта статья для вас. Итак, сразу к делу. Сделаем самую легкую программу, с одной кнопкой. =) Кидаем ее на форму, не забыв кинуть DXPlay. В этой программе давайте сделаем что бы форма подключения DXPlay выводилась при запуске. Идем в настройки DXPlay и устанавливаем любой Guid путем нажатия кнопки New, этот параметр (imho) &#8220;устанавливает&#8221; уникальности вашему мультиплееру. Далее так: TForm1&lt;Events&lt;OnCreate, и в процедуру кидаем:</p>
<pre>
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
</pre>
<p>Теперь при запуске программы у вас будет выводится форма DXPlay. После:</p>
<pre>
uses
   Windows, Messages, SysUtils, Variants, Classes, Graphics, Controls, Forms,
   Dialogs, StdCtrls, DXPlay;
</pre>
<p>Пишем:</p>
<pre>
const
   DXMESE = 1;
type
   TDXMessage = record
      MessageType: DWORD; //Тип сообщения
      Mes: Integer; //Тип пересылаемых данны, может быть несколько, к примеру - Mes2: String;
   end;
</pre>
<p>Далее, кликаем два раза на кнопку, создавая тем самым процедуру нажатия кноки, и пишем туда: Перед </p>
<p>begin:</p>
<pre>
Var
   Msg: ^TDXMessage; //Ссылаемя на TDXMessage
   MsgSize: Integer; //Размер сообщения
</pre>

<p>После:</p>
<pre>
MsgSize := SizeOf(TDXMessage); // Нужно узнать размер сообщения.
GetMem(Msg, MsgSize);
try
   Msg.MessageType := DXMESE; //Указываем тип сообщения
   Msg.Mes:=random(100); {Само сообщения, может быть что угодно, вплоть до нахождения курсора мышки}
   DXPlay1.SendMessage(DPID_ALLPLAYERS ,msg,msgsize); //Отправлем мессагу всем игрокам
   DXPlay1.SendMessage(DXPlay1.LocalPlayer.ID ,msg,msgsize); //Отпраляем себе
finally
   FreeMem(Msg); //Освобождаем память сообщения Msg
end;
</pre>
<p>Для приема делаем следующее - DXPlay1&lt;Events&lt;OnMessage и пишем :</p>
<pre>
Button1.Left:=TDXMessage(Data^).Mes; {Устанавливаем положения кнопки по горизонтали в соответсвии с полученным числом}
Button1.Caption:=inttostr(TDXMessage(Data^).Mes); //Пишем это число
</pre>

<p>Итак, это уже конец, осталось чуть-чуть:<br>
<p>В процедуре уничтожения формы (FormDestroy) (Tform1&lt;Events&lt;OnDestroy) пишем:</p>
<pre>
DXPlay1.Close; //Завершение подключения DXPlay.
</pre>
<p>И последний штрих &#8211; В Unit добавляем DirectX.<br>
Все, запускаем и радуемся нашей первой программе с мультиплеером! =)<br>
<p>&nbsp;</p>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
