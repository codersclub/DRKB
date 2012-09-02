<h1>Символы разного цвета в TStringGrid</h1>
<div class="date">01.01.2007</div>


<p>Ниже представлен юнит, который позволяет поместить текст в String Grid с символами различного цвета:</p>
<pre>
unit Strgr;
 
interface
 
uses
  SysUtils, WinTypes, WinProcs, Messages, Classes, Graphics, Controls,
  Forms, Dialogs, Grids, StdCtrls, DB;
 
type
  TForm1 = class(TForm)
    StringGrid1: TStringGrid;
    procedure StringGrid1DrawCell(Sender: TObject; Col, Row: Longint;
      Rect: TRect; State: TGridDrawState);
  private
    { Private declarations }
  public
    { Public declarations }
  end;
 
var
  Form1: TForm1;
 
implementation
 
{$R *.DFM}
 
procedure TForm1.StringGrid1DrawCell(Sender: TObject; Col, Row: Longint;
  Rect: TRect; State: TGridDrawState);
const
  CharOffset = 3;
begin
  with StringGrid1.canvas do
  begin
    font.color := clMaroon;
    textout(rect.left + CharOffset, rect.top + CharOffset, 'L');
      font.color := clNavy;
    textout(rect.left + CharOffset + TextWidth('L'),
      rect.top + CharOffset, 'loyd');
  end;
end;
 
end.
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

