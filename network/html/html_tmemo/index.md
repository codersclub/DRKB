---
Title: Показать код HTML страницы в TMemo
Date: 01.01.2007
---


Показать код HTML страницы в TMemo
==================================

::: {.date}
01.01.2007
:::

    // You need a TMemo, a TButton and a NMHTTP
    procedure TForm1.Button1Click(Sender: TObject); 
    begin 
      NMHTTP1.Get('www.swissdelphicenter.ch'); 
      memo1.Text := NMHTTP1.Body 
    end;

Взято с сайта <https://www.swissdelphicenter.ch/en/tipsindex.php>
