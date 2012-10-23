<h1>Выравнивание по центру в TEdit</h1>
<div class="date">01.01.2007</div>

<p>TEdit не поддерживает выравниваение текста по центру и по правой стороне - лучше использовать компонент TMemo. Вам понадобится запретить пользователю нажимать Enter, Ctrl-Enter и всевозможные комбинации клавиш со стрелками, чтобы избежать появления нескольких сторк в Memo. Этого можно добиться и просматривая содержимое текста в TMemo в поисках кода возврата каретки (13) и перевода строки(10) на событиях TMemo Change и KeyPress. Можно также заменять код возврата каретки на пробел - для того чтобы позволять вставку из буфера обмена многострочного текста в виде одной строки. </p>
<pre>
procedure TForm1.FormCreate(Sender: TObject);
begin
  Memo1.Alignment := taCenter;
  Memo1.MaxLength := 24;
  Memo1.WantReturns := false;
  Memo1.WordWrap := false;
end;
 
procedure MultiLineMemoToSingleLine(Memo: TMemo);
var
  t: string;
begin
  t := Memo.Text;
  if Pos(#13, t) &gt; 0 then
  begin
    while Pos(#13, t) &gt; 0 do
      delete(t, Pos(#13, t), 1);
    while Pos(#10, t) &gt; 0 do
      delete(t, Pos(#10, t), 1);
    Memo.Text := t;
  end;
end;
 
procedure TForm1.Memo1Change(Sender: TObject);
begin
  MultiLineMemoToSingleLine(Memo1);
end;
 
procedure TForm1.Memo1KeyPress(Sender: TObject; var Key: Char);
begin
  MultiLineMemoToSingleLine(Memo1);
end; 
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
&nbsp;</p>
<hr />
<pre>
unit Unit1;
 
interface
 
uses
  Windows, Messages, SysUtils, Variants, Classes, Graphics, Controls, Forms,
  Dialogs, StdCtrls;
 
{ Пример TEdit с выравниванием по центру © Song 
  в модификации Vit
}

 
type
 TForm1 = class(TForm)
   procedure FormCreate(Sender: TObject);
 private
   { Private declarations }
 public
   { Public declarations }
 end;
 
{ Обявляем класс нашего едита как потомок от стандартного}
type TMySuperEdit=class(TCustomEdit)
public
  { Внутри класса переопредялем процедуру CreateParams,
     т.к. нужный нам стиль можно изменить только на создании или пересоздании
     окна  }
 Procedure CreateParams(Var Params: TCreateParams); override;
end;
 
var
 Form1: TForm1;
 
implementation
 
{$R *.dfm}
 
Procedure TMySuperEdit.CreateParams(Var Params: TCreateParams);
Begin
 { Вызываем родительский обработчик, чтобы он сделал все процедуры по созданию объекта класса }
inherited CreateParams(Params);
  { Изменяем стиль }
With Params Do Style:=Style or ES_CENTER;
End;
 
procedure TForm1.FormCreate(Sender: TObject);
begin
 { Создаём едит на основе нашего класса и кладём его на форму }
With TMySuperEdit.Create(Self) Do
  Parent:=Self;
end;
End.
</pre>
<div class="author">Автор: Vit</div>

