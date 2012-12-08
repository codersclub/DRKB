---
Title: Работа с Netscape Navigator через DDE
Date: 01.01.2007
---


Работа с Netscape Navigator через DDE
=====================================

::: {.date}
01.01.2007
:::

    uses DDEman;
    ...
    procedure GotoURL(sURL: string);
    var
      dde: TDDEClientConv;
    begin
      dde := TDDEClientConv.Create(nil);
      with dde do
      begin
        // specify the location of netscape.exe
        ServiceApplication :='C:\Program Files\Netscape\Communicator\Program\NETSCAPE.EXE';
        // activate the Netscape Navigator
        SetLink( 'Netscape', 'WWW_Activate' );
        RequestData('0xFFFFFFFF');
        // go to the specified URL
        SetLink( 'Netscape', 'WWW_OpenURL' );
        RequestData( sURL+',,0xFFFFFFFF,0x3,,,' );
        // ... CloseLink;
      end;
      dde.Free;
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      GotoURL('http://www.site.ru');
    end;

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
