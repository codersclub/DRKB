<h1>Поточность TreeView</h1>
<div class="date">01.01.2007</div>

Автор: Mike Scott</p>
<p>На пустой форме у меня располагается TTreeView. Затем я сохраняю это в файле, используя WriteComponent. Это работает как положено; я могу из DOS c помощью команды "type" посмотреть двоичный файл и увидеть его содержимое, типа строк TTreeView и имя объекта. По крайней мере файл записывается и создается впечатление его "наполненности".</p>
<p>Затем я освобождаю компонент TTreeView, открываю поток, делаю ReadComponent и, затем, InsertControl. И получаю исключение "TreeView1 has no parent window" (TreeView1 не имеет родительского окна).</p>
<p>Это происходит из-за того, что при установке определенных свойств TreeView требуется дескриптор окна элемента управления, а для этого необходимо иметь родителя. Решение заключается в создании пустого TreeView и передаче его в качестве параметра ReadComponent - вы наверняка меня спросите, почему ReadComponent необходим параметр, правильно? Смотрите дальше.</p>
<p>Попробуйте этот код:</p>
<pre>
procedure TForm1.Button1Click(Sender: TObject);
var 
  TreeView: TTreeView ;
begin
  with TFileStream.Create( 'JUNK.STR', fmCreate ) do 
    try
      WriteComponent( TreeView1 ) ;
      TreeView1.Name := 'TreeView' ;
      Position := 0 ;
      TreeView := TTreeView.Create( Self ) ;
      TreeView.Visible := false ;
      TreeView.Parent := Self ;
      ReadComponent( TreeView ) ;
      TreeView.Top := TreeView1.Top + TreeView1.Height + 10 ;
      TreeView.Visible := true ;
    finally
      Free ;
    end ;
end;
</pre>

<p>Два небольших замечания:</p>
<p>Убедитесь в отсутствии конфликта имен. Данный код делает форму владельцем второго TreeView и при ее освобождении разрушает компонент. Я просто переименовываю существующий TreeView перед загрузкой 'клона'.</p>
<p>Я установил свойство visible в false перед установкой свойства parent, этим я предотвратил показ только что созданного TreeView до момента загрузки его из потока.</p>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
