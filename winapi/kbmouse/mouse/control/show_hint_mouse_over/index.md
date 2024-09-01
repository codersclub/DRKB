---
Title: Как заставить появиться окошко подсказки, когда курсор мышки находится над определенным контролом?
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Как заставить появиться окошко подсказки, когда курсор мышки находится над определенным контролом?
==================================================================================================

    var  hintWnd: THintWindow; 
     
    procedure TForm1.ActivateHintNOW( x,y: Integer); 
    var rect: TRect; 
    begin 
      HintTxt := 'qq'; 
      if hintTxt <> '' then 
      begin 
        rect := hintWnd.CalcHintRect( Screen.Width, hinttxt, nil); 
        rect.Left := rect.Left + x; 
        rect.Right := rect.Right + x; 
        rect.Top := rect.Top + y; 
        rect.Bottom := rect.Bottom + y; 
        hintWnd.ActivateHint( rect, hinttxt); 
      end; 
    end; 

**Замечание:**
Не забудьте каждый раз создавать hintWnd:

    hintwnd:= THintWindow.create(self);

а затем освобождать его

     hintwnd.releasehandle;

