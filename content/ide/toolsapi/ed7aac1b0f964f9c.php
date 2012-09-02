<h1>Как найти все установленные компоненты?</h1>
<div class="date">01.01.2007</div>



<pre>
uses ToolsApi;
{....}
var
  a, i: Integer;
begin
  with (BorlandIDEServices as IOTAPackageServices) do
  begin
    for a := 0 to GetPackageCount - 1 do
    begin
      for i := 0 to GetComponentCount(a) - 1 do
      begin
        {get each component name with GetComponentName(a, i);}
      end;
    end;
  end;
end;
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
