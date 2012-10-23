<h1>Как получить координаты указателя мыши относительно формы в Delphi?</h1>
<div class="date">01.01.2007</div>

Существует такой тип, как TMouse, который передаёт координаты мышки в любое время, так что помести в обработчик события нажатия мыши на форме его вызов. Подробнее смотри в хелпе.</p>
<p>Лучше говорить, что существует объект класса TMouse, на него ссылается глобальная переменная Mouse из модуля Controls... А то человек кинется создавать свой экземпляр...</p>
<pre>
procedure TForm1.FormClick(Sender: TObject);
var
  MyMouse: TMouse;
begin
  Form1.Caption := inttostr(MyMouse.CursorPos.x) + 'Х ' +
  inttostr(MyMouse.CursorPos.y);
end;
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>

