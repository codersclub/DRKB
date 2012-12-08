---
Title: Как явно вызвать виртуальный метод дедушки?
Date: 01.01.2007
---


Как явно вызвать виртуальный метод дедушки?
===========================================

::: {.date}
01.01.2007
:::

Проблема в следующем. Допустим, есть иерархия классов, у которых
перекрывается один и тот же виртуальный (или динамический - не важно)
метод и в одной из реализаций этого метода вы хотите вызвать виртуальный
метод предка своего предка. Новая объектная модель Delphi допускает
только вызов методов предка (с помощью ключевого слова inherited) либо
вызов методов класса с префиксом - типом класса (например,
TLevel1.ClassName).

Эта проблема стандартными средствами не решается. Но сделать требуемый
вызов можно. Причем способом, показанным ниже, можно вызвать любой метод
для любого класса, однако, в этом случае вся ответственность за
правильность работы с методами и полями ложится на программиста. Ниже в
методе VirtualFunction класса TLevel3 вызывается метод класса TLevel1, а
в функции Level1Always всегда вызывается метод класса TLevel1 для любого
его наследника.

     
    TLevel1 = class(TComponent)
            public
              function VirtualFunction: string; virtual;
            end;
     
            TLevel2 = class(TLevel1)
            public
              function VirtualFunction: string; override;
            end;
     
            TLevel3 = class(TLevel2)
            public
              function VirtualFunction: string; override;
            end;
     
            function Level1Always(MyLevel: TLevel1): string;
     
    implementation
     
            type
              PClass = ^TClass;
     
            function TLevel1.VirtualFunction: string;
            begin
              Result := 'Level1';
            end;
     
            function TLevel2.VirtualFunction: string;
            begin
              Result := inherited VirtualFunction+' Level2';
            end;
     
            function TLevel3.VirtualFunction: string;
            var
              ClassOld: TClass;
            begin
             ClassOld := PClass(Self)^;
              PClass(Self)^ := TLevel1;
              Result := VirtualFunction + ' Level3';
              PClass(Self)^ := ClassOld;
            end;
     
            function Level1Always(MyObject: TObject): string;
            var
              ClassOld: TClass;
            begin
              ClassOld := PClass(MyObject)^;
              PClass(MyObject)^ := TLevel1;
              Result := (MyObject as TLevel1).VirtualFunction;
              PClass(MyObject)^ := ClassOld;
            end;

Как же это работает? Стандартные так называемые объектные типы (object
types - class of \...) на самом деле представляют из себя указатель на
VMT (Virtual Method Table) - таблицу виртуальных методов, который
(указатель) лежит по смещению 0 в экземпляре класса. Воспользовавшись
этим, мы сначала сохраняем \'старый тип класса\' - указатель на VMT,
присваиваем ему указатель на VMT нужного класса, делаем вызов и
восстанавливаем все как было. Причем нигде не требуется, чтобы один из
этих классов был бы порожден от другого, т.е. функция Level1Always
вызовет требуемый метод вообще для любого экземпляра любого класса.

Если в функции Level1Always сделать попробовать вызов

    Result := MyObject.VirtualFunction;

то будет ошибка на стадии компиляции, так как у класса TObject нет
метода VirtualFunction. Другой вызов

    Result := (MyObject as TLevel3).VirtualFunction;

будет пропущен компилятором, но вызовет Run-time ошибку, даже если
передается экземпляр класса TLevel3 или один из его потомком, так как
информация о типе объекта меняется. Динамически распределяемые (dynamic)
методы можно вызывать точно таким же образом, т.к. информация о них тоже
хранится в VMT. Статические методы объектов вызываются гораздо более
простым способом, например

    var
              MyLevel3: TLevel3;
            ...
              (MyLevel3 as TLevel1).SomeMethode;

вызовет метод класса TLevel1 даже если у MyLevel3 есть свой такой же
метод.

Copyright © 1996 Epsylon Technologies

Взято из FAQ Epsylon Technologies (095)-913-5608; (095)-913-2934;
(095)-535-5349
