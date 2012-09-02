<h1>Как заставить форму не разворачиваться из иконки?</h1>
<div class="date">01.01.2007</div>


<pre>
procedure WMQueryOpen(var Msg: TWMQueryOpen);
  message WM_QUERYOPEN;
 
// ... и ее реализация
procedure TMainForm.WMQueryOpen(var Msg: TWMQueryOpen);
begin
  Msg.Result := 0;
end;
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
