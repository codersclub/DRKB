---
Title: События OnKeyPress и OnKeyDown для клавиши Tab
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


События OnKeyPress и OnKeyDown для клавиши Tab
==================================================================================

> События OnKeyPress и OnKeyDown не вызываются для Tab - как определить её нажатие?

    type
      TForm1 = class(TForm)
      private
        procedure CMDialogKey(var msg: TCMDialogKey);
          message CM_DIALOGKEY;
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.DFM}
     
    procedure TForm1.CMDialogKey(var msg: TCMDialogKey);
    begin
      if msg.Charcode <> VK_TAB then
        inherited;
    end;
     
    procedure TForm1.FormKeyDown(Sender: TObject; var Key:
      Word; Shift: TShiftState);
    begin
      if Key = VK_TAB then
        Form1.Caption := 'Tab Key Down!';
    end;



