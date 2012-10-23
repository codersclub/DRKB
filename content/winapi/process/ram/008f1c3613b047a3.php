<h1>Сохранить строку в памяти + пример работы с атомами</h1>
<div class="date">01.01.2007</div>


<p>Например через атомы:</p>
<p>К счастью количество атомов ограничено 0xFFFF, так что простые функции перебора работают достаточно быстро. Вот пример как сохранять и читать значение через атомы:</p>
<pre>
const UniqueSignature='GI7324hjbHGHJKdhgn90jshUH*hjsjshjdj';

 
Procedure CleanAtoms;
var P:PChar;
  i:Word;
begin
GetMem(p, 256);
For i:=0 to $FFFF do
begin
  GlobalGetAtomName(i, p, 255);
  if StrPos(p, PChar(UniqueSignature))&lt;&gt;nil then GlobalDeleteAtom(i);
end;
FreeMem(p);
end;
 
Procedure WriteAtom(Str:string);
begin
CleanAtoms;
GlobalAddAtom(PChar(UniqueSignature+Str));
end;
 
Function ReadAtom:string;
var P:PChar;
  i:Word;
begin
GetMem(p, 256);
For i:=0 to $FFFF do
begin
GlobalGetAtomName(i, p, 255);
if StrPos(p, PChar(UniqueSignature))&lt;&gt;nil then break;
end;
result:=StrPas(p+length(UniqueSignature));
FreeMem(p);
end;
 
procedure TReadFromAtom.Button1Click(Sender: TObject);
begin
WriteAtom(Edit1.text);
end;
 
procedure TReadFromAtom.Button2Click(Sender: TObject);
begin
Showmessage(ReadAtom);
end;
 
</pre>
<p class="note">Примечание</p>
<p>Константа "UniqueSignature" должна быть достаточно длинной, чтобы однозначно идентифицировать атом, в тоже время длина хранимой строки вместе с UniqueSignature не должна превышать 255 символов. Данная конструкция может хранить только 1 значение. Для хранения нескольких значений надо назначить несколько разных UniqueSignature и использовать сходные процедуры.</p>
<div class="author">Автор: Vit</div>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
