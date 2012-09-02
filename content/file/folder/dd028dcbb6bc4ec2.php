<h1>Проход дерева каталогов</h1>
<div class="date">01.01.2007</div>


<pre><p>Procedure ScanDir(Dir:string);</p>
var SearchRec:TSearchRec;
begin
if Dir&lt;&gt;'' then if Dir[length(Dir)]&lt;&gt;'\' then Dir:=Dir+'\';
if FindFirst(Dir+'*.*', faAnyFile, SearchRec)=0 then
repeat
if (SearchRec.name='.') or (SearchRec.name='..') then continue;
if (SearchRec.Attr and faDirectory)&lt;&gt;0 then
ScanDir(Dir+SearchRec.name) //we found Directory: "Dir+SearchRec.name"
else
Showmessage(Dir+SearchRec.name); //we found File: "Dir+SearchRec.name"
until FindNext(SearchRec)&lt;&gt;0;
FindClose(SearchRec);
end;
procedure TForm1.Button1Click(Sender: TObject);
begin
ScanDir('c:');
end;
</pre>
<p class="author">Автор: Vit</p>
<p>Ненамного сложнее, но возможностей поболе будет.</p>
<pre>
procedure ScanDir (Path:string;SearchMask:TStrings;ScanSub:boolean);
var
SearchRec:TSearchrec;
a,i:integer;
begin
if ScanSub then
begin
FindFirst(path+'\*.*',faDirectory,SearchRec);{. found}
FindNext(SearchRec); {.. found}
a:=FindNext(SearchRec);
while a=0 do
begin
if (SearchRec.Attr and faDirectory)&gt;0 then 
 
ScanDir(Path+'\'+SearchRec.Name,SearchMask,ScanSub);
a:=FindNext(SearchRec);
end;{while}
FindClose(SearchRec);
end;{if}
 
for i:=0 to SearchMask.Count-1 do
begin
a:=FindFirst(Path+'\'+SearchMask[i],faAnyFile,SearchRec);
while a=0 do
begin
{operation on file}
a:=FindNext(SearchRec);
end;{while}
FindClose(SearchRec);
end;{for}
 
end; {ScanDir}
</pre>
<p class="author">Автор December</p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
