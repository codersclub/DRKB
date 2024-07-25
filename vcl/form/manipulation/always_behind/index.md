---
Title: Как заставить форму находиться всегда позади всех окон?
Author: antonn
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Как заставить форму находиться всегда позади всех окон?
=======================================================

    type
      TForm1 = class(TForm)
        procedure WndProc (var message: TMessage); override;
      private
        { Private declarations }
      public
        { Public declarations }
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.dfm}
     
    procedure TForm1.WndProc (var message: TMessage);
    begin
      case message.Msg of                         
         WM_WINDOWPOSCHANGING: PWindowPos(Message.LParam)^.hwndInsertAfter:=HWND_BOTTOM;
      end;
       inherited;
    end;

