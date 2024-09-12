---
Title: Как определить, запущено ли приложение в Windows NT?
Date: 01.01.2007
---

Как определить, запущено ли приложение в Windows NT?
====================================================

Вариант 1:

Source: <https://forum.sources.ru>

Следующий код компилируется как на 16-ти, так и на 32-битных платформах.

    {$IFNDEF WIN32} 
      const WF_WINNT = $4000; 
    {$ENDIF} 
     
    function IsNT : bool; 
    {$IFDEF WIN32} 
    var 
       osv : TOSVERSIONINFO; 
    {$ENDIF} 
    begin 
      result := true; 
    {$IFDEF WIN32} 
      GetVersionEx(osv); 
      if osv.dwPlatformId = VER_PLATFORM_WIN32_NT then exit; 
    {$ELSE} 
       if ((GetWinFlags and WF_WINNT) = WF_WINNT ) then exit; 
    {$ENDIF} 
      result := false; 
    end; 
     
    procedure TForm1.Button1Click(Sender: TObject); 
    begin 
      if IsNt then 
        ShowMessage('Running on NT') 
      else 
        ShowMessage('Not Running on NT'); 
    end;


------------------------------------------------------------------------

Вариант 2:

Source: <https://blackman.wp-club.net/>

    function IsNT: bool;
    var osv: TOSVERSIONINFO;
    begin result := true;
      GetVersionEx(osv);
      if osv.dwPlatformId = VER_PLATFORM_WIN32_NT then exit;
      result := false;
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      if IsNt then
        ShowMessage('Running on NT')
      else
        ShowMessage('Not Running on NT');

