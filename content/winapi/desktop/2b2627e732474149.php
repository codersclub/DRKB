<h1>Как установить обои в формате JPEG?</h1>
<div class="date">01.01.2007</div>


<p>Как установить обои в формате jpeg.</p>
<p>SystemParametersInfo только для bmp.</p>
<pre>
uses
  ComObj, ShlObj;
 
procedure ChangeActiveWallpaper;
const
  CLSID_ActiveDesktop: TGUID = '{75048700-EF1F-11D0-9888-006097DEACF9}';
var
  ActiveDesktop: IActiveDesktop;
begin
  ActiveDesktop := CreateComObject(CLSID_ActiveDesktop) as IActiveDesktop;
  ActiveDesktop.SetWallpaper('c:\windows\forest.jpg', 0);
  ActiveDesktop.ApplyChanges(AD_APPLY_ALL or AD_APPLY_FORCE);
end;
</pre>


<div class="author">Автор: Vasya2000</div>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

