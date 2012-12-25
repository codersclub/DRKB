---
Title: Удаление ненужных подстрок из строки
Author: Vit
Date: 01.01.2007
---


Удаление ненужных подстрок из строки
====================================

::: {.date}
01.01.2007
:::

    procedure RemoveInvalid(what, where: string): string;
    // what - удаляемая подстрока, where - обрабатываемая строка
    var
      tstr: string;
    begin
      tstr:=where;
      while pos(what, tstr)>0 do
        tstr:=copy(tstr,1,pos(what,tstr)-1) +
      copy(tstr,pos(what,tstr)+length(tstr),length(tstr));
      Result:=tstr;
    end; 
     
     
     
     
    //Применение: 
     
     
     
    NewStr:=RemoveInvalid('<брак>','Этот <брак> в моей строке, и я хочу
    удалить из нее этот <брак>');

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

 

------------------------------------------------------------------------

Используйте стандартную функцию Pascal DELETE\...

Пользуясь тем же примером, вы можете сделать так\....

    Target:='<брак>';
    While POS(Target,string)>0 do
    begin
      P := POS(Target,string);
      DELETE(string,P,Length(Target));
    end;

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

 

------------------------------------------------------------------------

Всё даже проще:


    Result:=StringReplace(ИсходнаяСтрока,ТоЧтоНадоУдалить,'',[rfReplaceAll])

Автор: Vit
