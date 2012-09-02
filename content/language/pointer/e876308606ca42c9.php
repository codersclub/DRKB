<h1>Получение ссылки на экземпляр класса</h1>
<div class="date">01.01.2007</div>


<p>...мне также понадобилось в подпрограмме получить ссылку на дочернее MDI-окно без сообщения подпрограмме с каким конкретно классом MDI необходимо работать. Что я сделал: я передавал в виде параметров тип дочернего MDI-окна и ссылку как нетипизированную переменную и затем обрабатывал это в подпрограмме.</p>

<p>Вот пример. Эта подпрограмма работает с дочерним окном, которое может иметь только один экземпляр. Если оно не открыто, подпрограмма создаст его, если оно открыто, оно переместит его на передний план.</p>

<pre>
procedure FormLoader(FormClassType: TFormClass; var FormName);
begin
  if TForm(FormName) = nil then
    begin
      Application.CreateForm(FormClassType, FormName);
    end
  else
    begin
      TForm(FormName).BringToFront;
      TForm(FormName).WindowState := wsNormal;
    end;
end;
 
Вот как это вызывать:
 
procedure TfrmTest.sbOpenClick(Sender: TObject);
begin
  FormLoader(TfrmTest, frmTest);
end;
</pre>

<p>Взято из Советов по Delphi от <a href="mailto:mailto:webmaster@webinspector.com" target="_blank">Валентина Озерова</a></p>
<p>Сборник Kuliba</p>

