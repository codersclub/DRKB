<h1>Как получить информацию о BIOS в Windows 9x?</h1>
<div class="date">01.01.2007</div>


<pre>
with Memo1.Lines do 
begin 
  Add('MainBoardBiosName:'+^I+string(Pchar(Ptr($FE061)))); 
  Add('MainBoardBiosCopyRight:'+^I+string(Pchar(Ptr($FE091)))); 
  Add('MainBoardBiosDate:'+^I+string(Pchar(Ptr($FFFF5)))); 
  Add('MainBoardBiosSerialNo:'+^I+string(Pchar(Ptr($FEC71)))); 
end;
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

