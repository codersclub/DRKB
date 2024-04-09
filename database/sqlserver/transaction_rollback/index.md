---
Title: Транзакции и откат при ошибках
Author: Vit
Date: 01.01.2007
---


Транзакции и откат при ошибках
==============================

    Begin Tran
     
      Declare @ErrorCode  
     
      Update MyTable
      Set MyField1=MyField2
      Where MyField3=1
     
      Set @ErrorCode=@@Error
     
    If @ErrorCode <> 0 Rollback Else Commit
