<h1>Реагируем на щелчок по ссылке в TWebBrowser</h1>
<div class="date">01.01.2007</div>


<pre>

 
 
var
  Document: IHtmlDocument2;
  V: Variant;
 
procedure TForm1.FormCreate(Sender: TObject);
begin
  WebBrowser1.Navigate('about:blank');
  while WebBrowser1.Document = nil do
    Application.ProcessMessages;
  Document := WebBrowser1.Document as IHtmlDocument2;
end;
 
procedure TForm1.Button1Click(Sender: TObject);
begin
  V[0] :='&lt;a href="https://ya.ru"&gt;Run&lt;/a&gt;';
  Document.Writeln(PSafeArray(TVarData(v).VArray));
  WebBrowser1.OleObject.Document.ParentWindow.Scroll(0, 10000000);
end;
 
procedure TForm1.WebBrowser1BeforeNavigate2(Sender: TObject;
  const pDisp: IDispatch; var URL, Flags, TargetFrameName, PostData,
  Headers: OleVariant; var Cancel: WordBool);
begin
  if url &lt;&gt; 'about:blank' then
  begin
    WebBrowser2.Navigate(URL);
    Cancel := True;
  end;
end;
</pre>
<div class="author">Автор: Rouse_</div>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
&nbsp;<br>

<hr />
<pre>

 
var
  NavigateTo: Boolean = False;
 
procedure TForm1.WebBrowser1BeforeNavigate2(Sender: TObject;
  const pDisp: IDispatch; var URL, Flags, TargetFrameName, PostData,
  Headers: OleVariant; var Cancel: WordBool);
begin
  if NavigateTo then
  begin
    Cancel := True;
    WebBrowser2.Navigate(URL);
  end;
end;
 
procedure TForm1.Button2Click(Sender: TObject);
begin
  WebBrowser1.Navigate('about:&lt;a href="https://ya.ru"&gt;Run&lt;/a&gt;');
  NavigateTo := True;
end;
</pre>
<div class="author">Автор: s-mike</div>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
&nbsp;<br>

<hr />
<p>OnNewWindow2 <br>
Возникает при попытке открыть документ в новом окне. Если Вы хотите, чтобы документ был открыт в Вашем экземпляре броузера, то Вам нужно создать свой экземпляр броузера и параметру ppDisp присвоить интерфейсную ссылку на этот экземпляр:<br>
<p>&nbsp;</p>
<pre>
procedure TFormSimpleWB.WebBrowser1NewWindow2(Sender: TObject;
  var ppDisp: IDispatch; var Cancel: WordBool);
var 
  newForm:TFormSimpleWB;
begin 
  newForm := TFormSimpleWB.Create(Application);
  newForm.Show;
  ppDisp := newForm.WebBrowser1.ControlInterface;
end;
</pre>
<p>&nbsp;<br>
<div class="author">Автор: -TOXA- </div>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a><br>
<p>&nbsp;</p>
