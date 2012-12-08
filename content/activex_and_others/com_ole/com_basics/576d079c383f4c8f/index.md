---
Title: Понятие интерфейса - 2
Date: 01.01.2007
---


Понятие интерфейса - 2
=======================

::: {.date}
01.01.2007
:::

Давайте теперь вернем наш второй интерфейс. Теперь, когда таблица
интерфейсов создается компилятором, мы не можем эмулировать два
интерфейса простой заменой адресов функций. Теперь нам действительно
надо создать второй интерфейс. Хорошо, что интерфейсы можно наследовать:

     ICalc2=interface(ICalc)
       function Mult:integer;
       function Divide:integer;
     end;

Tак ICalc2 будет содержать в себе все методы ICalc. Нам Sum и Diff в
этом интерфейсе не нужны, так что давайте лучше напишем так:

      ICalcBase=interface //здесь нам GUID не нужен, так как с этим интерфейсом мы работать не собираемся.
        procedure SetOperands(x,y:integer);
        procedure Release;
      end;
     
      ICalc=interface(ICalcBase)
        ['{149D0FC0-43FE-11D6-A1F0-444553540000}']
        function Sum:integer;
        function Diff:integer;
      end;
     
      ICalc2=interface(ICalcBase)
        ['{D79C6DC0-44B9-11D6-A1F0-444553540000}']
        function Mult:integer;
        function Divide:integer;
      end;

Теперь добавим его в наш объект.

      MyCalc=class(TObject,ICalc,ICalc2)
         ...                     //без изменений
         function Divide:integer;   //это и
         function Mult:integer;  //это добавили
      end;

Опять возмемся за наш GetInterface. В принципе, мы могли бы оставить
выбор интерфейса как было у нас раньше - передаем в GetInterface целую
переменную и если она равна 1 то возвращаем ICalc, а если 2 то ICalc2.

Но уж коли мы связались с COM, то давайте будем, по возможнсти, к нему
приближаться. Сделаем полную аналогию GetInterface в TObject:

    function GetInterface(const IID: TGUID; var ACalc): Boolean;
    begin
     CreateObject;
     Result:=Сalc.GetInterface(IID,ACalc);
     if not Result then
      Calc.Free;  
    end;

Вуоля! Чуствуется, насколько теперь лучше, чем было вначале? Теперь если
запрашиваемый инерфейс нашим объектом не поддерживается, то во-первых,
мы даем клиенту об этом узнать, возвращая в Calc nil (
TObject.GetInterface это делает) и возвращая False из функции, а во-
вторых, мы сразу же освобождаем объект. Но на самом деле, то что
во-вторых, ничего хорошего нет, ибо мы подходим к следующей проблеме.

Функцию мы обозвали GetInterface, но она еще и объект создает! А если
пользователь захотел получить вначале ICalc, а потом ICalc2? Так как ему
известна лишь функция GetInterface, он может воспользоваться только ей и
получит два объекта, вместо двух интерфейсов одного объекта. Значит
нужно отделить функции создание объекта, от получение его интерфейса.
Давайте попробуем это сделать.

Первая попытка:

    ...
    var
      Calc:MyCalc; //без изменений
    ...
    ...
    procedure CreateObject;
    begin
     Calc:=MyCalc.Create;
    end;
     
    function GetInterface(const IID: TGUID; var ACalc): Boolean;
    begin
     Result:=Сalc.GetInterface(IID,ACalc);
    end;
     
    exports
     CreateObject, //добавили в экспорт 
     GetInterface;

Хм... Не работает, не правда ли? Если клиент сделает так:

    CreateObject;
    CreateObject;
    GetInterface(ICalc, Calc);

то он получит интерфес второго созданного объекта, тогда как первый
объект будет навсегда утерян. Что же надо сделать? Надо сделать так,
чтобы CreateObject возвращала бы чего-нибудь, чтобы мы могли
индифецировать объект, и получать имено его интерфейсы. Как я уже
сказал, клиент работает с COM объектом только через его интерфейсы,
значит логичнее всего при создании объекта вернуть интерфейс созданного
объекта(точнее, указатель на него). Для нашего случая, можно возвращать
указатель на ICalc, но можно облегчить жизнь ползователю, и попросить
его указать, какой интерфейс он хочет.

    procedure CreateObject(const IID: TGUID; var ACalc);
    var
     Сalc:MyCalc;
    begin
     Calc:=MyCalc.Create;
     if not Calc.GetInterface(IID,ACalc) then
      Calc.Free;
    end;

Здесь если интерфейса, который пользователь попросит нас нет, мы вернем
nil и удалим объект. Если интерфейс есть, то пользователь сам будет
удалять объект через метод Release. Неплохо, не правда ли?

Теперь глобальная переменная Calc нам не нужна - мы создаем много
обектов динамически.

Ну теперь совсем очевидно, что если ползователь захочет еще один
интерфейс этого объекта, то логичнее всего у этого объекта этот
интерфейс и поросить. Вот мы уже влотную подошли к имплементации
IUnknown - основного интерфейса в COM. Как я уже сказал, все объекты
должны имплементировать IUnknown, и все интерфейсы должны быть потомками
IUnknown(что Borland и сделал). Так что вы помните, что и оба наших
интерфейса ICalc и ICalc2 являются потомками IUnknown, а значит и первые
три метода, которые они содержат - это QueryInterface, AddRef, Release.
Помните, я предлагал вам оставить эти три метода пустыми? Давайте сейчас
имплементируем один из них - QueryInterface:

    function MyCalc.QueryInterface(const IID: TGUID; out Obj): HResult;
    begin
      if GetInterface(IID, Obj) then
        Result := S_OK;
      else
        Result := E_NOINTERFACE;
    end;

HResult это тоже, что и Longint, только его значение определятся
соглашением принятым в COM.