<h1>Устанавливаем дату создания файла</h1>
<div class="date">01.01.2007</div>

<pre>
function SetFileDate(
  Const FileName : String;
  Const FileDate : TDateTime): Boolean;
var
 FileHandle        : THandle;
 FileSetDateResult : Integer;
begin
 try
  try
   FileHandle := FileOpen
      (FileName,
       fmOpenWrite OR fmShareDenyNone);
   if FileHandle &gt; 0 Then  begin
    FileSetDateResult :=
      FileSetDate(
        FileHandle,
        DateTimeToFileDate(FileDate));
      result := (FileSetDateResult = 0);
    end;
  except
   Result := False;
  end;
 finally
  FileClose (FileHandle);
 end;
end;
 
{Использование:}
SetFileDate('c:\mydir\myfile.ext', Now)
 
</pre>

<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
<hr />
<pre>
var
  f: file;
begin
  Assign(f, DirInfo.Name);
  Reset(f);
  SetFTime(f, Time);
  Close(f);
end;
 
</pre>

<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
<hr />
<p>Функция, которая устанавливает дату одного файла, равную дате другого файла </p>
<pre>
procedure CopyFileDate(const Source, Dest: String);
var
  SourceHand, DestHand: word;
begin
  SourceHand := FileOpen(Source, fmOutput);       { открываем исходный файл }
  DestHand := FileOpen(Dest, fmInput);            { открываем целевой файл }
  FileSetDate(DestHand, FileGetDate(SourceHand)); { получаем/устанавливаем дату }
  FileClose(SourceHand);                          { закрываем исходный файл }
  FileClose(DestHand);                            { закрываем целевой файл }
end; 
</pre>

<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
