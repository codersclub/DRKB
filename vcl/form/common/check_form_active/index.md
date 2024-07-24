---
Title: Как узнать, форма активна или нет?
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Как узнать, форма активна или нет?
==================================

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

