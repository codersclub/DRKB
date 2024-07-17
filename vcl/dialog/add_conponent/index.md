---
Title: Добавляем компонент в стандартный MessageDialog
Author: Terrance Hui
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Добавляем компонент в стандартный MessageDialog
===============================================

Пример показывает стандартное диалоговое окно, которое обычно
используется для подтверждения дальнейших действий в любой программе с
галочкой "Don\'t show this message again."

Используем функцию CreateMessageDialog и добавляем любой компонент до
того как будет вызвана ShowModal.

    procedure TForm1.Button1Click(Sender: TObject); 
    Var 
      AMsgDialog: TForm; 
      ACheckBox: TCheckBox; 
    begin 
      AMsgDialog := CreateMessageDialog('This is a test message.', mtWarning, [mbYes, mbNo]); 
      ACheckBox := TCheckBox.Create(AMsgDialog); 
      with AMsgDialog do 
      try 
        Caption := 'Dialog Title' ; 
        Height := 169; 
     
        With ACheckBox do 
        begin 
          Parent := AMsgDialog; 
          Caption := 'Do not show me again.'; 
          top := 121; 
          Left := 8; 
        end; 
     
        Case ShowModal of 
          ID_YES: ;//здесь Ваш код после того как диалог будет закрыт 
          ID_NO:  ; 
        end; 
        If ACheckBox.Checked then 
        begin 
          //... 
        end; 
      finally 
        ACheckBox.Free; 
        Free; 
      end; 
    end; 

Так же Вы можете изменить диалог по Вашему усмотрению.

