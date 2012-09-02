<h1>Прокрутка TreeView, чтобы держать выделение посередине</h1>
<div class="date">01.01.2007</div>


<pre>
procedure TMyForm.TreeChange(Sender: TObject; Node: TTreeNode);
 var
   i : integer;
   pp, cp : TTreeNode;
 begin
   if Assigned(Tree.Selected) then
     begin
       cp := Tree.Selected;
       pp := cp;
       for i := 1 to Round(Tree.Height/30) do
         if cp &lt;&gt; nil then
           begin
             pp := cp;
             cp := cp.GetPrevVisible;
           end;
       Tree.TopItem := pp;
     end;
 end;
</pre>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>

