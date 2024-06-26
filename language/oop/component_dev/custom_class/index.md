---
Title: Как написать собственный класс?
Author: Vit
Date: 01.01.2007
Source: Vingrad.ru <https://forum.vingrad.ru>
---


Как написать собственный класс?
===============================

Вот пример написания класса. Этот класс вычисляет сумму квадратов
введенных чисел. Этот класс написан мной только для примера, и я исходил
из соображений наглядности, а не оптимальности. Большая часть реализации
не только не оптимальна, но и бессмысленна, но показывает большую часть
простейших приемов создания класса.

    unit Unit2;
     
    interface
     
    Uses classes, Sysutils;
     
    {Нам нужен процедурный тип для создания собственного события.
     Собственно - это описание процедуры которая должна будет исполнятся
     при каких-нибудь обстоятельствах}
     
    Type
      TError = procedure(Sender:TObject; Error: string) of object;
     
    {Описание нашего класса, мы его наследуем от TObject,
     потому что нам практически не нужна
     никакия функциональность предков}
    Type TStatistic=Class(TObject)
    private {здесь описываются только внутренние переменные и процедуры - "для служебного пользования"}
    {Описание полей, т.е. переменных которые работают только внутри класса,
     "снаружи" они недоступны.}
    FList:TStringList;
    FPrecision: byte;
    {Тоже переменная - для определения события}
    FonError: TError;
    {функция - будет использоваться только внутри класса, "снаружи" напрямую не доступна}
    function GetCount: integer;
    public {Описанное здесь доступно для пользователя класса}
    {Конструктор - метод создания класса, имеет смысл его описывать только если он делает
    что-то специфическое - например нам надо будет создать переменную FList. В противном случае
    его описание можно опустить - будет работать конструктор родительского класса}
    Constructor Create;
    {Деструктор - метод разрушения класса}
    Destructor Destroy; override;
    {Описание методов - собственно методы мало чем отличаются от процедур}
    Procedure AddValue(Value:String);
    Procedure Clear;
    Function Solve:real;
    {Описание свойств. Обратите внимание само свойство не способно хранить никакую информацию, это
    только указатель на внутренюю струкруру. Например для хранения свойства Precision используется
    переменная FPrecision. А для чтения свойства Count используется функция GetCount}
    Property Precision:byte read FPrecision write FPrecision;
    Property Count:integer read GetCount;
    {Описание событий. Что такое событие? - Это указатель на процедуру.
     Сам класс реализации этой процедуры не знает.
     Классу известно только заголовок процедуры,
     вы в коде программы будете писать реализацию процедуры,
     а класс только в нужный момент передаст ей управление,
     используя указатель onError}
    Property onError:TError read FonError write FonError;
    end;
     
    implementation
     
    { TStatistic }
     
    constructor TStatistic.Create;
    begin
    inherited; {Вначале надо вызвать конструктор класса-родителя}
    FList:=TStringList.create;{создаем структуры нашего класса}
    end;
     
    destructor TStatistic.Destroy;
    begin
    FList.Free;{Разрушаем структуры нашего класса}
    inherited;{в последнюю очередь вызываем деструктор клсса-родителя}
    end;
     
    procedure TStatistic.AddValue(Value: String);
    begin
      FList.add(Value); {Примерно так мы реализуем метод}
    end;
     
    procedure TStatistic.Clear;
    begin
      FList.clear;
    end;
     
    function TStatistic.GetCount: integer;
    begin
      Result:=FList.count+1;
    end;
     
    function TStatistic.Solve: real;
      var i:integer;
    begin
    result:=0;
    for i:=0 to FList.count-1 do
    begin
    try
      result:=result+(Sqr(strtofloat(FList[i])));
    except
    {интересная конструкция. "on e:exception do" - мы "отлавливаем" ошибку как переменную "e".
    Эта переменная имеет очень полезное свойство e.message - оно содержит описание ошибки. Далее
    следует вызов события. Вначале мы проверяем использует ли пользователь событие:
    "if Assigned(FOnError) then", если использует то вызываем его процедуру: FOnError, с параметрами:
    self - зарезервированная переменная - указатель на экземпляр нашего класса, e.message - описание
    ошибки}
    on e:exception do 
    if Assigned(FOnError) then FOnError(Self, e.message);
    end;
    end;
    end;
     
    end.
     
Вот пример использования этого класса:

    unit Unit1;
     
    interface
     
    uses Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
    StdCtrls;
     
    type
    TForm1 = class(TForm)
    Button1: TButton;
    procedure Button1Click(Sender: TObject);
    private
    procedure OnError(Sender:TObject; Error: string);
    public
    { Public declarations }
    end;
     
    var
    Form1: TForm1;
     
    implementation
     
    uses Unit2;
     
    {$R *.DFM}
     
    procedure TForm1.Button1Click(Sender: TObject);
      var Statistic:TStatistic;
    begin
    Statistic:=TStatistic.create;
    Statistic.onError:=onError;
    Statistic.AddValue('123423');
    Statistic.AddValue('123423');
    showmessage(floattostr(Statistic.solve));
    Statistic.Clear;
    Statistic.AddValue('123423');
    Statistic.AddValue('12ssss3');
    showmessage(floattostr(Statistic.solve));
    Statistic.Free;
    end;
     
    procedure TForm1.OnError(Sender: TObject; Error: string);
    begin
    showmessage('Error inside class:'+Sender.ClassName+#13#10+Error);
    end;
     
    end.

