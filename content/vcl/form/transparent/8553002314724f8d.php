<h1>Прозрачность в Delphi 6</h1>
<div class="date">01.01.2007</div>


<p>Перевод одноимённой статьи с сайта delphi.about.com )</p>

<p>В Delphi 6 разработчикам Windows-приложений доступна одна из замечательных возможностей создавать (полу)прозрачные формы (окна). В Delphi 6 класс TForm поддерживает формы со слоями, которые имеют свойства AlphaBlend, AlphaBlendValue, TransparentColor, и TransparentColorValue.</p>

<p>Прозрачность в форме означает то, что пользователь может видить то, что находится позати формы.</p>

<p>Чтобы подготовить форму к прозрачности, Вам потребуется установить свойство AlphaBlend в True. Если AlphaBlend установлено в True, то свойство AlphaBlendValue указывает степень прозрачности. Это свойство позволяет задать значения от 0 до 255. 0 указывает на полную прозрачность окна, в то время как 255 указывает на непрозрачное окно.</p>

<p>Так же возможно устанавливать свойства AlphaBlend и AlphaBlendValue во время разработки (или во время выполнения приложения) при помощи Object Inspector.</p>

<p>Возможно, Вы подумаете, что такая возможность в Delphi, может Вам пригодиться довольно редко, однако прозрачностью можно довольно эффективно привлекать внимание пользователей Вашей программы:</p>
<pre>
procedure TAboutBox.FormClose
(Sender: TObject; var Action: TCloseAction);
var
  i, cavb : 0..255;
begin
  if AlphaBlend=False then
  begin
    AlphaBlendValue:=255;
    AlphaBlend:=True;
  end;
  cavb:=AlphaBlendValue;
 
  for i := cavb downto 0 do
  begin
    AlphaBlendValue := i;
    Application.ProcessMessages;
  end
end;
</pre>


<p>Вышеприведённый код, в событие OnClose для формы about, создаёт плавно изменяющийся эффект. Когда пользователь попытается закрыть диалоговое окошко, то форма плавно исчезнет. Делается это путём циклического уменьшения AlphaBlendValue до нуля.</p>

<p>Другие два новый свойства формы в Delphi 6, это TransparentColor и TransparentColorValue. TransparentColor, это булевое свойство, которое указывает, будет определённый цвет, указанный в TransparentColorValue прозрачным. То есть мы можем задать прозрачность только определённому цвету.</p>

<p>И взаключении хотелось бы указать на главный недостаток. Все свойства, описанные выше, не будут работать, если приложение запущено не под Windows 2000 или выше, и если процессор на компьютере ниже P90.</p>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>


