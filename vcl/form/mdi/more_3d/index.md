---
Title: Придание MDI-формам большей трехмерности
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Придание MDI-формам большей трехмерности
========================================

    constructor TMainForm.Create(AOwner: TComponent);
    begin
      Inherited Create(AOwner);
      SetWindowLong(ClientHandle, GWL_EXSTYLE,
      GetWindowLong(ClientHandle, GWL_EXSTYLE) or WS_EX_CLIENTEDGE);
      SetWindowPos(ClientHandle, 0, 0, 0, 0, 0,
        swp_DrawFrame or swp_NoMove or swp_NoSize or swp_NoZOrder);
    end;

