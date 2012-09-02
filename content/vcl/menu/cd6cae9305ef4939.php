<h1>Как добавить пункт меню?</h1>
<div class="date">01.01.2007</div>


<pre>
procedure AddItemsM(vAction: TAction; vMenu:TMainMenu);

var
 index: integer
 vItems :TMenuItem;
begin
 index := vMenu.Items.IndexOf(nmWindow);
 vItems := TMenuItem.Create(vMenu);
 vItems.Action := vAction;
 vMenu.Items.Items[index].Add(vItems);
end;
</pre>
<p>nmWindow - это Name пункта меню "Окна"</p>
<p>(этот код я писал для добавления открытых окон в пункт меню "Окна", главного меню своего приложения) </p>
<p class="author">Автор Pegas</p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
