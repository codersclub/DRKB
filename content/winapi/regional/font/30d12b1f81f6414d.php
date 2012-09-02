<h1>Как выяснить, установлены ли в системе шрифты TrueType</h1>
<div class="date">01.01.2007</div>


<pre>
function IsTrueTypeInstalled: bool;
var
  {$IFDEF WIN32}
  rs : TRasterizerStatus;
  {$ELSE}
  rs : TRasterizer_Status;
  {$ENDIF}
begin
  result := false;
  if not GetRasterizerCaps(rs, sizeof(rs)) then
    exit;
  if rs.WFlags and TT_AVAILABLE &lt;&gt; TT_AVAILABLE then
    exit;
  if rs.WFlags and TT_ENABLED &lt;&gt; TT_ENABLED then
    exit;
  result := true;
end;
</pre>


<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
