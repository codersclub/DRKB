---
Title: Как создать и вызвать модальную форму?
Date: 01.01.2007
---


Как создать и вызвать модальную форму?
======================================

::: {.date}
01.01.2007
:::

    ModalForm := TModalForm.Create(Self);
    try
      ModalForm.ShowModal;
    finally 
      ModalForm.Free;
    end;
