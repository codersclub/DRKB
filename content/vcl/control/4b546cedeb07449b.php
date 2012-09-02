<h1>Добавление и удаление страниц TNotebook</h1>
<div class="date">01.01.2007</div>

Автор: Mark Johnson </p>
<p>Как во время выполнения программы динамически добавлять и удалять страницы динамически созданного NoteBook?</p>
<pre>
procedure AddPage(nbk: TNotebook; tabset: TTabSet; const pagename: string);
{ Добавляем новую страницу к NoteBook и новую закладку к tabset
(параметр pagename задает имя страницы), размещаем на странице
компонент Memo и выводим новую страницу на передний план.
Подразумевается, что TabSet (набор закладок) имеет ровно по
одной закладке на каждую страницу NoteBook с точным сохранением порядка. }
 
var
  memo: TMemo;
  page: TPage;
begin
  if nbk &lt;&gt; nil then
  begin
    nbk.Pages.Add(pagename); {добавляем страницу в TNotebook}
    nbk.PageIndex := nbk.Pages.Count - 1; {делаем новую страницу текущей}
    if tabset &lt;&gt; nil then
    begin
      tabset.Tabs.Add(pagename); {добавляем соответствующую закладку}
      tabset.TabIndex := nbk.PageIndex; {делаем новую закладку текущей}
    end;
    if nbk.PageIndex &gt; -1 then
    begin {убедимся что страница существует}
      page := TPage(nbk.Pages.Objects[nbk.PageIndex]); {получаем объект страницы}
      }
        memo := TMemo.Create(page);
          {создаем TMemo (и страницей в качестве родителя)}
      try
        memo.Parent := page; {устанавливаем страницу в качестве Parent}
        memo.Align := alClient;
          {устанавливаем выравнивание для заполнения области клиента}
      except
        memo.Free; {освобождаем TMemo, если что-то идет неправильно}
      end;
      page.Visible := true; {показываем страницу}
    end;
  end;
end;
 
procedure DeletePage(nbk: TNotebook; tabset: TTabSet; index: integer);
{ Удаляем страницу, чей PageIndex = index из nbk и tabset. Подразумевается,
что TabSet имеет ровно по одной закладке на каждую страницу NoteBook с
точным сохранением порядка. }
 
var
  switchto: integer;
begin
  if nbk &lt;&gt; nil then
  begin
    if (index &gt;= 0) and (index &lt; nbk.Pages.Count) then
    begin
      if index = nbk.PageIndex then
      begin
        if index &lt; nbk.Pages.Count - 1 then
        begin {если страница не последняя в списке}
          switchto := nbk.PageIndex;
            {выводим страницу за текущей, ставшей ею после удаления}
          if (index = 0) and (nbk.Pages.Count &gt; 1) then {если первая страница}
            nbk.PageIndex := 1; {теперь показываем вторую страницу}
        end
        else
          switchto := nbk.PageIndex - 1;
            {в противном случае показываем страницу, расположенную перед текущей}
      end;
      nbk.Pages.Delete(index);
        {освобождаем страницу и все принадлежавшие ей элементы управления}
      if tabset &lt;&gt; nil then
      begin
        if index &lt; tabset.Tabs.Count then
          tabset.Tabs.Delete(index); {удаляем соответствующую закладку}
      end;
      nbk.PageIndex := switchto;
    end;
  end;
end;
 
 
</pre>
<hr />
<pre>
procedure TForm1.Button1Click(Sender: TObject);
var
  NewPage: TWinControl;
begin
  TabbedNotebook1.Pages.Add(Edit1.Text);
  NewPage := TabbedNotebook1.Pages.Objects[TabbedNotebook1.Pages.Count - 1]
    as TWinControl;
  with TLabel.Create(Self) do
  begin
    Left := 20;
    Top := 20;
    Caption := '&amp;Телефон: ';
    Parent := NewPage;
  end;
  with TEdit.Create(Self) do
  begin
    Left := 100;
    Top := 20;
    Text := '1-800-555-1212';
    Parent := NewPage;
  end;
end;
 
 
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
