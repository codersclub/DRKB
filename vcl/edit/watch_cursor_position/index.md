---
Title: Отслеживаем позицию курсора в TEdit
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Отслеживаем позицию курсора в TEdit
===================================

В форму добавляются TEditBox и TLabel, при этом TLabel постоянно
показывает позицию курсора в элементе редактирования.

    procedure TForm1.Edit1Change(Sender: TObject); 
    begin 
      CurPos := Edit1.SelStart; 
      Label1.Caption := IntToStr(CurPos); 
    end; 
     
    procedure TForm1.Edit1KeyDown(Sender: TObject; var Key: Word; 
      Shift: TShiftState); 
    begin 
      If Key = VK_LEFT then dec(CurPos); 
      if Key = VK_RIGHT then inc(CurPos);   
      Label1.Caption:= IntToStr(CurPos); 
    end;

