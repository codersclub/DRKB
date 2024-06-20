---
Title: Показать код HTML страницы в TMemo
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Показать код HTML страницы в TMemo
==================================

    // You need a TMemo, a TButton and a NMHTTP
    procedure TForm1.Button1Click(Sender: TObject); 
    begin 
      NMHTTP1.Get('www.swissdelphicenter.ch'); 
      memo1.Text := NMHTTP1.Body 
    end;

