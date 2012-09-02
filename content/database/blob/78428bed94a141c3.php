<h1>Как определить реальный размер поля типа BLOB, которое сохранено в таблице?</h1>
<div class="date">01.01.2007</div>


<p>Ниже приведена функция GetBlobSize, которая возвращает размер данного BLOB или MEMO поля.</p>

<p>Пример вызова:</p>

<pre>
function GetBlobSize(Field: TBlobField): Longint;
begin
  with TBlobStream.Create(Field, bmRead) do
  try
    Result := Seek(0, 2);
  finally
    Free;
  end;
end;
 
procedure TForm1.Button1Click(Sender: TObject);
begin
 { This sets the Edit1 edit box to display the size of }
 { a memo field named Notes.                           }
 
  Edit1.Text := IntToStr(GetBlobSize(Notes));
end;
</pre>


<p>Copyright © 1996 Epsylon Technologies</p>
<p>Взято из FAQ Epsylon Technologies (095)-913-5608; (095)-913-2934; (095)-535-5349</p>
