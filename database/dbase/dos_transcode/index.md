---
Title: При использовании DOS DBF файлов - перекодировка между форматами
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


При использовании DOS DBF файлов - перекодировка между форматами
=================================================================

При использовании DOS DBF файлов можно сделать небольшую программку (или
процедурку), которая произведет перекодировку между форматами. что-то
типа:

    function update_dos(s:string):string;
    var c:STRING;
        I:INTEGeR;
        l:byte;
        dd:char;
    begin
     i:=1;
     c:='';
     while i< length(s)+1 do
     begin
       l:=ord(s[i]);
       inc(i);
       if (l>=128) and (l<=192)then l:=l+64 else
       if (l>=224) and (l<240) then l:=l+16 else
       if l=241 then l:=184 else
       if l=240 then l:=168;
       dd:=chr(l);
       c:=c+dd;
     end;
    update_dos:=c;
    end;
     
    function update_win(s:string):string;
    var c:STRING;
        I:INTEGeR;
        l:byte;
        dd:char;
    begin
     i:=1;
     c:='';
     while i< length(s)+1 do
     begin
       l:=ord(s[i]);
       inc(i);
       if (l>=192) and (l<240)then l:=l-64 else
       if (l>=240) and (l<256) then l:=l-16 else
       if l=184 then l:=241 else    
       if l=168 then l:=240;
       dd:=chr(l);
       c:=c+dd;
     end;
    update_win:=c;
    end;

это и туда и обратно, у меня работает на старых DBF. Осталось только
вызвать в нужный момент.

