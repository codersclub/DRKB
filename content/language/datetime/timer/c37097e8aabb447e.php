<h1>Скорость работы процессора, точный таймер</h1>
<div class="date">01.01.2007</div>


<p>Данная тема уже обсуждалась, но у меня есть своя реализация сабжа. Начиная с Pentium MMX, Intel ввели в процессор счетчик тактов на 64 бита (Присутствует точно и в К6). Для того чтобы посмотреть&nbsp; на его содержание, была введена команда "rdtsc" (подробное описание в интеловской мануале).&nbsp; Эту возможность можно использовать для реализации сабжа.</p>
<p>Поскольку Дельфи не в курсе насчет rdtsc, то пришлось юзать опкод (0F31).</p>
<p>Привожу простенький примерчик юзания, Вы уж извините - немножко кривоват получился,&nbsp; да и ошибка компилятора какая-то вылезла :( (V4 Bld5.104 Upd 2). Кому интересно, поделитесь своими соображениями по этому поводу. Особенно интересует работа в режиме когда меняется частота процессора (Duty Cycle, Standby).</p>

<pre>
// (C) 1999 ISV
unit Unit1;interfaceuses  Windows, Messages, SysUtils, Classes, Graphics,
 Controls, Forms,Dialogs,  StdCtrls, Buttons, ExtCtrls;
type  TForm1 = class(TForm)
    Label1: TLabel;
    Timer1: TTimer;
    Label2: TLabel;
    Label3: TLabel;
    Button1: TButton;
    Button2: TButton;
    Label4: TLabel;
    procedure Timer1Timer(Sender: TObject);
    procedure FormActivate(Sender: TObject);
    procedure Button1Click(Sender: TObject);
    procedure Button2Click(Sender: TObject);
  private    
{ Private declarations }
  public    
{ Public declarations }
    Counter:integer;
      //Счетчик срабатывания таймера    
Start:int64;              
//Начало роботы    
Previous:int64;        
//Предыдущее значение    
PStart,PStop:int64;
 //Для примера выч. времени   
 CurRate:integer;
     //Текущая частота проца    
function GetCPUClick:int64;    
function GetTime(Start,Stop:int64):double;
 end;
var  Form1: TForm1;implementation{$R *.DFM}
// Функция работает на пнях ММХ или выше а
// также проверялась на К6
function TForm1.GetCPUClick:int64;
begin
  asm    db  0fh,31h   
// Опкод для команды rdtsc    mov dword ptr result,eax    mov dword ptr result[4],edx  
end;
// Не смешно :(. Без ?той штуки
// Компайлер выдает Internal error C1079  
Result:=Result;
end;
// Время в секундах между старт и стоп
function TForm1.GetTime(Start,Stop:int64):double;
begin
  try    result:=(Stop-Start)/CurRate  except    result:=0;
 end;
end;
// Обработчик таймера считает текущую частоту, выводит ее, а также
// усредненную частоту, текущий такт с момента старта процессора.
// При постоянной частоте процессора желательно интервал братьпобольше
// 1-5с для точного прощета частоты процессора.
procedure TForm1.Timer1Timer(Sender: TObject);
  var    i:int64;
begin
  i:=GetCPUClick;
  if Counter=0    then Start:=i    else 
begin
      Label2.Caption:=Format('Частота общая:%2f',[(i-Start)/(Counter*Timer1.Interval*1000)]);
      Label3.Caption:=Format('Частота текущая:%2f',[(i-Previous)/(Timer1.Interval*1000)]);
      CurRate:=Round(((i-Previous)*1000)/(Timer1.Interval));
    end;
  Label1.Cap примера
procedure TForm1.Button1Click(Sender: TObject);
begin
  PStart:=GetCPUClick;
end;
// Останавливаем отсчет времени и показуем соко
// прошло секунд
procedure TForm1.Button2Click(Sender: TObject);
begin
  PStop:=GetCPUClick;
  Label4.Caption:=Format!
('Время между нажатиями:%gсек',[GetTime(PStart,PStop)])
end;
end.
</pre>

<p>Взято с сайта <a href="https://blackman.wp-club.net/" target="_blank">https://blackman.wp-club.net/</a></p>
