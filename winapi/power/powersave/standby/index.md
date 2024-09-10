---
Title: Как перевести монитор в режим stand by?
Author: Kecvin S. Gallagher
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Как перевести монитор в режим stand by?
=======================================

Если монитор поддерживает режим Stand by, то его можно программно
перевести в этот режим. Данная возможность доступна на Windows95 и выше.

Чтобы перевести монитор в режим Stand by:

    SendMessage(Application.Handle, wm_SysCommand, SC_MonitorPower, 0) ; 

Чтобы вывести его из этого режима:

    SendMessage(Application.Handle, wm_SysCommand, SC_MonitorPower, -1) ;

А теперь более полный пример кода:

На новую форму поместите кнопку, таймер и ListBox.

    Timer (use Object Inspector):
     
    Enabled := False
    Interval := 15000 

Добавьте следующее событие таймеру:

    procedure TForm1.Timer1Timer(Sender: TObject);
    begin
      ListBox1.Items.Add(FormatDateTime('h:mm:ss AM/PM',Time)) ;
      SendMessage(Application.Handle, wm_SysCommand, SC_MonitorPower, -1);
    end;

Command Button:

    procedure TForm1.Button1Click(Sender: TObject);
    begin
      ListBox1.Items.Add('--> ' + FormatDateTime('h:mm:ss AM/PM',Time)) ;
      Timer1.Enabled := not Timer1.Enabled ;
      SendMessage(Application.Handle, wm_SysCommand, SC_MonitorPower, 0) ;
    end;

После запуска откомпилированного приложения и нажатия на кнопку, экран
погаснет на 15 секунд.

**ЗАМЕЧАНИЕ:**
Удостоверьтесь, что во первых компьютер поддерживает режимы
энергосбережения, а вовторых, эти функции не запрещены на данном
компьютере.

