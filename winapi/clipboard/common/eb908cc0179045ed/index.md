---
Title: Копирование в буфер обмена
Date: 01.01.2007
---


Копирование в буфер обмена
==========================

::: {.date}
01.01.2007
:::

    procedure CopyButtonClick(Sender: TObject);
    begin
      if ActiveControl is TMemo then
        TMemo(ActiveControl).CopyToClipboard;
      if ActiveControl is TDBMemo then
        TDBMemo(ActiveControl).CopyToClipboard;
      if ActiveControl is TEdit then
        TEdit(ActiveControl).CopyToClipboard;
      if ActiveControl is TDBedit then
        TDBedit(ActiveControl).CopyToClipboard;
    end;
     
    procedure PasteButtonClick(Sender: TObject);
    begin
      if ActiveControl is TMemo then
        TMemo(ActiveControl).PasteFromClipboard;
      if ActiveControl is TDBMemo then
        TDBMemo(ActiveControl).PasteFromClipboard;
      if ActiveControl is TEdit then
        TEdit(ActiveControl).PasteFromClipboard;
      if ActiveControl is TDBedit then
        TDBedit(ActiveControl).PasteFromClipboard;
    end;
     

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
