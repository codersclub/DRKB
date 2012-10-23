<h1>Функция для работы с палитрами и RGB</h1>
<div class="date">01.01.2007</div>


<p>У меня трудности с пониманием операций, производимых в Delphi над палитрой. По существу, я имею 4 открытых формы, которые должны использовать цвета, которые не входят в стандрартный набор из 20 именованных цветов. Ячейки таблицы также должны использовать мои нестандартные цвета. Есть какой-либо способ обновления системной палитры для того, чтобы все формы использовали один и тот же цвет?</p>

<p>При работе с палитрами рекомендуется пользоваться функцией RGB. Если вы используете ее для изменения свойства "Color", Windows довольно хорошо справляется с задачай подбора цветов для низкого разрешения, а в системах с высоким разрешением вы получите точный цвет RGB. Это могло бы послужить выходом из создавшейся у вас ситуации. Вот пример формы, которая "линяет" от красного до синего:</p>

<pre>
procedure TForm1.FormClick(Sender: TObject);
var
  blue: Byte;
begin
  For blue := 0 to 255 do
  Begin
    Color := RGB(255-blue,0,blue);
    Update;
  End;
end;
</pre>

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
