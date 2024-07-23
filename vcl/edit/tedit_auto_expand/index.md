---
Title: Как автоматически расширить TEdit?
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Как автоматически расширить TEdit?
==================================

Следующий компонент автоматически подстраивается под текст, вводимый в
него:

    unit ExpandingEdit; 
     
    interface 
     
    uses 
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs, 
      StdCtrls; 
     
    type 
      TExpandingEdit = class(TEdit) 
      private 
        FCanvas: TControlCanvas; 
      protected 
        procedure Change; override; 
      public 
        constructor Create(AOwner: TComponent); override; 
        destructor Destroy; override; 
      end; 
     
    procedure Register; 
     
    implementation 
     
    constructor TExpandingEdit.Create(AOwner: TComponent); 
    begin 
      inherited Create(AOwner); 
      FCanvas := TControlCanvas.Create; 
      FCanvas.Control := Self; 
    end; 
     
    destructor TExpandingEdit.Destroy; 
    begin 
      FCanvas.Free; 
      inherited Destroy; 
    end; 
     
    procedure TExpandingEdit.Change; 
    const 
      EditMargin = 8; 
    var 
      W: Integer; 
    begin 
      inherited Change; 
      if not HandleAllocated then Exit; 
      FCanvas.Font := Font; 
      W := FCanvas.TextWidth(Text) + (2 * EditMargin); 
      if (Width < W) then Width := W; 
    end; 
     
    procedure Register; 
    begin 
      RegisterComponents('Samples', [TExpandingEdit]); 
    end; 
     
    end.

