---
Title: Как поместить TCheckBox внутри TRichEdit?
Date: 01.01.2007
---


Как поместить TCheckBox внутри TRichEdit?
=========================================

::: {.date}
01.01.2007
:::

Для использования следующего примера, необходимо создать новую форму,
перетащить на неё TRichEdit (RichEdit1) и создать checkbox (acb) в
событии FormCreate().

    procedure TForm1.FormCreate(Sender: TObject);

    var
      Acb: TCheckBox;
    begin
      RichEdit1.Left := 20;
      Acb := TCheckBox.Create(RichEdit1);
      Acb.Left := 30;
      Acb.Top := 30;
      Acb.Caption := 'my checkbox';
      Acb.Parent := RichEdit1;
    end;

Взято из <https://forum.sources.ru>
