---
Title: Как загрузить потоковые (stream) данные в TWebBrowser, не прибегая к открытию файла?
Author: Per Larsen
Date: 01.01.2007
Source: FAQ: <https://blackman.km.ru/myfaq/cont4.phtml>
---


Как загрузить потоковые (stream) данные в TWebBrowser, не прибегая к открытию файла?
====================================================================================


_Перевод материала с сайта members.home.com/hfournier/webbrowser.htm_

    function TForm1.LoadFromStream(const AStream: TStream): HRESULT;
    begin
    AStream.seek(0, 0);
    Result := (WebBrowser1.Document as IPersistStreamInit)
              .Load(TStreamAdapter.Create(AStream));
    end;

**Примечание от Vit**

1. В Uses добавить ActiveX
2. Если в TWebBrowser ничего не загружено то код выдаёт Access Violation

Исправляется следующим образом:

    function TForm1.LoadFromStream(const AStream: TStream): HRESULT;
    begin
      AStream.seek(0, soFromBeginning);
      WebBrowser1.Navigate('about:blank');
      Result := (WebBrowser1.Document as IPersistStreamInit)
                .Load(TStreamAdapter.Create(AStream));
    end;
