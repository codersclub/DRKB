---
Title: Как перехватить нажатие TAB?
Date: 01.01.2007
---


Как перехватить нажатие TAB?
============================

Вариант 1:

Author: Vit

Source: Vingrad.ru <https://forum.vingrad.ru>

    private
     
    Procedure CMDialogKey(Var Msg: TWMKey); message CM_DIALOGKEY;
    .....
    procedure TForm1.CMDialogKey(var Msg: TWMKey);
    begin
      //здесь Ваш код
      Msg.Result := 0
    end;

------------------------------------------------------------------------

Вариант 2:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>


На уровне формы клавиша tab обычно обрабатывается Windows. В примере
создается обработчик события CM\_Dialog для перехвата Dialog keys

    type
      TForm1 = class(TForm)
      private
        procedure CMDialogKey( var msg: TCMDialogKey );
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
     
    procedure TForm1.FormKeyDown(Sender: TObject;
    var Key: Word; Shift: TShiftState);
    begin
      if Key = VK_TAB then
        Form1.Caption := 'Tab Key Down!';
    end;


------------------------------------------------------------------------

Вариант 3:

Author: Ralph Friedman

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

Единственное место в программе, где можно перехватить нажатие клавиши
tab - в обработчике Application.OnMessages. Пример ниже:

    unit Hndltabu;
     
    interface
     
    uses
      SysUtils, WinTypes, WinProcs, Messages, Classes,
      Graphics, Controls, Forms, Dialogs, StdCtrls;
     
    type
      TForm1 = class(TForm)
        Edit1: TEdit;
        Edit2: TEdit;
        Label1: TLabel;
        procedure FormCreate(Sender: TObject);
      private { Private-Deklarationen }
        procedure AppMessage(var Msg: TMsg; var Handled: Boolean);
      public { Public-Deklarationen }
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.DFM}
     
    procedure TForm1.AppMessage(var Msg: TMsg; var Handled: Boolean);
    const
      shiftPressed: boolean = false;
    begin
      if Msg.Message = WM_KEYDOWN then
        if not shiftPressed and (Msg.wParam = VK_SHIFT) then
        begin
          shiftPressed := true;
          Exit;
        end
        else
        begin
          if Msg.wParam = VK_TAB then
            if ActiveControl = Edit1 then
            begin
              if shiftPressed then
                Label1.Caption := 'BACKTAB!'
              else
                Label1.Caption := 'TAB!';
     
              Handled := true
            end
            else
              Label1.Caption := '';
     
          shiftPressed := false;
        end;
    end;
     
    procedure TForm1.FormCreate(Sender: TObject);
    begin
      Application.OnMessage := AppMessage;
    end;
     
    end.

