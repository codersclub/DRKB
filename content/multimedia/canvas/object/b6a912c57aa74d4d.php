<h1>Как рисовать на компоненте, если свойство Canvas недоступно?</h1>
<div class="date">01.01.2007</div>


<p>У всех компонентов, порожденных от TCustomControl, имеется свойство Canvas типа TCanvas.</p>
<p>Если свойство Canvas недоступно, Вы можете достучаться до него созданием потомка и переносом этого свойства в раздел Public.</p>
<pre>
{ Example. We recommend You to create this component through Component Wizard.
In Delphi 1 it can be found as 'File|New Component...', and can be found
as 'Component|New Component...' in Delphi 2 or above. }
type
  TcPanel = class(TPanel)
  public
    property Canvas;
  end;
</pre>


<p>Akzhan Abdulin</p>
<p>(2:5040/55)</p>

<p>Если у объекта нет свойства Canvas (у TDBEdit, вpоде-бы нет), по кpайней меpе в D3 можно использовать класс TControlCanvas. Пpимеpное использование:</p>
<pre>
var cc: TControlCanvas; 
... 
cc := TControlCanvas.Create; 
cc.Control := youControl; 
... 
</pre>

<p>и далее как обычно можно использовать методы Canvas.</p>

<p>Andrew Velikoredchanin</p>
<p>(2:5026/29.3)</p>
