<h1>Необходимо, чтобы дочерняя форма не активизировала родительское окно</h1>
<div class="date">01.01.2007</div>


<p>Сделайте родительским окном рабочий стол.</p>
<pre>
procedure TForm2.CreateParams(VAR Params: TCreateParams); 
begin 
  Inherited CreateParams(Params); 
  Params.WndParent := GetDesktopWindow; 
end; 
</pre>

