---
Title: Вывести номер строки и столбца TStringGrid
Author: Дмитрий Карагеур
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Вывести номер строки и столбца TStringGrid
==========================================

Например, у нас есть таблица с некоторыми данными, и нам необходимо
какую-либо запись отредактировать/удалить и т.п. Чтобы не считать, какой
это столбец или строка используем следующее: создаем popup menu,
прописываем его в форме и создаем соответствующие обработчики событий -
это все в файле. На самой таблице жмем правым кликом и edit и перед нами
номер строки и столбца. Эти данные пригодятся для создания более
интерактивного и дружественного интерфейса ваших приложений.

    unit Unit1;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Variants, Classes, Graphics, Controls, Forms,
      Dialogs, Grids, Menus;
     
    type
      TForm1 = class(TForm)
        StringGrid1: TStringGrid;
        PopupMenu1: TPopupMenu;
        Edit1: TMenuItem;
        procedure StringGrid1MouseMove(Sender: TObject; Shift: TShiftState; X,
          Y: Integer);
        procedure Edit1Click(Sender: TObject);
      private
        { Private declarations }
      public
        x1, y1: integer;
      end;
     
    var
      Form1: TForm1;
    implementation
     
    {$R *.dfm}
     
    procedure TForm1.StringGrid1MouseMove(Sender: TObject; Shift: TShiftState;
      X, Y: Integer);
    begin
      form1.x1 := x;
      form1.y1 := y;
    end;
     
    procedure TForm1.Edit1Click(Sender: TObject);
    var
      Column, Row: Longint;
    begin
      StringGrid1.MouseToCell(form1.x1, form1.y1, Column, Row);
      ShowMessage('Строка - ' + IntToStr(row) + #13 + 'Столбец - ' + IntToStr(column));
    end;
     
    end.


