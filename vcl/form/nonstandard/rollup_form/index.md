---
Title: Как сделать roll-up форму?
Date: 01.01.2007
Source: Delphi Knowledge Base: <https://www.baltsoft.com/>
---


Как сделать roll-up форму?
==========================

    unit testmain;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
      ExtCtrls, StdCtrls, Buttons, ShellAPI;
     
    type
      TForm1 = class(TForm)
        procedure FormCreate(Sender: TObject);
      private
        { Private declarations }
        FOldHeight: Integer;
        procedure WMNCRButtonDown(var Msg: TWMNCRButtonDown);
          message WM_NCRBUTTONDOWN;
      public
        { Public declarations }
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.DFM}
     
    procedure TForm1.FormCreate(Sender: TObject);
    begin
      FOldHeight := ClientHeight;
    end;
     
    procedure TForm1.WMNCRButtonDown(var Msg: TWMNCRButtonDown);
    var
      I: Integer;
    begin
      if (Msg.HitTest = HTCAPTION) then
        if (ClientHeight = 0) then
        begin
          I := 0;
          while (I < FOldHeight) do
          begin
            I := I + 40;
            if (I > FOldHeight) then
              I := FOldHeight;
            ClientHeight := I;
            Application.ProcessMessages;
          end;
        end
        else
        begin
          FOldHeight := ClientHeight;
          I := ClientHeight;
          while (I > 0) do
          begin
            I := I - 40;
            if (I < 0) then
              I := 0;
            ClientHeight := I;
            Application.ProcessMessages;
          end;
        end;
    end;
     
    end.

First, by way of synopsis, the roll-up/down occurs in response to a
WM\_NCRBUTTONDOWN message firing off and the WMNCRButtonDown procedure
handling the message, telling the window to roll up/down depending upon
the height of the client area. WM\_NCRBUTTONDOWN fires whenever the
right mouse button is clicked in a "non-client" area, such as a
border, menu or, for our purposes, the caption bar of a form. (The
client area of a window is the area within the border where most of the
interesting activity usually occurs. In general, the Windows API
restricts application code to drawing only within the client area.)

Delphi encapsulates the WM\_NCRBUTTONDOWN in a TWMNCRButtonDown type,
which is actually an assignment from a TWMNCHitMessage type that has the
following structure:

    type
      TWMNCHitMessage = record
        Msg: Cardinal;
        HitTest: Integer;
        XCursor: SmallInt;
        YCursor: SmallInt;
        Result: Longint;
      end;

It\'s easy to create message wrappers in Delphi to deal with messages
that aren\'t handled by an object by default. Since a right-click on the
title bar of a form isn\'t handled by default, I had to create a
wrapper. The procedure procedure WMNCRButtonDown(var Msg :
TWMNCRButtonDown); message WM\_NCRBUTTONDOWN; is the wrapper I created.
All that goes on in the procedure is the following:

In order to make this work, I had to create a variable called FOldHeight
and set its value at FormCreate whenever the form was to be rolled up.
FOldHeight is used as a place for the form to remember what size it was
before it was re-sized to 0. When a form is to be rolled up, FOldHeight
is immediately set to the current ClientHeight, which means you can
interactively set the form\'s size, and the function will always return
the form\'s ClientHeight to what it was before you rolled it up.

So what use is this? Well, sometimes I don\'t want to iconize a window;
I just want to get it out of the way so I can see what\'s underneath.
Having the capability to roll a form up to its title bar makes it a lot
easier to see underneath a window without iconizing it, then having to
Alt-tab back to it. (If you are familiar with the Macintosh platform,
the System 7.5 environment offers a very similar facility called a
"window shade," and makes a roll-up sound when the shade goes up.)

