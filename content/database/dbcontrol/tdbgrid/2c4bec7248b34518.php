<h1>Буфер обмена и ячейки TDBGrid</h1>
<div class="date">01.01.2007</div>


<p>Внутренний (in-place) редактор является защищенным свойством TCustomGrid, поэтому тут придется немного поколдовать. Вы можете сделать приблизительно так:</p>
<pre>
type
  TMyCustomGrid = class(TCustomGrid)
  public
    property InplaceEditor;
  end;
 
...
 
if ActiveControl is TCustomGrid then
  TMyCustomGrid(ActiveControl).InplaceEditor.CopyToClipboard;
</pre>


<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
