---
Title: Как с помощью API поместить Label на Form?
Author: Baa
Date: 01.01.2007
---


Как с помощью API поместить Label на Form?
==========================================

::: {.date}
01.01.2007
:::

    var 
    hLabel : HWND ;
    ...
    hLabel := CreateWindow ( 'STATIC', 'test', WS_CHILD or WS_VISIBLE, 0, 0, 200, 40, hWnd, NULL, hInstance, NULL ); 

Автор: Baa

Примечание: Vit

Скорее всего последний параметр не \"NULL\", а \"Nil\" (NULL в паскале -
варианта для обозначения пустого поля в базе данных)

Взято с Vingrad.ru <https://forum.vingrad.ru>

------------------------------------------------------------------------

    program Project1;

     
    uses
    Windows,
    Messages;
    const
    myClassName= 'myWindow';
    var
    handleWnd, Label1 : THandle;
    WndClass: TWndClass;
    Msg: TMsg;
    function WindowProc(Window: HWnd; AMessage, WParam,
    LParam: Longint): Longint; stdcall;
    begin
    WindowProc:= DefWindowProc(Window, AMessage, WParam, LParam);
    case AMessage of
    {WM_COMMAND: if lParam = Button1 then
    MessageBox( 0, 'Вы нажали кнопку!', 'Информация',
    MB_OK or MB_ICONINFORMATION); }
    WM_DESTROY: Halt;
    end;
    end;
    begin
    with WndClass do
    begin
    hInstance := hInstance;
    lpszClassName:= myClassName;
    style := cs_hRedraw or cs_vRedraw;
    hbrBackground:= color_btnface +1;
    lpfnWndProc := @WindowProc;
    hCursor := LoadCursor(0, idc_Arrow);
    hIcon := LoadIcon(0, IDI_EXCLAMATION);
    lpszMenuName := NIL;
    cbWndExtra := 0;
    cbClsExtra := 0;
    end;
    RegisterClass( WndClass );
    handleWnd:= CreateWindow(myClassName, 'Hажми кнопку', ws_OverlappedWindow,
    400, 300, 200, 100, 0, 0, hInstance, NIL);
    if handleWnd = 0 then
    begin
    MessageBox( 0, 'Error', NIL, MB_OK );
    Exit;
    end;
    Label1:= CreateWindow( 'Label', 'Text',
    WS_VISIBLE or WS_CHILD or WM_SETTEXT,
    20, 10, 60, 23, handleWnd, 0, hInstance, nil);
    ShowWindow(handleWnd, SW_SHOW);
    UpdateWindow(handleWnd);
    while GetMessage(Msg, handleWnd, 0, 0) do
    begin
    TranslateMessage(Msg) ;
    DispatchMessage(Msg) ;
    end;
    end.

Автор: alex-co

Взято с Vingrad.ru <https://forum.vingrad.ru>
