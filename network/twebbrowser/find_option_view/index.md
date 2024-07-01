---
Title: Как вызвать команды Find, Option или View Source?
Date: 01.01.2007
Source: FAQ: <https://blackman.km.ru/myfaq/cont4.phtml>
---


Как вызвать команды Find, Option или View Source?
=================================================


_Перевод материала с сайта members.home.com/hfournier/webbrowser.htm_

Вот пример вызова диалога

    const
      HTMLID_FIND = 1;
      HTMLID_VIEWSOURCE = 2;
      HTMLID_OPTIONS = 3;
     
    ... 
     
    procedure TForm1.FindIE;
    const
      CGID_WebBrowser: TGUID = '{ED016940-BD5B-11cf-BA4E-00C04FD70816}';
    var
      CmdTarget : IOleCommandTarget;
      vaIn, vaOut: OleVariant;
      PtrGUID: PGUID;
    begin
      New(PtrGUID);
      PtrGUID^ := CGID_WebBrowser;
      if WebBrowser1.Document < > nil then
      try
        WebBrowser1.Document.QueryInterface(IOleCommandTarget, CmdTarget);
        if CmdTarget <> nil then
        try
          CmdTarget.Exec( PtrGUID, HTMLID_FIND, 0, vaIn, vaOut);
        finally
          CmdTarget._Release;
        end;
      except
        // Ничего
      end;
      Dispose(PtrGUID);
    end;
