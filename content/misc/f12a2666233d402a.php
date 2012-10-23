<h1>Ханойская башня</h1>
<div class="date">01.01.2007</div>


<p>"Ханойская башня" построена на очень простом алгоритме. Здесь я привожу этот алгоритм, который Вы сможете без труда воспроизвести.</p>

<pre>
type
  THanoiBin = 0..2;
  THanoiLevel = 0..9;
 
procedure MoveDisc(FromPin, ToPin : THanoiPin; Level : THanoiLevel);
//  Это Вы должны сделать сами. Переместите один диск с одного штырька на другой.
//  Диск окажется наверху (естественно, выше него дисков не будет) 
</pre>

<p>Вы можете каким угодно образом перемещать диски 3-х пирамид. 3 пирамиды - наиболее простая разновидность алгоритма. Таким образом процедура переноса диска (MoveDisc) аналогична операции переноса диска на верхний уровень (MoveTopDisc): переместить диск наверх с одного штырька (FromPin) на другой штырек (ToPin) и передать указатель на штырек-приемник (MoveTower) вместе с уровнем расположения перемещенного диска. Другое решение заключается в использовании трех массивов [THanoiLevel] логического типа. В этом случае триггер "Истина (True)" означает наличие на пирамиде диска с размером, соответствующим порядковому номеру элемента массива THanoiLevel.</p>

<pre>
procedure MoveTower(FromPin, ToPin : THanoiPin; Level : THanoiLevel);
begin
  if HanoiLevel &lt;= High(THanoiLevel) then
  begin
    MoveTower(FromPin, 3 - FromPin - ToPin, Level + 1);
    MoveDisc(FromPin, ToPin, Level);
    MoveTower(3 - FromPin - ToPin, ToPin, Level + 1);
  end;
end;
</pre>



<p>Чтобы переместить пирамиду целиком, вы должны вызвать процедуру MoveTower следующим образом:</p>


<p>MoveTower(0, 1, Low(THanoiLevel));</p>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
