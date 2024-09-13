---
Title: Как использовать CreateWindow(Ex)?
Author: lel
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---

Как использовать CreateWindow(Ex)?
==================================

    program winmin;
     
    uses
     windows,
     messages;
    var   wc : TWndClassEx;
    MainWnd : HW   Mesg : TMsg;   
     
    function WindowProc(wnd:HWND; Msg : Integer; Wparam:Wparam;
     Lparam:Lparam):Lresult; stdcall;
    Begin
     case msg of
     wm_destroy :
      Begin
       postquitmessage(0); exit;
       Result:=0;
      End;
      
      else Result:=DefWindowProc(wnd,msg,wparam,lparam);
     end;
     
    End;
    
    var xPos,yPos,nWidth,nHeight : Integer;
    begin
     wc.cbSize:=sizeof(wc);
     wc.style:=cs_hredraw or cs_vredraw;
     wc.lpfnWndProc:=@WindowProc;
     wc.cbClsExtra:=0;
     wc.cbWndExtra:=0;
     wc.hInstance:=HInstance;
     wc.hIcon:=LoadIcon(0,idi_application);
     wc.hCursor:=LoadCursor(0,idc_arrow);
     wc.hbrBackground:=COLOR_BTNFACE+1;
     wc.lpszMenuName:=nil;
     wc.lpszClassName:='WinMin : Main';
      
     RegisterClassEx(wc);
     xPos:=100;
     yPos:=150;
     nWidth:=400;
     nHeight:=250;
      
     MainWnd:=CreateWindowEx(
       0,              
       'WinMin : Main',
       'Win Min',        
       ws_overlappedwindow,
       xPos, 
       yPos,
       nWidth,   
       nHeight,        
       0,               
       0,                  
       Hinstance,          
       nil                 
     );
      
      
     ShowWindow(Mai! nWnd,CmdShow);
     While GetMessage(Mesg,0,0,0) do
     begin
      TranslateMessage(Mesg);
      DispatchMessage(Mesg);
     end;
     
    end.



