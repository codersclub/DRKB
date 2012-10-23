<h1>Cколько файлов есть в определенной папке?</h1>
<div class="date">01.01.2007</div>


<p>Как наиболее быстрым способом узнать, сколько файлов с определенным расширением есть в определенной папке?</p>
<p>Например для HTM файлов:</p>
<pre>
Function GetFileCount(Dir:string):integer;
 

 
var fs:TSearchRec;
begin
  Result:=0;
  if FindFirst(Dir+'\*.htm',faAnyFile-faDirectory-faVolumeID, fs)=0 then
    repeat
      inc(Result);
    until FindNext(fs)&lt;&gt;0;
  FindClose(fs);
end;
</pre>

<div class="author">Автор: Vit</div>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>

