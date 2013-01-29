---
Title: Покрашенный TStringGrid
Date: 01.01.2007
---


Покрашенный TStringGrid
=======================

::: {.date}
01.01.2007
:::

\...вы можете попробовать использовать StringGrid. У него имеется
свойство Objects, через которое вы можете назначать объекты. Создайте
объект, содержащий переменную типа TColor, и назначьте это
Objects\[col,row\], что позволит иметь к нему доступ в любое время.
Назначьте событие OnDrawCell StringGrid, позволяющее рисовать текст
ячейки правильного цвета. Чтобы убедиться, что ячейка выбрана,
воспользуйтесь свойством Selection, содержащим то, что выбрал
пользователь. Все это должно выглядеть приблизительно так:

    type
      TStrColor = class(TObject)
      public
        Color: TColor; {вы могли бы также определить частные и
        публичные методы доступа}
      end;
    ...
     
    procedure TForm1.FormCreate(Sender: TObject)
    var
      i, j: Integer;
    begin
      with StringList1 do
        for i := 0 to ColCount - 1
          for j := 0 to RowCount - 1
          Objects[i, j] := TStrColor.Create;
    end;
    ...
     
    procedure TForm1.StringGrid1DrawCell(Sender: TObject; Col, Row: Longint;
      Rect: TRect; State: TGridDrawState);
    var
      OldColor: TColor;
    begin
      with StringGrid1.Canvas do
      begin
        OldColor := Font.Color;
        Font.Color := (StringGrid1.Objects[col, row] as TStrColor).Color;
        TextOut(Rect.Left + 2, Rect.Top + 2, StringGrid1.Cells[Col, Row]);
        Font.Color := OldColor;
      end;
    end;
    ...
     
    procedure TForm1.ProcessSelection(Sender: TObject);
    var
      i, j: Integer;
    begin
      with StringGrid1.Selection do
        for i := left to right do
          for j := top to bottom do
            MessageDlg(IntToStr(i) + ',' + IntToStr(j) + '-' +
              IntToStr((StringGrid1.Objects[i, j] as TStrColor).Color),
              mtInformation, [mbOk], 0);
    end;
     
     
     
     

Этот компонент не позволяет делать многочисленный выбор\....

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

 

------------------------------------------------------------------------

В данном модуле демонстрируется техника изменения цвета у выводимого в
StringGrid текста.

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
     
     

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
