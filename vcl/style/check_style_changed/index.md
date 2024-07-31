---
Title: Как получить сообщение об изменении стиля?
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Как получить сообщение об изменении стиля?
==========================================

    const
      WM_THEMECHANGED = $031A;
     
    type
      TForm1 = class(TForm)
        {...}
      private
      public
        procedure WMTHEMECHANGED(var Msg: TMessage); message WM_THEMECHANGED;
      end;
     
    {...}
     
    implementation
     
    {...}
     
    procedure TForm1.WMTHEMECHANGED(var Msg: TMessage);
    begin
      Label1.Caption := 'Theme changed';
      Msg.Result := 0;
    end;

