---
Title: Анимированная кнопка «Пуск»
Author: I MD.CIPTAYASA
Date: 01.01.2007
Source: <https://forum.sources.ru>
---

Анимированная кнопка «Пуск»
===========================

Итак, если Вам надоело привычное статическое изображение кнопки
"Пуск", то предлагаю немного оживить её :) Надеюсь, что это доставит
Вам удовольствие.

    unit Main; 
     
    interface 
     
    uses 
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs, 
      StdCtrls, ExtCtrls,ShellAPI; 
     
    const 
      MAX_BUFFER = 6; 
     
    type 
      TForm1 = class(TForm) 
        Button1: TButton; 
        Timer1: TTimer; 
        Button2: TButton; 
        Image1: TImage; 
        Edit1: TEdit; 
        Label1: TLabel; 
        Label2: TLabel; 
        Label3: TLabel; 
        Button3: TButton; 
        procedure FormCreate(Sender: TObject); 
        procedure Button1Click(Sender: TObject); 
        procedure FormDestroy(Sender: TObject); 
        procedure Timer1Timer(Sender: TObject); 
        procedure Button2Click(Sender: TObject); 
        procedure Edit1KeyPress(Sender: TObject; var Key: Char); 
        procedure FormClose(Sender: TObject; var Action: TCloseAction); 
        procedure Button3Click(Sender: TObject); 
      private 
        HW : HWND; 
        DC : HDC; 
        R  : TRect; 
        FNumber : integer; 
        Buffer : array[1..MAX_BUFFER] of TBitmap; 
        TrayIcon : TNotifyIconData; 
        procedure CreateFrames; 
        procedure DestroyFrames; 
        procedure BuildFrames; 
        procedure NotifyIcon(var Msg : TMessage);message WM_USER + 100; 
        procedure OnMinimizeEvt(Sender : TObject); 
      end; 
     
    var 
      Form1: TForm1; 
     
    implementation 
     
    uses Math; 
    {$R *.DFM} 
     
    // Создаём буфер для спрайтов 
    procedure TForm1.CreateFrames; 
    var 
    i : integer; 
    begin 
      for i:=1 to MAX_BUFFER do 
       begin 
         Buffer[i] := TBitmap.Create; 
         Buffer[i].Height := R.Bottom-R.Top; 
         Buffer[i].Width  := R.Right-R.Left; 
         Buffer[i].Canvas.Brush.Color := clBtnFace; 
         Buffer[i].Canvas.Pen.Color := clBtnFace; 
         Buffer[i].Canvas.Rectangle(0,0,Buffer[i].Width,Buffer[i].Height); 
       end; 
    end; 
     
    procedure TForm1.DestroyFrames; 
    var 
    i : integer; 
    begin 
      for i:=1 to MAX_BUFFER do 
       begin 
         Buffer[i].Destroy; 
       end; 
    end; 
     
    // Подготавливает сегменты/спрайты для анимации 
    procedure TForm1.BuildFrames; 
    var 
    i,j,k,H,W : integer; 
    Y : double; 
    begin 
    H := R.Bottom-R.Top; 
    W := R.Right-R.Left; 
    Image1.Width := W; 
    Image1.Height:= H; 
    for i := 1 to MAX_BUFFER-1 do //Буфер[MAX_BUFFER] используется для хранения оригинального битмапа 
      for j:= 1 to W do 
       for k:=1 to H do 
        begin 
         Y := 2*Sin((j*360/W)*(pi/180)-20*i); 
         Buffer[i].Canvas.Pixels[j,k-Round(Y)]:= Buffer[6].Canvas.Pixels[j,k]; 
        end; 
    end; 
     
    procedure TForm1.OnMinimizeEvt(Sender : TObject); 
    begin 
      ShowWindow(Application.Handle,SW_HIDE); 
    end; 
     
    procedure TForm1.FormCreate(Sender: TObject); 
    begin 
      HW := FindWindowEx(FindWindow('Shell_TrayWnd',nil),0,'Button',nil); 
      GetWindowRect(HW,R); 
      DC := GetWindowDC(HW); 
      CreateFrames; 
      FNumber :=1; 
      TrayIcon.cbSize := SizeOf(TrayIcon); 
      TrayIcon.Wnd := Form1.Handle; 
      TrayIcon.uID := 100; 
      TrayIcon.uFlags := NIF_MESSAGE + NIF_ICON + NIF_TIP; 
      TrayIcon.uCallbackMessage := WM_USER + 100; 
      TrayIcon.hIcon := Application.Icon.Handle; 
      Shell_NotifyIcon(NIM_ADD,@TrayIcon); 
      Application.OnMinimize := OnMinimizeEvt; 
    end; 
     
    // Уведомляем обработчик 
    procedure TForm1.NotifyIcon(var Msg : TMessage); 
    begin 
      case Msg.LParam of 
       WM_LBUTTONDBLCLK : 
        begin 
          ShowWindow(Application.Handle,SW_SHOW); 
          Application.Restore; 
        end; 
      end; 
    end; 
     
    procedure TForm1.Button1Click(Sender: TObject); 
    begin 
      //Получаем изображение оригинальной кнопки, чтобы потом использовать его
      //когда анимация завершится
      BitBlt(Buffer[MAX_BUFFER].Canvas.Handle,0,0,R.Right-R.Left,R.Bottom-R.Top, 
             DC,0,0,SRCCOPY); 
      BuildFrames; 
      Image1.Canvas.Draw(0,0,Buffer[MAX_BUFFER]); 
      Button2.Enabled := true; 
      if Edit1.Text <> '' then 
       Timer1.Interval := StrToInt(Edit1.Text) 
      else 
       begin 
        Timer1.Interval := 100; 
        Edit1.Text := '100'; 
       end; 
    end; 
     
    // Освобождение ресурсов 
    procedure TForm1.FormDestroy(Sender: TObject); 
    begin 
      Timer1.Enabled := false; 
      BitBlt(DC,0,0,R.Right-R.Left,R.Bottom-R.Top, 
             Buffer[MAX_BUFFER].Canvas.Handle,0,0,SRCCOPY); 
      ReleaseDC(HW,DC); 
      DestroyFrames; // не забудьте сделать это !!!
      Shell_NotifyIcon(NIM_DELETE,@TrayIcon); 
    end; 
     
    // Анимация начинается здесь
    procedure TForm1.Timer1Timer(Sender: TObject); 
    begin 
      BitBlt(DC,0,0,R.Right-R.Left,R.Bottom-R.Top, 
             Buffer[FNumber].Canvas.Handle,0,0,SRCCOPY); 
      Inc(FNumber); 
      if (FNumber > MAX_BUFFER-1) then FNumber := 1; 
    end; 
     
    procedure TForm1.Button2Click(Sender: TObject); 
    begin 
      Timer1.Enabled := not Timer1.Enabled; 
      if not Timer1.Enabled then 
       begin 
         BitBlt(DC,0,0,R.Right-R.Left,R.Bottom-R.Top, 
             Buffer[MAX_BUFFER].Canvas.Handle,0,0,SRCCOPY); 
         Button2.Caption := '&Animate'; 
         Button1.Enabled := true; 
       end 
      else 
       begin 
         Button2.Caption := '&Stop'; 
         Button1.Enabled := false; 
       end; 
    end; 
     
    // Обеспечиваем ввод числовых значений
    procedure TForm1.Edit1KeyPress(Sender: TObject; var Key: Char); 
    begin 
      if not (Key in ['0'..'9']) and (Key <> Chr(VK_BACK)) then 
       Key := #0; 
    end; 
     
    procedure TForm1.FormClose(Sender: TObject; var Action: TCloseAction); 
    begin 
      Action := caNone; 
      Application.Minimize; 
    end; 
     
    procedure TForm1.Button3Click(Sender: TObject); 
    begin 
      PostMessage(Form1.Handle,WM_DESTROY,0,0); 
      Application.Terminate; 
    end; 
     
    end.

