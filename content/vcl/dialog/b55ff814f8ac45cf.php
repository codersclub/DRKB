<h1>Правильные диалоги от Борланда</h1>
<div class="date">01.01.2007</div>

Если покопаться в фирменных "Дельфовых" примерах, можно найти ГОРАЗДО более удачную конструкцию (которую, кстати, я уже давно использую).</p>
<p>Еще раз подчеркну - это не моя придумка, а ребят из Борланда.</p>
<p>Эта конструкция позволяет:</p>
<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>Возвращать ЛЮБЫЕ значения;</td></tr></table></div>
<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>ДИНАМИЧЕСКИ создавать форму;</td></tr></table></div>
<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>Еще куча всяких "бонусов", просто лень описывать :-)</td></tr></table></div>
<p>Итак, смотрим исходники...<br>
 <br>
В этом примере я привел два наиболее типичных случая. 1-й - InputString - просто ввод, без анализа отмены, второй - MrInputString - с анализом отмены ввода (ModalResult). <br>
 <br>
Оба случая используют начальные значения. Без них - Еще проще... <br>
В принципе - ваша фантазия ничем не ограничивается. Я, например, храню последние вводившиеся значения в реестре и читаю их оттуда после создания формы. Удобно. <br>
 <br>
<p>Пользователь не мается вводя по 10 раз одно и то же, а у меня не болит голова с инициализацией полей (есть специальный класс, который этим занимается, но это отдельная тема...)</p>
<p>ИСХОДНИКИ:</p>
<pre>
//**************************************************************
//Основной модуль Обратите Внимание!  "uses Dialog;"
 
implementation
 
{$R *.dfm}
uses
  Dialog;
 
procedure TForm1.BitBtn1Click(Sender: TObject);
begin
  ShowMessage('Вы ввели '+InputString('Начальное значение'));
end;
 
procedure TForm1.BitBtn2Click(Sender: TObject);
Var
  Str: String;
begin
  Str:='Начальное значение';
  If MrInputString(Str) = mrOk Then
    ShowMessage('Вы ввели '+Str)
  Else
    ShowMessage('Вы отменили ввод');
end;
 
//********************************************************
//Модуль диалога
unit Dialog;
 
interface
 
uses
  Windows, Messages, SysUtils, Variants, Classes, Graphics, Controls, Forms,
  Dialogs, StdCtrls, ExtCtrls, Buttons;
 
type
  TOptionsDlg = class(TForm)
    Bevel1: TBevel;
    BitBtn1: TBitBtn;
    BitBtn2: TBitBtn;
    Edit1: TEdit;
    Label1: TLabel;
    Bevel2: TBevel;
    Label3: TLabel;
    procedure FormKeyDown(Sender: TObject; var Key: Word;
      Shift: TShiftState);
  private
    { Private declarations }
  public
    { Public declarations }
  end;
 
var
  OptionsDlg: TOptionsDlg;
 
function InputString(BeginVal: String): String;
function MrInputString(Var Str: String): TModalResult;
 
implementation
 
{$R *.dfm}
 
function InputString(BeginVal: String): String;
begin
  With TOptionsDlg.Create(Application.MainForm) do
    Try
      Edit1.Text:=BeginVal;
      If ShowModal = mrOk Then
        Result:=Edit1.Text
      Else
        Result:='"Отмена"';
    Finally
      Free;
    End;
end;
 
function MrInputString(Var Str: String): TModalResult;
begin
  With TOptionsDlg.Create(Application.MainForm) do
    Try
      Edit1.Text:=Str;
      Result:=ShowModal;
      Str:=Edit1.Text;
    Finally
      Free;
    End;
end;
 
procedure TOptionsDlg.FormKeyDown(Sender: TObject; var Key: Word;
  Shift: TShiftState);
begin
  Case Key of
    27:     ModalResult:=mrCancel;
    13: ModalResult:=mrOk;
  End;
end;
 
end.
</pre>
<p>Сергей Горбань</p>
<p><a href="https://www.delphikingdom.com" target="_blank">https://www.delphikingdom.com</a></p>
