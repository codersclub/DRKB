<h1>Как поместить TMenuItem справа у формы?</h1>
<div class="date">01.01.2007</div>


<p>Допустим, у Вас есть TMainMenu MainMenu1 и HelpMenuItem в конце панели меню (Menubar). Если Вызвать следующий обработчик события OnCreate, то HelpMenuItem сместится вправо.</p>
<pre>
uses 
  Windows; 
 
procedure TForm1.FormCreate(Sender: TObject); 
begin 
  ModifyMenu(MainMenu1.Handle, 0, mf_ByPosition or mf_Popup 
             or mf_Help, HelpMenuItem1.Handle, '&amp;Help'); 
end;
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

