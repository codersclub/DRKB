---
Title: Как получить картинку с видео источника?
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Как получить картинку с видео источника?
========================================

Для использования следующиего примера необходимо иметь "Microsoft Video
for Windows SDK". Пример показывает, как открыть видео устройство для
захвата видео, как сграбить фрейм с устройства, как сохранить этот фрейм
на диск в виде файла .BMP, как записать .AVI файл (со звуком, но без
предварительного просмотра), и как закрыть устройство.

Замечание: Для работы примера необходимо иметь установленное устройство
захвата видео (video capture device).

Пример:

    unit Unit1;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms,
       Dialogs, ExtCtrls, StdCtrls;
     
    type
      TForm1 = class(TForm)
        Panel1: TPanel;
        OpenVideo: TButton;
        CloseVideo: TButton;
        GrabFrame: TButton;
        SaveBMP: TButton;
        StartAVI: TButton;
        StopAVI: TButton;
        SaveDialog1: TSaveDialog;
        procedure FormCreate(Sender: TObject);
        procedure OpenVideoClick(Sender: TObject);
        procedure CloseVideoClick(Sender: TObject);
        procedure GrabFrameClick(Sender: TObject);
        procedure SaveBMPClick(Sender: TObject);
        procedure StartAVIClick(Sender: TObject);
        procedure StopAVIClick(Sender: TObject);
      private
        { Private declarations }
        hWndC : THandle;
        CapturingAVI : bool;
      public
        { Public declarations }
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.DFM}
     
    const WM_CAP_START                  = WM_USER;
    const WM_CAP_STOP                   = WM_CAP_START + 68;
    const WM_CAP_DRIVER_CONNECT         = WM_CAP_START + 10;
    const WM_CAP_DRIVER_DISCONNECT      = WM_CAP_START + 11;
    const WM_CAP_SAVEDIB                = WM_CAP_START + 25;
    const WM_CAP_GRAB_FRAME             = WM_CAP_START + 60;
    const WM_CAP_SEQUENCE               = WM_CAP_START + 62;
    const WM_CAP_FILE_SET_CAPTURE_FILEA = WM_CAP_START +  20;
     
    function capCreateCaptureWindowA(lpszWindowName : PCHAR;
                                     dwStyle : longint;
                                     x : integer;
                                     y : integer;
                                     nWidth : integer;
                                     nHeight : integer;
                                     ParentWin  : HWND;
                                     nId : integer): HWND;
                                     STDCALL EXTERNAL 'AVICAP32.DLL';
     
    procedure TForm1.FormCreate(Sender: TObject);
    begin
      CapturingAVI := false;
      hWndC := 0;
      SaveDialog1.Options :=
        [ofHideReadOnly, ofNoChangeDir, ofPathMustExist]
    end;
     
    procedure TForm1.OpenVideoClick(Sender: TObject);
    begin
      hWndC := capCreateCaptureWindowA('My Own Capture Window',
                                       WS_CHILD or WS_VISIBLE,
                                       Panel1.Left,
                                       Panel1.Top,
                                       Panel1.Width,
                                       Panel1.Height,
                                       Form1.Handle,
                                       0);
      if hWndC <> 0 then
        SendMessage(hWndC, WM_CAP_DRIVER_CONNECT, 0, 0);
    end;
     
    procedure TForm1.CloseVideoClick(Sender: TObject);
    begin
      if hWndC <> 0 then begin
        SendMessage(hWndC, WM_CAP_DRIVER_DISCONNECT, 0, 0);
       hWndC := 0;
       end;
    end;
     
    procedure TForm1.GrabFrameClick(Sender: TObject);
    begin
      if hWndC <> 0 then
        SendMessage(hWndC, WM_CAP_GRAB_FRAME, 0, 0);
    end;
     
    procedure TForm1.SaveBMPClick(Sender: TObject);
    begin
      if hWndC <> 0 then begin
        SaveDialog1.DefaultExt := 'bmp';
        SaveDialog1.Filter := 'Bitmap files (*.bmp)|*.bmp';
        if SaveDialog1.Execute then
          SendMessage(hWndC,
                      WM_CAP_SAVEDIB,
                      0,
                      longint(pchar(SaveDialog1.FileName)));
      end;
    end;
     
    procedure TForm1.StartAVIClick(Sender: TObject);
    begin
      if hWndC <> 0 then begin
        SaveDialog1.DefaultExt := 'avi';
        SaveDialog1.Filter := 'AVI files (*.avi)|*.avi';
        if SaveDialog1.Execute then begin
           CapturingAVI := true;
           SendMessage(hWndC,
                       WM_CAP_FILE_SET_CAPTURE_FILEA,
                       0,
                       Longint(pchar(SaveDialog1.FileName)));
           SendMessage(hWndC, WM_CAP_SEQUENCE, 0, 0);
        end;
      end;
    end;
     
    procedure TForm1.StopAVIClick(Sender: TObject);
    begin
      if hWndC <> 0 then begin
        SendMessage(hWndC, WM_CAP_STOP, 0, 0);
        CapturingAVI := false;
      end;
    end;
     
    end.

