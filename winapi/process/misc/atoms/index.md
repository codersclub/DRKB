---
Title: Атомы: запись, чтение и удаление информации
Author: Radmin
Date: 01.01.2007
Source: Vingrad.ru <https://forum.vingrad.ru>
---

Атомы: запись, чтение и удаление информации
===========================================

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
         if StrPos(p, PChar(Uniq))<>nil then GlobalDeleteAtom(i);
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
        if StrPos(p, PChar(Uniq))<>nil then break;
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

