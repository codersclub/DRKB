---
Title: Не работает кнопка \<Enter\> в WebBrowser
Author: Song
Date: 01.01.2007
---


Не работает кнопка \<Enter\> в WebBrowser
=========================================

::: {.date}
01.01.2007
:::

Html страницы, отображаемые в TWebBrowser часто имеют кнопки \"Submit\",
и нажатие \<Enter\> не воспринимается непосредственно этой кнопкой.

    unit Unit1;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Variants, Classes, Graphics, Controls, Forms,
      Dialogs, OleCtrls, SHDocVw_TLB, ActiveX, StdCtrls;
     
    type
      TForm1 = class(TForm)
        WebBrowser1: TWebBrowser;
        Button1: TButton;
        Button2: TButton;
        procedure FormDestroy(Sender: TObject);
        procedure FormCreate(Sender: TObject);
        procedure Button1Click(Sender: TObject);
        procedure Button2Click(Sender: TObject);
      private
        { Private declarations }
        FOleInPlaceActiveObject: IOleInPlaceActiveObject;
        procedure MsgHandler(var Msg: TMsg; var Handled: Boolean);
      public
        { Public declarations }
      end;
     
    var
      Form1: TForm1;
     
     
    implementation
     
    {$R *.dfm}
     
    procedure TForm1.FormDestroy(Sender: TObject);
    begin
      FOleInPlaceActiveObject := nil;
    end;
     
    procedure TForm1.FormCreate(Sender: TObject);
    begin
      Application.OnMessage := MsgHandler;
    end;
     
    procedure TForm1.MsgHandler(var Msg: TMsg; var Handled: Boolean);
    var
      iOIPAO: IOleInPlaceActiveObject;
      Dispatch: IDispatch;
    begin
      if not Assigned(WebBrowser1) then
      begin
        Handled := False;
        Exit;
      end;
     
      Handled := (IsDialogMessage(WebBrowser1.Handle, Msg) = True);
     
      if (Handled) and (not WebBrowser1.Busy) then
      begin
        if FOleInPlaceActiveObject = nil then
        begin
          Dispatch := WebBrowser1.Application;
          if Dispatch <> nil then
          begin
            Dispatch.QueryInterface(IOleInPlaceActiveObject, iOIPAO);
            if iOIPAO <> nil then
              FOleInPlaceActiveObject := iOIPAO;
          end;
        end;
     
        if FOleInPlaceActiveObject <> nil then
          if ((Msg.message = WM_KEYDOWN) or (Msg.message = WM_KEYUP)) and
            ((Msg.wParam = VK_BACK) or (Msg.wParam = VK_LEFT) or (Msg.wParam = VK_RIGHT)) then
            //nothing - do not pass on Backspace, Left or Right arrows
          else
            FOleInPlaceActiveObject.TranslateAccelerator(Msg);
      end;
    end;

Автор: Song

Взято из <https://forum.sources.ru>
