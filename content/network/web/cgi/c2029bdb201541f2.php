<h1>Как отправить бинарные данные из CGI приложения?</h1>
<div class="date">01.01.2007</div>


<p>Не для кого не секрет, как просто можно получать данные различного типа из CGI приложения. Однако, иногда необходимо, чтобы данные сохранялись в виде файла с определённым именем, типа "Test.ZIP". Для этого необходимо добавить в заголовок HTTP пункт "Content-Disposition".</p>
<p>В Delphi для этого используется свойство CustomHeaders. В это TStrings свойство можно добавлять пункты в виде "name=value" - так как HTTP синтакс name:value здесь не используется.</p>
<p>Пример:</p>
<pre>procedure TWebModule1.WebModule1CHECKSTATUSAction(Sender: TObject;
  Request: TWebRequest; Response: TWebResponse; var Handled: Boolean);
var s : TFileStream;
begin
  s := nil;
  if request.query='download' then
  try
    response.Title := 'Download Test.ZIP';
    response.CustomHeaders.Add('Content-Disposition=filename=Test.zip');
    response.ContentType := 'application/zip';
    s := TFileStream.Create(fmOpenRead+fmShareDenyNone,'Test.zip');
    response.contentstream := s;
    response.sendresponse;
  finally
    s.Free;
  end;
end;
</pre>


<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

