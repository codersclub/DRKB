---
Title: Проверка значения бита
Author: Krid
Date: 01.01.2007
---


Проверка значения бита
======================

Вариант 1:

Author: Krid

Source: <https://forum.sources.ru>

Проверка - установлен ли определенный бит?

    function IsBitSet(Value: cardinal; BitNum : byte): boolean;
    begin
      result:=((Value shr BitNum) and 1) = 1
    end;
    ...
    if IsBitSet(43691,1) then //установлен (равен 1)

------------------------------------------------------------------------

Вариант 2:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

    function GetBitStat(SetWord, BitNum: Word): Boolean;
    begin
      GetBitStat := SetWord and BitNum = BitNum { Если бит установлен }
    end;


------------------------------------------------------------------------

Вариант 3:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

    unit BitsForm;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls,
      Forms, Dialogs, ComCtrls, StdCtrls;
     
    type
      TForm1 = class(TForm)
        Label1: TLabel;
        GroupBox1: TGroupBox;
        CheckBox1: TCheckBox;
        CheckBox2: TCheckBox;
        CheckBox3: TCheckBox;
        CheckBox4: TCheckBox;
        CheckBox5: TCheckBox;
        Edit1: TEdit;
        UpDown1: TUpDown;
        procedure Edit1Change(Sender: TObject);
        procedure CheckBoxClick(Sender: TObject);
      private
        { Private declarations }
      public
        { Public declarations }
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.DFM}
     
    function IsBitOn (Value: Integer; Bit: Byte): Boolean;
    begin
      Result := (Value and (1 shl Bit)) <> 0;
    end;
     
    function TurnBitOn (Value: Integer; Bit: Byte): Integer;
    begin
      Result := Value or (1 shl Bit);
    end;
     
    function TurnBitOff (Value: Integer; Bit: Byte): Integer;
    begin
      Result := Value and not (1 shl Bit);
    end;
     
    procedure TForm1.Edit1Change(Sender: TObject);
    var
      I: Integer;
      CheckBox: TCheckBox;
    begin
      for I := 1 to 5 do
      begin
        Checkbox := FindComponent (
          'Checkbox' + IntToStr (I)) as TCheckbox;
        CheckBox.Checked :=
          IsBitOn (UpDown1.Position, CheckBox.Tag);
      end;
    end;
     
    procedure TForm1.CheckBoxClick(Sender: TObject);
    var
      Val: Integer;
    begin
      Val := UpDown1.Position;
      with Sender as TCheckBox do
        if Checked then
          Val := TurnBitOn (Val, Tag)
        else
          Val := TurnBitOff (Val, Tag);
      UpDown1.Position := Val;
    end;
     
    end.


------------------------------------------------------------------------

Вариант 4:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

    unit BitsForm;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls,
      Forms, Dialogs, ComCtrls, StdCtrls;
     
    type
      TForm1 = class(TForm)
        Label1: TLabel;
        GroupBox1: TGroupBox;
        CheckBox1: TCheckBox;
        CheckBox2: TCheckBox;
        CheckBox3: TCheckBox;
        CheckBox4: TCheckBox;
        CheckBox5: TCheckBox;
        Edit1: TEdit;
        procedure CheckBoxClick(Sender: TObject);
        procedure FormCreate(Sender: TObject);
        procedure FormDestroy(Sender: TObject);
      private
        MyBits: TBits;
        procedure UpdateEdit;
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.DFM}
     
    uses
      Math;
     
    procedure TForm1.UpdateEdit;
    var
      I, Total: Integer;
    begin
      Total := 0;
      for I := 0 to 4 do
        if MyBits.Bits [I] then
          Total := Total + Round (Power (2, I));
      Edit1.Text := IntToStr (Total);
    end;
     
    procedure TForm1.CheckBoxClick(Sender: TObject);
    begin
      MyBits.Bits [(Sender as TCheckBox).Tag] :=
        not MyBits.Bits [(Sender as TCheckBox).Tag];
      UpdateEdit;
    end;
     
    procedure TForm1.FormCreate(Sender: TObject);
    begin
      MyBits := TBits.Create;
      MyBits.Size := 5;
    end;
     
    procedure TForm1.FormDestroy(Sender: TObject);
    begin
      MyBits.Free;
    end;
     
    end.
