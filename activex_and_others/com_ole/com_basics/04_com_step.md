---
Title: Еще шаг в направлении COM
Author: Fantasist
Date: 01.01.2007
---


Общие сведения о COM (статья)
-----------------------------

1. [Введение](./)
2. [Простой пример](02_simple_sample/)
3. [DLL!](03_dll/)
4. [Еще шаг в направлении COM](04_com_step/)
5. [Понятие интерфейса](05_interface/)
6. [Понятие интерфейса − 2](06_interface2/)
7. [Собираем тестовый пример](07_testsample/)
8. [Стандарт СОМ](08_com_standard/)
9. [Как система создает объект СОМ](09_com_create/)
10. [IClassFactory](10_iclassfactory/)

# Еще шаг в направлении COM

Сделаем еще шаг в направлении Component Object Module (COM).Даже сейчас
у экспортируется довольно много функций. Соответсвенно и в программе нам
надо сделать несколько ступений - создать переменную-указатель,
присвоить ей значение адреса нужной функции при помощи GetProcAddress, и
только потом вызвать саму функцию. Причем все эти функции у нас сами по
себе и никак не связанны с самим объектом, который мы используем. А
неплохо бы сделать так, чтобы можно было работать с ними как с объектом,
что нибудь типа:

    Сalc.SetOperands(13,10);
    i:=Calc.Sum;

Так давайте так и сделаем! Правда мы ограничены экспортом только
функций, но мы сделаем так:

Добавим в dll такую запись

    type
    ICalc=record
    SetOpers:procedure (x,y:integer);
    Sum:function:integer;
    Diff:function:integer;
    Release:procedure;
    end;
     

и процедуру:

    procedure GetInterface(var Calc:ICalc);
    begin
    CreateObject;
    Calc.Sum:=Sum;
    Calc.Diff:=Diff;
    Calc.SetOpers:=SetOperands;
    Calc.Release:=ReleaseObject;
    end;

и будем экспортировать только ее:

    exports
    GetInterface; 
     

Видете что происходит? Теперь вместо того, чтобы получать адрес каждой
функции, мы можем получить сразу всю таблицу адресов. Причем создание
объекта происходит в этой же функции, и пользователю больше не нужно
знать функцию CreateObject и не забыть ее вызвать.

Переделаем наш тестер.

В описание типов добавим:

    type
    ICalc=record
    SetOpers:procedure (x,y:integer);
    Sum:function:integer;
    Diff:function:integer;
    Release:procedure;
    end;

изменим секцию var.

    var
    Form1: TForm1;
    _Mod:Integer;
    GetInterface:procedure (var x:ICalc);
    Calc:ICalc;

и процедуры где мы используем наш объект.

    procedure TForm1.FormCreate(Sender: TObject);
    begin
    _Mod:=LoadLibrary('CalcDll.dll');
    GetInterface:=GetProcAddress(_Mod,'GetInterface');
    GetInterface(Calc);
    Calc.SetOpers(13,10);
    end;
    procedure TForm1.FormDestroy(Sender: TObject);
    begin
    Calc.Release;
    FreeLibrary(_Mod);
    end;
    procedure TForm1.Button1Click(Sender: TObject);
    begin
    ShowMessage(IntToStr(Calc.diff));
    end;
    procedure TForm1.Button2Click(Sender: TObject);
    begin
    ShowMessage(IntToStr(Calc.Sum));
    end;

Теперь со стороны может показаться, что мы пользуемся объектом, хотя на
самом деле это всего лиш таблица с указателями на функции.
