<h1>Перемещение на страницу TabSet по имени</h1>
<div class="date">01.01.2007</div>

Разместите компоненты Tabset(TabSet1) и Edit (Edit1) на вашей форме. Измените свойство компонента Tabset Tabs для размещения в списке строк следующих четерых закладок:</p>
<p>Hello</p>
<p>World</p>
<p>Of</p>
<p>Delphi</p>
<p>Создайте обработчик события onChange компонента Edit1 как показано ниже:</p>
<pre>
procedure TForm1.Edit1Change(Sender: TObject);
var
  I: Integer;
begin
  for  I:= 0 to tabset1.tabs.count-1 do
    if  edit1.text = tabset1.tabs[I] then
      tabset1.tabindex:=I;
end;
</pre>
<p>Теперь при наборе любого из существующих имен в edit1 соотвутствующая закладка будет выведена на передний план.</p>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
