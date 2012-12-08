---
Title: Проблема потери фокуса для TEdit
Date: 01.01.2007
---


Проблема потери фокуса для TEdit
================================

::: {.date}
01.01.2007
:::

To Reproduce the Problem:

1\. Drop two TEdits onto a form.

2\. In the OnExit Event of Edit1 add the following code:

    Application.MessageBox( 'Title','...', mb_ok );

3\. Run the application.

4\. First select Edit1 then Edit2

5\. The Message box is shown.

Click the OK button, and the Caret has dissapeared!

6\. How to handle this:

     procedure TForm1.Edit1Exit(Sender: TObject);
     begin
      Application.MessageBox('qq','qq',mb_ok);
      if Assigned(ActiveControl) then
        PostMessage(ActiveControl.Handle,WM_SETFOCUS,0,0);
     end;

Взято с сайта: <https://www.swissdelphicenter.ch>
