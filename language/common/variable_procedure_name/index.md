---
Title: Как использовать переменную для имени процедуры?
Date: 01.01.2007
Source: FAQ <https://blackman.km.ru/myfaq/cont4.phtml>
---


Как использовать переменную для имени процедуры?
================================================

Каким образом можно использовать переменную типа String в качестве имени
процедуры?

Если все процедуры, которые вы собираетесь вызывать, имеют список с
одними и теми же параметрами (или все без параметров), то это не трудно.
Для этого необходимы: процедурный тип, соответствующий вашей процедуре,
например:

    type
     
    TMacroProc = procedure(param: Integer); 
      //массив, сопоставляющий имена процедур их адресам
      //во время выполнения приложения: 
      TMacroName = string[32];
      TMacroLink = record
      name: TMacroName;
      proc: TMacroProc;
    end;
    TMacroList = array [1..MaxMacroIndex] of TMacroLink; 
     
    const
    Macros: TMacroList = (
      (name: 'Proc1'; proc: Proc1),
      (name: 'Proc2'; proc: Proc2),
      ...
    ); //интерпретатор функций, типа: 
     
    procedure CallMacro(name: String; param: Integer);
    var
      i: Integer;
    begin
      for i := 1 to MaxMacroIndex do
        if CompareText(name, Macros[i].name) = 0 then 
        begin
          Macros[i].proc(param);
          break;
        end;
    end; 
     
    {Макропроцедуры необходимо объявить в секции Interface модуля
     или с ключевым словом Far, например: }
    procedure Proc1(n: Integer); far;
    begin
      ...
    end; 
     
    procedure Proc2(n: Integer); far;
    begin
      ...
    end; 

