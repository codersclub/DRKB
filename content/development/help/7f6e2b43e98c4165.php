<h1>Хелп с окошечком для поиска раздела</h1>
<div class="date">01.01.2007</div>


<pre>
procedure TForm1.HelpSearchFor; 
var 
  S : String; 
begin 
  S := ''; 
  Application.HelpFile := 'C:\MYAPPPATH\MYHELP.HLP'; 
  Application.HelpCommand(HELP_PARTIALKEY, LongInt(@S)); 
end; 
</pre>

<p>Konstantin Kipa </p>
<p>2:5061/19.17 </p>
<p>kotya@extranet.ru </p>
