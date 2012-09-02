<h1>Симуляция нажатия кнопки при наличии TDBGrid</h1>
<div class="date">01.01.2007</div>


<p>В случае нажатия клавиши Enter, клавиша по умолчанию не срабатывает, если у вас на форме расположен компонент DBGrid, но вы можете создать обработчик события DBGrid OnKeypUp, уведомляющий кнопку по умолчанию о ее "нажатии" при реальном нажатии клавиши Enter. Пример:</p>
<pre>
{Код DBGrid OnKeyUp. Default-кнопка - BitBtn1.}
if Key = VK_RETURN then
begin
  PostMessage(BitBtn1.Handle, WM_LBUTTONDOWN, Word(0), LongInt(0)) ;
  PostMessage(BitBtn1.Handle, WM_LBUTTONUP, Word(0), LongInt(0)) ;
end ;
</pre>

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>


