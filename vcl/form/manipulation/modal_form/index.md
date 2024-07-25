---
Title: Как создать и вызвать модальную форму?
Date: 01.01.2007
---


Как создать и вызвать модальную форму?
======================================

    ModalForm := TModalForm.Create(Self);
    try
      ModalForm.ShowModal;
    finally 
      ModalForm.Free;
    end;
