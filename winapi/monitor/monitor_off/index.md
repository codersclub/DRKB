---
Title: Выключить монитор
Date: 01.01.2007
---


Выключить монитор
=================

::: {.date}
01.01.2007
:::

    procedure TForm1.Button3Click(Sender: TObject);
    begin
      MessageDlg('Уже поздно. Будь послушным мальчиком. '+
      'Туши свет и вали спать!', mtInformatoion, [mbOk], 0);
      SendMessage(Application.Handle, WM_SYSCOMMAND, SC_MONITORPOWER, 0);
    end;
     
     
     
     
    Для того, чтобы программно включить монитор можете использовать следующий код: 
     
     
     
    procedure TForm1.Button3Click(Sender: TObject);
    begin
      SendMessage(Application.Handle, WM_SYSCOMMAND, SC_MONITORPOWER, -1);
    end;

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
