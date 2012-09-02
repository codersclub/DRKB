<h1>Как создать свой пункт меню в Delphi IDE?</h1>
<div class="date">01.01.2007</div>


<pre>
{....} 
 
uses ToolsApi, Menus; 
 
{....} 
 
var 
  item: TMenuItem; 
begin 
  {get reference to delphi's mainmenu. You can handle it like a common TMainMenu} 
  with (BorlandIDEServices as INTAServices).GetMainMenu do 
  begin 
    item := TMenuItem.Create(nil); 
    item.Caption := 'A Mewn caption'; 
    Items.Add(item); 
  end; 
end; 
</pre>
<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
