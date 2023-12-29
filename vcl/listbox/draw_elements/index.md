---
Title: Отрисовка элементов TListBox
Author: Александр (Rouse\_) Багель
Date: 01.01.2007
---


Отрисовка элементов TListBox
============================

::: {.date}
01.01.2007
:::

    unit Unit1;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms,
      Dialogs, StdCtrls;
     
    type
      TForm1 = class(TForm)
        ListBox1: TListBox;
        Button1: TButton;
        procedure Button1Click(Sender: TObject);
        procedure ListBox1DrawItem(Control: TWinControl; Index: Integer;
          Rect: TRect; State: TOwnerDrawState);
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.dfm}
     
    procedure TForm1.Button1Click(Sender: TObject);
    var
      S : String;
    begin
      // Очистка
      ListBox1.Clear;
      S := 'C:\Windows*.bmp';
      // Даем команду листбоксу чтобы он нашел все картинки в папке Windows
      // и занес их имена к себе
      ListBox1.Perform(LB_DIR, DDL_READWRITE, Longint(@S[1]));
    end;
     
    procedure TForm1.ListBox1DrawItem(Control: TWinControl; Index: Integer;
      Rect: TRect; State: TOwnerDrawState);
    begin
      with (Control as TListBox).Canvas do
      begin
        // очищаем прямоугольник
        FillRect(Rect);
        // В зависимости от индекса - определяем цвет
        Font.Color := clBlack;
        case Index of
          0: Font.Color := clBlue;
          1: Font.Color := clRed;
          2, 4: Font.Color := clGreen;
        end;
        // Выводим текст
        TextOut(Rect.Left, Rect.Top, Listbox1.Items[Index]);
      end;
    end;
     
    end.

Автор: Александр (Rouse\_) Багель

Взято из <https://forum.sources.ru>
