<h1>Сыграть звуковой файл без компонентов</h1>
<div class="date">01.01.2007</div>


<p>Если Вам не нужен компонент MediaPlayer, а сыграть звук, например, при нажатии на кнопку, нужно, воспользуйтесь функцией PlaySound. Одна из ее возможностей &#8211; сыграть wav-файл.</p>
<pre>
uses MMsystem;
 
procedure TForm1.Button1Click(Sender: TObject);
begin
  if OpenDialog1.Execute then
    PlaySound(PChar(OpenDialog1.FileName), 0, SND_FILENAME);
end;
</pre>


<div class="author">Автор: Даниил Карапетян (delphi4all@narod.ru)</div>
<div class="author">Автор справки: Алексей Денисов (aleksey@sch103.krasnoyarsk.su)</div>

