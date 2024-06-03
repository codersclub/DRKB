---
Title: Как создать компонент во время выполнения приложения?
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Как создать компонент во время выполнения приложения?
=====================================================

При создании визуальных контролов в runtime, важным моментом является
назначение родительских свойств и использование метода SetBounds, чтобы
этот контрол стал видимым.

    type 
      TForm1 = class(TForm) 
      protected 
        MyLabel: TLabel; 
        procedure LabelClick(Sender: TObject); 
        procedure CreateControl; 
      end; 
     
    procedure TForm1.LabelClick(Sender: TObject); 
    begin 
      (Sender as Label).Caption := ... 
    end; 
     
    procedure TForm1.CreateControl; 
    var 
      ALeft, ATop, AWidth, AHeight: Integer; 
    begin 
      ALeft := 10; 
      ATop := 10; 
      AWidth := 50; 
      AHeight := 13; 
      MyLabel := TLabel.Create(Self); 
      MyLabel.Parent := Self;       
      MyLabel.Name:='LabelName'; 
      MyLabel.SetBounds(ALeft, ATop, AWidth, AHeight); 
      MyLabel.OnClick := LabelClick; 
    end;

