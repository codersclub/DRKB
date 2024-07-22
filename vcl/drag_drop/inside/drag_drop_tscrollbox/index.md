---
Title: Drag & Drop из TScrollBox
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Drag & Drop из TScrollBox
=========================

Вы можете написать общую функцию для отдельного TImage, и назначать этот
метод для каждого динамически создаваемого TImage, примерно так:

    procedure TForm1.GenericMouseDown(Sender: TObject; Button: TMouseButton;
      Shift: TShiftState; X, Y: Integer);
    begin
      TImage(Sender).BeginDrag(False);
      {что-то другое, что вы хотели бы сделать}
    end;
     
    {....}
     
    UmpteenthDynImage := TImage.Create(dummyImage);
    UmpteenthDynImage.MouseDown := TForm1.GenericMouseDown;

Это должно быть синтаксически закрытым. Вы можете просто назначать
каждый динамический объект методу GenericMouseDown, и они все им будут
пользоваться. Предок dummyImage позволяет легко разрушать все
динамические объекты обычным деструктором dummyImage.



 
