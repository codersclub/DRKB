---
Title: Скопировать, удалить, вставить в TWebBrowser
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Скопировать, удалить, вставить в TWebBrowser
============================================

    uses 
     ActiveX; 
     
    // Copy the selected text to the clipboard 
    procedure TForm1.Button7Click(Sender: TObject); 
    begin 
      try 
        WebBrowser1.ExecWB(OLECMDID_COPY, OLECMDEXECOPT_PROMPTUSER); 
      except 
      end; 
    end; 
     
    // Cut the selected text 
    procedure TForm1.Button8Click(Sender: TObject); 
    begin 
      try 
        WebBrowser1.ExecWB(OLECMDID_CUT, OLECMDEXECOPT_PROMPTUSER); 
      except 
      end; 
    end; 
     
    // Delete the selected text 
    procedure TForm1.Button9Click(Sender: TObject); 
    begin 
      try 
        WebBrowser1.ExecWB(OLECMDID_DELETE, OLECMDEXECOPT_PROMPTUSER); 
      except 
      end; 
    end; 
     
     
    initialization 
      OleInitialize(nil); 
     
    finalization 
      OleUninitialize; 
    end. 
     
    // as of Internet Explorer 4

