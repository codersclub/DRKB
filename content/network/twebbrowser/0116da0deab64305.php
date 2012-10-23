<h1>Как запретить всплывающее меню при нажатии правой кнопки мыши?</h1>
<div class="date">01.01.2007</div>


<p>Взято из FAQ:<a href="https://blackman.km.ru/myfaq/cont4.phtml" target="_blank">https://blackman.km.ru/myfaq/cont4.phtml</a></p>
<p>Перевод материала с сайта members.home.com/hfournier/webbrowser.htm</p>

<p>Вам необходимо включить интерфейс IDocHostUIHandler.</p>
<p>Для этого Вам понадобятся два файла: ieConst.pas и IEDocHostUIHandler.pas.</p>
<p>В методе ShowContextMenu интерфейса IDocHostUIHandler,</p>
<p>необходимо изменить возвращаемое значение с E_NOTIMPL на S_OK.</p>
<p>После этого меню перестанет реагировать на правое нажатие кнопки мыши.</p>
<p>Добавьте два модуля, упомянутые выше в секцию Uses и добавьте следующий код:</p>
<pre>
... var
Form1: TForm1;
FDocHostUIHandler: TDocHostUIHandler;
... 
implementation
... 
procedure TForm1.FormCreate(Sender: TObject);
begin
  FDocHostUIHandler := TDocHostUIHandler.Create;
end; 
 
procedure TForm1.FormClose(Sender: TObject; var Action: TCloseAction);
begin
  FDocHostUIHandler.Free;
end; 
procedure TForm1.WebBrowser1NavigateComplete2(Sender: TObject;
pDisp: IDispatch; var URL: OleVariant);
var
  hr: HResult;
  CustDoc: ICustomDoc;
begin
  hr := WebBrowser1.Document.QueryInterface(ICustomDoc, CustDoc);
  if hr = S_OK then CustDoc.SetUIHandler(FDocHostUIHandler);
end;
</pre>

