---
Title: Создание компонентов в Delphi
Author: Александр Василевский
Date: 01.01.2007
---


Создание компонентов в Delphi
=============================

::: {.date}
01.01.2007
:::

Перед созданием своего компонента нужно выбрать для него предка. Кто же
может быть предком для вашего компонента?  Как правило, используются в
виде предков TComponent, TControl, TWinControl, TGraphicControl,
TCustomXXXXXX, а также все компоненты палитры компонентов. Возьмем для
примера компонент TOpenDialog, который находится на странице Dialogs
палитры компонентов. Он хорошо справляется со своей задачей, но у него
есть одно маленькое неудобство. Каждый раз, когда его используешь
необходимо каждый раз изменять значение свойства Options. И причем это,
как правило, одни и те же действия.

    OpenDialog1.Options := OpenDialog1.Options + [ofFileMustExist, ofPathMustExist];

чтобы файл, который мы пытаемся открыть с помощью этого диалогового
окна, действительно существовал на диске.
Задание для себя мы уже выбрали, осталось за малым - создать компонент.
Заготовку для компонента создаем, выбирая из меню команду Component/New
Component... и в диалоговом окне выбираем
Ancestor type: TOpenDialog
Class Name: TOurOpenDialog
Palette Page: Our Test
Нажали Ok и у нас появился шаблон нашего будущего компонента.


Переопределяем конструктор у этого компонента, т.е. в секции public
вставляем строку:

    constructor Create(AOwner: TComponent); override;

нажатие на этой строке Ctrl + Shift + C создает шаблон для этого метода,
внутри которого мы вставляем такие строки:

 

    inherited Create(AOwner); {Вызываем унаследованный конструктор}
    Options := Options + [ofFileMustExist, ofPathMustExist]; {Выполняем необходимые нам действия}


Обратите внимание: Комбинации клавиш Ctrl + Shift + стрелки вверх/вниз
позволяют перемещаться между объявлением метода и его реализацией.

Установка созданного компонента Component/Install Component...
Install Into New Package
Package file name: C:\\Program
Files\\Borland\\Delphi4\\Lib\\OurTest.dpk
Package description: Our tested package

Вам не нравится, что у нашего компонента иконка такая же как у
стандартного? Тогда создадим для него свою собственную. Для этого нам
необходимо вызвать Tools/Image Editor. Создаем новый *.dcr файл.

Вставляем в него рисунок Resource/New/Bitmap. Устанавливаем размер
картинки 24x24 точек. А дальше - ваше творчество... Обратите внимание:
цвет точек, совпадающий с цветом точки в левом нижнем углу рисунка,
будет считаться ПРОЗРАЧНЫМ! После того как вы создали свой рисунок,
переименуйте его из Bitmap1 в TOurOpenDialog и сохраните файл с именем
OurOpenDialog.dcr. Удалите компонент из пакета и установите его снова
(только в этом случае добавится и ссылка на *.dcr файл). Compile,
Install и удачи!

    {======================================================}
    unit OurOpenDialog;

    interface

    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs;

    type
      TOurOpenDialog = class(TOpenDialog)
      private
        { Private declarations }
      protected
        { Protected declarations }
      public
        { Public declarations }
        constructor Create(AOwner: TComponent); override;
      published
        { Published declarations }
      end;

    procedure register;

    implementation

    procedure register;
    begin
      RegisterComponents('Samples', [TOurOpenDialog]);
    end;

    { TOurOpenDialog }

    constructor TOurOpenDialog.Create(AOwner: TComponent);
    begin
      inherited Create(AOwner); {Вызываем
    унаследованный конструктор}
      Options := Options + [ofFileMustExist, ofPathMustExist]; 
      {Выполняем необходимые нам действия}
    end;
    end.

Объявление компонента состоит из секций, таких как private, protected,
public и published. Что они означают?
Это директивы видимости. Все что объявлено в секции private, доступно
только внутри модуля в котором объявлен класс (приватные объявления).
Здесь как правило объявляются переменные, в которых хранятся значения
свойств, а также методы (процедуры или функции) доступа к ним. Все что
объявлено в секции protected, доступно как и в секции private, а также
наследникам данного класса (интерфейс разработчика). Здесь можно
объявить методы доступа к значениям свойств (если вы хотите позволить
изменять эти методы потомкам вашего компенента),
а также свойства, методы и события (методы реакции на события) в
компонентах типа TCustomXXX.
Все что объявлено в секции public, доступно любому пользователю
компонента (интерфейс этапа выполнения).

Здесь объявляются, как правило методы. В секции published можно
объявлять только свойства и события (они объявляются в виде свойств).
Они доступны во время проектирования приложения (интерфейс этапа
проектирования).

 

Свойства

Свойства типа масив - обычные массива Object Pascal, но в отличии от
последних могут индексироваться не только числовыми значениями но и
строковыми. К сожалению этот тип свойства требует пользовательского
редактора свойств (в инспекторе объектов редактор свойства имеет кнопку
с тремя точками [...], по-этому в указанном ниже примере свойство
ArrayProp объявлено в секции public.

    type
      TOurComponent = class(TComponent)
      private
        { Private declarations }
        FArrayProp: array[0..9] of integer;
        function GetArrayProp(aIndex: integer): integer;
        procedure SetArrayProp(aIndex: integer; const
    Value: integer);
      protected
        { Protected declarations }
      public
        { Public declarations }
        property ArrayProp[aIndex: integer]: integer read
    GetArrayProp 
        write SetArrayProp;
      published
        { Published declarations }
      end;

Спецификаторы свойств

Спецификатор default указывает сохранять значение свойства в файле формы
или нет. Если значение свойства совпадает со значением default -
значение в файле формы не сохраняется, если значения не равны -
сохраняется. Это можно проверить, положив компонент на форму и выбрать
правой кнопкой мыши пункт меню "View as Text". Default не
устанавливает первоначальное значение свойства к указанному. Это
необходимо сделать в конструкторе компонента.

    unit OurComponent;
     
    interface
     
    uses Windows, SysUtils, Classes, Graphics, Forms, Controls;
     
    type
      TOurComponent = class(TComponent)
      private
        { Private declarations }
        FMyInteger: Integer;
      protected
        { Protected declarations }
      public
        { Public declarations }
        constructor Create(AOwner: TComponent); override;
      published
        { Published declarations }
        property MyInteger: Integer read FMyInteger
    write FMyInteger default 10;
      end;
     
    implementation
     
    constructor TOurComponent.Create(AOwner: TComponent);
    begin
      inherited Create(AOwner);
      FInteger := 10;
    end;
     
    end.

Спецификатор nodefault отменяет заданное по умолчанию значение свойства.
Этот спецификатор, как правило, используется для отмены заданого по
умолчанию значения унаследованного свойства.



Например:

     property AutoSize nodefault;

Спецификатор stored указывает когда сохранять в файле формы значение
свойства. После stored может стоять true (всегда сохранять), false
(никогда не сохранять) или название функции, которая возвращает
логический результат.

    property OneProp: integer read FOneProp
    write
    SetOneProp 
    stored False;
        property TwoProp: integer read FTwoProp
    write
    SetTwoProp 
    stored True;
        property ThreeProp: integer read FThreeProp
    write SetThreeProp 
    stored Fuct;

Дата: 12.02.2004

Автор: Александр Василевский

Источник: <https://alvas.hypermart.net/>
