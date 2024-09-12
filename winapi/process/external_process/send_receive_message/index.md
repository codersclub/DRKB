---
Title: Как передать строку другому приложению?
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---

Как передать строку другому приложению?
=======================================

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


