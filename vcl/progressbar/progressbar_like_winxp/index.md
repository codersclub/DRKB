---
Title: Как сделать TProgressBar таким же, как на заставке Windows XP
Date: 01.01.2007
---


Как сделать TProgressBar таким же, как на заставке Windows XP
=============================================================

Вариант 1:

Author: Rrader

Source: Vingrad.ru <https://forum.vingrad.ru>

    unit Unit1;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms,
      Dialogs, XPMan, ComCtrls, StdCtrls;
     
    type
      TForm1 = class(TForm)
        Button1: TButton;
        ProgressBar1: TProgressBar;
        Button2: TButton;
        procedure Button1Click(Sender: TObject);
        procedure Button2Click(Sender: TObject);
      private
        { Private declarations }
      public
        { Public declarations }
      end;
     
    var
      Form1: TForm1;
     
    const
      PBS_MARQUEE = $08;
      PBM_SETMARQUEE = WM_USER + 10;
     
    implementation
     
    {$R *.dfm}
     
    procedure TForm1.Button1Click(Sender: TObject);
    var
      FSpeed: Integer;
    begin
      FSpeed := 100;
      SetWindowLong(ProgressBar1.Handle, GWL_STYLE,
        GetWindowLong(ProgressBar1.Handle, GWL_STYLE) Or PBS_MARQUEE);
      { Включить }
      SendMessage(ProgressBar1.Handle, PBM_SETMARQUEE, 1, FSpeed);
    end;
     
    procedure TForm1.Button2Click(Sender: TObject);
    begin
      { Выключить }
      SendMessage(ProgressBar1.Handle, PBM_SETMARQUEE, 0, 0);
    end;
     
    end.


------------------------------------------------------------------------

Вариант 2:

Source: <https://www.swissdelphicenter.ch>

    { 
      Use this ProgressBar when you do not know the amount of progress toward 
      completion but wish to indicate that progress is being made. 
     
      This ProgressBar works only on Windows XP and the ComCtl32.dll version 
      6.00 or later is needed. To use the new ComCtrl you have to provide the manifest. 
      In Delphi 7 just drop TXPManifest on the form. For prior versions of Delphi 
      you have to include the XP manifest resource. 
    }
     
     unit MarqueeProgressBar;
     
     interface
     
     uses
       SysUtils, Windows, Classes, Controls, ComCtrls, Messages;
     
     type
       TMarqueeProgressBar = class(TProgressBar)
       private
         FActive: Boolean;
         FAnimationSpeed: Integer;
         procedure SetActive(const Value: Boolean);
         procedure SetAnimationSpeed(const Value: Integer);
         procedure UpdateProgressBar;
       protected
         procedure CreateParams(var Params: TCreateParams); override;
       public
         constructor Create(AOwner: TComponent); override;
       published
         property Active: Boolean read FActive write SetActive;
         property AnimationSpeed: Integer read FAnimationSpeed write SetAnimationSpeed;
       end;
     
     const
       PBS_MARQUEE  = $08;
       PBM_SETMARQUEE = WM_USER + 10;
     
     procedure Register;
     
     implementation
     
     procedure Register;
     begin
       RegisterComponents('SwissDelphiCenter', [TMarqueeProgressBar]);
     end;
     
     constructor TMarqueeProgressBar.Create(AOwner: TComponent);
     begin
       inherited;
       FAnimationSpeed := 60;
     end;
     
     procedure TMarqueeProgressBar.CreateParams(var Params: TCreateParams);
     begin
       inherited;
       Params.Style := Params.Style or PBS_MARQUEE;
     end;
     
     procedure TMarqueeProgressBar.SetActive(const Value: Boolean);
     begin
       FActive := Value;
       UpdateProgressBar;
     end;
     
     procedure TMarqueeProgressBar.SetAnimationSpeed(const Value: Integer);
     begin
       FAnimationSpeed := Value;
       UpdateProgressBar;
     end;
     
     procedure TMarqueeProgressBar.UpdateProgressBar;
     begin
       if FActive then
         SendMessage(Self.Handle, PBM_SETMARQUEE, 1, FAnimationSpeed)
       else
         SendMessage(Self.Handle, PBM_SETMARQUEE, 0, 0);
     end;
     
     end.

