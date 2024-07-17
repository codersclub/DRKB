---
Title: Как сделать popup TComboBox по позиции курсора в TMemo?
Date: 01.01.2007
Source: Delphi Knowledge Base: <https://www.baltsoft.com/>
---


Как сделать popup TComboBox по позиции курсора в TMemo?
=======================================================


    unit CBoxInMemo;
     
    interface
     
    uses
      Windows, Classes, Controls, Graphics, Forms, StdCtrls;
     
    type
      TFrmCboxInMemo = class(TForm)
        Button1: TButton;
        Memo1: TMemo;
        Label1: TLabel;
        ComboBox1: TComboBox;
        procedure Button1Click(Sender: TObject);
        procedure ComboBox1Exit(Sender: TObject);
        procedure ComboBox1Click(Sender: TObject);
      private
        { Private declarations }
      public
        { Public declarations }
      end;
     
    var
      FrmCboxInMemo: TFrmCboxInMemo;
     
    implementation
     
    {$R *.DFM}
     
    procedure TFrmCboxInMemo.Button1Click(Sender: TObject);
    var
      clientPos: TPoint;
      lineHeight: Integer;
      tmpFont: TFont;
    begin
      GetCaretPos(clientPos);
      {Use the following calculation of line height only if you want your combobox
      to appear below the char position you are referencing.}
      tmpFont := Canvas.Font;
      Canvas.Font := Memo1.Font;
      lineHeight := Canvas.TextHeight('Xy');
      Canvas.Font := tmpFont;
      with ComboBox1 do
      begin
        {Adjustment of Top by lineHeight only necessary if combobox is to appear below line.}
        Top := clientPos.Y + Memo1.Top + lineHeight;
        Left := clientPos.X + Memo1.Left;
        Visible := true;
        SetFocus;
      end;
    end;
     
    procedure TFrmCboxInMemo.ComboBox1Exit(Sender: TObject);
    begin
      ComboBox1.Visible := false;
    end;
     
    procedure TFrmCboxInMemo.ComboBox1Click(Sender: TObject);
    begin
      ComboBox1.Visible := false;
    end;
     
    end.

