<h1>Атомы: запись, чтение и удаление информации</h1>
<div class="date">01.01.2007</div>


<pre>
{Act: 0 - Очистка атомов, 1 - чтение атомов, 2 - запись атомов}
{Uniq - Уникальный идентификатор}
{AtomNfo - Информация для записи}
Function AtomDo(Act:integer;Uniq,AtomNfo:string);
 Procedure CleanAtoms;
 var P:PChar;
  i:Word;
 begin
  GetMem(p, 256);
    For i:=0 to $FFFF do
    begin
      GlobalGetAtomName(i, p, 255);
     if StrPos(p, PChar(Uniq))&lt;&gt;nil then GlobalDeleteAtom(i);
    end;
   FreeMem(p);
 end;
 Function ReadAtom:string;
 var P:PChar;
  i:Word;
  begin
    GetMem(p, 256);
    For i:=0 to $FFFF do
   begin
    GlobalGetAtomName(i, p, 255);
    if StrPos(p, PChar(Uniq))&lt;&gt;nil then break;
   end;
      result:=StrPas(p+length(Uniq));
      FreeMem(p);
  end;
begin
  case Act of
  0 : CleanAtoms;
  1 : Result:=ReadAtom;
  2 : begin
      CleanAtoms;
      GlobalAddAtom(PChar(Uniq+AtomNfo));
      end;
end;
</pre>

<div class="author">Автор: Radmin</div>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
