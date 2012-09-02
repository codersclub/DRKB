<h1>Придание MDI-формам большей трехмерности</h1>
<div class="date">01.01.2007</div>



<pre>
constructor TMainForm.Create(AOwner: TComponent);
begin
  Inherited Create(AOwner);
  SetWindowLong(ClientHandle, GWL_EXSTYLE,
  GetWindowLong(ClientHandle,
  GWL_EXSTYLE) or WS_EX_CLIENTEDGE);
  SetWindowPos(ClientHandle, 0, 0, 0, 0, 0,
    swp_DrawFrame or swp_NoMove or swp_NoSize
    or swp_NoZOrder);
end;
</pre>

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
