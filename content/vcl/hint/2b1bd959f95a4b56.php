<h1>Использование Hints</h1>
<div class="date">01.01.2007</div>

Aвтор: Serzs</p>
<p>Предположим, у нас есть список строк, причем все строки или некоторые не влазят по ширине. Пользоваться прокруткой не всегда удобно. Возможно использование другого варианта. Мышкой проводим по списку и, если строка не влазит по ширине, то появляется Hint, содержащий текущую строку целиком, причем прямо поверх самой строки! Идея подходит ? Тогда это можно реализовать, например, так ... </p>
<p>Текст формы примера : </p>
<pre>
object MainForm: TMainForm
  Left = 7
    Top = 121
    Width = 200
    Height = 157
    Hint = '34534535'
    Caption = 'Long hints'
    Font.Charset = DEFAULT_CHARSET
    Font.Color = clWindowText
    Font.Height = -13
    Font.Name = 'MS Sans Serif'
    Font.Style = []
    ShowHint = True
    OnCreate = FormCreate
    PixelsPerInch = 120
    TextHeight = 16
    object ListBox1: TListBox
    Left = 12
      Top = 12
      Width = 165
      Height = 97
      Hint = '1|2'
      ItemHeight = 16
      Items.Strings = (
      '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ'
      'A1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ'
      '1234567890'
      'ABCDEFGHIJKLMNOPQRSTUVWXYZ'
      'ABCD')
      ParentShowHint = False
      ShowHint = True
      TabOrder = 0
      OnMouseMove = ListBox1MouseMove
  end
end
</pre>
<p>Текст модуля : </p>
<pre>
unit Main;
 
interface
 
uses
  Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
  StdCtrls;
 
type
  TMainForm = class(TForm)
    ListBox1: TListBox;
    procedure FormCreate(Sender: TObject);
    procedure ListBox1MouseMove(Sender: TObject; Shift: TShiftState; X,
      Y: Integer);
  private
    { Private declarations }
    FHintRow: Integer; // Номер строки в списке, на которую указывает мышь
 
  public
    { Public declarations }
    // Обработчик подсказок
    procedure OnShowHint(var HintStr: string;
      var CanShow: Boolean;
      var HintInfo: THintInfo);
  end;
 
var
  MainForm: TMainForm;
 
implementation
 
{$R *.DFM}
 
procedure TMainForm.FormCreate(Sender: TObject);
begin
  FHintRow := -1;
  Application.OnShowHint := OnShowHint; // Установка обработчика
end;
 
procedure TMainForm.OnShowHint(var HintStr: string;
  var CanShow: Boolean;
  var HintInfo: THintInfo);
var
  Pos: TPoint;
begin
  with HintInfo do
    if HintControl is TListBox then // Проверка на нужный объект
      with HintControl as TListBox do
      begin
        Pos.X := 0;
        Pos.Y := ListBox1.Tag;
        HintPos := ListBox1.ClientToScreen(Pos);
        HintStr := ListBox1.Hint;
      end;
end;
 
procedure TMainForm.ListBox1MouseMove(Sender: TObject; Shift: TShiftState; X,
  Y: Integer);
var
  MousePos: TPoint;
  ItemPos: TRect;
  RowWidth,
    ItemNum: Integer;
  FHint: string;
begin
  MousePos.X := X;
  MousePos.Y := Y;
  ItemNum := ListBox1.ItemAtPos(MousePos, True);
    // Определение номера строки в списке
 
  if (ItemNum &lt;&gt; FHintRow) then // Проверка на перемещение мыши на другую строку
  begin
    FHintRow := ItemNum;
    if ItemNum &lt;&gt; -1 then // Проверка на наличие элементов в списке
    begin
      ItemPos := ListBox1.ItemRect(ItemNum);
 
      Application.CancelHint; // Снять текущую подсказку
      ListBox1.Tag := ItemPos.Top; // Запоминаем позицию строки по вертикали
 
      FHint := ListBox1.Items[ItemNum];
 
      // Проверка на ширину строки
      RowWidth := ListBox1.Canvas.TextWidth(FHint);
      if (RowWidth &gt; ListBox1.ClientWidth) then
        FHint := FHint + '|'
      else
        FHint := '';
 
      ListBox1.Hint := FHint;
    end
    else
    begin
      ListBox1.Hint := '';
      Application.CancelHint;
      ListBox1.Tag := -1;
    end;
  end
end;
 
end.
</pre>
<p>Текст проекта : </p>
<pre>
program PrjHint;
 
uses
  Forms,
  Main in 'Main.pas' {MainForm};
 
{$R *.RES}
 
begin
  Application.Initialize;
  Application.CreateForm(TMainForm, MainForm);
 
  Application.ShowHint := True;
  Application.HintPause := 100;
  Application.HintHidePause := 999999;
 
  Application.Run;
end.
</pre>
<div class="author">Автор: Сергей Королев</div>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
