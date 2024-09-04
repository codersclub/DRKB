---
Title: Выключить монитор
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Выключить монитор
=================

Для того, чтобы перевести монитор в режим Stand by:

    procedure TForm1.Button3Click(Sender: TObject);
    begin
      MessageDlg('Уже поздно. Будь послушным мальчиком. '+
        'Туши свет и вали спать!', mtInformatoion, [mbOk], 0);
      SendMessage(Application.Handle, WM_SYSCOMMAND, SC_MONITORPOWER, 0);
    end;


Для того, чтобы программно снова включить монитор можете использовать следующий код: 

    procedure TForm1.Button3Click(Sender: TObject);
    begin
      SendMessage(Application.Handle, WM_SYSCOMMAND, SC_MONITORPOWER, -1);
    end;

