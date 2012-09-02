<h1>Как поместить в буфер файл с помощью File Mapping?</h1>
<div class="date">01.01.2007</div>


<p>1.</p>
<p>В файлике Delphi5\Demos\Resxplor\exeimage.pas ищи слово CreateFileMapping</p>
<p>2.</p>
<p>идея простая открываешь файл .. (или создаешь)</p>
<p>создаешь Mapping ... CreateFileMapping</p>
<p>отображаешь Mapping в свой процесс MapViewOfFile</p>
<p>и всё</p>
<pre>
var
  SharedHandle: THandle;
  FileView: Pointer;
  MyFile: HFILE;
begin
  MyFile := OpenFile('c:\1.txt', // pointer to filename
    ..., // pointer to buffer for file information
    ... // action and attributes
    );
  SharedHandle := CreateFileMapping(MyFile, nil, PAGE_READWRITE, 0,
    size {размер файла}, PChar('MyFile'));
  FileView := MapViewOfFile(SharedHandle, FILE_MAP_WRITE, 0, 0, size {размер файла});
  ...
    ...
    ...
    ...
// потом
  UnmapViewOfFile(FileView);
</pre>

<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>

