---
Title: Как сделать форму без Caption?
Author: Song
Date: 01.01.2007
---


Как сделать форму без Caption?
==============================

::: {.date}
01.01.2007
:::

Обычная форма:

    TForm.Style:=bsNone 

Автор: Song

Взято с Vingrad.ru <https://forum.vingrad.ru>

------------------------------------------------------------------------

MDIChild форма:

    setWindowLong (handle,GWL_STYLE,getWindowLong(handle, GWL_STYLE) and not WS_CAPTION);
    width:=width+1;
    width:=width-1;

Автор: rhf

Взято с Vingrad.ru <https://forum.vingrad.ru>

------------------------------------------------------------------------

    { Private Declaration } 
    procedure CreateParams(var Params : TCreateParams); override; 
     
    ... 
     
    procedure TForm1.CreateParams(var Params : TCreateParams); 
     
    begin 
    inherited Createparams(Params); 
    with Params do 
    Style := (Style or WS_POPUP) and not WS_DLGFRAME; 
    end;

Взято из <https://forum.sources.ru>

------------------------------------------------------------------------

    procedure TForm1.HideTitlebar; 
    var 
      Style: Longint; 
    begin 
      if BorderStyle = bsNone then Exit; 
      Style := GetWindowLong(Handle, GWL_STYLE); 
      if (Style and WS_CAPTION) = WS_CAPTION then 
      begin 
        case BorderStyle of 
          bsSingle, 
          bsSizeable: SetWindowLong(Handle, GWL_STYLE, Style and 
              (not (WS_CAPTION)) or WS_BORDER); 
          bsDialog: SetWindowLong(Handle, GWL_STYLE, Style and 
              (not (WS_CAPTION)) or DS_MODALFRAME or WS_DLGFRAME); 
        end; 
        Height := Height - GetSystemMetrics(SM_CYCAPTION); 
        Refresh; 
      end; 
    end; 
     
    procedure TForm1.ShowTitlebar; 
    var 
      Style: Longint; 
    begin 
      if BorderStyle = bsNone then Exit; 
      Style := GetWindowLong(Handle, GWL_STYLE); 
      if (Style and WS_CAPTION) <> WS_CAPTION then 
      begin 
        case BorderStyle of 
          bsSingle, 
          bsSizeable: SetWindowLong(Handle, GWL_STYLE, Style or WS_CAPTION or 
              WS_BORDER); 
          bsDialog: SetWindowLong(Handle, GWL_STYLE, 
              Style or WS_CAPTION or DS_MODALFRAME or WS_DLGFRAME); 
        end; 
        Height := Height + GetSystemMetrics(SM_CYCAPTION); 
        Refresh; 
      end; 
    end; 
     
    procedure TForm1.Button1Click(Sender: TObject); 
    begin 
      HideTitlebar; 
    end; 
     
    procedure TForm1.Button2Click(Sender: TObject); 
    begin 
      ShowTitlebar; 
    end;

Взято с <https://delphiworld.narod.ru>
