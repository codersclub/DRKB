---
Title: Как найти простое число?
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Как найти простое число?
========================


    unit simple_;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
      StdCtrls;
     
    type
      TForm1 = class(TForm)
        Button1: TButton;
        Label1: TLabel;
        Edit1: TEdit;
        Label2: TLabel;
        procedure Button1Click(Sender: TObject);
      private
        { Private declarations }
      public
        { Public declarations }
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.DFM}
     
    procedure TForm1.Button1Click(Sender: TObject);
    var
      n: integer; // проверяемое число
      d: integer; // делитель
      r: integer; // остаток от деления n на d
    begin
      n := StrToInt(Edit1.text);
      d := 2; // сначала будем делить на два
      repeat
        r := n mod d;
        if r <> 0 {// n не разделилось нацело на d} then
          d := d + 1;
      until r = 0; // повторять пока не найдено число на n делится без остатка
      label2.caption := Edit1.text;
      if d = n then
        label2.caption := label2.caption + ' - простое число.'
      else
        label2.caption := label2.caption + ' - обычное число.';
    end;
     
    end.
     


