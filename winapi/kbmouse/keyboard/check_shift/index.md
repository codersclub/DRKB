---
Title: Как выполнять другую команду по нажатию на кнопку, если зажата клавиша Shift?
Date: 01.01.2007
---


Как выполнять другую команду по нажатию на кнопку, если зажата клавиша Shift?
=============================================================================

::: {.date}
01.01.2007
:::

    procedure TForm1.Button1Click(Sender: TObject);
    begin
      if GetKeyState(VK_SHIFT) < 0 then
        ShowMessage('Кнопка Shift нажата')
      else
        ShowMessage('Обычное нажатие кнопки');
    end;

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
