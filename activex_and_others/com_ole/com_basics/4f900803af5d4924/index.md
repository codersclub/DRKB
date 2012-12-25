---
Title: DLL!
Date: 01.01.2007
---


DLL!
====

::: {.date}
01.01.2007
:::

Ура. До нас и за нас все уже стандатизировали. Давайте этим
воспользуемся и напишем теперь наш модуль в по стандарту. Напишем dll.

    library CalcDll;
    uses SysUtils, Classes;
    type
      MyCalc=class
      fx,fy:integer;
    public
      procedure SetOperands(x,y:integer);
      function Sum:integer;
      function Diff:integer;
    end;
    var Calc:MyCalc;
    procedure MyCalc.SetOperands(x,y:integer);
    begin
      fx:=x; fy:=y;
    end;
    function MyCalc.Sum:integer;
    begin
      result:=fx+fy;
    end;
    function MyCalc.Diff:integer;
    begin
      result:=fx-fy;
    end;
    procedure SetOperands(x,y:integer);
    begin
      Calc.SetOperands(x,y);
    end;
    function Sum:integer;
    begin
      result:=Calc.Sum;
    end;
    function Diff:integer;
    begin
      result:=Calc.Diff;
    end;
    procedure CreateObject;
    begin
      Calc:=MyCalc.Create;
    end;
    procedure ReleaseObject;
    begin
      Calc.Free;
    end;
    exports //Вот эта секция и указывает компилятору что записать в таблицу экспорта
      SetOperands,
      Sum,
      Diff,
      CreateObject,
      ReleaseObject;
    begin
    end.

Напишем программку - протестировать наш модуль.

    unit tstcl;
    interface
    uses Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs, StdCtrls;
    type
      TForm1 = class(TForm)
      Button1: TButton;
      Button2: TButton;
      procedure FormCreate(Sender: TObject);
      procedure FormDestroy(Sender: TObject);
      procedure Button1Click(Sender: TObject);
      procedure Button2Click(Sender: TObject);
    end;
    var Form1: TForm1;
      _Mod:Integer; //индефикатор модуля
      SetOpers:procedure(x,y:integer); //Это все указатели на функции,
      diff,sum:function:integer; //которые мы собираемся получить
      CreateObj,ReleaseObj:procedure; //из нашего модуля
    implementation
    {$R *.DFM}
    procedure TForm1.FormCreate(Sender: TObject);
    begin
      //загружаем наш модуль в память
      _Mod:=LoadLibrary('CalcDll.dll'); 
     
      //получаем адреса функций по именам 
      CreateObj:=GetProcAddress(_Mod,'CreateObject');
      ReleaseObj:=GetProcAddress(_Mod,'ReleaseObject');
      sum:=GetProcAddress(_Mod,'Sum');
      diff:=GetProcAddress(_Mod,'Diff');
      SetOpers:=GetProcAddress(_Mod,'SetOperands');
       
      CreateObj; //вызываем функцию по адресу
      SetOpers(13,10); //вызываем функцию по адресу
    end;
    procedure TForm1.FormDestroy(Sender: TObject);
    begin
      ReleaseObj; //опять вызываем функцию по адресу
      FreeLibrary(_Mod); //выгружаем модуль из памяти
    end;
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      ShowMessage(IntToStr(diff)); //вычисляем разницу
    end;
    procedure TForm1.Button2Click(Sender: TObject);
    begin
      ShowMessage(IntToStr(sum)); //вычисляем сумму
    end;
    end.

Классно! Теперь каждый программирующий в системе Windows на любом языке
может использовать наш калькулятор! Что? Разочарованны? Такое ощущение
что COM тут и не пахнет?

Правильно, ибо про СОМ я пока ничего и не сказал, но...

Продолжение следует!
