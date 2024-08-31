---
Title: Как выполнять другую команду по нажатию на кнопку, если зажата клавиша Shift?
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Как выполнять другую команду по нажатию на кнопку, если зажата клавиша Shift?
=============================================================================

    procedure TForm1.Button1Click(Sender: TObject);
    begin
      if GetKeyState(VK_SHIFT) < 0 then
        ShowMessage('Кнопка Shift нажата')
      else
        ShowMessage('Обычное нажатие кнопки');
    end;


