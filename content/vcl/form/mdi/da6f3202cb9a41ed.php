<h1>Как спрятать окна MDI Child?</h1>
<div class="date">01.01.2007</div>


<pre>
procedure TCustomForm.VisibleChanging;
begin
  if (FormStyle = fsMDIChild) and Visible then
    raise EInvalidOperation.Create(SMDIChildNotVisible);
end;
</pre>


<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
