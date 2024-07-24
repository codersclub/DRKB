---
Title: Как изменить оконную процедуру для TForm?
Date: 01.01.2007
---


Как изменить оконную процедуру для TForm?
=========================================

Переопределите в подклассе TForm оконную процедуру WinProc класса. В
примере оконная процедура переопределяется для того чтобы реагировать на
сообщение WM\_CANCELMODE, показывающее, что выполняется messagebox или
какой-либо еще диалог.

    type
      TForm1 = class(TForm)
        Button1: TButton;
        procedure WndProc(var Message: TMessage); override;
        procedure Button1Click(Sender: TObject);
      private
      {Private declarations}
      public
      {Public declarations}
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.DFM}
     
    procedure TForm1.WndProc(var Message: TMessage);
    begin
      if Message.Msg = WM_CANCELMODE then
        begin
          Form1.Caption := 'A dialog or message box has popped up';
        end
      else
        inherited // <- остальное сделает родительская процедура
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      ShowMessage('Test Message');
    end;
