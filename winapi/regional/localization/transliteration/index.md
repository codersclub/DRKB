---
Title: Транслитерация
Author: NiJazz
Source: Vingrad.ru <https://forum.vingrad.ru>
Date: 01.01.2007
---

Транслитерация
==============

> Как сделать транслитерацию?  
> Например, молоко - moloko. И всё.

Вот пример функции, которая транслирует из русских слов в английские.

Пригодилась, когда нужно было файлы в mp3-плеер перегонять - он русский
не понимает.

    unit Translate;
     
    interface
     
    function Convert(OldName: string): string;
     
    implementation
     
    function Convert(OldName: string): string;
    var OldNameLength: integer;
       i: integer;
       s: string;
    begin
     OldNameLength := length(OldName);
     s:='';
     i:=1;
     while i <= OldNameLength do begin
      if (OldName[i] in ['A'..'Z']+['a'..'z']+['0'..'9']+
                        ['{']+['}']+['[']+[']']+['`']+['~']+
                        ['!']+['@']+['#']+['$']+['%']+['^']+
                        ['&']+['*']+['(']+[')']+['-']+['_']+
                        ['+']+['=']+['\']+['|']+[';']+[':']+
                        ['"']+['{']+['<']+['>']+[',']+['.']+
                        [' ']+['?']+['/']+['№']+['^'])
                     then
         s:=s+OldName[i];
      if OldName[i] in ['А','Б','а','б'] then
         s:=s+chr(ord(OldName[i])-127);
      if OldName[i] in ['В','в'] then
         s:=s+chr(ord(OldName[i])-108);
      if OldName[i] in ['Г','г','Ж','ж'] then
         s:=s+chr(ord(OldName[i])-124);
      if OldName[i] in ['Д','д','Е','е'] then
         s:=s+chr(ord(OldName[i])-128);
      if OldName[i] in ['З','з'] then
         s:=s+chr(ord(OldName[i])-109);
      if OldName[i] in ['И','и','К','к','Л','л','М','м','Н','н','О','о','П','п'] then
         s:=s+chr(ord(OldName[i])-127);
      if OldName[i] in ['Й','й'] then
         s:=s+chr(ord(OldName[i])-128);
      if OldName[i] in ['Р','р','С','с','Т','т','У','у'] then
         s:=s+chr(ord(OldName[i])-126);
      if OldName[i] in ['Ф','ф'] then
         s:=s+chr(ord(OldName[i])-142);
      if OldName[i] in ['Х','х'] then
         s:=s+chr(ord(OldName[i])-141);
      if OldName[i] in ['Ц','ц'] then
         s:=s+chr(ord(OldName[i])-147);
      if OldName[i] in ['Ы','ы'] then
         s:=s+chr(ord(OldName[i])-130);
      if OldName[i] in ['Э','э'] then
         s:=s+chr(ord(OldName[i])-152);
      if OldName[i] = 'Ё' then s:=s+'Yo';
      if OldName[i] = 'ё' then s:=s+'yo';
      if OldName[i] = 'Ч' then s:=s+'Ch';
      if OldName[i] = 'ч' then s:=s+'ch';
      if OldName[i] = 'Ш' then s:=s+'Sh';
      if OldName[i] = 'ш' then s:=s+'sh';
      if OldName[i] = 'Щ' then s:=s+'Sch';
      if OldName[i] = 'щ' then s:=s+'sch';
      if OldName[i] in ['Ъ','ъ','Ь','ь'] then s:=s+chr(39);
      if OldName[i] = 'Ю' then s:=s+'Yu';
      if OldName[i] = 'ю' then s:=s+'yu';
      if OldName[i] = 'Я' then s:=s+'Ya';
      if OldName[i] = 'я' then s:=s+'ya';
      i:=i+1;
     end;
     Convert:=s;
    end;
     
    end.
