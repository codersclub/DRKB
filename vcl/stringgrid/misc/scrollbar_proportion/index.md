---
Title: Пропорциональное отображение в TScrollBar или TStringGrid
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch>
---


Пропорциональное отображение в TScrollBar или TStringGrid
=========================================================

    // Getting a TScrollbar control to Show a proportional thumb: 
     
    procedure TForm1.Button1Click(Sender: TObject);
    var
      info: TScrollInfo;
    begin
      FillChar(info, SizeOf(info), 0);
      with info do
      begin
        cbsize := SizeOf(info);
        fmask  := SIF_PAGE;
        nPage  := ScrollBar1.LargeChange;
      end;
      SetScrollInfo(ScrollBar1.Handle, SB_CTL, info, True);
    end;
    
    // Same for a TStringGrid 
     
    procedure TForm1.Button1Click(Sender: TObject);
    var
      info: TScrollInfo;
    begin
      FillChar(info, SizeOf(info), 0);
      with info do
      begin
        cbsize := SizeOf(info);
        fmask  := SIF_ALL;
        GetScrollInfo(StringGrid1.Handle, SB_VERT, info);
        fmask := fmask or SIF_PAGE;
        nPage := 5 * (nmax - nmin) div StringGrid1.RowCount;
        // whatever number of cells you consider a "page" 
      end;
      SetScrollInfo(StringGrid1.Handle, SB_VERT, info, True);
    end;

