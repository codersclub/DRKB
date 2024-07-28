---
Title: Как узнать статус меню?
Author: Girder
Date: 01.01.2007
Source: Vingrad.ru <https://forum.vingrad.ru>
---


Как узнать статус меню?
=======================

> В чём вопрос: как узнать, нажат ли сейчас именно нужный пункт меню?
> Чтобы я в таймере мог его опрашивать на состояние.

До тех пор, пока какая-то часть главного меню "выпала" (то есть нажат
итем "Файл", и видны New, Open, Save etc.) нужно что-то делать раз в
полсекунды. То есть надо отловить момент, когда это самое меню
закроется, чтобы перестать что-то делать.

1) Событие OnClick - срабатывает на пункте, если мы по нему кликнули, или
если данный пункт имеет подменю (а точнее подпункты) и оно активировалось...
Как следствие - повесив обработчик на OnClick мы
можем узнать, что меню активировалось, и какое это меню, а также узнать
информацию о подменю (и при необходимости что-нибуть изменить).

2) Исходя из 1 пункта, мы знаем, что меню активно.
Но нам надо знать что меню закрылось.
Для этого ловим сообщение WM\_CAPTURECHANGED или
его не видно WM\_UNINITMENUPOPUP.

Пример для первого и второго пункта:

    unit Unit1;
     
    interface
     
    uses
     Windows, Messages, SysUtils, Variants, Classes, Graphics, Controls, Forms,
     Dialogs, ExtCtrls, Menus, StdCtrls, ComCtrls;
     
    type
     TForm1 = class(TForm)
       MainMenu1: TMainMenu;
       N1231: TMenuItem; //Какой то пункт
       N23551: TMenuItem; //Какой то пункт
       N1231231: TMenuItem; //Какой то пункт
       N1231111: TMenuItem; //Какой то пункт
       Timer1: TTimer; //Какой то пункт
       N2341: TMenuItem; //Какой то пункт
       N2342: TMenuItem; //Какой то пункт
       N234541: TMenuItem; //Какой то пункт
       N23421: TMenuItem; //Какой то пункт
       ertert1: TMenuItem; //Какой то пункт
       N1: TMenuItem; //Какой то пункт
       N123121: TMenuItem; //Какой то пункт
       N1231232: TMenuItem; //Какой то пункт
       N2343: TMenuItem; //Какой то пункт
       procedure Timer1Timer(Sender: TObject);
       procedure WndProc(var Message: TMessage); override;
       procedure N1231Click(Sender: TObject);
     private
       { Private declarations }
     public
       { Public declarations }
     end;
     
    var
     Form1: TForm1;
     f:boolean=false; //флаг активности
     
    implementation
     
    {$R *.dfm}
     
    procedure TForm1.WndProc(var Message: TMessage);
    begin
    if f then
     begin
      if (Message.Msg=WM_UNINITMENUPOPUP) then
       Caption:='Мдя... Че-то меня не видно! Но я активен!' else
       if (Message.Msg=WM_CAPTURECHANGED) then
        begin
         Caption:='Ёпс!... ты че вышел?';
         f:=false; //Сбрасываем флаг активности
        end else inherited;
     end else inherited;
    end;
     
    procedure TForm1.Timer1Timer(Sender: TObject);
    begin
     EndMenu; //закрываем меню
     Timer1.Enabled:=false;
    end;
     
    procedure TForm1.N1231Click(Sender: TObject);
    //Вешаем на все пункты меню :)
    begin
    Caption:=IntToStr(TMenuItem(Sender).MenuIndex);
    if (TMenuItem(Sender).Count>0) then
     begin
      if f=false then
       begin
        Timer1.Interval:=10000; //Ставим таймер для автоматического закрытия
        Timer1.Enabled:=true;
        Timer1.OnTimer:=Timer1Timer;
       end;
      f:=true; //меню активированно!
     end;
    end;
     
    end. 

