---
Title: Проверить, можно ли отменить последнее действие в TMemo
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch>
---


Проверить, можно ли отменить последнее действие в TMemo
=======================================================

    procedure TForm1.Button1Click(Sender: TObject);
     begin
       if Memo1.Perform(EM_CANUNDO, 0, 0) <> 0 then
         ShowMessage('Undo is possible')
       else
         ShowMessage('Undo is not possible');
     end;

