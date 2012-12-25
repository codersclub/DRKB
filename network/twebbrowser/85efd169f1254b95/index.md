---
Title: Как загрузить HTML-код непосредственно в TWebBrowser?
Date: 01.01.2007
---


Как загрузить HTML-код непосредственно в TWebBrowser?
=====================================================

::: {.date}
01.01.2007
:::

    uses 
      ActiveX; 
     
    procedure WB_LoadHTML(WebBrowser: TWebBrowser; HTMLCode: string); 
    var 
      sl: TStringList; 
      ms: TMemoryStream; 
    begin 
      WebBrowser.Navigate('about:blank'); 
      while WebBrowser.ReadyState < READYSTATE_INTERACTIVE do 
       Application.ProcessMessages; 
     
      if Assigned(WebBrowser.Document) then 
      begin 
        sl := TStringList.Create; 
        try 
          ms := TMemoryStream.Create; 
          try 
            sl.Text := HTMLCode; 
            sl.SaveToStream(ms); 
            ms.Seek(0, 0); 
            (WebBrowser.Document as IPersistStreamInit).Load(TStreamAdapter.Create(ms)); 
          finally 
            ms.Free; 
          end; 
        finally 
          sl.Free; 
        end; 
      end; 
    end; 
     
    procedure TForm1.Button1Click(Sender: TObject); 
    begin 
      WB_LoadHTML(WebBrowser1,'SwissDelphiCenter'); 
    end; 

Взято с сайта <https://www.swissdelphicenter.ch/en/tipsindex.php>
