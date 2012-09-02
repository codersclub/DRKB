<h1>Как показать TDBGrid в режиме disabled?</h1>
<div class="date">01.01.2007</div>


<p>Ниже приведен пример, меняющий цвет шрифта на clGray, когда доступ к элементу управления (в данном случае TDBGrid) запрещен (disabled). </p>

<pre>
procedure TForm1.Button1Click(Sender: TObject);
begin
  DbGrid1.Enabled := false;
  DbGrid1.Font.Color := clGray;
end;
 
procedure TForm1.Button2Click(Sender: TObject);
begin
  DbGrid1.Enabled := true;
  DbGrid1.Font.Color := clBlack;
end;
</pre>


<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

