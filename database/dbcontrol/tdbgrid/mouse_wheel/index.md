---
Title: Как заставить корректно работать колесо мыши в TDBGrid?
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Как заставить корректно работать колесо мыши в TDBGrid?
=======================================================

    {....}
     
    public
      procedure AppMessage(var Msg: TMsg; var Handled: Boolean);
     
    {....}
     
     
     
    procedure TForm1.AppMessage(var Msg: TMsg; var Handled: Boolean);
    var
      i: SmallInt;
    begin
      {Mouse wheel behaves strangely with dgbgrids - this proc sorts this out}
      if Msg.message = WM_MOUSEWHEEL then
      begin
        Msg.message := WM_KEYDOWN;
        Msg.lParam := 0;
        i := HiWord(Msg.wParam);
        if i > 0 then
          Msg.wParam := VK_UP
        else
          Msg.wParam := VK_DOWN;
     
        Handled := False;
      end;
    end;
     
      // And in the project source:
     
    {....}
     
    Application.OnMessage := Form1.AppMessage;
     
    {....}

