---
Title: Как перетащить целую колонку из StringGrid в ListBox?
Date: 01.01.2007
---


Как перетащить целую колонку из StringGrid в ListBox?
=====================================================

::: {.date}
01.01.2007
:::

В Object Inspector установите свойство dragmode у StringGrid в
dmAutomatic.

Ниже приведён полный код:

    type
      TForm1 = class(TForm)
        StringGrid1: TStringGrid;
        ListBox1: TListBox;
        procedure ListBox1DragOver(Sender, Source: TObject; X, Y: Integer;
          State: TDragState; var Accept: Boolean);
        procedure ListBox1DragDrop(Sender, Source: TObject; X, Y: Integer);
        procedure FormCreate(Sender: TObject);
        procedure StringGrid1DragOver(Sender, Source: TObject; X, Y: Integer;
          State: TDragState; var Accept: Boolean);
        procedure StringGrid1DragDrop(Sender, Source: TObject; X, Y: Integer);
      private
        { Private declarations }
        XMouseCord: Integer;
        StartDrag: Boolean;
      public
        { Public declarations }
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.DFM}
     
    procedure TForm1.ListBox1DragOver(Sender, Source: TObject; X, Y: Integer;
      State: TDragState; var Accept: Boolean);
    begin
      Accept := Source is TStringGrid;
    end;
     
    procedure TForm1.ListBox1DragDrop(Sender, Source: TObject; X, Y: Integer);
    var
      i: integer;
      ColumVal, CurrentCol: Integer;
    begin
      if Source is TStringGrid then
      begin
        //Вычисляем колонку
        ColumVal := 0;
        CurrentCol := 0;
        for i := 0 to TStringGrid(Source).ColCount - 1 do
        begin
          ColumVal := ColumVal + TStringGrid(Source).ColWidths[i];
          if XMouseCord <= ColumVal then
          begin
            CurrentCol := i;
            break;
          end;
        end;
        //Убеждаемся, что это не первая колонка, которая не содержит данных
        if CurrentCol <> 0 then
        begin
          for i := 1 to TStringGrid(Source).RowCount - 1 do
          begin
            ListBox1.items.Add(TStringGrid(Source).Cells[CurrentCol, i]);
          end;
        end;
        StartDrag := True;
      end;
    end;
     
    procedure TForm1.FormCreate(Sender: TObject);
    begin
    //Для демонстрационных целей
      with StringGrid1 do
      begin
        Cells[1, 1] := 'T1';
        Cells[1, 2] := 'T2';
        Cells[1, 3] := 'T3';
        Cells[1, 4] := 'T4';
        Cells[2, 1] := 'T5';
        Cells[2, 2] := 'T6';
        Cells[2, 3] := 'T7';
        Cells[2, 4] := 'T8';
        Cells[3, 1] := 'T9';
        Cells[3, 2] := 'T10';
        Cells[3, 3] := 'T11';
        Cells[3, 4] := 'T12';
        Cells[4, 1] := 'T13';
        Cells[4, 2] := 'T14';
        Cells[4, 3] := 'T15';
        Cells[4, 4] := 'T16';
      end;
      StartDrag := True;
    end;
     
    procedure TForm1.StringGrid1DragOver(Sender, Source: TObject; X,
      Y: Integer; State: TDragState; var Accept: Boolean);
    begin
      //Сохраняем колонку, когда начинается перетаскивание.
      if StartDrag then
      begin
        XMouseCord := X;
        StartDrag := False;
      end;
    end;
     
    procedure TForm1.StringGrid1DragDrop(Sender, Source: TObject; X,
      Y: Integer);
    begin
      //В данном случае помещаем е? на грид
      StartDrag := True;
    end;

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

 
