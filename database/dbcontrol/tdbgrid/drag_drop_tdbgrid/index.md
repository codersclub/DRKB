---
Title: Пример Drag & Drop между двумя TDBGrid
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Пример Drag & Drop между двумя TDBGrid
======================================

Данный пример компонента и демонстрационный проект показывают простой
путь осуществления операции "drag and drop" (перетащи и брось) между
двумя полями различных табличных сеток.

Запустите Delphi 3 (с незначительными изменениями данный код может
работать и в Delphi 1-2).

Активизируйте File\|New\|Unit. Скопируйте приведенный ниже модуль
MyDBGrid во вновь созданный модуль. Сделайте File\|Save As. Сохраните
модуль как MyDBGrid.pas.

Выберите пункт меню Component\|Install Component. Переключитесь на
страницу Info New Package. Поместите MyDBGrid.pas в поле редактирования
"Unit file name" (имя файла модуля). Назовите модуль MyPackage.dpk.
Ответьте Yes на вопрос Delphi 3 о необходимости сборки и установки
пакета. Нажмите OK на сообщение Delphi 3 о необходимости включения
VCL30.DPL. После этого пакет будет собран и установлен. Теперь компонент
TMyDBGrid будет отображен в Палитре Компонентов в группе "Samples".
Закройте редактор пакетов и сохраните пакет.

Выберите пункт меню File\|New Application. Щелкните правой кнопкой мыши
на форме (Form1) и выберите View As Text. Скопируйте приведенный ниже
исходный код формы GridU1 в Form1. Щелкните правой кнопкой мыши на форме
и выберите View As Form. Убедитесь в активности ваших таблиц. Скопируйте
расположенный ниже модуль GridU1 в ваш модуль Unit1.

Выберите пункт меню File\|Save Project As. Сохраните модуль как
GridU1.pas. Сохраните проект как GridProj.dpr.

Теперь запустите проект и наслаждайтесь функцией Drag and Drop между
двумя табличными сетками.

    // Модуль MyDBGrid
     
    unit MyDBGrid;
     
    interface
     
    uses
     
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms,
      Dialogs, Grids, DBGrids;
     
    type
     
      TMyDBGrid = class(TDBGrid)
      private
        { Private declarations }
        FOnMouseDown: TMouseEvent;
      protected
        { Protected declarations }
        procedure MouseDown(Button: TMouseButton; Shift: TShiftState;
          X, Y: Integer); override;
      published
        { Published declarations }
        property Row;
        property OnMouseDown read FOnMouseDown write FOnMouseDown;
      end;
     
    procedure Register;
     
    implementation
     
    procedure TMyDBGrid.MouseDown(Button: TMouseButton;
     
      Shift: TShiftState; X, Y: Integer);
    begin
     
      if Assigned(FOnMouseDown) then
        FOnMouseDown(Self, Button, Shift, X, Y);
      inherited MouseDown(Button, Shift, X, Y);
    end;
     
    procedure Register;
    begin
     
      RegisterComponents('Samples', [TMyDBGrid]);
    end;
     
    end.

    // Модуль GridU1
     
    unit GridU1;
     
    interface
     
    uses
     
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms,
      Dialogs, Db, DBTables, Grids, DBGrids, MyDBGrid, StdCtrls;
     
    type
     
      TForm1 = class(TForm)
        MyDBGrid1: TMyDBGrid;
        Table1: TTable;
        DataSource1: TDataSource;
        Table2: TTable;
        DataSource2: TDataSource;
        MyDBGrid2: TMyDBGrid;
        procedure MyDBGrid1MouseDown(Sender: TObject;
          Button: TMouseButton; Shift: TShiftState; X, Y: Integer);
        procedure MyDBGrid1DragOver(Sender, Source: TObject;
          X, Y: Integer; State: TDragState; var Accept: Boolean);
        procedure MyDBGrid1DragDrop(Sender, Source: TObject;
          X, Y: Integer);
      private
        { Private declarations }
      public
        { Public declarations }
      end;
     
    var
     
      Form1: TForm1;
     
    implementation
     
    {$R *.DFM}
     
    var
     
      SGC: TGridCoord;
     
    procedure TForm1.MyDBGrid1MouseDown(Sender: TObject;
     
      Button: TMouseButton; Shift: TShiftState; X, Y: Integer);
    var
     
      DG: TMyDBGrid;
    begin
     
      DG := Sender as TMyDBGrid;
      SGC := DG.MouseCoord(X, Y);
      if (SGC.X > 0) and (SGC.Y > 0) then
        (Sender as TMyDBGrid).BeginDrag(False);
    end;
     
    procedure TForm1.MyDBGrid1DragOver(Sender, Source: TObject;
     
      X, Y: Integer; State: TDragState; var Accept: Boolean);
    var
     
      GC: TGridCoord;
    begin
     
      GC := (Sender as TMyDBGrid).MouseCoord(X, Y);
      Accept := Source is TMyDBGrid and (GC.X > 0) and (GC.Y > 0);
    end;
     
    procedure TForm1.MyDBGrid1DragDrop(Sender, Source: TObject;
     
      X, Y: Integer);
    var
     
      DG: TMyDBGrid;
      GC: TGridCoord;
      CurRow: Integer;
    begin
     
      DG := Sender as TMyDBGrid;
      GC := DG.MouseCoord(X, Y);
      with DG.DataSource.DataSet do
      begin
        with (Source as TMyDBGrid).DataSource.DataSet do
          Caption := 'Вы перетащили "' + Fields[SGC.X - 1].AsString + '"';
        DisableControls;
        CurRow := DG.Row;
        MoveBy(GC.Y - CurRow);
        Caption := Caption + ' в "' + Fields[GC.X - 1].AsString + '"';
        MoveBy(CurRow - GC.Y);
        EnableControls;
      end;
    end;
     
    end.

    // Форма GridU1
     
    object Form1: TForm1
     
      Left = 200
        Top = 108
        Width = 544
        Height = 437
        Caption = 'Form1'
        Font.Charset = DEFAULT_CHARSET
        Font.Color = clWindowText
        Font.Height = -11
        Font.Name = 'MS Sans Serif'
        Font.Style = []
        PixelsPerInch = 96
        TextHeight = 13
        object MyDBGrid1: TMyDBGrid
        Left = 8
          Top = 8
          Width = 521
          Height = 193
          DataSource = DataSource1
          Row = 1
          TabOrder = 0
          TitleFont.Charset = DEFAULT_CHARSET
          TitleFont.Color = clWindowText
          TitleFont.Height = -11
          TitleFont.Name = 'MS Sans Serif'
          TitleFont.Style = []
          OnDragDrop = MyDBGrid1DragDrop
          OnDragOver = MyDBGrid1DragOver
          OnMouseDown = MyDBGrid1MouseDown
      end
      object MyDBGrid2: TMyDBGrid
        Left = 7
          Top = 208
          Width = 521
          Height = 193
          DataSource = DataSource2
          Row = 1
          TabOrder = 1
          TitleFont.Charset = DEFAULT_CHARSET
          TitleFont.Color = clWindowText
          TitleFont.Height = -11
          TitleFont.Name = 'MS Sans Serif'
          TitleFont.Style = []
          OnDragDrop = MyDBGrid1DragDrop
          OnDragOver = MyDBGrid1DragOver
          OnMouseDown = MyDBGrid1MouseDown
      end
      object Table1: TTable
        Active = True
          DatabaseName = 'DBDEMOS'
          TableName = 'ORDERS'
          Left = 104
          Top = 48
      end
      object DataSource1: TDataSource
        DataSet = Table1
          Left = 136
          Top = 48
      end
      object Table2: TTable
        Active = True
          DatabaseName = 'DBDEMOS'
          TableName = 'CUSTOMER'
          Left = 104
          Top = 240
      end
      object DataSource2: TDataSource
        DataSet = Table2
          Left = 136
          Top = 240
      end
    end

