<h1>Как вставить свой пункт меню?</h1>
<div class="date">01.01.2007</div>


<pre class="delphi">
{ ... }
var
  CBar: CommandBar;
  MenuItem: OleVariant;
  { ... }
 
{ Add an item to the File menu }
  CBar := Word.CommandBars['File'];
  MenuItem := CBar.Controls.Add(msoControlButton, EmptyParam, EmptyParam,
    EmptyParam, True) as CommandBarButton;
  MenuItem.Caption := 'NewMenuItem';
  MenuItem.DescriptionText := 'Does nothing';
{Note that a VB macro with the right name must exist before you assign it to the item!}
  MenuItem.OnAction := 'VBMacroName';
{ ... }
</pre>

<p>Взято с Delphi Knowledge Base: <a href="https://www.baltsoft.com/" target="_blank">https://www.baltsoft.com/</a></p>
