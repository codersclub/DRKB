---
Title: Как узнать, форма активна или нет?
Date: 01.01.2007
---


Как узнать, форма активна или нет?
==================================

::: {.date}
01.01.2007
:::

    type
       //...
      private
        { Private declarations }
        procedure WMNCACTIVATE(var M: TWMNCACTIVATE); message WM_NCACTIVATE;
      end;
     
     
    implementation
     
    //...
     
    procedure TForm1.WMNCACTIVATE(var M: TWMNCACTIVATE);
    begin
      inherited;
      if M.Active then
        caption:='Form active'
      else caption:='Form not active' ;
    end;

Взято с сайта <https://www.swissdelphicenter.ch/en/tipsindex.php>
