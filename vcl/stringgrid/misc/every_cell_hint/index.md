---
Title: Как сделать различные подсказки для каждой ячейки в TStringGrid?
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Как сделать различные подсказки для каждой ячейки в TStringGrid?
================================================================

Следующий пример демонстрирует отслеживаение движения мышки в компоненте
TStringGrid. Если мышка переместится на другую ячейку в гриде, то будет
показано новое окно подсказки с номером колонки и строки данной ячейки:

    type
      TForm1 = class(TForm)
        StringGrid1: TStringGrid;
        procedure StringGrid1MouseMove(Sender: TObject;
          Shift: TShiftState; X, Y: Integer);
        procedure FormCreate(Sender: TObject);
      private
        { Private declarations }
          Col : integer;
          Row : integer;
      public
        { Public declarations }
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.DFM}
     
    procedure TForm1.FormCreate(Sender: TObject);
    begin
      StringGrid1.Hint := '0 0';
      StringGrid1.ShowHint := True;
    end;
     
    procedure TForm1.StringGrid1MouseMove(Sender: TObject;
    Shift: TShiftState; X, Y: Integer);
    var
      r : integer;
      c : integer;
    begin
      StringGrid1.MouseToCell(X, Y, C, R);
      if ((Row <> r) or
          (Col <> c)) then begin
        Row := r;
        Col := c;
        Application.CancelHint;
        StringGrid1.Hint := IntToStr(r) + #32 + IntToStr(c);
      end;
    end;

