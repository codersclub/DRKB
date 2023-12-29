---
Title: Режим вставки и замены
Date: 01.01.2007
---


Режим вставки и замены
======================

::: {.date}
01.01.2007
:::

Элементы управления Windows TEdit и TMemo не имеют режима замены. Однако
этот режим можно эмулировать установив свойство SelLength edit\'а или
memo в 1 при обработке события KeyPress. Это заставит его перезаписывать
символ в текущей позиции курсора. В примере этот способ используется для
TMemo. Режим вставка/замена переключается клавишей "Insert".

    type
      TForm1 = class(TForm)
        Memo1: TMemo;
        procedure Memo1KeyDown(Sender: TObject; var Key: Word; Shift: TShiftState);
        procedure Memo1KeyPress(Sender: TObject; var Key: Char);
      private
        {Private declarations}
        InsertOn : bool;
      public
        {Public declarations}
    end;
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.DFM}
     
    procedure TForm1.Memo1KeyDown(Sender: TObject; var Key: Word; Shift: TShiftState);
    begin
      if (Key = VK_INSERT) and (Shift = []) then
        InsertOn := not InsertOn;
    end;
     
    procedure TForm1.Memo1KeyPress(Sender: TObject; var Key: Char);
    begin
      if ((Memo1.SelLength = 0) and (not InsertOn)) then
        Memo1.SelLength := 1;
    end;
     
     

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
