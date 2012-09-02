<h1>Как сделать пункты меню с картинками?</h1>
<div class="date">01.01.2007</div>


<p>Следующий код показывает, как добавить картинку в виде объекта TImage в объект TMenuItem.</p>
<pre>
var 
   hHandle: THandle; 
   x: integer; 
   // visual controls: 
   hMenu: TMenuItem; 
   Image1: TImage; 
 
... 
 
  x:= 10; // десятый пункт меню
  hHandle := GetMenuItemID(hMenu.handle, x); 
  ModifyMenu(hMenu.handle, hHandle, MF_BYCOMMAND Or MF_BITMAP, hHandle, 
             PChar(Image1.picture.bitmap.handle)) 
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

