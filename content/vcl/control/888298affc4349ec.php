<h1>Как получить число и список всех компонентов, расположенных на TNotebook?</h1>
<div class="date">01.01.2007</div>


<pre>
procedure TForm1.Button1Click(Sender: TObject);
var
  n: integer;
  p: integer;
begin
  ListBox1.Clear;
  with Notebook1 do
    begin
      for n := 0 to ControlCount - 1 do
        begin
          with TPage(Controls[n]) do
            begin
              ListBox1.Items.Add('Notebook Page: ' +
                TPage(Notebook1.Controls[n]).Caption);
              for p := 0 to ControlCount - 1 do
                ListBox1.Items.Add(Controls[p].Name);
              ListBox1.Items.Add(EmptyStr);
            end;
        end;
    end;
end;
</pre>


<hr />
<p>Вот две малениких процедурки, присваивающие заголовкам всех компонентов Label на всех страницах компонента NoteBook значение 'Foo'. (Я вам не говорил, что это будет ПОЛЕЗНЫМ примером!)</p>

<pre>
procedure TForm1.Button1Click(Sender: TObject);
var
  M, N: Word;
begin
  for N := 0 to TabbedNotebook1.Pages.Count - 1 do
    with TabbedNotebook1.pages.Objects[N] as TTabPage do
      for M := 0 to ControlCount - 1 do
        if Controls[M] is TLabel then
          with Controls[M] as TLabel do
            Caption := 'Foo';
end;
 
procedure TForm1.TabSet1Change(Sender: TObject; NewTab: Integer;
  var AllowChange: Boolean);
begin
  Notebook1.PageIndex := TabSet1.TabIndex;
end;
 
procedure TForm1.Button2Click(Sender: TObject);
var
  M, N: Word;
begin
  for N := 0 to TabbedNotebook1.Pages.Count - 1 do
    with Notebook1.pages.Objects[N] as TPage do
      for M := 0 to ControlCount - 1 do
        if Controls[M] is TLabel then
          with Controls[M] as TLabel do
            Caption := 'Foo';
 
end; 
</pre>
<a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>

