---
Title: Как передать строку другому приложению?
Date: 01.01.2007
---

Как передать строку другому приложению?
=======================================

::: {.date}
01.01.2007
:::

получатель:

    procedure ReceiveMessage (var Msg: TMessage);
    message WM_COPYDATA;
    ...
    procedure TFormReceive.ReceiveMessage;
    var
      pcd: PCopyDataStruct;
    begin
      pcd := PCopyDataStruct(Msg.LParam);
      Caption := PChar(pcd.lpData);
    end;

отправитель:

    procedure TFormXXX.Button1Click(Sender: TObject);
    var
      cd: TCopyDataStruct;
    begin
      cd.cbData := Length(Edit1.Text) + 1;
      cd.lpData := PChar(Edit1.Text);
      SendMessage(FindWindow('TFormReceive', nil), WM_COPYDATA, 0, LParam(@cd));
    end;

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
