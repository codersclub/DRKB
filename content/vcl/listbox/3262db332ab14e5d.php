<h1>Уменьшение мерцания TListBox в обработчике OwnerDraw</h1>
<div class="date">01.01.2007</div>


<p>Предположим ListBox имеет в своем списке два элемента, элемент 0 имеет фокус, активен другой компонент и вы щелкаете на элементе 1. При этом происходит *ПЯТИКРАТНЫЙ* вызов OnDrawItem, смотрите сами изменения состояний двух элементов: </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Index&nbsp;&nbsp; State</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 0&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [odSelected, odFocused]</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 0&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [odSelected]</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 0&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; []</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [odSelected]</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [odSelected, odFocused]</p>
<p>В случае единственного элемента в списке ListBox получается конфуз, поскольку при щелчке на нем вы получаете тот же самый сценарий, только вместо двух индексов присутствует один, нулевой. </p>
<p>Имея эту информацию, вы можете минимизировать количество вызовов процедуры отрисовки. Для примера, в не-multi-select ListBox, элемент не нужно отрисовывать, если его состояние = [odSelected], поскольку это состояние всегда сопровождается НЕ selected НЕ focused, или ОДНОВРЕМЕННО selected и focused. В этом вам поможет технология отслеживания в обработчике OnDrawItem предыдущего отрисованного элемента, и если предыдущий запомненный элемент равен текущему, то отрисовывать его необязательно, например:</p>
<pre>
...
const 
  LastIndex: LongInt = -1;
begin
  IF Index = LastIndex THEN
    ...
  ELSE
    ...
  LastIndex := Index;
end;
</pre>

<div class="author">Автор: Neil </div>

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
