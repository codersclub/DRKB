<h1>Как программно перевести TDBGrid в режим редактирования?</h1>
<div class="date">01.01.2007</div>


<p>Переведите таблицу в режим редактирования, затем получите дескриптор (handle) окна редактирования и перешлите ей сообщение EM_SETSEL. В качестве параметров вы должны переслать начальную позицию курсора, и конечную позицию, определяющую конец выделения текста цветом. В приведенном примере курсор помещается во вторую позицию, текст внутри ячейки не выделяется.</p>
<pre>
procedure TForm1.Button1Click(Sender: TObject);
var
       h : THandle;
begin
       Application.ProcessMessages;
       DbGrid1.SetFocus;
       DbGrid1.EditorMode := true;
       Application.ProcessMessages;
       h:= Windows.GetFocus;
       SendMessage(h, EM_SETSEL, 2, 2);
end;
</pre>

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>

