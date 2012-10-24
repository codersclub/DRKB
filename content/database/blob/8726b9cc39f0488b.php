<h1>Извлечение текста из TMemoField</h1>
<div class="date">01.01.2007</div>

<div class="author">Автор: Steve Schafer</div>

<pre>
var
  P: PChar;
  S: TMemoryStream;
  Size: LongInt;
begin
  S := TMemoryStream.Create;
  MyMemoField.SaveToStream(S);
  Size := S.Position;
  GetMem(P, Size + 1);
  S.Position := 0;
  S.Read(P^, Size);
  P[Size] := #0;
  S.Free;
  { используем текст в PChar }
  FreeMem(P, Size + 1);
end;
</pre>

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
