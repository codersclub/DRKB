---
Title: Копирование в буфер обмена
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Копирование в буфер обмена
==========================

Копировать в буфер:

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

Вставить из буфера:

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

