---
Title: Как изменить стандартный цвет TProgressBar?
Date: 01.01.2007
---


Как изменить стандартный цвет TProgressBar?
===========================================

Вариант 1:

Source: <https://forum.sources.ru>

Самый простой способ, это изменить цветовую схему в свойствах экрана...

А вот при помощи следующей команды можно разукрасить ProgressBar не
изменяя системных настроек:

    PostMessage(ProgressBar1.Handle, $0409, 0, clGreen); 

Вуаля! Теперь Progress Bar зелёный. Это всего лишь простой пример чёрной
магии ;)


------------------------------------------------------------------------

Вариант 2:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

    uses 
      CommCtrl; 
     
    procedure TForm1.Button1Click(Sender: TObject); 
    begin 
      // Set the Background color to teal 
      Progressbar1.Brush.Color := clTeal; 
      // Set bar color to yellow 
      SendMessage(ProgressBar1.Handle, PBM_SETBARCOLOR, 0, clYellow); 
    end;

