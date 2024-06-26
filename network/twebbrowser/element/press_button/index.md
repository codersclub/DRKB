---
Title: Как нажать кнопку в TWebBrowser, когда в окне есть несколько кнопок?
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Как нажать кнопку в TWebBrowser, когда в окне есть несколько кнопок?
====================================================================

If there is only one button, you can do something like: 
     
    WebBrowser1.OleObject.Document.forms.item(0).elements.item(0).click; 
     
This will do a click on the first element of the first `<FORM`>, where an 
element is either `<INPUT>`, `<SELECT>` or `<TEXTAREA>`.

If there is more than one button, you can do something like: 

    procedure TForm1.Button1Click(Sender: TObject); 
    var  
      ovElements: OleVariant;  
      i: Integer;  
    begin  
      ovElements := WebBrowser1.OleObject.Document.forms.item(0).elements;  
      for i := 0 to (ovElements.Length - 1) do 
        if (ovElements.item(i).tagName = 'INPUT') and 
          (ovElements.item(i).type = 'SUBMIT') and 
          (ovElements.item(i).Value = 'Recent Charges') then 
          ovElements.item(i).Click;  
    end; 

