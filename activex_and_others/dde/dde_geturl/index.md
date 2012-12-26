---
Title: DDE для захвата текущего URL из окна Internet Explorer или Netscape Navigator
Date: 01.01.2007
---


DDE для захвата текущего URL из окна Internet Explorer или Netscape Navigator
=============================================================================

::: {.date}
01.01.2007
:::

    uses
      windows, ddeman, ...
     
     
    function Get_URL(Servicio: string): string;
    var
      Cliente_DDE: TDDEClientConv;
      temp: PChar;      //<<-------------------------This is new
    begin
      Result := '';
      Cliente_DDE:= TDDEClientConv.Create( nil );
      with Cliente_DDE do
      begin
        SetLink( Servicio,'WWW_GetWindowInfo');
        temp := RequestData('0xFFFFFFFF');
        Result := StrPas(temp);
        StrDispose(temp);  // <<-- Предотвращаем утечку памяти
        CloseLink;
      end;
      Cliente_DDE.Free;
    end;
     
    procedure TForm1.Button1Click(Sender);
    begin
       showmessage(Get_URL('Netscape'));
    // или
       showmessage(Get_URL('IExplore'));
    end;
