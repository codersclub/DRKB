---
Title: Как присвоить событие в runtime?
Author: Vit
Date: 01.01.2007
---


Как присвоить событие в runtime?
================================

::: {.date}
01.01.2007
:::

Пример стандартного присвоения события в run-time:

    type

     
      TForm1 = class(TForm)
        Button1: TButton;
        procedure FormCreate(Sender: TObject);
      private
        procedure Click(Sender: TObject);
      end;
     
    var  Form1: TForm1;
     
    implementation
     
    procedure TForm1.Click(Sender: TObject);
    begin
      // do something
    end;
     
    procedure TForm1.FormCreate(Sender: TObject);
    begin
      button1.OnClick:=Click;
    end;
     
    end.

Автор: Vit

Взято с Vingrad.ru <https://forum.vingrad.ru>

------------------------------------------------------------------------

А как сделать чтобы "procedure Click" была не методом класса, а
отдельно стоящей функцией?


     
    procedure Click(Self: TObject; Sender: TObject);
    begin
      ...
    end;
     
    var
      evhandler: TNotifyEvent;
      TMethod(evhandler).Code := @Click;
      TMethod(evhandler).Data := nil;
      Button1.OnClick := evhandler;
     
      Без извращений можно так:
     
      TDummy = class
        class procedure Click(Sender: TObject);
      end;
     
      Button1.OnClick := TDummy.Click;

Автор: Le Taon

Взято с Vingrad.ru <https://forum.vingrad.ru>

------------------------------------------------------------------------

По идее, при вызове OnClick первым параметром будет запихнут указатель
на экземпляр того класса который в этом OnClick хранится . Я в
низкоуровневой реализации не силен, но кажись, так как параметры в
процедурах в Delphi передаются через регистры, то ничего страшного не
произойдет.


    procedure C(Self:pointer;Sender:TObject);
    begin
      TButton(Sender).Caption:='ee';
    end;
     
    procedure TForm1.FormCreate(Sender: TObject);
    begin
      @Button1.OnClick:=@c;
    end;

Self тут у нас будет равен nil, а Sender как раз и получается
Sender\'ом.

Автор: Fantasist

Взято с Vingrad.ru <https://forum.vingrad.ru>
