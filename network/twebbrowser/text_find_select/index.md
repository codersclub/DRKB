---
Title: Найти и выделить текст в TWebBrowser
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Найти и выделить текст в TWebBrowser
====================================

    {....} 
     
      private 
        procedure SearchAndHighlightText(aText: string); 
     
    {....} 
     
    procedure TForm1.SearchAndHighlightText(aText: string); 
    var 
      i: Integer; 
    begin 
      for i := 0 to WebBrowser1.OleObject.Document.All.Length - 1 do 
      begin 
        if Pos(aText, WebBrowser1.OleObject.Document.All.Item(i).InnerText) <> 0 then 
        begin 
          WebBrowser1.OleObject.Document.All.Item(i).Style.Color := '#FFFF00'; 
          WebBrowser1.OleObject.Document.All.Item(i).ScrollIntoView(True); 
        end; 
      end; 
    end; 
     
    procedure TForm1.Button1Click(Sender: TObject); 
    begin 
      SearchAndHighlightText('some text...'); 
    end; 

