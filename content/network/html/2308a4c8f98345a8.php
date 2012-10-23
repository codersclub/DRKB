<h1>GIF для HTML в EXE</h1>
<div class="date">01.01.2007</div>


<p>Есть программа на Delphi, котоpая отображает какой-то html. В html используется gif-файл. Как в Delphi-пpоекте указать, чтобы этот gif находился в exe как некий кусок кода. А когда надо будет, записать его обратно в gif-файл без изменений, выковырнув из exe?</p>
<p>Можно, используя RxLib. После его установки в меню View появится пунктик Project Resources. Hужно выбрать Project Resources-&gt;New-&gt;User Data и добавить нужный файл. В данном случае ресурс был назван "RCDATA_1".</p>
<p>Если RxLib нет, то нужно создать файл описания ресурсов:</p>
<pre>
=== Begin gifs.rc ===
mygif rcdata "имя_gif-файла.gif"
mygif1 rcdata "RCDATA_1"
=== End dots.rc ===
</pre>

<p>Потом скомпилировать его командой brcc32 gifs.rc и получить gifs.res В начало модуля добавь строчку {$R gifs.res}</p>
<p>В своей программе необходимо написать:</p>
<pre>
var
  rs: TResourceStream;
  a: Pointer;
begin
  rs := TResourceStream.Create(hinstance, 'RCDATA_1', RT_RCDATA);
  try
    GetMem(a, rs.size);
    rs.Read(a^, rs.size); {Теперь a - динамический указатель на код}
    { Здесь делается все, что необходимо с кодом, используя указатель a }
    FreeMem(a);
  finally
    rs.Free;
  end;
end;
</pre>

<p>А можно и так, если необходимо записать ресурс в файл:</p>
<pre>
var
  rs: TResourceStream;
  fs: TFileStream;
begin
  rs := TResourceStream.Create(hInstance, 'mygif', RT_RCDATA);
  fs := TFileStream.Create('имя_gif-файла.gif', fmCreate);
  try
    fs.CopyFrom(rs, rs.Size);
  finally
    fs.Free;
    rs.Free;
  end;
end;
</pre>


<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
