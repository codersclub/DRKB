---
Title: Как отправить бинарные данные из CGI приложения?
Date: 01.01.2007
---


Как отправить бинарные данные из CGI приложения?
================================================

::: {.date}
01.01.2007
:::

Не для кого не секрет, как просто можно получать данные различного типа
из CGI приложения. Однако, иногда необходимо, чтобы данные сохранялись в
виде файла с определённым именем, типа \"Test.ZIP\". Для этого
необходимо добавить в заголовок HTTP пункт \"Content-Disposition\".

В Delphi для этого используется свойство CustomHeaders. В это TStrings
свойство можно добавлять пункты в виде \"name=value\" - так как HTTP
синтакс name:value здесь не используется.

Пример:

    procedure TWebModule1.WebModule1CHECKSTATUSAction(Sender: TObject;
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

Взято из <https://forum.sources.ru>
