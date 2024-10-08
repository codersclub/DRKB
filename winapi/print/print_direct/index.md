---
Title: Печать текста в обход Windows
Date: 01.01.2007
Author: Steve
Source: Советы по Delphi от [Валентина Озерова](mailto:webmaster@webinspector.com) Сборник Kuliba
---

Печать текста в обход Windows
=============================

Откройте файл типа TextFile и пишите в него напрямую:

    var
      Lst: TextFile;
     
    begin
      AssignFile(Lst, 'LPT1');
      Rewrite(Lst);
      WriteLn(Lst, 'Здравствуй, мир!');
      Close(Lst);
    end.

При этом вы должны помнить, что при данной технологии вы не можете в это
же время печатать из другой программы, иначе наступит конец света, а
ваша распечатка будет похожа на "запутанный беспорядк".

Если вы планируете посылать на принтер управляющие коды, вызывайте
следующую функцию немедленно после перезаписи файла:

    procedure SetBinaryMode(var F: Text); assembler;
    asm
      mov ax,$4400
      les di,F
      mov bx,word ptr es:[di]
      int $21
      or dl,$20
      xor dh,dh
      mov ax,$4401
      int $21
    end;

