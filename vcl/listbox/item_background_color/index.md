---
Title: Как изменить фоновый цвет текста в различных строчках TListBox?
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Как изменить фоновый цвет текста в различных строчках TListBox?
===============================================================

После того, как поместите TListBox на форму, необходимо изменить
свойство Style в TListBox на lbOwnerDrawFixed. Если не изменить свойство
Style, то событие OnDrawItem никогда не вызовется. Теперь поместите
следующий код в обработчик события OnDrawItem Вашего TListBox:

    procedure TForm1.ListBox1DrawItem
      (Control: TWinControl; Index: Integer;
      Rect: TRect; State: TOwnerDrawState);
    var
        myColor: TColor;
        myBrush: TBrush;      
    begin
      myBrush := TBrush.Create;  
      with (Control as TListBox).Canvas do
      begin
        if not Odd(Index) then
          myColor := clSilver
        else
          myColor := clYellow;
        myBrush.Style := bsSolid; 
        myBrush.Color := myColor; 
        Windows.FillRect(handle, Rect, myBrush.Handle); 
        Brush.Style := bsClear;  
        TextOut(Rect.Left, Rect.Top, 
                (Control as TListBox).Items[Index]);  
        MyBrush.Free;
      end;
    end;

