<h1>В TreeView текущий Node выделяется другим шрифтом</h1>
<div class="date">01.01.2007</div>


<pre>
procedure TForm1.TreeView1CustomDrawItem(Sender: TCustomTreeView;
Node: TTreeNode; State: TCustomDrawState; var DefaultDraw: Boolean);
begin
  if cdsSelected in State then
    Sender.Canvas.Font.Style := Sender.Canvas.Font.Style + [fsUnderline];
end;
 
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
