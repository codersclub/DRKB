---
Title: SetFocus в Edit на OnExit
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


SetFocus в Edit на OnExit
=========================

Я пробую выполнить editbox.SetFocus и/или editbox.Clear, но но это не
дает никакого эффекта (по крайней мере видимого). Что я делаю
неправильно?

Вы посылаете команду на изменение фокуса внутри обработчика, который сам
устанавливает фокус, этим вы получаете банальную рекурсию.

Я избегаю этого путем отправления собственного сообщения в обработчике
OnExit, после чего в обработчике моего сообщения выставляю логический
флажок, предохраняющий код от рекурсии, поскольку данный флажок
контролируется в обработчике OnExit.

Следующие строки содержат необходимый код:

    interface
    ........
    const
      WM_MyExitRtn = WM_USER + 1001;
      ........
      type
      TForm1 = class(TForm)
        .........
        private
        bExitInProgress: Boolean; {предохраняемся от рекурсий сообщений}
      public
        procedure WMMyExitRtn(var msg: TMessage); message WM_MyExitRtn;
      end;
      .........
      implementation
    .........
     
    procedure TForm1.DBEdit1Exit(Sender: TObject);
    begin
      if not bExitInProgress then
        PostMessage(Handle, WM_MyExitRtn, 0, LongInt(Sender));
    end;
    .........
     
    procedure TForm1.WMMyExitRtn(var msg: TMessage);
    begin
      bExitInProgress := True; { предохраняемся от рекурсивного вызова }
      {здесь содержится необходимый код }
      bExitInProgress := False; { сбрасываем флаг }
    end;



