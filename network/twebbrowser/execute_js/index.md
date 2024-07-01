---
Title: Как выполнить JavaScript-функцию?
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Как выполнить JavaScript-функцию?
=================================

    uses 
      MSHTML_TLB, SHDocVw, ShellAPI; 
     
    // function to execute a script function 
     
    function ExecuteScript(doc: IHTMLDocument2; script: string; language: string): Boolean; 
    var 
      win: IHTMLWindow2; 
      Olelanguage: Olevariant; 
    begin 
      if doc <> nil then 
      begin 
        try 
          win := doc.parentWindow; 
          if win <> nil then 
          begin 
            try 
              Olelanguage := language; 
              win.ExecScript(script, Olelanguage); 
            finally 
              win := nil; 
            end; 
          end; 
        finally 
          doc := nil; 
        end; 
      end; 
    end; 
     
    // 2 Examples how to login to gmx homepage 
     
    procedure FillInGMXForms(WB: ShDocVW_TLB.IWebbrowser2; IDoc1: IHTMLDocument2; 
      Document: Variant; AKennung, APasswort: string); 
    const 
      IEFields: array[1..4] of string = ('INPUT', 'text', 'INPUT', 'password'); 
    var 
      IEFieldsCounter: Integer; 
      i: Integer; 
      m: Integer; 
      ovElements: OleVariant; 
    begin 
      if Pos('GMX - Homepage', Document.Title) <> 0 then 
     
        while WB.ReadyState <> READYSTATE_COMPLETE do 
          Application.ProcessMessages; 
     
      // count forms on document and iterate through its forms 
      IEFieldsCounter := 0; 
      for m := 0 to Document.forms.Length - 1 do 
      begin 
        ovElements := Document.forms.Item(m).elements; 
     
        // iterate through elements 
        for i := ovElements.Length - 1 downto 0 do 
        begin 
          try 
            // if input fields found, try to fill them out 
            if (ovElements.item(i).tagName = IEFields[1]) and 
              (ovElements.item(i).type = IEFields[2]) then 
            begin 
              ovElements.item(i).Value := AKennung; 
              Inc(IEFieldsCounter); 
            end; 
     
            if (ovElements.item(i).tagName = IEFields[3]) and 
              (ovElements.item(i).type = IEFields[4]) then 
            begin 
              ovElements.item(i).Value := APasswort; 
              Inc(IEFieldsCounter); 
            end; 
          except 
            // failed... 
          end; 
        end; { for i...} 
      end;  { for m } 
      // if the fields are filled in, submit. 
      if IEFieldsCounter = 3 then ExecuteScript(iDoc1, 'document.login.submit()', 
          'JavaScript'); 
    end; 
     
    function LoginGMX_IE(AKennung, APasswort: string): Boolean; 
    var 
      ShellWindow: IShellWindows; 
      WB: ShDocVW_TLB.IWebbrowser2; 
      spDisp: IDispatch; 
      IDoc1: IHTMLDocument2; 
      Document: Variant; 
      k: Integer; 
    begin 
      ShellWindow := CoShellWindows.Create; 
      // get the running instance of Internet Explorer 
      for k := 0 to ShellWindow.Count do 
      begin 
        spDisp := ShellWindow.Item(k); 
        if spDisp = nil then Continue; 
        // QueryInterface determines if an interface can be used with an object 
        spDisp.QueryInterface(iWebBrowser2, WB); 
        if WB <> nil then 
        begin 
          WB.Document.QueryInterface(IHTMLDocument2, iDoc1); 
          if iDoc1 <> nil then 
          begin 
            WB := ShellWindow.Item(k) as ShDocVW_TLB.IWebbrowser2; 
            Document := WB.Document; 
            // if GMX page... 
            FillInGMXForms(WB, IDoc1, Document, AKennung, APasswort); 
          end;  { idoc <> nil } 
        end; { wb <> nil } 
      end;  { for k } 
    end; 
     
    // Example 1: Navigate to the gmx homepage in the IE browser an login 
    procedure TForm1.Button1Click(Sender: TObject); 
    begin 
      ShellExecute(Handle, 
        'open', 
        'http://www.gmx.ch', 
        nil, 
        nil, 
        SW_SHOW); 
      Sleep(2000); 
      LoginGMX_IE('user@gmx.net', 'pswd'); 
    end; 
     
     
    // Example 2: navigate to the gmx homepage in the Webbrowser an login 
    procedure TForm1.Button2Click(Sender: TObject); 
    var 
      IDoc1: IHTMLDocument2; 
      Web: ShDocVW_TLB.IWebBrowser2; 
    begin 
      Webbrowser1.Navigate('http://www.gmx.ch'); 
      while Webbrowser1.ReadyState <> READYSTATE_COMPLETE do 
        Application.ProcessMessages; 
      Webbrowser1.Document.QueryInterface(IHTMLDocument2, iDoc1); 
      Web := WebBrowser1.ControlInterface; 
      FillInGMXForms(Web, iDoc1, Webbrowser1.Document, 'user@gmx.net', 'pswd'); 
    end;

