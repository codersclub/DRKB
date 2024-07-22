---
Title: Перестроить вкладки TPageControl с помощью Drag & Drop
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Перестроить вкладки TPageControl с помощью Drag & Drop
======================================================

    // In the PageControl's OnMouseDown event handler: 
     
    procedure TForm1.PageControl1MouseDown(Sender: TObject; 
      Button: TMouseButton; Shift: TShiftState; X, Y: Integer); 
    begin 
      PageControl1.BeginDrag(False); 
    end; 
     
     
    // In the PageControl's OnDragDrop event handler: 
     
    procedure TForm1.PageControl1DragDrop(Sender, Source: TObject; X, Y: Integer); 
    const 
      TCM_GETITEMRECT = $130A; 
    var 
      i: Integer; 
      r: TRect; 
    begin 
      if not (Sender is TPageControl) then Exit; 
      with PageControl1 do 
      begin 
        for i := 0 to PageCount - 1 do 
        begin 
          Perform(TCM_GETITEMRECT, i, lParam(@r)); 
          if PtInRect(r, Point(X, Y)) then 
          begin 
            if i <> ActivePage.PageIndex then 
              ActivePage.PageIndex := i; 
            Exit; 
          end; 
        end; 
      end; 
    end; 
     
    // In the PageControl's OnDragOver event handler: 
     
    procedure TForm1.PageControl1DragOver(Sender, Source: TObject; X, 
      Y: Integer; State: TDragState; var Accept: Boolean); 
    begin 
      if Sender is TPageControl then 
        Accept := True; 
    end;

