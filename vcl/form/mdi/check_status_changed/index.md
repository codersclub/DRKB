---
Title: Как узнать, что MDI-форма изменила статус?
Date: 01.01.2007
---


Как узнать, что MDI-форма изменила статус?
==========================================

     private
       Procedure WMSize( Var msg: TWMSize ); Message WM_SIZE;
    ...
    Procedure TChildForm.WMSize( Var msg: TWMSize );
    Begin
      inherited;
      If msg.SizeType = SIZE_MINIMIZED Then
        ...
    End;
