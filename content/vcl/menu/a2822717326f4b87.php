<h1>Как узнать статус меню?</h1>
<div class="date">01.01.2007</div>


<p>В чём вопрос: как узнать, нажат ли сейчас именно нужный пункт меню? Чтобы я в таймере мог его опрашивать на состояние.</p>
<p>До тех пор, пока какая-то часть главного меню "выпала" (то есть нажат итем "Файл", и видны New, Open, Save etc.) нужно чёто делать раз в полсекунды. То есть надо отловить момент, когда это самое меню закроется, чтобы перестать чё-то делать.</p>

<p>1)Событие OnClick - срабатывает на пункте если мы по нему кликнули или если данный пункт имеет подменю(а точнее подпункты) и оно активировалось... как следствие - повесив обработчик на OnClick мы можем узнать что меню активировалось и какое енто меню, а также узнать информацию о подменю(и при необходимости что нить изменить&nbsp; ).</p>

<p>2)Из ходя из 1 пункта мы знаем что меню... активно. Но нам надо знать что меню закрылось... для ентого ловим сообщение WM_CAPTURECHANGED или его не видно WM_UNINITMENUPOPUP.</p>

<p>Пример для первого и второго пункта:</p>
<pre>
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
if (TMenuItem(Sender).Count&gt;0) then
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
</pre>


<div class="author">Автор: Girder</div>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>

