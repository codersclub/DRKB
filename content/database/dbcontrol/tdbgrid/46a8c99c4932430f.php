<h1>TDBGrid.CutToClipboard</h1>
<div class="date">01.01.2007</div>


<p>Внутри TDBGrid "зашит" защищенный (protected) элемент управления типа TInPlaceEdit, потомок TCustomMaskEdit. Данный элемент управляется комбинацией клавиш [Shift]+[Ins] и [Shift]+[Del]. Но для нас не существует способа оперировать элементом, поскольку он является защищенным членом.</p>
<p>Да, но вы можете сделать это обманным путем. Попробуйте так:</p>
<pre>
procedure TForm1.Paste1Click(Sender: TObject);
begin
  SendMessage(GetFocus, WM_PASTE, 0, 0);
end;
 
procedure TForm1.Copy1Click(Sender: TObject);
begin
  SendMessage(GetFocus, WM_COPY, 0, 0);
end;
</pre>

<p>Эти методы привязаны к вашим пунктам меню. Они посылают сообщение окну с текущим фокусом. Если это элемент управления TInPlaceEdit, то мы добились того, чего хотели.</p>

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
