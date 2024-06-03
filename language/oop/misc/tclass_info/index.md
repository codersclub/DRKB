---
Title: Информация о TClass
Date: 01.01.2007
Source: Советы по Delphi от [Валентина Озерова](mailto:webmaster@webinspector.com) Сборник Kuliba
---


Информация о TClass
===================

TObject - "корневой" объект.

TClass определен как Class of TObject. Переменная Class НЕ является
указателем на экземпляр объекта. Это указатель на **ТИП** объекта Class.

    var
      Obj1: TWinControl;
      Class1: class of TWinControl;

`Class1 := TWinControl` - правильное присваивание. Мы не распределяем
память, у нас нет экземпляра TWinControl, мы не можем вызвать
Class1.OnClick.

Class1 - это **тип** TWinControl с тем же контекстом использования, что
и "TWinControl".

Поскольку мы можем использовать `TWinControl.Create`, то также мы можем
использовать и `Class1.Create`, при этом создавая новый экземпляр
TWinControl.

Поскольку TEdit - наследник TWinControl, то `Class1 := TEdit` - правильное
присваивание и `Class1.Create` создает экземпляр TEdit.

Если у меня имеется переменная `Obj2: TWinControl`, и даже если я присвоил
экземпляр `TListbox Obj2`, я не могу ссылаться на `Obj2.Items`, поскольку
`Obj2` определен как TWinControl, а TWinControl не имеет свойства Items.

Те же характеристики верны и для Class1. Class1 определен как
`Class of TWinControl`, поэтому они имеют общий конструктор, определенный в классе
TWinControl.

Это не пугает меня при создании дополнительных типов:

    TMyObj1 = class(TEdit)
      constructor CreateMagic; virtual;
    end;
     
    TMyObj2 = class(TMyObj1)
      constructor CreateMagic; override;
    end;
     
    TMyClass = class of TMyObj;
     
    var
      MyObj1: TMyObj1;
      MyObj2: TMyObj2;
     
    function MakeAnother(AClass: TMyClass): TMyObj1;
    begin
      Result := AClass.CreateMagic;
    end;
     
    begin
      MyObj2 := TMyObj2.CreateMagic;
      MyObj1 := MakeAnother(MyObj2.ClassType);
    end.

