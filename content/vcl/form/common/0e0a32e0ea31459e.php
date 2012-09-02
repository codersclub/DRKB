<h1>Как установить минимальный размер окна?</h1>
<div class="date">01.01.2007</div>


<p>Необходимо объявить обработчик события для WM_GETMINMAXINFO:</p>
<pre>
... 
private 

 
  procedure WMGetMinMaxInfo(var Message : TWMGetMinMaxInfo); 
  message WM_GETMINMAXINFO; 
 
 
А вот как выглядит сам обработчик:
 
procedure TForm1.WMGetMinMaxInfo(var Message : TWMGetMinMaxInfo); 
begin 
  Message.MinMaxInfo^.ptMinTrackSize := Point(Width, Height); 
  Message.MinMaxInfo^.ptMaxTrackSize := Point(Width, Height); 
end; 
</pre>


<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

<p class="note">Примечание от Vit:</p>

<p>Начиная с Дельфи 5 появилось удобное свойство Constrains - специально для ограничесния минимальных и максимальных размеров...</p>
