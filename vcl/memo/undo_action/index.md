---
Title: Проверить, можно ли отменить последнее действие в TMemo
Date: 01.01.2007
---


Проверить, можно ли отменить последнее действие в TMemo
=======================================================

::: {.date}
01.01.2007
:::

    procedure TForm1.Button1Click(Sender: TObject);
     begin
       if Memo1.Perform(EM_CANUNDO, 0, 0) <> 0 then
         ShowMessage('Undo is possible')
       else
         ShowMessage('Undo is not possible');
     end;

Взято с сайта: <https://www.swissdelphicenter.ch>
