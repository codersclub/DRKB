---
Title: Вывод шрифтов в списке в виде самих шрифтов
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---

Вывод шрифтов в списке в виде самих шрифтов
===========================================

    unit Fontlist;
     
    interface
     
    uses
      Windows, Classes, Graphics, Forms, Controls, StdCtrls;
     
    type
      TForm1 = class(TForm)
        ListBox1: TListBox;
        Label1: TLabel;
        FontLabel: TLabel;
        procedure FormCreate(Sender: TObject);
        procedure ListBox1Click(Sender: TObject);
        procedure DrawItem(Control: TWinControl; index: Integer; Rect: TRect;
          State: TOwnerDrawState);
        procedure ListBox1MeasureItem(Control: TWinControl; index: Integer;
          var Height: Integer);
      private
        { Private declarations }
      public
        { Public declarations }
    end;
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.DFM}
     
    procedure TForm1.FormCreate(Sender: TObject);
    begin
      Listbox1.Items := Screen.Fonts;
    end;
     
    procedure TForm1.ListBox1Click(Sender: TObject);
    begin
      FontLabel.Caption := ListBox1.Items[ListBox1.ItemIndex];
    end;
     
    procedure TForm1.DrawItem(Control: TWinControl; index: Integer;
      Rect: TRect; State: TOwnerDrawState);
    begin
      with ListBox1.Canvas do
      begin
        FillRect(Rect);
        Font.name := ListBox1.Items[index];
        Font.Size := 0; // use font's preferred size
        TextOut(Rect.Left+1, Rect.Top+1, ListBox1.Items[index]);
      end;
    end;
     
    procedure TForm1.ListBox1MeasureItem(Control: TWinControl; index: Integer;
      var Height: Integer);
    begin
      with ListBox1.Canvas do
      begin
        Font.name := Listbox1.Items[index];
        Font.Size := 0; // use font's preferred size
        Height := TextHeight('Wg') + 2; // measure ascenders and descenders
      end;
    end;
     
    end.

