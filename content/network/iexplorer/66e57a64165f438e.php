<h1>Как автоматически заполнить поля формы в IE?</h1>
<div class="date">01.01.2007</div>


<pre>
{ 
  This example shows how to automatically fill in a search string 
  in the "Search Tip" page and click the search button. 
} 
 
uses 
  MSHTML_TLB; 
 
// first navigate to tipspage 
 
procedure TForm1.Button1Click(Sender: TObject); 
begin 
  Webbrowser1.Navigate('http://www.swissdelphicenter.ch/en/tipsuchen.php'); 
end; 
 
// Try to access IE instance and fill out the search field with 
// a text and click the search button 
 
procedure TForm1.Button3Click(Sender: TObject); 
var 
  hIE: HWND; 
  ShellWindow: IShellWindows; 
  WB: IWebbrowser2; 
  spDisp: IDispatch; 
  IDoc1: IHTMLDocument2; 
  Document: Variant; 
  k, m: Integer; 
  ovElements: OleVariant; 
  i: Integer; 
begin 
  ShellWindow := CoShellWindows.Create; 
  // get the running instance of Internet Explorer 
  for k := 0 to ShellWindow.Count do 
  begin 
    spDisp := ShellWindow.Item(k); 
    if spDisp = nil then Continue; 
    // QueryInterface determines if an interface can be used with an object 
    spDisp.QueryInterface(iWebBrowser2, WB); 
 
    if WB &lt;&gt; nil then 
    begin 
      WB.Document.QueryInterface(IHTMLDocument2, iDoc1); 
      if iDoc1 &lt;&gt; nil then 
      begin 
        WB := ShellWindow.Item(k) as IWebbrowser2; 
        begin 
          Document := WB.Document; 
 
          // count forms on document and iterate through its forms 
          for m := 0 to Document.forms.Length - 1 do 
          begin 
            ovElements := Document.forms.Item(m).elements; 
            // iterate through elements 
            for i := 0 to ovElements.Length - 1 do 
            begin 
              // when input fieldname is found, try to fill out 
              try 
                if (CompareText(ovElements.item(i).tagName, 'INPUT') = 0) and 
                  (CompareText(ovElements.item(i).type, 'text') = 0) then 
                begin 
                  ovElements.item(i).Value := 'FindWindow'; 
                end; 
              except 
              end; 
              // when Submit button is found, try to click 
              try 
                if (CompareText(ovElements.item(i).tagName, 'INPUT') = 0) and 
                  (CompareText(ovElements.item(i).type, 'SUBMIT') = 0) and 
                  (ovElements.item(i).Value = 'Search') then  // Suchen fьr German 
                begin 
                  ovElements.item(i).Click; 
                end; 
              except 
              end; 
            end; 
          end; 
        end; 
      end; 
    end; 
  end; 
end; 
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
